<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	
if(isset($_GET['bbh_usu_per_codigo'])){
	$deleteSQL = "DELETE FROM bbh_usuario_nomeacao WHERE bbh_usu_per_codigo = ".$_GET['bbh_usu_per_codigo'];
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	
	$homeDestino	= '/e-solution/servicos/bbhive/usuarios/colaboradores/adicionados.php?bbh_usu_codigo='.$_GET['bbh_usu_codigo'];
	echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."','adicionados','&1=1','Atualizando dados...','cadastraModelo','2','1');</var>";
	exit;
}	

	/*$query_Perfil = "select bbh_usu_codigo, bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['bbh_usu_codigo']."
		order by bbh_per_nome asc";*/
		
	$query_Perfil = "select bbh_usu_codigo, bbh_perfil.bbh_per_codigo, bbh_per_nome, bbh_usu_per_codigo from bbh_perfil
inner join bbh_usuario_nomeacao on bbh_perfil.bbh_per_codigo = bbh_usuario_nomeacao.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['bbh_usu_codigo']."
		order by bbh_per_nome asc";
    list($Perfil, $row_Perfil, $totalRows_Perfil) = executeQuery($bbhive, $database_bbhive, $query_Perfil);
	
	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/usuarios/colaboradores/adicionados.php?bbh_usu_codigo='.$_GET['bbh_usu_codigo']."&bbh_usu_per_codigo=xxx";
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','&1=1','Cadastrando dados...','cadastraModelo','2','1');";
?>
<table width="270" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
<?php if($totalRows_Perfil>0) { ?> 
  <?php do{ ?>
  <tr>
    <td width="240" height="22">&nbsp;<img src="/e-solution/servicos/bbhive/images/marcador.gif" />&nbsp;<?php echo $row_Perfil['bbh_per_nome']; ?></td>
    <td width="30" align="center"><a href="#@" onClick="return <?php echo str_replace('bbh_usu_per_codigo=xxx','bbh_usu_per_codigo='.$row_Perfil['bbh_usu_per_codigo'],$acao);?>"><img src="/e-solution/servicos/bbhive/images/var_alerta.gif" width="14" height="14" border="0" /></a></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/e-solution/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <?php } while ($row_Perfil = mysqli_fetch_assoc($Perfil)); ?>
<?php } else { ?>
  <tr>
    <td colspan="2" align="center">N&atilde;o h&aacute; registros dispon&iacute;veis</td>
  </tr>
<?php } ?>
</table>
<var style='display:none'>OpenAjaxPostCmd('/e-solution/servicos/bbhive/usuarios/colaboradores/nAdicionados.php?bbh_usu_codigo=<?php echo $_GET['bbh_usu_codigo']; ?>','nAdicionados','&1=1','Carregando dados...','cadastraModelo','2','1');</var>