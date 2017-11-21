<?php
 require_once("../includes/autenticacao/index.php");
 require_once("gerencia_perfil.php");
 
 $usuario = new perfil();//instância classe
 echo '<var>document.getElementById("foto").src="'.$usuario->verificaImagem($database_bbpass, $bbpass).'"</var>';
?>