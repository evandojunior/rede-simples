<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	if(isset($_GET['bbh_interface_codigo'])){
		$_SESSION['bbh_mod_flu_codigo'] = $_GET['bbh_interface_codigo'];
		?>
        <var style="display:none">
        	document.executaInterfaceRica.submit();
        </var>
        <?php
		exit;
	}

//Modelos de fluxos
$query_modfluxo = "SELECT COUNT(bbh_mod_flu_codigo) as TOTAL FROM bbh_modelo_fluxo";
list($modfluxo, $row_modfluxo, $totalRows_modfluxo) = executeQuery($bbhive, $database_bbhive, $query_modfluxo);

$page 		= "1";
$nElements 	= "50";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/index.php?Ts='.$_SERVER['REQUEST_TIME'];
$exibe			= 'conteudoGeral';
$pages 			= ceil($row_modfluxo['TOTAL']/$nElements);

	$query_modFluxos = "select
count(bbh_campo_detalhamento_fluxo.bbh_cam_det_flu_codigo) as campos,
bbh_modelo_fluxo.bbh_mod_flu_codigo, bbh_tipo_fluxo.bbh_tip_flu_codigo, bbh_mod_flu_nome, 
bbh_mod_flu_sub , bbh_tip_flu_identificacao, bbh_tip_flu_nome 
from bbh_modelo_fluxo 

inner join bbh_tipo_fluxo
on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo

left join bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
left join bbh_campo_detalhamento_fluxo ON bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo = bbh_detalhamento_fluxo.bbh_det_flu_codigo

 group by bbh_modelo_fluxo.bbh_mod_flu_codigo 
  order by bbh_tip_flu_codigo, bbh_mod_flu_nome asc  LIMIT $Inicio,$nElements";
    list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);
?>
<var style="display:none">txtSimples('tagPerfil', 'Modelos de  <?php echo $_SESSION['adm_FluxoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de modelos de <?php echo $_SESSION['adm_FluxoNome']; ?></td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" id="loadFluxo">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<p>
  <?php 
$cad="";
	if($row_modfluxo['TOTAL']==1) {
		$cad = "<span class='legandaLabel11'><strong>".$row_modfluxo['TOTAL']." modelo cadastrado</strong></span>";
	} elseif($row_modfluxo['TOTAL']>1){
		$cad = "<span class='legandaLabel11'><strong>".$row_modfluxo['TOTAL']." modelos cadastrados</strong></span>";
	}
	echo $cad;
?>
</p>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td width="22" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td width="331" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>T&iacute;tulo do <?php echo $_SESSION['adm_FluxoNome']; ?></strong><div style="float:right; "><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2&amp;menuEsquerda=1|fluxos/tiposFluxos/tipos.php','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/tabelaDinamica.gif" width="14" height="14" border="0" align="absmiddle" /> Tipos de Fluxo</a></div></td>
    <td colspan="7" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2&amp;menuEsquerda=1|fluxos/modelosFluxos/novo.php','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/novo.gif" border="0" align="absmiddle" /> modelo de <?php echo $ses = $_SESSION['adm_FluxoNome']; ?></a></td>
  </tr>
<?php if($totalRows_modFluxos>0) { ?>  
 <?php $codTipo="";
 do { 
	$codModelo = $row_modFluxos['bbh_mod_flu_codigo'];
		//perfis adicionados no modelo
		$query_perAdd = "select count(bbh_per_flu_codigo) as total from bbh_permissao_fluxo Where bbh_mod_flu_codigo=$codModelo";
        list($perAdd, $row_perAdd, $totalRows_perAdd) = executeQuery($bbhive, $database_bbhive, $query_perAdd);
		
		//atividades adicionadas no modelo
		$query_atiAdd = "select count(bbh_mod_ati_codigo) as total from bbh_modelo_atividade Where bbh_mod_flu_codigo=$codModelo";
        list($atiAdd, $row_atiAdd, $totalRows_atiAdd) = executeQuery($bbhive, $database_bbhive, $query_atiAdd);
		
		//parágrafos deste modelo
		$query_par = "select count(bbh_mod_par_codigo) as total from bbh_modelo_paragrafo Where bbh_mod_flu_codigo=$codModelo";
        list($par, $row_par, $totalRows_par) = executeQuery($bbhive, $database_bbhive, $query_par);
		
	if($codTipo != $row_modFluxos['bbh_tip_flu_codigo']){	
 ?>
  <tr class="legandaLabel11">
    <td height="10" colspan="9" align="left"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" colspan="9" align="left" class="titulo_setor" style="font-size:14px;">Tipo: <span class="color"><?php echo normatizaCep($row_modFluxos['bbh_tip_flu_identificacao'])."&nbsp;".$row_modFluxos['bbh_tip_flu_nome']; ?></span></td>
  </tr>
  <?php } ?>
  <tr class="legandaLabel11">
    <td height="30" align="center">
	<?php if($row_modFluxos['bbh_mod_flu_sub']=="1"){ 
		echo '<img src="/e-solution/servicos/bbhive/images/282.gif" border="0" />';
	} else { 
		echo '<img src="/e-solution/servicos/bbhive/images/setaII.gif" border="0" />';
	}
	?></td>
    <td>&nbsp;<?php echo $row_modFluxos['bbh_mod_flu_nome']; ?></td>
    <td width="20" align="center">
	<a href="#@" title="Clique para visualizar o Fluxograma" onclick="return OpenAjaxPostCmd('/e-solution/servicos/bbhive/fluxos/modelosFluxos/index.php?bbh_interface_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>&','loadFluxo','','Aguarde','loadFluxo','2','2')"><img src="/e-solution/servicos/bbhive/images/fluxograma_mini.gif" align="absmiddle" border="0"/></a>
    </td>
    <td width="25" align="center"><a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/edita.php?bbh_mod_flu_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/editar.gif" border="0" align="absmiddle" /></a></td>
    <td width="21" align="center">
<a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/exclui.php?bbh_mod_flu_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');">
<img src="/e-solution/servicos/bbhive/images/excluir.gif" border="0" align="absmiddle" />
</a>
    </td>
    <td width="43" align="left">
<a href="#@" title="<?php echo $row_modFluxos['campos']; ?> campos(s) do detalhamento cadastrado(s)"  onclick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/detalhamento/index.php?bbh_mod_flu_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');">
<img src="/e-solution/servicos/bbhive/images/detalhamento.gif" alt="Detalhamento do fluxo" width="16" height="16" border="0" align="absmiddle"/></a><?php echo $var = $row_modFluxos['campos']; ?>
    </td>
    <td width="42" align="left">
<a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/paragrafos/index.php?bbh_mod_flu_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" title="<?php echo $oPar = $row_par['total']; ?> texto(s) pr&eacute;-definido cadastrado">
<img src="/e-solution/servicos/bbhive/images/paragrafo.gif" border="0" align="absmiddle" /> <?php echo $oPar = $row_par['total']; ?>
</a>
    </td>
    <td width="43" align="left">
<a href="#@" title="<?php echo $row_perAdd['total']; ?> perfi(s) cadastrado(s)"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/permissaoFluxo/regra.php?bbh_mod_flu_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');">
       <?php if($row_perAdd['total']>0){ 
	   	echo '<img src="/e-solution/servicos/bbhive/images/cadeado.gif" border="0" align="absmiddle" />';
		} else { 
	   	echo '<img src="/e-solution/servicos/bbhive/images/cadeado_off.gif" border="0" align="absmiddle" /> ';
		}
		echo $tot = $row_perAdd['total'];
	   ?> 
</a>
    </td>
    <td width="48" align="left">
<a href="#@" title="<?php echo $row_atiAdd['total']; ?> atividade(s) cadastrada(s)" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');">
<img src="/e-solution/servicos/bbhive/images/atividades.gif" border="0" align="absmiddle" />
<?php echo $add = $row_atiAdd['total']; ?></a>
    </td>
  </tr>
  <tr>
    <td height="1" colspan="9" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <?php $codTipo = $row_modFluxos['bbh_tip_flu_codigo'];
 } while ($row_modFluxos = mysqli_fetch_assoc($modFluxos)); ?>
<?php } else { ?>
  <tr class="legandaLabel11">
    <td height="25" colspan="9" align="center">N&atilde;o h&aacute; registros cadastrados</td>
  </tr>
<?php } ?>
      <tr class="legandaLabel11">
        <td height="22" colspan="9" align="center"><?php require_once('../../includes/paginacao/paginacao.php');?></td>
      </tr>
</table>
<form name="executaInterfaceRica" id="executaInterfaceRica" method="get" action="/e-solution/servicos/bbhive/fluxograma/interface_rica/index.php" target="_blank">
</form>