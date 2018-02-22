<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author Will
 */
class EnlacesPaginas {
    //put your code here
    
    public function enlacesPaginasModel($enlacesModel){
        $module = "";
        if($enlacesModel == null){
            $module = "Views/Modules/index.php?action=inicio";
        }
        elseif(
            $enlacesModel == "nuevoProyecto" || $enlacesModel== "reporteExcel"
            || $enlacesModel == "nuevaEtapa" 
            || $enlacesModel == "eEtapas" || $enlacesModel == "guardarCambiosEtapa"
            || $enlacesModel == "reporteExcel" || $enlacesModel == "reporteProyecto"
            || $enlacesModel == "eTareas" || $enlacesModel == "eProyecto"
            || $enlacesModel == "descargaCuatrimetre" || $enlacesModel == "nuevaTarea"
            || $enlacesModel == "nuevaAsignacion"
        ){
            $module = "Views/Modules/".$enlacesModel.".php";
        }
        elseif ($enlacesModel == "inicio")  {
            $module = "Views/Modules/".$enlacesModel.".php";
        }
        elseif($enlacesModel == "oknProyecto"){
            $module = "Views/Modules/nuevoProyecto.php";
        }
        return $module;
    }
}
