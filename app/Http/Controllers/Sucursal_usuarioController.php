<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Sucursal_user;
use App\Sucursal;
use App\User;
use DB;

class Sucursal_usuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sucursal_usuario.create')->only(['create','store']);
        $this->middleware('can:sucursal_usuario.index')->only('index');
        $this->middleware('can:sucursal_usuario.edit')->only(['edit','update']);
        $this->middleware('can:sucursal_usuario.show')->only('show');
        $this->middleware('can:sucursal_usuario.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursal_usuarios = DB::table('sucursal_user as suc_usu')
                        ->join('sucursals','sucursals.id','=','suc_usu.sucursal_id')
                        ->join('users','users.id','=','suc_usu.user_id')
                        ->select('suc_usu.id','sucursals.sucursal','users.name','suc_usu.estado','suc_usu.fecha_inactivacion')
                        ->orderBy('suc_usu.id', 'desc')
                        ->paginate();

        return view('sucursal_usuario.index', compact('sucursal_usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        $users = User::all();

        return view("sucursal_usuario.create", compact('sucursales','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sucursal_usuario = new Sucursal_user;
        $sucursal_usuario->sucursal_id = $request->sucursal_id;
        $sucursal_usuario->user_id = $request->user_id;
        $sucursal_usuario->save();

        toast('Sucursal asignada registrada con éxito!','success');
        return redirect()->route('sucursal_usuario.index');
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
        $sucursal_usuario = Sucursal_user::findOrFail($id);
        $sucursal_usuario->estado = 'INACTIVO';
        $sucursal_usuario->fecha_inactivacion = \Carbon\Carbon::now();
        $sucursal_usuario->update();

        toast('Eliminado correctamente!','warning');
        return redirect()->route('sucursal_usuario.index');
    }
}
