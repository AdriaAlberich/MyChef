<?php

/*
|--------------------------------------------------------------------------
| Rutas de la aplicación
|--------------------------------------------------------------------------
|
| Aqui se encuentran descritas todas las rutas de la aplicación.
|
*/

//Rutas principales
//Ver página landing
Route::get('', 'LoginController@verLanding');
//Función desloguearse
Route::get('/logout', 'LoginController@Logout');

//Rutas del login
Route::group(['prefix' => 'login'], function () {

	//Ver página landing
	Route::get('', 'LoginController@verLanding');
	//Post del login
	Route::post('', 'LoginController@hacerLogin');
	//Post de registro de usuario
	Route::post('registrarse', 'LoginController@registrarUsuario');
	//Función de activación del usuario
	Route::get('activar/{codigo}', 'LoginController@activarUsuario');
	//Post del formulario de petición de reestablecer contraseña
	Route::post('reestablecer', 'LoginController@reestablecerPassword');
	//Post del formulario de petición de reenviar código de activación
	Route::post('reenviar', 'LoginController@reenviarCodigo');
	//Redirección al formulario de reestablecer contraseña
	Route::get('reestablecer/{codigo}', 'LoginController@formReestablecerPassword');
	//Redirección al formulario de reestablecer contraseña por post.
	Route::post('reestablecer/{codigo}', 'LoginController@formReestablecerPassword');
	//Post del formulario de reestablecer contraseña
	Route::post('cambiarpassword', 'LoginController@cambiarPassword');
});

//Rutas página de perfil del chef
Route::group(['prefix' => 'chef'], function () {
	Route::get('{id_chef}', 'ChefController@mostrarChef');
    Route::post('insertarPerfil', 'ChefController@insertarPerfil'); 
    Route::post('insertarMenu1', 'ChefController@insertarMenu1');
    Route::post('insertarMenu2', 'ChefController@insertarMenu2');
    Route::post('insertarMenu3', 'ChefController@insertarMenu3');
    Route::post('puntuacion', 'ChefController@puntuacion');
    Route::post('opinion', 'ChefController@opinion');
    Route::post('imagenPerfil', 'ChefController@imagenPerfil');
    Route::post('imagenMenu1', 'ChefController@imagenMenu1');
    Route::post('imagenMenu2', 'ChefController@imagenMenu2');
    Route::post('imagenMenu3', 'ChefController@imagenMenu3');
    Route::post('imagenGaleria', 'ChefController@imagenGaleria');
    Route::post('eliminarFotosGaleria', 'ChefController@eliminarFotosGaleria');
});

//Rutas de la página de perfil de usuario
Route::group(['prefix' => 'perfil'], function () {
	//Ver página principal del perfil de usuario
    Route::get('', 'PerfilController@verPerfil');
    //Función cambiar directorio
    Route::post('cambiardir', 'PerfilController@cambiarDir');
	//cambiar la contraseña
	Route::post('cambiarpass', 'PerfilController@cambiarPass');
	//modificar forma de pago 
	Route::post('modipagos', 'PerfilController@modiPagos');
	//eliminar la cuenta
	Route::post('eliminarcuenta', 'PerfilController@eliminarCuenta');
	//elimina la cuenta del ususairo
	Route::get('eliminarcontrato/{id}', 'PerfilController@eliminarContrato');
	//elimina los metodos de pago del usuario 
	Route::get('eliminarpagos/{id}', 'PerfilController@eliminarPagos');

	
});
Route::group(['prefix' => 'principal'], function () {
	//Ver página con todos los chefs que hay en la base de datos
    Route::get('', 'PrincipalController@verPrincipal');
	//devuelve los valores de la bisqueda que se ha realizado 
	Route::post('busqueda', 'PrincipalController@verBusqueda');
	//podemos ver los chefs con la mejor puntuacion 
	Route::get('valorados', 'PrincipalController@verValorados');
    
   
	
});
Route::group(['prefix' => 'contrato'], function () {
	//con esto realizamos la contratacion de un chef 
    Route::get('{id}', 'FacturaController@verFactura');
    Route::post('contratar', 'FacturaController@contratoChef');
    
   
	
});
Route::group(['prefix' => 'pdf'], function () {
	//accedemos a la factura detallada del usuario para poder imprimirla si la necesita 
    Route::get('pdf/{id}', 'PdfController@verPdf');
    
   
	
});


//Rutas del panel admin
Route::group(['prefix' => 'admin'], function () {
	//Ver panel principal
    Route::get('', 'AdminController@verPanelAdmin');
	//Alta chef
	Route::get('altaChef/{id_usuario}', 'AdminController@altaChef');
	//Baja chef
	Route::get('bajaChef/{id_usuario}', 'AdminController@bajaChef');
	//Ver página chef
	Route::get('paginaChef/{id_usuario}', 'AdminController@verPaginaChef');
	//Ver editar chef (desde el panel)
	Route::get('verEditarChef/{id_usuario}', 'AdminController@editarChefPanel');
	//Editar chef (post)
	Route::post('editarChef/{id_chef}', 'AdminController@editarChef');
});