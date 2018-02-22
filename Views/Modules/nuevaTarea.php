<?php
$proyectos = Proyectos::mostrar_todos_proyectos();

if (!isset($_POST['idEtapa'])) {
        if(!isset($_POST['id'])){
            echo"<form method=\"post\">
                <label for=\"id\">Escoger Proyecto</label>
                <select name=\"id\">";
            foreach ($proyectos as $proy) {
                echo ($proy);
            }
            echo "";
            echo("<input type=\"submit\" value=\"enviar\">");
            echo "</form>";
        }
}

        
        if(isset($_POST['id'])){
            $id_pro=$_POST['id'];
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
        if (isset($_POST['idEtapa'])) {
            $id = $_POST['idEtapa'];
            echo "
                <form method=\"post\">
                    <fieldset>
                        <legend>Nueva Tarea</legend>
                        
                        <table border=\"0\" class=\"tablaPrincipal\">
                            <tr>
                                <td><laber for=\"idfaset\">id Fase</label></td>
                                <td><input type=\"text\" name=\"idfaset\" value=\"$id\" readonly=\"readonly\"></td>
                            </tr>
                            <tr>
                                <td >
                                    <label>Nombre de la Tarea</label>
                                </td>
                                <td >
                                    <input type=\"text\"  name=\"nombtarea\">
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <label>fecha inicial</label>
                                </td>
                                <td >
                                    <input type=\"date\" id=\"datepicker\" name=\"fechaI\">
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <label>fecha final</label>
                                </td>
                                <td >
                                    <input type=\"date\" id=\"datepicker2\"  name=\"fechaF\">
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                 <td ><label>estado</label></td>
                                 <td >
                                    <select name=\"estado\">
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
        }

if(isset($_POST['idfaset'])){
    $arrdatos = array($_POST['idfaset'],$_POST['nombtarea'],$_POST['fechaI'],$_POST['fechaF'],$_POST['estado']);
    if(Tareas::nueva_tarea($arrdatos)){
        echo "<div class=\"alert alert-success\" id=\"message\">
           <h1> <strong>Creacion Exitosa de $arrdatos[1]</strong></h1></div>";
    }else{
        $repetido="";
        if(!Tareas::validar_doble_tarea($ardatos[0],$ardatos[1])){
            echo "<br><br><br><br>
                        <div class=\"alert alert-warning\" id=\"message\">
                          <h1> <strong>Warning! Nombre de Tarea Repetida</strong> </h1>
                        </div>";
        }else{
            echo "<br><br><br><br>
                        <div class=\"alert alert-warning\" id=\"message\">
                          <h1> <strong>Warning! No se pudo Crear esta Tarea</strong> </h1>
                        </div>";
        }
        
    }
}