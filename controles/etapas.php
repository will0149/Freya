<?php
include_once("conexion/conexion.php");
class Etapas{
	
    public function nueva_etapa($ardatos){
            $flag = false;
            $i=0;
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("insert into etapas (id_proyecto,nombre_f,fecha_inicialfs,fecha_finalfs,componentes,actividades,resultados_obtenidos,avances_planificados,avances_reales,medio_verificacion,observacion)	values(:id_proyecto,:nombre_f,:fecha_inicialfs,:fecha_finalfs,:componentes,:actividades,:resultados_obtenidos,:avances_planificados,:avances_reales,:medio_verificacion,:observacion)");
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
                    if($stmt->execute()){
                        Etapas::aumentar_etapas($ardatos[0]);
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
    public function aumentar_etapas($id_pro){//metodo especial para cuando se crea una etapa nueva
            $flag = false;
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("UPDATE proyectos set cant_etapa=cant_etapa + 1 where id_proyecto = :id_proyecto");//instruccion que aumenta la cantidad de etapas en la tabla proyectos

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
            return $flag;
    }
    public function listar_etapas_proyecto($id_pro){//crea una lista select de las fases de un proyecto
            $form_arr = array();//devuelve un arreglo de proyectoss
            $form = "<option value=\"</option>";
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
    public function crear_etapas($ca_e,$nom_p){
            $flag = false;
            $i=0;
            $con = new Conexion();
            $con2 = $con->conectar();

            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("insert into etapas(id_proyecto,nombre_f) values((select id_proyecto from proyectos where nombre_p = :nombre_p),:nombre_f)");

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

    public function form_por_etapa($id_p){//crea proyectoss por fase para su edicion y vista
            $form_arr = array();//devuelve un arreglo de proyectoss
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
                            $cont=0;
                            while ($row = $stmt->fetchObject()) {
                                    $cont+=1;
                            $form = "
                                    <form method=\"post\" action=\"index.php?action=guardarCambiosEtapa\" class=\"form\">
                                            <fieldset>
                                                    <legend><b>$cont:{$row->nombre_f}</b></legend>
                                                    <table border=\"0\" class=\"table-responsive\">
                                                            <tr>
                                                                    <td >
                                                                            <label>Id fase</label>
                                                                    </td>

                                                                    <td >
                                                                            <abbr title =\"No Modificar éste campo\">
                                                                            <input type=\"text\" value=\"{$row->id_fase}\"  name=\"idfase\" readonly=\"readonly\">
                                                                            </abbr title> 
                                                                    </td>

                                                            <!--/tr>
                                                            <tr-->
                                                                    <td >
                                                                            <label>Nombre Fase</label>
                                                                    </td>
                                                                    <td >
                                                                    
                                                                            <input type=\"text\" id=\"txta\" value=\"{$row->nombre_f}\" name=\"nomf\">
                                                                            
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>fecha inicial</label>
                                                                    </td>
                                                                    <td >
                                                                            <input type=\"text\" id=\"datepicker\" onClick=\"calendario\" value=\"{$row->fecha_inicialfs}\" name=\"nfechaI\">
                                                                            
                                                                    </td>
                                                            <!--/tr>
                                                            <tr-->
                                                                    <td >
                                                                            <label>fecha final</label>
                                                                    </td>
                                                                    <td >
                                                                            <input type=\"text\" id=\"datepicker2\" onClick=\"calendario\" value=\"{$row->fecha_finalfs}\" name=\"nfechaF\">
                                                                            
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>Componentes</label>
                                                                    </td>
                                                                    <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtacom\" maxlength=\"5000\">{$row->componentes}</textarea>
                                                                    </td>
                                                            <!--/tr>
                                                            <tr-->
                                                                    <td >
                                                                            <label>Actividades</label>
                                                                    </td>
                                                                    <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtact\" maxlength=\"5000\">{$row->actividades}</textarea>
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>Resultados obtenido</label>
                                                                    </td>
                                                                    <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtareso\" maxlength=\"5000\">{$row->resultados_obtenidos}</textarea>
                                                                    </td>
                                                            <!--/tr>
                                                            <tr-->
                                                                     <td ><label>OBSERVACION</label></td>
                                                                     <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtaobs\" maxlength=\"5000\">{$row->observacion}</textarea>
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td ><label>AVANCE PLANEADO</label></td>
                                                                    <td >
                                                                            <input type=\"text\" id=\"txta\" name=\"avap\" value=\"{$row->avances_planificados}\">
                                                                    </td>
                                                            <!--/tr>
                                                            <tr-->
                                                                    <td ><label>AVANCE REAL</label></td>
                                                                    <td >
                                                                            <input type=\"text\" id=\"txta\"  name=\"avar\" value=\"{$row->avances_reales}\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                     <td ><label>MEDIOS DE VERIFICACION</label></td>
                                                                     <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtamev\" maxlength=\"5000\">{$row->medio_verificacion}</textarea>
                                                                    </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                    <td >
                                                                            <input  class=\"btn\"type=\"submit\" value=\"guardar\">
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
    public function form_por_etapa2($nom_p){//crea proyectoss por fase para su edicion y vista
            $form_arr = array("","");//devuelve un arreglo de proyectoss
            $form = "";
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("select * from etapas e inner join proyectos f on e.id_proyecto = f.id_proyecto  where nombre_p = :nombre_p");
                    $stmt->bindParam(':nombre_p', $np);
                    $np = $nom_p;

                    if($stmt->execute()){
                            $cont=0;
                            while ($row = $stmt->fetchObject()) {
                                    $cont+=1;
                            $form = "
                                    <form action=\"\" method=\"post\" class=\"form_d\">
                                            <fieldset>
                                            <legend><b>$cont: {$row->nombre_f}</b></legend>
                                                    <table border=\"0\" class=\"tablaPrincipal\">
                                                            <tr>
                                                                    <td >
                                                                            <label>Id fase</label>
                                                                    </td>

                                                                    <td >
                                                                            <abbr title =\"No Modificar éste campo\">
                                                                            <input type=\"text\" value=\"{$row->id_fase}\"  name=\"idfase\" readonly=\"readonly\">
                                                                            </abbr title> 
                                                                    </td>

                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>Nombre Fase</label>
                                                                    </td>
                                                                    <td >
                                                                            <input type=\"text\" id=\"txta\" value=\"{$row->nombre_f}\" name=\"nomf\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>fecha inicial</label>
                                                                    </td>
                                                                    <td >
                                                                            <input type=\"date\" id=\"datepicker\"  value=\"{$row->fecha_inicialfs}\" name=\"nfechaI\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>fecha final</label>
                                                                    </td>
                                                                    <td >
                                                                            <input type=\"date\" id=\"datepicker2\" value=\"{$row->fecha_finalfs}\" name=\"nfechaF\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>Componentes</label>
                                                                    </td>
                                                                    <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtacom\" maxlength=\"5000\">{$row->componentes}</textarea>
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>Actividades</label>
                                                                    </td>
                                                                    <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtact\" maxlength=\"5000\">{$row->actividades}</textarea>
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>Resultados obtenido</label>
                                                                    </td>
                                                                    <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtareso\" maxlength=\"5000\">{$row->resultados_obtenidos}</textarea>
                                                                    </td>
                                                            </tr>

                                                            <tr>
                                                                    <td ><label>AVANCE PLANEADO</label></td>
                                                                    <td >
                                                                            <input type=\"text\" id=\"txta\" name=\"avap\" value=\"{$row->avances_planificados}\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td ><label>AVANCE REAL</label></td>
                                                                    <td >
                                                                            <input type=\"text\" id=\"txta\"  name=\"avar\" value=\"{$row->avances_reales}\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                     <td ><label>MEDIOS DE VERIFICACION</label></td>
                                                                     <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtamev\" maxlength=\"5000\">{$row->medio_verificacion}</textarea>
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                     <td ><label>OBSERVACION</label></td>
                                                                     <td >
                                                                            <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtaobs\" maxlength=\"5000\">{$row->observacion}</textarea>
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <input  class=\"btn\"type=\"submit\" value=\"guardar\">
                                                                    </td>
                                                                    <td >
                                                                            <input class=\"btn\" type=\"reset\">
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
                    }finally{
                        $con2 = null;
                    }
            
            return $form_arr;
    }
    public function modificar_etapa($ardatos){//crea proyectoss por etapa para su edicion y vista
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
    public function validar_doble_etapa($id_pro,$nom_f){
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
}
