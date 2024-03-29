<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;
// use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;
use App\Articulo;
use App\Categoria;
use App\Solicitudcompra;
use App\Preventivo;
use App\Sucursal;
use Carbon\Carbon;
use DB;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:producto.create')->only(['create','store']);
        $this->middleware('can:producto.index')->only('index');
        $this->middleware('can:producto.edit')->only(['edit','update']);
        $this->middleware('can:producto.show')->only('show');
        $this->middleware('can:producto.destroy')->only('destroy');
        $this->middleware('can:reporte.resumenalmacenes')->only('resumenalmacenes');
        $this->middleware('can:reporte.detallesalmacenes')->only('detallealmacenes');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulos = Articulo::with('categoria')
                ->orderBy('nombre','asc')
                ->paginate();

        return view('articulo.index', compact('articulos'));
    }

    public function buscador(Request $request)
    {
        $search = $request->query('search');

        $articulos = Articulo::with('categoria')
                ->where('id', 'like', '%'.$search.'%')
                ->orwhere('nombre', 'like', '%'.$search.'%')
                ->orWhereHas('categoria', function ($query) use ($search){
                            $query->where('nombre', 'like', '%'.$search.'%');
                            })
                ->take(10)
                ->get();

        return view ('articulo.lista_articulos',compact('articulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias=Categoria::where('condicion','=','1')->orderBy('nombre', 'asc')->get();
        return view("articulo.create", compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $articulo = new Articulo;
        $articulo->categoria_id = $request->categoria_id;
        $articulo->nombre = $request->nombre;
        $articulo->presentacion = $request->presentacion;
        $articulo->save();

        toast('Artículo registrado con éxito!','success');
        return redirect()->route('articulo.index');
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
        $articulo = Articulo::findOrFail($id);
        $categorias=DB::table('categorias')->where('condicion','=','1')->orderBy('nombre', 'asc')->get();
        return view("articulo.edit", compact('articulo','categorias'));
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
        $articulo = Articulo::findOrFail($id);
        $articulo->categoria_id = $request->categoria_id;
        $articulo->nombre = $request->nombre;
        $articulo->presentacion = $request->presentacion;
        $articulo->update();

        toast('Artículo actualizado con éxito!','success');
        return redirect()->route('articulo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->delete();

        toast('Articulo eliminado con éxito!','warning');
        return redirect()->route('articulo.index');
    }

    // function articulo_edit($id){
    //     $articulo = DB::table('articulos as a')
    //     ->select('a.precio')
    //     ->where('id', $id)
    //     ->first();
    //     return $articulo->precio;
    // }

    // function articulo_update(Request $request){
    //     $articulo = Articulo::findOrFail($request->id);
    //     $articulo->precio = $request->precio;

    //     $articulo->update();
    //     $articulo_edit = $request->id;
    //     return redirect::to('compras/facturadetalle/create');
    // }

    // public function saldoarticulo()
    // {
    //     $categorias = Categoria::where('id','=',2)->get();

    //     $indice = 0;
    //     foreach ($categorias as $categoria)
    //     {
    //         $aux = Articulo::with('facturadetalle.factura.solicitudcompra.entidad')
    //         ->where('categoria_id',$categoria->id)
    //         ->whereHas('facturadetalle', function ($query){
    //                 $query->where('cantidadrestante','=',9);
    //                 })
    //         ->whereHas('facturadetalle.factura.solicitudcompra', function ($query){
    //                 $query->where('user_id',auth()->user()->id);
    //                 })
    //         ->orderBY('nombre','asc')
    //         ->get();

    //         $categorias[$indice]->articulos = $aux;
    //         $indice++;
    //     }

    //     return $categorias;
    // }

    //ingresoarticulo_stock - Por rango de fechas
    public function ingresoarticulo_stock(Request $request)
    {
        $sucursal_id = $request->sucursal_id;
        $fechainicio = $request->fechainicio;
        $fechafin = $request->fechafin;

        $articulos = Solicitudcompra::with('entidad','factura.proveedor','factura.facturadetalle.articulo.categoria','preventivo')
                ->orderBY('fechaingreso','asc')
                ->where('sucursal_id',$sucursal_id)
                ->where('estado', 'ACTIVO')
                ->whereBetween('fechaingreso',array($fechainicio,$fechafin))
                ->get();

        //Calcula montos totales
        $sumaTotalSolcomp = DB::table('facturadetalles as fdet')
                    ->join('facturas','facturas.id','=','fdet.factura_id')
                    ->join('solicitudcompras as s','s.id','=','facturas.solicitudcompra_id')
                    ->join('entidades','entidades.id','=','s.entidad_id')
                    ->select(DB::raw('sum(cantidadsolicitada * preciocompra) as sumaSolcomp'),'s.numerosolicitud','entidades.nombre as entidad')
                    ->groupBy('factura_id')
                    ->where('s.sucursal_id',$sucursal_id)
                    ->where('facturas.estado', 'ACTIVO')
                    ->whereBetween('s.fechaingreso',array($fechainicio,$fechafin))
                    ->get();
        return view('pdf.newingresoarticulo_stock', compact('articulos','sumaTotalSolcomp','fechainicio','fechafin'));
        // $pdf = \PDF::loadview('pdf.ingresoarticulo_stock',compact('articulos','sumaTotalSolcomp'))->setPaper('A4','landscape');
        // return $pdf->stream('INGRESO DE ARRICULO A STOCK.pdf');
    }

    public function saldoarticulo(Request $request)
    {
        $sucursal_id = $request->sucursal_id;
        $categorias = Categoria::orderBY('nombre','asc')->get();
        $anio = Carbon::today()->year;
        $indice = 0;
        foreach ($categorias as $categoria)
        {
            $aux = DB::table('facturadetalles as fdet')
                    ->leftjoin('articulos as art','fdet.articulo_id','=','art.id')
                    ->join('facturas as f','f.id','=','fdet.factura_id')
                    ->join('solicitudcompras as s','s.id','=','f.solicitudcompra_id')
                    ->join('entidades','entidades.id','=','s.entidad_id')
                    ->select('art.id as idarticulo','art.nombre as articulo',
                            'art.presentacion','fdet.preciocompra','fdet.cantidadrestante',
                            'fdet.totalbs','s.numerosolicitud','entidades.nombre as entidad','s.estado')
                    ->where('fdet.cantidadrestante','>',0)
                    ->where('s.sucursal_id',$sucursal_id)
                    ->where('f.estado','ACTIVO')
                    ->orderBY('art.nombre','asc')
                    ->where('categoria_id',$categoria->id)
                    ->get();
            $categorias[$indice]->articulos = $aux;
            $indice++;
        }
        $pdf = \PDF::loadview('pdf.saldoproducto',compact('categorias'));
        return $pdf->stream('SALDO DE PRODUCTOS - '.date('d-m-Y').'.pdf');
    }

    public function saldoarticulo_rango(Request $request)
    {
        // return $request;
        $sucursal_id = $request->sucursal_id;
        $categorias = Categoria::orderBY('nombre','asc')->get();
        // return $categorias;
        $anio = Carbon::today()->year;
        // return $anio

        $indice = 0;
        foreach ($categorias as $categoria)
        {
            $aux = DB::table('facturadetalles as fdet')
                    ->leftjoin('articulos as art','fdet.articulo_id','=','art.id')
                    ->join('facturas as f','f.id','=','fdet.factura_id')
                    ->join('solicitudcompras as s','s.id','=','f.solicitudcompra_id')
                    ->join('entidades','entidades.id','=','s.entidad_id')
                    ->select('art.id as idarticulo','art.nombre as articulo',
                            'art.presentacion','fdet.preciocompra','fdet.cantidadrestante',
                            'fdet.totalbs','s.numerosolicitud','entidades.nombre as entidad','s.estado')
                    ->where('fdet.cantidadrestante','>',0)
                    ->where('s.sucursal_id',$sucursal_id)
                    ->where('s.fechaingreso','>=', $request->fechainicio)
                    ->where('s.fechaingreso','<=', $request->fechafin)
                    ->where('f.estado','ACTIVO')
                    ->orderBY('art.nombre','asc')
                    ->where('categoria_id',$categoria->id)
                    ->get();

                    
            $categorias[$indice]->articulos = $aux;
            $indice++;
        }
        $fechainicio= $request->fechainicio;
        $fechafin = $request->fechafin;

        // return $categorias;
        $pdf = \PDF::loadview('pdf.saldoproductorangofecha',compact('categorias','fechainicio','fechafin'));
        return $pdf->stream('SALDO DE PRODUCTOS - '.date('d-m-Y').'.pdf');
    }

    public function articulostock(Request $request)
    {
        $articulo_id = $request->articulo_id;
        $sucursal_id = $request->sucursal_id;
        //$articulo = 
        $articulos = DB::table('articulos')
                ->join('categorias','categorias.id','=','articulos.categoria_id')
                ->select('articulos.id','articulos.nombre as articulo','articulos.presentacion','categorias.nombre as categoria')
                ->where('articulos.id',$articulo_id)
                ->get();
        $indice = 0;
        foreach ($articulos as $articulo)
        {
            $aux = DB::table('facturadetalles as fdet')
                ->join('facturas','facturas.id','=','fdet.factura_id')
                ->join('solicitudcompras as solcomp','solcomp.id','=','facturas.solicitudcompra_id')
                ->join('entidades','entidades.id','=','solcomp.entidad_id')
                ->select(DB::raw('CONCAT(entidades.nombre, " - ",solcomp.numerosolicitud) AS solicitudcompra'),'fdet.cantidadrestante','fdet.preciocompra','solcomp.estado')
                ->where('fdet.cantidadrestante','>',0)
                ->where('solcomp.sucursal_id',$sucursal_id)
                ->where('fdet.articulo_id',$articulo->id)
                ->where('solcomp.estado','ACTIVO')
                ->where('facturas.estado','ACTIVO')
                ->orderBY('solcomp.id','asc')
                ->get();

            $articulos[$indice]->facturadetalle = $aux;
            $indice++;
        }

        $pdf = \PDF::loadview('pdf.articulostock',compact('articulos'));
        return $pdf->stream('SALDO DE '.$articulos[0]->articulo.'.pdf');
    }


    //Reporte de articulos egresados - Solicitudes de pedidos
    public function articuloegreso(Request $request)
    {
        $articulo_id = $request->articulo_id;
        $sucursal_id = $request->sucursal_id;

        $articulos = DB::table('articulos')
                ->join('categorias','categorias.id','=','articulos.categoria_id')
                ->select('articulos.id','articulos.nombre as articulo','articulos.presentacion','categorias.nombre as categoria')
                ->where('articulos.id',$articulo_id)
                ->get();

        $indice = 0;
        foreach ($articulos as $articulo)
        {
            $aux = DB::table('egresodetalles as edet')
                ->join('egresos','egresos.id','=','edet.egreso_id')
                ->join('unidadadministrativas','unidadadministrativas.id','=','egresos.unidadadministrativa_id')
                ->join('facturadetalles as fdet','fdet.id','=','edet.facturadetalle_id')
                ->join('articulos','articulos.id','=','fdet.articulo_id')
                ->join('facturas','facturas.id','=','fdet.factura_id')
                ->join('solicitudcompras as solcomp','solcomp.id','=','facturas.solicitudcompra_id')
                ->join('entidades','entidades.id','=','solcomp.entidad_id')
                ->select(DB::raw('CONCAT(entidades.nombre, " - ",solcomp.numerosolicitud) AS solicitudcompra'),'edet.cantidadegresada','edet.totalbs','egresos.fechasalida','egresos.codigopedido','unidadadministrativas.nombre as oficina')
                ->where('solcomp.sucursal_id',$sucursal_id)
                ->where('fdet.articulo_id',$articulo->id)
                ->where(function ($query) {
                    $query->where('egresos.condicion',1);
                })
                ->where('facturas.estado', 'ACTIVO')
                ->orderBY('egresos.fechasalida','asc')
                ->get();

            $articulos[$indice]->egresodetalles = $aux;
            $indice++;
        }

        $pdf = \PDF::loadview('pdf.articuloegresado',compact('articulos'))->setPaper('A4','landscape');
        return $pdf->stream('SALDO DE '.$articulos[0]->articulo.'.pdf');
    }
 
    //Reporte resumenes de almacenes                --ig
    public function resumenalmacenes(Request $request)
    {
        // return $request;
        $data = DB::table('partidas as p')
            ->join('partidacategorias as pt', 'pt.partida_id', 'p.id')
            ->join('categorias as c', 'c.id', 'pt.categoria_id')
            ->join('articulos as r', 'r.categoria_id', 'c.id')
            ->join('facturadetalles as fd', 'fd.articulo_id', 'r.id')
            ->join('facturas as f', 'f.id', 'fd.factura_id')
            ->join('sucursals as s', 's.id', 'fd.sucursal_id')
            ->join('solicitudcompras as sc', 'sc.id', 'f.solicitudcompra_id')            
            ->where('s.id', $request->sucursal_id)
            ->where('fd.gestion', $request->gestion)            
            // ->where('sc.fechaingreso', '>=', $request->fechainicio)
            // ->where('sc.fechaingreso', '<=', $request->fechafin)
            ->select('p.codigo','c.nombre as categoria', 'r.nombre as articulo', DB::raw("SUM(fd.cantidadsolicitada) as cantinicial"), DB::raw("sum(fd.totalbs) as saldoinicial"), 
                DB::raw("SUM(fd.cantidadrestante) as cantfinal"), DB::raw("sum(fd.preciocompra)"), DB::raw("SUM(fd.cantidadrestante) * sum(fd.preciocompra) as saldofinal"))
            ->groupBy('c.nombre', 'r.nombre')
            ->get();
            // return $data;
        $sucursal = Sucursal::find($request->sucursal_id);
        // $fechainicio= $request->fechainicio;
        // $fechafin = $request->fechafin;
        return view('pdf.resumenalmacenes',compact('data','sucursal'));

        // $pdf = \PDF::loadview('pdf.resumenalmacenes',compact('data','sucursal','fechainicio','fechafin'))->setPaper('A4','landscape');
        // return $pdf->stream('SALDO DE.pdf');
    }

    public function resumenalmacenespartida(Request $request)
    {
        $data = DB::table('partidas as p')
            ->join('partidacategorias as pt', 'pt.partida_id', 'p.id')
            ->join('categorias as c', 'c.id', 'pt.categoria_id')
            ->join('articulos as r', 'r.categoria_id', 'c.id')
            ->join('facturadetalles as fd', 'fd.articulo_id', 'r.id')
            ->join('facturas as f', 'f.id', 'fd.factura_id')
            ->join('sucursals as s', 's.id', 'fd.sucursal_id')
            ->join('solicitudcompras as sc', 'sc.id', 'f.solicitudcompra_id')            
            ->where('s.id', $request->sucursal_id)
            ->where('fd.gestion', $request->gestion)            
            // ->where('sc.fechaingreso', '>=', $request->fechainicio)
            // ->where('sc.fechaingreso', '<=', $request->fechafin)
            ->select('p.codigo','c.nombre as categoria', 'r.nombre as articulo', DB::raw("SUM(fd.cantidadsolicitada) as cantinicial"), DB::raw("sum(fd.totalbs) as saldoinicial"), 
                DB::raw("SUM(fd.cantidadrestante) as cantfinal"), DB::raw("sum(fd.preciocompra)"), DB::raw("SUM(fd.cantidadrestante) * sum(fd.preciocompra) as saldofinal"))
                ->groupBy('p.codigo','c.nombre', 'r.nombre') ->orderBy('p.codigo')
            ->get();


        

        $sucursal = Sucursal::find($request->sucursal_id);
        $anio = $request->gestion;
        // return $request;
        return view('pdf.resumenalmacenespartida', compact('data','sucursal', 'anio'));
    }



    //Reporte detalle de almacenes                --ig
    public function detallealmacenes(Request $request)
    {
        $data = DB::table('partidas as p')
            ->join('partidacategorias as pt', 'pt.partida_id', 'p.id')
            ->join('categorias as c', 'c.id', 'pt.categoria_id')
            ->join('articulos as a', 'a.categoria_id', 'c.id')
            ->join('facturadetalles as fd', 'fd.articulo_id', 'a.id')  
            ->join('sucursals as s', 's.id', 'fd.sucursal_id')          
            ->where('s.id', $request->sucursal_id)
            ->where('fd.gestion', $request->gestion)
            ->select('a.id','a.nombre', 'a.presentacion', 'fd.preciocompra',
                DB::raw("fd.cantidadsolicitada as cinicial"),DB::raw("SUM(fd.cantidadsolicitada) - fd.cantidadsolicitada as centrada"), DB::raw("SUM(fd.cantidadsolicitada)- SUM(fd.cantidadrestante) as csalida"),DB::raw('SUM(fd.cantidadrestante) as saldofinal'),
                DB::raw("fd.totalbs as BSsaldoinicial"),     DB::raw("SUM(fd.totalbs) - fd.totalbs as BSentrada"),           DB::raw("(SUM(fd.cantidadsolicitada)- SUM(fd.cantidadrestante))*fd.preciocompra as BSsalida"), DB::raw("SUM(fd.cantidadrestante)*fd.preciocompra as BSsaldofinal"))
            ->groupBy('a.id', 'fd.preciocompra')->orderBy('a.id')
            ->get();

        // return $data; 

        $sucursal = Sucursal::find($request->sucursal_id);
        // return $sucursal;
        // $pdf = \PDF::loadview('pdf.detallealmacenes',compact('data','sucursal'))->setPaper('A4','landscape');
        // return $pdf->stream('SALDO DE.pdf');

        return view('pdf.detallealmacenes',compact('data','sucursal'));
    }


}
