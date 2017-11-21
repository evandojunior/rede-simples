<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$cont=0;
foreach($_GET as $indice=>$valor){
		if($cont==0){ $bbh_tip_flu_codigo = $valor; } 
		if($cont==1){ $bbh_mod_flu_codigo = $valor; } 
	$cont=$cont+1;
}

	$query_Fluxos = "select 
		bbh_modelo_fluxo.*, bbh_per_nome, bbh_usu_codigo, bbh_tip_flu_identificacao, bbh_tip_flu_nome
		
		from bbh_modelo_fluxo
		#Tipo de fluxo
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		
		#Modelo Fluxo com permissão fluxo
		inner join bbh_permissao_fluxo on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_permissao_fluxo.bbh_mod_flu_codigo
		
		#Permissão Fluxo com perfil
		inner join bbh_perfil on bbh_permissao_fluxo.bbh_per_codigo = bbh_perfil.bbh_per_codigo
		
		#Perfil com Usuário Perfil
		inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
		
		Where bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_modelo_fluxo.bbh_mod_flu_codigo = $bbh_mod_flu_codigo
		
		order by bbh_mod_flu_nome asc";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
	
	$homeDestino	= '/corporativo/servicos/bbhive/relatorios/paragrafos/paragrafos.php?bbh_tip_flu_codigo='.$bbh_tip_flu_codigo.'&bbh_mod_flu_codigo='.$bbh_mod_flu_codigo."&Ts=".time();
	$acao = "OpenAjaxPostCmd('".$homeDestino."','exibePar','&2=2','Carregando dados...','exibePar','2','2');";

?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastrar par&aacute;grafo')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Cadastro de par&aacute;grafos</strong></span>
      <label style="float:right; ">
     <a href="#@"  onClick="return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra2.php?bbh_tip_flu_codigo=<?php echo $bbh_tip_flu_codigo; ?>','menuEsquerda|colPrincipal');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
</table>
<br />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11 borderAlljanela">
  <tr>
    <td colspan="2" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">
    <label style="margin-left:15px"><strong>Dados do modelo</strong></label>    </td>
  </tr>
  <tr>
    <td width="21%" height="25" align="right" class="color"><strong>Tipo do modelo :</strong>&nbsp;</td>
    <td width="79%" height="25">&nbsp;<?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao']). " " . $row_Fluxos['bbh_tip_flu_nome']; ?></td>
  </tr>
  <tr>
    <td height="25" align="right" class="color"><strong>T&iacute;tulo do modelo :</strong>&nbsp;</td>
    <td height="25">&nbsp;<?php echo $row_Fluxos['bbh_mod_flu_nome']; ?></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
</table>
<br />
<div id="loadOrdena" class="verdana_12" style="position:absolute; margin-top:-5px;">&nbsp;</div>
<div id="exibePar" class="verdana_12" style="margin-top:30px;">&nbsp;</div>
<var style="display:none"><?php echo $acao; ?></var>