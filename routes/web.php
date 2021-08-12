<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


//Grupo de rutas que comprueba usuario logeado
Route::middleware(['auth'])->group(function () {
	//Roles.
	Route::resource('roles','RoleController');

	//Users.
	Route::resource('users','UserController');

	//Sucursales.
	Route::resource('sucursales','SucursalController');

	//Sucursales_Usuarios (Asignacion de sucursales).
	Route::resource('sucursal_usuario','Sucursal_usuarioController');
	Route::post('sucursaluser/{id}','Sucursal_usuarioController@active')->name('active.user');

	//Categorias.
	Route::resource('categoria','CategoriaController');
	Route::get('vista/saldocategoria', 'VistasreportesController@saldocategoria')->name('v_saldocategoria');
	Route::post('reporte/saldocategoria','CategoriaController@saldocategoria')->name('r_saldocategoria');

	//Proveedores
	Route::get('reporte/proveedores', 'ProveedorController@reporteproveedores')->name('r_proveedores');

	//reporte dependencias por secretarias
    Route::get('reporte/dependencies_by_secretaries', 'VistasreportesController@view_of_dependencies_by_secretaries')->name('view_dependencies_by_secretaries');
	Route::post('dependencies_by_secretaries','ReportesController@dependencies_by_secretaries')->name('dependencies_by_secretaries');

	//Articulos
	//Buscador de artículos
	Route::get('articulo/buscador', 'ArticuloController@buscador');
	Route::resource('articulo','ArticuloController');
	//Reporte saldo de artículo en stock - Global - Por sucursal
	Route::get('vista/saldoporarticulo', 'VistasreportesController@saldoporarticulo')->name('v_saldoporarticulo');
	Route::post('saldoarticulo','ArticuloController@saldoarticulo')->name('r_saldoarticulo');
	//Reporte de artículo en especifico (por parametro) en stock.
	Route::get('vista/articulostock','VistasreportesController@articulostock')->name('v_articulostock');
	Route::post('reporte/articulostock','ArticuloController@articulostock')->name('r_articulostock');
	//Reporte de artículo en especifico (por parametro) egresado.
	Route::get('vista/articuloegreso','VistasreportesController@articuloegreso')->name('v_articuloegreso');
	Route::post('reporte/articuloegreso','ArticuloController@articuloegreso')->name('r_articuloegreso');
	//Reporte de ingreso de artículo a stock - solicitud de compra por fechas.
	Route::get('vista/ingresoarticulo_stock','VistasreportesController@ingresoarticulo_stock')->name('v_ingresoarticulo_stock');
	Route::post('reporte/ingresoarticulo_stock','ArticuloController@ingresoarticulo_stock')->name('r_ingresoarticulo_stock');

	//Solicitud de compra.
	Route::resource('solicitudcompra','SolicitudcompraController')->except(['index']);
	Route::post('unsuscrib-erequest-purchase/{id}','SolicitudcompraController@unsuscriberequest')->name('unsuscriberequest');

	//Reporte de solicitudes de compras - Resumen de montos
	Route::get('vista/solicitudesresumen_v','SolicitudcompraController@solicitudesresumen_v')->name('solicitudesresumen_v');
	Route::post('reporte/solicitudesresumen_r','SolicitudcompraController@solicitudesresumen_r')->name('solicitudesresumen_r');
	//Reportes de kardex de articulos
	Route::get('vista/kardex_articulo','VistasreportesController@kardex_articulo')->name('kardex_articulo_v');
	Route::post('reporte/kardex_articulo','ReportesController@kardex_articulo')->name('kardex_articulo_r');

	//factura y detalle.
	//Buscador de factura y detalles
	Route::get('factura/buscador', 'FacturaController@list');
	Route::resource('factura','FacturaController');
	Route::get('pdfdetallefactura/{id}', 'FacturaController@pdfdetallefactura')->name('pdfdetallefactura');
	Route::post('anularfactura/{id}','FacturaController@unsuscriberequest');

	//Egresos de articulos/productos.
	//Buscador de egresos y detalles
	Route::get('egreso/buscador', 'EgresoController@list');
	Route::resource('egreso','EgresoController');
	Route::get('pdfdetalleegreso/{id}', 'EgresoController@pdfdetalleegreso')->name('pdfdetalleegreso');
	//Crear dependencia(Unidad Administrativa).
	Route::post('create_dependencia', 'EgresoController@create_dependencia')->name('create_dependencia');
	//obtener detalle de solicitud.
	Route::get('egreso_facturadetalle', 'EgresoController@egreso_facturadetalle')->name('egreso_facturadetalle');
	//Anulacion de los egresos
	Route::post('anular/{id}','EgresoController@anular')->name('anulacion_egreso');

	//Trae los datos heredados de direcciones administrativas.
	Route::get('unidadadministrativa','EgresoController@unidadadministrativa')->name('unidadadministrativa');
	//Reporte de egreso de artículos del estock
	Route::get('vista/egresoarticulo_stock','VistasreportesController@egresoarticulo_stock')->name('v_egresoarticulo_stock');
	Route::post('reporte/egresoarticulo_stock','EgresoController@egresoarticulo_stock')->name('r_egresoarticulo_stock');
	//Reporte de solicitudes de compras - Resumen de montos
	Route::get('vista/egresosresumen_v','EgresoController@egresosresumen_v')->name('egresosresumen_v');
	Route::post('reporte/egresosresumen_r','EgresoController@egresosresumen_r')->name('egresosresumen_r');

	//Proveedores.
	//Buscador de proveedores
	Route::get('proveedor/buscador', 'ProveedorController@buscador');
	Route::resource('proveedor','ProveedorController');
	//Compra de artículos por proveedor
	Route::get('vista/articulo_proveedor','VistasreportesController@articulo_proveedor')->name('v_articulo_proveedor');
	Route::post('reporte/articulo_proveedor','ProveedorController@articulo_proveedor')->name('r_articulo_proveedor');

	//Partidas.
	Route::resource('partida','PartidaController');

	//Proyectos.
	Route::resource('proyecto','ProyectoController');

	//Preventivos.
	Route::resource('preventivo','PreventivoController');
	Route::get('pdfpreventivo/{id}', 'PreventivoController@pdfpreventivo')->name('pdfpreventivo');

	//Reportes
	Route::get('vista/egresoarticulo_oficina','VistasreportesController@egresoarticulo_oficina')->name('v_egresoarticulo_oficina');
	Route::post('reporte/egresoarticulo_oficina','ReportesController@egresoarticulo_oficina')->name('r_egresoarticulo_oficina');

	//Saldo de compras de gestiones
	Route::resource('saldocompra','SaldocompraController');

	Route::post('saldocompracloseinventory/{id}','SaldocompraController@closeinventorytoyear');

	//Perfil de usuario del sistema
	Route::resource('perfilusuario','PerfilusuarioController');

	//reportes para inventario
	Route::get('report-inventory','VistasreportesController@custominventory')->name('report_inventory_index');
	Route::post('printf-report-inventory','ReportesController@displayreportoinventory')->name('displayreportoinventory');

});