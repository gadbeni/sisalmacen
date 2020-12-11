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

        $ingresos = Solicitudcompra::select([
                       'fechaingreso'
                   ])->withCount([
                       'factura as ingreso_sum' => function($query) {
                           $query->select(DB::raw('SUM(montofactura)'));
                       }
                   ])
                   ->where('gestion',$anio)
                   ->where(function ($query) {
                       $query->where('solicitudcompras.estado', '<>','ELIMINADO')
                             ->orWhere(function ($q) {
                                   $q->whereNull('solicitudcompras.estado');
                             });
                   })
                   ->where('sucursal_id', $sucursal)
                   ->get()
                   ->groupBy(function($val) {
                          return Carbon::parse($val->fechaingreso)->format('m');
                   });
   
       $ingresos_aux = collect();
       foreach ($ingresos as $key => $value) {
           $monto = 0;
           foreach ($value as $amount) {
               $monto += $amount->ingreso_sum;
           }
           $ingresos_aux->push(['mes' => $key, 'monto' => $monto]);
       }
   
       $egresos = Egreso::select([
                       'fechasalida'
                   ])->withCount([
                           'egresodetalle as egreso_sum' => function($query) {
                               $query->select(DB::raw('SUM(totalbs)'));
                           }
                    ])
                    ->where('gestion',$anio)
                    ->where('sucursal_id', $sucursal)
                   ->get()
                   ->groupBy(function($val) {
                          return Carbon::parse($val->fechasalida)->format('m');
                   });
       $egresos_aux = collect();
       foreach ($egresos as $key => $value) {
           $monto = 0;
           foreach ($value as $amount) {
               $monto += $amount->egreso_sum;
           }
           $egresos_aux->push(['mes' => $key, 'monto' => $monto]);
       }
   
       $reporte = collect();
       $meses = array('', 'ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
       for ($i=1; $i <= 12; $i++) {
           $monto_ingreso = 0;
           $monto_egreso = 0;
           foreach ($ingresos_aux as $value) {
               if(intval($value['mes'])==$i){
                   $monto_ingreso = $value['monto'];
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
