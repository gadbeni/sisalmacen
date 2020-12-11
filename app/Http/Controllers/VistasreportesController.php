<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Categoria;
use App\Articulo;
use App\Solicitudcompra;
use App\Entidad;
use DB;

class VistasreportesController extends Controller
{
    public function articulostock()
    {
    	$articulostock = Articulo::orderBy('nombre', 'asc')->get();
        $sucursales = Auth::user()->sucursales;

    	return view ('vistasreportes_por_parametros.articulostock',compact('articulostock','sucursales'));
    }

    public function articuloegreso()
    {
    	$articuloegreso = Articulo::with('categoria')->orderBy('nombre', 'asc')->get();
        $sucursales = Auth::user()->sucursales;

    	return view ('vistasreportes_por_parametros.articuloegreso',compact('articuloegreso','sucursales'));
    }

    public function saldocategoria()
    {
    	$categorias = Categoria::orderBy('nombre', 'asc')->get();
        $sucursales = Auth::user()->sucursales;
    	return view ('vistasreportes_por_parametros.saldocategoria',compact('categorias','sucursales'));
    }

    public function lista_proveedores()
    {
        $proveedores = Proveedor::orderBy('razonsocial', 'asc')->get();
        return view ('vistasreportes_por_parametros.proveedores', compact('proveedores'));
    }

    public function egresoarticulo_oficina()
    {
        $direccionadministrativas = DB::table('direccionadministrativas')
                                ->select('id','nombre')
                                ->orderBy('nombre', 'asc')
                                ->where('estado','=', 1)
                                ->get();
        $sucursales = Auth::user()->sucursales;

        return view('vistasreportes_por_parametros.egresoarticulo_oficina',compact('direccionadministrativas','sucursales'));
    }

    public function ingresoarticulo_stock()
    {
        $sucursales = (auth()->user()->hasRole('Admin')) ? \App\Sucursal::all() : Auth::user()->sucursales ;
        //$sucursales = Auth::user()->sucursales;
        return view('vistasreportes_por_parametros.ingresoarticulo_stock',compact('sucursales'));
    }

    public function egresoarticulo_stock()
    {
        $sucursales = Auth::user()->sucursales;
        return view('vistasreportes_por_parametros.egresoarticulo_stock',compact('sucursales'));
    }

    public function articulo_proveedor()
    {
        $proveedors=DB::table('proveedors')
                ->select('id','razonsocial')
                ->where('condicion','=','1')->orderBy('razonsocial', 'asc')->get();

        $sucursales = Auth::user()->sucursales;

        return view('vistasreportes_por_parametros.articulo_proveedor',compact('proveedors','sucursales'));
    }

    public function kardex_articulo()
    {
        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $solicitudescompras = Solicitudcompra::with('entidad')
        ->whereIn('sucursal_id',$id_sucursales)
        ->where(function ($query) {
            $query->where('estado', '<>','ELIMINADO')
                  ->orWhere(function ($q) {
                        $q->whereNull('estado');
                  });
        })
        ->get();

        //$sucursales = Auth::user()->sucursales;

        return view('vistasreportes_por_parametros.kardex_articulo',compact('solicitudescompras','sucursales'));
    }

    public function custominventory() {
         $sucursales = Auth::user()->sucursales;
        return view('vistasreportes_por_parametros.custominventory', compact('sucursales'));
    }

    public function saldoporarticulo() {
        $sucursales = Auth::user()->sucursales;
        return view('vistasreportes_por_parametros.saldo_por_articulo', compact('sucursales'));
    }
}
