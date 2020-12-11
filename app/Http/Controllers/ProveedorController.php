<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Proveedor;
use App\Solicitudcompra;
use App\Factura;
use DB;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proveedor.create')->only(['create','store']);
        $this->middleware('can:proveedor.index')->only('index');
        $this->middleware('can:proveedor.edit')->only(['edit','update']);
        $this->middleware('can:proveedor.show')->only('show');
        $this->middleware('can:proveedor.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $proveedores = Proveedor::orderBy('razonsocial','asc')->paginate();
        return View('proveedor.index',compact('proveedores'));
    }

    public function buscador(Request $request)
    {
        $search = $request->query('search');
        $sentencia = $search ? "(
                        nit like '%$search%' or
                        razonsocial like '%$search%' or
                        responsable like '%$search%' or
                        telefono like '%$search%'
                        )" : 1;

        $proveedores = Proveedor::whereRaw($sentencia)
                ->take(10)
                ->get();

        return view ('proveedor.lista_proveedores',compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedor.create');
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
            'razonsocial' => 'unique:proveedors,razonsocial'
        ];

        $messages = [
            'razonsocial.unique' => 'La razón social (Proveedor) ya ha sido registrada.'
        ];

        $this->validate($request, $rules, $messages);

        $proveedor = new Proveedor;
        $proveedor->nit = $request->nit;
        $proveedor->razonsocial = $request->razonsocial;
        $proveedor->responsable = $request->responsable;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->fax = $request->fax;
        $proveedor->comentario = $request->comentario;
        $proveedor->save();

        toast('Proveedor registrado con éxito!','success');
        return redirect()->route('proveedor.index');
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
        $proveedor = Proveedor::findOrFail($id);
        return view("proveedor.edit", compact('proveedor'));
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
        $proveedor = Proveedor::findOrFail($id);
        $this->validate($request,[
            'razonsocial' => 'unique:proveedors,id,'.$proveedor->id
        ]);

        $proveedor->nit = $request->nit;
        $proveedor->razonsocial = $request->razonsocial;
        $proveedor->responsable = $request->responsable;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->fax = $request->fax;
        $proveedor->comentario = $request->comentario;
        $proveedor->update();

        toast('Proveedor actualizado con éxito!','success');
        return redirect()->route('proveedor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        if ($proveedor->condicion == 1) {
            $proveedor->condicion='0';
            $proveedor->update();
            toast('Proveedor inhabilitado!','warning');
            return redirect()->route('proveedor.index');
        }
        else{
            $proveedor->condicion='1';
            $proveedor->update();
            toast('Proveedor habilitado!','warning');
            return redirect()->route('proveedor.index');
        }
    }

    public function articulo_proveedor(Request $request)
    {
        //$sentencia_proveedor_id = $request->proveedor_id ? "proveedors.id=".$request->proveedor_id : 1;
        $proveedor_id = $request->proveedor_id;
        $fechainicio = $request->fechainicio;
        $fechafin = $request->fechafin;
        $sucursal_id = $request->sucursal_id;

        $proveedores = Factura::with('solicitudcompra.entidad','proveedor','facturadetalle.articulo.categoria')
                ->orderBY('fechafactura','asc')
                ->whereHas('proveedor', function ($query) use ($proveedor_id){
                            $query->where('id',$proveedor_id);
                            })
                ->whereBetween('fechafactura',array($fechainicio,$fechafin))
                ->where('sucursal_id',$sucursal_id)
                ->get();
        //return $proveedores;

        // $sumaTotalSolcomp = DB::table('facturadetalles as fdet')
        // ->join('facturas','facturas.id','=','fdet.factura_id')
        // ->join('proveedors','proveedors.id','=','facturas.proveedor_id')
        // ->select(DB::raw('sum(cantidadsolicitada * preciocompra) as sumaSolcomp'),'proveedors.razonsocial')
        // //->groupBy('fechafactura')
        // ->whereBetween('facturas.fechafactura',array($fechainicio,$fechafin))
        // ->get();

        $pdf = \PDF::loadview('pdf.articulo_proveedor',compact('proveedores'))->setPaper('A4','landscape');
        return $pdf->stream('ARTICULOS POR PROVEEDOR.pdf');
    }

    public function reporteproveedores()
    {
        $proveedores = Proveedor::orderBy('razonsocial','asc')->get();

        $pdf = \PDF::loadview('pdf.proveedores',compact('proveedores'));
        return $pdf->stream('PROVEEDORES.pdf');
    }
}
