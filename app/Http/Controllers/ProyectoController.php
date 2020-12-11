<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
//use App\Http\Requests\ProyectoFormRequest;
use App\Direccionadministrativa;
use App\Unidadejecutora;
use App\Proyecto;
use DB;

class ProyectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proyecto.create')->only(['create','store']);
        $this->middleware('can:proyecto.index')->only('index');
        $this->middleware('can:proyecto.edit')->only(['edit','update']);
        $this->middleware('can:proyecto.show')->only('show');
        $this->middleware('can:proyecto.destroy')->only('destroy');
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
                        proyectos.codigo like '%$search%' or
                        proyectos.nombre like '%$search%' or
                        da.codigo like '%$search%' or
                        da.nombre like '%$search%' or
                        ua.codigo like '%$search%' or
                        ua.nombre like '%$search%'
                        )" : 1;

        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $proyectos = Proyecto::join('direccionadministrativas as da','proyectos.direccionadministrativa_id','=','da.id')
                ->join('unidadadministrativas as ua','proyectos.unidadadministrativa_id','=','ua.id')
                ->select('proyectos.id','proyectos.codigo','proyectos.nombre','da.codigo as codigo_da','da.nombre as direccionadministrativa','ua.codigo as codigo_ua','ua.nombre as unidadadministrativa')
                ->orderBy('proyectos.id','desc')
                ->whereIn('proyectos.sucursal_id',$id_sucursales)
                ->whereRaw($sentencia)
                ->paginate();

        return view('proyecto.index',compact('proyectos','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $direccionadministrativas = DB::table('direccionadministrativas')
                                ->select('id','nombre')
                                ->orderBy('nombre', 'asc')
                                ->where('estado','=', 1)
                                ->get();

        $sucursales = Auth::user()->sucursales;

        return view("proyecto.create",compact('direccionadministrativas','sucursales'));
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
            'nombre' => 'unique:proyectos,nombre'
        ];

        $messages = [
            'nombre.unique' => 'El proyecto ya ha sido registrado.'
        ];

        $this->validate($request, $rules, $messages);

        $proyecto = new Proyecto;
        $proyecto->user_id = Auth::user()->id;
        $proyecto->sucursal_id = $request->sucursal_id;
        $proyecto->direccionadministrativa_id = $request->direccionadministrativa_id;
        $proyecto->unidadadministrativa_id = $request->unidadadministrativa_id;
        $proyecto->codigo = $request->codigo;
        $proyecto->nombre = $request->nombre;
        $proyecto->save();

        toast('Proyecto registrado con éxito!','success');
        return redirect()->route('proyecto.index');
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
        $proyecto = Proyecto::findOrFail($id);

        $direccionadministrativas = DB::table('direccionadministrativas')
                                ->select('id','nombre')
                                ->orderBy('nombre', 'asc')
                                ->where('estado','=', 1)
                                ->get();

        $sucursales = Auth::user()->sucursales;

        return view("proyecto.edit",compact('proyecto','direccionadministrativas','sucursales'));
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
        $proyecto = Proyecto::findOrFail($id);
        $this->validate($request,[
            'nombre' => 'unique:proyectos,id,'.$proyecto->id
        ]);
        //dd($request);
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->user_id = Auth::user()->id;
        $proyecto->sucursal_id = $request->sucursal_id;
        $proyecto->direccionadministrativa_id = $request->direccionadministrativa_id;
        $proyecto->unidadadministrativa_id = $request->unidadadministrativa_id;
        $proyecto->codigo = $request->codigo;
        $proyecto->nombre = $request->nombre;
        $proyecto->update();

        toast('Proyecto actualizado con éxito!','success');
        return redirect()->route('proyecto.index');
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

    public function unidadejecutora()
    {
        $dep_id = Input::get('dep_id');

        $unidadejecutora = Unidadejecutora::where('iddireccionadministrativa',$dep_id)->get();
        return response()->json($unidadejecutora);
    }
}
