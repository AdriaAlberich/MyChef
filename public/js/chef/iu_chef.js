function IU_CHEF(){
    
    //var chef = new CHEF();
    
    this.inicio = inicio;
    this.activar = activar;
    this.activar2 = activar2;
    this.textareaOpen = textareaOpen; // muestra/oculta edtiar sobre mi
    //this.ocultaInputsMenu = ocultaInputsMenu; // oculta inputs menu al inicio
    this.inputsOpen = inputsOpen; // muestra/oculta edtiar menu
    this.editaImgPerfilOpen = editaImgPerfilOpen; // muestra/oculta edtiar imagen perfil
    this.editaVinosOpen = editaVinosOpen; // muestra/oculta edtiar vinos
    this.insertaVotos = insertaVotos; //'pinta' las estrellas con la puntuacin del chef
    this.votarHovers = votarHovers; //activa el hover de las estrellas para poder votar
    this.ocultaAlertaVotos = ocultaAlertaVotos;
    this.cargaVideo = cargaVideo;
    this.ocultaInputsMenu = ocultaInputsMenu;
    this.ocultaInputsVinos = ocultaInputsVinos;
    this.cancelaSobreMi = cancelaSobreMi;
    this.editaImgMenusOpen = editaImgMenusOpen;
    
    
    $inputsMenu1 = [$('#inputMenu1_Entrante1'), $('#inputMenu1_Entrante2'), $('#inputMenu1_Entrante3'), 
                    $('#inputMenu1_Primero1'), $('#inputMenu1_Primero2'), $('#inputMenu1_Primero3'),
                    $('#inputMenu1_Segundo1'), $('#inputMenu1_Segundo2'), $('#inputMenu1_Segundo3'),
                    $('#inputMenu1_Postre1'), $('#inputMenu1_Postre2'), $('#inputMenu1_Postre3'), $('#inputMenu1_precio')];

    $inputsMenu2 = [$('#inputMenu2_Entrante1'), $('#inputMenu2_Entrante2'), $('#inputMenu2_Entrante3'), 
                    $('#inputMenu2_Primero1'), $('#inputMenu2_Primero2'), $('#inputMenu2_Primero3'),
                    $('#inputMenu2_Segundo1'), $('#inputMenu2_Segundo2'), $('#inputMenu2_Segundo3'),
                    $('#inputMenu2_Postre1'), $('#inputMenu2_Postre2'), $('#inputMenu2_Postre3'), $('#inputMenu2_precio')
                   ];
    $inputsMenu3 = [$('#inputMenu3_Entrante1'), $('#inputMenu3_Entrante2'), $('#inputMenu3_Entrante3'), 
                    $('#inputMenu3_Primero1'), $('#inputMenu3_Primero2'), $('#inputMenu3_Primero3'),
                    $('#inputMenu3_Segundo1'), $('#inputMenu3_Segundo2'), $('#inputMenu3_Segundo3'),
                    $('#inputMenu3_Postre1'), $('#inputMenu3_Postre2'), $('#inputMenu3_Postre3'), $('#inputMenu3_precio')
                   ];
    $pMenu1 = [$('#menu1_Entrante1'), $('#menu1_Entrante2'), $('#menu1_Entrante3'), 
               $('#menu1_Primero1'), $('#menu1_Primero2'), $('#menu1_Primero3'),
               $('#menu1_Segundo1'), $('#menu1_Segundo2'), $('#menu1_Segundo3'),
               $('#menu1_Postre1'), $('#menu1_Postre2'), $('#menu1_Postre3'), $('#menu1_Precio')
              ];
    $pMenu2 = [$('#menu2_Entrante1'), $('#menu2_Entrante2'), $('#menu2_Entrante3'), 
               $('#menu2_Primero1'), $('#menu2_Primero2'), $('#menu2_Primero3'),
               $('#menu2_Segundo1'), $('#menu2_Segundo2'), $('#menu2_Segundo3'),
               $('#menu2_Postre1'), $('#menu2_Postre2'), $('#menu2_Postre3'), $('#menu2_Precio')
              ];
    $pMenu3 = [$('#menu3_Entrante1'), $('#menu3_Entrante2'), $('#menu3_Entrante3'), 
               $('#menu3_Primero1'), $('#menu3_Primero2'), $('#menu3_Primero3'),
               $('#menu3_Segundo1'), $('#menu3_Segundo2'), $('#menu3_Segundo3'),
               $('#menu3_Postre1'), $('#menu3_Postre2'), $('#menu3_Postre3'), $('#menu3_Precio')
              ];
    
    $inputsVinos = [$('#inputVino1_titulo'), $('#inputVino1_desc'), 
                    $('#inputVino2_titulo'), $('#inputVino2_desc'), 
                    $('#inputVino3_titulo'), $('#inputVino3_desc'), 
                    $('#inputVino4_titulo'), $('#inputVino4_desc')];
    $pVinos  = [$('#Vino1_titulo'), $('#Vino1_desc'), 
                $('#Vino2_titulo'), $('#Vino2_desc'), 
                $('#Vino3_titulo'), $('#Vino3_desc'),  
                $('#Vino4_titulo'), $('#Vino4_desc')];
    
    function inicio (){
        $("#video").hide();
        $("#links img").attr("style", "height: 200px !important; width: 200px;!important");
        ocultaInputsMenu();
        $("#video").hide();
        $('.textareaPerfil').hide();
        $('.imgPerfil').hide();
        $('.imgMenus').hide();
        ocultaInputsVinos();
        insertaVotos();
        ocultaAlertaVotos();
        
    }
    function ocultaAlertaVotos (){
        $('.alerta').hide();
         $('#textoVoto').text("");
    }
    
    function cancelaSobreMi(){
         $('.textareaPerfil').hide();
    }
           
    function activar(){
        $("#videodiv").removeClass( "noactivo" );
        $("#fotodiv").addClass( "noactivo" );
        $("#foto").hide();
        $("#video").removeClass("invisible").show();
    }

    function activar2(){
        $("#fotodiv").removeClass( "noactivo" );
        $("#videodiv").addClass( "noactivo" );
        $("#video").hide();
        $("#foto").show();
    }
    
    function textareaOpen(){
        $('#textareaDescripcion').val("");  
        
        $('.textareaPerfil').slideToggle();
        $('.pDescripcion' ).each(function(){
            $desc = $(this).text() + '\n\n'; 
            $('#textareaDescripcion').val($('#textareaDescripcion').val()+ $desc);         
        });
        $('.divDescripcion' ).slideToggle();
        
    }
    
    function ocultaInputsMenu(){
        for (var i = 0; i<13; i++ ){
            $inputsMenu1[i].hide();
            $inputsMenu2[i].hide();
            $inputsMenu3[i].hide();           
        }
        $('.botonMenus').hide();
    }
    
    function inputsOpen(){ //str.trim()
        $pMenu1[12].text($pMenu1[12].text().trim());
        $pMenu2[12].text($pMenu2[12].text().trim());
        $pMenu3[12].text($pMenu3[12].text().trim());

        $aux1 = $pMenu1[12].text().split(" ");
        $aux2 = $pMenu2[12].text().split(" ");
        $aux3 = $pMenu3[12].text().split(" ");

        $pMenu1[12].text(parseInt($aux1[0]));
        $pMenu2[12].text(parseInt($aux2[0]));
        $pMenu3[12].text(parseInt($aux3[0]));
        
        $('.botonMenus').slideToggle();
      
        for (var i = 0; i<13; i++ ){
                        
            $inputsMenu1[i].slideToggle();
            $inputsMenu2[i].slideToggle();
            $inputsMenu3[i].slideToggle();       
                    
            $textM1 = $.trim($pMenu1[i].text());
            $textM2 = $.trim($pMenu2[i].text());
            $textM3 = $.trim($pMenu3[i].text());
                 
            $inputsMenu1[i].val($textM1);
            $inputsMenu2[i].val($textM2);
            $inputsMenu3[i].val($textM3);                  
                    
            $pMenu1[i].slideToggle();
            $pMenu2[i].slideToggle();
            $pMenu3[i].slideToggle();
            
        }       
    }
    
    function editaImgPerfilOpen (){
        $('.imgPerfil').slideToggle();
    }

    function editaImgMenusOpen (){
        $('.imgMenus').slideToggle();
    }
    
    function ocultaInputsVinos(){
        for (var i = 0; i<8; i++ ){
            $inputsVinos[i].hide();                             
        }
        $('.botonVinos').hide();
    }
    
    function editaVinosOpen (){
        $('.botonVinos').slideToggle();
        
        for (var i = 0; i<8; i++ ){
                        
            $inputsVinos[i].slideToggle();
                                
            $inputsVinos[i].val($pVinos[i].text());
                                
            $pVinos[i].slideToggle();
                        
        }
    }
    
    function insertaVotos(){
        
        $total = $('.ec-stars-wrapper').attr('puntuacion');
        //console.log($total);
        
        $('[vota]').each(function(){
            if($(this).attr('vota') <= $total){
                $(this).addClass('star_color');
            }
        });
        
    }
    
    function votarHovers(){
        $('[vota]').each(function(){
            if($(this).attr('vota') <= $total){
                $(this).removeClass('star_color');
            }
        });
    }
    
    function cargaVideo(){
        $('#verVideo').attr('src', "");
        $srcV = $(this).children().attr('src');
        $('#verVideo').attr('src',$srcV );
    }
    
}