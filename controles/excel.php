<?php
include_once("conexion/conexion.php");
class Excel{
	public function listar_excel($id_pro){//crea una tabla preview de excel antes de descargar
		$form_arr = array();//devuelve un arreglo de proyectoss
		$form = "";//carga datos en proyectoss diferentes
		$contenedor="";
		$contenedor2=array();
		$asignaciones = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		$us = new Usuario();
		$tarea = new Tareas();
		try{
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $con2->prepare("SELECT * from proyectos f inner join etapas e on f.id_proyecto = e.id_proyecto where f.id_proyecto = :id_proyecto");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $id_pro;
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					$id_fase = $row->id_fase;
					$contenedor2 = $tarea->exc_tareas($id_fase);
					$tar = implode(" ",$contenedor2);//une un arreglo de datos y los separa con un espacio
					if($tar!=""){
						$form="<tr>
								<td><h6><b>{$row->nombre_p}</b></h6></td>
								<td>{$row->fecha_creacionp}</td>
								<td><b>{$row->nombre_f}</b></td>
								<td>{$row->fecha_inicialfs}</td>
								<td>{$row->fecha_finalfs}</td>
								<td>{$row->componentes}</td>
								<td>{$row->actividades}</td>
								<td>{$row->resultados_obtenidos}</td>
								<td>{$row->avances_planificados}</td>
								<td>{$row->avances_reales}</td>
								<td>{$row->medio_verificacion}</td>
								<td>{$row->observacion}</td>
								".$tar."
							</tr>";
					}else{
						$form="<tr>
								<td><h6><b>{$row->nombre_p}</b></h6></td>
								<td>{$row->fecha_creacionp}</td>
								<td><b>{$row->nombre_f}</b></td>
								<td>{$row->fecha_inicialfs}</td>
								<td>{$row->fecha_finalfs}</td>
								<td>{$row->componentes}</td>
								<td>{$row->actividades}</td>
								<td>{$row->resultados_obtenidos}</td>
								<td>{$row->avances_planificados}</td>
								<td>{$row->avances_reales}</td>
								<td>{$row->medio_verificacion}</td>
								<td>{$row->observacion}</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>";
					}
					
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
	public function listar_excel_cuatrimestre($cuatrimestre,$anho){//metodo anulado por ser poco eficiente para el propòsito
	$form_arr = array();//devuelve un arreglo de proyectoss
		$form = "";//carga datos en proyectoss diferentes
		$contenedor="";
		$contenedor2=array();
		$asignaciones = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		$us = new Usuario();
		$tarea = new Tareas();
        $an = 0;
		
		try{
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
            if($cuatrimestre>=0 && $cuatrimestre < 4){
				if($cuatrimestre==1){
					$stmt = $con2->prepare("SELECT * FROM `proyectos` f 
						inner join etapas e on f.id_proyecto = e.id_proyecto 
						where fecha_creacionp between :primer_mes and :ultimo_mes");
					$stmt->bindParam(':primer_mes', $inicio);
                    $stmt->bindParam(':ultimo_mes', $final);
					$inicio = "".$anho."/01/01/";
                    $final = "".$anho."/04/30/";
				}else if($cuatrimestre==2){
					$stmt = $con2->prepare("SELECT * FROM `proyectos` f 
						inner join etapas e on f.id_proyecto = e.id_proyecto 
						where fecha_creacionp between :primer_mes and :ultimo_mes");
					$stmt->bindParam(':primer_mes', $inicio);
                    $stmt->bindParam(':ultimo_mes', $final);
					$inicio = "".$anho."/05/01/";
                    $final = "".$anho."/08/31/";
				}else if($cuatrimestre==3){
					$stmt = $con2->prepare("SELECT * FROM `proyectos` f 
						inner join etapas e on f.id_proyecto = e.id_proyecto 
						where fecha_creacionp between :primer_mes and :ultimo_mes");
					$stmt->bindParam(':primer_mes', $inicio);
                    $stmt->bindParam(':ultimo_mes', $final);
					$inicio = "".$anho."/09/01/";
                    $final = "".$anho."/12/31/";
				}
			}
            
		if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					$id_fase = $row->id_fase;
					$contenedor2 = Tareas::exc_tareas($id_fase);
					$tar = implode(" ",$contenedor2);//une un arreglo de datos y los separa con un espacio
					if($tar!=""){
						$form="<tr>
								<td><h6><b>{$row->nombre_p}</b></h6></td>
								<td>{$row->fecha_creacionp}</td>
								<td><b>{$row->nombre_f}</b></td>
								<td>{$row->fecha_inicialfs}</td>
								<td>{$row->fecha_finalfs}</td>
								<td>{$row->componentes}</td>
								<td>{$row->actividades}</td>
								<td>{$row->resultados_obtenidos}</td>
								<td>{$row->avances_planificados}</td>
								<td>{$row->avances_reales}</td>
								<td>{$row->medio_verificacion}</td>
								<td>{$row->observacion}</td>
								".$tar."
							</tr>";
					}else{
						$form="<tr>
								<td><h6><b>{$row->nombre_p}</b></h6></td>
								<td>{$row->fecha_creacionp}</td>
								<td><b>{$row->nombre_f}</b></td>
								<td>{$row->fecha_inicialfs}</td>
								<td>{$row->fecha_finalfs}</td>
								<td>{$row->componentes}</td>
								<td>{$row->actividades}</td>
								<td>{$row->resultados_obtenidos}</td>
								<td>{$row->avances_planificados}</td>
								<td>{$row->avances_reales}</td>
								<td>{$row->medio_verificacion}</td>
								<td>{$row->observacion}</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>";
					}
					
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
	public function generar_excel(){//genera un documento con el formato .xls para usar en excel
		$form_arr = array();//devuelve un arreglo de proyectoss
		$form = "<tr>
				<td colspan=\"2\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"2\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"2\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td  colspan=\"1\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td  colspan=\"1\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
			  </tr>
			  <tr>
				<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
				<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
			  </tr>";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select nombre_p,nombre_f,nombre_tarea,actividades,avances_planificados,avances_reales,resultados_obtenidos,medio_verificacion,observacion from asignaciones a inner join tareas t on a.id_tarea = t.id_tarea inner join etapas et on t.id_fase = et.id_fase inner join proyectos f on et.id_proyecto = f.id_proyecto where nombre_p = (select nombre_p from proyectos where id_proyecto = :id_proyecto)");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $this->id_p;
			
			//condicion que asegura que el método se ejecute correctamente
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					
				$form = "
					  <tr>
						<td colspan=\"2\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->nombre_p}</td>
						<td colspan=\"2\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->nombre_f}</td>
						<td colspan=\"2\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->nombre_tarea}</td>
						<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->actividades}</td>
						<td  colspan=\"1\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->avances_planificados}</td>
						<td  colspan=\"1\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->avances_reales}</td>
						<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
						<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
					  </tr>
					  <tr>
						<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->resultados_obtenidos}</td>
						<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->medio_verificacion}</td>
						<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\">{$row->observacion}</td>
						<td colspan=\"3\" style=\"padding: 4px; margin: 3px; border: 1px solid #4C4C4C; color: #000\"></td>
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
	
	public function listar_excel_cuatrimestre2(){//cambios en v2.0, mejora en generar reportes del 16 al 25 de mayo
		
		$form_arr = array();//devuelve un arreglo de proyectoss
		$form = "";//carga datos en proyectoss diferentes
		$contenedor="";
		$contenedor2=array();
		$asignaciones = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		$us = new Usuario();
		$tarea = new Tareas();
		try{
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $con2->prepare("SELECT * from proyectos f inner join etapas e on f.id_proyecto = e.id_proyecto ");
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					$id_fase = $row->id_fase;
					$contenedor2 = $tarea->exc_tareas($id_fase);
					$tar = implode(" ",$contenedor2);//une un arreglo de datos y los separa con un espacio
					if($tar!=""){
						$form="<tr>
								<td><h6><b>{$row->nombre_p}</b></h6></td>
								<td>{$row->fecha_creacionp}</td>
								<td><b>{$row->nombre_f}</b></td>
								<td>{$row->fecha_inicialfs}</td>
								<td>{$row->fecha_finalfs}</td>
								<td>{$row->componentes}</td>
								<td>{$row->actividades}</td>
								<td>{$row->resultados_obtenidos}</td>
								<td>{$row->avances_planificados}</td>
								<td>{$row->avances_reales}</td>
								<td>{$row->medio_verificacion}</td>
								<td>{$row->observacion}</td>
								".$tar."
							</tr>";
					}else{
						$form="<tr>
								<td><h6><b>{$row->nombre_p}</b></h6></td>
								<td>{$row->fecha_creacionp}</td>
								<td><b>{$row->nombre_f}</b></td>
								<td>{$row->fecha_inicialfs}</td>
								<td>{$row->fecha_finalfs}</td>
								<td>{$row->componentes}</td>
								<td>{$row->actividades}</td>
								<td>{$row->resultados_obtenidos}</td>
								<td>{$row->avances_planificados}</td>
								<td>{$row->avances_reales}</td>
								<td>{$row->medio_verificacion}</td>
								<td>{$row->observacion}</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>";
					}
					
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

/*if($cuatrimestre>=0 && $cuatrimestre < 4){
				if($cuatrimestre==1){
					$stmt = $con2->prepare("
                     DROP TEMPORARY TABLE IF EXISTS projects;
                    CREATE TEMPORARY TABLE IF NOT EXISTS projects
		              SELECT * FROM proyectos  WHERE YEAR(fecha_creacionp) = :fecha_creacionp 
                      AND MONTH(fecha_creacionp) = 1 
						OR MONTH(fecha_creacionp) = 2 
						OR MONTH(fecha_creacionp) = 3 
						OR MONTH(fecha_creacionp) = 4;
                        SELECT * from projects p inner join etapas e on p.id_proyecto = e.id_proyecto;");
					$stmt->bindValue(':fecha_creacionp', $an);
                    $an = $anho;
                    /*$stmt->bindValue(':domain_name', $domain);
                    $stmt->execute();
                    $article_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}else if($cuatrimestre==2){
					$cuatrimestre=$stmt = $con2->prepare("
                     DROP TEMPORARY TABLE IF EXISTS projects;
                    CREATE TEMPORARY TABLE IF NOT EXISTS projects
		              SELECT * FROM proyectos  WHERE YEAR(fecha_creacionp) = :fecha_creacionp OR 
                      MONTH(fecha_creacionp) = '5' 
						AND MONTH(fecha_creacionp) = 6 
						OR MONTH(fecha_creacionp) = 7 
						OR MONTH(fecha_creacionp) = 8;
                        SELECT * from projects p inner join etapas e on p.id_proyecto = e.id_proyecto;");
                    $stmt->bindValue(':fecha_creacionp', $an);
                    $an = $anho;
				}else if($cuatrimestre==3){
					$cuatrimestre=$stmt = $con2->prepare("
                     DROP TEMPORARY TABLE IF EXISTS projects;
                    CREATE TEMPORARY TABLE IF NOT EXISTS projects
		              SELECT * FROM proyectos f WHERE YEAR(fecha_creacionp) = :fecha_creacionp
						AND MONTH(fecha_creacionp) = 9 
						OR MONTH(fecha_creacionp) = 10 
						OR MONTH(fecha_creacionp) = 11 
						OR MONTH(fecha_creacionp) = 12;
                        SELECT * from projects p inner join etapas e on p.id_proyecto = e.id_proyecto;");
                    $stmt->bindValue(':fecha_creacionp', $an);
                    $an = $anho;
				}*/
/* query perfecto
		CREATE TEMPORARY TABLE IF NOT EXISTS projects
		SELECT * FROM proyectos WHERE YEAR(fecha_creacionp) = :fecha_creacionp;

		SELECT * from projects p inner join etapas e on p.id_proyecto = e.id_proyecto
		*/
?>