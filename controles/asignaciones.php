<?php
include_once("conexion/conexion.php");
class Asignaciones{
	
    public function nueva_asignacion($ardatos){
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("insert into asignaciones(id_tarea,cedula) values(:id_tarea,:cedula)");
			
			$stmt->bindParam(':id_tarea', $ardatos[0]);
			$stmt->bindParam(':cedula', $ardatos[1]);
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
		return $flag;
	}
	public function lista_asignaciones_etapa($id_fas){//crea una lista select de las tareas asignadas a usuarios por etapa
		$form_arr = array("","");//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare(" select nombre_tarea,nombre_f,nombre,apellido,cargo,unidad,sede from usuario us 
			 inner join asignaciones a on us.cedula=a.cedula
			 inner join tareas t on a.id_tarea = t.id_tarea
			 inner join etapas et on t.id_fase = et.id_fase 
			inner join proyectos f on et.id_proyecto = f.id_proyecto
			 where nombre_f = (select nombre_f from etapas where id_fase = :id_fase);");
			$stmt->bindParam(':id_fase', $np);
			$np = $id_fas;
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "<tr>
							<td>{$row->nombre_tarea}</td>
							<td>{$row->nombre_f}</td>
							<td>{$row->nombre}</td>
							<td>{$row->apellido}</td>
							<td>{$row->cargo}</td>
							<td>{$row->unidad}</td>
							<td>{$row->sede}</td>
						</tr>";
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
	
}