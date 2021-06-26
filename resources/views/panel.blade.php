@extends('layouts.principal')

@section('content')
<style type="text/css">
.centrado {
  position: absolute;
  top: 50%; 
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>

 <script type="text/javascript" src="http://www.mychef.cat/js/ocultar.js"></script>

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
</header>
</br>
</br>
<div class="container margenfoter" style="margin-bottom: 210px;">
    <div class="row">
        <div class="col-xs-12 col-ms-12 col-md-12 col-lg-12">
            <h2 class="texto1 Subtitulo destacado">Mi Perfil</h2>
        </div>
    </div>


    <div class="row">
        <div id="panel" style='display: block' class="col-lg-10 col-xs-10 texto1 destacado iconos">


            <div class="col-lg-2 col-sm-10 col-md-4 col-xs-10">

                <button name="boton" class="btn btn-danger enable" onclick="mostrarmensaje(ocultariconos())">
                    <img src="http://www.mychef.cat/img/ordenador.svg" width="80" height="80" />
                </br>Mensajes
                 
            </div>

            <div class="col-lg-2 col-sm-10 col-md-4 col-xs-10 ">


                <button name="boton" type="submit" class="btn btn-danger enable" onclick="mostrardatos(ocultariconos())">
                    <img src="http://www.mychef.cat/img/usuario.svg" width="80" height="80" />
                </br>Datos
			
            </div>

            <div class="col-lg-2 col-sm-10 col-md-4 col-xs-10 ">


                <button name="boton" type="submit" class="btn btn-danger enable" onclick="direccion2(ocultariconos())">
                    <img src="http://www.mychef.cat/img/direccion.svg" width="80" height="80" />
                </br> Dirección
			
            </div>
            <div class="col-lg-2 col-sm-10 col-md-4 col-xs-10 ">

                <button name="boton" type="submit" class="btn btn-danger enable" onclick="mostrarfactura(ocultariconos())">
                    <img src="http://www.mychef.cat/img/factura.svg" width="80" height="80" />
                </br> Contrato
            </div>
            <div class="col-lg-2 col-sm-10 col-md-4 col-xs-10 ">

                <button name="boton" class="btn btn-danger enable" onclick="mostrarpagos(ocultariconos())">
                    <img src="http://www.mychef.cat/img/pago.svg" width="80" height="80" />
                </br> Pagos
            </div>
            <div class="col-lg-2 col-sm-10 col-md-4 col-xs-10">

                <button name="boton" class="btn btn-danger enable" data-toggle="modal" data-target="#eliminarcuenta" onclick="">
                    <img src="http://www.mychef.cat/img/borrar.svg" width="80" height="80" />
                </br> Eliminar
            </div>



        </div>
        <!--Fin Iconos-->


    </div>
    <!--Datos personales del usuario-->
    <div class="row">

        <div id="datos" style='display: none' class="col-lg-12">
            <div class=" panel panel-default caixa">
                <div class="panel-body">
                    <!--formulario -->
                    <form class="form-horizontal">

                        <legend>Datos Personales</legend>
                        <!--campos-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="disabledInput">Nombre</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="Text1" type="text" placeholder="@if(!empty($usuario)){{$usuario->nombre}}@endif" disabled="">
                            </div>
                        </div>

                        <!------------>
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="disabledInput">Apellidos</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="Text2" type="text" placeholder="@if(!empty($usuario)){{$usuario->apellidos}}@endif" disabled="">
                            </div>
                        </div>
                        <!------------------------------>
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="focusInput">DNI</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="Text3" type="text" placeholder="@if(!empty($usuario)){{$usuario->dni}}@endif" disabled="">
                            </div>
                        </div>
                        <!--Cambiar contraseña-->
                        <div id="boton_pass" class="centrar">
                            <a href="#" class="btn btn-primary" onclick="mostrar(ocultar()) ">Cambiar Contraseña</a>
                            <a href="#" class="btn btn-danger" onclick="mostrariconos(ocultardatos())">Salir</a>
                        </div>
                    </form>

                    <!------------- -->
                    <form class="form-horizontal" method="POST" action="perfil/cambiarpass">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <fieldset>
                            <div id="pass" style='display: none'>
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for="focusInput">Password Actual</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="pass1" type="password" placeholder="Nueva Contraseña" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for="focusInput">Nuevo Password</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="pass2" type="password" placeholder="Nueva Contraseña" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for="focusInput">Repita el Password</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="pass3" type="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <!--Botones -->
                                <div class="form-group centrar">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-primary">Aceptar</button>
                                        <a href="#" class="btn btn-default" onclick="ocultarpass(mostrarboton())">Cancelar</a>


                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!--fin datos personales-->

    <div class="row">
        <div id="direccion" style='display: none' class="col-lg-12">
            <div class=" panel panel-default container caixa ">
                <div class="panel-body">
                    <!--formulario -->
                    <form class="form-horizontal">
                        <!--campos-->

                        <div id="dir" style='display: block'>
                            <legend>Dirección</legend>
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="disabledInput">Alias</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="Alias" type="text" placeholder="@if(!empty($usuario)){{$usuario->alias}}@endif" disabled="">
                                </div>
                            </div>

                            <!------------>
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="disabledInput">Ciudad</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="Provincia" type="text" placeholder="@if(!empty($ciudad)){{$ciudad->nombre}}@endif" disabled="">
                                </div>
                            </div>
                            <!------------------------------>
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="focusInput">Población</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="Poblacion" type="text" placeholder="@if(!empty($usuario)){{$usuario->poblacion}}@endif" disabled="">
                                </div>
                            </div>
                            <!------------------------ -->
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="focusInput">Dirección</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="Text4" type="text" placeholder="@if(!empty($usuario)){{$usuario->direccion}}@endif" disabled="">
                                </div>
                            </div>
                            <!------   -->
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="focusInput">Código Postal</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="Postal" type="text" placeholder="@if(!empty($usuario)){{$usuario->codigo_postal}}@endif" disabled="">
                                </div>
                            </div>
                        </div>



                        <!--Cambiar direccion-->
                        <div id="boton_dir" class="centrar" style='display: block'>

                            <a href="#" class="btn btn-primary" onclick="direccion(ocultardir(ocultarbotondir()))">Cambiar Dirección</a>
                            <a href="#" class="btn btn-danger" onclick="mostrariconos(ocultardir2())">Salir</a>

                        </div>
                    </form>

                    <!------------- -->



                    <!------------- -->
                    <form class="form-horizontal" method="POST" action="perfil/cambiardir">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div id="dire2" style='display: none' class="container">
                            <legend>Nueva Dirección</legend>
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="disabledInput">Alias</label>
                                <div class="col-lg-10">
                                    <input class="form-control" name="alias" type="text" placeholder="Alias" required>
                                </div>
                            </div>

                            <!------------>
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="disabledInput">Ciudad</label>
                                <div class="col-lg-10">
                                    <select class="form-control" name="ciudad">
                                        <option value="1">Barcelona</option>
                                        <option value="2">Madrid</option>
                                        <option value="3">Zaragoza</option>
                                        <option value="4">Valencia</option>
                                    </select>
                                </div>
                            </div>
                            <!------------------------------>
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="focusInput">Población</label>
                                <div class="col-lg-10">
                                    <input class="form-control" name="poblacion" type="text" placeholder="Poblacion" required>
                                </div>
                            </div>
                            <!------------------------ -->
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="focusInput">Dirección</label>
                                <div class="col-lg-10">
                                    <input class="form-control" name="direccion" type="text" placeholder="calle/numero/piso" required>
                                </div>
                            </div>
                            <!------   -->
                            <div class="form-group">
                                <label class="control-label col-lg-1" for="focusInput">Código Postal</label>
                                <div class="col-lg-10">
                                    <input class="form-control" name="codigo_postal" type="text" placeholder="000">
                                </div>
                            </div>
                            <!--Botones -->
                            <div class="form-group centrar">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                    <a href="#" class="btn btn-default" onclick="ocultardir22(mostrardir(mostrarboton2()))">Cancelar</a>


                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <!--fin direccion--->
    <!--ver facturas-->
    <div class="row">

        <div id="faturas" style='display: none' class="col-lg-12 margenfoter1">

            <div class=" panel panel-default caixa">
                <div class="panel-body">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Fecha</th>
                                <th>Forma de pago</th>
                                <th>Factura</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratos as $contrato)
                <tr class="active">
                    <td>@if(!empty($contratos)){{$contrato->id}}@endif</td>
                    <td>@if(!empty($contratos)){{$contrato->fecha}}@endif</td>
                    <td>@if(!empty($nombrepago)){{$nombrepago->nombre}}@endif</td>

                    <td>

                        <a href="pdf/pdf/{{$contrato->id}}"><span class="glyphicon glyphicon-save"></span></a></td>

                    <td><a href="perfil/eliminarcontrato/{{$contrato->id}}"><span class="glyphicon glyphicon-remove"></a></td>
                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    <div id="boton_factura">

                        <a href="#" class="btn btn-danger" onclick="mostrariconos(ocultarfactura())" float:center><span class="glyphicon glyphicon-arrow-left"></a>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <!--Fin facturas-->
    <!--metodos de pago-->

    <div class="row">
        <div id="pagos" style='display: none' class="col-lg-12 margenfoter1">
            <div class=" panel panel-default caixa">
                <div class="panel-body">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Numero</th>
                                <th>Fecha de vencimiento</th>
                                <th>Titular</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagos as $pago)
                <tr class="active">
                    <td>@if(!empty($pagos)){{$nombrepago->nombre}}@endif</td>
                    <td>@if(!empty($pagos)){{$pago->numero}}@endif</td>
                    <td>@if(!empty($pagos)){{$pago->fecha}}@endif</td>
                    <td>@if(!empty($usuario)){{$usuario->nombre}}@endif</td>
                    <td><a href='#' data-toggle="modal" data-target="#pagar"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a href='perfil/eliminarpagos/{{$pago->id}}'><span class="glyphicon glyphicon-remove"></a></td>
                </tr>
                            @endforeach
		
                        </tbody>
                    </table>
                    <div id="boton_pagos">

                        <a href="#" class="btn btn-danger" onclick="mostrariconos(ocultarpagos())" float:center><span class="glyphicon glyphicon-arrow-left"></a>

                    </div>

                </div>
            </div>


            <div class="modal col-lg-10 " id="pagar">
                <div class="modal-dialog">
                    <div class="modal-content ">
                        <div class="modal-header  container">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Pagos</h4>
                        </div>
                        <div class="modal-body ">


                            <form class="form-horizontal" method="POST" action="perfil/modipagos">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <fieldset>

                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="panel-body">


                                                <div class="form-group" class="container">
                                                    <label for="select" class="col-lg-2 control-label">Tipo</label>
                                                    <div class="col-lg-10">
                                                        <select class="form-control" name="tipo">
                                                            <option value="1">Visa</option>
                                                            <option value="2">MasterCard</option>
                                                            <option value="3">DinersClub</option>
                                                            <option value="4">AmericaExpres</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-3" for="disabledInput">Numero</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control" name="numero" type="text" placeholder="xxxxxxxxxxx-122" required>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-lg-3" for="focusedInput">Fecha vencimiento</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control" name="vencimiento" type="text" placeholder="12-22" required>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-lg-3" for="focusedInput">Titular</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control" name="titular" type="text" placeholder="Juan perez Lopez" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-3" for="focusedInput">CVC</label>
                                                <div class="col-lg-5">
                                                    <input class="form-control" name="cvc" type="password" placeholder="xxx"required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </fieldset>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">

        <div id="mensajes" style='display: none' class="col-lg-12 margenfoter1">
            <div class=" panel panel-default caixa">
                <div class="panel-body">

                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Asunto</th>
                                <th>Nº Pedido</th>
                                <th>Fecha</th>
                                <th>Leer</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratos as $contrato)
                <tr class="active">
                    <td>@if(!empty($contratos)){{$contrato->estado}}@endif</td>
                    <td>@if(!empty($contratos)){{$contrato->id}}@endif</td>
                    <td>@if(!empty($contratos)){{$contrato->fecha}}@endif</td>
                    <td><a href='#' data-toggle="modal" data-target="#mensaje"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <td><a href='perfil/eliminarcontrato/{{$contrato->id}}'><span class="glyphicon glyphicon-remove"></a></td>
                </tr>
                            @endforeach
                 
                        </tbody>
                    </table>
                    <div id="boton_mensaje">

                        <a href="#" class="btn btn-danger" onclick="mostrariconos(ocultarmensaje())" float:center><span class="glyphicon glyphicon-arrow-left"></a>

                    </div>
                </div>
            </div>


            <div class="modal col-lg-10" id="mensaje">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Mensaje</h4>
                        </div>
                        <div class="modal-body">

                            <p>@if(!empty($contratos)){{$contrato->mensaje}}@endif</p>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="modal" id="eliminarcuenta">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Eliminar cuenta</h4>
                    </div>
                    <form class="form-horizontal" method="POST" action="perfil/eliminarcuenta">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="modal-body">
                            <p>¿Esta seguro de que desea eliminar su cuenta?</p>
                            <div class="panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" for="disabledInput">Contraseña</label>
                                        <div class="col-lg-12">
                                            <input class="form-control" name="contra" type="password">
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
     @if ($errors->has())
    @foreach ($errors->all() as $error)
        <div class='alert alert-dismissible alert-success' style="position:fixed; right: 2%; top: 10%; z-index:9999999;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $error }}
        </div>
    @endforeach
@endif 
  

@stop