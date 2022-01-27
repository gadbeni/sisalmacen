<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Saldocompra;
use App\Meses;
use App\Saldocompradetalles;

class SaldocompradetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Saldocompra $saldocompra)
    {
        $meses = Meses::all();
        return view('saldocompradetalle.create',compact('saldocompra','meses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Saldocompra $saldocompra)
    {
        // return $request;
        $clientIP =\Request::ip ();

        //Monto ingreso por mes - Variable
        $var_ingreso = $request->ingreso;

        //Monto Egreso por mes - Variable
        $var_egreso = $request->egreso;
        //Monto aux - Saldo de Inventario
        $total_monto_aux = $saldocompra->monto_aux;

        //Suma de monto aux + ingreso - egreso
        $calcular_ingreso_egreso = $var_ingreso + $total_monto_aux - $var_egreso;

        $saldocompradetalle = new Saldocompradetalles();
        $saldocompradetalle->mes_id = $request->mes_id;
        $saldocompradetalle->ingreso = $request->ingreso;
        $saldocompradetalle->egreso = $request->egreso;
        $saldocompradetalle->saldo = $calcular_ingreso_egreso;
        $saldocompradetalle->registro_clientIP = $clientIP;
        $saldocompradetalle->registro_clientIP_update = $clientIP;
        $saldocompradetalle->saldocompra_id = $saldocompra->id;
        $saldocompradetalle->user_id = Auth::user()->id;
        $saldocompradetalle->save();

        $saldocompra = Saldocompra::findOrFail($saldocompradetalle->saldocompra_id);
        $saldocompra->monto_aux = $calcular_ingreso_egreso;
        $saldocompra->update();

        return redirect()->route('saldocompra.show', $saldocompra);
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
        //
    }
}
