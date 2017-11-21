<?php
if(!isset($_SESSION)){ session_start(); }

require_once($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/../database/config/globalFunctions.php");
require_once('classeAtividade.php');

$CodAtividade= $_GET['bbh_ati_codigo'];
$atividade = new atividade();
$atividade->setLinkConnection($bbhive);
$atividade->setDefaultDatabase($database_bbhive);
$atividade->execute($CodAtividade);

$cdModeloAtiv = $atividade->ModeloAtividade;
//--Verifico se esta atividade tem campos de detalhamento para preenchimento
	$query_descDet = "select bbh_cam_det_flu_codigo, bbh_mod_flu_codigo, bbh_flu_codigo 
					  from bbh_campo_detalhamento_atividade as mda
				 		inner join bbh_modelo_atividade as ma on mda.bbh_mod_ati_codigo = ma.bbh_mod_ati_codigo
						 inner join bbh_atividade as a on ma.bbh_mod_ati_codigo = a.bbh_mod_ati_codigo
				  			where mda.bbh_mod_ati_codigo = $cdModeloAtiv and a.bbh_ati_codigo = $CodAtividade";
    list($descDet, $row_descDet, $totalRows_descDet) = executeQuery($bbhive, $database_bbhive, $query_descDet);
//-- ?>	
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="22" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/setaII.gif" border="0" align="absmiddle" />&nbsp;<strong><?php echo $atividade->nome; ?></strong></td>
  </tr>
  <tr>
    <td width="291"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="legandaLabel">
        <td width="43%" height="15">Inicio previsto</td>
        <td width="57%">&nbsp; T&eacute;rmino previsto</td>
      </tr>
      <tr class="legandaLabel">
        <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendarioII.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->inicioPrevisto); ?></td>
        <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendario.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->finalPrevisto); ?></td>
      </tr>
    </table></td>
    <td width="279"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="legandaLabel">
        <td width="43%" height="15">&nbsp;Iniciado real</td>
        <td width="57%">&nbsp;T&eacute;rmino real</td>
      </tr>
      <tr class="legandaLabel">
        <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendarioII.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->inicioReal); ?></td>
        <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendario.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->finalReal); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <tr>
    <td height="22" colspan="2"></td>
  </tr>
  <tr>
    <td height="22" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle" />&nbsp;<strong>Descri&ccedil;&atilde;o da  atividade</strong></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="22" colspan="2"><?php echo nl2br($atividade->descricaoAtividade); ?></td>
  </tr>
<?php if($totalRows_descDet>0){?>
  <tr>
    <td height="15" colspan="2"></td>
  </tr>
  <tr>
    <td height="22" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/detalhe_tar.gif" width="16" height="16" align="absmiddle" />&nbsp;<strong>Campos de detalhamento desta atividade
      <input name="camposDetalhamento" type="hidden" id="camposDetalhamento" value="1" />
    </strong></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="22" colspan="2">
    <?php $camposExibicao = 0;

	 $cadastraDet			= "form1";
	 $bbh_mod_flu_codigo	= $row_descDet['bbh_mod_flu_codigo'];
	 $bbh_flu_codigo		= $row_descDet['bbh_flu_codigo'];
	 //--
	 
	 do {
		$camposExibicao.=",".  $row_descDet['bbh_cam_det_flu_codigo'];
	 } while($row_descDet = mysqli_fetch_assoc($descDet));

	 $readOnly = $_SESSION['atividadeAberta']==0 ? 'readonly="readonly"' : "";
	 //-
	 require_once(__DIR__ . "/../../../fluxo/detalhamento/edita_det_atividade.php");
	?>
    </td>
  </tr>
  <?php } ?>
</table>
