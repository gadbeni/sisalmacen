<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
//use App\Http\Requests\PartidaFormRequest;
use App\Partida;
use DB;

class PartidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:partida.create')->only(['create','store']);
        $this->middleware('can:partida.index')->only('index');
        $this->middleware('can:partida.edit')->only(['edit','update']);
        $this->middleware('can:partida.show')->only('show');
        $this->middleware('can:partida.destroy')->only('destroy');
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
                        partidas.codigo like '%$search%' or
                        partidas.nombre like '%$search%'
                        )" : 1;

        $partidas = DB::table('partidas')
            ->select('id','codigo','nombre','condicion')
            ->OrderBy('id','desc')
            ->whereRaw($sentencia)
            ->paginate();

        return View('partida.index',compact('partidas','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partida.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'unique:partidas,nombre'
        ];

        $messages = [
            'nombre.unique' => 'La partida presupuestaria ya ha sido registrada.'
        ];

        $this->validate($request, $rules, $messages);

        $partida = new Partida();
        $partida->codigo = $request->codigo;
        $partida->nombre = $request->nombre;
        $partida->save();

        toast('Partida registrada con éxito!','success');
        return redirect()->route('partida.index');
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
        $partida = Partida::findOrFail($id);
        return view("partida.edit",compact('partida'));
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
        $partida = Partida::findOrFail($id);
        $this->validate($request,[
            'nombre' => 'unique:partidas,id,'.$partida->id
        ]);

        $partida = Partida::findOrFail($id);
        $partida->codigo = $request->codigo;
        $partida->nombre = $request->nombre;
        $partida->update();

        toast('Partida actualizada con éxito!','success');
        return redirect()->route('partida.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partida = Partida::findOrFail($id);

        if ($partida->condicion == 1) {
            $partida->condicion='0';
            $partida->update();
            toast('Partida inhabilitada con éxito!','warning');
            return redirect()->route('partida.index');;
        }
        else{
            $partida->condicion='1';
            $partida->update();
            toast('Partida habilitada con éxito!','warning');
            return redirect()->route('partida.index');
        }
    }
}
