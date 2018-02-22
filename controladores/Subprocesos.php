<?php
include_once("controles/etapas.php");
include_once("controles/tarea.php");
include_once("controles/proyectos.php");
class SubProcesos{
	public function redirect_Nuevo_Proyecto($datos){
		$flag = false;
		$pro = new Proyectos();
		$datos2 = array();
		$datos2 = $datos;
		$pro->cargar_proy($datos2[0],$datos2[1],$datos2[2]);
		if($pro->validar_doble_pro($datos2[0])){
			echo("Proyecto Duplicado");
			header("Location: nuevo_proyecto.php");
			exit;
		}
		else{
			if($pro->nuevo_proyecto()){
				$flag = true;
			}
		}
		return $flag;
	}
}
?>