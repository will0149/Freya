<?php
            $proyectos = Proyectos::mostrar_todos_proyectos();
        
if (!isset($_POST['id'])) {
    echo "<form method=\"post\">
            <label for=\"id\">Escoger Proyecto</label>
            <select name=\"id\">";
    
    foreach ($proyectos as $proy) {
        echo ($proy);
    }
    echo "
            </select>

            <input type=\"submit\" value=\"enviar\">
        </form>";
}

if(isset($_POST['id'])){
    $id_pro = $_POST['id'];
    $formProyecto = Proyectos::form_por_proyecto($id_pro);
    echo "$formProyecto";
}

if (isset($_POST['id_pro'])) {
    $id=$_POST['id_pro'];
    $nombre=$_POST['nom_pro'];
    $responsable=$_POST['responsable'];
    $estado =$_POST['status'];
    $arrdatos=array($id,$nombre,$estado,$responsable);

    if (Proyectos::modificar_proyecto($arrdatos)) {
        echo "<div class=\"alert alert-success\" id=\"message\">
                <h1> <strong>Cambios Exitosos en: $nombre!</strong></h1></div>";
    }
    else{
        echo "<div class=\"alert alert-warning\" id=\"message\">
              <h1> <strong>Warning! No se hizo el cambio en: $nombre</strong> </h1>
                </div>";
    }
}