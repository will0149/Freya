
<script type="text/javascript">
  $( "#message" ).show().fadeOut( 1000 );
      event.preventDefault();
    });
</script>
<?php
//guardar_cambios_fase
$et = new Etapas();
//

$id_f=$_POST['idfase'];
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

$ardatos = array($id_f,$nom_f,$fechain,$fechafi,$compo,$activ,$result_ob,$av_pla,$av_re,$med_ver,$observ,$observ);

if($et->modificar_etapa($ardatos)){
	echo "<div class=\"alert alert-success\" id=\"message\">
           <h1> <strong>Cambios Exitosos en: $nom_f!</strong></h1></div>";
}
else{
	echo "<div class=\"alert alert-warning\" id=\"message\">
  <h1> <strong>Warning! No se hizo el cambio en: $nom_f</strong> </h1>
</div>";
}
?>
<script type="text/javascript">
	window.setTimeout(function(){
        window.location.href = "index.php?action=eEtapas";

    }, 2000);
</script>
