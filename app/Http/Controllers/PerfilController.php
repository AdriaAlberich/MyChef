<?php
namespace App\Http\Controllers;

// require_once 'phpmailer/PHPMailerAutoload.php'; //Cargamos la clase de PHPMailer

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Mail;

class PerfilController extends Controller {
	
	
	public function verPerfil() {

		$idusuario= 0;
		$usuario  =array(); 
		$cliente =array();
		$idcliente=0;
		$idciudad=0;
		$ciudad  = array();
		$contratos =array();
		$pagos = array();
		$idpago=0;
		$nombrepago=array();
		$es=0;
		/*print_r($usuario);
		print_r($cliente);
		print_r($idcliente);
		print_r($idciudad);
		print_r($ciudad);
		print_r($contratos);
		print_r($pagos);
		print_r($idpago);
		print_r($nombrepago);
		print_r($es);*/
		if(Auth::check()){
			$idusuario= Auth::user()->id;
			$usuario  = DB::table('usuarios')->where('id', '=', $idusuario)->get();
			$es=$usuario[0]->chef;
			//comrpuebo si el usuario es cliente o chef.
		
			
			if($es==0){
				//obtengo la id del cliente para poder acceder a sus datos 
				$cliente = DB::table('cliente')->where('id_usuario', '=', $idusuario)->get();
		        $idcliente=$cliente[0]->id;
		        //consultamos en la tabla contratos
		        $contratos = DB::table('contrato')->where('id_cliente', '=', $idcliente)->get();
				//compruevo que el campo ciudad contiene datos
				if(!empty($usuario[0]->ciudad))
				{
					//obtengo la id de la ciudad para poder acceder a su nombre 
					$idciudad=$usuario[0]->ciudad;
					$ciudad  = DB::table('ciudades')->where('id', '=', $idciudad)->get();	
				}
				//comprovamos la consulta der la tabla contratos para ver si hay error
				if(!empty($contratos)){
					$pagos = DB::table('pagos')->where('id_cliente', '=', $idcliente)->get();	
				
					$idpago=$pagos[0]->tipo;
					$nombrepago=DB::table('tarjeta')->where('id', '=', $idpago)->get();	
				}
		
				if(!empty($ciudad))
				{
			  		if(!empty($contratos)){
							  
						$desc = array ('usuario' => $usuario[0],'cliente'=>$cliente[0],'ciudad'=>$ciudad[0],'nombrepago'=>$nombrepago[0]);
				  		
				  		return view('panel',['contratos'=>$contratos],['pagos'=>$pagos])->with($desc);
		  			}else{
							  
						$desc = array ('usuario' => $usuario[0],'cliente'=>$cliente[0],'ciudad'=>$ciudad[0],'nombrepago'=>$nombrepago);
						
						return view('panel',['contratos'=>$contratos],['pagos'=>$pagos])->with($desc);
					}
				}else{
					$desc = array ('usuario' => $usuario[0],'cliente'=>$cliente[0]);
					
					return view('panel',['contratos'=>$contratos],['pagos'=>$pagos],['nombrepago'=>$nombrepago],['ciudad'=>$ciudad])->with($desc);
				}
			}else{
				//comprovamos los datos del chef 
				$chefc = DB::table('chef')->where('id_usuario', '=', $idusuario)->get();
				$chefcli=DB::table('cliente')->where('id_usuario', '=', $idusuario)->get();
			
		        $idchef=$chefc[0]->id;
		        $idciudad=$usuario[0]->ciudad;
		  
				if(!empty($idciudad)){
					//consultamos el nombre de la ciudad del chef 
					$ciudad  = DB::table('ciudades')->where('id', '=', $idciudad)->get();
		        }
				//consultamos si el chef tiene contratos
				if(!empty($chefcli)) {
					$contratos = DB::table('contrato')->where('id_cliente', '=', $chefcli[0]->id)->get();
				}
				if(!empty($contratos)){
					if(empty($usuario[0]->ciudad)){
						
						$desc = array ('usuario' => $usuario[0],'ciudad'=>$ciudad,);
						
						return view('panel',['contratos'=>$contratos],['pagos'=>$pagos],['nombrepago'=>$nombrepago],['ciudad'=>$ciudad], ['chef' => $chefc])->with($desc);
					}else{
						/*$pagos = DB::table('pagos')->where('id_cliente', '=', $chefcli[0]->id)->get();	
				
								$idpago=$pagos[0]->tipo;
								$nombrepago=DB::table('tarjeta')->where('id', '=', $idpago)->get();*/
						$desc = array ('usuario' => $usuario[0],'ciudad'=>$ciudad[0],);
						
						return view('panel',['contratos'=>$contratos],['pagos'=>$pagos],['nombrepago'=>$nombrepago],['ciudad'=>$ciudad], ['chef' => $chefc])->with($desc);
					
					/*$desc = array ('usuario' => $usuario[0],'cliente'=>$cliente[0],'ciudad'=>$ciudad[0],'nombrepago'=>$nombrepago);
						
						return view('panel',['contratos'=>$contratos],['pagos'=>$pagos])->with($desc);*/
					}
				}
				if(!empty($usuario[0]->ciudad)){
					$desc = array ('usuario' => $usuario[0],'cliente'=>$cliente,'ciudad'=>$ciudad[0]);
					return view('panel',['contratos'=>$contratos],['pagos'=>$pagos],['nombrepago'=>$nombrepago], ['chef' => $chefc])->with($desc);
				}else{
					
					$desc = array ('usuario' => $usuario[0],'cliente'=>$cliente);
					return view('panel',['contratos'=>$contratos],['pagos'=>$pagos],['nombrepago'=>$nombrepago],['ciudad'=>$ciudad], ['chef' => $chefc])->with($desc);
				}
			}
		}
		
	return view('landing'); 

	}


	/******************************************************/
	public function cambiarDir(Request $datoscliente) {
		$idusuario= Auth::user()->id;
		$alias = $datoscliente->input('alias');
		$ciudad = $datoscliente->input('ciudad');
		$poblacion = $datoscliente->input('poblacion');
		$direccion = $datoscliente->input('direccion');
		$codigo_postal = $datoscliente->input('codigo_postal');
		if(empty($alias))
			return back()->withErrors('El campo Alias Esta vacio.');
		if(empty($ciudad))
			return back()->withErrors('El campo Ciudad Esta vacio.');
		if(empty($poblacion))
			return back()->withErrors('El campo poblacion Esta vacio.');
		if(empty($direccion))
			return back()->withErrors('El campo direccion Esta vacio.');
		if(empty($codigo_postal))
			return back()->withErrors('El campo Codigo Postal Esta vacio.');
			
		DB::table('usuarios')
            ->where('id','=',$idusuario)
            ->update(array('alias' => $alias, 'ciudad' => $ciudad, 'poblacion' => $poblacion, 'direccion' => $direccion,'codigo_postal'=> $codigo_postal));
		return back();
	}


	/************************************/

	public function cambiarPass(Request $datoscliente) {
		$idusuario= Auth::user()->id;
		$pass1 = $datoscliente->input('pass1');
		$pass2 = $datoscliente->input('pass2');
		$pass3 = $datoscliente->input('pass3');
		$usuario  = DB::table('usuarios')->where('id', '=', $idusuario)->get();
		$passvieja= $usuario[0]->password;

		if (Hash::check($pass1, $passvieja))
		{
		  	if(strlen($pass2) < 6 || strlen($pass2) > 40)
				return back()->withInput()->withErrors('La contraseña debe tener una longitud mínima de (6) carácteres y máxima de (40) carácteres.');
			
				if(strcmp($pass2, $pass3))
					return back()->withInput()->withErrors('Las contraseñas no coinciden.');

				DB::table('usuarios')
				    ->where('id','=',$idusuario)
				    ->update(array('password' => Hash::make($pass2)));

				return back();
		}
		return back()->withInput()->withErrors('Las contraseñas no coinciden');
	}


	public function eliminarCuenta(Request $datoscliente){
		$contra=$datoscliente->input('contra');
		$idusuario= Auth::user()->id;
		$cliente  = DB::table('cliente')->where('id_usuario', '=', $idusuario)->get();
		$idcliente=$cliente[0]->id;
		$usuario  = DB::table('usuarios')->where('id', '=', $idusuario)->get();
		$passvieja= $usuario[0]->password;

		if (Hash::check($contra, $passvieja))
		{
			DB::table('usuarios')->where('id', '=',$idusuario )->delete();
			DB::table('cliente')->where('id', '=',$idcliente )->delete();
			DB::table('contrato')->where('id_cliente', '=',$idcliente )->delete();
			DB::table('pagos')->where('id_cliente', '=',$idcliente )->delete();



			Auth::logout(); 
			return view('landing');  

		}

		return back()->withInput()->withErrors('La contraseña no es correcta');
	}



	/************************************/
	public function eliminarContrato($id){
		$idcontrato=$id;
		DB::table('contrato')->where('id', '=',$idcontrato )->delete();
		return back()->withInput()->withErrors('La tabla se ha borrado correctamente');;      
	}



	/*******************************/
	public function eliminarPagos($id){
		$idpagos=$id;
		DB::table('pagos')->where('id', '=',$idpagos )->delete();
		return back()->withInput()->withErrors('La tabla se ha borrado correctamente');;      
	}


	/********************/
	public function modiPagos(Request $datoscliente){
		$tipo=$datoscliente->input('tipo');
		$idusuario= Auth::user()->id;
		$cliente = DB::table('cliente')->where('id_usuario', '=', $idusuario)->get();
		$idcliente=$cliente[0]->id;
		$numero=$datoscliente->input('numero');
		$fecha=$datoscliente->input('fecha');
		$titular=$datoscliente->input('titular');
		$cvc=$datoscliente->input('cvc');
		DB::table('pagos')
            ->where('id_cliente','=',$idcliente)
            ->update(array('id_cliente' => $idcliente, 'tipo' => $tipo, 'numero' => $numero, 'fecha' => $fecha,'cvc'=> $cvc));
		return back()->withInput()->withErrors('Se ha actualizado correctamente su metodo de pago');;
	}

/*****************************************************/
}

?>
