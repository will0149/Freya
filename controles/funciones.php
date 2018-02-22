<?php
include_once("conexion/conexion.php");
include_once("controles/usuario.php");
class Funciones{
	private $conn;
	private $nom_pro;
	private $cant_et;
	private $est;
	private $id_p;
	public function __Construct(){
		$c = new Conexion();
		$con2 = $c->conectar();
	}
	
	public function cargar_proy($nom_pro,$cant_et,$estad){
		$this->nom_pro = $nom_pro;
		$this->cant_et = $cant_et;
		$this->est = $estad;
	}
	public function aumentar_etapas($id_pro){
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("UPDATE formulario set cant_etapa=cant_etapa + 1 where id_proyecto = :id_proyecto");//instruccion que aumenta la cantidad de etapas en la tabla formulario
			
			$stmt->bindParam(':id_proyecto', $id_pro);
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
	public function mostrar_todos_proyectos(){
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from formulario");
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					$form = "<option value=\"{$row->id_proyecto}\">{$row->nombre_p}</option>";
	;				array_push($form_arr,$form);
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
	public function listar_todos_proyectos(){//muestra un informe pequeño de todos los proyectos
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from formulario");
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					$form = "<tr>
							<td>{$row->nombre_p}</td>
							<td>{$row->cant_etapa}</td>
							<td>{$row->fecha_creacionp}</td>
							<td>{$row->estado}</td>
						</tr>";
	;				array_push($form_arr,$form);
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
	public function listar_fases_proyecto($id_pro){//crea una lista select de las fases de un proyecto
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select id_fase,nombre_f from etapas WHERE id_proyecto = :id_proyecto");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $id_pro;
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "<option value=\"{$row->id_fase}\">{$row->nombre_f}</option>";
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
	public function listar_tareas_proyecto($id_fas){//crea una lista de las tareas de una etapa
		$form_arr = array("","");//devuelve un arreglo de formularios
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
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "<form action=\"guardar_cambios_tareas.php\" method=\"post\" id=\"form\">
					<table border=\"0\" class=\"tablaPrincipal\">
						<tr>
                            <td id=\"relleno\">
                                <label>ID Tarea</label>
                            </td>
                            <td id=\"relleno\">
                                <input type=\"text\" value=\"{$row->id_tarea}\" name=\"idtarea\" readonly=\"readonly\">
                            </td>
                        </tr>
                        <tr>
                            <td id=\"relleno\">
                                <label>tarea a realizar</label>
                            </td>
                            <td id=\"relleno\">
                                <input type=\"text\" value=\"{$row->nombre_tarea}\" name=\"tareaR\">
                            </td>
                        </tr>
                        <tr>
                            <td id=\"relleno\">
                                <label>fecha inicial</label>
                            </td>
                            <td id=\"relleno\">
                                <input type=\"date\" value=\"{$row->fecha_inicialt}\"  name=\"fechaI\">
                            </td>
                        </tr>
                        <tr>
                            <td id=\"relleno\">
                                <label>fecha final</label>
                            </td>
                            <td id=\"relleno\">
                                <input type=\"date\" value=\"{$row->fecha_finalt}\"  name=\"fechaF\">
                            </td>
                        </tr>
                        <tr>
                        <tr>
                             <td id=\"relleno\"><label>estado</label></td>
                             <td id=\"relleno\">
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
                            <td id=\"relleno\">
                                <input type=\"submit\" class=\"btn\">
                            </td>
                            <td id=\"relleno\">
                                <input type=\"reset\" class=\"btn\">
                            </td>
                        </tr>
                </table>

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
	/*public function listar_asignaciones($cedula){//falta
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from asignaciones a inner join tareas t on a.id_tarea = t.id_tarea inner join etapas et on t.id_fase = et.id_fase inner join formulario f on et.id_proyecto = f.id_proyecto WHERE cedula = :cedula");
			$stmt->bindParam(':cedula', $np);
			$np = $cedula;
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "";
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
	}*/
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
			inner join formulario f on et.id_proyecto = f.id_proyecto
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
	public function listar_tareas($id_fase){//crea una lista select las en un fase
		$form_arr = array();//devuelve un arreglo de formularios
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
	public function listar_excel($id_pro){//crea una tabla preview de excel antes de descargar
		$form_arr = array();//devuelve un arreglo de formularios
		$this->id_p = $id_pro;
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
		$stmt = $con2->prepare("select nombre_p,nombre_f,nombre_tarea,actividades,avances_planificados,avances_reales,resultados_obtenidos,medio_verificacion,observacion from asignaciones a inner join tareas t on a.id_tarea = t.id_tarea inner join etapas et on t.id_fase = et.id_fase inner join formulario f on et.id_proyecto = f.id_proyecto where nombre_p = (select nombre_p from formulario where id_proyecto = :id_proyecto)");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $id_pro;

			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "<tr>
								<td colspan=\"2\">{$row->nombre_p}</td>
								<td colspan=\"2\">{$row->nombre_f}</td>
								<td colspan=\"2\">{$row->nombre_tarea}</td>
								
								<td colspan=\"5\">{$row->actividades}</td>
								<td>{$row->avances_planificados}</td>
								<td>{$row->avances_reales}</td>
								<td colspan=\"5\">{$row->resultados_obtenidos}</td>
								<td colspan=\"3\">{$row->medio_verificacion}</td>
								<td colspan=\"5\">{$row->observacion}</td>
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
	public function listar_excel_cuatrimestre(){
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$contenedor="";
		$asignaciones = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		$us = new Usuario();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("SELECT *,(CASE
  WHEN MONTH(fecha_creacionp) IN (1,2,3,4) THEN 1
  WHEN MONTH(fecha_creacionp) IN (5,6, 7,8) THEN 2
  WHEN MONTH(fecha_creacionp) IN (9, 10,11,12) THEN 3
  END) Cuatrimestre FROM formulario f
 INNER JOIN etapas e on f.id_proyecto = e.id_proyecto
 inner join tareas ta on e.id_fase = ta.id_fase
GROUP BY Cuatrimestre;");
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					$id_t = "{$row->id_tarea}";
					$contenedor = $us->listar_us_asignaciones($id_t);
					$extra = implode(" ",$contenedor);
					$id_t = "{$row->id_tarea}";
					$contenedor = $us->listar_us_asignaciones($id_t);
					$extra = implode(" ",$contenedor);
					$form="<tr>
					<td>{$row->nombre_p}</td>
					<td>{$row->fecha_creacionp}</td>
					<td>{$row->nombre_f}</td>
					<td>{$row->fecha_inicialfs}</td>
					<td>{$row->fecha_finalfs}</td>
					<td>{$row->componentes}</td>
					<td>{$row->actividades}</td>
					<td>{$row->resultados_obtenidos}</td>
					<td>{$row->avances_planificados}</td>
					<td>{$row->avances_reales}</td>
					<td>{$row->medio_verificacion}</td>
					<td>{$row->observacion}</td>
					<td>{$row->nombre_tarea}</td>
					<td>{$row->fecha_inicialt}</td>
					<td>{$row->fecha_finalt}</td>
					<td>{$row->estado}</td>
					<td>$extra</td>
					<td>{$row->Cuatrimestre}</td>
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
	public function todos_los_datos_en_un_proyecto($id_pro){//muestra todos los datos que hay en un formulari
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$contenedor="";
		$asignaciones = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		$us = new Usuario();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from formulario f INNER JOIN etapas e on f.id_proyecto = e.id_proyecto inner join tareas ta on e.id_fase = ta.id_fase where nombre_p = (select nombre_p from formulario where id_proyecto = :id_proyecto)");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $id_pro;
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
					$id_t = "{$row->id_tarea}";
					$contenedor = $us->listar_us_asignaciones($id_t);
					$extra = implode(" ",$contenedor);
					$form="<tr>
					<td>{$row->nombre_p}</td>
					<td>{$row->fecha_creacionp}</td>
					<td>{$row->nombre_f}</td>
					<td>{$row->fecha_inicialfs}</td>
					<td>{$row->fecha_finalfs}</td>
					<td>{$row->componentes}</td>
					<td>{$row->actividades}</td>
					<td>{$row->resultados_obtenidos}</td>
					<td>{$row->avances_planificados}</td>
					<td>{$row->avances_reales}</td>
					<td>{$row->medio_verificacion}</td>
					<td>{$row->observacion}</td>
					<td>{$row->nombre_tarea}</td>
					<td>{$row->fecha_inicialt}</td>
					<td>{$row->fecha_finalt}</td>
					<td>{$row->estado}</td>
					<td>$extra</td>
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
	public function nuevo_proyecto(){//crear un nuevo proyeto
		$flag = false;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("insert into formulario(nombre_p,cant_etapa,fecha_creacionp,estado) values(:nombre_p,:cant_etapa,now(),:estado)");
			$stmt->bindParam(':nombre_p', $np);
			$stmt->bindParam(':cant_etapa', $ce);
			$stmt->bindParam(':estado', $es);
			
			$np = $this->nom_pro;
			$ce = $this->cant_et;
			$es = $this->est;
			
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
	public function crear_fases($ca_e,$nom_p){
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("insert into etapas(id_proyecto,nombre_f) values((select id_proyecto from formulario where nombre_p = :nombre_p),:nombre_f)");
			
			$stmt->bindParam(':nombre_p', $np);
			$stmt->bindParam(':nombre_f', $ne);
			// "
			while($i<$ca_e){
				$np = $nom_p;
				$num = $i++;
			    $ne = "Etapa $num";
				if($stmt->execute()){
					$flag = true;
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
	public function nueva_tarea($ardatos){
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("insert into tareas(id_fase,nombre_tarea,fecha_inicialt,fecha_finalt,estado) values(:id_fase,:nombre_tarea,:fecha_inicialt,:fecha_finalt,:estado)");
			
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
		return $flag;
	}
	public function nueva_etapa($ardatos){
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("insert into etapas values(:id_proyecto,:nombre_f,:fecha_inicialfs,:fecha_finalfs,:componentes,:actividades,:resultados_obtenidos,:avances_planificados,:avances_reales,:medio_verificacion,:observacion)");
			$stmt->bindParam(':id_proyecto', $ardatos[0]);
			$stmt->bindParam(':nombre_f', $ardatos[1]);
			$stmt->bindParam('fecha_inicialfs', $ardatos[2]);
			$stmt->bindParam(':fecha_finalfs', $ardatos[3]);
			$stmt->bindParam(':componentes', $ardatos[4]);
			$stmt->bindParam(':actividades', $ardatos[5]);
			$stmt->bindParam(':resultados_obtenidos', $ardatos[6]);
			$stmt->bindParam(':avances_planificados', $ardatos[7]);
			$stmt->bindParam(':avances_reales', $ardatos[8]);
			$stmt->bindParam(':medio_verificacion', $ardatos[9]);
			$stmt->bindParam(':observacion', $ardatos[10]);
			
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
	public function form_por_fase($id_p){//crea formularios por fase para su edicion y vista
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from etapas  where id_proyecto = :id_proyecto");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $id_p;
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "
							<form action=\"guardar_cambios_fase.php\" method=\"post\" class=\"form_d\">
							
								<table border=\"0\" class=\"tablaPrincipal\">
									<tr>
										<td id=\"relleno\">
											<label>Id fase</label>
										</td>
										
										<td id=\"relleno\">
											<abbr title =\"No Modificar éste campo\">
											<input type=\"text\" value=\"{$row->id_fase}\"  name=\"idfase\" readonly=\"readonly\">
											</abbr title> 
										</td>
										
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Nombre Fase</label>
										</td>
										<td id=\"relleno\">
											<input type=\"text\" id=\"txta\" value=\"{$row->nombre_f}\" name=\"nomf\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>fecha inicial</label>
										</td>
										<td id=\"relleno\">
											<input type=\"date\" id=\"txta\" value=\"{$row->fecha_inicialfs}\" name=\"nfechaI\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>fecha final</label>
										</td>
										<td id=\"relleno\">
											<input type=\"date\" id=\"txta\" value=\"{$row->fecha_finalfs}\" name=\"nfechaF\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Componentes</label>
										</td>
										<td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtacom\" maxlength=\"5000\">{$row->componentes}</textarea>
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Actividades</label>
										</td>
										<td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtact\" maxlength=\"5000\">{$row->actividades}</textarea>
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Resultados obtenido</label>
										</td>
										<td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtareso\" maxlength=\"5000\">{$row->resultados_obtenidos}</textarea>
										</td>
									</tr>

									<tr>
										<td id=\"relleno\"><label>AVANCE PLANEADO</label></td>
										<td id=\"relleno\">
											<input type=\"text\" id=\"txta\" name=\"avap\" value=\"{$row->avances_planificados}\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\"><label>AVANCE REAL</label></td>
										<td id=\"relleno\">
											<input type=\"text\" id=\"txta\"  name=\"avar\" value=\"{$row->avances_reales}\">
										</td>
									</tr>
									<tr>
										 <td id=\"relleno\"><label>MEDIOS DE VERIFICACION</label></td>
										 <td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtamev\" maxlength=\"5000\">{$row->medio_verificacion}</textarea>
										</td>
									</tr>
									<tr>
										 <td id=\"relleno\"><label>OBSERVACION</label></td>
										 <td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtaobs\" maxlength=\"5000\">{$row->observacion}</textarea>
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<input  class=\"btn\"type=\"submit\" value=\"guardar\">
										</td>
										<td id=\"relleno\">
											<input class=\"btn\" type=\"reset\">
										</td>
									</tr>
							</table>
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

	public function form_por_fase2($nom_p){//crea formularios por fase para su edicion y vista
		$form_arr = array("","");//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from etapas e inner join formulario f on e.id_proyecto = f.id_proyecto  where nombre_p = :nombre_p");
			$stmt->bindParam(':nombre_p', $np);
			$np = $nom_p;
			
			if($stmt->execute()){
				while ($row = $stmt->fetchObject()) {
				$form = "
							<form action=\"guardar_cambios_fase.php\" method=\"post\" class=\"form_d\">
							
								<table border=\"0\" class=\"tablaPrincipal\">
									<tr>
										<td id=\"relleno\">
											<label>Id fase</label>
										</td>
										
										<td id=\"relleno\">
											<abbr title =\"No Modificar éste campo\">
											<input type=\"text\" value=\"{$row->id_fase}\"  name=\"idfase\" readonly=\"readonly\">
											</abbr title> 
										</td>
										
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Nombre Fase</label>
										</td>
										<td id=\"relleno\">
											<input type=\"text\" id=\"txta\" value=\"{$row->nombre_f}\" name=\"nomf\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>fecha inicial</label>
										</td>
										<td id=\"relleno\">
											<input type=\"date\" id=\"txta\" value=\"{$row->fecha_inicialfs}\" name=\"nfechaI\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>fecha final</label>
										</td>
										<td id=\"relleno\">
											<input type=\"date\" id=\"txta\" value=\"{$row->fecha_finalfs}\" name=\"nfechaF\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Componentes</label>
										</td>
										<td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtacom\" maxlength=\"5000\">{$row->componentes}</textarea>
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Actividades</label>
										</td>
										<td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtact\" maxlength=\"5000\">{$row->actividades}</textarea>
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<label>Resultados obtenido</label>
										</td>
										<td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtareso\" maxlength=\"5000\">{$row->resultados_obtenidos}</textarea>
										</td>
									</tr>

									<tr>
										<td id=\"relleno\"><label>AVANCE PLANEADO</label></td>
										<td id=\"relleno\">
											<input type=\"text\" id=\"txta\" name=\"avap\" value=\"{$row->avances_planificados}\">
										</td>
									</tr>
									<tr>
										<td id=\"relleno\"><label>AVANCE REAL</label></td>
										<td id=\"relleno\">
											<input type=\"text\" id=\"txta\"  name=\"avar\" value=\"{$row->avances_reales}\">
										</td>
									</tr>
									<tr>
										 <td id=\"relleno\"><label>MEDIOS DE VERIFICACION</label></td>
										 <td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtamev\" maxlength=\"5000\">{$row->medio_verificacion}</textarea>
										</td>
									</tr>
									<tr>
										 <td id=\"relleno\"><label>OBSERVACION</label></td>
										 <td id=\"relleno\">
											<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtaobs\" maxlength=\"5000\">{$row->observacion}</textarea>
										</td>
									</tr>
									<tr>
										<td id=\"relleno\">
											<input  class=\"btn\"type=\"submit\" value=\"guardar\">
										</td>
										<td id=\"relleno\">
											<input class=\"btn\" type=\"reset\">
										</td>
									</tr>
							</table>
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
	public function form_por_proyecto($id_pro){////crea formularios por proyecto para su edicion y vista
		$form="";
		$flag = false;
		$con = new Conexion();$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select id_proyecto,nombre_p,estado from formulario where id_proyecto=:id_proyecto");
			$stmt->bindParam(':id_proyecto', $id_pro);
			if($stmt->execute()){
					if($row = $stmt->fetchObject()) {
					$form = "<form class=\"form_d\" action=\"guardar_cambios_proyecto.php\" method=\"post\">
						<table border=\"0\" class=\"tablaPrincipal\">
								<tr>
									<td id=\"relleno\"><label>ID DEL PROYECTO</label></td>
									<td id=\"relleno\">
										<input type=\"text\" name=\"id_pro\" value=\"{$row->id_proyecto}\" readonly=\"readonly\">
									</td>
								</tr>
								<tr>
									<td id=\"relleno\"><label>NOMBRE DEL PROYECTO</label></td>
									<td id=\"relleno\">
										<input type=\"text\" name=\"n_proy\" value=\"{$row->nombre_p}\">
									</td>
								</tr>
								<tr>
									<td id=\"relleno\">
										<label>ESTADO</label>
									</td>
									<td id=\"relleno\">
										<select name=\"status\">
										    <option value=\"{$row->estado}\">{$row->estado}</option>
											<option value=\"En proceso\">En proceso</option>
											<option value=\"Detenido\">Detenido</option>
											<option value=\"Cancelado\">Cancelado</option>
											<option value=\"Finalizado\">Finalizado</option>
										</select>
									</td>
								</tr>

								<tr>
									<td id=\"relleno\">
										<input type=\"submit\" class=\"btn\">
									</td>
									<td id=\"relleno\">
										<input type=\"reset\" class=\"btn\">
									</td>
								</tr>

						</table>
				</form>";
				}
			
				}
			}
		catch(PDOException $e)
			{
			echo "Error: " . $e->getMessage();
			}
		$con2 = null;
		return $form;
	}
	public function modificar_proyecto($id_pro,$nom_pro,$estad){//crea formularios por proyecto para su edicion y vista
		$flag = false;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("UPDATE formulario SET nombre_p=:nombre_p,estado=:estado where id_proyecto=:id_proyecto");
			$stmt->bindParam(':nombre_p', $np);
			$stmt->bindParam(':estado', $es);
			$stmt->bindParam(':id_proyecto', $id_pro);
			$np = $nom_pro;
			$es = $estad;
			
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
	public function modificar_tarea($ardatos){//crea formularios por tarea para su edicion y vista
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("UPDATE tareas set nombre_tarea= :nombre_tarea,fecha_inicialt=:fecha_inicialt,fecha_finalt=:fecha_finalt,estado=:estado where id_tarea = :id_tarea");
			
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
	
	public function modificar_etapa($ardatos){//crea formularios por etapa para su edicion y vista
		$flag = false;
		$i=0;
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("UPDATE etapas set nombre_f = :nombre_f,fecha_inicialfs=:fecha_inicialfs,fecha_finalfs=:fecha_finalfs,componentes=:componentes,actividades=:actividades,resultados_obtenidos=:resultados_obtenidos,avances_planificados=:avances_planificados,avances_reales=:avances_reales,medio_verificacion=:medio_verificacion,observacion=:observacion where id_fase=:id_fase");
			
			$stmt->bindParam(':nombre_f', $ardatos[1]);
			$stmt->bindParam('fecha_inicialfs', $ardatos[2]);
			$stmt->bindParam(':fecha_finalfs', $ardatos[3]);
			$stmt->bindParam(':componentes', $ardatos[4]);
			$stmt->bindParam(':actividades', $ardatos[5]);
			$stmt->bindParam(':resultados_obtenidos', $ardatos[6]);
			$stmt->bindParam(':avances_planificados', $ardatos[7]);
			$stmt->bindParam(':avances_reales', $ardatos[8]);
			$stmt->bindParam(':medio_verificacion', $ardatos[9]);
			$stmt->bindParam(':observacion', $ardatos[10]);
			$stmt->bindParam(':id_fase', $ardatos[0]);
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
	
	public function generar_excel(){//genera un documento con el formato .xls para usar en excel
		$form_arr = array();//devuelve un arreglo de formularios
		$form = "";
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select nombre_p,nombre_f,nombre_tarea,actividades,avances_planificados,avances_reales,resultados_obtenidos,medio_verificacion,observacion from asignaciones a inner join tareas t on a.id_tarea = t.id_tarea inner join etapas et on t.id_fase = et.id_fase inner join formulario f on et.id_proyecto = f.id_proyecto where nombre_p = (select nombre_p from formulario where id_proyecto = :id_proyecto)");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $this->id_p;

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

	//de aqui para solo es para evitar que se creen archivos en una tabla con el mismo nombre
	public function validar_doble_pro($nom_pro){
		$flag = false;
		$list = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("SELECT * FROM formulario where nombre_p = :nombre_p " );
			$stmt->bindParam(':nombre_p', $np);
			$np = $nom_pro;
			
			if($stmt->execute()){
				while($row = $stmt->fetchObject()){
					array_push($list,$row->nombre_p);
				}
			}
			if(sizeOf($list) > 0){
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
	public function validar_doble_fase($id_pro,$nom_f){
		$flag = false;
		$list = array();
		$con = new Conexion();
		$con2 = $con->conectar();
		try{
			// se establece el modo de error PDO a Exception
			$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Se prepara el satetement y se cargan los parametros
			$stmt = $con2->prepare("select * from etapas  where id_proyecto = :id_proyecto");
			$stmt->bindParam(':id_proyecto', $np);
			$np = $id_pro;
			
			if($stmt->execute()){
				while($row = $stmt->fetchObject()){
					array_push($list,$row->nombre_f);
				}
			}
			foreach($list as $l){//ciclo en donde se almacenan todos los valores de las consultas
				if(stristr($nom_f,$l)){//se compara este arreglo con el nombre para saber si existe o no
					$flag = true;
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
}
?>