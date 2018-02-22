<?php
include_once("conexion/conexion.php");
class Proyectos{
    public $nom_pro;
    public $cant_et;
    public $est;
    public $id_p;
    public function nuevo_proyecto($datosModel){//crear un nuevo proyeto
            $nom_pro = $datosModel["nProyecto"];
            $cant_et = $datosModel["nEtapasProyecto"];
            $est = $datosModel["nStatusProyecto"];
            $et = new Etapas();
            $flag = false;
            $con = new Conexion();
            $con2 = $con->conectar();
            if(Proyectos::validar_doble_pro($nom_pro)){
                $flag = false;
            }
            else{
                try{
                        // se establece el modo de error PDO a Exception
                        $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $con2->prepare("insert into proyectos(nombre_p,cant_etapa,fecha_creacionp,estado) values(:nombre_p,:cant_etapa,now(),:estado)");
                        $stmt->bindParam(':nombre_p', $np);
                        $stmt->bindParam(':cant_etapa', $ce);
                        $stmt->bindParam(':estado', $es);

                        $np = $nom_pro;
                        $ce = $cant_et;
                        $es = $est;

                        if($stmt->execute()){
                                if($et->crear_etapas($cant_et,$nom_pro)){
                                        $flag = true;
                                }
                        }
                }
                catch(PDOException $e)
                {
                echo "Error: " . $e->getMessage();
                }
                finally {
                    $con2 = null;
                }
            }
                    
            
            return $flag;
    }
    public function form_por_proyecto($id_pro){////crea un proyectos por proyecto para su edicion y vista
            $form="";
            $flag = false;
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("select id_proyecto,nombre_p,estado from proyectos where id_proyecto=:id_proyecto");
                    $stmt->bindParam(':id_proyecto', $id_pro);
                    if($stmt->execute()){
                                    if($row = $stmt->fetchObject()) {
                                    $form = "
                                    <form class=\"form\" method=\"post\">
                                    <fieldset><legend><b>{$row->nombre_p}</b></legend>
                                            <table border=\"0\" class=\"table-responsive\">
                                                            <tr>
                                                                    <td ><label>ID DEL PROYECTO</label></td>
                                                                    <td >
                                                                            <input type=\"text\" name=\"id_pro\" value=\"{$row->id_proyecto}\" readonly=\"readonly\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td ><label>NOMBRE DEL PROYECTO</label></td>
                                                                    <td >
                                                                            <input type=\"text\" name=\"nom_pro\" value=\"{$row->nombre_p}\">
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label for=\"responsable\">Responsable Del Proyecto</label>
                                                                </td>
                                                                <td>
                                                                    <input type=\"text\" name=\"responsable\">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                    <td >
                                                                            <label>ESTADO</label>
                                                                    </td>
                                                                    <td >
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
                                                                    <td >
                                                                            <input type=\"submit\" class=\"btn\">
                                                                    </td>
                                                                    <td >
                                                                    </td>
                                                            </tr>

                                            </table>
                                    </fieldset>
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
    public function modificar_proyecto($arrdatos){//crea proyectoss por proyecto para su edicion y vista
            //$id_pro,$nom_pro,$estad
            $flag = false;
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("UPDATE proyectos SET nombre_p=:nombre_p,estado=:estado,modificado = now(),responsable=:responsable where id_proyecto=:id_proyecto");
                    $stmt->bindParam(':nombre_p', $np);
                    $stmt->bindParam(':estado', $es);
                    $stmt->bindParam(':id_proyecto', $arrdatos[0]);
                    $stmt->bindParam(':responsable',$res);
                    $np = $arrdatos[1];
                    $es = $arrdatos[2];
                    $res = $arrdatos[3];

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
        //poner dos varibales una de inicio y otra offset
        //inicio empieza en 0 si la pagina es igual a 1, si es mayor se multiplica por 10 o la cantidad de datos que vaya a mostrar. se resta si es lo contrario.
        
            $form_arr = array();//devuelve un arreglo de proyectoss
            $form = "";
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("select id_proyecto,nombre_p from proyectos ");

                    if($stmt->execute()){
                        while ($row = $stmt->fetchObject()) {
                            $form = "<option value=\"{$row->id_proyecto}\">{$row->nombre_p}</option>";
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
    public function mostrar_todos_proyectos2(){
            $form_arr = array();//devuelve un arreglo de proyectoss
            $form = "";
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("select * from proyectos");

                    if($stmt->execute()){
                            while ($row = $stmt->fetchObject()) {
                                    $form = "<option value=\"{$row->nombre_p}\">{$row->nombre_p}</option>";
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
    public function listar_todos_proyectos(){//muestra un informe pequeño de todos los proyectos
            $form_arr = array();//devuelve un arreglo de proyectoss
            $form = "";
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("select * from proyectos order by fecha_creacionp desc LIMIT 10");

                    if($stmt->execute()){
                            while ($row = $stmt->fetchObject()) {
                                    $form = "<tr>
                                                <td>
                                                    {$row->nombre_p}
                                                </td>
                                                <td>{$row->cant_etapa}</td>
                                                <td>{$row->fecha_creacionp}</td>
                                                <td>{$row->estado}</td>
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
    public function todos_los_datos_en_un_proyecto($nom_pro){//muestra todos los datos que hay en un formulari
            $form_arr = array();//devuelve un arreglo de proyectoss
            $form = "";//carga datos en proyectoss diferentes
            $contenedor2=array();
            $con = new Conexion();
            $con2 = $con->conectar();
            $tarea = new Tareas();
            try{
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $con2->prepare("SELECT * from proyectos f inner join etapas e on f.id_proyecto = e.id_proyecto where nombre_p = :nombre_p");
                    $stmt->bindParam(':nombre_p', $np);
                    $np = $nom_pro;
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
           finally {
                $con2 = null;
                $stmt->close();
           }
            return $form_arr;
    }
    public function validar_doble_pro($nom_pro){
            $flag = false;
            $list = array();
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("SELECT * FROM proyectos where nombre_p = :nombre_p " );
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
    /*public function form_anular_proyecto($id_proyecto,$nombre_proyecto){
            $form ="";
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    $con2->setAttribute(PDO:ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $con2->prepare("select * from proyectos where id_proyecto = :id_proyecto and nombre_p = :nombre_p");
                    $stmt->bindParam(':id_proyecto',$id_proy);
                    $stmt->bindParam(':nombre_p',$nombre_proy);
                    $id_proy = $id_proyecto;
                    $nombre_proy = $nombre_proyecto;
                    if($stmt->execute()){
                            if($row = $stmt->fetchObject()){
                                    $form="
                                            <form action=\"\" mehtod=\"post\">
                                                    <table>
                                                            <tr>
                                                                    <td><label for=\"proyecto\"></label></td>
                                                                    <td><input type=\"text\" name=\"proyecto\" value=\"{$row->nombre_p}\"></td>
                                                            </tr>
                                                            <tr>
                                                                    <td><label for=\"proyecto\"></label></td>
                                                                    <td>
                                                                            <select name=\"status\" required>
                                                                            <option ></option>
                                                                                    <option value=\"En proceso\">En proceso</option>
                                                                                    <option value=\"Detenido\">Detenido</option>
                                                                                    <option value=\"Cancelado\">Cancelado</option>
                                                                                    <option value=\"Finalizado\">Finalizado</option>
                                                                            </select>
                                                                    </td>
                                                            </tr>
                                                    </table>
                                            </form>
                                    ";
                            }
                    }
            }
    }*/
    public function total_proyectos(){
            $total=0;
            $arr=array();
            $con = new Conexion();
            $con2 = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $con2->prepare("SELECT id_proyecto FROM proyectos;" );

                    if($stmt->execute()){
                            while($row = $stmt->fetchObject()){
                                    array_push($arr, $row->id_proyecto);
                            }
                            $total = sizeOf($arr);
                    }
            }
            catch(PDOException $e)
            {
                    echo "Error: " . $e->getMessage();
            }
            finally{
                $con2 = null;
            }
            return $total;
    }
    public function anhos(){
        $arr = array();

        $con = new Conexion();
        $con2 = $con->conectar();

        try{
            $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con2->prepare("SELECT distinct YEAR(fecha_creacionp) AS anho FROM proyectos;" );

                    if($stmt->execute()){
                            while($row = $stmt->fetchObject()){
                    $fecha = $row->anho;
                    $select = "<option value=\"$fecha\">$fecha</option>";
                    array_push($arr, $select);
                }
            }
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        finally{
            $con2 = null;
        }
        return $arr;

    }
}