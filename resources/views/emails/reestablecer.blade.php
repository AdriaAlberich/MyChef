<!DOCTYPE html>
<html lang=&quot;es-ES&quot;>
    <head>
		<meta charset=&quot;utf-8&quot;>
    </head>
    <body>
		<h2>Reestablecer contraseña de la cuenta '{{ $cuenta }}'</h2>
		<div>
			<p><i>(Este mensaje se ha generado automaticamente. Por favor, no lo conteste.)</i></p>
			<p>Hemos recibido su solicitud de reestablecimiento de contraseña para su cuenta en nuestro <b>sistema</b>, 
			para verificar su identidad y poder reestablecer su contraseña, haga click en el siguiente enlace y siga las instrucciones:</p>
			<p>http://www.mychef.cat/login/reestablecer/{{ $codigo_reestablecimiento }}</p>
			<p>Si usted no ha pedido reestablecer su contraseña, simplemente ignore este mensaje.</p>
			<p>&nbsp;</p>
			<hr>
			<h4><i>Atentamente, el equipo de MyChef.</i></h4>
		</div>
	</body>
</html>