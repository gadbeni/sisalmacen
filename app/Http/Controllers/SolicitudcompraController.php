<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Solicitudcompra;
use App\Articulo;
use App\Categoria;
use App\Egresodetalle;
use App\Egreso;
use App\Factura;
use App\Proveedor;
use App\Facturadetalle;
use App\Entidad;
use Carbon\Carbon;
use DB;

class SolicitudcompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:solicitudcompra.create')->only(['create','store']);
        $this->middleware('can:solicitudcompra.index')->only('index');
        $this->middleware('can:solicitudcompra.edit')->only(['edit','update']);
        $this->middleware('can:solicitudcompra.show')->only('show');
        $this->middleware('can:solicitudcompra.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sentencia = $search ? "(
                        entidades.nombre like '%$search%' or
                        solcomp.numerosolicitud like '%$search%' or
                        solcomp.fechaingreso like '%$search%'
                        )" : 1;

        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $solicitudcompras=DB::table('solicitudcompras as solcomp')
        ->join('entidades','entidades.id','=','solcomp.entidad_id')
        ->select('solcomp.id','entidades.nombre as entidad','solcomp.numerosolicitud','solcomp.condicion','solcomp.fechaingreso')
        ->where('solcomp.condicion','=','1')
        ->where('solcomp.estado', 'ACTIVO')
        ->whereIn('solcomp.sucursal_id',$id_sucursales)
        ->whereRaw($sentencia)
        ->orderBy('solcomp.id','desc')
        ->paginate();

        return View('solicitudcompra.index',compact('solicitudcompras','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $entidades=Entidad::whereIn('sucursal_id',$id_sucursales)
        ->where('condicion','=','1')
        ->orderBy('nombre', 'desc')->get();

        $proveedors = Proveedor::where('condicion','=','1')->orderBy('razonsocial', 'asc')->get();

        $articulos = Articulo::with('categoria')->where('condicion','=','1')->orderBy('nombre', 'asc')->get();

        return view('solicitudcompra.create', compact('sucursales','entidades','proveedors','articulos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request);
        //captura el año - gestion
        $date = Carbon::now();
        $gestion = $date->format('Y');

        //capyura ip del usuario
        $clientIP =\Request::ip ();
        //DB::beginTransaction();
        try{
            DB::beginTransaction();
            //registra datos de la tabla solicitudcompra
            $solicitudcompra = new Solicitudcompra;
            $solicitudcompra->sucursal_id = $request->sucursal_id;
            $solicitudcompra->entidad_id = $request->entidad_id;
            $solicitudcompra->numerosolicitud = $request->numerosolicitud;
            $solicitudcompra->fechaingreso = $request->fechaingreso;
            $solicitudcompra->registro_clientIP = $clientIP;
            $solicitudcompra->registro_clientIP_update = $clientIP;
            $solicitudcompra->gestion = $gestion;
            $solicitudcompra->user_id = Auth::user()->id;
            $solicitudcompra->save();

            //registra datos de la tabla factura
            $factura = new Factura;
            $factura->sucursal_id = $request->sucursal_id;
            $factura->solicitudcompra_id = $solicitudcompra->id;
            $factura->proveedor_id = $request->idproveedor_input;
            $factura->numerofactura = $request->numerofactura;
            $factura->fechafactura = $request->fechafactura;
            $factura->montofactura = $request->montofactura;
            $factura->registro_clientIP = $clientIP;
            $factura->registro_clientIP_update = $clientIP;
            $factura->gestion = $gestion;
            $factura->user_id = Auth::user()->id;
            $factura->save();

            //registra datos de la tabla facturadetalle
            $cont = 0;
            while ($cont < count($request->articulo_id)) {
                $facturadetalle = new Facturadetalle;
                $facturadetalle->sucursal_id = $request->sucursal_id;
                $facturadetalle->factura_id = $factura->id;
                $facturadetalle->articulo_id = $request->articulo_id[$cont];
                $facturadetalle->cantidadsolicitada = $request->cantidad[$cont];
                $facturadetalle->cantidadrestante = $request->cantidad[$cont];
                $facturadetalle->preciocompra = $request->precio[$cont];
                $facturadetalle->totalbs = $request->totalbs[$cont];
                $facturadetalle->registro_clientIP = $clientIP;
                $facturadetalle->registro_clientIP_update = $clientIP;
                $facturadetalle->gestion = $gestion;
                $facturadetalle->user_id = Auth::user()->id;
                $facturadetalle->save();
                $cont++;
            }

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
        }

        toast('Solicitud de compra registrada con éxito!','success');
        return redirect()->route('factura.index');

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
        $solicitudcompra = Solicitudcompra::findOrFail($id);
        return view("solicitudcompra.edit",compact('solicitudcompra'));
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
        $clientIP =\Request::ip ();

        $solicitudcompra = Solicitudcompra::findOrFail($id);
        $solicitudcompra->numerosolicitud = $request->numerosolicitud;
        $solicitudcompra->fechaingreso = $request->fechaingreso;
        $solicitudcompra->registro_clientIP_update = $clientIP;
        $solicitudcompra->update();

        toast('Solicitud de compra actualizada con éxito!','success');
        return redirect()->route('solicitudcompra.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function solicitudesresumen_v()
    {
        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $entidades = Entidad::whereIn('sucursal_id',$id_sucursales)->get();
        $sucursales = Auth::user()->sucursales;
        return view ('vistasreportes_por_parametros.solicitudcompras_resumen',compact('entidades','sucursales'));
    }
    public function solicitudesresumen_r(Request $request)
    {
        //dd($request);
        //$sentencia_entidad_id = $request->entidad_id ? "id=".$request->entidad_id : 1;
        $sucursal_id = $request->sucursal_id;
        $entidad_id = $request->entidad_id;
        $fechainicio = $request->fechainicio;
        $fechafin = $request->fechafin;

        // $entidades = DB::table('entidades')->select('id','nombre')
        //         ->whereRaw($sentencia_entidad_id)
        //         ->get();

        // $indice = 0;
        // foreach ($entidades as $entidad)
        // {
        //     $aux = DB::table('solicitudcompras as solcomp')
        //             ->join('facturas','facturas.solicitudcompra_id','=','solcomp.id')
        //             ->select('solcomp.numerosolicitud','solcomp.fechaingreso','facturas.montofactura')
        //             ->whereBetween('solcomp.fechaingreso',array($fechainicio,$fechafin))
        //             ->where('solcomp.entidad_id',$entidad->id)
        //             //->where('s.user_id',auth()->user()->id)
        //             ->where('solcomp.sucursal_id',$sucursal_id)
        //             ->orderBy('solcomp.fechaingreso', 'asc')
        //             ->get();

        //     $entidades[$indice]->solicitudcompras = $aux;
        //     $indice++;
        // }
        $entidad = Entidad::find($entidad_id);
        $entidades = Solicitudcompra::with('entidad','factura.proveedor')
                ->where('entidad_id',$entidad->id)
                //->whereRaw($sentencia_entidad_id)
                ->whereBetween('fechaingreso',array($fechainicio,$fechafin))
                ->where('sucursal_id',$sucursal_id)
                ->where('estado', 'ACTIVO')
                ->orderBy('fechaingreso', 'asc')
                ->get();

        //return $entidades;

        $pdf = \PDF::loadview('pdf.solicitudcompras_resumen',compact('entidades','entidad'));
        return $pdf->stream('RESUMEN SOLICITUDES DE COMPRAS - '.date('d-m-Y').'.pdf');
    }

    public function unsuscriberequest(Request $request, $id) {
        DB::beginTransaction();
        try {
        $egresos_id = DB::table('egresodetalles as ed')
                        ->where('solicitudcompra_id', $id)
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
            // else {
            //     $egresodetalle = Egresodetalle::where('id',$egre->id)->first();
            //     $egresodetalle->cantidad = 0;
            //     $egresodetalle->totalbs = 0;
            //     $egresodetalle->save();
            // }
        }

        $solicitudcompra = Solicitudcompra::find($id);
       
        $solicitudcompra->canceled()->create([
            'user_id' => auth()->user()->id,
            'motivo' => $request->motivo
            ]);

        $solicitudcompra->estado = 'INACTIVO';
        $solicitudcompra->save();

        $factura = Factura::where('solicitudcompra_id',$id)->first();
        $factura->canceled()->create([
            'user_id' => auth()->user()->id,
            'motivo' => $request->motivo
            ]);
        $factura->estado = 'INACTIVO';
        $factura->save();
        DB::commit();
        toast('Solicitud de compra enulada con éxito');
        return redirect()->route('solicitudcompra.index');
        }catch(\Exception $e){
          DB::rollback();
         return $e->getMessage();
        }
        
    }
}
