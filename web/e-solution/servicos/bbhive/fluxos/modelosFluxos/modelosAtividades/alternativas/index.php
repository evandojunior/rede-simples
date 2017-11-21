<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	if(isset($_GET['nv'])){
		$con=0;
		foreach($_GET as $indice=>$valor){
			$con=$con+1;
			if($con==2){ $bbh_mod_flu_codigo = $valor;}
			if($con==3){ $bbh_mod_ati_codigo = $valor;}
		}
	} else {
		$bbh_mod_ati_codigo = $_GET['bbh_mod_ati_codigo'];
		$bbh_mod_flu_codigo = $_GET['bbh_mod_flu_codigo'];
	}

	$query_Alternativas = "	select 
bbh_flu_alt_codigo, bbh_flu_alt_titulo, bbh_atividade_predileta, bbh_mod_flu_codigo, bbh_mod_ati_ordem
 from bbh_fluxo_alternativa 
      Where bbh_fluxo_alternativa.bbh_mod_ati_codigo=$bbh_mod_ati_codigo
     Order by bbh_atividade_predileta asc";
list($Alternativas, $row_Alternativas, $totalRows_Alternativas) = executeQuery($bbhive, $database_bbhive, $query_Alternativas);
?>
<var style="display:none">txtSimples('tagPerfil', 'Alternativas da atividade')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de modelos alternativas de atividades</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../cabecaModelo.php'); ?>
<?php require_once('cabecaAtividade.php'); ?>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela legandaLabel11">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><span style="color:#0033FF">&nbsp;<strong>Alternativas</strong></span>
    </td>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><span style="color:#0033FF"><strong>Modelo <?php echo $_SESSION['adm_FluxoNome']; ?></strong></span></td>
    <td height="26" colspan="3" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><span style="color:#0033FF"><strong>Ordem</strong></span>
       <label style="float:right; margin-top:-13px;">
    	<a href="#@"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/alternativas/novo.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>&bbh_mod_ati_codigo=<?php echo $bbh_mod_ati_codigo; ?>','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/novo.gif" border="0" align="absmiddle" /> alternativa</a>&nbsp;    </label>    </td>
  </tr>
<?php if($totalRows_Alternativas>0){ ?>  
 <?php do {
 
 	//qual modelo selecionou
	$query_modFlu = "select * from bbh_modelo_fluxo Where bbh_mod_flu_codigo=".$row_Alternativas['bbh_mod_flu_codigo'];
	list($modFlu, $row_modFlu, $totalRows_modFlu) = executeQuery($bbhive, $database_bbhive, $query_modFlu);
	
	//seleciona a atividade
	$query_modAti = "SELECT bbh_mod_ati_codigo, bbh_mod_ati_nome, bbh_mod_ati_ordem from bbh_modelo_atividade Where bbh_mod_flu_codigo=".$row_modFlu['bbh_mod_flu_codigo']." and bbh_mod_ati_ordem=".$row_Alternativas['bbh_mod_ati_ordem'];
	list($modAti, $row_modAti, $totalRows_modAti) = executeQuery($bbhive, $database_bbhive, $query_modFlu);
 ?>
  <tr>
    <td width="266" height="22">&nbsp;<img src="/e-solution/servicos/bbhive/images/marcador.gif" border="0" align="absmiddle" />&nbsp;<?php echo $row_Alternativas['bbh_flu_alt_titulo']; ?></td>
    <td width="134">&nbsp;<?php echo substr($row_modFlu['bbh_mod_flu_nome'],0,15)."..."; ?></td>
    <td width="142">&nbsp;<?php echo substr((isset($row_modAti['bbh_mod_ati_nome']) ? $row_modAti['bbh_mod_ati_nome']:''),0,15)."..."; ?></td>
    <td width="26" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/alternativas/edita.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>&bbh_mod_ati_codigo=<?php echo $bbh_mod_ati_codigo; ?>&bbh_flu_alt_codigo=<?php echo $row_Alternativas['bbh_flu_alt_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/editar.gif" border="0" align="absmiddle" /></a></td>
    <td width="27" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/alternativas/exclui.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>&bbh_mod_ati_codigo=<?php echo $bbh_mod_ati_codigo; ?>&bbh_flu_alt_codigo=<?php echo $row_Alternativas['bbh_flu_alt_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/excluir.gif" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td height="1" colspan="5" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <?php } while ($row_Alternativas = mysqli_fetch_assoc($Alternativas)); ?>
<?php } else { ?>  
  <tr>
    <td height="22" colspan="5" align="center">N&atilde;o h&aacute; registros cadastrados</td>
  </tr>
<?php } ?>
</table>
