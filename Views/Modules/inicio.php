<?php

$proyectosLista = Proyectos::listar_todos_proyectos();
$proyectos = Proyectos::listar_todos_proyectos();
$totalProyectos = Proyectos::total_proyectos();
?>

<div class="bs-example">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>   
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="img/LOGO_CDTIC.png" alt="Ciditic" width="460" height="445">
            </div>
            <div class="item">
                <img src="img/logo_utp_1_72.png" alt="Chania" width="200" height="200">
            </div>
            <div class="item">
                <img src="img/logo_utp_2_72.png" alt="Flower" width="200" height="200">
            </div>
            <div class="item">
                <img src="img/yalapps.png" alt="Yalapps" width="200" height="200">
            </div>
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
<div class="container-fluid text-left">
<table class="table">
  <tr>
    <td>
      <div class="col-sm-3 col-md-6">
        <p>
          <?php
              foreach ($proyectosLista as $key) {
                  echo $key;
                  echo "<br>";
              }
          ?>
          </p>
      </div>
    </td>
    <td>
        <tr>
          <td>Nombre De Proyectos</td>
          <td>Cantidad De Etapas</td>
          <td>Fecha de Creacion</td>
          <td>Estado</td>
        </tr>
        <tr>
          <?php
          foreach ($proyectos as $proy) {
            echo "$proy";
          }
          ?>
        </tr>
    </td>
  </tr>
    
</table>
  
      <article>
        <p>
        fisjfjdsfjdsfdsfdshglhskghjsdhlkfdsfñhsafñkjhsafjhdsf<b>dfkdshfsdh</b>
        </p>
      </article> 
</div>


