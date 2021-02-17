<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Egreso;
use App\Solicitudcompra;
use App\SaldoCompra;
use App\Egresodetalle;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
//use Dompdf\Options;
use App\Traits\Inventory;

class ReportesController extends Controller
{
    use Inventory;
    
    public function egresoarticulo_oficina(Request $request)
    {
        $sucursal_id = $request->sucursal_id;
        $fechainicio = $request->fechainicio;
        $fechafin = $request->fechafin;
        $direccionadministrativa_id = $request->direccionadministrativa_id;
        $unidadadministrativa_id = $request->unidadadministrativa_id;

        $oficinas = Egreso::with('direccionadministrativa','unidadadministrativa','egresodetalle.solicitudcompra.preventivo','egresodetalle.facturadetalle.articulo.categoria')
                ->orderBy(DB::raw('DATE_FORMAT(fechasalida, "%Y-%m-%d")'),'asc')
                ->whereHas('direccionadministrativa', function ($query) use ($direccionadministrativa_id){
                            $query->where('id',$direccionadministrativa_id);
                            })
                ->whereHas('unidadadministrativa', function ($query) use ($unidadadministrativa_id){
                            $query->where('id',$unidadadministrativa_id);
                            })
                ->where('sucursal_id',$sucursal_id)
                ->where('condicion','!=',0)
                ->whereBetween(DB::raw('DATE_FORMAT(fechasalida, "%Y-%m-%d")'),array($fechainicio,$fechafin))
                ->get();

        $pdf = \PDF::loadview('pdf.egresoarticulo_oficina', compact('oficinas'))->setPaper('A4','landscape');
        return $pdf->stream('EGRESO ARTICULO POR OFICINA.pdf');

    }

    public function kardex_articulo(Request $request)
    {
        $sucursal_id = $request->sucursal_id;
        $entidad_id = $request->entidad_id;

        $solcomp_factura = Solicitudcompra::with('entidad','factura')
                ->where('id',$entidad_id)
                ->where('estado', 'ACTIVO')
                ->get();

        $solicitudescompras = Solicitudcompra::with('factura.facturadetalle.articulo.categoria')
                ->where('id',$entidad_id)
                ->where('estado', 'ACTIVO')
                ->where('sucursal_id',$sucursal_id)
                ->get();

        $egresodetalles = Egresodetalle::with('solicitudcompra','facturadetalle.articulo','egreso')
            ->whereHas('solicitudcompra', function ($query) use ($entidad_id){
                $query->where('id',$entidad_id);
            })
            ->whereHas('egreso', function ($query){
                $query->where('condicion','!=',0);
            })
            ->where('sucursal_id',$sucursal_id)
            ->get();

        $pdf = \PDF::loadview('pdf.kardex_articulo', compact('solicitudescompras','solcomp_factura','egresodetalles'))->setPaper('A4','landscape');

        return $pdf->stream('KARDEX DE ARTICULO.pdf');
    }

    public function displayreportoinventory(Request $request)
    {
        $sucursal = $request->sucursal_id;
        $modelo   = $request->entidad;
        $tiporeporte = $request->tipo_reporte;
        $f_inicio = $request->inicio;
        $f_fin    = $request->fin;
        //$anio = Carbon::today()->year;
        
        if (isset($request->year)) {
            $year = $request->year;
            $saldoinicial = SaldoCompra::select('monto','gestion')
                         ->where('gestion',$year)
                         ->where('sucursal_id',$sucursal) 
                         ->first();
            $reporte= $this->generateinventorytoyear($year, $sucursal);
            $pdf = \PDF::loadview('pdf.inventario_anual',compact('saldoinicial','reporte','year'));
            return $pdf->stream('INVENTARIO ANUAL.pdf');
        }else {
            return "no envio anio";
        }
        
        switch ($modelo) {
            case 'yearsumary':
                break;

            case 'solicitudes':

              break;

            default:
                # code...
                break;
        }

    }

    public function dependencies_by_secretaries(Request $request){
        if ($request->direccion_id == 'all') {
           $direcciones = $this->generate_all_dependency_to_secretaries($request->sucursal_id);
           $pdf = \PDF::loadview('pdf.all_dependency_to_secretary',compact('direcciones'));
           return $pdf->stream('dependencias.pdf');
        }
        $direccionesadm = \App\Direccionadministrativa::findOrFail($request->direccion_id);
        $unidades = DB::table('unidadadministrativas as ua')
                        ->select('ua.codigo','ua.nombre')
                        ->join('egresos as eg','eg.unidadadministrativa_id','=','ua.id')
                        ->where('ua.direccionadministrativa_id',$direccionesadm->id)
                        ->where('eg.sucursal_id',$request->sucursal_id)
                        ->groupBy('ua.id')
                        ->get();
        
        $pdf = \PDF::loadview('pdf.dependporsecretaria',compact('direccionesadm','unidades'));
        return $pdf->stream('dependencias.pdf');
    }

    static function generate_all_dependency_to_secretaries($sucursalid){
        $direccionesadm = \App\Direccionadministrativa::select('direccionadministrativas.id','direccionadministrativas.codigo','direccionadministrativas.nombre')
                                                        ->join('egresos as eg','eg.direccionadministrativa_id','=','direccionadministrativas.id')
                                                        ->where('eg.sucursal_id',$sucursalid)
                                                        ->groupBy('direccionadministrativas.id')
                                                        ->get();
        $indice = 0;
        foreach ($direccionesadm as $dir)
        {
            $aux = DB::table('unidadadministrativas as ua')
                        ->select('ua.codigo','ua.nombre')
                        ->join('egresos as eg','eg.unidadadministrativa_id','=','ua.id')
                        ->where('ua.direccionadministrativa_id',$dir->id)
                        ->where('eg.sucursal_id',$sucursalid)
                        ->groupBy('ua.id')
                        ->get();

            $direccionesadm[$indice]->unidades = $aux;
            $indice++;
        }
        return $direccionesadm;
    }
}
