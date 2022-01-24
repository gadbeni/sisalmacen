<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SaldoCompra;
use App\Saldocompradetalles;
use DB;
use App\Traits\Inventory;

use Carbon\Carbon;

class SaldocompraController extends Controller
{
    use Inventory;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sentencia = $search ? "(
                        descripcion like '%$search%' or
                        monto like '%$search%' or
                        gestion like '%$search%'
                        )" : 1;

        $saldocompras= \App\SaldoCompra::with('sucursal')

       // ->where('user_id',auth()->user()->id)p
        ->whereRaw($sentencia)
        ->orderBy('id','desc')
        ->paginate();

        return View('saldocompra.index',compact('saldocompras','search'));
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

        return view('saldocompra.create', compact('sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clientIP =\Request::ip ();
        $gestion = Carbon::today()->year;
        $sucursal_actual = SaldoCompra::where('sucursal_id',$request->sucursal_id)
                                        ->where('gestion',$gestion)->first();
        if ($sucursal_actual) {
            toast("ya se hiso un registro para este almacen con esta gestion!",'success');
            return redirect()->back();
        }
        $saldocompra = new SaldoCompra;
        $saldocompra->sucursal_id = $request->sucursal_id;
        $saldocompra->descripcion = $request->descripcion;
        $saldocompra->monto = $request->monto;
        $saldocompra->monto_aux = 0;
        $saldocompra->gestion = $gestion;
        $saldocompra->registro_clientIP = $clientIP;
        $saldocompra->registro_clientIP_update = $clientIP;
        $saldocompra->user_id = Auth::user()->id;
        $saldocompra->save();

        toast('Saldo de inventario registrado con éxito!','success');
        return redirect()->route('saldocompra.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $saldocompra = SaldoCompra::find($id);
        $arreglo = $this->generateinventorytoyear($saldocompra->gestion, $saldocompra->sucursal_id);
        return view('saldocompra.show',compact('saldocompra','arreglo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SaldoCompra $saldocompra)
    {
        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }
       return view('saldocompra.edit',compact('saldocompra','sucursales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,SaldoCompra $saldocompra)
    {
        $clientIP =\Request::ip ();
        $gestion = Carbon::today()->year;
        if ($saldocompra->sucursal_id != $request->sucursal_id) {
            $sucursal_actual = SaldoCompra::where('sucursal_id',$request->sucursal_id)
                                        ->where('gestion',$gestion)->first();
            if ($sucursal_actual) {
                toast("ya se hiso un registro para este almacen con esta gestion!",'error');
                return redirect()->back();
            }
        }
        $saldocompra->sucursal_id = $request->sucursal_id;
        $saldocompra->descripcion = $request->descripcion;
        $saldocompra->monto = $request->monto;
        $saldocompra->registro_clientIP_update = $clientIP;
        $saldocompra->update();
        toast('Saldo de inventario actualizado con éxito!','success');
        return redirect()->route('saldocompra.index');
    }

    public function closeinventorytoyear($id)
    {
        $sucursal_id = request()->get('sucursal');
        $saldocompra = SaldoCompra::find(request()->get('saldo_compra_id'));
        $arreglo = $this->generateinventorytoyear($saldocompra->gestion, $sucursal_id);

        //calculamos el saldo inicial y los totales de ingresos y egresos de la gestion
        $saldo = $saldocompra->monto;
        $totalingresos= $arreglo->sum('ingresos');
        $totalegresos= $arreglo->sum('egresos');
        //recorremos el arreglo para obtener el saldo final de la gestion
        foreach ($arreglo as $value) {
            $saldo+= $value['ingresos'] - $value['egresos'];
        }
        $saldocompra->saldo_final = $saldo;
        $saldocompra->condicion = 0;
        $saldocompra->observation = request()->get('observation');
        $saldocompra->update();
        toast('Saldo de inventario cerrado con éxito!','success');
        return redirect()->route('saldocompra.index');
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
}
