<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="MYCHEF Team">
		<meta name="designer" content="MYCHEF Team">
		<meta name="Description" content="Contrata un chef profesional para que cocine para ti en tu casa.">
		<meta name="Keywords" content="">
		<meta name="application-name" content="MyChef - Chef a domicilio">
		<meta name="msapplication-TileColor" content="#ffffff">

		<link rel="shortcut icon" href="" type="image/ico" />
		<link rel="icon" href="" type="image/ico" />

        <title>MyChef - Tu chef a domicilio | @yield('title')</title>


        

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <link rel="stylesheet" type="text/css" href="http://www.mychef.cat/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="http://www.mychef.cat/css/code.css"/>
        <link rel="stylesheet" type="text/css" href="http://www.mychef.cat/css/chef.css"/>
        <link rel="stylesheet" type="text/css" href="http://www.mychef.cat/css/basic.css"/>
        <link rel="stylesheet" type="text/css" href="http://www.mychef.cat/css/dropzone.css"/>
        <link rel="stylesheet" type="text/css" href="http://www.mychef.cat/css/principal.css"/>

        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/south-street/jquery-ui.css" id="theme"/>
        <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css"/>
  


		<!-- SCRIPT CONTROL DE COOKIES -->
		<script type="text/javascript">
		function controlcookies() {
			//si variable no existe se crea (al clicar en Aceptar)
			localStorage.controlcookiemychef = (localStorage.controlcookiemychef || 0);

			localStorage.controlcookiemychef++; // incrementamos cuenta de la cookie
			cookie1.style.display='none'; // Esconde la política de cookies
		}
		</script>

		<!--- Codigo para la política de cookies-->


		<style type="text/css">

		/* CSS para la animación y localización de los DIV de cookies */

    		.cookiesms{
    			width:100%;
    			height:51px;
    			margin:0 auto;
    			padding-left:1%;
    				padding-top:5px;
    			clear:both;
    				font-weight: strong;
    			color: #333;
    			bottom:0px;
    			position:fixed;
    			left: 0px;
    			background-color: #FFF;
    			opacity:0.8;
    			filter:alpha(opacity=80);
    			z-index:999999999;
    			text-align:center
    		}


		/* Fin del CSS para cookies */

		</style>
    </head>

    <body>

        <script src="http://www.mychef.cat/js/jquery-1.11.3.min.js"></script>
    	<script src="http://www.mychef.cat/js/bootstrap.min.js"></script>
        
        
        
        <script type="text/javascript" src="http://www.mychef.cat/js/chef/chef.js"></script>        
        <script type="text/javascript" src="http://www.mychef.cat/js/chef/iu_chef.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/chef/events_chef.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/dropzone-amd-module.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/dropzone.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/chef/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/ocultar.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/jspdf.min.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/html2canvas.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/principal.js"></script>

        
        <script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
        <script type="text/javascript" src="http://www.mychef.cat/js/jquery.image-gallery.min.js"></script>
       

        <!-- Sección -->
    	<div class='container-fluid'>
    		<div class='row'>
    			@yield('content')
    		</div>
    	</div>

        <!-- Footer -->
        <div class='footer'>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                        <strong>¿Eres Chef y quieres trabajar con nosotros?</strong>
                        <br/>
                        <small>Telefono gratuito: 900 832 342</small>
                        <br/>
                        <small>Envia tu CV: <a href='mailto:contacto@mychef.cat'>contacto@mychef.cat</a></small>
                    </div>
                    <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                        <strong>Legal</strong>
                        <br/>
                        <a href='#'><small>Términos legales</small></a>
                        <br/>
                        <a href='#'><small>Política de cookies</small></a>
                    </div>
                    <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                        <strong>Pago seguro</strong>
                        <br/>
                        <img id='metodosPagoFooter' src="http://www.mychef.cat/img/pagos.png"></img>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <small><em>Copyright © 2016 MyChef. Todos los derechos reservados.</em></small>
                    </div>
                </div>
            </div>
        </div>

    	<!--Código HTML de la política de cookies -->

    	<!--La URL incluida es la parte que se ha de modificar -->

    	<div class="cookiesms" id="cookie1">
          	<small>Esta web utiliza cookies, puedes ver nuestra política de cookies<a href="http://www.mychef.cat"> aquí.</a>.
          	Si continuas navegando estás aceptándola.</small>
            <button class="btn btn-xs btn-success" onclick="controlcookies()">Aceptar</button>
    	</div>
    	<script type="text/javascript">
        	if (localStorage.controlcookiemychef>0){
        		cookie1.style.display='none';
        	}
    	</script>

    	<!-- Fin del código de cookies -->
    </body>
</html>
