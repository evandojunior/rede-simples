<?php
$caminho = "/corporativo/servicos/bbhive/tarefas/acao/includes/classeAtividade.php";
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico'].$caminho);

$CodAtividade	= $_GET['bbh_ati_codigo'];
$bbh_ati_codigo = $CodAtividade;

$atividade = new atividade();
$atividade->setLinkConnection($bbhive);
$atividade->setDefaultDatabase($database_bbhive);
$atividade->execute($CodAtividade);

$dirFluxo = "/corporativo/servicos/bbhive/fluxo/cabecalhoModeloFluxo.php";
?><table width="98%" border="0" align="center" cellpadding="0"  cellspacing="0" class="verdana_11">
<tr>
  <td height="26"><?php require_once($_SESSION['caminhoFisico'].$dirFluxo); ?></td>
</tr>
<tr>
			<td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" style="cursor:pointer" onClick="javascript: if(document.getElementById('corpoAtividade').className=='show') { document.getElementById('corpoAtividade').className='hide';document.getElementById('setaBaixo').innerHTML='';var img = document.createElement('img'); img.src='/corporativo/servicos/bbhive/images/seta_baixo.gif'; document.getElementById('setaBaixo').appendChild(img); document.getElementById('msgComum').innerHTML='[ Clique para mais detalhes ]';} else { document.getElementById('corpoAtividade').className='show';document.getElementById('setaBaixo').innerHTML='';var img = document.createElement('img'); img.src='/corporativo/servicos/bbhive/images/seta_topo.gif'; document.getElementById('setaBaixo').appendChild(img); document.getElementById('msgComum').innerHTML='[ Clique para menos detalhes ]';} ">
			  <div style="position:absolute;margin-top:5px;" id="setaBaixo"><img src="/corporativo/servicos/bbhive/images/seta_baixo.gif" width="8" height="4" align="absmiddle" /></div><strong>&nbsp;&nbsp;&nbsp;&nbsp;Atividade</strong>
              <label id="msgComum" style="float:right; margin-top:-13px;" class="color">
              	[ Clique para mais detalhes ] 
              </label>
              </td>
  </tr>
		</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="22" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer" class="verdana_11">&nbsp;<img src="/corporativo/servicos/bbhive/images/setaII.gif" border="0" align="absmiddle" />&nbsp;<strong><?php echo $atividade->nome; ?></strong></td>
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
    <td height="15" colspan="2"></td>
  </tr>

</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="corpoAtividade" class="hide">
  <tr>
    <td height="22" class="verdana_11">&nbsp;<img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle" />&nbsp;<strong>Descri&ccedil;&atilde;o da  atividade</strong></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td height="22" class="verdana_11"><?php echo nl2br($atividade->descricaoAtividade); ?></td>
  </tr>
  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table>
<input type="hidden" name="bbh_ati_codigo" id="bbh_ati_codigo" value="<?php echo $_GET['bbh_ati_codigo'];?>" />
<br>
