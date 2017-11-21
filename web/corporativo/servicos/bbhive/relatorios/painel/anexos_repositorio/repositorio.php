<?php if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
}

/*
select * from (select * from bbh_arquivo where bbh_flu_codigo = 2
  and bbh_arq_compartilhado = '1' AND bbh_arq_tipo = 'pdf' and bbh_usu_codigo <> 7
UNION
    
select * from bbh_arquivo where bbh_flu_codigo = 2
  and bbh_usu_codigo = 7 AND bbh_arq_tipo = 'pdf'
  	 ) as consulta
	 order by bbh_arq_titulo, bbh_arq_nome_logico ASC

*/
	$query_repositorio = "select * from bbh_arquivo where bbh_flu_codigo = $bbh_flu_codigo
  and bbh_arq_compartilhado = '1' AND bbh_arq_tipo = 'pdf'
    order by bbh_arq_titulo, bbh_arq_nome_logico ASC";
	
	$query_repositorio = "select * from (select * from bbh_arquivo where bbh_flu_codigo = $bbh_flu_codigo
  and bbh_arq_compartilhado = '1' AND bbh_arq_tipo = 'pdf' and bbh_usu_codigo <> ".$_SESSION['usuCod']."
UNION
    
select * from bbh_arquivo where bbh_flu_codigo = $bbh_flu_codigo
  and bbh_usu_codigo = ".$_SESSION['usuCod']." AND bbh_arq_tipo = 'pdf'
  	 ) as consulta
	 order by bbh_arq_titulo, bbh_arq_nome_logico ASC";

    list($repositorio, $rows, $totalRows_repositorio) = executeQuery($bbhive, $database_bbhive, $query_repositorio, $initResult = false);
?><link rel="stylesheet" type="text/css" href="../../../includes/relatorio.css">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<?php while($row_repositorio = mysqli_fetch_assoc($repositorio)){
	$tituloRadio = substr($row_repositorio['bbh_arq_nome_logico'],0,-4);
?>
  <tr>
    <td width="26" height="25" align="center"><input type="radio" name="radio" id="bbh_arq_codigo" value="<?php echo $row_repositorio['bbh_arq_codigo']; ?>" onClick="javascript: window.top.document.getElementById('bbh_arq_codigo').value=this.value;window.top.document.getElementById('bbh_par_paragrafo').value='<?php echo($tituloRadio);?>'"></td>
    <td width="350" align="left" class="verdana_11">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<?php echo $row_repositorio['bbh_arq_nome_logico']; ?></td>
    <td width="184" align="left" class="verdana_11"><?php echo $row_repositorio['bbh_arq_autor']; ?></td>
  </tr>
  <?php } ?>
<?php if($totalRows_repositorio==0){ ?>
  <tr>
    <td height="25" colspan="3" align="center" class="verdana_11">N&atilde;o existem arquivos.</td>
  </tr>
<?php } ?>
</table>