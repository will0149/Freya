<?php
    $proyectos = Proyectos::mostrar_todos_proyectos();
?>


        <?php
        if(!isset($_POST['id'])){
        	echo "<form method=\"post\">
                    <label for=\"id\">Escoger Proyecto</label>
                    <select name=\"id\">";
            foreach ($proyectos as $proy) {
                echo ($proy);
            }
            echo  "</select>
			   <input type=\"submit\" value=\"enviar\">
			</form>";
        }
        

        if (isset($_POST['id'])){
        	$id = $_POST['id'];
        	echo "
			<form method=\"post\" class=\"form\">
			    <fieldset>
			        <legend><b></b></legend>
			             <table border=\"0\" class=\"table-responsive\">
			                <tr>
			                    <td >
			                        <label>Id Proyecto</label>
			                    </td>

			                    <td>
			                    	<abbr title =\"No Modificar éste campo\">
			                        <input type=\"text\" 
			                        value=\"$id\"
			                        name=\"idproyect\" readonly=\"readonly\">
			                        </abbr title> 
			                    </td>

			                                                            <!--/tr>
			                                                            <tr-->
			                    <td>
			                        <label>Nombre Fase</label>
			                    </td>
			                    <td >
			                                                                    
			                        <input type=\"text\" id=\"txta\" name=\"nomf\" >
			                                                                            
			                    </td>
			                </tr>
			                <tr>
			                    <td >
			                        <label>fecha inicial</label>
			                    </td>
			                    <td >
			                        <input type=\"text\" id=\"datepicker\" onClick=\"calendario\" name=\"nfechaI\">
			                                                                            
			                    </td>
			                                                            <!--/tr>
			                                                            <tr-->
			                    <td >
			                        <label>fecha final</label>
			                    </td>
			                    <td >
			                        <input type=\"text\" id=\"datepicker2\" onClick=\"calendario\" name=\"nfechaF\">
			                                                                            
			                    </td>
			                </tr>
			                <tr>
			                    <td >
			                        <label>Componentes</label>
			                    </td>
			                    <td >
			                        <textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtacom\" maxlength=\"5000\"></textarea>
			                    </td>
			                                                            <!--/tr>
			                                                            <tr-->
			                    <td >
			                        <label>Actividades</label>
			                    </td>
			                    <td >
			                        <textarea id=\"txta\" cols=\"20\" rows=\"6\"  name=\"txtact\" maxlength=\"5000\"></textarea>
			                    </td>
			                </tr>
			                <tr>
			                    <td >
			                        <label>Resultados obtenido</label>
			                    </td>
			                    <td >
			                        <textarea id=\"txta\" cols=\"20\" rows=\"6\"  name=\"txtareso\" maxlength=\"5000\"></textarea>
			                    </td>
			                                                            <!--/tr>
			                                                            <tr-->
			                    <td ><label>OBSERVACION</label></td>
			                    <td >
			                        <textarea id=\"txta\" cols=\"20\" rows=\"6\"  name=\"txtaobs\" maxlength=\"5000\"></textarea>
			                    </td>
			                </tr>
			                <tr>
			                    <td ><label>AVANCE PLANEADO</label></td>
			                    <td >
			                        <input type=\"text\" id=\"txta\" name=\"avap\">
			                    </td>
			                                                            <!--/tr>
			                                                            <tr-->
			                    <td ><label>AVANCE REAL</label></td>
			                    <td >
			                        <input type=\"text\" id=\"txta\"  name=\"avar\">
			                    </td>
			                </tr>
			                <tr>
			                <td ><label>MEDIOS DE VERIFICACION</label></td>
			                <td >
			                   	<textarea id=\"txta\" cols=\"20\" rows=\"6\" name=\"txtamev\" maxlength=\"5000\"></textarea>
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
        }
   

   if(isset($_POST['idproyect'])){
            $id_pro=$_POST['idproyect'];
            $nom_f=$_POST['nomf'];
            $fechain=$_POST['nfechaI'];
            $fechafi=$_POST['nfechaF'];
            $compo=$_POST['txtacom'];
            $activ=$_POST['txtact'];
            $result_ob=$_POST['txtareso'];
            $av_pla=$_POST['avap'];
            $av_re=$_POST['avar'];
            $med_ver=$_POST['txtamev'];
            $observ=$_POST['txtaobs'];

            $ardatos = array($id_pro,$nom_f,$fechain,$fechafi,$compo,$activ,$result_ob,$av_pla,$av_re,$med_ver,$observ,$observ);


            if(!Etapas::validar_doble_etapa($ardatos[0],$ardatos[1])){
                if(Etapas::nueva_etapa($ardatos)){
                	echo "<div class=\"alert alert-success\" id=\"message\">
	        			<h1> <strong>Etapa Creada Exitosamente</strong></h1></div>";
                }
            }else{
            	echo "<div class=\"alert alert-warning\" id=\"message\">
			  		<h1> <strong>Warning! Ya existe una etapa con este nombre en el proyecto!!</strong> </h1>
					</div>";
            }
        }