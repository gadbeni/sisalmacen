<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Solicitudcompra;
use App\Proveedor;
use App\Entidad;
use App\Egreso;
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
        return view('factura.index');
    }
    
    public function list(){
        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }
        $data = Factura::with([
                            'proveedor:id,razonsocial,nit',
                            'solicitudcompra:id,numerosolicitud,entidad_id',
                            'solicitudcompra.entidad:id,nombre'
                        ])
                        ->whereIn('sucursal_id',$id_sucursales)
                        ->where(function ($query) {
                            $query->where('estado', 'ACTIVO');
                        })
                        ->select('id','solicitudcompra_id','proveedor_id','numerofactura','montofactura','fechafactura','created_at')
                        ->get();

        return datatables()->of($data)
                            ->addIndexColumn()
                            ->addColumn('entity_nro_purchase', function($row){
                                //return $row->id;
                                return $row->solicitudcompra->entidad->nombre.'-'.$row->solicitudcompra->numerosolicitud;
                            })
                            ->addColumn('provider', function($row){
                                return $row->proveedor->razonsocial.'<br><strong>'.$row->proveedor->nit.'</strong>';
                            })
                            ->addColumn('date_invoice', function($row){
                                return \Carbon\Carbon::parse($row->fechafactura)->format('Y/m/d').'<br> <strong>Monto: '.$row->montofactura.'</strong> Bs.';
                            })
                            ->addColumn('fecha_ingreso', function($row){
                                return date('d/m/Y H:i:s', strtotime($row->created_at)).'<br><small>'.\Carbon\Carbon::parse($row->created_at)->diffForHumans().'</small>';
                            })
                            ->addColumn('action', function($row){
                                $actions = '
                                    <div class="no-sort no-click bread-actions text-right">
                                        <a href="'.route('pdfdetallefactura', ['id' => $row->id]).'" title="Imprimir Detalle de Compra" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fas fa-print"></i> <span class="hidden-xs hidden-sm"></span>
                                        </a>
                                        <a href="'.route('factura.edit',$row->id).'" title="Editar" class="btn btn-sm btn-info view">
                                            <i class="fas fa-edit"></i> <span class="hidden-xs hidden-sm"></span>
                                        </a>
                                        <button title="Anular Factura" class="btn btn-sm btn-danger delete" data-toggle="modal" data-target="#modal-delete" onclick="deleteItem('."'".url("anularfactura/".$row->id)."'".')">
                                            <i class="fas fa-trash"></i> <span class="hidden-xs hidden-sm"></span>
                                        </button>
                                    </div>
                                        ';
                                return $actions;
                            })
                            ->rawColumns(['entity_nro_purchase', 'provider','fecha_ingreso','date_invoice','action'])
                            ->make(true);
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
        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $factura = Factura::findOrFail($id);
        $entidades = Entidad::whereIn('sucursal_id',$id_sucursales)
                            ->where('condicion','=','1')
                            ->orderBy('nombre', 'desc')->get();
        $solicitud = Solicitudcompra::find($factura->solicitudcompra_id,['id','entidad_id','numerosolicitud','fechaingreso']);
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
        return view("factura.edit", compact('factura', 'articulos', 'facturadetalles','sucursales','providers','solicitud','entidades'));
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
        DB::beginTransaction();
        try{
            $factura = Factura::findOrFail($id);
            $factura->numerofactura = $request->numerofactura;
            $factura->fechafactura = $request->fechafactura;
            $factura->proveedor_id = $request->proveedor_id;
            $factura->update();

            //actualizamos la solicitud de compra
            $solicitud = Solicitudcompra::findOrFail($factura->solicitudcompra_id);
            $solicitud->entidad_id = $request->entidad_id;
            $solicitud->numerosolicitud = $request->numerosolicitud;
            $solicitud->fechaingreso = $request->fechaingreso;
            $solicitud->update();
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
    public function anular(Request $request, $id) 
    {
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
    public function unsuscriberequest(Request $request, $id) {
        $factura = Factura::findOrFail($id);
        $solicitudcompra = Solicitudcompra::where('id',$factura->solicitudcompra_id)->first();
        DB::beginTransaction();
        try {
        $egresos_id = DB::table('egresodetalles as ed')
                        ->where('solicitudcompra_id', $solicitudcompra->id)
                        ->select('ed.egreso_id','ed.facturadetalle_id','ed.cantidad')
                        ->groupBy('ed.egreso_id')
                        ->get();

        foreach ($egresos_id as $egre) {
            $facturadetalle = Facturadetalle::where('id',$egre->facturadetalle_id)->first();
            $facturadetalle->cantidadrestante = $facturadetalle->cantidadrestante + floatVal($egre->cantidad);
            $facturadetalle->save();
            $scPorEgreso = DB::table('egresodetalles')
                                ->where('egreso_id', $egre->egreso_id)
                                ->select('solicitudcompra_id')
                                ->groupBy('solicitudcompra_id')
                                ->get()->count();
           
            if ($scPorEgreso === 1) {
                //anular egreso
                $egreso = Egreso::where('id',$egre->egreso_id)->first();
                $egreso->canceled()->create([
                    'user_id' => auth()->user()->id,
                    'motivo' => $request->motivo
                     ]);
                $egreso->condicion = 0;
                $egreso->update();
            } 
        }

        $solicitudcompra->canceled()->create([
            'user_id' => auth()->user()->id,
            'motivo' => $request->motivo
            ]);

        $solicitudcompra->estado = 'INACTIVO';
        $solicitudcompra->save();

        $factura->canceled()->create([
            'user_id' => auth()->user()->id,
            'motivo' => $request->motivo
            ]);
        $factura->estado = 'INACTIVO';
        $factura->save();
        DB::commit();
        toast('Solicitud de compra + Factura enulada con éxito');
        return redirect()->route('factura.index');
        }catch(\Exception $e){
          DB::rollback();
         return $e->getMessage();
        }
        
    }
}
