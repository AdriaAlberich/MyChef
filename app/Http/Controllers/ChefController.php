<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Mail;
use Session;

//IMPORTANTE PARA LAS IMG MIRAR LA CLSE STORAGE

class ChefController extends Controller {
    
    
   public function mostrarChef ($id){ 
      $edit = false;
      if(strcmp($id, 'imagenGaleria') != 0 ){
        Session::put('id_chef', $id);
      }
      elseif(strcmp($id, 'eliminarFotosGaleria') != 0){
        Session::put('id_chef', $id);
      }
      else{
         $id = Session::get('id_chef', 'null');
      }
       $id_chef_user = null;

      if (Auth::check()){


            //consultas
           $id_usuario = Auth::user()->id;
            
           $usuario     = DB::table('usuarios')->where('id', $id_usuario)->get();
           $chef        = DB::table('chef')->where('id', '=', $id)->get();
           $menus       = DB::table('menu')->where('id_chef', '=', $id)->get();
           $opiniones   = DB::table('puntuacion')->where('id_chef', '=', $id)->where('opinion' , '<>', 'null')->get();
           $precio      = DB::table('precio')->where('id_chef', '=', $id)->get();
           $fotos_db    = DB::table('foto')->where('id_chef', '=', $id)->get();    

            
            //comprobar si es admin o el chef indicado
           if ($usuario[0]->admin == 1){
               $edit = true;
           }
           else if ($id_usuario == $chef[0]->id_usuario){
               $edit = true;
           }    
                       
            //preparar los menus                     
           $cartas=array(); 
           $i = 0;
           $j = 0;
           $q = 0;          
           
            for ($y = 0 ; $y < count($menus); $y++){

               if ($menus[$y]->menu == 1){
                   $cartas['menu1']['entrantes'][$i]=$menus[$y]->entrantes;
                   $cartas['menu1']['primeros'][$i]=$menus[$y]->primeros;
                   $cartas['menu1']['segundos'][$i]=$menus[$y]->segundos;
                   $cartas['menu1']['postres'][$i]=$menus[$y]->postres;
                   $i++;
               }
               elseif ($menus[$y]->menu == 2){
                   $cartas['menu2']['entrantes'][$j]=$menus[$y]->entrantes;
                   $cartas['menu2']['primeros'][$j]=$menus[$y]->primeros;
                   $cartas['menu2']['segundos'][$j]=$menus[$y]->segundos;
                   $cartas['menu2']['postres'][$j]=$menus[$y]->postres;
                   $j++;
               }
               elseif ($menus[$y]->menu == 3){
                   $cartas['menu3']['entrantes'][$q]=$menus[$y]->entrantes;
                   $cartas['menu3']['primeros'][$q]=$menus[$y]->primeros;
                   $cartas['menu3']['segundos'][$q]=$menus[$y]->segundos;
                   $cartas['menu3']['postres'][$q]=$menus[$y]->postres;
                   $q++;
               }
            }
                     
            //preparar los comentarios
            $comentarios=array();
            for ($i = 0 ; $i < count($opiniones); $i++){
                 
               
                    $comentarios[$i]['comentario']=$opiniones[$i]->opinion;
                                  
                    $users = DB::table('usuarios')->where('id', $opiniones[$i]->id_cliente)->get();

                  if(!empty($users)){
                                
                    $comentarios[$i]['nombre']=$users[0]->nombre;              
                  }
                  else{
                    $comentarios[$i]['nombre']="Anónimo";
                  }
            }
       
            //preparar el precio
            $precioM = array();
            for ($y = 0 ; $y < count($precio); $y++){
               if ($precio[$y]->menu == 1){
                   $precioM['menu1']=$precio[$y]->precio;
                }
               elseif ($precio[$y]->menu == 2){
                  $precioM['menu2']=$precio[$y]->precio;
               }
               elseif ($precio[$y]->menu == 3){
                   $precioM['menu3']=$precio[$y]->precio;
               }
           }
            
            //preparar las fotos

            $fotos = array();
            $fotos['galeria'] = array();
            $p = 0;
            for ($y = 0 ; $y < count($fotos_db); $y++){
                if (strcmp($fotos_db[$y]->descripcion, 'imgPerfil') == 0){
                   $fotos['perfil']=$fotos_db[$y]->imagen;
                } 
                elseif (strcmp($fotos_db[$y]->descripcion, 'imgMenu1') == 0){
                   $fotos['menu1']=$fotos_db[$y]->imagen;
                }
                elseif (strcmp($fotos_db[$y]->descripcion, 'imgMenu2') == 0){
                   $fotos['menu2']=$fotos_db[$y]->imagen;
                }               
                elseif (strcmp($fotos_db[$y]->descripcion, 'imgMenu3') == 0){
                   $fotos['menu3']=$fotos_db[$y]->imagen;
                }
                else{
                  $fotos['galeria'][$p]['img']=$fotos_db[$y]->imagen;
                  $fotos['galeria'][$p]['id']=$fotos_db[$y]->id;

                  if(!is_null($fotos_db[$y]->descripcion)){
                    $fotos['galeria'][$p]['desc']=$fotos_db[$y]->descripcion;
                  }
                  else{
                    $fotos['galeria'][$p]['desc'] = "";
                  }
                  $p++;
                }
                              
            }  

            //si el usuario es un chef que visita otro chef (para el menu de navegacion)
            if($usuario[0]->chef == 1){

              $chef_user   = DB::table('chef')->where('id_usuario', '=', $id_usuario)->get();

              $id_chef_user = $chef_user[0]->id;
            }


          $desc = array ('chef' => $chef[0], 'menus' => $cartas, 'opiniones' => $comentarios, 'id_chef' => $id, 'precios' => $precioM, 'edit' => $edit, 'fotos' =>$fotos, 'id_chef_user' => $id_chef_user);

           //comprobaciones
           
          if(!isset($chef)){
               $this->errores("Error, no se ha encontrado la descripcion personal");
           }
           if(!isset($menus))
           {
              $this->errores("Error, no se ha encontrado los menus");
           }
           
           return view('chef', $desc);
        }

      return view('landing');

    }

    public function insertarPerfil (Request $datosChef){

        $id_chef = Session::get('id_chef', 'null');  
        $descripcion = $datosChef->input('textareaDescripcion');
        //$id_chef = $datosChef->input('id_chefPerfil');  

        if (!empty($descripcion) || !is_null($id_chef)){
            DB::table('chef')->where('id', $id_chef)->update(array('descripcion' => $descripcion));
        }   
        else{
            //return back()->withInput()->withErrors('No se pudo insertar la descripcion. Inténtelo más tarde.');
            $this->errores('No se pudo insertar la descripcion. Inténtelo más tarde.');
        }    
          
          return back();
    }
        
    
    public function insertarMenu1(Request $datosChef){
        
        // recuperamos los datos de los inputs
        $entrante1 = $datosChef->input('inputMenu1_Entrante1');
        $entrante2 = $datosChef->input('inputMenu1_Entrante2');
        $entrante3 = $datosChef->input('inputMenu1_Entrante3');
        
        $primero1 = $datosChef->input('inputMenu1_Primero1');
        $primero2 = $datosChef->input('inputMenu1_Primero2');
        $primero3 = $datosChef->input('inputMenu1_Primero3');
        
        $segundo1 = $datosChef->input('inputMenu1_Segundo1');
        $segundo2 = $datosChef->input('inputMenu1_Segundo2');
        $segundo3 = $datosChef->input('inputMenu1_Segundo3');
        
        $postre1 = $datosChef->input('inputMenu1_Postre1');
        $postre2 = $datosChef->input('inputMenu1_Postre2');
        $postre3 = $datosChef->input('inputMenu1_Postre3');

        $precio = $datosChef->input('inputMenu1_precio');

        $id_chef = Session::get('id_chef', 'null');  

        
        if(!is_null($id_chef)){
          //comprobamos los datos 
          if(isset($entrante1) && isset($entrante2) && isset($entrante3) &&
             isset($primero1) && isset($primero2) && isset($primero3) &&
             isset($segundo1) && isset($segundo2) && isset($segundo3) &&
             isset($postre1) && isset($postre2) && isset($postre3) && isset($precio))
          {
            //TABLA DE MENU
              $menus = DB::table('menu')  
                          ->where('id_chef', '=', $id_chef)
                          ->where('menu', '=', '1')->get();

              if(!empty($menus)){
                //hacemos los updates necesarios
                DB::table('menu')
                    ->where('id', $menus[0]->id)
                    ->update(array('entrantes' => $entrante1, 'primeros' => $primero1, 'segundos' => $segundo1, 'postres' => $postre1));

                DB::table('menu')
                    ->where('id', $menus[1]->id)
                    ->update(array('entrantes' => $entrante2, 'primeros' => $primero2, 'segundos' => $segundo2, 'postres' => $postre2));
                
                DB::table('menu')
                    ->where('id', $menus[2]->id)
                    ->update(array('entrantes' => $entrante3, 'primeros' => $primero3, 'segundos' => $segundo3, 'postres' => $postre3));
              }
              else{
                DB::table('menu')
                    ->insert(array('id_chef' => $id_chef, 'entrantes' => $entrante1, 'primeros' => $primero1, 'segundos' => $segundo1, 'postres' => $postre1, 'menu' => 1));
                
                DB::table('menu')
                    ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante2, 'primeros' => $primero2, 'segundos' => $segundo2, 'postres' => $postre2, 'menu' => 1));
                
                DB::table('menu')
                    ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante3, 'primeros' => $primero3, 'segundos' => $segundo3, 'postres' => $postre3, 'menu' => 1));
              }
              //TABLA DE PRECIO
              $precios = DB::table('precio')  
                          ->where('id_chef', '=', $id_chef)
                          ->where('menu', '=', '1')->get();
              
              if(!empty($precios)){
                //hacemos el update
                DB::table('precio')
                    ->where('id', $precios[0]->id)
                    ->update(array('precio' => $precio));             
              }
              //insert
              else{
                DB::table('precio')
                    ->insert(array('precio' => $precio, 'menu' => 1,  'id_chef' => $id_chef));
              }
          }
          //enviamos errores
          else{
              $this->errores("Error, no se ha podido insertar los menus los menus");
          }
        }
        else{
          $this->errores("Ha habido un error en la sesion");
        }
        
        return back();
        
    }
    
    public function insertarMenu2(Request $datosChef){
        
        // recuperamos los datos de los inputs
        $entrante1 = $datosChef->input('inputMenu2_Entrante1');
        $entrante2 = $datosChef->input('inputMenu2_Entrante2');
        $entrante3 = $datosChef->input('inputMenu2_Entrante3');
        
        $primero1 = $datosChef->input('inputMenu2_Primero1');
        $primero2 = $datosChef->input('inputMenu2_Primero2');
        $primero3 = $datosChef->input('inputMenu2_Primero3');
        
        $segundo1 = $datosChef->input('inputMenu2_Segundo1');
        $segundo2 = $datosChef->input('inputMenu2_Segundo2');
        $segundo3 = $datosChef->input('inputMenu2_Segundo3');
        
        $postre1 = $datosChef->input('inputMenu2_Postre1');
        $postre2 = $datosChef->input('inputMenu2_Postre2');
        $postre3 = $datosChef->input('inputMenu2_Postre3');

        $precio = $datosChef->input('inputMenu2_precio');

        $id_chef  = $datosChef->input('inputMenu2_idChef');
        
        //comprobamos los datos 
        if(isset($entrante1) && isset($entrante2) && isset($entrante3) &&
           isset($primero1) && isset($primero2) && isset($primero3) &&
           isset($segundo1) && isset($segundo2) && isset($segundo3) &&
           isset($postre1) && isset($postre1) && isset($postre1) && isset($precio))
        {

          //TABLA MENUS
            $menus = DB::table('menu')  
                        ->where('id_chef', '=', $id_chef)
                        ->where('menu', '=', '2')->get();
            
            //Updates
            if(!empty($menus)){
              DB::table('menu')
                  ->where('id', $menus[0]->id)
                  ->update(array('entrantes' => $entrante1, 'primeros' => $primero1, 'segundos' => $segundo1, 'postres' => $postre1));
              
              DB::table('menu')
                  ->where('id', $menus[1]->id)
                  ->update(array('entrantes' => $entrante2, 'primeros' => $primero2, 'segundos' => $segundo2, 'postres' => $postre2));
              
              DB::table('menu')
                  ->where('id', $menus[2]->id)
                  ->update(array('entrantes' => $entrante3, 'primeros' => $primero3, 'segundos' => $segundo3, 'postres' => $postre3));
            }
            //inserts
            else{
              DB::table('menu')
                  ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante1, 'primeros' => $primero1, 'segundos' => $segundo1, 'postres' => $postre1, 'menu' => 2));
              
              DB::table('menu')
                  ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante2, 'primeros' => $primero2, 'segundos' => $segundo2, 'postres' => $postre2, 'menu' => 2));
              
              DB::table('menu')
                  ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante3, 'primeros' => $primero3, 'segundos' => $segundo3, 'postres' => $postre3, 'menu' => 2));
            } 
            //TABLA DE PRECIO
            $precios = DB::table('precio')  
                        ->where('id_chef', '=', $id_chef)
                        ->where('menu', '=', '2')->get();
            
            if(!empty($precios)){
              //hacemos el update
              DB::table('precio')
                  ->where('id', $precios[0]->id)
                  ->update(array('precio' => $precio));             
            }
            //insert
            else{
              DB::table('precio')
                  ->insert(array('precio' => $precio, 'menu' => 2,  'id_chef' => $id_chef));
            }
        }
        //enviamos errores
        else{
            $this->errores("Error, no se ha podido insertar los menus los menus");
        }
        return back();
    }
    public function insertarMenu3(Request $datosChef){
        
        // recuperamos los datos de los inputs
        $entrante1 = $datosChef->input('inputMenu3_Entrante1');
        $entrante2 = $datosChef->input('inputMenu3_Entrante2');
        $entrante3 = $datosChef->input('inputMenu3_Entrante3');
        
        $primero1 = $datosChef->input('inputMenu3_Primero1');
        $primero2 = $datosChef->input('inputMenu3_Primero2');
        $primero3 = $datosChef->input('inputMenu3_Primero3');
        
        $segundo1 = $datosChef->input('inputMenu3_Segundo1');
        $segundo2 = $datosChef->input('inputMenu3_Segundo2');
        $segundo3 = $datosChef->input('inputMenu3_Segundo3');
        
        $postre1 = $datosChef->input('inputMenu3_Postre1');
        $postre2 = $datosChef->input('inputMenu3_Postre2');
        $postre3 = $datosChef->input('inputMenu3_Postre3');

        $precio = $datosChef->input('inputMenu3_precio');

        $id_chef  = $datosChef->input('inputMenu3_idChef');
        
        //comprobamos los datos 
        if(isset($entrante1) && isset($entrante2) && isset($entrante3) &&
           isset($primero1) && isset($primero2) && isset($primero3) &&
           isset($segundo1) && isset($segundo2) && isset($segundo3) &&
           isset($postre1) && isset($postre1) && isset($postre1) && isset($precio))
        {
            $menus = DB::table('menu')  
                        ->where('id_chef', '=', $id_chef)
                        ->where('menu', '=', '3')->get();
            
            //Updates
            if(!empty($menus)){
              DB::table('menu')
                  ->where('id', $menus[0]->id)
                  ->update(array('entrantes' => $entrante1, 'primeros' => $primero1, 'segundos' => $segundo1, 'postres' => $postre1));
              
              DB::table('menu')
                  ->where('id', $menus[1]->id)
                  ->update(array('entrantes' => $entrante2, 'primeros' => $primero2, 'segundos' => $segundo2, 'postres' => $postre2));
              
              DB::table('menu')
                  ->where('id', $menus[2]->id)
                  ->update(array('entrantes' => $entrante3, 'primeros' => $primero3, 'segundos' => $segundo3, 'postres' => $postre3));
            }
             //inserts
            else{
              DB::table('menu')
                  ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante1, 'primeros' => $primero1, 'segundos' => $segundo1, 'postres' => $postre1, 'menu' => 3));
              
              DB::table('menu')
                  ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante2, 'primeros' => $primero2, 'segundos' => $segundo2, 'postres' => $postre2, 'menu' => 3));
              
              DB::table('menu')
                  ->insert(array('id_chef' => $id_chef,'entrantes' => $entrante3, 'primeros' => $primero3, 'segundos' => $segundo3, 'postres' => $postre3, 'menu' => 3));
            }
            //TABLA DE PRECIO
            $precios = DB::table('precio')  
                        ->where('id_chef', '=', $id_chef)
                        ->where('menu', '=', '3')->get();
            
            if(!empty($precios)){
              //hacemos el update
              DB::table('precio')
                  ->where('id', $precios[0]->id)
                  ->update(array('precio' => $precio));             
            }
            //insert
            else{
              DB::table('precio')
                  ->insert(array('precio' => $precio, 'menu' => 3,  'id_chef' => $id_chef));
            } 

        }
        //enviamos errores
        else{
            $this->errores("Error, no se ha podido insertar los menus los menus");
        }
        return back();
    }
    public function puntuacion(Request $datosChef){  //FALTA CONTROLAR QUE UN CHEF NO SE VOTE A SI MISMO
        
        $nuevaPun   = $datosChef->input('votar');
        $id_chef    = $datosChef->input('id_chef');
        $id_usuario = Auth::user()->id;

        $chef       = DB::table('chef')->where('id', '=',  $id_chef)->get();

      if (isset($id_chef)){
        if ($id_usuario != $chef[0]->id_usuario){
          if (isset($nuevaPun)){


            $antiguaPun     = DB::table('puntuacion')
                            ->where('id_cliente', '=', $id_usuario)
                            ->where('id_chef', $id_chef)->get();
              
            $totalPun       = DB::table('chef')
                              ->where('id', $id_chef)->get();

            $update_chef_oK = false;


              //si ya hay registro en la bd tabla puntuacion -> MODIFICACION
            if (!empty($totalPun)){
                if (!empty($antiguaPun)){

                    DB::table('puntuacion')
                    ->where('id_cliente', '=', $id_usuario)
                    ->where('id_chef', $id_chef)
                    ->update(array('puntuacion' => $nuevaPun));
                      
                    if($totalPun[0]->puntuacion_total != 0){

                      $nuevaPunTotal = $totalPun[0]->puntuacion_total - $antiguaPun[0]->puntuacion;

                      $nuevaPunTotal = ($nuevaPunTotal + $nuevaPun);                   
                    }
                    else{
                       $nuevaPunTotal = $nuevaPun;
                    }

                    

                    DB::table('chef')
                    ->where('id', '=', $id_chef)
                    ->update(array('puntuacion_total' => $nuevaPunTotal));

                    //si ha comentado pero no ha votado
                    if(is_null($antiguaPun[0]->puntuacion)){

                      $nuevaPunTotal = ($totalPun[0]->puntuacion_total + $nuevaPun);
                      $numVotos = $totalPun[0]->numero_Votos + 1;
                     
                      DB::table('chef')
                      ->where('id', '=', $id_chef)
                      ->update(array('puntuacion_total' => $nuevaPunTotal, 'numero_Votos' => $numVotos));

                    }
                   
                }

                //si no hay registro en la bd --> NUEVA PUNTUACION
                else{              
  
                    DB::table('puntuacion')
                    ->insert(array('id_chef' => $id_chef, 'id_cliente' => $id_usuario, 'puntuacion'=> $nuevaPun));
                

                    $nuevaPunTotal = ($totalPun[0]->puntuacion_total + $nuevaPun);
                    $numVotos = $totalPun[0]->numero_Votos + 1;
                   
                    DB::table('chef')
                    ->where('id', '=', $id_chef)
                    ->update(array('puntuacion_total' => $nuevaPunTotal, 'numero_Votos' => $numVotos)); 
                  }              
                
            }
            else{
              $this->errores("Error, no se ha podido insertar la puntuacion");
            }            
          }
          else{
              $this->errores("Error, no se ha podido insertar la puntuacion");
          }
        }
        else{
            $this->errores("Error, no te puedes votar a ti mismo");
        }

      }
      else{
        $this->errores("Error, no se ha podido insertar la puntuacion*");
      }
        return back();
      
    }
    public function opinion(Request $datosChef){
        
        $opinion = $datosChef->input('textAreaComent');
        $id_usuario = Auth::user()->id;
        $id_chef = $datosChef->input('coments_idChef');

        $chef       = DB::table('chef')->where('id', '=',  $id_chef)->get();

      if (isset($id_chef)){
        if ($id_usuario != $chef[0]->id_usuario){
          if (isset($opinion)){
              
              $antiguaOp  = DB::table('puntuacion')
                          ->where('id_cliente', $id_usuario)
                          ->where('id_chef', $id_chef)->get();
              
                          
              //si ya hay registro en la bd tabla puntuacion
              
              if (!empty($antiguaOp) ){

                  DB::table('puntuacion')
                  ->where('id', $antiguaOp[0]->id)
                  ->update(array('opinion' => $opinion));

              }

              //si no hay registro en la bd
              else{              

                  DB::table('puntuacion')
                  ->insert(array('id_chef' => $id_chef, 'id_cliente' => $id_usuario, 'opinion' => $opinion));
              }
              
          }          
          else{
              $this->errores("Error, no se ha podido insertar la opinion");
          }
        }
        else{
          $this->errores("Error, no puedes poner comentarios sobre ti mismo");
        }
      }
      else{
        $this->errores("Error, no se ha podido insertar la opinion");
      }

        return back();
        
    }
    public function imagenPerfil(Request $datosChef){  //https://styde.net/subir-archivos-en-laravel-con-dropzone/
        $file =  $datosChef->file('file');
        $id_chef = Session::get('id_chef', 'null'); 
        $id_usuario = Auth::user()->id;
        
        //controlamos que el usuario sea chef y no administrador
        $usuario     = DB::table('usuarios')->where('id', $id_usuario)->get();
        if(!is_null($id_chef)){

          $chef = DB::table('chef')->where('id_usuario', $id_usuario)->get();

          if ($usuario[0]->admin == 1 || $chef[0]->id == $id_chef){
              
                     
              //redirigimos la imagen a la carpeta uuploads
              $path = public_path().'/uploads/';
              
              //foreach($files as $file){
              $fileName = $id_chef . "_" . "imgPerfil" . "_" . $file->getClientOriginalName();
              $file->move($path, $fileName);
              //}
              
              //subimos la ruta de la imagen a la bd:
              $ruta = 'http://www.mychef.cat/uploads/' . $fileName;
              
              $foto  = DB::table('foto')
                      ->where('descripcion', 'imgPerfil')
                      ->where('id_chef', $id_chef)->get();
              
              if(!empty($foto)){

                  //eliminamos el antiguo archivo
                  $rest = substr($foto[0]->imagen, 30);
                  unlink(public_path().'/uploads/' . $rest);

                  DB::table('foto')
                    ->where('id', $foto[0]->id)
                    ->update(array('imagen' => $ruta, 'descripcion' => 'imgPerfil'));
              }
              else{

                  DB::table('foto')
                    ->insert(array('imagen' => $ruta, 'descripcion' => 'imgPerfil', 'id_chef' => $id_chef));
              }
              
          }
          else{
             $this->errores("Error de identificacion, solo el chef y/o el administrador pueden subir imagenes");
          }
        }
        else{
          $this->errores("Ha habido un error en la sesion");
        }
        return back();
                           
    }
    public function imagenMenu1(Request $datosChef){  //https://styde.net/subir-archivos-en-laravel-con-dropzone/
        $file =  $datosChef->file('file');
        $id_chef = Session::get('id_chef', 'null'); 
        $id_usuario = Auth::user()->id;
        
        //controlamos que el usuario sea chef y no administrador
        $usuario     = DB::table('usuarios')->where('id', $id_usuario)->get();
        if(!is_null($id_chef)){
          $chef = DB::table('chef')->where('id_usuario', $id_usuario)->get();

          if ($usuario[0]->admin == 1 || $chef[0]->id == $id_chef){
          
              //redirigimos la imagen a la carpeta uuploads
              $path = public_path().'/uploads/';
              
              //foreach($files as $file){
              $fileName = $id_chef . "_" . "imgMenu1" . "_" . $file->getClientOriginalName();
              $file->move($path, $fileName);
              //}
              
              //subimos la ruta de la imagen a la bd:
              $ruta = 'http://www.mychef.cat/uploads/' . $fileName;
              
              $foto  = DB::table('foto')
                      ->where('descripcion', 'imgMenu1')
                      ->where('id_chef', $id_chef)->get();
              
              if(!empty($foto)){

                  //eliminamos el antiguo archivo
                  $rest = substr($foto[0]->imagen, 30);
                  unlink(public_path().'/uploads/' . $rest);

                  DB::table('foto')
                    ->where('id', $foto[0]->id)
                    ->update(array('imagen' => $ruta, 'descripcion' => 'imgMenu1'));
              }
              else{
                  DB::table('foto')
                    ->insert(array('imagen' => $ruta, 'descripcion' => 'imgMenu1', 'id_chef' => $id_chef));
              }
              
          }
          else{
             $this->errores("Error de identificacion, solo el chef y/o el administrador pueden subir imagenes");
          }
        }
        else{
          $this->errores("Ha habido un error en la sesion");
        }
        return back();
                           
    }
    public function imagenMenu2(Request $datosChef){  //https://styde.net/subir-archivos-en-laravel-con-dropzone/
        $file =  $datosChef->file('file');
        $id_chef = Session::get('id_chef', 'null'); 
        $id_usuario = Auth::user()->id;
        
        //controlamos que el usuario sea chef y no administrador
        $usuario     = DB::table('usuarios')->where('id', $id_usuario)->get();
        if(!is_null($id_chef)){
          $chef = DB::table('chef')->where('id_usuario', $id_usuario)->get();

          if ($usuario[0]->admin == 1 || $chef[0]->id == $id_chef){
          
              //redirigimos la imagen a la carpeta uuploads
              $path = public_path().'/uploads/';
              
              //foreach($files as $file){
              $fileName = $id_chef . "_" . "imgMenu2" . "_" . $file->getClientOriginalName();
              $file->move($path, $fileName);
              //}
              
              //subimos la ruta de la imagen a la bd:
              $ruta = 'http://www.mychef.cat/uploads/' . $fileName;
              
              $foto  = DB::table('foto')
                      ->where('descripcion', 'imgMenu2')
                      ->where('id_chef', $id_chef)->get();
              
              if(!empty($foto)){

                  //eliminamos el antiguo archivo
                  $rest = substr($foto[0]->imagen, 30);
                  unlink(public_path().'/uploads/' . $rest);

                  DB::table('foto')
                    ->where('id', $foto[0]->id)
                    ->update(array('imagen' => $ruta, 'descripcion' => 'imgMenu2'));
              }
              else{
                  DB::table('foto')
                    ->insert(array('imagen' => $ruta, 'descripcion' => 'imgMenu2', 'id_chef' => $id_chef));
              }
              
          }
          else{
             $this->errores("Error de identificacion, solo el chef y/o el administrador pueden subir imagenes");
          }
        }
        else{
          $this->errores("Ha habido un error en la sesion");
        }
        return back();
                           
    }
    public function imagenMenu3(Request $datosChef){  //https://styde.net/subir-archivos-en-laravel-con-dropzone/
        $file =  $datosChef->file('file');
        $id_chef = Session::get('id_chef', 'null'); 
        $id_usuario = Auth::user()->id;
        
        //controlamos que el usuario sea chef y no administrador
        $usuario     = DB::table('usuarios')->where('id', $id_usuario)->get();
        if(!is_null($id_chef)){
          $chef = DB::table('chef')->where('id_usuario', $id_usuario)->get();

          if ($usuario[0]->admin == 1 || $chef[0]->id == $id_chef){
          
              //redirigimos la imagen a la carpeta uuploads
              $path = public_path().'/uploads/';
              
              //foreach($files as $file){
              $fileName = $id_chef . "_" . "imgMenu3" . "_" . $file->getClientOriginalName();
              $file->move($path, $fileName);
              //}
              
              //subimos la ruta de la imagen a la bd:
              $ruta = 'http://www.mychef.cat/uploads/' . $fileName;
              
              $foto  = DB::table('foto')
                      ->where('descripcion', 'imgMenu3')
                      ->where('id_chef', $id_chef)->get();
              
              if(!empty($foto)){

                  //eliminamos el antiguo archivo
                  $rest = substr($foto[0]->imagen, 30);
                  unlink(public_path().'/uploads/' . $rest);

                  DB::table('foto')
                    ->where('id', $foto[0]->id)
                    ->update(array('imagen' => $ruta, 'descripcion' => 'imgMenu3'));
              }
              else{
                  DB::table('foto')
                    ->insert(array('imagen' => $ruta, 'descripcion' => 'imgMenu3', 'id_chef' => $id_chef));
              }
              
          }
          else{
             $this->errores("Error de identificacion, solo el chef y/o el administrador pueden subir imagenes");
          }
        }
        else{
          $this->errores("Ha habido un error en la sesion");
        }
        return back();
                           
    }
    public function imagenGaleria(Request $datosChef){  //https://styde.net/subir-archivos-en-laravel-con-dropzone/  
        $file =  $datosChef->file('file');
        $id_chef = Session::get('id_chef', 'null'); 
        $id_usuario = Auth::user()->id;
        $titulo = $datosChef->input('tituloImg');
        
        $usuario     = DB::table('usuarios')->where('id', $id_usuario)->get();
        if(!is_null($id_chef)){
          $chef = DB::table('chef')->where('id_usuario', $id_usuario)->get();

          if ($usuario[0]->admin == 1 || $chef[0]->id == $id_chef){
            if(!is_null($file) && !is_null($titulo )){
          
              //redirigimos la imagen a la carpeta uuploads
              $path = public_path().'/uploads/';
              
              //foreach($files as $file){
              $fileName = $id_chef . "_" . "galeria" . "_" . $file->getClientOriginalName();
              $file->move($path, $fileName);
              //}
              
              //subimos la ruta de la imagen a la bd:
              $ruta = 'http://www.mychef.cat/uploads/' . $fileName;
              
              $prueba = DB::table('foto')
                       ->insert(array('imagen' => $ruta, 'id_chef' => $id_chef, 'descripcion' => $titulo));
            }
            else{
              $this->errores("Error al subir imagenes");
            }
              
          }
          else{
             $this->errores("Error de identificacion, solo el chef y/o el administrador pueden subir imagenes");
          }
        }
        else{
          $this->errores("Ha habido un error en la sesion");
        }
        return back();
                           
    }
    public function eliminarFotosGaleria(Request $datosChef){  //https://styde.net/subir-archivos-en-laravel-con-dropzone/  
        $id_chef = Session::get('id_chef', 'null'); 
        $id_usuario = Auth::user()->id;
        $id_foto = $datosChef->input('id_foto');
        
        $usuario     = DB::table('usuarios')->where('id', $id_usuario)->get();
        if(!is_null($id_chef)){

          $chef = DB::table('chef')->where('id_usuario', $id_usuario)->get();

          if ($usuario[0]->admin == 1 || $chef[0]->id == $id_chef){
            if(!is_null($id_foto)){
              $foto  = DB::table('foto')
                      ->where('id', $id_foto)->get();
                      
              if (!empty($foto)){

                $rest = substr($foto[0]->imagen, 30);
                unlink(public_path().'/uploads/' . $rest);

                DB::table('foto')->where('id', $id_foto)->delete();
              }       
              else{
                $this->errores("Error, no se ha encontrado la");
              }
            }
          }
          else{
             $this->errores("Error de identificacion, solo el chef y/o el administrador pueden subir imagenes");
          }
        }
        else{
          $this->errores("Ha habido un error en la sesion");
        }
        return back();
                           
    }
    public function errores ($mensaje){
        return back()->withInput()->withErrors($mensaje);
    }

    

}
