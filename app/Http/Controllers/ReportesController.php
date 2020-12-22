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
        //dd($request);
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
                ->where('estado','!=','ELIMINADO')
                ->get();

        $solicitudescompras = Solicitudcompra::with('factura.facturadetalle.articulo.categoria')
                ->where('id',$entidad_id)
                ->where('estado','!=','ELIMINADO')
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

    public function displayreportoinventory(Request $request){
        $sucursal = $request->sucursal_id;
        $modelo   = $request->entidad;
        $tiporeporte = $request->tipo_reporte;
        $f_inicio = $request->inicio;
        $f_fin    = $request->fin;
        $anio = Carbon::today()->year;
        $saldoinicial = SaldoCompra::select('monto','gestion')
                         ->where('gestion',$anio)
                         ->where('sucursal_id',$sucursal) 
                         ->first();
        switch ($modelo) {
            case 'yearsumary':
                 if ($tiporeporte == "currentyear") {
                    $reporte= $this->generateinventorytoyear($anio, $sucursal);
                    $pdf = \PDF::loadview('pdf.inventario_anual',compact('saldoinicial','reporte','anio'));
                    return $pdf->stream('INVENTARIO ANUAL.pdf');
                 }

                break;

            case 'solicitudes':

              break;

            default:
                # code...
                break;
        }

    }

}
