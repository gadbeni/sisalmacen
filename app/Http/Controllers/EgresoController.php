<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Egresodetalle;
use App\Egreso;
use App\Canceled;
use App\Solicitudcompra;
use App\Factura;
use App\Facturadetalle;
use App\Unidadadministrativa;
use App\Preventivo;
use Carbon\Carbon;
use Datatables;
use DB;

class EgresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:egreso.create')->only(['create','store']);
        $this->middleware('can:egreso.index')->only('index');
        $this->middleware('can:egreso.edit')->only(['edit','update']);
        $this->middleware('can:egreso.show')->only('show');
        $this->middleware('can:egreso.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('egreso.index');
    }

    public function list(){
      $sucursales = Auth::user()->sucursales;
      foreach ($sucursales as $key => $value) {
         $id_sucursales[] = $value->id;
      }
      $data = DB::table('egresos as e')
                  ->leftJoin('direccionadministrativas as da', 'e.direccionadministrativa_id', '=' ,'da.id')
                  ->leftJoin('unidadadministrativas as ua', 'e.unidadadministrativa_id', '=' ,'ua.id')
                  ->leftJoin('cuentas as cu', 'e.cuenta_id', '=', 'cu.id')
                  ->select(
                      'e.id', 'e.codigopedido', 'e.fechasolicitud', 'e.fechasalida',
                      'da.nombre as da_nombre', 'ua.nombre as ua_nombre',
                      'cu.codigo'
                  )
                  ->whereIn('e.sucursal_id',$id_sucursales)
                  ->where('e.condicion','!=',0)
                  ->orderBy('id','desc')
                  ->get();

      return datatables()->of($data)
                          ->addIndexColumn()
                          ->addColumn('date_output', function($row){
                              return date('d/m/Y H:i:s', strtotime($row->fechasalida)).'<br><small>'.\Carbon\Carbon::parse($row->fechasalida)->diffForHumans().'</small>';
                          })
                          ->addColumn('oficina', function($row){
                              return $row->da_nombre.'<br><strong>'.$row->ua_nombre.'</strong>';
                          })
                          ->addColumn('action', function($row){
                              $actions = '
                                  <div class="no-sort no-click bread-actions text-right">
                                      <a href="'.route('pdfdetalleegreso', ['id' => $row->id]).'" title="Imprimir Detalle de Compra" target="_blank" class="btn btn-sm btn-success">
                                          <i class="fas fa-print"></i> <span class="hidden-xs hidden-sm"></span>
                                      </a>
                                      <a href="'.route('egreso.edit',$row->id).'" title="Editar" class="btn btn-sm btn-info view">
                                          <i class="fas fa-edit"></i> <span class="hidden-xs hidden-sm"></span>
                                      </a>
                                      <button title="Anular Egreso" class="btn btn-sm btn-danger delete" data-toggle="modal" data-target="#modal-delete" onclick="deleteItem('."'".url("anular/".$row->id)."'".')">
                                          <i class="fas fa-trash"></i> <span class="hidden-xs hidden-sm"></span>
                                      </button>
                                  </div>
                                      ';
                              return $actions;
                          })
                          ->rawColumns(['date_output','oficina','action'])
                          ->make(true);
  }

    public function buscador(Request $request)
    {
        $search = $request->query('search');

        /*$egresos = Egreso::with('direccionadministrativa','unidadadministrativa','cuenta')
                ->where('codigopedido', 'like', '%'.$search.'%')
                ->orwhere('fechasolicitud', 'like', '%'.$search.'%')
                ->orwhere('fechasalida', 'like', '%'.$search.'%')
                ->orWhereHas('direccionadministrativa', function ($query) use ($search){
                            $query->where('nombre', 'like', '%'.$search.'%');
                            })
                ->orWhereHas('unidadadministrativa', function ($query) use ($search){
                            $query->where('nombre', 'like', '%'.$search.'%');
                            })
                ->take(10)
                ->get();*/

        $egresos = DB::table('egresos as e')
            ->leftJoin('direccionadministrativas as da', 'e.direccionadministrativa_id', '=' ,'da.id')
            ->leftJoin('unidadadministrativas as ua', 'e.unidadadministrativa_id', '=' ,'ua.id')
            ->leftJoin('cuentas as cu', 'e.cuenta_id', '=', 'cu.id')
            ->select(
                'e.id', 'e.codigopedido', 'e.fechasolicitud', 'e.fechasalida',
                'da.nombre as da_nombre', 'ua.nombre as ua_nombre',
                'cu.codigo'
            )
            ->where('e.condicion','!=',0)
            ->where('e.codigopedido', 'like', '%'.$search.'%')
            ->orwhere('e.fechasolicitud', 'like', '%'.$search.'%')
            ->orwhere('e.fechasalida', 'like', '%'.$search.'%')
            ->orwhere('da.nombre', 'like', '%'.$search.'%')
            ->orwhere('ua.nombre', 'like', '%'.$search.'%')
            ->take(10)
            ->get();

        return view ('egreso.lista_egresos',compact('egresos'));
    }

    public function pdfdetalleegreso($id)
    {
        $egreso = Egreso::with('direccionadministrativa','unidadadministrativa','cuenta','egresodetalle.facturadetalle.articulo','egresodetalle.solicitudcompra.entidad')->findOrFail($id);

        $pdf = \PDF::loadview('pdf.comprobanteentrega',compact('egreso'));
        return $pdf->stream('COMPROBANTE DE EGRESO - '.$egreso->codigopedido.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cuentas=DB::table('cuentas')->orderBy('nombre', 'asc')->get();

        $direccionadministrativas = DB::table('direccionadministrativas')
                                ->select('id','nombre')
                                ->orderBy('nombre', 'asc')
                                ->where('estado','=', 1)
                                ->get();
                                // return $direccionadministrativas;

        $sucursales = Auth::user()->sucursales;
        foreach ($sucursales as $key => $value) {
           $id_sucursales[] = $value->id;
        }

        $solicitudcompras=DB::table('solicitudcompras as s')
                            ->join('entidades','entidades.id','=','s.entidad_id')
                            ->join('facturas','facturas.solicitudcompra_id','=','s.id')
                            ->join('facturadetalles','facturadetalles.factura_id','=','facturas.id')
                            ->select(DB::raw('CONCAT(entidades.nombre, " - ", s.numerosolicitud) AS solicitudcompra'),'s.id','facturas.id as id_factura')
                            ->whereIn('s.sucursal_id', $id_sucursales)
                            ->where('facturadetalles.cantidadrestante','>',0)
                            ->where('facturas.estado', 'ACTIVO')
                            ->orderBy('s.id', 'desc')
                            ->groupBy('s.id')
                            ->get();

            $indice = 0;
            foreach ($solicitudcompras as $item)
            {
                $aux = DB::table('facturadetalles')
                         ->where('factura_id', $item->id_factura)
                         ->get();

                $solicitudcompras[$indice]->facturadetalle = $aux;
                $indice++;
            }

        return view("egreso.create",compact('cuentas','direccionadministrativas','sucursales','solicitudcompras'));
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
          'sucursal_id' => 'required',
          'direccionadministrativa_id' => 'required',
          'unidadadministrativa_id' => 'required',
          'fechasolicitud' => 'required',
          'fechasalida' => 'required'
        ];
        $messages = [
          'sucursal_id.required' => 'La sucurrsal es obligatoria.',
          'direccionadministrativa_id.required' => 'La direccion administrativa es obligatoria',
          'unidadadministrativa_id.required' => 'El campo unidad administrativa es obligatoria.',
          'fechasolicitud.required' => 'La fecha de solicitud es obligatoria',
          'fechasalida.required' => 'La fecha de salida es requerida'
        ];
        $this->validate($request, $rules, $messages);
        //dd($request);
        $date = Carbon::now();
        $gestion = $date->format('Y');

        $clientIP =\Request::ip ();

        try{
            DB::beginTransaction();
            //registra datos de la tabla egresos.
            $egreso = new Egreso;
            $egreso->user_id = Auth::user()->id;
            $egreso->sucursal_id = $request->sucursal_id;
            $egreso->direccionadministrativa_id = $request->direccionadministrativa_id;
            $egreso->unidadadministrativa_id = $request->unidadadministrativa_id;
            $egreso->codigopedido = $request->codigopedido; 
            $egreso->fechasolicitud = $request->fechasolicitud;
            $egreso->fechasalida = $request->fechasalida;
            $egreso->cuenta_id = $request->cuenta_id;
            $egreso->registro_clientIP = $clientIP;
            $egreso->registro_clientIP_update = $clientIP;
            $egreso->gestion = $gestion;
            $egreso->save();

            //registra datos del detalle de egreso.
            $cont = 0;
            while ($cont < count($request->articulo_id)) {
                $egresodetalle = new Egresodetalle;
                $egresodetalle->user_id = Auth::user()->id;
                $egresodetalle->sucursal_id = $request->sucursal_id;
                $egresodetalle->egreso_id = $egreso->id;
                $egresodetalle->solicitudcompra_id = $request->solicitudcompra_id[$cont];
                $egresodetalle->facturadetalle_id = $request->facturadetalle_id[$cont];
                $egresodetalle->cantidad = $request->cantidad[$cont];
                $egresodetalle->cantidadegresada = $request->cantidad[$cont];
                $egresodetalle->totalbs = $request->totalcompra[$cont];
                $egresodetalle->registro_clientIP = $clientIP;
                $egresodetalle->registro_clientIP_update = $clientIP;
                $egresodetalle->gestion = $gestion;
                $egresodetalle->save();

                //Resta los productos de egresodetalle a la tabla facturadetalle.
                $facturadetalle = Facturadetalle::where('id',$request->facturadetalle_id[$cont])->decrement('cantidadrestante', $request->cantidad[$cont]);

                $cont++;
            }

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
        }

        toast('Egreso de artículo registrado con éxito!','success');
        return redirect()->route('egreso.index');
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
      public function edit ($id) {
        $sucursales = Auth::user()->sucursales;
        $egreso = Egreso::with(['egresodetalle.facturadetalle.articulo'])->findOrFail($id);
        $direccionadministrativas = DB::table('direccionadministrativas')
                                ->select('id','nombre')
                                ->orderBy('nombre', 'asc')
                                ->where('estado','=', 1)
                                ->get();

        $solicitudcompras=DB::table('solicitudcompras as s')
                             ->join('entidades','entidades.id','=','s.entidad_id')
                             ->join('facturas','facturas.solicitudcompra_id','=','s.id')
                             ->join('facturadetalles','facturadetalles.factura_id','=','facturas.id')
                             ->select(DB::raw('CONCAT(entidades.nombre, " - ", s.numerosolicitud) AS solicitudcompra'),'s.id','facturas.id as id_factura')
                             ->where('facturadetalles.cantidadrestante','>',0)
                             ->orderBy('s.id', 'desc')
                             ->groupBy('s.id','entidades.nombre','s.numerosolicitud')
                             ->get();
        return view("egreso.editar", compact('egreso','solicitudcompras','sucursales','direccionadministrativas'));
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
        $clientIP =\Request::ip();
        DB::beginTransaction();

         try{

                $egreso = Egreso::findOrFail($id);
                //retorna todo el detalle al stock anterior
                $detalleegresooriginal = $egreso->egresodetalle;
                foreach ($detalleegresooriginal as $dtoriginal) {
                    $facturadetalle = Facturadetalle::where('id',$dtoriginal->facturadetalle_id)->first();
                    $facturadetalle->cantidadrestante = $facturadetalle->cantidadrestante + $dtoriginal->cantidad;
                    $facturadetalle->save();

                }
                $egreso->direccionadministrativa_id = $request->direccionadministrativa_id;
                $egreso->unidadadministrativa_id = $request->unidadadministrativa_id;
                $egreso->sucursal_id = $request->sucursal_id;
                $egreso->codigopedido = $request->codigopedido;
                $egreso->fechasolicitud = $request->fechasolicitud;
                $egreso->fechasalida = $request->fechasalida;
                $egreso->update();
                //eliminamos el detalle para insertar los nuevos items
                $egreso->egresodetalle()->delete();
                //Actualiza datos de la tabla facturadetalle
                $products = collect($request->egresodetalle)->transform(function($product) use($request,$clientIP) {
                  $egresodetalle = new Egresodetalle;
                    $egresodetalle->user_id = Auth::user()->id;
                    $egresodetalle->sucursal_id = $request->sucursal_id;
                    $egresodetalle->egreso_id = $request->id;
                    $egresodetalle->facturadetalle_id = $product['facturadetalle_id'];
                    $egresodetalle->solicitudcompra_id = $product['solicitudcompra_id'];
                    $egresodetalle->cantidad = $product['cantidad'];
                    $egresodetalle->cantidadegresada = $product['cantidad'];
                    $egresodetalle->totalbs =  $product['cantidad'] * $product['preciocompra'];
                    $egresodetalle->registro_clientIP = $request->registro_clientIP;
                    $egresodetalle->registro_clientIP_update = $clientIP;
                    $egresodetalle->gestion = $request->gestion;
                    $egresodetalle->save();
                     //Resta los productos de egresodetalle a la tabla facturadetalle.
                   $facturadetalle = Facturadetalle::where('id',$product['facturadetalle_id'])->decrement('cantidadrestante',$product['cantidad']);
                return $product;
               });

             DB::commit();

         }catch(\Exception $e){
           DB::rollback();
         }

         toast('Egreso de artículo atualizado con éxito!','success');
          return response()
            ->json([
                'updated' => true,
                'id' => $egreso->id
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function anular(Request $request, $id) {
       DB::beginTransaction();
       try{
          $egreso = Egreso::findOrFail($id);
         //retorna todo el detalle al stock anterior
          $detalleegresooriginal = $egreso->egresodetalle;
           foreach ($detalleegresooriginal as $dtoriginal) {
             $facturadetalle = Facturadetalle::where('id',$dtoriginal->facturadetalle_id)->first();
             $facturadetalle->cantidadrestante = $facturadetalle->cantidadrestante + $dtoriginal->cantidad;
             $facturadetalle->save();
           }
         $egreso->canceled()->create([
           'user_id' => auth()->user()->id,
           'motivo' => $request->motivo
           ]);

         $egreso->condicion = 0;
         $egreso->save();
           DB::commit();

        }catch(\Exception $e){
          DB::rollback();
        }
          toast('Egreso anulado con éxito');
         return redirect()->route('egreso.index');
    }

    public function destroy($id)
    {

    }

    //Obtiene unidades administrativas - Select heredado.
    public function unidadadministrativa(Request $request)
    {
        // dd($request);
      $dep_id = $request->dep_id;

      $unidadadministrativa = Unidadadministrativa::where('direccionadministrativa_id',$dep_id)->get();
        return response()->json($unidadadministrativa);
    }

    //obtener detalle de solicitud.
    public function egreso_facturadetalle(Request $request)
    {
      $dep_id = $request->dep_id;

      $articulos = Factura::join('solicitudcompras','facturas.solicitudcompra_id','=','solicitudcompras.id')
                            ->join('facturadetalles','facturas.id','=','facturadetalles.factura_id')
                            ->join('articulos','facturadetalles.articulo_id','=','articulos.id')
                            ->join('categorias','articulos.categoria_id','=','categorias.id')
                            ->select('articulos.id','articulos.nombre','categorias.nombre as nombre_categoria','articulos.presentacion','facturadetalles.id as idfacdet','facturadetalles.preciocompra','facturadetalles.cantidadrestante')
                            ->where('solicitudcompras.id',$dep_id)
                            ->where('facturadetalles.cantidadrestante', '>', 0)
                            ->get();
      return response()->json($articulos);
    }

    //Crear dependencia de direccion administrativa.
    public function create_dependencia(Request $request)
    {
        $unidadadministrativa = new Unidadadministrativa;
        $unidadadministrativa->nombre = $request->nombre;
        $unidadadministrativa->codigo = $request->codigo;
        $unidadadministrativa->direccionadministrativa_id = $request->direccionadministrativa_id;
        $unidadadministrativa->estado = 1;
        $unidadadministrativa->save();

        toast('Unidad administrativa registrada con éxito!','success');
        return redirect()->route('egreso.create');
    }

    //egresoarticulo_stock - Por rango de fechas
    public function egresoarticulo_stock(Request $request)
    {
        //dd($request);
        $sucursal_id = $request->sucursal_id;
        $fechainicio = $request->fechainicio;
        $fechafin = $request->fechafin;

        $articulos = Egreso::with('direccionadministrativa','unidadadministrativa','egresodetalle.solicitudcompra.preventivo','egresodetalle.facturadetalle.articulo.categoria')
                ->orderBy(DB::raw('DATE_FORMAT(fechasalida, "%Y-%m-%d")'),'asc')
                ->where('sucursal_id',$sucursal_id)
                ->where('egresos.condicion','!=',0)
                ->whereBetween(DB::raw('DATE_FORMAT(fechasalida, "%Y-%m-%d")'),array($fechainicio,$fechafin))
                ->get();
       
        $sumaTotalNumeroPedidos = DB::table('egresodetalles as edet')
                        ->join('egresos','egresos.id','=','edet.egreso_id')
                        ->join('facturadetalles as fdet','fdet.id','=','edet.facturadetalle_id')
                        ->select(DB::raw('sum(edet.cantidad * fdet.preciocompra) as sumaNumeroPedido'),'egresos.codigopedido')
                        ->groupBy('egreso_id')
                        ->where('egresos.sucursal_id',$sucursal_id)
                        ->where('egresos.condicion','!=',0)
                        ->whereBetween(DB::raw('DATE_FORMAT(egresos.fechasalida, "%Y-%m-%d")'),array($fechainicio,$fechafin))
                        ->get();

                        return view('pdf.newegresoarticulo_stock',compact('articulos','sumaTotalNumeroPedidos','fechainicio','fechafin'));
    }

    //Refleja el resumen de los egresos por fechas y montos
    public function egresosresumen_v()
    {
        $sucursales = Auth::user()->sucursales;
        return view ('vistasreportes_por_parametros.egresos_resumen',compact('sucursales'));
    }

    public function egresosresumen_r(Request $request)
    {
        $fechainicio = $request->fechainicio;
        $fechafin = $request->fechafin;
        $sucursal_id = $request->sucursal_id;

        // $egresos = DB::table('egresodetalles as edet')
        // ->join('egresos','egresos.id','=','edet.egreso_id')
        // ->join('facturadetalles as fdet','fdet.id','=','edet.facturadetalle_id')
        // ->select(DB::raw('DATE_FORMAT(egresos.fechasalida, "%Y-%m-%d") as fechasalida'),'egresos.codigopedido',DB::raw('sum(edet.totalbs) as sumaNumeroPedido'))
        // ->groupBy('egreso_id')
        // //->where('egresos.user_id',auth()->user()->id)
        // ->where('egresos.sucursal_id',$sucursal_id)
        // ->whereBetween(DB::raw('DATE_FORMAT(egresos.fechasalida, "%Y-%m-%d")'),array($fechainicio,$fechafin))
        // ->orderBy('egresos.fechasalida', 'asc')
        // ->get();

        $egresos = Egreso::with('egresodetalle')
            ->where('sucursal_id',$sucursal_id)
            ->where('condicion',1)
            ->orderBy(DB::raw('DATE_FORMAT(fechasalida, "%Y-%m-%d")','asc'))
            ->whereBetween(DB::raw('DATE_FORMAT(fechasalida, "%Y-%m-%d")'),array($fechainicio,$fechafin))
            ->get();

           // return $egresos;
        $pdf = \PDF::loadview('pdf.egresos_resumen',compact('egresos'));
        return $pdf->stream('RESUMEN DE EGRESOS POR PEDIDOS - '.date('d-m-Y').'.pdf');
                //return $egresos;
    }
}
