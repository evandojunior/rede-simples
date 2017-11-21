<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


if(isset($_GET['bbh_per_codigo'])){
	$insertSQL = "INSERT INTO bbh_usuario_nomeacao (bbh_usu_codigo, bbh_per_codigo) VALUES (".$_GET['bbh_usu_codigo'].", ".$_GET['bbh_per_codigo'].")";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

	$homeDestino	= '/e-solution/servicos/bbhive/usuarios/colaboradores/adicionados.php?bbh_usu_codigo='.$_GET['bbh_usu_codigo'];
	echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."','adicionados','&1=1','Atualizando dados...','cadastraModelo','2','1');</var>";
	exit;
}


	/*$query_Perfil = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['bbh_usu_codigo']."
		order by bbh_per_nome asc";*/
	$query_Perfil = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_nomeacao on bbh_perfil.bbh_per_codigo = bbh_usuario_nomeacao.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['bbh_usu_codigo']."
		order by bbh_per_nome asc";
    list($Perfil, $row_Perfil, $totalRows_Perfil) = executeQuery($bbhive, $database_bbhive, $query_Perfil);

	$perfil=0;
	 if($totalRows_Perfil>0) {
		do{
			$perfil.= ", ".$row_Perfil['bbh_per_codigo'];
		}while($row_Perfil = mysqli_fetch_assoc($Perfil));
	 }

	/*$query_Nomeia = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_nomeacao on bbh_perfil.bbh_per_codigo = bbh_usuario_nomeacao.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['bbh_usu_codigo']." and bbh_perfil.bbh_per_codigo not in($perfil)
		order by bbh_per_nome asc";*/
	$query_Nomeia = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['bbh_usu_codigo']." and bbh_perfil.bbh_per_codigo not in($perfil)
		order by bbh_per_nome asc";
    list($Nomeia, $row_Nomeia, $totalRows_Nomeia) = executeQuery($bbhive, $database_bbhive, $query_Nomeia);

	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/usuarios/colaboradores/nAdicionados.php?bbh_usu_codigo='.$_GET['bbh_usu_codigo']."&bbh_per_codigo=xxx";

	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','&1=1','Cadastrando dados...','cadastraModelo','2','1');";
?>
<table width="270" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
<?php if($totalRows_Nomeia>0) { ?> 
  <?php do{ ?>
  <tr>
    <td width="240" height="22">&nbsp;<img src="/e-solution/servicos/bbhive/images/marcador.gif" />&nbsp;<?php echo $row_Nomeia['bbh_per_nome']; ?></td>
    <td width="30" align="center"><a href="#@" onClick="return <?php echo str_replace('bbh_per_codigo=xxx','bbh_per_codigo='.$row_Nomeia['bbh_per_codigo'],$acao);?>"><img src="/e-solution/servicos/bbhive/images/var[ok].gif" width="14" height="14" border="0" /></a></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/e-solution/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <?php } while ($row_Nomeia = mysqli_fetch_assoc($Nomeia)); ?>
<?php } else { ?>
  <tr>
    <td colspan="2" align="center">N&atilde;o h&aacute; registros dispon&iacute;veis</td>
  </tr>
<?php } ?>
</table>