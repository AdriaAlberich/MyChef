<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Mail;

class LoginController extends Controller {

	public function verLanding() 
	{

		//Comprobamos si es chef, en dicho caso recuperamos sus datos y los mandamos a la vista.
		if(Auth::check()) {
			$chef = DB::table('chef')->where('id_usuario', '=', Auth::user()->id)->get();

			if(!empty($chef)) {
				return view('landing', ['creada' => 0, 'chef' => $chef[0]]);
			}
		}

		//En caso contrario la mostramos normalmente.
		return view('landing', ['creada' => 0, 'chef' => null]);
	}

	public function hacerLogin(Request $peticion) 
	{

		$emailusuario = $peticion->input('email');
		$password = $peticion->input('password');
		$recordarvalor = $peticion->input('recordar');

		//Si pulsamos el botón de entrar y no especificamos un usuario o mail, no hacemos nada
		if(empty($emailusuario))
			return back();

		//Primero comprobaremos que la cuenta a la que estamos intentando acceder existe
		$resultado = DB::table('usuarios')->where('email', '=', $emailusuario)->get();
			
		//Si la cuenta no existe, no hacemos nada
		if(empty($resultado))
			return back()->withInput()->withErrors('El usuario y/o contraseña no son correctos.');

		//Si existe y no está activada, no le permitimos acceder
		if(!empty($resultado) && $resultado[0]->activada == 0)
			return back()->withInput()->withErrors('La cuenta a la que está intentando acceder no está activada.');
			
			//Establecemos el valor de la variable 'recordar' dependiendo de si el usuario quiso recordar su sesión o no
			$recordar = false;

			if($recordarvalor == 'si')
				$recordar = true;

			//Intenamos loguear, vamos a la página de inicio
		if (Auth::attempt(['email' => $emailusuario, 'password' => $password], $recordar))
			{
				$url = action('LoginController@verLanding');
		        return redirect($url)->with('creada', 0);
			}

		//Si no se pudo loguear no hacemos nada y mostramos el mensaje de error
		return back()
		    ->withInput()
		    ->withErrors('El usuario y/o contraseña no son correctos.');
	}

	public function registrarUsuario(Request $peticion)
	{
		//En mantenimiento
		//return back()->withInput()->withErrors('Ahora mismo no puedes crearte una cuenta. Estamos en mantenimiento.');

		$dni = $peticion->input('dni');
		$nombre = $peticion->input('nombre');
		$apellido = $peticion->input('apellido');
		$email = $peticion->input('email');
		$password = $peticion->input('password');
		$password_confirmada = $peticion->input('password_confirmada');
		$captcha = $peticion->input('captcha');
		$reglas_captcha = array('captcha' => ['required', 'captcha']);

		//Primero comprobamos que ya no exista el nombre de usuario
		$resultado = DB::table('usuarios')->where('nombre', '=', $nombre)->get();

		if(!empty($resultado))
			return back()->withInput()->withErrors('El nombre de usuario especificado ya está en uso.');

		//Comprobamos el formato del DNI
		if(!preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $dni))
		{
			return back()
				->withInput()
				->withErrors('El formato del DNI no es correcto, solo se permiten DNI o NIE españoles.');
		}

		//Comprobamos que el dni no exista ya en la base de datos.

		$dniduplicados = DB::table('usuarios')->where('dni', '=', $dni)->get();

		if(!empty($dniduplicados))
			return back()->withInput()->withErrors('El DNI introducido ya está en uso.');

		//Comprobamos que la dirección de correo electrónico sea válida
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			return back()->withInput()->withErrors('La dirección de correo electrónico no es válida.');

		//Comprobamos que la dirección de correo electrónico no esté en uso por otra cuenta
		$resultado = DB::table('usuarios')->where('email', '=', $email)->get();

		if(!empty($resultado))
			return back()->withInput()->withErrors('La dirección de correo electrónico especificada ya está en uso.');

		//Comprobamos que las contraseñas sean iguales y tengan una longitud mínima
		if(strlen($password) < 6 || strlen($password) > 40)
			return back()->withInput()->withErrors('La contraseña debe tener una longitud mínima de (6) carácteres y máxima de (40) carácteres.');

		//Comprobamos que las contraseñas introducidas sean iguales
		if(strcmp($password, $password_confirmada))
			return back()->withInput()->withErrors('Las contraseñas no coinciden.');

		//Comprobamos que el captcha sea correcto
		$validador_captcha = Validator::make(['captcha' => $captcha], $reglas_captcha, ['captcha' => 'El código de verificación introducido no es válido.']);

		if(!$validador_captcha->passes())
			return back()->withInput()->withErrors($validador_captcha);

		//Creamos la cuenta
		$codigo_activacion = md5(gmdate('Y-m-d h:i:s \G\M\T')); //Generamos el código de activación
		DB::insert('insert into usuarios (dni, nombre, apellidos, email, password, admin, remember_token, created_at, updated_at, activada, codigo_activacion, codigo_reestablecimiento) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			[$dni, $nombre, $apellido, $email, Hash::make($password), 0, null, gmdate('Y-m-d h:i:s \G\M\T'), gmdate('Y-m-d h:i:s \G\M\T'), 1, $codigo_activacion, " "]);

		//Comprobamos que se haya creado la cuenta
		$resultado = DB::table('usuarios')->where('nombre', '=', $nombre)->get();

		/* Si se creó, devolvemos un aviso diciendo que la cuenta fue creada
		   y enviamos el mail de verificación para activar la cuenta */

		if(!empty($resultado))
		{	
			//Enviamos el mail de verificación
			$data = ['cuenta' => $nombre, 'codigo_activacion' => $codigo_activacion];
			Mail::send('emails.activacion', $data, function($message) use ($email, $nombre)
			{
				$message->to($email, '')->subject('[MY CHEF] Activación de la cuenta \'' . $nombre . '\'');
			});

			//Volvemos a la página de iniciar sesión, informamos al usuario
			return redirect('')->with('creada', 1);
		}

		//No se creó, devolvemos un error
		return back()->withInput()->withErrors('No se pudo crear la cuenta. Inténtelo más tarde.');
	}

	public function activarUsuario($codigo)
	{
		//Si el código no es válido, abortamos
		if(strlen($codigo) < 32 || strlen($codigo) > 32)
			return redirect('')->withErrors('El código de activación especificado no es válido.');

		//Primero comprobamos que el código de activación exista en la base de datos
		$resultado = DB::table('usuarios')->where('codigo_activacion', '=', $codigo)->get();

		if(empty($resultado))
			return redirect('')->withErrors('El código de activación especificado no existe.');

		//Si existe, activamos la cuenta
		DB::update('update usuarios set activada = 1, codigo_activacion = \'\' where id = ?', [$resultado[0]->id]);

		//Vamos a la página de login y avisamos al usuario de que fue activada
		return redirect('')->with('activada', 1);
	}

	public function reestablecerPassword(Request $peticion)
	{
		//En mantenimiento
		//return back()->withInput()->withErrors('Función deshabilitada temporalmente. Estamos en mantenimiento.');

		$email = $peticion->input('email');

		//Campo vacío, volvemos atrás
		if(empty($email))
			return back();

		//Comprobamos que exista el usuario o un usuario con dicho e-mail
		$resultado = DB::table('usuarios')->where('email', '=', $email)->get();

		//Si no existe el usuario, error
		if(empty($resultado))
			return back()->withInput()->withErrors('La dirección de correo electrónico no existe en nuestra base de datos.');

		//Existe, generamos un código de reestablecimiento de contraseña
		$codigo_reestablecimiento = md5(gmdate('Y-m-d h:i:s \G\M\T'));

		//Una vez generado, lo insertamos en la base de datos
		DB::update('update usuarios set codigo_reestablecimiento = ? where id = ?', [$codigo_reestablecimiento, $resultado[0]->id]);

		//Enviamos el mail con la dirección para reestablecer la contraseña a una nueva

		$data = ['cuenta' => $resultado[0]->nombre, 'codigo_reestablecimiento' => $codigo_reestablecimiento];
		Mail::send('emails.reestablecer', $data, function($message) use ($resultado)
		{
			$message->to($resultado[0]->email, '')->subject('[MY CHEF] Reestablecer contraseña de la cuenta \'' . $resultado[0]->nombre . '\' (Panel)');
		});

		//Volvemos a la página de iniciar sesión, informamos al usuario de que le hemos enviado el mail
		return redirect('')->with('reestablecer', 2);
	}

	public function formReestablecerPassword($codigo)
	{
		//Si el código no es válido, abortamos
		if(strlen($codigo) < 32 || strlen($codigo) > 32)
			return redirect('')->withErrors('El código de reestablecimiento de contraseña especificado no es válido.');

		//Primero comprobamos que el código de activación exista en la base de datos
		$resultado = DB::table('usuarios')->where('codigo_reestablecimiento', '=', $codigo)->get();

		if(empty($resultado))
			return redirect('')->withErrors('El código de reestablecimiento de contraseña especificado no existe.');

		//Vamos a la página de reestablecimiento
		return view('reestablecer_password', ['usuario' => $resultado[0]->nombre, 'email' => $resultado[0]->email, 'codigo' => $resultado[0]->codigo_reestablecimiento]);
	}

	public function cambiarPassword(Request $peticion)
	{
		$email = $peticion->input('email');
		$codigo_reestablecimiento = $peticion->input('codigo');
		$password = $peticion->input('password');
		$password_confirmada = $peticion->input('password_confirmada');

		//Comprobamos que el usuario y el código de activacion existan
		$resultado = DB::table('usuarios')->where('email', '=', $email)->where('codigo_reestablecimiento', '=', $codigo_reestablecimiento)->get();

		//Si no existe, error
		if(empty($resultado))
			return back()->withInput()->withErrors('El email o código de activación especificado no es válido. N: ' . $email . ' C: ' . $codigo_reestablecimiento);

		//Comprobamos que las contraseñas sean iguales y tengan una longitud mínima
		if(strlen($password) < 6 || strlen($password) > 40)
			return back()->withInput()->withErrors('La contraseña debe tener una longitud mínima de (6) carácteres y máxima de (40) carácteres.');

		//Comprobamos que las contraseñas introducidas sean iguales
		if(strcmp($password, $password_confirmada))
			return back()->withInput()->withErrors('Las contraseñas no coinciden.');

		//Todo válido, procedemos a cambiar la contraseña
		DB::update('update usuarios set password = ?, codigo_reestablecimiento = \'\' where id = ?', [Hash::make($password), $resultado[0]->id]);

		//Volvemos a la página de login informando al usuario
		return redirect('')->with('reestablecer', 1);
	}

	public function reenviarCodigo(Request $peticion)
	{
		//En mantenimiento
		//return back()->withInput()->withErrors('Función deshabilitada temporalmente. Estamos en mantenimiento.');

		$email = $peticion->input('email');

		//Campo vacío, volvemos atrás
		if(empty($email))
			return back();

		//Comprobamos que exista el usuario o un usuario con dicho e-mail
		$resultado = DB::table('usuarios')->where('email', '=', $email)->get();

		//Si no existe el usuario, error
		if(empty($resultado))
			return back()->withInput()->withErrors('La dirección de correo electrónico no existe en nuestra base de datos.');

		//Comprobamos que el usuario tenga un código de activación pendiente y que no tenga la cuenta activada
		if($resultado[0]->activada == 0)
		{
			//Si no tiene un código de activación generado, le generamos uno nuevo
			if(empty($resultado[0]->codigo_activacion))
			{
				$resultado[0]->codigo_activacion = md5(gmdate('Y-m-d h:i:s \G\M\T')); // Generamos el código de activación y lo guardamos en la BD
				DB::insert('update usuarios set codigo_activacion = ? where id = ?', [$resultado[0]->codigo_activacion, $resultado[0]->id]);
			}

			//Enviamos el mail de verificación
			$data = ['cuenta' => $resultado[0]->nombre, 'codigo_activacion' => $resultado[0]->codigo_activacion];
			$email = $resultado[0]->email;
			$nombre = $resultado[0]->nombre;
			Mail::send('emails.activacion', $data, function($message) use ($email, $nombre)
			{
				$message->to($email, '')->subject('[MY CHEF] Activación de la cuenta \'' . $nombre . '\' (Panel)');
			});

			//Volvemos a la página de iniciar sesión, informamos al usuario
			return redirect('')->with('reenviar', 1);
		}

		//Volvemos a la página de iniciar sesión, informamos al usuario de que no se pudo reenviar el e-mail
		return redirect('')->withInput()->withErrors("Esa cuenta ya está activada.");
	}

    public function Login() {

        return redirect('/');
    }

    public function Logout() {

        Auth::logout();;

        return redirect('/');
    }
}

?>
