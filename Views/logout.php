<h1>Adiós</h1>
<?php
session_start();
session_destroy();

?>
<script type="text/javascript">
	window.setTimeout(function(){
        window.location.href = "../index.php";

    }, 1000);
</script>
