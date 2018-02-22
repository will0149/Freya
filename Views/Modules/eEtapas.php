<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

        <?php
            $et = new Etapas();
            $proyectos = Proyectos::mostrar_todos_proyectos();
       
        if(!isset($_POST['id'])){
            echo "<form method=\"post\">
                    <label for=\"id\">Escoger Proyecto</label>
                    <select name=\"id\">";
            foreach ($proyectos as $proy) {
                echo ($proy);
            }
            echo "  </select>
                    <input type=\"submit\" value=\"enviar\">
                </form>";
        }
        ?>
    
<h2 id="loadmessage"></h2>
            <?php
            if(isset($_POST['id'])){
                $idProyecto = filter_input(INPUT_POST,'id');

                try{
                    //ésta instancia cumple una funcion ciclíca dentro de (gen_proy,form_por_etapa2)
                    $form_fase = $et->form_por_etapa($idProyecto);
                    if(sizeOf($form_fase) >= 0){
                        foreach($form_fase as $ff){
                            echo($ff);
                        }
                    }
                }
                catch(PDOException $e)
                {
                    echo "Error: " . $e->getMessage();
                }
            }
            elseif(isset($_GET['id'])){
                $idProyecto = filter_input(INPUT_GET,'id');

                try{
                    //ésta instancia cumple una funcion ciclíca dentro de (gen_proy,form_por_etapa2)
                    $form_fase = $et->form_por_etapa($idProyecto);
                    if(sizeOf($form_fase) >= 0){
                        foreach($form_fase as $ff){
                            echo($ff);
                        }
                    }
                }
                catch(PDOException $e)
                {
                    echo "Error: " . $e->getMessage();
                }
            }
        ?>


        <script> 
        var id = $('input[name="idfase"]').val();
        var nombre = $('input[name="nomf"]').val();
        var fechai= $('input[name="nomf"]').val();
        var fechafi= $('input[name="nomf"]').val();
        var comp= $('input[name="nomf"]').val();
        var activ= $('input[name="nomf"]').val();
        var result= $('input[name="nomf"]').val();
        var avp= $('input[name="nomf"]').val();
        var avr= $('input[name="nomf"]').val();
        var medv= $('input[name="nomf"]').val();
        var obser= $('input[name="nomf"]').val();

        //document.write(id+""+nombre+""+fechai);

        //$(".form").click(function(){
        /*$( ".form" ).submit(function( event ) {
            $( "#message" ).text("Exitoso").show().fadeOut( 1000 );
          event.preventDefault();
        });
            $.post( "test.php", { 
                id_fase: id,
                nombre_fase: nombre,
                fecha_inicial: fechai,
                fecha_final: fechafi,
                componentes: comp,
                actividades: activ,
                resultados_obt: result,
                avance_plan: avp,
                avance_real: avr,
                medios_ver: medv,
                observaciones:  obser
            });

        });*/

        $(function() {
            $('#datetimepicker1').datetimepicker({
              language: 'es-PA'
            });
          });
         </script>