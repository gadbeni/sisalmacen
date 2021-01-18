<?php

namespace App\Traits;

use DB;
use App\Egreso;
use App\Solicitudcompra;
use Carbon\Carbon;
/*
 * traits para calcular todo tipo de incentarios 
 */
trait Inventory
{
    public function generateinventorytoyear($anio, $sucursal){

        /*$ingresos = Solicitudcompra::select([
                       'fechaingreso','estado'
                   ])->withCount([
                       'factura as ingreso_sum' => function($query) {
                           $query->select(DB::raw('SUM(montofactura)'))
                           ->where('estado', 'ACTIVO');
                       }
                   ])
                   ->where('gestion',$anio)
                   ->where('sucursal_id', $sucursal)
                   ->where('estado', 'ACTIVO')
                   ->get()
                   ->groupBy(function($val) {
                          return Carbon::parse($val->fechaingreso)->format('m');
                   });*/

        $ingresos = DB::table('solicitudcompras as sc')
                        ->join('facturas as fa', 'sc.id', '=', 'fa.solicitudcompra_id')
                        ->join('facturadetalles as fd', 'fa.id', '=', 'fd.factura_id')
                        ->select(
                            DB::raw("DATE_FORMAT(sc.fechaingreso, '%m') as mes"),
                            DB::raw('SUM(fd.cantidadsolicitada * fd.preciocompra) as total')
                        )
                        ->where('sc.gestion', $anio)
                        ->where('sc.sucursal_id', $sucursal)
                        ->where('sc.estado', 'ACTIVO')
                        ->where('fa.estado', 'ACTIVO')
                        ->groupBy(DB::raw("DATE_FORMAT(sc.fechaingreso, '%m')"))
                        ->orderBy('sc.fechaingreso')
                        ->get();
   
       /*$ingresos_aux = collect();
       foreach ($ingresos as $key => $value) {
           $monto = 0;
           foreach ($value as $amount) {
               $monto += $amount->ingreso_sum;
           }
           $ingresos_aux->push(['mes' => $key, 'monto' => $monto]);
       }*/
   
       /*$egresos = Egreso::select([
                       'fechasalida'
                   ])->withCount([
                           'egresodetalle as egreso_sum' => function($query) {
                               $query->select(DB::raw('SUM(totalbs)'))
                               ->where('condicion','!=',0);
                           }
                    ])
                    ->where('gestion',$anio)
                    ->where('sucursal_id', $sucursal)
                   ->get()
                   ->groupBy(function($val) {
                          return Carbon::parse($val->fechasalida)->format('m');
                   });*/

        $egresos = DB::table('egresodetalles as ed')
                       ->join('egresos as eg', 'ed.egreso_id', '=', 'eg.id')
                       ->join('facturadetalles as fd', 'ed.facturadetalle_id', '=', 'fd.id')
                       ->join('facturas as fa', 'fd.factura_id', '=', 'fa.id')
                       ->join('solicitudcompras as sc', 'fa.solicitudcompra_id', '=', 'sc.id')
                       ->select(
                           DB::raw("DATE_FORMAT(eg.fechasalida, '%m') as mes"),
                           'eg.fechasalida', 'ed.facturadetalle_id',
                           DB::raw("sum(COALESCE(ed.cantidad, 0)) * fd.preciocompra as sub_total")
                       )
                       ->where('eg.gestion', $anio)
                       ->where('sc.sucursal_id', $sucursal)
                       ->where('fa.estado', 'ACTIVO')
                       ->where('sc.estado', 'ACTIVO')
                       ->groupBy('eg.fechasalida', 'ed.facturadetalle_id')
                       ->orderBy('eg.fechasalida')
                       ->get()->toArray();


       /*$egresos_aux = collect();
       foreach ($egresos as $key => $value) {
           $monto = 0;
           foreach ($value as $amount) {
               $monto += $amount->egreso_sum;
           }
           $egresos_aux->push(['mes' => $key, 'monto' => $monto]);
       }*/

        $cantEgresos = count($egresos);
        $monto = 0;
        $egresos_aux = collect();
        for ($i = 0; $i < ($cantEgresos - 1); $i++) {
            $next = $i + 1;
            $monto = $monto + $egresos[$i]->sub_total;
            if ($egresos[$next]->mes != $egresos[$i]->mes) {
                $egresos_aux->push(['mes' => $egresos[$i]->mes, 'monto' => $monto]);
                $monto = 0;
            }
        }
        $egresos_aux->push(['mes' => $egresos[$cantEgresos-1]->mes, 'monto' => $monto + $egresos[$cantEgresos-1]->sub_total]);
   
       $reporte = collect();
       $meses = array('', 'ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
       for ($i=1; $i <= 12; $i++) {
           $monto_ingreso = 0;
           $monto_egreso = 0;
            /*foreach ($ingresos_aux as $value) {
                if(intval($value['mes'])==$i){
                   $monto_ingreso = $value['monto'];
                }
            } */

            foreach ($ingresos as $value) {
                if(intval($value->mes)==$i){
                    $monto_ingreso = $value->total;
                }
            }

            foreach ($egresos_aux as $value) {
                if(intval($value['mes'])==$i){
                    $monto_egreso = $value['monto'];
                }
            }
            $reporte->push(['mes' => $meses[$i], 'ingresos' => $monto_ingreso, 'egresos' => $monto_egreso]);
   
       }
       return $reporte;
     }
}
