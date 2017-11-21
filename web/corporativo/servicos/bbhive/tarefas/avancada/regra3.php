<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	$query_Fluxos = "select 
		bbh_modelo_fluxo.*, bbh_per_nome, bbh_usu_codigo, bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_tipo_fluxo.bbh_tip_flu_codigo
		
		from bbh_modelo_fluxo
		#Tipo de fluxo
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		
		#Modelo Fluxo com permissão fluxo
		inner join bbh_permissao_fluxo on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_permissao_fluxo.bbh_mod_flu_codigo
		
		#Permissão Fluxo com perfil
		inner join bbh_perfil on bbh_permissao_fluxo.bbh_per_codigo = bbh_perfil.bbh_per_codigo
		
		#Perfil com Usuário Perfil
		inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
		
		Where bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_modelo_fluxo.bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo']."
		
		order by bbh_mod_flu_nome asc";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/tarefas/avancada/detalhamento/executa.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'resultBusca';
	$infoGet_Post	= 'formLivro';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Consultando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$exporta = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td colspan="2" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong>Console de busca avan&ccedil;ada <?php echo $_SESSION['FluxoNome']; ?></strong>/<strong><?php echo $_SESSION['TarefasNome']; ?></strong>
        <label style="float:right; ">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="#" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&tarefas=1|tarefas/avancada/regra.php','menuEsquerda|conteudoGeral')";>
            <img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
            <span class="color"><strong>Voltar</strong></span>     </a>    </label>        </td>
      </tr>
      <tr>
        <td width="4%" height="22" align="center" bgcolor="#EFEFE7" class="verdana_11">&nbsp;</td>
        <td width="96%" class="verdana_11">
<div style="float:right;">
        <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php','menuEsquerda|conteudoGeral');">
       	   <img src="/corporativo/servicos/bbhive/images/busca.gif" border="0" align="absmiddle" />&nbsp;<strong>Busca simples</strong>
        </a>   
        </div>
        </td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7">&nbsp;</td>
        <td width="96%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
          <tr>
            <td width="12%" height="18" align="right" class="color"><strong>C&oacute;d. tipo :&nbsp;</strong></td>
            <td width="88%">&nbsp;<?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao']); ?></td>
          </tr>
          <tr>
            <td height="18" align="right" class="color"><strong>Tipo :&nbsp;</strong></td>
            <td>&nbsp;<?php echo $row_Fluxos['bbh_tip_flu_nome']; ?></td>
          </tr>
          <tr>
            <td align="right" class="color"><strong>Modelo :&nbsp;</strong></td>
            <td>&nbsp;<?php echo $row_Fluxos['bbh_mod_flu_nome']; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr id="temExportacao">
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><input type="checkbox" name="chk_livro" id="chk_livro" onClick="javascript: if(this.checked==true){document.getElementById('opcaoExporta').style.display='block';document.getElementById('tableDetalha').style.display='none';} else {document.getElementById('opcaoExporta').style.display='none';document.getElementById('tableDetalha').style.display='block';}"/></td>
        <td height="22" align="left" bgcolor="#EFEFE7" class="verdana_11"><strong>&nbsp;Emitir livro de <?php echo($_SESSION['ProtNome']); ?></strong></td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_11"><div id="opcaoExporta" style="display:none"><?php require_once("livro.php");?></div></td>
      </tr>
  </table>
<br />
  
<var style="display:none">txtSimples('tagPerfil', 'Consulta avançada')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11" style="margin-top:-10px;display:block" id="tableDetalha">
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><span class="verdana_11_bold"><img src="/corporativo/servicos/bbhive/images/detalhe_tar.gif" width="16" height="16" align="absmiddle" /></span><span class="verdana_11"><strong>&nbsp;Detalhamento</strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="verdana_11">
    <div style="margin-left:5px;">
	<?php 
		$nProt	= "108px";
		$nDtP	= "103px";
		$ofc	= "156px";
		//require_once("../../consulta/busca_protocolo.php"); ?></div>
	<?php require_once("detalhamento/index.php"); ?></td>
  </tr>
</table>