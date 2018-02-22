<?php
$proyectos = Proyectos::mostrar_todos_proyectos();

if(!isset($_POST['id_p'])){
    if(isset($_POST['idEtapa']) || isset($_POST['idTarea']) || isset($_POST['usuario'])){
        
    }else{
        echo "<form method=\"post\">
                        <table >
                            <tr>
                                <td >
                                    <label>Seleccione un Proyecto</label>
                                </td>
                                <td >
                                    <select name=\"id_p\">
                                        <option ></option>";
        foreach($proyectos as $proy){											
            echo ($proy);
        }
        echo "
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        <input type=\"submit\" class=\"btn\">
                                    </td>
                                    <td >
                                        <input type=\"reset\" class=\"btn\">
                                    </td>
                                </tr>
                        </table>

                    </form>";
    }
    

}


if(isset($_POST['id_p'])){
    $id_pro = $_POST['id_p'];
    $etapas = Etapas::listar_etapas_proyecto($id_pro);
    echo"<form method=\"post\">";
    echo "<label for\"idEtapa\">Seleccione Etapa</label>";
    echo "<select name=\"idEtapa\">";
    foreach ($etapas as $etp) {
            echo "$etp";
    }
    echo "</select>";
    echo("<input type=\"submit\" value=\"enviar\">
            </form>");
}
if(isset($_POST['idEtapa'])){
    $id_f = $_POST['idEtapa'];
    $usuarios = Usuario::listar_usuarios();
    $tareas = Tareas::listar_tareas($id_f);
    if(sizeof($tareas)>0){
        echo "
                <form method=\"post\" id=\"form_p\">
                                    <fieldset>
                                        <legend>Asignar Tareas</legend>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>Id fase</label>
                                                </td>

                                                <td >
                                                    <abbr title =\"No Modificar éste campo\">
                                                    <input type=\"text\" value=\"";
            echo("$id_f");

            echo"\" name=\"id_fas\" readonly=\"readonly\">
                                                    </abbr> 
                                                </td>

                                            </tr>
                                            <tr>
                                                 <td ><label>Tarea</label></td>
                                                 <td >
                                                    <select name=\"idTarea\">
                                                        <option ></option>
                                                        ";
                                                            foreach($tareas as $t){
                                                                echo($t);
                                                            }
            echo "
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                 <td ><label>Usuario a asignar</label></td>
                                                 <td >
                                                    <select name=\"usuario\">
                                                        <option ></option>
                                                        ";
                                                            foreach($usuarios as $proy){
                                                                echo ($proy);
                                                            }

            echo "
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    <input type=\"submit\" >
                                                </td>
                                                <td >
                                                    <input type=\"reset\" >
                                                </td>
                                            </tr>
                                            <tr>
                                    </table>
                                </fieldset>
                            </form>";
    }
    
}

if(isset($_POST['idTarea']) && isset($_POST['usuario'])){
    $id_tarea= $_POST['idTarea'];
    $cedula = $_POST['usuario'];
    $ardatos=array($id_tarea,$cedula);
    if(Asignaciones::nueva_asignacion($ardatos)){
       echo "<div class=\"alert alert-success\" id=\"message\">
	        			<h1> <strong>Tarea Asignada Correctamente</strong></h1></div>";
    }
    else{
        echo "<div class=\"alert alert-warning\" id=\"message\">
			 <h1> <strong>Warning! No se pudo crear la tarea!!</strong> </h1>
             </div>";
    }
}