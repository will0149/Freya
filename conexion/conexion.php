<?php
class Conexion{
	private $con;
	public function __Construct(){
		try{
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "informe_proyectos";
			$this->con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
		
	}
	public function conectar(){//metodo para coneccion a la BD con la clase PDO para aumento de seguridad
		return $this->con;
	}
}
?>