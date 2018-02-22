<?php
$proyectos = Proyectos::mostrar_todos_proyectos();

        if(!isset($_POST['id'])){
            echo "<br><br>  
                <form method=\"post\">
                    <label for=\"id\">Escoger Proyecto</label>
                    <select name=\"id\">";
            foreach ($proyectos as $proy) {
                echo ($proy);
            }
            
            echo "</select>
                    <input type=\"submit\" value=\"enviar\">
                </form>";
        }
        

        if(isset($_POST['id'])){
        	$id = $_POST['id'];
        	$excel = Excel::listar_excel($id);
            echo "<br><br><center>
            <button id=\"descarga\">Descargar</button>
                    <table class=\"table-striped\" border=\"1\" id=\"reporteProyecto\">
                        <tr>
                            <td class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">NOMBRE PROYECTO</td>
                            <td class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">FECHA DE CREACION DEL PROYECTO</td>
                            <td class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">NOMBRE DE LA ETAPA</td>
                            <td class=\"col-md-2\" style=\"background-color:darkgreen; color:white;\">FECHA INICIAL DE LA ETAPA</td>
                            <td  class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">FECHA FINAL DE LA ETAPA</td>
                            <td  class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">COMPONENTES</td>
                            <td class=\"col-md-2\" style=\"background-color:darkgreen; color:white;\">ACTIVIDADES</td>
                            <td class=\"col-md-2\" style=\"background-color:darkgreen; color:white;\">RESULTADOS OBTENIDOS</td>
                            <td class=\"col-md-2\" style=\"background-color:darkgreen; color:white;\">avances planificados</td>
                            <td  class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">avances reales</td>
                            <td  class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">medio_verificacion</td>
                            <td  class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">observacion</td>
                            <td class=\"col-md-2\" style=\"background-color:darkgreen; color:white;\">nombre DE LA tarea</td>
                            <td class=\"col-md-2\" style=\"background-color:darkgreen; color:white;\">FECHA INICIAL DE LA TAREA</td>
                            <td  class=\"col-md-2\"style=\"background-color:darkgreen; color:white;\">FECHA FINAL DE LA TAREA</td>
                            <td  style=\"background-color:darkgreen; color:white;\">ESTADO DE LA TAREA</td>
                            <td  style=\"background-color:darkgreen; color:white;\">PARTICIPANTES</td>
                        </tr>";
		    foreach($excel as $es){
		        echo("$es");
	    	}
            echo"</table>
                <br><br>
            </center>";
        }
	     
	?> 
    
<script>
function descargarExcel(){
        //Creamos un Elemento Temporal en forma de enlace
        var tmpElemento = document.createElement('a');
        // obtenemos la información desde el div que lo contiene en el html
        // Obtenemos la información de la tabla
        var data_type = 'data:application/vnd.ms-excel';
        var tabla_div = document.getElementById('reporteProyecto');
        var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
        tmpElemento.href = data_type + ', ' + tabla_html;
        //Asignamos el nombre a nuestro EXCEL
        tmpElemento.download = 'Nombre_De_Mi_Excel.xls';
        // Simulamos el click al elemento creado para descargarlo
        tmpElemento.click();
    }
       
       $( "#descarga" ).click(function() {
          descargarExcel();
        });
</script>