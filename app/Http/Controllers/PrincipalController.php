<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Mail;

class PrincipalController extends Controller {
	
	public function verPrincipal() {
		$chefs = DB::table('chef')->get();

		$datos=array();
		
		for($i = 0 ; $i < count($chefs); $i++){

		    $fotos  = DB::table('foto')->where('id_chef', '=',$chefs[$i]->id)
		    						   ->where('descripcion', '=','imgPerfil')->get();
		    if (!empty($fotos)){
	 			$datos[$i]['foto']=$fotos[0]->imagen;
		 	}else{
		 	 	$datos[$i]['foto']= null;
		 	}

	 		$users  = DB::table('usuarios')->where('id', '=', $chefs[$i]->id_usuario)->get();
	 		$datos[$i]['nombre']=$users[0]->nombre;
	 		$datos[$i]['ruta']="chef/" . $chefs[$i]->id;
	 		$datos[$i]['id']=$chefs[$i]->id;
	 		//print_r('///');
	 		//print_r($datos[$i]);
	 	}

		$desc = array ('datos' => $datos);
		// print_r($da);

		return view('Principal', $desc);
	}
  
  
	public function verBusqueda (Request $datoscliente){
		  
		$personas=$datoscliente->input('boton1');
		$tipo=$datoscliente->input('boton2');
		$es=$datoscliente->input('boton3');
		$comida=$datoscliente->input('boton4');
		$alergia=$datoscliente->input('boton6');
		$cocina=$datoscliente->input('boton7');
		$horno=$datoscliente->input('boton8');
		$ciudad=$datoscliente->input('ciudad');
		$direccion=$datoscliente->input('direccion');
		$fecha=$datoscliente->input('fecha');
		//print_r($personas);
		//print_r($tipo);
		//print_r($es);
		//print_r($comida);
		/*print_r($alergia);
		print_r($cocina);
		print_r($horno);*/
		//print_r($ciudad);
		//print_r($direccion);
		//print_r($fecha);
		
	
	  	$chefs  = DB::table('chef')->where('personas', '<=', $personas)
				->where('cocina','=',$comida)
				->where('comida','=',$es)
				->where('ciudad','=',$ciudad)
            
            ->get();
		    
	  	$datos=array();
	
	  	
		for ($i = 0 ; $i < count($chefs); $i++){

      	    $fotos  = DB::table('foto')->where('id_chef', '=',$chefs[$i]->id)
      	    						   ->where('descripcion', '=','imgPerfil')->get();
      	    if (!empty($fotos)){
 		 		$datos[$i]['foto']=$fotos[0]->imagen;
 		 	}else{
 		 	 	$datos[$i]['foto']= null;
 		 	}

	 		$users  = DB::table('usuarios')->where('id', '=', $chefs[$i]->id_usuario)->get();
	 		$datos[$i]['nombre']=$users[0]->nombre;
	 		$datos[$i]['ruta']= action('ChefController@mostrarChef', $chefs[$i]->id);
	 		$datos[$i]['id']=$chefs[$i]->id;
 		 	
 		}

		$desc = array ('datos' => $datos);

		return view('Principal', $desc);  
	}

	public function verValorados (){
	  
		$chefs  = DB::table('puntuacion')->where('puntuacion', '>=', '3')->get();
	 
	
	  	$datos=array();
		for ($i = 0 ; $i < count($chefs); $i++){

      	    $fotos  = DB::table('foto')->where('id_chef', '=',$chefs[$i]->id_chef)
      	    						   ->where('descripcion', '=','imgPerfil')->get();
			 $chef= DB::table('chef')->where('id', '=', $chefs[$i]->id_chef)->get();
									   
      	    if (!empty($fotos)){
 		 		$datos[$i]['foto']=$fotos[0]->imagen;
 		 	}else{
 		 	 	$datos[$i]['foto']= null;
 		 	}
			   
			/*print_r($chefs);
			print_r($fotos);
			print_r($chef);*/
	 		$users  = DB::table('usuarios')->where('id', '=', $chef[0]->id_usuario)->get();
	 		$datos[$i]['nombre']=$users[0]->nombre;
	 		$datos[$i]['ruta']= action('ChefController@mostrarChef', $chefs[$i]->id);
	 		$datos[$i]['id']=$chefs[$i]->id;
 		 	
 		}

		$desc = array ('datos' => $datos);
		//print_r($desc);
		return view('Principal', $desc);

	}
}

?>
