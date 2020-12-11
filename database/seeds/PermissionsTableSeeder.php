<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Users
        Permission::create([
            'name'          => 'Navegar usuarios',
            'slug'          => 'users.index',
            'description'   => 'Lista y navega todos los usuarios del sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de usuario',
            'slug'          => 'users.show',
            'description'   => 'Ve en detalle cada usuario del sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de usuarios',
            'slug'          => 'users.edit',
            'description'   => 'Podría editar cualquier dato de un usuario del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar usuario',
            'slug'          => 'users.destroy',
            'description'   => 'Podría eliminar cualquier usuario del sistema',
        ]);

        //Roles
        Permission::create([
            'name'          => 'Navegar roles',
            'slug'          => 'roles.index',
            'description'   => 'Lista y navega todos los roles del sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un rol',
            'slug'          => 'roles.show',
            'description'   => 'Ve en detalle cada rol del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de roles',
            'slug'          => 'roles.create',
            'description'   => 'Podría crear nuevos roles en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de roles',
            'slug'          => 'roles.edit',
            'description'   => 'Podría editar cualquier dato de un rol del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar roles',
            'slug'          => 'roles.destroy',
            'description'   => 'Podría eliminar cualquier rol del sistema',
        ]);

        //Sucursales
        Permission::create([
            'name'          => 'Navegar sucursales',
            'slug'          => 'sucursales.index',
            'description'   => 'Lista y navega todas las sucursales del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de sucursales',
            'slug'          => 'sucursales.create',
            'description'   => 'Podría crear nuevas sucursales en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de sucursales',
            'slug'          => 'sucursales.edit',
            'description'   => 'Podría editar sucursal del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar sucursales',
            'slug'          => 'sucursales.destroy',
            'description'   => 'Podría eliminar cualquier sucursal del sistema',
        ]);

        //Sucursales_usuarios (Asignacion de sucursales)
        Permission::create([
            'name'          => 'Navegar sucursales asignadas',
            'slug'          => 'sucursal_usuario.index',
            'description'   => 'Lista y navega todas las sucursales asignadas del sistema',
        ]);

        Permission::create([
            'name'          => 'Creación de asignacion de sucursales',
            'slug'          => 'sucursal_usuario.create',
            'description'   => 'Podría crear nueva asignacion sucursales en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de asignacion de sucursales',
            'slug'          => 'sucursal_usuario.edit',
            'description'   => 'Podría editar asignacion de sucursal del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar asignacion de sucursales',
            'slug'          => 'sucursal_usuario.destroy',
            'description'   => 'Podría eliminar cualquier asignacion de sucursal del sistema',
        ]);

        //==============================================//
        //DropdownAlmacen
        Permission::create([
            'name'          => 'Navegar dropdown almacen',
            'slug'          => 'dropdown.almacen',
            'description'   => 'navega toda la lista de dropdown de almacen',
        ]);

        //Categoría - DropdownAlmacen
        Permission::create([
            'name'          => 'Navegar categoria',
            'slug'          => 'categoria.index',
            'description'   => 'Lista y navega todas las categorias',
        ]);

        Permission::create([
            'name'          => 'Creación de categoria',
            'slug'          => 'categoria.create',
            'description'   => 'Podría crear nueva categoria en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de categoria',
            'slug'          => 'categoria.edit',
            'description'   => 'Podría editar una categoria en el sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de una categoria',
            'slug'          => 'categoria.show',
            'description'   => 'Ve en detalle cada categoria del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar categoria',
            'slug'          => 'categoria.destroy',
            'description'   => 'Podría eliminar cualquier categoria del sistema',
        ]);

        //Producto - DropdownAlmacen
        Permission::create([
            'name'          => 'Navegar productos',
            'slug'          => 'producto.index',
            'description'   => 'Lista y navega todos los productos',
        ]);

        Permission::create([
            'name'          => 'Creación de producto',
            'slug'          => 'producto.create',
            'description'   => 'Podría crear nuevo producto en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de producto',
            'slug'          => 'producto.edit',
            'description'   => 'Podría editar un producto en el sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un producto',
            'slug'          => 'producto.show',
            'description'   => 'Ve en detalle cada producto del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar producto',
            'slug'          => 'producto.destroy',
            'description'   => 'Podría eliminar cualquier producto del sistema',
        ]);

        //==============================================//
        //DropdownComprasEgresos
        Permission::create([
            'name'          => 'Navegar dropdown compras y egresos',
            'slug'          => 'dropdown.compraegreso',
            'description'   => 'navega toda la lista de dropdown de compras y egresos',
        ]);

        //Solicitud Compra - DropdownComprasEgresos
        Permission::create([
            'name'          => 'Navegar solicitudes de compra',
            'slug'          => 'solicitudcompra.index',
            'description'   => 'Lista y navega todas las solicitudes de compra',
        ]);

        Permission::create([
            'name'          => 'Creación de solicitud de compra',
            'slug'          => 'solicitudcompra.create',
            'description'   => 'Podría crear nueva solicitud de compra en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de solicitud de compra',
            'slug'          => 'solicitudcompra.edit',
            'description'   => 'Podría editar una solicitud de compra en el sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un solicitud de compra',
            'slug'          => 'solicitudcompra.show',
            'description'   => 'Ve en detalle cada solicitud de compra del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar solicitud de compra',
            'slug'          => 'solicitudcompra.destroy',
            'description'   => 'Podría eliminar cualquier solicitud de compra del sistema',
        ]);

        //Factura y Detalles - DropdownComprasEgresos
        Permission::create([
            'name'          => 'Navegar facturas y detalles',
            'slug'          => 'factura.index',
            'description'   => 'Lista y navega todas las facturas y detalles',
        ]);

        Permission::create([
            'name'          => 'Edición de factura y detalle',
            'slug'          => 'factura.edit',
            'description'   => 'Podría editar una factura o un detalle de compra en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar factura y su detalle',
            'slug'          => 'factura.destroy',
            'description'   => 'Podría eliminar cualquier factura y su detalle del sistema',
        ]);

        //pdf Comprobante de Compra - Factura y Detalles
        Permission::create([
            'name'          => 'Ver PDF comprobante de compra',
            'slug'          => 'pdf.comprobantecompra',
            'description'   => 'Podría generar comprobante de compra',
        ]);

        //Egreso de Producto - DropdownComprasEgresos
        Permission::create([
            'name'          => 'Navegar egresos de productos',
            'slug'          => 'egreso.index',
            'description'   => 'Lista y navega todos los egresos de productos',
        ]);

        Permission::create([
            'name'          => 'Creación de egresos de productos',
            'slug'          => 'egreso.create',
            'description'   => 'Podría crear nuevo egreso de productos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de egreso de productos',
            'slug'          => 'egreso.edit',
            'description'   => 'Podría editar un egreso de productos en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar egreso de productos',
            'slug'          => 'egreso.destroy',
            'description'   => 'Podría eliminar un egreso de productos y su detalle en el sistema',
        ]);

        //pdf Comprobante de Entrega de Productos - Egreso de Producto
        Permission::create([
            'name'          => 'Ver PDF comprobante de egreso de productos',
            'slug'          => 'pdf.comprobanteegreso',
            'description'   => 'Podría generar comprobante de egreso de productos',
        ]);

        //Preventivos - DropdownComprasEgresos
        Permission::create([
            'name'          => 'Navegar preventivos',
            'slug'          => 'preventivo.index',
            'description'   => 'Lista y navega todos los preventivos',
        ]);

        Permission::create([
            'name'          => 'Creación de preventivos',
            'slug'          => 'preventivo.create',
            'description'   => 'Podría crear nuevo preventivo en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de preventivo',
            'slug'          => 'preventivo.edit',
            'description'   => 'Podría editar un preventivo en el sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar preventivo',
            'slug'          => 'preventivo.destroy',
            'description'   => 'Podría eliminar cualquier preventivo del sistema',
        ]);

        //pdf Preventivo - Preventivos
        Permission::create([
            'name'          => 'Ver PDF preventivo',
            'slug'          => 'pdf.preventivo',
            'description'   => 'Podría generar documento de preventivo',
        ]);

        //Proveedor - DropdownComprasEgresos
        Permission::create([
            'name'          => 'Navegar proveedores',
            'slug'          => 'proveedor.index',
            'description'   => 'Lista y navega todos los proveedores',
        ]);

        Permission::create([
            'name'          => 'Creación de proveedor',
            'slug'          => 'proveedor.create',
            'description'   => 'Podría crear nuevo proveedor en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de proveedor',
            'slug'          => 'proveedor.edit',
            'description'   => 'Podría editar un proveedor en el sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un proveedor',
            'slug'          => 'proveedor.show',
            'description'   => 'Ve en detalle cada proveedor del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar proveedor',
            'slug'          => 'proveedor.destroy',
            'description'   => 'Podría eliminar cualquier proveedor del sistema',
        ]);

        //==============================================//
        //DropdownCategoriasProgramaticas
        Permission::create([
            'name'          => 'Navegar dropdown de categorias programaticas',
            'slug'          => 'dropdown.categoriaprogramatica',
            'description'   => 'navega toda la lista de dropdown de categorias programaticas',
        ]);

        //Proyectos - DropdownCategoriasProgramaticas
        Permission::create([
            'name'          => 'Navegar proyectos',
            'slug'          => 'proyecto.index',
            'description'   => 'Lista y navega todos los proyectos',
        ]);

        Permission::create([
            'name'          => 'Creación de proyecto',
            'slug'          => 'proyecto.create',
            'description'   => 'Podría crear nuevo proyecto en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de proyecto',
            'slug'          => 'proyecto.edit',
            'description'   => 'Podría editar un proyecto en el sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de un proyecto',
            'slug'          => 'proyecto.show',
            'description'   => 'Ve en detalle cada proyecto del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar proyecto',
            'slug'          => 'proyecto.destroy',
            'description'   => 'Podría eliminar cualquier proyecto del sistema',
        ]);

        //Partidas - DropdownCategoriasProgramaticas
        Permission::create([
            'name'          => 'Navegar partidas',
            'slug'          => 'partida.index',
            'description'   => 'Lista y navega todas las partidas',
        ]);

        Permission::create([
            'name'          => 'Creación de partida',
            'slug'          => 'partida.create',
            'description'   => 'Podría crear nueva partida en el sistema',
        ]);

        Permission::create([
            'name'          => 'Edición de partida',
            'slug'          => 'partida.edit',
            'description'   => 'Podría editar una partida en el sistema',
        ]);

        Permission::create([
            'name'          => 'Ver detalle de una partida',
            'slug'          => 'partida.show',
            'description'   => 'Ve en detalle cada partida del sistema',
        ]);

        Permission::create([
            'name'          => 'Eliminar partida',
            'slug'          => 'partida.destroy',
            'description'   => 'Podría eliminar cualquier partida del sistema',
        ]);

        //==============================================//
        //DropdownReportes
        Permission::create([
            'name'          => 'Navegar dropdown de reportes',
            'slug'          => 'dropdown.reportes',
            'description'   => 'navega toda la lista de dropdown de reportes del sistema',
        ]);

        //Reporte de ingreso de articulo por fecha
        Permission::create([
            'name'          => 'Ver reporte ingreso de articulos por fecha',
            'slug'          => 'reporte.ingresoarticulo_porfecha',
            'description'   => 'Podría generar reporte de ingreso de articulo por fechas',
        ]);

        //Reporte de proveedores por fecha
        Permission::create([
            'name'          => 'Ver reporte proveedores por fecha',
            'slug'          => 'reporte.proveedores_porfecha',
            'description'   => 'Podría generar reporte de proveedores por fechas',
        ]);

        //Reporte de egresos de productos por fecha
        Permission::create([
            'name'          => 'Ver reporte egreso de productos por fecha',
            'slug'          => 'reporte.egresoproducto_porfecha',
            'description'   => 'Podría generar reporte de egresos de productos por fechas',
        ]);

        //Reporte de egresos de productos por oficinas
        Permission::create([
            'name'          => 'Ver reporte egreso de productos por oficinas',
            'slug'          => 'reporte.egresoproducto_poroficina',
            'description'   => 'Podría generar reporte de egresos de productos por oficinas',
        ]);

        //Reporte saldo de productos
        Permission::create([
            'name'          => 'Ver reporte de saldo de productos',
            'slug'          => 'reporte.saldoproducto',
            'description'   => 'Podría generar reporte de saldo de productos',
        ]);

        //Reporte saldo por categoria
        Permission::create([
            'name'          => 'Ver reporte de saldo por categoria',
            'slug'          => 'reporte.saldocategoria',
            'description'   => 'Podría generar reporte de saldo por categoria',
        ]);

        //Reporte articulo en stock
        Permission::create([
            'name'          => 'Ver reporte de articulo en stock',
            'slug'          => 'reporte.articulostock',
            'description'   => 'Podría generar reporte de articulo en stock',
        ]);

        //Reporte articulo egresado
        Permission::create([
            'name'          => 'Ver reporte de articulo egresado',
            'slug'          => 'reporte.articuloegresado',
            'description'   => 'Podría generar reporte de articulo egresado',
        ]);
    }
}
