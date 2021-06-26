<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Mail;


class AdminController extends Controller {


	//Muestra el panel de administración
	public function verPanelAdmin() 
	{
		//Comprueba si ésta logueado
		if(Auth::check()) {

			//Coge todos los usuarios paginados cada 10.
			$usuarios = DB::table('usuarios')->paginate(10);

			$chef = DB::table('chef')->where('id_usuario', '=', Auth::user()->id)->get();

			//Si es chef, mandamos los datos del chef a la vista.
			if(!empty($chef)) {
				return view('admin.panel', ['usuarios' => $usuarios, 'chef' => $chef[0]]);
			}

			//Llamamos a la vista del panel pasandole todos los usuarios.
			return view('admin.panel', ['usuarios' => $usuarios]);
		}
		
		return redirect('');
	}

	public function altaChef($id_usuario)
	{

		//Primero comprobamos que exista
		$resultado = DB::table('usuarios')->where('id', '=', $id_usuario)->get();

		if(!empty($resultado)) {
			//Si no es chef lo damos de alta.
			if($resultado[0]->chef == 0) {
				DB::table('usuarios')
	            ->where('id', $id_usuario)
	            ->update(['chef' => 1]);

	        	DB::table('chef')->insert(['id_usuario' => $id_usuario, 'dnichef' => $resultado[0]->dni]);

	        	return back()->with('altachef', true);
			}

			return back()->withErrors('El usuario ya es chef.');
		}
		
		return back()->withErrors('Este usuario no existe.');
	}

	public function bajaChef($id_usuario)
	{
		//Primero comprobamos que exista
		$resultado = DB::table('usuarios')->where('id', '=', $id_usuario)->get();

		if(!empty($resultado)) {
			//Si es chef lo damos de baja.
			if($resultado[0]->chef == 1) {
				DB::table('usuarios')
	            ->where('id', $id_usuario)
	            ->update(['chef' => 0]);

	            $chef = DB::table('chef')->where('id_usuario', '=', $id_usuario)->get();

	            //Eliminamos todos los registros de las tablas relacionadas.
	            if(!empty($chef)) {
	            	try{
	            		DB::table('contrato')->where('id_chef', '=', $chef[0]->id)->delete();
		            	DB::table('foto')->where('id_chef', '=', $chef[0]->id)->delete();
		            	DB::table('menu')->where('id_chef', '=', $chef[0]->id)->delete();
		            	DB::table('precio')->where('id_chef', '=', $chef[0]->id)->delete();
		            	DB::table('puntuacion')->where('id_chef', '=', $chef[0]->id)->delete();
		            	DB::table('receta')->where('id_chef', '=', $chef[0]->id)->delete();
		            	DB::table('video')->where('id_chef', '=', $chef[0]->id)->delete();
		            	DB::table('chef')->where('id', '=', $chef[0]->id)->delete();
	            	}catch(Exception $e) {
	            		return back()->withErrors('No se ha podido dar de baja al chef.');
	            	}

	            	return back()->with('bajachef', true);
	            	
	            }
	        	
			}

			return back()->withErrors('El usuario no es chef.');
		}
		
		return back()->withErrors('El usuario no existe.');
	}

	public function verPaginaChef($id_usuario)
	{
		//Primero comprobamos que exista
		$resultado = DB::table('usuarios')->where('id', '=', $id_usuario)->get();

		if(!empty($resultado)) {
			//Si es chef
			if($resultado[0]->chef == 1) {

	            $chef = DB::table('chef')->where('id_usuario', '=', $id_usuario)->get();

	            //Redireccionamos a la página del chef en cuestión
	            $url = action('ChefController@mostrarChef', $chef[0]->id); 
	            
	        	return redirect($url);
			}

			return back()->withErrors('El usuario no es chef.');
		}
		
		return back()->withErrors('El usuario no existe.');
	}

	public function editarChefPanel($id_usuario)
	{

		//Primero comprobamos que exista
		$resultado = DB::table('usuarios')->where('id', '=', $id_usuario)->get();

		if(!empty($resultado)) {

			//Obtenemos los datos del chef y de los tipos de cocina.
            $chef = DB::table('chef')->where('id_usuario', '=', $id_usuario)->get();

        	$cocinas = DB::table('comida')->get();

        	//Llamamos a la vista de editar chef y le pasamos los datos.
        	return view('admin.editarChef', ['chef' => $chef[0], 'cocinas' => $cocinas]);
		}
		
		return back()->withErrors('Este chef no existe.');
	}

	public function editarChef(Request $peticion, $id_chef)
	{

		//Primero comprobamos que exista
		$resultado = DB::table('chef')->where('id', '=', $id_chef)->get();

		if(!empty($resultado)) {

			//Obtenemos los datos del formulario.
			$cocina = $peticion->input('cocina');
			$personas = $peticion->input('personas');
			$barco = $peticion->input('barco');

			//Procesamos el estado del checkbox de servicio a barcos.
			if($barco == 'barco') {
				$barco = 1;
			}else{
				$barco = 0;
			}

			$precio = $peticion->input('precio');

			//Actualizamos los datos del chef
			DB::table('chef')
            ->where('id', $id_chef)
            ->update(['cocina' => $cocina, 'personas' => $personas, 'barco' => $barco, 'precio' => $precio]);

            //Obtenemos de nuevo lo datos y mostramos la vista con un mensaje informativo.
            $chef = DB::table('chef')->where('id', '=', $id_chef)->get();

        	$cocinas = DB::table('comida')->get();

        	return back()->withInput()->with('editado', true);
		}
		
		return back()->withErrors('Este chef no existe.');
	}

}

?>
