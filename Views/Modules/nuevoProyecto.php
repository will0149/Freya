<center>
    <form method="POST">
        <fieldset>
            <legend>Crear Proyecto</legend>
            <table border="0" class="tablaPrincipal">
                <tr>
                    <td >
                        <label for="nProyecto">Nombre Del Proyecto</label>
                    </td>
                    <td >
                        <input type="text" name="nProyecto" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="responsable">Responsable Del Proyecto</label>
                    </td>
                    <td>
                        <input type="text" name="responsable">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="nEtapasProyecto">Cantidad De Etapas</label>
                    </td>
                    <td >
                        <select name="nEtapasProyecto" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td >
                        <label for="nStatusProyecto">Estado Inicial</label>
                    </td>
                    <td >
                        <select name="nStatusProyecto" required>
                        <option ></option>
                        <option value="Iniciado">Iniciado</option>
                        <!--option value="Detenido">Detenido</option>
                        <option value="Cancelado">Cancelado</option>
                        <option value="Finalizado">Finalizado</option-->
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td >
                        <input type="submit" value="Crear" name="registroProyecto">
                    </td>
                    <td >
                    </td>
                </tr>

            </table>
        </fieldset>
    </form>
</center>

<?php
$mvc = new NavController();
$mvc->nuevoproyecto();

if(isset($_GET['action'])){

    if($_GET['action'] == "oknProyecto"){

        //echo "<a href=\"index.php?action=verEtapas&id="+$_GET['nProyecto']+"\"> </a>";
        echo "<div class=\"alert alert-success\">
            <strong>Success!</strong></div>";
    }
    
}
