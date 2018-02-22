<br><br><br>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php?action=inicio" class="navbar-brand">Freya</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Proyectos <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a  href="index.php?action=nuevoProyecto">Crear Proyecto</a></li>
            <li><a href="index.php?action=eProyecto">Editar</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="index.php?action=reporteProyecto">Reporte Por Proyecto</a></li>
          </ul>
        </li>



        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Etapas <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?action=nuevaEtapa">Crear</a></li>
            <li><a href="index.php?action=eEtapas">Editar</a></li>
            <li role="separator" class="divider"></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tareas <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?action=nuevaTarea">Crear</a></li>
            <li><a href="index.php?action=eTareas">Editar</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="index.php?action=nuevaAsignacion">Asignar Tarea</a></li>
          </ul>
        </li>
        <li><a href="index.php?action=reporteExcel">Reporte Cuatrimestral</a></li>
    </ul>


      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default" value="Buscar">Buscar</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="Views/logout.php"><?php echo $_SESSION['nombre'].""; ?> Salir</a></li>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>