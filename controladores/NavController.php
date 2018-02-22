<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NavController
 *
 * @author ASUS
 */
class NavController {
    //put your code here
    public function plantilla(){
        include "Views/Template.php";
    }
    
    public function enlancesPaginasController(){
        $enlacePagina = "";
        //condicion que redirecciona a la pagina correspondiente
        $page = filter_input(INPUT_GET,'action');
        if($page != null){
            $enlacePagina = $page;
        }
        else{
            $enlacePagina = "inicio";
        }
        
        $respuesta = EnlacesPaginas::enlacesPaginasModel($enlacePagina);
        
        //$respuesta = "Views/Modules/EtapasO/eEtapas.php ";
        include $respuesta;
    }
    public function nuevoproyecto(){
        //$proyecto = new Proyectos();
        if(isset($_POST['nProyecto'])){

            /*$datosController=array(
                "nProyecto"=>fillter_input(INPUT_POST,'nProyecto'),
                "nEtapasProyecto"=>fillter_input(INPUT_POST,'nEtapasProyecto'),
                "nStatusProyecto"=>fillter_input(INPUT_POST,'nStatusProyecto'));
            $respuesta = Proyectos::nuevo_proyecto($datosController);*/
            $datosController=array(
                "nProyecto"=>$_POST['nProyecto'],
                "nEtapasProyecto"=>$_POST['nEtapasProyecto'],
                "nStatusProyecto"=>$_POST['nStatusProyecto']);
            
            if(Proyectos::nuevo_proyecto($datosController)){
                header("location: index.php?action=oknProyecto");
                    exit;
            }
        }
        

            //if(!empty($datosController['nProyecto'])) {
                //if(Proyectos::nuevo_proyecto($datosController)){
        
                
            //}
    }
    /*public function guardarcambiosEtapas(){
        $et = new Etapas();
        //
        $flag = false;
       $id_f=filter_input(INPUT_POST,'idfase');
        $cookie_name = "id_fase";
        setcookie($cookie_name, $id_f,time() + 3600);
        $nom_f=filter_input(INPUT_POST,'nomf');
        $fechain=filter_input(INPUT_POST,'nfechaI');
        $fechafi=filter_input(INPUT_POST,'nfechaF');
        $compo=filter_input(INPUT_POST,'txtacom');
        $activ=filter_input(INPUT_POST,'txtact');
        $result_ob=filter_input(INPUT_POST,'txtareso');
        $av_pla=filter_input(INPUT_POST,'avap');
        $av_re=filter_input(INPUT_POST,'avar');
        $med_ver=filter_input(INPUT_POST,'txtamev');
        $observ=filter_input(INPUT_POST,'txtaobs');

        $ardatos = array($id_f,$nom_f,$fechain,$fechafi,$compo,$activ,$result_ob,$av_pla,$av_re,$med_ver,$observ,$observ);

        if($et->modificar_etapa($ardatos)){
                $flag = true;
        }
        return $flag;
    }*/
    
}
