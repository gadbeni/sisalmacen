<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Categoria;
use App\Facturadetalle;
//use Illuminate\Validation\Rule;
use DB;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:categoria.create')->only(['create','store']);
        $this->middleware('can:categoria.index')->only('index');
        $this->middleware('can:categoria.edit')->only(['edit','update']);
        $this->middleware('can:categoria.show')->only('show');
        $this->middleware('can:categoria.destroy')->only('destroy');
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
                        categorias.id like '%$search%' or
                        categorias.nombre like '%$search%'
                        )" : 1;

        $categorias = DB::table('categorias')
            ->select('id','nombre','condicion')
            ->OrderBy('id','desc')
            ->whereRaw($sentencia)
            ->paginate();

        return View('categoria.index', compact('categorias','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->validate($request,[
            //'nombre' => 'unique:categorias,nombre'
        //]);
        $rules = [
            'nombre' => 'unique:categorias,nombre'
        ];

        $messages = [
            'nombre.unique' => 'La categoría ya ha sido registrada.'
        ];

        $this->validate($request, $rules, $messages);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();

        toast('Categoría registrada con éxito!','success');
        return redirect()->route('categoria.index');
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
        $categoria = Categoria::findOrFail($id);
        return view("categoria.edit", compact('categoria'));
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
        $categoria = Categoria::findOrFail($id);
        $this->validate($request,[
            'nombre' => 'unique:categorias,id,'.$categoria->id
            //'nombre' => Rule::unique('categorias')->ignore($categoria->id)
        ]);

        $categoria->nombre = $request->nombre;
        $categoria->update();

        toast('Categoría actualizada con éxito!','success');
        return redirect()->route('categoria.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->condicion == 1) {
            $categoria->condicion='0';
            $categoria->update();
            toast('categoría inhabilitada con éxito!','warning');
            return redirect()->route('categoria.index');
        }
        else{
            $categoria->condicion='1';
            $categoria->update();
            toast('categoría habilitada con éxito!','warning');
            return redirect()->route('categoria.index');
        }
    }

    public function saldocategoria(Request $request)
    {
        $sucursal_id = $request->sucursal_id;
        $categoria_id = $request->categoria_id;

        $categoria = Categoria::find($categoria_id);
        $facturadetalles = Facturadetalle::with('factura.solicitudcompra.entidad','articulo.categoria')
            ->where('cantidadrestante','>','0')
            ->whereHas('articulo', function ($query) {
                            $query->orderBY('nombre', 'asc');
                            })
            ->whereHas('articulo.categoria', function ($query) use ($categoria_id){
                            $query->where('id',$categoria_id);
                            })
            ->where('sucursal_id',$sucursal_id)
            ->get();

        $pdf = \PDF::loadview('pdf.saldocategoria',compact('facturadetalles','categoria'));
        return $pdf->stream('SALDO DE '.$categoria->nombre.'.pdf');
    }
}
