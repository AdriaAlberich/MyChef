@extends('layouts.principal')

@section('content')
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script>
    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker").datepicker({
            firstDay: 1
        });
    });
</script>

<header style="margin-bottom: 100px;">
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
<div class="container" style="margin-bottom: 35px;">
    <div class="row">
       <form class="form-horizontal" method="POST" action="contratar">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="row" style="display: block" id="buscar">
                <div class="panel panel-success caixa">
                    <div class="panel-heading">
                        <h3 class="panel-title">Contrata tu Chef</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-horizontal">

                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Nombre</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputEmail" name="nombre" value="{{$usuario->nombre}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">DNI</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text1" name="dni" value="{{$usuario->dni}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Correo</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text2 " name="email" value="{{$usuario->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Chef</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text3" name="chef" value="{{$userchef->nombre}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Fecha</label>
                                <div class="col-lg-10">
                                    <input type="text" id="datepicker" name="fecha" class="form-control" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label" >Menú</label>
                                <div class="col-lg-10">
                                    <select class="form-control" id="select" name="menu2">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <center>
                            <a href="#" class="btn btn-primary" onclick="ocultar(mostrar())">Siguiente</a>
                        </center>
                    </div>
                </div>
            </div>
            <div class="row" style='display: none' id="cuantos">
                <div class="panel panel-success caixa">
                    <div class="panel-heading">
                        <h3 class="panel-title">Dirección</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-horizontal">

                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Alias</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text4" name="alias" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Ciudad</label>
                                <div class="col-lg-10">
                                    <select class="form-control" id="select1" name="ciudad">
                                        <option value="1">Barcelona</option>
                                        <option value="2">Madrid</option>
                                        <option value="3">Valencia</option>
                                        <option value="5">Zaragoza</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Población</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text5" name="poblacion" value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Código postal</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text6" name="codigo" value="" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Calle</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text7" name="calle" value="" required>
                                </div>
                            </div>
                        </div>
                        <center>
                            <a href="#" class="btn btn-primary" onclick="mostrar1(ocultar1())">Siguiente</a>
                        </center>
                    </div>
                </div>
            </div>
            <div class="row" style='display: none' id="tipo">
                <div class="panel panel-success caixa">
                    <div class="panel-heading">
                        <h3 class="panel-title">Forma de pago</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Tipo</label>
                                <div class="col-lg-10">
                                    <select class="form-control" id="select2" name="tipo">
                                        <option value="1">Visa</option>
                                        <option value="2">MasterCard</option>
                                        <option value="3">DinersClub</option>
                                        <option value="4">AmericaExpress</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Numero</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text8" name="numero" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Fecha</label>
                                <div class="col-lg-10">
                                    <input type="text" id="cadu" name="cadu" class="form-control" value="" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Titular</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Text10" name="titular" value="" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">CVC</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" id="Password1" name="cvc" value=""required>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="reset" class="btn btn-default">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </center>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop