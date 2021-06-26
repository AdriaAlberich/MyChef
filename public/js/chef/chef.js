function CHEF(){
        
    var src_imagenes_chef = ["http://www.mychef.cat/img/menu1.png", "http://www.mychef.cat/img/menu2.jpg", "http://www.mychef.cat/img/menu3.jpg"];
    
    //var Dropzone = require("dropzone");
    
    var votaciones_valor = 0; 
    var votaciones_total; 
    
    this.introComentario = introComentario;
    this.quitarErrors = quitarErrors;
    this.insertaVotos = insertaVotos;

    
    //Guarda la votacion (sin acabar, falta controlar que no se pueda votar a si mismo)
    function insertaVotos (){
        
        $('#textoVoto').empty();
        $num = $(this).attr("vota");
        
        $('#votar').attr('value', $num);
        $('#textoVoto').prepend("Deseas votar con " + $num + " estrellas?");
        $('.alerta').show();
        
    }
     
    
    // Introduce el comentario en la lista
    function introComentario(){
        $nom = $('#inputNom').val();
        $coment = $('#textAreaComent').val();
        
        validar($nom, $coment);
        
        $intoducir = '<blockquote>' +
                            '<p>' + $coment + '</p>' + 
                           ' <small>' + $nom + '</small>' +
                        '</blockquote>';
        
        $('#listaComents').prepend($intoducir);    
    }
    
    //valida los inputs del comentario
    function validar($nom, $coment){
        var nomOK = false;
        var comentOK = false;
        
        if($nom != ""){
            nomOK = true;
        }
        else {
            $('#inputNom').parent().addClass("has-error");
        }
        if($coment != ""){
            nomOK = true;
        }
        else {
            $('#textAreaComent').parent().addClass("has-error");
        }
    }
    
    //quita el has-error de los inputs
    function quitarErrors(){
         $('#inputNom').parent().removeClass("has-error");
         $('#textAreaComent').parent().removeClass("has-error");
    }
    function buttonGuardaPerfil(){
        $descripcion = $('.editaPerfil').text();
        
      
    }
    
    
}

      