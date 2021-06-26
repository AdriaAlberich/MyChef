
$(document).ready(function(){
    
    iu = new IU_CHEF();
    chef = new CHEF();
    Dropzone.autoDiscover = false;

    iu.inicio();
    chef.quitarErrors();
    
    $('#fotodiv').on("click", iu.activar2); // muestra/oculta el panel del video
    $('#videodiv').on("click", iu.activar); // muestra/oculta el panel de la galeria 
    $('.editaPerfil').on("click", iu.textareaOpen); //muestra/oculta textarea del Perfil
    $('.editaMenu').on("click", iu.inputsOpen); //muestra/oculta los inputs del Menu 
    $('.editaImgPerfil').on("click", iu.editaImgPerfilOpen); //muestra/oculta el input de la imagen de perfil
    $('.editaImgMenus').on("click", iu.editaImgMenusOpen); //muestra/oculta el input de la imagen de perfil
    $('.editaVinos').on("click", iu.editaVinosOpen); //muestra/oculta los inputs de los vinos 
    
    //eventos relacionados con los votos
    $('.ec-stars-wrapper').on("mouseenter", iu.votarHovers); //muestra/oculta los inputs de los vinos 
    $('.ec-stars-wrapper').on("mouseleave", iu.insertaVotos); //muestra/oculta los inputs de los vinos 
    $('.ec-stars-wrapper a').on("click", chef.insertaVotos);
    
    //eventos para los botones cancela.
    $('.cancelaVoto').on("click", iu.ocultaAlertaVotos);
    $('.cancelaSobreMi').on("click", iu.textareaOpen);
    $('.cancelaMenu').on("click", iu.inputsOpen); 
    $('.cancelaVinos').on("click", iu.editaVinosOpen); 
    
 
    
   // $('.v').on("click", iu.cargaVideo);

document.getElementById('links').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

blueimp.Gallery(
    document.getElementById('links').getElementsByTagName('a'),
    {
        container: '#blueimp-gallery-carousel',
        carousel: true
    }
);



Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element

  // The configuration we've talked about above
  autoProcessQueue: false,
  uploadMultiple: false,
  parallelUploads: 1,
  maxFiles: 100,

  // The setting up of the dropzone
  init: function() {
    var myDropzone = this;

    // First change the button to actually tell Dropzone to process the queue.
    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
      // Make sure that the form isn't actually being sent.
      e.preventDefault();
      e.stopPropagation();
      myDropzone.processQueue();
    });

    // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
    // of the sending event because uploadMultiple is set to true.
    this.on("sendingmultiple", function() {
      // Gets triggered when the form is actually being sent.
      // Hide the success button or the complete form.
    });
    this.on("successmultiple", function(files, response) {
      // Gets triggered when the files have successfully been sent.
      // Redirect user or notify of success.
    });
    this.on("errormultiple", function(files, response) {
      // Gets triggered when there was an error sending the files.
      // Maybe show form again, and notify user of error
    });
  }
};

setInterval(function(){

    var dz = $('.dz-upload');

    if(typeof dz !=  'undefined'){
        if(dz.attr('style') == 'width: 100%;'){
            location.reload();
        }
    }

 }, 5000);

});