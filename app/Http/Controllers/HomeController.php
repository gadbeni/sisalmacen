<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitudcompra;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$conteosolicitudes = DB::table('solicitudcompras')
        //->join('entidades','entidades.id','=','solicitudcompras.entidad_id')
        //->select(DB::raw('count(*) as totalSolicitudes'))
        //->where('entidades.id','=',1)
        //->where('entidades.id','=',2)
        //->orwhere('entidades.id','=',3)
        //->get();

        //return $conteosolicitudes;

        return view('home');
    }

}
