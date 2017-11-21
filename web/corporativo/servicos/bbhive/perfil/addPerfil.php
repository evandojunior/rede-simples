<?php
	if(!isset($_SESSION)){session_start();}
if(getCurrentPage()!="/corporativo/servicos/bbhive/perfil/detalhes.php"){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
}

	$query_Perfil = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['usuario']."
		order by bbh_per_nome asc";
    list($Perfil, $row_Perfil, $totalRows_Perfil) = executeQuery($bbhive, $database_bbhive, $query_Perfil);
	
	$perfil=0;
	 if($totalRows_Perfil>0) {
		do{
			$perfil.= ", ".$row_Perfil['bbh_per_codigo'];
		}while($row_Perfil = mysqli_fetch_assoc($Perfil));
	 }

	$query_Nomeia = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_nomeacao on bbh_perfil.bbh_per_codigo = bbh_usuario_nomeacao.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_perfil.bbh_per_codigo not in($perfil)
		order by bbh_per_nome asc";
    list($Nomeia, $row_Nomeia, $totalRows_Nomeia) = executeQuery($bbhive, $database_bbhive, $query_Nomeia);

?>
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="26" colspan="2" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Adicionar perfil</strong></td>
  </tr>
<?php if($totalRows_Nomeia>0) { ?>
	 <?php  do { ?>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td width="172" align="left"><a href="#" onClick="return gerencia('/corporativo/servicos/bbhive/perfil/executa.php?bbh_usu_codigo=<?php echo $_GET['usuario']; ?>&bbh_per_codigo=<?php echo $row_Nomeia['bbh_per_codigo']; ?>','add');">&nbsp;<img src="/corporativo/servicos/bbhive/images/perfil.gif" width="14" height="14" align="absmiddle" border="0" />&nbsp;<?php echo $row_Nomeia['bbh_per_nome']; ?></a></td>
    <td width="28" align="center"><img src="/corporativo/servicos/bbhive/images/visto.gif" width="14" height="11"></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
     <?php }while($row_Nomeia = mysqli_fetch_assoc($Nomeia)); ?>
<?php } else { ?> 
  <tr>
    <td colspan="2" height="19" align="center">
            <span class="verdana_9 color">N&atilde;o h&aacute; registros a serem adicionado</a></span></td>
  </tr>
<?php } ?>
</table>