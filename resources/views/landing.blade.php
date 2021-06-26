@extends('layouts.principal')

@section('title') Inicio @stop

@section('content')

	<header>
        <nav class="navbar navbar-inverse navbar-fixed-top barraNav">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://www.mychef.cat">My Chef</a>
                </div>
                <div class="navbar-left">
                    <ul class="nav navbar-nav">
                        <li class="barraNav"><a class="navbar-btn login barraNav" href="{{ action('PrincipalController@verPrincipal') }}"><span class="glyphicon glyphicon-search"></span>&nbsp;Buscar Chef</a></li>
                    </ul>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{Auth::user()->nombre}} <span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="http://www.mychef.cat/perfil">Mi perfil</a></li>
                                @if(isset($chef))
                                    <li><a href="http://www.mychef.cat/chef/{{ $chef->id }}">Mi página</a></li>
                                @endif
                                @if(Auth::user()->admin == 1)
                                    <li><a href="http://www.mychef.cat/admin">Panel admin</a></li>
                                @endif
                                <li class="divider"></li>
                                <li><a href="http://www.mychef.cat/logout">Desconectar</a></li>
                              </ul>
                            </li>
                        @else
                            <li class="barraNav"><a class="navbar-btn login barraNav" href="#" data-toggle="modal" data-target="#conectarseModal">Conectar</a></li>
                            <li class="barraNav"><a class="navbar-btn login barraNav" href="#" data-toggle="modal" data-target="#crearCuentaModal">Registrarse</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @if ($errors->has())
            @foreach ($errors->all() as $error)
                <div class='alert alert-dismissible alert-danger notificacion'>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ $error }}
                </div>
            @endforeach
        @endif

        @if (session()->has('creada'))
            @if(session('creada') == 1)
                <div class='alert alert-dismissible alert-success notificacion'>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    La cuenta ha sido creada satisfactoriamente.<br/>
                    Hemos enviado un e-mail a la dirección de correo electrónico especificada con instrucciones sobre cómo activar su cuenta.
                </div>
            @endif
        @endif  

        @if (session()->has('activada'))
            @if(session('activada') == 1)
                <div class='alert alert-dismissible alert-success notificacion'>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    La cuenta ha sido activada con éxito. Ya puedes iniciar sesión.
                </div>
            @endif
        @endif

        @if (session()->has('reestablecer'))
            @if(session('reestablecer') == 1)
                <div class='alert alert-dismissible alert-success notificacion'>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Su contraseña ha sido cambiada satisfactoriamente. Ya puedes iniciar sesión con los nuevos datos.
                </div>
            @elseif(session('reestablecer') == 2)
                <div class='alert alert-dismissible alert-success notificacion'>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Hemos enviado un e-mail a la dirección de correo electrónico con la que se registró con instrucciones sobre cómo reestablecer su contraseña.
                </div>
            @endif
        @endif

        @if (session()->has('reenviar'))
            @if(session('reenviar') == 1)
                <div class='alert alert-dismissible alert-success notificacion'>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Hemos reenviado el e-mail de activación a la dirección de correo electrónico de la cuenta especificada. Si aún así no le ha llegado, contacte con un administrador del sitio para resolver el problema.
                </div>
            @endif
        @endif

         <!-- Modal -->
        <div id="conectarseModal" class="modal fade" role="dialog">
            <div class="modal-dialog loginModalCaja">
                <!-- Modal content-->
                <div class="modal-content loginModal">
                    <form method="POST" action="http://www.mychef.cat/login">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="tituloModal modal-title;">Ingresa en MyChef</h4>
                        </div>
                        <div class="modal-body">
    						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <label for="email">Email</label>
                            <br/>
                            <input class="form-control loginInput" type="text" placeholder="ejemplo@ejemplo.com" name="email" id="email" value="{{ old('email') }}"/>
                            <br/>
                            <label for="password">Password</label>
                            <br/>
                            <input class="form-control loginInput" id="password" name="password" type="password" placeholder="*********" value=""/>
							<div class='form-group'>
								<input type="checkbox" value="si" name="recordar">
                                <label for="recordar">Recordar sesión</label>
							</div>
                            <a href="#" data-toggle="modal" data-target="#passwordOlvidada">¿Has olvidado tu contraseña?</a><!--recuperar contraseña-->
                            <br/>
							<a href="#" data-toggle="modal" data-target="#codigoActivacion">Reenviar email de activación</a><!--reenviar activación-->
                            <br/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" name="submit" value="Entrar" class="btn btn-primary"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="crearCuentaModal" class="modal fade" role="dialog">
            <div class="modal-dialog loginModalCaja">
                <div class="modal-content loginModal2">
                    <form action="http://www.mychef.cat/login/registrarse" name="formularioCuenta" method="POST">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="tituloModal modal-title">Registrarse</h4>
                        </div>
                        <div class="modal-body">        
                            <fieldset>
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control loginInput" name="dni" value="" placeholder="XXXXXXXXA" id="dni" size="15" maxlength="15">
                                <br/>
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control loginInput" name="nombre" value="" placeholder="Nombre" id="nombre" size="15" maxlength="15">
                                <br/>
                                <label for="apellido">Apellidos:</label>
                                <input type="text" class="form-control loginInput" name="apellido" value="" placeholder="Apellidos" id="apellido" size="32" maxlength="32">
                                <br/>
                                <label for="email">Email:</label>
                                <input type="text" class="form-control loginInput" name="email" value="" placeholder="ejemplo@ejemplo.com" id="email" size="40" maxlength="40">                       
                                <br/>
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control loginInput" placeholder="*********" name="password" id="password" value="" size="40" maxlength="40"/>
                                <br/>
                                <label for="password_confirmada">Repita la contraseña:</label>
                                <input type="password"class="form-control loginInput" placeholder="*********" name="password_confirmada" id="password_confirmada" value="" size="40" maxlength="40"/>
                                <br/>
                                <label>Código de verificación:</label>
                                <p>{!! Captcha::img(); !!}</p>
                                <p><input type="text" class="form-control" name="captcha" value="" placeholder="Introduzca el código de verificación" id="captcha" size="40" maxlength="40"></p>
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
        <div id="passwordOlvidada" class="modal fade" role="dialog">
            <div class="modal-dialog loginModalCaja">
                <div class="modal-content">
                    <form action="http://www.mychef.cat/login/reestablecer" name="formularioContraOlvidada" method="POST">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Reestablecer contraseña</h4>
                        </div>
                        <div class="modal-body">
                            <fieldset>
                                <h5>Email:</h5>
                                <p><input type="text" class="form-control" name="email" value="" placeholder="ejemplo@dominio.com" id="email" size="40" maxlength="40"></p>
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
        <div id="codigoActivacion" class="modal fade" role="dialog">
            <div class="modal-dialog loginModalCaja">
                <div class="modal-content">
                    <form action="http://www.mychef.cat/login/reenviar" name="formularioCodigoActivacion" method="POST" accept-charset="utf-8">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Reenviar e-mail de activación</h4>
                        </div>
                        <div class="modal-body">
                            <fieldset>
                                <h5>Email:</h5>
                                <p><input type="text" class="form-control" name="email" value="" placeholder="ejemplo@dominio.com" id="email" size="40" maxlength="40"></p>
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
     <!--/Modal-->
	</header>

	<div class="container-fluid nopadding ">

<!-- Cabezera -->
		<div class = "row fondo2 Cabeza nomargin">
			<div class = "col-xs-12 col-sm-6  col-md-6 col-lg-6  TituloCaja borde">	
                <h1 class="TituloLetras">M<samp class="destacado">y</samp> C<samp class="destacado">hef</samp></h1>
                <h1 class="Subtitulo"><samp class="destacado">TU CHEF EN CASA</samp></h1>
			</div>
		</div>
        <div class="col-xs-6 col-sm-6  col-md-6 col-lg-6"></div>
<!-- /Cabezera -->
<!-- Primera Sección-->
        <div class="container cajita1 nomargin degradado">
            <div class="row ">
                <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12  "  >	
                    <h2 class ="texto1">Sorprende a tus amigos contratando un chef para que cocine en tu casa</h2>
                </div>
            </div>
            <hr>
             <!-- Carrousel -->           
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6   conpaddingopcion1">
                                <div class="clearfix "></div>
                                <h1 class=" sombratexto TituloLetras3">Nuestros Chefs:</h1>
                                <p class="lead TituloLetras2" style="">Contamos con auténticos especialistas, profesionales con amplia experiencia en el sector.</p>
                            </div>
                            <div  class="col-lg-offset-1  col-xs-6 col-sm-6 col-md-6 col-lg-5 ">
                                <img class="img-responsive bordeimg2 menosM sombradiv"  src="http://www.mychef.cat/img/chef1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6   conpaddingopcion1">
                                <div class="clearfix"></div>
                                <h2  class="TituloLetras3 sombratexto">Elige el Menú:</h2>
                                <p  class="lead TituloLetras2">Sólo tienes que entrar y escoger, de entre las diferentes propuestas, la que más te guste.</p>
                            </div>
                            <div class="col-lg-offset-1  col-xs-6 col-sm-6 col-md-6 col-lg-5 ">
                                <img class="img-responsive bordeimg2 menosM sombradiv" src="http://www.mychef.cat/img/plato1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--/Carrousel -->     
<!--/Primera Sección-->
<!-- Segunda Sección-->
		<div class = "row vacio">
			<div id="fondo1" class = " col-xs-12 col-sm-12 col-md-12 col-lg-12 fondo3  "  >
                <div class="centrado3 col-xs-12 col-sm-7 col-md-6 col-lg-6 descubre borde">
                    <h1>DESCUBRE NUEVOS SABORES</h1>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-3 col-lg-3"></div>
            </div>
		</div>
<!--/Segunda Sección-->
<!-- Tercera Sección-->
		<div class = "row  cajita1 nomargin degradado">
			<div class = " col-xs-12 col-sm-12 col-md-12 col-lg-12  "  >	
				<h2 class ="texto1">Explora y encontrarás. </h2>
			</div>	
            <div class="row  ">
                <div class = " col-xs-12 col-sm-6 col-md-4 col-lg-4  "  ><!--col-md-offset-1 col-lg-offset-1 col-md-3 col-lg-3-->				
                    <div class="centrado2 view view-third"> <!--  style="left: 90px; top: 50px;" -->
                        <img src="http://www.mychef.cat/img/receta.jpg" />
                        <div class="mask">
                            <h2>Recetas</h2>
                            <p>Tendrás acceso a recetas exclusivas de nuestros chefs.</p>

                        </div>
                    </div>
                </div>
                <div class = "col-xs-12 col-sm-6 col-md-4 col-lg-4  "  >	
                    <div class="centrado2 view view-third"> <!--  style="left: 200px; top: 50px;" -->
                        <img src="http://www.mychef.cat/img/video.jpg" />
                        <div class="mask">
                            <h2>Videos</h2>
                            <p>Podras ver videos explicativos de parte de nuestros chefs.</p>

                        </div>
                    </div>
                </div>
                <div class = "col-xs-12 col-sm-12 col-md-4 col-lg-4  "  >	
                    <div class="centrado2 view view-third" > <!--  style="left: 300px; top: 50px;" -->
                        <img src="http://www.mychef.cat/img/yate.jpg" />
                        <div class="mask">
                            <h2> Y mucho mas ...</h2>
                            <p>Prueba nuestro servicio más novedoso. Contrata un chef profesional para que cocine en tu yate.</p>

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="tabla  col-sm-offset-1 col-md-offset-1 col-lg-offset-2 col-xs-12 col-sm-6 col-md-5 col-lg-4">
                <table class="table">
                    <tbody>
                        <tr class=" contenidoTexto">
                            <td><img src="http://www.mychef.cat/img/visto2.png" ></td>
                            <td class="tablaCentro ">Trato personalizado</td>
                        </tr>
                        <tr class=" contenidoTexto">
                            <td><img src="http://www.mychef.cat/img/visto2.png" ></td>
                            <td class="tablaCentro ">Contenidos exclusivos</td>
                        </tr>
                        <tr class=" contenidoTexto">
                            <td><img src="http://www.mychef.cat/img/visto2.png" ></td>
                            <td class="tablaCentro ">Alta cocina de calidad</td>
                        </tr>
                        <tr class=" contenidoTexto">
                            <td><img src="http://www.mychef.cat/img/visto2.png"></td>
                            <td  class="tablaCentro ">Acceso a cocinas del mundo</td>
                        </tr>
                        <tr class=" contenidoTexto">
                            <td><img src="http://www.mychef.cat/img/visto2.png" ></td>
                            <td  class="tablaCentro ">Menús adaptados al comensal</td>
                        </tr>
                    </tbody>
                </table>
                <div class="contenidoTexto">
                    <ul class="list-inline banner-social-buttons">
                        <li>
                            <a href="#" class="btn btn-default btn-md"><i class="fa fa-twitter"></i> <span class="network-name">Twitter</span></a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-default btn-md" ><i class="fa fa-facebook"></i> <span class="network-name">Facebook</span></a>
                        </li>
                    </ul>
                </div>
            </div>  
            <div class="col-md-offset-1 col-lg-offset-1  col-xs-4 col-sm-4 col-md-4 col-lg-4 cajaribete">
                <img class="ribete" src="http://www.mychef.cat/img/ribete2.png">
            </div>            
        </div>
    </div>
<!--/Tercera Sección-->
@stop
