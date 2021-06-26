 
@extends('layouts.principal')

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
                        <li class="barraNav"><a class="navbar-btn login barraNav" href="@if(isset($chef))../contrato/{{ $chef->id }} @endif"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;CONTRATAR</a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{Auth::user()->nombre}} <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="http://www.mychef.cat/perfil">Mi perfil</a></li>
                            @if(isset($id_chef_user))
                                <li><a href="http://www.mychef.cat/chef/{{ $id_chef_user }}">Mi página</a></li>
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
<div class="container">
    <div class="row">
        <div class="fotoChef col-xs-12 col-ms-12 col-md-12 col-lg-12">

        </div>
    </div>
    <div class ="row">
        <!-- SECCION PERFIL  -->
        <div class="caixaPerfil col-xs-12 col-ms-12 col-md-3 col-lg-3 pull-left">
            <form class="form-horizontal posicionEditImgPerfil">
                <div class="form-group">
                    @if($edit)<span class=" botonOK editaImgPerfil label label-info">Editar</span>@endif
                </div>
            </form>
            <img class="fotoperfil" src="@if(!empty($fotos)) @if(isset($fotos['perfil'])){{$fotos['perfil']}} @endif @endif"><!--my-awesome-dropzone -->
            <div class = "imgPerfil">

                <form action="imagenPerfil" class="dropzone cargadorImg " id="my-dropzone-perfil" method="post" enctype="multipart/form-data">
                    <div class="fallback" >
                        <input name="file" type="file" multiple />
                        <input type="text" class="form-control hidden" id="inputMenu1_idChef" name="img_perfil_idChef" value="{{$id_chef}}">
                       
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                </form>
            </div>
            <div class="estrellas">
                <div class="ec-stars-wrapper" puntuacion = "@if($chef->puntuacion_total !=0){{($chef->puntuacion_total / $chef->numero_Votos)}}@endif">
                    <a vota="1" title="Votar con 1 estrellas">&#9733;</a>
                    <a vota="2" title="Votar con 2 estrellas">&#9733;</a>
                    <a vota="3" title="Votar con 3 estrellas">&#9733;</a>
                    <a vota="4" title="Votar con 4 estrellas">&#9733;</a>
                    <a vota="5" title="Votar con 5 estrellas">&#9733;</a>
                </div>
            </div>
            <div class=" alerta">
                <form class="form-horizontal" method="POST" action = "puntuacion">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">                    
                    <input type="text" class="form-control hidden" id="votar" name="votar" value="">
                    <input type="text" class="form-control hidden" id="id_chef" name="id_chef" value="{{$id_chef}}">
                    <div class="form-group">
                        <div class="">
                            <p id = "textoVoto"></p>
                           <label class="btn btn-xs btn-default cancelaVoto">Cancelar</label>
                           <button id="ButtonGuardaPerfil" type="submit" class="botonOK btn btn-xs btn-primary">Vota</button>
                        </div>
                    </div>
                </form>                
            </div>         
        </div>
        <!--/SECCION PERFIL -->
        <!-- SECCION SOBRE_MI -->
        <div class="caixaSobreMi col-xs-12 col-ms-12 col-offset-md-1 col-offset-lg-1 col-md-8 col-lg-8 pull-right ">
            <div class ="padding10">                
                <h1 class="hChef">Sobre mi</h1>                
                <form class="form-horizontal" method="POST" action = "insertarPerfil">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="text" class="form-control hidden" id="id_chefPerfil" name="id_chefPerfil" value="{{$id_chef}}">
                    <div class="form-group">
                        @if($edit)<a><span class=" botonOK editaPerfil label label-info">Editar</span></a>@endif                       
                    </div>
                    <div class = "textareaPerfil">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <textarea class="form-control" rows="5" id="textareaDescripcion"  name="textareaDescripcion"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="btn btn-sm btn-default cancelaSobreMi">Cancelar</label>
                                <button id="ButtonGuardaPerfil" type="submit" class="botonOK btn btn-sm btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>                
                <div class="divDescripcion">
                    <p class="pDescripcion">{{$chef->descripcion}}
                </div>
            </div>
        </div> 
        <!--/SECCION SOBRE_MI -->
    </div>
    <div class="row ">   
        <div class=" caixa col-xs-12 col-ms-12 col-md-12 col-lg-12 padding20">
        <!-- SECCION MENU -->
        <div class ="padding10">
            <h1 class="hChef">Menú</h1>
                <form class="form-horizontal posicionEditMenus">
                    <div class="form-group">
                        @if($edit)<span class=" botonOK editaImgMenus label label-info">Editar</span>@endif
                    </div>
                </form>
            <div class="row">                
                <div class=" col-xs-12 col-ms-12 col-md-4 col-lg-4 ">
                    <div class = "imgMenus">
                        <form action="imagenMenu1" class="dropzone cargadorImgMenus centrado" id="my-awesome-dropzone2" method="post" enctype="multipart/form-data">
                            <div class="fallback">
                                <input name="file" type="file" multiple />                                
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        </form>
                    </div>                            
                </div>
                <div class=" col-xs-12 col-ms-12 col-md-4 col-lg-4 ">
                    <div class = "imgMenus">
                        <form action="imagenMenu2" class="dropzone cargadorImgMenus centrado" id="my-awesome-dropzone3" method="post" enctype="multipart/form-data">
                            <div class="fallback">
                                <input name="file" type="file" multiple />                                
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        </form>
                    </div>                            
                </div>
                <div class=" col-xs-12 col-ms-12 col-md-4 col-lg-4 "> 
                    <div class = "imgMenus">
                        <form action="imagenMenu3" class="dropzone cargadorImgMenus centrado" id="my-awesome-dropzone4" method="post" enctype="multipart/form-data">
                            <div class="fallback">
                                <input name="file" type="file" multiple />                                
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        </form>
                    </div>                           
                </div>

                <div class=" col-xs-12 col-ms-12 col-md-4 col-lg-4 ">                            
                    <a data-toggle="modal" data-target="#menu1" href="#"><img class="caixmenu centrado" src="@if(!empty($fotos)) @if(isset($fotos['menu1'])){{$fotos['menu1']}}@endif @endif"></a> 
                </div>
                <div class=" col-xs-12 col-ms-12 col-md-4 col-lg-4 ">
                    <a data-toggle="modal" data-target="#menu2" href="#"><img class="caixmenu centrado" src="@if(!empty($fotos)) @if(isset($fotos['menu2'])){{$fotos['menu2']}}@endif @endif"></a>
                </div>
                <div class=" col-xs-12 col-ms-12 col-md-4 col-lg-4">
                    <a data-toggle="modal" data-target="#menu3" href="#"><img class="caixmenu centrado" src="@if(!empty($fotos)) @if(isset($fotos['menu3'])){{$fotos['menu3']}}@endif @endif"></a>
                </div>
            </div>
           <!-- <button type="button" class=" pull-right btn btn-lg  btn-primary botonOK" data-toggle="modal" data-target="#vinos">
             vinos
            </button>-->
            <!--MODAL MENU 1-->
            <div class="modal fade" id="menu1" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modalFondoMenus">
                        <div class="modal-header ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h2 class="modal-title">Menú</h2>
                        </div>
                        <div class="modal-body modalImgFondo">
                            <form class="form-horizontal"  method="POST" action = "insertarMenu1" role="form" data-toggle="validator">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="text" class="form-control hidden" id="inputMenu1_idChef" name="inputMenu1_idChef" value="{{$id_chef}}">
                                <div class="form-group">
                                    @if($edit)<a><span class=" botonOK editaMenu label label-info">Editar</span></a>@endif
                                </div>                            
                                <div class="">
                                    <h2 class="modaltitle">Entrantes</h2>
                                    <input type="text" class="form-control" name="inputMenu1_Entrante1" id="inputMenu1_Entrante1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Entrante1" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['entrantes'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Entrante2" id="inputMenu1_Entrante2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Entrante2" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['entrantes'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Entrante3" id="inputMenu1_Entrante3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Entrante3" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['entrantes'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Primeros</h2>
                                    <input type="text" class="form-control" name="inputMenu1_Primero1" id="inputMenu1_Primero1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Primero1" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['primeros'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Primero2" id="inputMenu1_Primero2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Primero2" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['primeros'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Primero3" id="inputMenu1_Primero3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Primero3" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['primeros'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Segundos</h2>
                                    <input type="text" class="form-control" name="inputMenu1_Segundo1" id="inputMenu1_Segundo1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Segundo1" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['segundos'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Segundo2" id="inputMenu1_Segundo2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Segundo2" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['segundos'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Segundo3" id="inputMenu1_Segundo3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Segundo3" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['segundos'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Postres</h2>
                                    <input type="text" class="form-control" name="inputMenu1_Postre1" id="inputMenu1_Postre1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Postre1" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['postres'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Postre2" id="inputMenu1_Postre2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Postre2" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['postres'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu1_Postre3" id="inputMenu1_Postre3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu1_Postre3" class="platos">@if(!empty($menus)) @if(isset($menus['menu1'])){{$menus['menu1']['postres'][2]}}@endif @endif</p>
                                    <h2 id="menu1_Precio" class="modaltitle">@if(!empty($precios))  @if(isset($precios['menu1'])){{$precios['menu1']}} € @endif @endif</h2>
                                    <input type="number" class="form-control" name="inputMenu1_precio" id="inputMenu1_precio" placeholder="Introduce aqui el precio" required>
                                    
                                </div>
                                <div class="form-group botonMenus">
                                    <div class="col-lg-12">
                                        <label class="btn btn-sm btn-default cancelaMenu">Cancelar</label>
                                        <button id="ButtonGuardaMenu1" type="submit" class=" botonOK btn btn-sm btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/MODAL MENU 1-->
            <!--MODAL MENU 2-->
            <div class="modal fade" id="menu2" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modalFondoMenus">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h2 class="modal-title">Menú</h2>
                        </div>
                        <div class="modal-body modalImgFondo">
                            <form class="form-horizontal"  method="POST" action = "insertarMenu2" role="form" data-toggle="validator">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="text" class="form-control hidden" id="inputMenu2_idChef" name="inputMenu2_idChef" value="{{$id_chef}}">
                                <div class="form-group">
                                    @if($edit)<a><span class=" botonOK editaMenu label label-info">Editar</span></a>@endif
                                </div>                            
                                <div class="">
                                    <h2 class="modaltitle">Entrantes</h2>
                                    <input type="text" class="form-control" name="inputMenu2_Entrante1" id="inputMenu2_Entrante1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Entrante1" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['entrantes'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Entrante2" id="inputMenu2_Entrante2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Entrante2" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['entrantes'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Entrante3" id="inputMenu2_Entrante3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Entrante3" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['entrantes'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Primeros</h2>
                                    <input type="text" class="form-control" name="inputMenu2_Primero1" id="inputMenu2_Primero1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Primero1" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['primeros'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Primero2" id="inputMenu2_Primero2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Primero2" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['primeros'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Primero3" id="inputMenu2_Primero3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Primero3" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['primeros'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Segundos</h2>
                                    <input type="text" class="form-control" name="inputMenu2_Segundo1" id="inputMenu2_Segundo1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Segundo1" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['segundos'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Segundo2" id="inputMenu2_Segundo2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Segundo2" class="platos" >@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['segundos'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Segundo3" id="inputMenu2_Segundo3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Segundo3" class="platos">@if(!empty($menus)) @if(isset($menus['menu2'])){{$menus['menu2']['segundos'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Postres</h2>
                                    <input type="text" class="form-control" name="inputMenu2_Postre1" id="inputMenu2_Postre1" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Postre1" class="platos">@if(!empty($menus))@if(isset($menus['menu2'])){{$menus['menu2']['postres'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Postre2" id="inputMenu2_Postre2" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Postre2" class="platos">@if(!empty($menus))@if(isset($menus['menu2'])){{$menus['menu2']['postres'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu2_Postre3" id="inputMenu2_Postre3" placeholder="Introduce aqui el menu" required>
                                    <p id="menu2_Postre3" class="platos">@if(!empty($menus))@if(isset($menus['menu2'])){{$menus['menu2']['postres'][2]}}@endif @endif</p>
                                    <h2 id="menu2_Precio" class="modaltitle">@if(!empty($precios)) @if(isset($precios['menu2'])){{$precios['menu2']}} €@endif @endif</h2>
                                    <input type="number" class="form-control" name="inputMenu2_precio" id="inputMenu2_precio" placeholder="Introduce aqui el precio" required>
                                </div>
                                <div class="form-group botonMenus">
                                    <div class="col-lg-12">
                                        <label class="btn btn-sm btn-default cancelaMenu">Cancelar</label>
                                        <button id="ButtonGuardaMenu1" type="submit" class=" botonOK btn btn-sm btn-primary">Guardar</button>
                                    </div>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/MODAL MENU 2-->
            <!--MODAL MENU 3-->
            <div class="modal fade" id="menu3" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modalFondoMenus">
                        <div class="modal-header ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h2 class="modal-title">Menú</h2>
                        </div>
                        <div class="modal-body modalImgFondo">
                            <form class="form-horizontal" method="POST" action = "insertarMenu3" role="form" data-toggle="validator">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="text" class="form-control hidden" id="inputMenu3_idChef" name="inputMenu3_idChef" value="{{$id_chef}}">
                                <div class="form-group">
                                    @if($edit)<a><span class=" botonOK editaMenu label label-info">Editar</span></a>@endif
                                </div>                            
                                <div class="">
                                    <h2 class="modaltitle">Entrantes</h2>
                                    <input type="text" class="form-control" name="inputMenu3_Entrante1" id="inputMenu3_Entrante1"  placeholder="Introduce aqui el menu" data-minlength="3" required>
                                    <p id="menu3_Entrante1" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['entrantes'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Entrante2" id="inputMenu3_Entrante2"  placeholder="Introduce aqui el menu" data-minlength="3" required>
                                    <p id="menu3_Entrante2" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['entrantes'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Entrante3" id="inputMenu3_Entrante3"  placeholder="Introduce aqui el menu" data-minlength="3" required>
                                    <p id="menu3_Entrante3" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['entrantes'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Primeros</h2>
                                    <input type="text" class="form-control" name="inputMenu3_Primero1" id="inputMenu3_Primero1"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Primero1" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['primeros'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Primero2" id="inputMenu3_Primero2"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Primero2" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['primeros'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Primero3" id="inputMenu3_Primero3"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Primero3" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['primeros'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Segundos</h2>
                                    <input type="text" class="form-control" name="inputMenu3_Segundo1" id="inputMenu3_Segundo1"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Segundo1" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['segundos'][0]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Segundo2" id="inputMenu3_Segundo2"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Segundo2" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['segundos'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Segundo3" id="inputMenu3_Segundo3"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Segundo3" class="platos" >@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['segundos'][2]}}@endif @endif</p>

                                    <h2 class="modaltitle">Postres</h2>
                                    <input type="text" class="form-control" name="inputMenu3_Postre1" id="inputMenu3_Postre1"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Postre1" class="platos">@if(!empty($menus)) @if(isset($menus['menu3'])){{$menus['menu3']['postres'][0]}} @endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Postre2" id="inputMenu3_Postre2"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Postre2" class="platos">@if(!empty($menus))@if(isset($menus['menu3'])){{$menus['menu3']['postres'][1]}}@endif @endif</p>
                                    <input type="text" class="form-control" name="inputMenu3_Postre3" id="inputMenu3_Postre3"  placeholder="Introduce aqui el menu" required>
                                    <p id="menu3_Postre3" class="platos">@if(!empty($menus))@if(isset($menus['menu3'])){{$menus['menu3']['postres'][2]}}@endif @endif</p>
                                    <h2 id="menu3_Precio" class="modaltitle">@if(!empty($precios)) @if(isset($precios['menu3'])){{$precios['menu3']}} € @endif @endif</h2>
                                    <input type="number" class="form-control" name="inputMenu3_precio" id="inputMenu3_precio" placeholder="Introduce aqui el precio" required>
                                </div>
                                <div class="form-group botonMenus">
                                    <div class="col-lg-12">
                                        <label class="btn btn-sm btn-default cancelaMenu">Cancelar</label>
                                        <button id="ButtonGuardaMenu1" type="submit" class=" botonOK btn btn-sm btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/MODAL MENU 3-->
            <!-- MODAL VINOS -->
          <!--  <div class="modal fade" id="vinos" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div >
                        <div class="col-xs-offset-10 col-ms-offset-10 col-md-offset-10 col-lg-offset-10 col-xs-2 col-ms-2 col-md-2 col-lg-2">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <a><span class=" editaVinos label label-info">Editar</span></a>
                                </div>
                            </form> 
                        </div>
                        <div class="caixaVinos  col-xs-12 col-ms-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-2 col-ms-2 col-md-2 col-lg-2">
                                    <img class="imagenvino" src="img/vino.png" >
                                </div>
                                <div class=" textoVinos col-xs-10 col-ms-10 col-md-10 col-lg-10">
                                    <input type="text" class="form-control" id="inputVino1_titulo" placeholder="">
                                    <h3 id="Vino1_titulo" >Nombre del vino</h3>
                                    <input type="text" class="form-control" id="inputVino1_desc" placeholder="">
                                    <p id="Vino1_desc">Donec eleifend rhoncus erat. Pellentesque eget porta est, nec congue eros. Proin purus elit, mattis a consectetur in, tincidunt cursus purus.</p>                                   
                                </div>                                
                            </div>
                        </div>
                        <div class="caixaVinos  col-xs-12 col-ms-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-2 col-ms-2 col-md-2 col-lg-2">
                                    <img class="imagenvino" src="img/vino.png" >
                                </div>
                                <div class=" textoVinos col-xs-10 col-ms-10 col-md-10 col-lg-10">
                                    <input type="text" class="form-control" id="inputVino2_titulo" placeholder="">
                                    <h3 id="Vino2_titulo">Nombre del vino</h3>
                                    <input type="text" class="form-control" id="inputVino2_desc" placeholder="">
                                    <p id="Vino2_desc">Donec eleifend rhoncus erat. Pellentesque eget porta est, nec congue eros. Proin purus elit, mattis a consectetur in, tincidunt cursus purus.</p>
                                </div>
                            </div>
                        </div>
                        <div class="caixaVinos  col-xs-12 col-ms-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-2 col-ms-2 col-md-2 col-lg-2">
                                    <img class="imagenvino" src="img/vino.png" >
                                </div>
                                <div class=" textoVinos col-xs-10 col-ms-10 col-md-10 col-lg-10">
                                    <input type="text" class="form-control" id="inputVino3_titulo" placeholder="">
                                    <h3 id="Vino3_titulo">Nombre del vino</h3>
                                    <input type="text" class="form-control" id="inputVino3_desc" placeholder="">
                                    <p id="Vino3_desc">Donec eleifend rhoncus erat. Pellentesque eget porta est, nec congue eros. Proin purus elit, mattis a consectetur in, tincidunt cursus purus.</p>
                                </div>
                            </div>
                        </div>
                        <div class="caixaVinos  col-xs-12 col-ms-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-2 col-ms-2 col-md-2 col-lg-2">
                                    <img class="imagenvino" src="img/vino.png" >
                                </div>
                                <div class=" textoVinos col-xs-10 col-ms-10 col-md-10 col-lg-10">
                                    <input type="text" class="form-control" id="inputVino4_titulo" placeholder="">
                                    <h3 id="Vino4_titulo">Nombre del vino</h3>
                                    <input type="text" class="form-control" id="inputVino4_desc" placeholder="">
                                    <p id="Vino4_desc">Donec eleifend rhoncus erat. Pellentesque eget porta est, nec congue eros. Proin purus elit, mattis a consectetur in, tincidunt cursus purus.</p>
                                </div>
                            </div>
                        </div>
                        <form class="form-horizontal">
                            <div class="form-group botonVinos">                               
                                <label class="btn btn-sm btn-default cancelaVinos">Cancelar</label>
                                <button id="" type="submit" class=" botonOK btn btn-sm btn-primary">Guardar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>-->
            <!--/MODAL VINOS -->
        </div>
        <!--/SECCION MENU -->
        <!-- SECCION GALERIA -->   
        <div class="col-xs-12 col-ms-12 col-md-12 col-lg-12 padding20">
            <h1 class="hChef">Galería</h1>
                <div class="panel ">
                    <div class="row">
                        <!--RECORDAR CAMBIAR LAS COL'S  POR col-xs-6 col-ms-6 col-md-6 col-lg-6 SI SE PONE EL VIDEO-->
                        <div id = "fotodiv"  class=" elementos panel-heading col-xs-12 col-ms-12 col-md-12 col-lg-12 ">FOTOS     
                            @if($edit)<span class=" botonOK editaImgGaleria label label-info" data-toggle="modal" data-target="#subeImg">Editar</span>@endif                                

                            <div id="subeImg" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3 class="modal-title">Editar imagenes de la galería</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h4 class="modal-title">Subir imagenes a la galería</h4>
                                            <form id="my-awesome-dropzone" class=" form-horizontal dropzone cargadorImgModal modalGaleria" action="imagenGaleria">
                                                <div class="dropzone-previews"></div> <!-- this is were the previews should be shown. -->
                                                <!-- Now setup your input fields -->
                                                
                                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                <div class="form-group form-group-margenes">
                                                    <label class="col-xs-2 col-ms-2 col-md-2 col-lg-2 control-label">Titulo</label>
                                                    <div class=" col-xs-10 col-ms-10 col-md-8 col-lg-10">
                                                        <span class="label label-warning">Introduce el titulo antes de insertar la imagen</span>
                                                        <input class="form-control" name="tituloImg" id="tituloImg"></input>
                                                    </div>
                                                    <div class="col-xs-2 col-ms-2 col-md-2 col-lg-2" >
                                                        <button id="buttonComentari" type="submit" class="botonOK btn btn-primary hidden">Submit</button>
                                                  </div>
                                                </div>
                                                <div class="form-group form-group-margenes">
                                                  
                                                </div>
                                            </form>
                                        
                                            <hr>
                                            <h4 class="modal-title">Eliminar imagenes de la galería</h4>
                                            <div class="modalGaleria">
                                                @if(!empty($fotos)) 
                                                    @if(isset($fotos['galeria']))
                                                        @foreach ($fotos['galeria'] as $foto)
                                                            <form class="form-horizontal" method="POST" action = "eliminarFotosGaleria" style=" float:left; width:60px;">
                                                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control hidden" id="id_foto" name="id_foto" value="{{$foto['id']}}">
                                                                    <button id="btnfoto" type="submit" class="botonOK btn btn-primary" style="padding:0px !important;"><img src="{{$foto['img']}}" alt="" style="height:50px; width:50px;"></button>
                                                                </div>
                                                            </form>                                                    
                                                        @endforeach                                            
                                                    @endif 
                                                @endif
                                                <div style="clear:left;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- VIDEO POR ACABAR-->
                        <!--<div id = "videodiv" class=" elementos noactivo panel-heading col-xs-6 col-ms-6 col-md-6 col-lg-6">VIDEOS</div>-->
                        <div class="panel-body contingut">
                            <div id="foto" class="   "> 
                               <div id="blueimp-gallery-dialog" data-show="fade" data-hide="fade">
                                    <!-- The gallery widget  -->
                                    <div class="blueimp-gallery blueimp-gallery-carousel blueimp-gallery-controls">
                                        <div class="slides"></div>
                                        <a class="prev">‹</a>
                                        <a class="next">›</a>
                                        <a class="play-pause"></a>
                                    </div>
                                </div>                             
                                
                                <div id="links" style="height:377px; overflow-y:auto !important;">

                                    @if(!empty($fotos)) 
                                        @if(isset($fotos['galeria']))
                                            @foreach ($fotos['galeria'] as $foto)                            
                                                <a href="{{$foto['img']}}" title="{{$foto['desc']}}" data-dialog>
                                                    <img src="{{$foto['img']}}" alt="" style="height:100px; width:100px;">
                                                </a>
                                            @endforeach                                            
                                        @endif 
                                    @endif                                    
                                </div>
                            </div>
                            <!-- 
                            <div id="video" class="  ">
                                <div class="row">
                                    <div class="col-xs-9 col-ms-9 col-md-9 col-lg-9">
                                        <video  class="centrado" style="height:350px; width:700px;" controls >
                                            <source id="verVideo" src="http://www.mychef.cat/videos/video1.webm" type="video/webm" style="height:350px; width:700px;">
                                        </video>
                                    </div> 
                                    <div class="col-xs-3 col-ms-3 col-md-3 col-lg-3" style="height:350px; overflow-y:auto !important;">
                                        <video  class="v centrado" style="height:200px; width:200px;"  >
                                            <source  src="http://www.mychef.cat/videos/video2.webm" type="video/webm">
                                        </video>
                                        <video  class="v centrado" style="height:200px; width:200px;"  >
                                            <source  src="http://www.mychef.cat/videos/video1.webm" type="video/webm">
                                        </video>
                                        <video  class="v centrado" style="height:200px; width:200px;"  >
                                            <source  src="http://www.mychef.cat/videos/video1.webm" type="video/webm">
                                        </video>
                                        <video  class="v centrado" style="height:200px; width:200px;"  >
                                            <source  src="http://www.mychef.cat/videos/video1.webm" type="video/webm">
                                        </video>
                                        <video  class="v centrado" style="height:200px; width:200px;"  >
                                            <source src="http://www.mychef.cat/videos/video1.webm" type="video/webm">
                                        </video>
                                        <video  class="v centrado" style="height:200px; width:200px;"  >
                                            <source  src="http://www.mychef.cat/videos/video1.webm" type="video/webm">
                                        </video>                                        
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div> 
        <!--/SECCION GALERIA -->  
        <!-- SECCION COMENTARIOS -->
        <div class="col-xs-12 col-ms-12 col-md-12 col-lg-12 padding20">
            <h1 class="hChef">Comentarios</h1>
            <div id="listaComents" class="">
                @for ($i = 0; $i < count($opiniones); $i++)
                    @if(!empty($opiniones[$i]['comentario']))
                        <blockquote>                    
                            <p> {{$opiniones[$i]['comentario']}} </p>
                            <small> {{$opiniones[$i]['nombre']}}</small>                    
                        </blockquote>
                    @endif
                @endfor
            </div>
            
            <div class="panel ">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action = "opinion">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="text" class="form-control hidden" id="coments_idChef" name="coments_idChef" value="{{$id_chef}}">
                        <div class="form-group form-group-margenes">
                            <label for="textArea" class="col-xs-2 col-ms-2 col-md-2 col-lg-2 control-label">Comentario</label>
                            <div class=" col-xs-10 col-ms-10 col-md-10 col-lg-10">
                                <textarea class="form-control" rows="3" name="textAreaComent" id="textAreaComent"></textarea>
                            </div>
                        </div>
                        <div class="form-group form-group-margenes">
                          <div class="col-lg-10 col-lg-offset-2">
                            <button id="buttonComentari" type="submit" class="botonOK btn btn-primary">Enviar</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <!--/SECCION COMENTARIOS -->
        </div>
    </div>
</div>
    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='alert alert-dismissible alert-danger notificacion'>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ $error }}
            </div>
        @endforeach
    @endif      
@stop