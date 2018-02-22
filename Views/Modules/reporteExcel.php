<?php
     //require_once("sesion_in.php");
     //$exc = new Excel();
     //$excel = $exc->listar_excel_cuatrimestre2();

     $total = Proyectos::total_proyectos();
if(!isset($_POST['anhos'])&&!isset($_POST['cuatrimestre'])){
    $var = Proyectos::anhos();
    echo"<form method=\"post\">
            <select name=\"anhos\">";
            foreach ($var as $anhos) {
              echo "$anhos";
            }
        echo"
          </select>

          <select name=\"cuatrimestre\">
              <option value=\"1\">Primer Cuatrimestre</option>
              <option value=\"2\">Segundo Cuatrimestre</option>
              <option value=\"3\">Tercer Cuatrimestre</option>
          </select>
          <input type=\"submit\">
        </form>";
}


    if(isset($_POST['anhos'])&&isset($_POST['cuatrimestre'])){
        $cuatrimestre = $_POST['cuatrimestre'];
        $anho = $_POST['anhos'];
        $excel = Excel::listar_excel_cuatrimestre($cuatrimestre,$anho);
        if (sizeof($excel) > 0) {
            echo"<button id=\"descarga\">Descargar</button>";
            echo "<center>
            
            
                  <table class=\"table-responsive\" id=\"reporteCuatrimestre\"border=\"1\" style=\"font-size:10px; text-align:center;\">
                    <tr>
                          <td ><h4>a&ntildeo:</h4></td>
                          <td ><h4 id=\"an\" >$anho</h4></td>
                          <td ></td>
                          <td ><h4>Cuatrimestre</h4></td>
                          <td ><h4 id=\"cuat\" >$cuatrimestre</h4></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                          <td ></td>
                      </tr>
                      <thead class=\"blue-grey lighten-4\">
                      <tr>
                          <td ><b>NOMBRE PROYECTO</b></td>
                          <td ><b>FECHA DE CREACION DEL PROYECTO</b></td>
                          <td ><b>NOMBRE DE LA ETAPA</b></td>
                          <td  ><b>FECHA INICIAL DE LA ETAPA</b></td>
                          <td  ><b>FECHA FINAL DE LA ETAPA</b></td>
                          <td  ><b>COMPONENTES</b></td>
                          <td  ><b>ACTIVIDADES</b></td>
                          <td  ><b>RESULTADOS OBTENIDOS</b></td>
                          <td  ><b>avances planificados</b></td>
                          <td  ><b>avances reales</b></td>
                          <td  ><b>medio_verificacion</b></td>
                          <td  ><b>observacion</b></td>
                          <td  ><b>nombre DE LA tarea</b></td>
                          <td  ><b>FECHA INICIAL DE LA TAREA</b></td>
                          <td  ><b>FECHA FINAL DE LA TAREA</b></td>
                          <td  ><b>ESTADO DE LA TAREA</b></td>
                          <td  ><b>PARTICIPANTES</b></td>
                      </tr>
                      </thead>
                      <tbody>";
          foreach($excel as $es){
              echo("$es");
          }
            echo " </tbody></table>
                    <br><br>
                </center>";
        }
        else {
            echo "<h1>No Hay Resultados para éste periodo</h1>";
        }
        
    }
    ?>
   <script>
       
    var anho = $("#an").text();
    var cuatrimes = $("#cuat").text();
    function descargarExcel(){
        //Creamos un Elemento Temporal en forma de enlace
        var tmpElemento = document.createElement('a');
        // obtenemos la información desde el div que lo contiene en el html
        // Obtenemos la información de la tabla
        var data_type = 'data:application/vnd.ms-excel';
        var tabla_div = document.getElementById('reporteCuatrimestre');
        var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
        tmpElemento.href = data_type + ', ' + tabla_html;
        //Asignamos el nombre a nuestro EXCEL
        tmpElemento.download = anho+'_'+cuatrimes+'.xls';
        // Simulamos el click al elemento creado para descargarlo
        tmpElemento.click();
    }
       
       $( "#descarga" ).click(function() {
          descargarExcel();
        });
    
</script>