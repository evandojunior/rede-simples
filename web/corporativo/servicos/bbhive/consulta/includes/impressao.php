<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//recuperação de variáveis do GET e SESSÃO
foreach($_POST as $indice => $valor){
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
}
	//descobre o Fluxo desta atividade
	$query_Fluxo =  "select bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_flu_observacao,
					 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome, MAX(bbh_ati_final_previsto) as final, bbh_usu_nome
					 	from bbh_fluxo 
					
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
						Where bbh_fluxo.bbh_flu_codigo = $bbh_flu_codigo
							group by bbh_fluxo.bbh_flu_codigo
								order by bbh_flu_codigo desc LIMIT 0,1";
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	
    //quantas tem no fluxo
	$query_strArquivos = "select count(bbh_arq_codigo) as total from bbh_arquivo Where bbh_arq_compartilhado = '1' and bbh_flu_codigo=$bbh_flu_codigo";
    list($strArquivos, $row_strArquivos, $totalRows_strArquivos) = executeQuery($bbhive, $database_bbhive, $query_strArquivos);
	
    //quantas tarefas tem no fluxo
	$query_strMinhasTarefas = "select count(bbh_ati_codigo) as total from bbh_atividade Where bbh_flu_codigo=$bbh_flu_codigo";
    list($strMinhasTarefas, $row_strMinhasTarefas, $totalRows_strMinhasTarefas) = executeQuery($bbhive, $database_bbhive, $query_strMinhasTarefas);
	
$CriouRelatorio=0;

	$query_rel = "select MAX(r.bbh_rel_codigo) as bbh_rel_codigo from bbh_protocolos as p
				  inner join bbh_fluxo as f on p.bbh_flu_codigo = f.bbh_flu_codigo
				  inner join bbh_atividade as a on f.bbh_flu_codigo = a.bbh_flu_codigo
				  inner join bbh_modelo_atividade as ma on a.bbh_mod_ati_codigo = ma.bbh_mod_ati_codigo
				  inner join bbh_relatorio as r on a.bbh_ati_codigo = r.bbh_ati_codigo
				   Where ma.bbh_mod_ati_relatorio = '1' AND f.bbh_flu_codigo = $bbh_flu_codigo";
    list($rel, $row_rel, $totalRows_rel) = executeQuery($bbhive, $database_bbhive, $query_rel);
	$CriouRelatorio = $row_rel['bbh_rel_codigo'] > 0 ? 1 : 0;
	
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de impressão do resumo de ".$_SESSION['FluxoNome']." código (".$bbh_flu_codigo.") - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/

require_once("cabecaFluxo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Impress&atilde;o do resumo - <?php echo $_SESSION['FluxoNome']; ?></title>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/relatorio.css"/>
</head>

<body>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel16">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIVI.gif" border="0" align="absmiddle" />&nbsp;<strong>Resumo do <?php echo $_SESSION['FluxoNome']; ?></strong></td>
  </tr>
  </table>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECFFEC" style="border-left:#E6E6E6 solid 1px;border-right:#E6E6E6 solid 1px;border-bottom:#E6E6E6 solid 1px;">
  <tr>
    <td width="25" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/nome.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td colspan="2" class="legandaLabel16" style="color:#F60"><strong>&nbsp;<?php echo $numeroProcesso; ?></strong></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td width="23" align="center"><img src="/corporativo/servicos/bbhive/images/numero.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td width="552" class="legandaLabel16" style="color:#36C">&nbsp;<strong><?php echo $row_CabFluxo['bbh_flu_titulo']; ?></strong></td>
  </tr>
</table>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel12" style="margin-top:10px;border:#E6E6E6 solid 1px;">
  <tr>
    <td width="25" height="25" class="titulo_setor" align="center"><img src="/corporativo/servicos/bbhive/images/visualizar.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td colspan="3" class="titulo_setor legandaLabel12">&nbsp;<strong>Dados b&aacute;sicos</strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>C&oacute;digo :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><strong><?php echo $row_Fluxo['bbh_flu_codigo']; ?></strong></span></td>
    <td width="234" rowspan="6" align="left" valign="top">
      <fieldset style="margin-top:2px; margin-bottom:2px;">
        <legend class="legandaLabel11">Informa&ccedil;&otilde;es complementares</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" border="0" align="absmiddle"></td>
            <td height="25">&nbsp;<strong>Iniciado em <span style="color:#F60"><?php echo $dt=$row_Fluxo['bbh_flu_data_iniciado']; ?></span></strong></td>
          </tr>
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" border="0" align="absmiddle"></td>
            <td height="25">&nbsp;<strong>Final previsto <span style="color:#F60"><?php echo $dt=arrumadata($row_Fluxo['final']); ?></span></strong></td>
          </tr>
          <tr>
            <td width="12%" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/clipes.gif" border="0" align="absmiddle"></td>
            <td width="88%">&nbsp;<strong><span style="color:#F60"><?php echo $a=$row_strArquivos['total']; ?></span>&nbsp;<?php echo strtolower($_SESSION['arqNome']); ?> compartilhado(s)</strong></td>
          </tr>
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle"></td>
            <td height="25">&nbsp;<strong><span style="color:#F60"><?php echo $t=$row_strMinhasTarefas['total']; ?></span>&nbsp;<?php echo strtolower($_SESSION['TarefasNome']); ?></strong></td>
          </tr>
        </table>
      </fieldset>                
    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>T&iacute;tulo :&nbsp;</strong></td>
    <td width="244">&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_flu_titulo']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Tipo :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo normatizaCep($row_Fluxo['bbh_tip_flu_identificacao'])."&nbsp;".$row_Fluxo['bbh_tip_flu_nome']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Origem :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_dep_nome']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Distribu&iacute;do por :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_usu_nome']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Situa&ccedil;&atilde;o :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo $row_Fluxo['concluido']; ?>%</span></td>
  </tr>
  <tr>
    <td height="5"><span style="font-size:4px;">&nbsp;</span></td>
    <td width="97"><span style="font-size:4px;">&nbsp;</span></td>
    <td colspan="2"><span style="font-size:4px;">&nbsp;</span></td>
  </tr>
</table>
<br>
<?php require_once("protocolosCompleto.php"); ?>
<br>
<?php require_once("relacionados/relacionados.php"); ?>
</body>
</html>