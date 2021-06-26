@extends('layouts.principal')

@section('title') Reestablecer contraseña @stop

@section('content')

    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='alert alert-dismissible alert-danger' style="position:fixed; right: 2%; top: 10%; z-index:9999999;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ $error }}
            </div>
        @endforeach
    @endif

    <div class="container-fluid" style="margin-top:10%; margin-bottom: 10%">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <form method="POST" action="http://www.mychef.cat/login/cambiarpassword">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <label for="email">Email:</label>
                    <br/>
                    <input class="form-control" id="email" name="email" type="text" placeholder="ejemplo@ejemplo.com" value="{{ $email }}"/>
                    <br/>
                    <label for="codigo">Código de activación:</label>
                    <br/>
                    <input class="form-control" id="codigo" name="codigo" type="text" placeholder="" value="{{ $codigo }}"/>
                    <br/>
                    <label for="password">Escribe la nueva contraseña:</label>
                    <br/>
                    <input class="form-control" id="password" name="password" type="password" placeholder="*********" value=""/>
                    <br/>
                    <label for="password_confirmada">Repite la contraseña:</label>
                    <br/>
                    <input class="form-control" id="password_confirmada" name="password_confirmada" type="password" placeholder="*********" value=""/>
                    <br/>
                    <input type="submit" name="submit" value="Cambiar contraseña" class="btn btn-primary"/>
                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
            </div>
        </div>
    </div>
@stop
