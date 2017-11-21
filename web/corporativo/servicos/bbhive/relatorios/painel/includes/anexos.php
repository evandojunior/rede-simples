<?php
 if(!isset($_SESSION)){ session_start(); } 
 
 foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
}

	require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/relatorios/painel/includes/cabecalhoAtividade.php");

	$query_paragrafo = "SELECT * FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo AND bbh_par_titulo = 'Bl@ck_arquivo_ANEXO*~' ORDER BY bbh_par_ordem ASC";
    list($paragrafo, $row_paragrafo, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo, $initResult = false);
?>
<link href="/corporativo/servicos/bbhive/includes/relatorio.css" rel="stylesheet" type="text/css">
<?php
while($row_paragrafo = mysqli_fetch_assoc($paragrafo)){
?>
<table width="182" border="0" cellspacing="0" cellpadding="0" onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onClick="javascript: document.getElementById('file').value='<?php echo $row_paragrafo['bbh_par_codigo']; ?>'; document.getElementById('bbh_flu_codigo').value='<?php echo $bbh_flu_codigo; ?>'; document.abreArquivo.submit();" style="margin-left:1px; margin-top:1px;" title="Download deste arquivo">
  <tr>
    <td width="41" height="40" align="center"><img src="../../../images/painel/icones/<?php echo $row_paragrafo['bbh_par_tipo_anexo']; ?>" width="30" height="30"></td>
    <td width="141" class="verdana_11">&nbsp;<?php echo $row_paragrafo['bbh_par_paragrafo']; ?></td>
  </tr>
</table>
<?php } ?>
  <?php if($totalRows_paragrafo==0){ ?>
    <table width="182" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
      <tr>
        <td height="25" colspan="5" align="center" class="verdana_11">Sem anexos</td>
      </tr>
	</table>
  <?php } ?>
<script type="text/javascript">
	window.top.document.getElementById('qtAnexos').innerHTML = '<?php echo $totalRows_paragrafo; ?>';
</script>
<form id="abreArquivo" name="abreArquivo" action="/corporativo/servicos/bbhive/relatorios/painel/download/anexos.php" method="get" style="position:absolute" target="_blank">
<input name="file" id="file" type="hidden" value="0" />
<input name="bbh_flu_codigo" id="bbh_flu_codigo" type="hidden" value="0" />
</form>