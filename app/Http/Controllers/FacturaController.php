<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Solicitudcompra;
use App\Proveedor;
use App\Factura;
use App\Articulo;
use App\Categoria;
use App\Facturadetalle;
use DB;

class FacturaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:factura.create')->only(['create','store']);
        $this->middleware('can:factura.index')->only('index');
        $this->middleware('can:factura.edit')->only(['edit','update']);
        $this->middleware('can:factura.show')->only('show');
        $this->middleware('can:factura.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $facturas = Factura::with('proveedor','solicitudcompra.entidad')
                /*->whereHas('solicitudcompra', function ($query) use ($id_sucursales){
                    $query->whereIn('sucursal_id',$id_sucursales);
                })*/
                ->whereIn('sucursal_id',$id_sucursales)
                ->where(function ($query) {
                    $query->where('estado', 'ACTIVO');
                })
                ->orderBy('id','desc')
                ->paginate(30);

        return view('factura.index', compact('facturas'));
    }

    public function buscador(Request $request)
    {
        $search = $request->query('search');

        $facturas = Factura::with('proveedor','solicitudcompra.entidad')
                ->where('numerofactura', 'like', '%'.$search.'%')
                ->orwhere('fechafactura', 'like', '%'.$search.'%')
                ->orwhere('montofactura', 'like', '%'.$search.'%')
                ->orWhereHas('solicitudcompra', function ($query) use ($search){
                            $query->where('numerosolicitud', 'like', '%'.$search.'%');
                            })
                ->orWhereHas('solicitudcompra.entidad', function ($query) use ($search){
                            $query->where('nombre', 'like', '%'.$search.'%');
                            })
                ->orWhereHas('proveedor', function ($query) use ($search){
                            $query->where('nit', 'like', '%'.$search.'%');
                            $query->orwhere('razonsocial', 'like', '%'.$search.'%');
                            })
                ->having('estado','ACTIVO')
                ->take(10)
                ->get();

        return view ('factura.lista_facturadetalles',compact('facturas'));
    }

    public function pdfdetallefactura($id)
    {
        $factura = Factura::with(['facturadetalle.articulo','proveedor','solicitudcompra.entidad'])->findOrFail($id);

        $pdf = \PDF::loadview('pdf.comprobantecompra',compact('factura'));
        return $pdf->stream('COMPROBANTE DE COMPRA - '.$factura->solicitudcompra->entidad->nombre.' - '.$factura->solicitudcompra->numerosolicitud.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FacturaFormRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $factura = Factura::findOrFail($id);

        // $articulos=DB::table('articulos')
        // ->join('categorias','articulos.categoria_id','=','categorias.id')
        // ->select('articulos.id','articulos.nombre','articulos.presentacion','categorias.id as codigo_categoria','categorias.nombre as nombre_categoria')
        // ->where('articulos.condicion','=','1')->orderBy('articulos.nombre', 'asc')->get();

        $articulos = Articulo::with('categoria')->where('condicion','=','1')->orderBy('nombre', 'asc')->get();

        $facturadetalles = DB::table('facturadetalles')
        ->join('articulos','articulos.id','=','facturadetalles.articulo_id')
        ->join('categorias','categorias.id','=','articulos.categoria_id')
        ->join('facturas','facturas.id','=','facturadetalles.factura_id')
        ->select('facturadetalles.id','facturadetalles.factura_id','facturadetalles.articulo_id','facturadetalles.cantidadrestante','facturadetalles.preciocompra','facturadetalles.totalbs','facturadetalles.gestion','articulos.nombre as articulo','articulos.presentacion','categorias.nombre as categoria','facturas.numerofactura')
        ->where('facturadetalles.factura_id', $id)
        ->get();

        $sucursales = Auth::user()->sucursales;
        $providers = Proveedor::all();
        return view("factura.edit", compact('factura', 'articulos', 'facturadetalles','sucursales','providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $clientIP =\Request::ip ();

        $factura = Factura::findOrFail($id);
        $factura->numerofactura = $request->numerofactura;
        $factura->fechafactura = $request->fechafactura;
        $factura->proveedor_id = $request->proveedor_id;
        $factura->update();


        try{
            DB::beginTransaction();
            //Elimina detalle de compra.
            $facturadetalle = Facturadetalle::where('factura_id',$id)->delete();
            //DB::table('facturadetalles')->where('factura_id', $id)->delete();

            //registra datos de la tabla facturadetalle
            $cont = 0;
            while ($cont < count($request->articulo_id)) {
                $facturadetalle = new Facturadetalle;
                $facturadetalle->factura_id = $id;
                $facturadetalle->sucursal_id = $request->sucursal_id;
                $facturadetalle->articulo_id = $request->articulo_id[$cont];
                $facturadetalle->cantidadsolicitada = $request->cantidad[$cont];
                $facturadetalle->cantidadrestante = $request->cantidad[$cont];
                $facturadetalle->preciocompra = $request->precio[$cont];
                $facturadetalle->totalbs = $request->totalcompra[$cont];
                $facturadetalle->registro_clientIP = $request->registro_clientIP;
                $facturadetalle->registro_clientIP_update = $clientIP;
                $facturadetalle->gestion = $request->gestion;
                $facturadetalle->created_at = $request->created_at;
                $facturadetalle->user_id = Auth::user()->id;
                $facturadetalle->save();
                $cont++;
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }

        toast('Detalle de compra actualizado con éxito!','success');
        return redirect()->route('factura.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
    public function anular(Request $request, $id) {
        DB::beginTransaction();
        try{

            $factura = Factura::findOrFail($id);

            $factura->estado = 'ELIMINADO';
            $factura->eliminado_por = Auth::user()->email;
            $factura->update();
            $factura->canceled()->create([
            'user_id' => auth()->user()->id,
            'motivo' => $request->motivo
            ]);
            //Anula solicitud de compra.
            $solicitudcompra = Solicitudcompra::where('id',$factura->solicitudcompra_id)->first();
            $solicitudcompra->estado = 'ELIMINADO';
            $solicitudcompra->eliminado_por = Auth::user()->email;
            $solicitudcompra->update();
            $solicitudcompra->canceled()->create([
                'user_id' => auth()->user()->id,
                'motivo' => $request->motivo
                ]);
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
        }

        toast('Factura y solicitud de compra anuladas correctamente!','success');
        return redirect()->route('factura.index');
    }
}
