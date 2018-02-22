<!DOCTYPE html>
 <html>
 <head lang="es">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/angular.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

  } );
    $( function() {
    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });

  } );
</script>
<style type="text/css">
.carousel{
    /*background: #2f4357;*/
    background: lightgrey;
    margin-top: 20px;
}
.carousel .item{
    min-height: 280px; /* Prevent carousel from being distorted if for some reason image doesn't load */
}
.carousel .item img{
    margin: 0 auto; /* Align slide image horizontally center */
}
.bs-example{
	margin: 20px;
}
</style>
   <title>Informes Cuatrimestrales De Proyectos</title>
 </head>
 <body>
        <?php
          
        if(isset($_SESSION['nombre'])){
          include "NavBar.php";
        ?>
     <section>
         <center>
             <?php
                $mvc = new NavController();
               $mvc->enlancesPaginasController();
             }
             else{
              include "Login.php";
             }
             ?>
         </center>
         
     </section>
     
     
     
     
<div id="footer">
    <div class="container clear-top">
        <div class="row">
            <h3 class="footertext">Sobre Nosotros:</h3>
            <br>
              <div class="col-md-4">
                <center>
                  <img src="http://oi60.tinypic.com/w8lycl.jpg" class="img-circle" alt="the-brains">
                  <br>
                  <h4 class="footertext">Yalapps</h4>
                  <p class="footertext">Web De Seguimiento de Proyectos, desarrollado por <b>José Luis Domínguez Morán</b><br>
                </center>
              </div>
              <div class="col-md-4">
                <center>
                  <img src="http://oi60.tinypic.com/2z7enpc.jpg" class="img-circle" alt="...">
                  <br>
                  <h4 class="footertext">Artista</h4>
                  <p class="footertext">Yo mismo :P.<br>
                </center>
              </div>
              <div class="col-md-4">
                <center>
                  <img src="http://oi61.tinypic.com/307n6ux.jpg" class="img-circle" alt="...">
                  <br>
                  <h4 class="footertext">Designer</h4>
                  <p class="footertext">This pretty site and the copy it holds are all thanks to this guy.<br>
                </center>
              </div>
            </div>
            <div class="row">
            <p><center><a href="#">Contact Stuff Here</a> <p class="footertext">Copyright 2014</p></center></p>
        </div>
    </div>
</div>
 </body>
 </html>