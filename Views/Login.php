
<center>
        <form method="post"  class="form-inline">
                <fieldset>
                        <legend>Login de Usuarios</legend>
                        <label for="cedula" class="col-form-label">Cedula Usuario:</label><br>
                        <input name="cedula" type="text" required>
                        <br><br>

                        <label for="password" class="col-form-label">Password:</label><br>
                        <input name="password" type="password"required>
                        <br><br>

                        <input type="submit" value="Login">
                </fieldset>
        </form>
</center>
<?php
if(isset($_POST["cedula"])){
       $cedula = $_POST["cedula"];
        $password = $_POST["password"];

        if(Usuarios::verificar_sesion($cedula,$password)){
                header("Location: index.php?action=inicio");
                exit;
        }
}


?>