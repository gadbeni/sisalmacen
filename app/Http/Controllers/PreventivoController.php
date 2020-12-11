<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Proyecto;
use App\Partida;
use App\Solicitudcompra;
use App\Preventivo;
use DB;

class PreventivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:preventivo.create')->only(['create','store']);
        $this->middleware('can:preventivo.index')->only('index');
        $this->middleware('can:preventivo.edit')->only(['edit','update']);
        $this->middleware('can:preventivo.show')->only('show');
        $this->middleware('can:preventivo.destroy')->only('destroy');
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
                        solcomp.numerosolicitud like '%$search%'or
                        preventivos.numeropreventivo like '%$search%'
                        )" : 1;

        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $preventivos = DB::table('solicitudcompras as solcomp')
                ->join('entidades','entidades.id','=','solcomp.entidad_id')
                ->join('preventivos','preventivos.solicitudcompra_id','=','solcomp.id')
                ->select(DB::raw('CONCAT(entidades.nombre, " - ", solcomp.numerosolicitud) AS solicitudcompra'),'solcomp.id','preventivos.numeropreventivo')
                ->whereIn('solcomp.sucursal_id',$id_sucursales)
                ->where('solcomp.condicionegreso','=',0)
                ->where('preventivos.estado', '<>','ELIMINADO')
                ->whereRaw($sentencia)
                ->groupBy('solcomp.id')
                ->paginate();

        $indice = 0;

        foreach ($preventivos as $preventivo) {
            $aux = DB::table('preventivos')
                         ->select('id','numeropreventivo')
                         ->where('solicitudcompra_id', $preventivo->id)
                         ->orderBy('id', 'desc')
                         ->get();
            $preventivos[$indice]->preventivodetalle = $aux;
            $indice++;
        }

        return view('preventivo.index',compact('preventivos','search'));
    }

    public function pdfpreventivo($id)
    {
        $solcomp_preventivo = Solicitudcompra::with(['entidad','preventivo.proyecto.direccionadministrativa','preventivo.proyecto.unidadadministrativa','preventivo.partida','factura'])->findOrFail($id);

        $pdf = \PDF::loadview('pdf.preventivo', compact('solcomp_preventivo'));
        return $pdf->stream('ACTA PREVENTIVO DE - '.$solcomp_preventivo->entidad->nombre.' - '.$solcomp_preventivo->numerosolicitud.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $solicitudcompras = DB::table('solicitudcompras')
                        ->join('entidades','entidades.id','=','solicitudcompras.entidad_id')
                        ->join('facturas','facturas.solicitudcompra_id','=','solicitudcompras.id')
                        ->select(DB::raw('CONCAT(entidades.nombre, " - ", solicitudcompras.numerosolicitud) AS solicitudcompra'),'solicitudcompras.id','facturas.id as id_factura','facturas.montofactura')
                        ->where('solicitudcompras.user_id',auth()->user()->id)
                        ->where('condicionegreso','=','1')
                        ->orderBy('solicitudcompras.id', 'desc')
                        ->get();
                        //dd($solicitudcompras);

        $sucursales1 = Auth::user()->sucursales;
        foreach ($sucursales1 as $key => $value) {
           $id_sucursales[] = $value->id;
        }


        $proyectos = DB::table('proyectos')
                ->join('direccionadministrativas as da','proyectos.direccionadministrativa_id','=','da.id')
                ->join('unidadadministrativas as ua','proyectos.unidadadministrativa_id','=','ua.id')
                ->select(DB::raw('CONCAT(proyectos.codigo, " - ", proyectos.nombre) AS proyecto'),'proyectos.id',DB::raw('CONCAT(da.codigo, " - ", da.nombre) AS direccionadministrativa'),DB::raw('CONCAT(ua.codigo, " - ", ua.nombre) AS unidadejecutora'))
                //->where('proyectos.user_id',auth()->user()->id)
                //->where('proyectos.condicion','=','1')
                ->whereIn('proyectos.sucursal_id',$id_sucursales)
                ->orderBy('proyectos.id', 'asc')
                ->get();

        $partidas = DB::table('partidas')
                ->select(DB::raw('CONCAT(codigo, " - ",nombre) AS partida'),'id')
                ->where('condicion','=','1')
                ->orderBy('nombre','asc')
                ->get();

        $sucursales = Auth::user()->sucursales;

        return view("preventivo.create",compact('solicitudcompras','proyectos','partidas','sucursales'));
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
        $clientIP =\Request::ip();

        try{
            DB::beginTransaction();
            //registra datos de la tabla preventivos
            for ($i=0; $i<count($request->proyecto_id); $i++) {

                $preventivo = new Preventivo;
                $preventivo->sucursal_id = $request->sucursal_id;
                $preventivo->numeropreventivo = $request->numeropreventivo[$i];
                $preventivo->solicitudcompra_id = $request->solicitudcompra_id[$i];
                $preventivo->proyecto_id = $request->proyecto_id[$i];
                $preventivo->partida_id = $request->partida_id[$i];
                $preventivo->monto = $request->monto[$i];
                $preventivo->registro_clientIP = $clientIP;
                $preventivo->registro_clientIP_update = $clientIP;
                $preventivo->user_id = Auth::user()->id;
                $preventivo->save();

                //cambia estado condicion a la tabla solicitudcompras->condicionegreso=0
                $solicitudcompra = Solicitudcompra::findOrFail($preventivo->solicitudcompra_id);
                $solicitudcompra->condicionegreso = '0';
                $solicitudcompra->update();
            }

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
        }

        toast('Preventivo registrado con éxito!','success');
        return redirect()->route('preventivo.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $solicitudcompra = Solicitudcompra::findOrFail($id);
        $solicitudcompra->condicionegreso = '1';
        $solicitudcompra->update();

        //Eliminando detalle de preventivos.
        //$preventivo = Preventivo::where('solicitudcompra_id',$solicitudcompra->id)->delete();
        $preventivo = Preventivo::where('solicitudcompra_id',$solicitudcompra->id)->first();
        $preventivo->estado = 'ELIMINADO';
        $preventivo->eliminado_por = Auth::user()->email;
        $preventivo->update();

        toast('preventivo eliminado con éxito!','warning');
        return redirect()->route('preventivo.index');
    }
}
