@extends('layouts.principal')

@section('title') Iniciar sesión @stop

@section('content')

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			</button>
			<a class="navbar-brand" href="http://www.mychef.cat">MyChef</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opciones <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a data-toggle="modal" href="#passwordOlvidada">He olvidado mi contraseña</a></li>
						<li><a data-toggle="modal" href="#codigoActivacion">Reenviar e-mail de activación</a></li>
						<li><a data-toggle="modal" href="#crearCuenta">Crear nueva cuenta</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class='col-lg-4 col-lg-offset-4'>

    @if ($errors->has())
        @foreach ($errors->all() as $error)
			<p>&nbsp;</p>
            <div class='bg-danger alert fade in'>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ $error }}
			</div>
        @endforeach
    @endif

	<!-- Avisos satisfactorios -->

	@if ($creada == 1)
		<p>&nbsp;</p>
		<div class='bg-success alert fade in'>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			La cuenta ha sido creada satisfactoriamente.
			Hemos enviado un e-mail a la dirección de correo electrónico especificada con instrucciones sobre cómo activar su cuenta.
		</div>
	@endif

	@if (session()->has('creada'))
		@if(session('creada') == 1)
			<p>&nbsp;</p>
			<div class='bg-success alert fade in'>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				La cuenta ha sido creada satisfactoriamente.
				Hemos enviado un e-mail a la dirección de correo electrónico especificada con instrucciones sobre cómo activar su cuenta.
			</div>
		@endif
	@endif

	@if (session()->has('activada'))
		@if(session('activada') == 1)
			<p>&nbsp;</p>
			<div class='bg-success alert fade in'>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				La cuenta ha sido activada satisfactoriamente. Ya puedes iniciar sesión.
			</div>
		@endif
	@endif

	@if (session()->has('reestablecer'))
		@if(session('reestablecer') == 1)
			<p>&nbsp;</p>
			<div class='bg-success alert fade in'>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				Su contraseña ha sido cambiada satisfactoriamente. Ya puedes iniciar sesión con los nuevos datos.
			</div>
		@elseif(session('reestablecer') == 2)
			<p>&nbsp;</p>
			<div class='bg-success alert fade in'>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				Hemos enviado un e-mail a la dirección de correo electrónico con la que se registró con instrucciones sobre cómo reestablecer su contraseña.
			</div>
		@endif
	@endif

	@if (session()->has('reenviar'))
		@if(session('reenviar') == 1)
			<p>&nbsp;</p>
			<div class='bg-success alert fade in'>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				Hemos reenviado el e-mail de activación a la dirección de correo electrónico de la cuenta especificada. Si aún así no le ha llegado, contacte con un administrador del sitio para resolver el problema.
			</div>
		@endif
	@endif

    <h1><font size="7"><i class='fa fa-lock'></i></font> Iniciar sesión</h1>

    <form method="POST" action="http://www.mychef.cat/login">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class='form-group'>
		<label name="nombre">Usuario:</label>
		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
			<input type="text" class="form-control" placeholder="Ej: pepe" name="nombre" value="{{ old('nombre') }}">
		</div>
    </div>

    <div class='form-group'>
        <label name="password">Contraseña:</label>
		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
			<input type="password" class="form-control" placeholder="*********" name="password" id="password" value="">
		</div>
    </div>

	<div class='form-group'>
		<input type="checkbox" value="si" name="recordar"> Recordar sesión
	</div>

	<a data-toggle="modal" href="#passwordOlvidada"><i class="fa fa-exclamation-circle"></i> He olvidado mi contraseña.</a>
	<p></p>
	<a data-toggle="modal" href="#codigoActivacion"><i class="fa fa-info-circle"></i> Reenviar e-mail de activación.</a>
	<p></p>
    <div class='form-group'>
		<button type="submit" class="btn btn-primary">Entrar</button><a data-toggle="modal" href="#crearCuenta" class="btn btn-default pull-right">Crear nueva cuenta</a>
    </div>


    </form>

</div>

<!-- Menú de creación de una nueva cuenta de usuario -->

<div class="modal fade" id="crearCuenta" tabindex="-1" role="dialog" aria-labelledby="crearCuentaUsuario" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="http://www.mychef.cat/registrarse" name="formularioCuenta" method="POST" accept-charset="utf-8">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Crear nueva cuenta</h4>
				</div>
				<div class="modal-body">
					<fieldset>
						<h5>Nombre de usuario:</h5>
						<p><input type="text" class="form-control" name="nombrereg" value="" placeholder="Nombre de usuario" id="nombrereg" size="15" maxlength="15"></p>
						<p>&nbsp;</p>
						<h5>Dirección de correo electrónico:</h5>
						<p><input type="text" class="form-control" name="email" value="" placeholder="email@dominio.com" id="email" size="40" maxlength="40"></p>
						<p>&nbsp;</p>
						<h5>Contraseña:</h5>
						<p><input type="password" class="form-control" name="password" value="" size="40" maxlength="40"/></p>
						<p>&nbsp;</p>
						<h5>Repita la contraseña:</h5>
						<p><input type="password" class="form-control" name="password_confirmada" value="" size="40" maxlength="40"/></p>
						<p>&nbsp;</p>
						<h5>Código de verificación:</h5>
						<p>{!! Captcha::img(); !!}</p>
						<p><input type="text" class="form-control" name="captcha" value="" placeholder="Introduzca el código de verificación aquí" id="captcha" size="40" maxlength="40"></p>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<input type="submit" name="submit" value="Crear cuenta" class="btn btn-primary"/>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Menú de reestablecimiento de contraseña -->

<div class="modal fade" id="passwordOlvidada" tabindex="-1" role="dialog" aria-labelledby="reestablecerContra" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="http://www.mychef.cat/reestablecer" name="formularioContraOlvidada" method="POST" accept-charset="utf-8">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Reestablecer contraseña</h4>
				</div>
				<div class="modal-body">
					<fieldset>
						<h5>Nombre de usuario o dirección de correo electrónico:</h5>
						<p><input type="text" class="form-control" name="nombreomail" value="" placeholder="ejemplo@dominio.com" id="nombrereg" size="40" maxlength="40"></p>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<input type="submit" name="submit" value="Reestablecer contraseña" class="btn btn-primary"/>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Menú para reenviar el código de activación -->

<div class="modal fade" id="codigoActivacion" tabindex="-1" role="dialog" aria-labelledby="reestablecerContra" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="http://www.mychef.cat/reenviar" name="formularioCodigoActivacion" method="POST" accept-charset="utf-8">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Reenviar e-mail de activación</h4>
				</div>
				<div class="modal-body">
					<fieldset>
						<h5>Nombre de usuario o dirección de correo electrónico:</h5>
						<p><input type="text" class="form-control" name="nombreomail" value="" placeholder="ejemplo@dominio.com" id="nombrereg" size="40" maxlength="40"></p>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<input type="submit" name="submit" value="Continuar" class="btn btn-primary"/>
				</div>
			</form>
		</div>
	</div>
</div>

@stop
