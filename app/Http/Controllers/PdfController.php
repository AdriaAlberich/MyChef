<?php
namespace App\Http\Controllers;

// require_once 'phpmailer/PHPMailerAutoload.php'; //Cargamos la clase de PHPMailer
 // require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade;
use Auth;
use DB;

use Hash;
use Mail;
use PDF;

class PdfController extends Controller {
	
	public function verPdf($id) {
		
		if(Auth::check()){
			//cojo los datos personales del usuario
			$idusuario= Auth::user()->id;
			$usuario  = DB::table('usuarios')->where('id', '=', $idusuario)->get();
			//cojo la id del cliente para poder acceder a todos sus datos 
			$cliente = DB::table('cliente')->where('id_usuario', '=', $idusuario)->get();
			$idcliente=$cliente[0]->id;	
			//accedo a la tabla contratos para saber que tiene contratado 
			$contratos = DB::table('contrato')->where('id', '=', $id)->get();
			$idchef=$contratos[0]->id_chef;
			//averiguo el nombre del chef 
			$nombrechef=DB::table('chef')->where('id', '=', $idchef)->get();
			$nombrechef1=$nombrechef[0]->id_usuario;
			$nombrechef2= DB::table('usuarios')->where('id', '=', $nombrechef1)->get(); 
			$idmenu=$contratos[0]->id_menu;
			
			$menu=DB::table('menu')->where('menu', '=', $idmenu)->get();
			$precio=DB::table('precio')->where('menu', '=', $idmenu)->get();
			$desc = array ('usuario' => $usuario[0],'cliente'=>$cliente[0],'menu'=>$menu[0],'contratos'=>$contratos[0],'nombrechef2'=>$nombrechef2[0],'precio'=>$precio[0]);
			return view('pdf')->with($desc);
			//return view('pdf')->with($desc);
			/*$pdf = PDF::loadView('pdf',$desc);
			return $pdf->stream();*/
		}
		
	}
}

?>