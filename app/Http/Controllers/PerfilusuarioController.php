<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Perfil;
use DB;

class PerfilusuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfils = Perfil::where('user_id',auth()->user()->id)->get();
        return view('perfilusuario.index', compact('perfils'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perfilusuario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $perfil = new Perfil;
        $perfil->nombre = $request->nombre;
        $perfil->apaterno = $request->apaterno;
        $perfil->amaterno = $request->amaterno;
        $perfil->ci = $request->ci;
        $perfil->telefono = $request->telefono;
        $perfil->direccion = $request->direccion;
        $perfil->user_id = Auth::user()->id;
        $perfil->save();

        toast('Datos registrados con éxito!','success');
        return redirect()->route('perfilusuario.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perfil = Perfil::findOrFail($id);
        return view("perfilusuario.edit", compact('perfil'));
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
        $perfil = Perfil::findOrFail($id);
        $perfil->nombre = $request->nombre;
        $perfil->apaterno = $request->apaterno;
        $perfil->amaterno = $request->amaterno;
        $perfil->ci = $request->ci;
        $perfil->telefono = $request->telefono;
        $perfil->direccion = $request->direccion;
        $perfil->update();

        toast('Datos actualizados con éxito!','success');
        return redirect()->route('perfilusuario.index');
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
