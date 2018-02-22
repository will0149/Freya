<?php
include_once("conexion/conexion.php");
class Usuario{
    private $conn;
    public function __construct(){
            $c = new Conexion();
            $this->conn = $c->conectar();
    }
            public function sesion($cedula,$pass){
                    $alterno="";
                    $flag = false;
                    $con = new Conexion();
                    $con3 = $con->conectar();
                    try{
                            $con3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt2 = $con3->prepare("select * from usuarios where cedula = :cedula and password = :password");
                            $stmt2->bindParam(':cedula', $ced);
                            $stmt2->bindParam(':password', $password);
                            $ced = $cedula;
                            $password = $pass;
                            if($stmt2->execute()){
                                    if ($row2 = $stmt2->fetchObject()) {
                                            session_start();
                                            $_SESSION['loggedin'] = true;
                                            $_SESSION['nombre'] = "{$row2->nombre}";
                                            $_SESSION['cedula'] = $cedula;
                                            $_SESSION['cargo'] ="{$row2->cargo}";
                                            $_SESSION['unidad'] ="{$row2->unidad}";
                                            $_SESSION['sede'] ="{$row2->sede}";
                                            $_SESSION['start'] = time();
                                            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
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

    public function listar_usuarios(){
            $form_arr = array();//devuelve un arreglo de formularios
            $form = "<option value=\"\">no hay datos</option>";
            $con = new Conexion();
            $conn = $con->conectar();
            try{
                    // se establece el modo de error PDO a Exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Se prepara el satetement y se cargan los parametros
                    $stmt = $conn->prepare("select * from usuarios");
                    if($stmt->execute()){
                            while ($row = $stmt->fetchObject()) {
                                    $form = "<option value=\"{$row->cedula}\">{$row->nombre}</option>";
    ;				array_push($form_arr,$form);
                    }

                    }
            }
            catch(PDOException $e)
                    {
                    echo "Error: " . $e->getMessage();
                    }
            $conn = null;
            return $form_arr;
    }
    public function listar_us_asignaciones($id_tarea){//genera un arreglo que posteriormente se transforma a una cadena
            $contenedor="";
            $asignaciones = array();
            $con = new Conexion();
            $con3 = $con->conectar();
            try{
                    $con3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt2 = $con3->prepare("select * from asignaciones a inner join usuarios us on a.cedula = us.cedula WHERE id_tarea =:id_tarea");
                    $stmt2->bindParam(':id_tarea', $id_t);
                    $id_t = $id_tarea;
                    if($stmt2->execute()){
                            while ($row2 = $stmt2->fetchObject()) {
                                    $contenedor="{$row2->cedula}  <b>{$row2->nombre}</b> {$row2->cargo} {$row2->unidad} {$row2->sede}<br><br>";
                                    array_push($asignaciones,$contenedor);
                            }
                    }
            }
            catch(PDOException $e)
                    {
                    echo "Error: " . $e->getMessage();
                    }
            $con2 = null;
            return $asignaciones;
    }
}
?>