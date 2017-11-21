<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


$codUsu = -1;
if(isset($_GET['bbh_usu_codigo'])){
	$codUsu = $_GET['bbh_usu_codigo'];
}

	//select para descobrir o total de registros na base
	$query_TotMSGs = "SELECT count(bbh_usu_codigo) as TOTAL, bbh_usuario.bbh_usu_codigo FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_destin OR bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_remet WHERE bbh_usuario.bbh_usu_codigo = $codUsu GROUP BY bbh_usu_codigo";
    list($TotMSGs, $row_TotMSGs, $totalRows_TotMSGs) = executeQuery($bbhive, $database_bbhive, $query_TotMSGs);
	
	$page 		= "1";
	$nElements 	= "40";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= '/e-solution/servicos/bbhive/mensagens/usuarios/detalhes.php?Ts='.$_SERVER['REQUEST_TIME'];
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($row_TotMSGs['TOTAL']/$nElements);

$query_mensagens = "SELECT bbh_usuario.bbh_usu_nome, bbh_mensagens.bbh_men_data_recebida, bbh_men_codigo, bbh_usu_codigo_destin, bbh_usu_codigo_remet, bbh_men_assunto FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_destin OR bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_remet WHERE bbh_usu_codigo = $codUsu ORDER BY date_format(bbh_mensagens.bbh_men_data_recebida,'%Y') DESC,date_format(bbh_mensagens.bbh_men_data_recebida,'%m') DESC ,date_format(bbh_mensagens.bbh_men_data_recebida,'%d') DESC, date_format(bbh_mensagens.bbh_men_data_recebida, '%H') DESC, date_format(bbh_mensagens.bbh_men_data_recebida, '%i') DESC, date_format(bbh_mensagens.bbh_men_data_recebida, '%s') DESC";
list($mensagens, $row_mensagens, $totalRows_mensagens) = executeQuery($bbhive, $database_bbhive, $query_mensagens);

?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_MsgNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="75%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-mensagens-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_MsgNome']; ?></td>
    <td width="21%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|mensagens/usuarios/index.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
  
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr style="font-weight:bold; background-image:url(/e-solution/servicos/bbhive/images/barra_horizontal2.jpg)">
            <td height="27" colspan="4">&nbsp;<a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|mensagens/usuarios/index.php','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/equipe-operacional2.gif" alt="" width="12" height="12" border="0" align="absmiddle" /></a> Mensagens de <span class="color"><?php echo $row_mensagens['bbh_usu_nome']; ?></span></td>
          </tr>
    <?php if ($totalRows_mensagens > 0) { // Show if recordset not empty ?>
          <tr style="font-weight:bold;">
            <td width="31%" height="24" valign="bottom" style="border-bottom:1px solid #000000;">Destino</td>
            <td width="32%" valign="bottom" style="border-bottom:1px solid #000000;">Assunto</td>
            <td width="26%" valign="bottom" style="border-bottom:1px solid #000000;">Fluxo</td>
            <td width="11%" align="center" valign="bottom" style="border-bottom:1px solid #000000;">Data</td>
          </tr>
          <?php
		   do {
		  		  
		$codMens = $row_mensagens['bbh_men_codigo'];
		$voltarURL = $_SERVER['PHP_SELF'];


		$query_fluxo = "SELECT bbh_fluxo.bbh_flu_titulo FROM bbh_mensagens INNER JOIN bbh_fluxo ON bbh_fluxo.bbh_flu_codigo = bbh_mensagens.bbh_flu_codigo WHERE bbh_usu_codigo_destin = $codUsu OR bbh_usu_codigo_remet = $codUsu";
		list($fluxo, $row_fluxo, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $query_fluxo);

		$query_destin = "SELECT bbh_usuario.bbh_usu_nome, bbh_mensagens.* FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_destin WHERE bbh_men_codigo = $codMens";
		list($destin, $row_destin, $totalRows_destin) = executeQuery($bbhive, $database_bbhive, $query_destin);

		$query_remet = "SELECT bbh_usuario.bbh_usu_nome, bbh_mensagens.* FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_remet WHERE bbh_men_codigo = $codMens";
		list($remet, $row_remet, $totalRows_remet) = executeQuery($bbhive, $database_bbhive, $query_remet);
		
		  ?>
          <tr onClick="LoadSimultaneo('perfil/index.php?perfil=2|/mensagens/mensagem.php?bbh_men_codigo=<?php echo $codMens; ?>&back=<?php echo $voltarURL; ?>&cdg=<?php echo "bbh_usu_codigo=".$codUsu; ?>','menuEsquerda|conteudoGeral');" id="u<?php echo $codMens; ?>" onMouseOver="ativaCor('u<?php echo $codMens; ?>');" onMouseOut="desativaCor('u<?php echo $codMens; ?>');">
            <td style="border-bottom:1px dotted #666666;" height="22">
            <?php
			$nomeRemet  = $row_remet['bbh_usu_nome'];
			$nomeDestin = $row_destin['bbh_usu_nome'];
			if($row_mensagens['bbh_usu_codigo_destin']==$codUsu && $row_mensagens['bbh_usu_codigo_remet']==$codUsu){
				echo "<img src='/e-solution/servicos/bbhive/images/recebidaenviada.gif' align='absmiddle' /> Enviado para si pr&oacute;prio";
			}elseif($row_mensagens['bbh_usu_codigo_destin']==$codUsu){
			 echo "<img src='/e-solution/servicos/bbhive/images/recebidas.gif' align='absmiddle' /> de ".substr($nomeRemet,0,15)."...";
			}else{
			 echo "<img src='/e-solution/servicos/bbhive/images/enviadas.gif' align='absmiddle' /> para ".substr($nomeDestin,0,13)."...";
			}
			?>
            </td>
            <td class="verdana_10" style="border-bottom:1px dotted #999999;"><?php echo substr($row_mensagens['bbh_men_assunto'],0,28)."..."; ?></td>
            <td class="verdana_10" style="border-bottom:1px dotted #999999;"><?php echo empty($row_fluxo['bbh_flu_titulo']) ? '---' : $row_fluxo['bbh_flu_titulo']; ?></td>
            <td align="center" style="border-bottom:1px dotted #666666;"><?php echo arrumadata(substr($row_mensagens['bbh_men_data_recebida'],0,10)); ?></td>
          </tr>
            <?php } while ($row_mensagens = mysqli_fetch_assoc($mensagens)); ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
                    </table></td>
      </tr>
      <?php } else {// Show if recordset not empty ?>

<tr>
        <td class="color" colspan="2">N&atilde;o h&aacute; mensagens no momento.</td>
      </tr>
      <?php } ?>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<?php require_once('../../includes/paginacao/paginacao.php');?>
</form>
<?php
mysqli_free_result($mensagens);
?>