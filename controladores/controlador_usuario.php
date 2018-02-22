<?php
class Usuarios{
	public function verificar_sesion($cedula,$password){
		$flag = false;
		if(Usuario::sesion($cedula,$password)){
			
			$flag = true;
		}
		return $flag;
	}
}
?>