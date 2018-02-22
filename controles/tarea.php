<?php
include_once("conexion/conexion.php");

class Tareas{
	public function listar_tareas_proyecto($id_fas){//crea una lista de las tareas de una etapa
		$form_arr = array("","");//devuelve un arreglo de proyectoss
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from tareas  WHERE id_fase  = :id_fase");
			$stmt->bindParam(':id_fase', $np);
			$np = $id_fas;
			//guardar_cambios_tareas.php
			if($stmt->execute()){
				$cont = 0;
				while ($row = $stmt->fetchObject()) {
					$cont+=1;
				$form = "
				<form method=\"post\" class=\"form\">
					<fieldset><legend>$cont: <b>{$row->nombre_tarea}</b></legend>
					<table border=\"0\" class=\"tablaPrincipal\">
						<tr>
                            <td >
                                <label>ID Tarea</label>
                            </td>
                            <td >
                                <input type=\"text\" value=\"{$row->id_tarea}\" name=\"idtarea\" readonly=\"readonly\">
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <label>tarea a realizar</label>
                            </td>
                            <td >
                                <input type=\"text\" value=\"{$row->nombre_tarea}\" name=\"tareaR\">
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <label>fecha inicial</label>
                            </td>
                            <td >
                                <input type=\"date\" id=\"datepicker\"value=\"{$row->fecha_inicialt}\"  name=\"fechaI\">
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <label>fecha final</label>
                            </td>
                            <td >
                                <input type=\"date\" id=\"datepicker2\" value=\"{$row->fecha_finalt}\"  name=\"fechaF\">
                            </td>
                        </tr>
                        <tr>
                        <tr>
                             <td ><label>estado</label></td>
                             <td >
                                <select name=\"estado\">
									<option value=\"{$row->estado}\"><b>{$row->estado}</b></option>
                                    <option value=\"En proceso\">En proceso</option>
                                    <option value=\"Detenido\">Detenido</option>
                                    <option value=\"Cancelado\">Cancelado</option>
                                    <option value=\"Finalizado\">Finalizado</option>
                                </select>
                            </td>
                        </tr>
						<tr>
                            <td >
                                <input type=\"submit\" value=\"enviar\">
                            </td>
                            <td >

                            </td>
                        </tr>
                </table>
				</fieldset>
            </form>";
						array_push($form_arr,$form);
			}
			
		
		}
		}
		catch(PDOException $e)
			{
			echo "Error: " . $e->getMessage();
			}
		$con2 = null;
		return $form_arr;
	}
	public function listar_tareas($id_fase){//crea una lista select las en un fase
		$form_arr = array();//devuelve un arreglo de proyectoss
		$form = "<option value=\"\">No hay tareas</option>";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from tareas WHERE id_fase = :id_fase");
			$stmt->bindParam(':id_fase', $np);
			$np = $id_fase;
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "<option value=\"{$row->id_tarea}\">{$row->nombre_tarea}</option>";
						array_push($form_arr,$form);
			}
		
			}
		}
		catch(PDOException $e)
			{
			echo "Error: " . $e->getMessage();
			}
		$con2 = null;
		return $form_arr;
	}
	public function nueva_tarea($ardatos){
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
        if(!Tareas::validar_doble_tarea($ardatos[0],$ardatos[1])){
            try{
                // se establece el modo de error PDO a Exception
                $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Se prepara el satetement y se cargan los parametros
                $stmt = $con2->prepare("insert into tareas(id_fase,nombre_tarea,fecha_inicialt,fecha_finalt,estado,creado,modificado) values(:id_fase,:nombre_tarea,:fecha_inicialt,:fecha_finalt,:estado,now(),now())");

                $stmt->bindParam(':id_fase', $ardatos[0]);
                $stmt->bindParam(':nombre_tarea', $ardatos[1]);
                $stmt->bindParam(':fecha_inicialt', $ardatos[2]);
                $stmt->bindParam(':fecha_finalt', $ardatos[3]);
                $stmt->bindParam(':estado', $ardatos[4]);
                // 
                if($stmt->execute()){
                    $flag = true;
                }
            }
            catch(PDOException $e)
                {
                 echo "Error: " . $e->getMessage();
                }
            $con2 = null;
        }
		
		return $flag;
	}
	public function modificar_tarea($ardatos){//crea proyectoss por tarea para su edicion y vista
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("UPDATE tareas set nombre_tarea= :nombre_tarea,fecha_inicialt=:fecha_inicialt,fecha_finalt=:fecha_finalt,estado=:estado,modificado=now() where id_tarea = :id_tarea");
			
			$stmt->bindParam(':nombre_tarea', $ardatos[1]);
			$stmt->bindParam(':fecha_inicialt', $ardatos[2]);
			$stmt->bindParam(':fecha_finalt', $ardatos[3]);
			$stmt->bindParam(':estado', $ardatos[4]);
			$stmt->bindParam(':id_tarea', $ardatos[0]);
			// "
			if($stmt->execute()){
				$flag = true;
			}
		}
		catch(PDOException $e)
			{
			echo "Error: " . $e->getMessage();
			}
		$con2 = null;
		return $flag;
	}
	public function validar_doble_tarea($id_fas,$nombre_tarea){
		$flag = false;
		$list = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select nombre_tarea from tareas  WHERE id_fase  = :id_fase");
			$stmt->bindParam(':id_fase', $np);
			$np = $id_fas;
			
			if($stmt->execute()){
				while($row = $stmt->fetchObject()){
					array_push($list,$row->nombre_tarea);
				}
			}
			foreach($list as $l){//ciclo en donde se almacenan todos los valores de las consultas
				if(stristr($nombre_tarea,$l)){//se compara este arreglo con el nombre para saber si existe o no
					$flag = true;//devuelve true si el nombre se repite
				}
			}
			
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
		$con2 = null;
		return $flag;
	}
	
	public function exc_tareas($id_fase){
		$form =array();
		$con = new Conexion();
		$con2 = $con->conectar();
		$us = new Usuario();
		try{
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $con2->prepare("SELECT * from tareas where id_fase = :id_fase");
			$stmt->bindParam(':id_fase', $id_f);
			$id_f = $id_fase;
			$stmt->execute();
			if($row = $stmt->fetchObject()){
				$id_t = $row->id_tarea;
				$contenedor = $us->listar_us_asignaciones($id_t);
				$extra = implode(" ",$contenedor);
				array_push($form,"<td>{$row->nombre_tarea}</td>");
				array_push($form,"<td>{$row->fecha_inicialt}</td>");
				array_push($form,"<td>{$row->fecha_finalt}</td>");
				array_push($form,"<td>{$row->estado}</td>");
				array_push($form,"<td>$extra</td>");
				//typescript
			}
			
		}
		catch(PDOException $e)
			{
			echo "Error: " . $e->getMessage();
			}
		$con2 = null;
		return $form;
	}
	
}
?>