<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


if(isset($_GET['add'])){
	if($_GET['add']=="1"){
		$usuario   =  $_GET['usuario'];
		$perfil    =  $_GET['perfil'];
		
		$insertSQL = "INSERT INTO bbh_usuario_perfil (bbh_usu_codigo, bbh_per_codigo) VALUES ($usuario, $perfil)";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	    echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|usuarios/perfil/index.php?bbh_usu_codigo=".$_GET['usuario']."','menuEsquerda|conteudoGeral')</var>";
		
	}
}

if(isset($_GET['del'])){
	if($_GET['del']=="1"){
	  $usuario   =  $_GET['usuario'];
	  $perfil    =  $_GET['perfil'];
	
	  $deleteSQL = "DELETE FROM bbh_usuario_perfil WHERE bbh_usu_codigo = $usuario AND bbh_per_codigo = $perfil";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|usuarios/perfil/index.php?bbh_usu_codigo=".$_GET['usuario']."','menuEsquerda|conteudoGeral')</var>";
	}
}

if(!isset($usuario)){
	$usuario = -1;
	if(isset($_GET['usuario'])){
		$usuario = $_GET['usuario'];
	}
}

$query_perfis = "$row_perfis bbh_per_nome, bbh_usuario_perfil.bbh_per_codigo, bbh_usu_codigo FROM bbh_usuario_perfil INNER JOIN bbh_perfil ON bbh_usuario_perfil.bbh_per_codigo = bbh_perfil.bbh_per_codigo WHERE bbh_usu_codigo = $usuario";
list($perfis, $row_perfis, $totalRows_perfis) = executeQuery($bbhive, $database_bbhive, $query_perfis);

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <?php if($totalRows_perfis>0){ ?>
  <?php do { 
  		 $codigoperfil = $row_perfis['bbh_per_codigo'];
  ?>
  <tr onClick="return RemovePerfil(<?php echo $row_perfis['bbh_per_codigo']; ?>);" id="l<?php echo $codigoperfil; ?>" onmouseover="ativaCor('l<?php echo $codigoperfil; ?>');" onmouseout="desativaCor('l<?php echo $codigoperfil; ?>');">
    <td width="315" height="25">&nbsp;<img src="/e-solution/servicos/bbhive/images/ger-perfis-16px.gif" align="absmiddle" >&nbsp;<?php echo $row_perfis['bbh_per_nome']; ?></td>
    <td width="25"><img src="/e-solution/servicos/bbhive/images/excluir.gif" width="16" height="14" border="0" ></td>
  </tr>
  <?php } while ($row_perfis = mysqli_fetch_assoc($perfis)); ?>
  <?php } else { ?>
  <tr>
    <td colspan="2" class="verdana_11">N&atilde;o existem perfis atribu&iacute;dos</td>
  </tr>
  <?php } ?>
</table>