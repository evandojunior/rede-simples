<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/function.php");
require_once("gerencia_perfil.php");

	$usuario = new perfil();//instância classe
	$usuario->dadosPerfil($database_bbpass, $bbpass);//chama método responsável pela atribuição das variáveis
?>
<table width="770" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center">
  <tr>
    <td width="560" height="22" class="verdana_11">&nbsp;</td>
    <td width="210" class="verdana_11" style="color:#999">&Uacute;ltimo acesso: <?php echo $usuario->lastAcesso; ?></td>
  </tr>
</table>
