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

class FacturaController extends Controller {
	
	public function verFactura($id) {
		//print_r($id);
		if(Auth::check()){
			$idchef=$id;
			$chef= DB::table('chef')->where('id', '=', $idchef)->get();
			$idchefuser=$chef[0]->id_usuario;
			$userchef= DB::table('usuarios')->where('id', '=', $idchefuser)->get();
			$idusuario= Auth::user()->id;
			$usuario= DB::table('usuarios')->where('id', '=', $idusuario)->get();
			$desc = array ('userchef' => $userchef[0],'usuario'=>$usuario[0]);					 	
			return view('facturas',$desc);
		}
		return redirect()->action('LoginController@verLanding');
	}


	public function contratoChef(Request $datoscliente) {	
		/*******direccion de contratacion del usuario****/
	    $idusuario= Auth::user()->id;
		$alias = $datoscliente->input('alias');
		$ciudad = $datoscliente->input('ciudad');
		$poblacion = $datoscliente->input('poblacion');
		$direccion = $datoscliente->input('calle');
		$codigo= $datoscliente->input('codigo');
		/*******datos usuarios ******/
		$nombre = $datoscliente->input('nombre');
		$dni = $datoscliente->input('dni');
		$email = $datoscliente->input('email');
		$fecha = $datoscliente->input('fecha');
		$chef= $datoscliente->input('chef');
		$menu=$datoscliente->input('menu2');
		/******metodo de pago del usuario*****/
		$tipo = $datoscliente->input('tipo');
		$numero = $datoscliente->input('numero');
		$cadu = $datoscliente->input('cadu');
		$titular = $datoscliente->input('titular');
		$cvc= $datoscliente->input('cvc');
		/*********consultas para poder saber los datos del cliente y del chef antes de hacer el inser ya que adria me esta mirando mal ! -->*****/
	    $usuariochef= DB::table('usuarios')->where('nombre', '=', $chef)->get();
	    $idusuariochef=$usuariochef[0]->id;
	    /***datos para el contrato*/

		$idechef= DB::table('chef')->where('id_usuario', '=', $idusuariochef)->get();

		$idcliente= DB::table('cliente')->where('id_usuario', '=', $idusuario)->get();
		/***introduciendo datos del contrato*****/
		//actualizando la ciudad de facturacion del cliente
		DB::table('usuarios')
            ->where('id','=',$idusuario)
            ->update(array('alias' => $alias, 'ciudad' => $ciudad, 'poblacion' => $poblacion, 'direccion' => $direccion,'codigo_postal'=> $codigo));
		/*******/
		//introduciendo en la tabla contratos los datos del contrato 
		DB::table('contrato')
            ->insert(array('fecha' => $fecha, 'id_chef' => $idechef[0]->id, 'id_cliente' => $idcliente[0]->id, 'id_menu' => $menu, 'metodo' => $tipo));

		/*******/
		//insertamos el metodo de pago del cliente 
		$cpagos=DB::table('pagos')->where('id_cliente', '=', $idcliente[0]->id)->get();
		//print_r($cpagos);

		if(empty($cpagos)){
		DB::table('pagos')
        ->insert(array('id_cliente' => $idcliente[0]->id, 'tipo' => $tipo, 'numero' => $numero, 'fecha' => $cadu, 'cvc' => $cvc));

    	 	}
			else
			{
				DB::table('pagos')
            ->where('id_cliente','=',$idcliente[0]->id)
            ->update(array('id_cliente' => $idcliente[0]->id, 'tipo' => $tipo, 'numero' => $numero, 'fecha' => $cadu,'cvc'=> $cvc));
			}

    	 	return redirect()->action('PerfilController@verPerfil')->withInput()->withErrors('El contrato se ha realizado correctamente');
	}

}

?>