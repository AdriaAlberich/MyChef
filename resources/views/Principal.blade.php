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
</br>
</br>
    <div class="container">
        <div class="row" style="display: block" id="buscar">
            <div class="panel panel-default caixa" >
                <div class="panel-body ">
                    <p style="line-height: 70px; text-align: center">
                        <button name="boton" class="btn btn-warning enable texto1 morph" href="#" onclick="ocultar(mostrar())">
                            <img src="http://www.mychef.cat/img/lupa.svg" width="80" height="40" />
                        </br>
                        Buscar          
                    </p>
                </div>
            </div>
        </div>
        <!--empieza el formulario para el buscados -->
        <form class="form-horizontal"  method="POST" action = "principal/busqueda">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="row" style='display: none' id="cuantos">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Cuantos són:</h3>
            </div>
        <div class="panel-body">
            <div>
                <p style="line-height: 70px; text-align: center">
                    <div class="col-lg-3 col-sm-12" style="float: left">
                        <input type="radio"name="boton1" class="btn btn-default enable borde morph" value="2" style="background-color: transparent">
                            <img src="http://www.mychef.cat/img/2.svg" width="100" height="80" />
                        </br>
                        2 Personas
                    </div>

                    <div class="col-lg-3" style="float: left">

                        <input type="radio"name="boton1" class="btn btn-default enable borde morph" value="3"  style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/3.svg" width="100" height="80" />
                        </br>
                        3-6 Personas
                    </div>

                    <div class="col-lg-3" style="float: left">

                        <input type="radio"name="boton1" class="btn btn-default enable borde morph" value="7"  style="background-color: transparent">
                            <img src="http://www.mychef.cat/img/7.svg" width="100" height="80" />
                        </br>
                        7-12 Personas
                    </div>
                    <div class="col-lg-3">
                        <input type="radio"name="boton1" class="btn btn-default enable borde morph" value="13"  style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/6.svg" width="100" height="80" />
                        </br>
                        + 13 Personas
                    </div>

                </p>
         </div>
    	 <center>
        	 <button type="button" class="btn btn-primary glyphicon glyphicon-arrow-left"></button>
        	 <button type="button" class="btn btn-primary glyphicon glyphicon-arrow-right" onclick="mostrar1(ocultar1())"></button>
    	 </center>
      </div>
    </div>
</div>


<!--- aqui termina la primera parte de cuantas personas son - -->
<div class="row" style='display: none' id="tipo">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Que ocasión es</h3>
        </div>
    <div class="panel-body">
	   <div>
            <p style="line-height: 70px; text-align: center">
                          
                <div class="col-lg-4 col-sm-12">

                    <input type="radio"name="boton2" class="btn btn-default enable borde morph" value="romantica" style="background-color: transparent">
                        <img src="http://www.mychef.cat/img/pareja.svg" width="100" height="80" />
                    </br>
                    Romantica
                </div>

                <div class="col-lg-4 col-sm-12" style="float: left">

                    <input type="radio"name="boton2" class="btn btn-default enable borde morph" value="amigos" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/amigos.svg" width="100" height="80" />
                    </br>
                    Amigos
                </div>

                <div class="col-lg-4 col-sm-12" style="float: left">

                    <input type="radio"name="boton2" class="btn btn-default enable borde morph" value="familia" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/familia.svg" width="100" height="80" />
                    </br>
                    Familia
                </div>

            </p>

        </div>
		</br>
		<center>
    		<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-left" onclick="ocultar2(mostrar())"></button>
    		<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-right" onclick="mostrar2(ocultar2())"></button>
		</center>					
    </div>
</div>
</div>

<div class="row"style='display: none' id="es">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Es una</h3>
        </div>
    <div class="panel-body">
   
        <div>
            <p style="line-height: 70px; text-align: center">
                <div class="col-lg-2 col-sm-12">
                </div>
                <div class="col-lg-5 col-sm-12">
                    <input type="radio"name="boton3" class="btn btn-default enable borde morph" value="1" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/dia.svg" width="100" height="80" />
                    </br>
                    Comida
                </div>

                <div class="col-lg-5 col-sm-12" style="float: left">

                    <input type="radio"name="boton3" class="btn btn-default enable borde morph" value="0" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/noche.svg" width="100" height="80" />
                    </br>
                    Cena
                </div>

            </p>

        </div>
		<center>
        	<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-left"onclick="ocultar3(mostrar1())""></button>
        	<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-right" onclick="mostrar3(ocultar3())"></button>
		</center>
    </div>
</div>


</div>


<div class="row" style='display: none' id="comida">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Tipo de comida que desea </h3>
        </div>
        <div class="panel-body">
            <div>
                <p style="line-height: 70px; text-align: center">
                    <div class="col-lg-2 col-sm-12">
                        <input type="radio"name="boton4" class="btn btn-default enable borde morph" value="1" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/mediterranea.svg" width="100" height="80" />
                        </br>
                        Mediterránea
                    </div>
                    <div class="col-lg-2 col-sm-12" style="float: left">

                        <input type="radio"name="boton4" class="btn btn-default enable borde morph" value="2" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/italiana.svg" width="100" height="80" />
                        </br>
                        Italiana
                    </div>

                    <div class="col-lg-2 col-sm-12" style="float: left">

                        <input type="radio"name="boton4" class="btn btn-default enable borde morph" value="3" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/francesa.svg" width="100" height="80" />
                        </br>
                        Francesa
                    </div>

                    <div class="col-lg-2 col-sm-12" style="float: left">

                        <input type="radio"name="boton4" class="btn btn-default enable borde morph" value="4" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/mexicana.svg" width="100" height="80" />
                        </br>
                        Mexicana
                    </div>

                    <div class="col-lg-2 col-sm-12" style="float: left">

                        <input type="radio"name="boton4" class="btn btn-default enable borde morph" value="5" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/japonesa.svg" width="100" height="80" />
                        </br>
                        Japonesa
                    </div>

                    <div class="col-lg-2 col-sm-12" style="float: left">

                        <input type="radio"name="boton4" class="btn btn-default enable borde morph" value="6" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/autor.svg" width="100" height="80" />
                        </br>
                        Cocina de autor
                    </div>

                </p>
            </div>
            <center>
            	<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-left"onclick="ocultar4(mostrar2())"></button>	
                <button type="button" class="btn btn-primary glyphicon glyphicon-arrow-right" onclick="mostrar4(ocultar4())"></button>	
            </center>
        </div>
    </div>
</div>


<div class="row" style='display: none' id="restricciones">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Hay algo que no pueda comer</h3>
        </div>
        <div class="panel-body">
            <div>
                <p style="line-height: 70px; text-align: center">
                    <div class="col-lg-2 col-sm-12">
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <button type="button" class="btn btn-default enable borde morph" style="background-color: transparent" onclick="mostrarsi(ocultar5())">
                            <img src="http://www.mychef.cat/img/si.svg" width="100" height="80" />
							</button>
                        </br>
                        <p style="text-align: center"> Si</p>
                    </div>

                    <div class="col-lg-5 col-sm-12" style="float: left">
						<button type="button" class="btn btn-default enable borde morph" style="background-color: transparent" onclick="mostrarno(ocultar5())">
                        <img src="http://www.mychef.cat/img/no.svg" width="100" height="80" />
						</button>
                        </br>
                        No
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>


<div class="row" style='display: none' id="si">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Que alimentos no puede ingerir</h3>
        </div>
        <div class="panel-body">
            <div>
                <p style="line-height: 70px; text-align: center">
                    <div class="col-lg-2 col-sm-12">
                        <input type="radio"name="boton6" class="btn btn-default enable borde morph"value="vegetariano" style="background-color: transparent" onclick="mostrarno(ocultar6())">
                            <img src="http://www.mychef.cat/img/vegetariano.svg" width="100" height="80" />
                        </br>
                        Vegetariano
                    </div>
                    <div class="col-lg-2 col-sm-12" style="float: left">
                        <input type="radio"name="boton6" class="btn btn-default enable borde morph" value="gluten" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/gluten.svg" width="100" height="80" />
                        </br>
                        Gluten
                    </div>
                    <div class="col-lg-2 col-sm-12" style="float: left">
                        <input type="radio"name="boton6" class="btn btn-default enable borde morph"value="secos" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/frutos.svg" width="100" height="80" />
                        </br>
                        Frutos Secos
                    </div>
                    <div class="col-lg-2 col-sm-12" style="float: left">
                        <input type="radio"name="boton6" class="btn btn-default enable borde morph" value="lacteos" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/lacteo.svg" width="100" height="80" />
                        </br>
                        Lacteos
                    </div>
                    <div class="col-lg-2 col-sm-12" style="float: left">
                        <input type="radio"name="boton6" class="btn btn-default enable borde morph" value="marisco" style="background-color: transparent" >
                            <img src="http://www.mychef.cat/img/marisco.svg" width="100" height="80" />
                        </br>
                        Marisco
                    </div>
                    <div class="col-lg-2 col-sm-12" style="float: left">
                        <input type="radio"name="boton6" class="btn btn-default enable borde morph" value="otros" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/otros.svg" width="100" height="80" />
                        </br>
                        Otros
                    </div>
                </p>
            </div>
			<center>
    			<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-left"onclick="ocultar6(mostrar4())" ></button>
    			<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-right" onclick="mostrarno(ocultar6())"></button>
			</center>
        </div>
    </div>
</div>


<div class="row" style='display: none' id="cocina">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Que tipo de cocina tiene </h3>
        </div>
        <div class="panel-body">
            <div>
                <p style="line-height: 70px; text-align: center">
                    <div class="col-lg-2 col-sm-12">
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <input type="radio"name="boton7" class="btn btn-default enable borde morph" value="gas" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/gas.svg" width="100" height="80" />
                        </br>
                        Gas 
                    </div>
                    <div class="col-lg-5 col-sm-12" style="float: left">
                        <input type="radio"name="boton7" class="btn btn-default enable borde morph" value="luz" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/induccion.svg" width="100" height="80" />
                        </br>
                        Induccion
                    </div>
                </p>
            </div>
			<center>
    			<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-left"onclick="ocultar7(mostrar4())"></button>
    			<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-right" onclick="mostrar7(ocultar7())"></button>
			</center>
        </div>
    </div>
</div>


<div class="row" style='display: none' id="horno">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Tiene horno</h3>
        </div>
        <div class="panel-body">
  
            <div>
                <p style="line-height: 70px; text-align: center">
                    <div class="col-lg-2 col-sm-12">
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <input type="radio"name="boton8" class="btn btn-default enable borde morph" value="si" style="background-color: transparent">
                        <img src="http://www.mychef.cat/img/horno.svg" width="100" height="80" />
                        </br>
                        Si
                    </div>

                    <div class="col-lg-5 col-sm-12" style="float: left">

                        <input type="radio"name="boton8" class="btn btn-default enable borde morph" value="no" style="background-color: transparent" >
                        <img src="http://www.mychef.cat/img/hornono.svg" width="100" height="80" />
                        </br>
                        No
                    </div>
                </p>
            </div>
			<center>
        		<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-left"onclick="ocultar8(mostrarno())"></button>
        		<button type="button" class="btn btn-primary glyphicon glyphicon-arrow-right" onclick="mostrar8(ocultar8())"></button>
			</center>
        </div>
    </div>
</div>


<div class="row" style='display: none' id="lugar">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Dia y lugar del evento</h3>
        </div>
        <div class="panel-body">
  
            <div>
                <p style="line-height: 70px; text-align: center">

                    <div class="col-lg-4 col-sm-12">

                        <div>
                            <label class="control-label">Ciudad</label>
                           
							<div>
								<select class="form-control" name="ciudad">
									<option value="1">Barcelona</option>
									<option value="2">Madrid</option>
									<option value="3">Valencia</option>
									<option value="4">Pais Vasco</option>
									<option value="5">Sevilla</option>
								</select>
							</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12" style="height">
                        <label class="control-label" for="focusedInput">Dirección</label>
                        <input class="form-control" name="direccion" type="text" value="">        
                    </div>

                    <div class="col-lg-4 col-sm-12" style="height">
                        <label class="control-label" for="focusedInput">Fecha</label>
                        <input type="text" id="datepicker" name="fecha"class="form-control" />
                    </div>
                    </br>
                </p>
            </div>
			<center>
                <button type="submit" class="btn btn-primary" style="float:center">Finalizar Búsqueda</button>	
            </center>		
        </div>
    </div>
</div>

</form>
<div class="row">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Todos</a></li>
        <li><a href="#profile">Nuevos</a></li>
        <li><a href='{{action('PrincipalController@verValorados')}}' >Mas Valorados</a></li>
        <li><a href=''>Favoritos</a></li>
    </ul>
    <hr>
    <!----cuerpo---->
    @for ($i = 0; $i < count($datos); $i++)

    <div class="col-lg-3 col-sm-12">
        <a href="{{$datos[$i]['ruta']}}" > <img src="@if(!is_null($datos[$i]['foto'])){{$datos[$i]['foto']}}@endif"   style="width: 250px !important; height: 200px !important; margin-top:20px; margin-bottom:20px; margin-right:10px; margin-left:10px;"class="caixa" /></a>
    </div>
    @endfor
    

    <!----cuerpo------>

</div>

</div>

@stop
