<!DOCTYPE html>
<html lang=&quot;es-ES&quot;>
    <head>
		<meta charset=&quot;utf-8&quot;>
    </head>
    <body>
		<h2>Activación de la cuenta '{{ $cuenta }}'</h2>
		<div>
			<p><i>(Este mensaje se ha generado automaticamente. Por favor, no lo conteste.)</i></p>
			<p><b>Bienvenido a MyChef</b>, para continuar con el registro de su cuenta en nuestro <b>sistema</b>, 
			tendrá que activarla para confirmar que la dirección de correo que especificó al registrarse es válida. Por favor, haga click en el siguiente enlace para activar 
			su cuenta:</p>
			<p>http://www.mychef.cat/login/activar/{{ $codigo_activacion }}</p>
			<p>Si cree que no debería haber recibido este e-mail, simplemente ignórelo.</p>
			<p>&nbsp;</p>
			<hr>
			<h4><i>Atentamente, el equipo de M</i></h4>
		</div>
	</body>
</html>