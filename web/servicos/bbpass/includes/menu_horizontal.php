<?php  if(!isset($_SESSION)){session_start();}
require_once($_SESSION['caminhoFisico']."/servicos/bbpass/perfil/foto.php");

require_once($_SESSION['caminhoFisico']."/servicos/bbpass/credencial/index.php");

if(isset($_GET['atualiza'])){
	//echo "<var style='display:none'>limpaCarregando()</var>";	
}