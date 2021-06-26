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

    @if (session()->has('editado'))
        @if(session('editado'))
            <div class='alert alert-dismissible alert-success notificacion'>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Chef editado correctamente.
            </div>
        @endif
    @endif

    <div class="container-fluid" style="margin-top:10%; margin-bottom: 20%">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <form method = "POST" action = "{{ action('AdminController@editarChef', ['id_chef' => $chef->id]) }}">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label for="cocina" class="control-label">Tipo de cocina:</label> 
                        <select id="cocina" name="cocina" class="form-control">
                            @foreach($cocinas as $cocina)
                                <option value="{{ $cocina->id }}">{{ $cocina->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="personas" class="control-label">Max personas:</label> 
                        <input id="personas" name="personas" class="form-control" type="text" value="{{ $chef->personas }}"/>
                    </div>
                    <div class="form-group">
                        <label for="barco" class="control-label">¿Servicio a barcos?</label> 
                        <input id="barco" @if($chef->barco == 1) checked="checked" @endif type="checkbox" name="barco" value="barco">
                    </div>
                    <div class="form-group">
                        <label for="precio" class="control-label">Precio mínimo:</label> 
                        <input id="precio" name="precio" class="form-control" type="text" value="{{ $chef->precio }}"/>
                    </div>
                    <div class="form-group">
                        <a href="{{ action('AdminController@verPanelAdmin') }}"><button type="button" class="btn btn-md btn-default"><span class="glyphicon glyphicon-remove"></span>&nbsp;Volver</button></a>
                        <button type="submit" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;Guardar cambios</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
            </div>
        </div>
    </div>
@stop
