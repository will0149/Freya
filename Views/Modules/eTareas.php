<?php
            $et = new Etapas();
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
            $idEtapa = $_POST['idEtapa'];
            $tareas= Tareas::listar_tareas_proyecto($idEtapa);
            $size = sizeOf($tareas) - 2;
            if($size > 0){
                foreach ($tareas as $tar) {
                     echo "$tar";
                 }
            }else{
                echo "<br><br><br><br>
                        <div class=\"alert alert-warning\" id=\"message\">
                          <h1> <strong>Warning! No hay Tareas En ésta etapa</strong> </h1>
                        </div>";
            }
        }