@extends('layouts.principal')

@section('title') Panel Admin @stop

@section('content')

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

    @if (session()->has('altachef'))
        @if(session('altachef'))
            <div class='alert alert-dismissible alert-success notificacion'>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Chef dado de alta satisfactoriamente. Te recomendamos que edites sus parámetros basicos haciendo click en el botón 'Editar'.
            </div>
        @endif
    @endif

    @if (session()->has('bajachef'))
        @if(session('bajachef'))
            <div class='alert alert-dismissible alert-success notificacion'>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Chef dado de baja correctamente.
            </div>
        @endif
    @endif

    <div class="container-fluid" style="margin-top:10%; margin-bottom: 20%">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Listado de usuarios
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover table-condensed">
                            <thead>
                                <th></th><th></th><th></th><th>Nombre</th><th>Apellidos</th><th>E-mail</th>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    @if($usuario->chef == 1)
                                    <tr class="success">
                                    @else
                                    <tr>
                                    @endif
                                        @if($usuario->chef == 0)
                                        <td class="acciones">
                                            <form method = "GET" action = "{{ action('AdminController@altaChef', ['id_usuario' => $usuario->id]) }}">
                                                <button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-ok"></span>Alta Chef</button>
                                            </form>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        @else
                                        <td class="acciones">
                                            <form method = "GET" action = "{{ action('AdminController@bajaChef', ['id_usuario' => $usuario->id]) }}">
                                                <button type="submit" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span>Baja Chef</button>
                                            </form>
                                        </td>
                                        <td class="acciones">
                                            <form method = "GET" action = "{{ action('AdminController@editarChefPanel', ['id_usuario' => $usuario->id]) }}">
                                                <button type="submit" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-edit"></span>Editar</button>
                                            </form>
                                        </td>
                                        <td class="acciones">
                                            <a target="_blank" href="{{ action('AdminController@verPaginaChef', ['id_usuario' => $usuario->id]) }}">
                                                <button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span>Página</button>
                                            </a>
                                        </td>
                                        @endif
                                        <td>
                                            {{ $usuario->nombre }}
                                        </td>
                                        <td>
                                            {{ $usuario->apellidos }}
                                        </td>
                                        <td>
                                            {{ $usuario->email }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $usuarios->render() !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
        </div>
    </div>
@stop
