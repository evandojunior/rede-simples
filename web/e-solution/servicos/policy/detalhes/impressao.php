<?php 	require_once("../includes/autentica.php"); ?>
<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "atualizaObs")) {
  $updateSQL = sprintf("UPDATE pol_auditoria SET pol_aud_obs=%s WHERE pol_aud_codigo=%s",
                       GetSQLValueString($policy, $_POST['observacao'], "text"),
                       GetSQLValueString($policy, $_POST['pol_aud_codigo'], "int"));

  mysqli_select_db($policy, $database_policy);
  $Result1 = mysqli_query($policy, $updateSQL) or die(mysql_error());

  $updateGoTo = "regra.php?".$_SERVER['QUERY_STRING'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_detalhes = "-1";
if (isset($_GET['impressaodet'])) {
  $colname_detalhes = $_GET['impressaodet'];
}
mysqli_select_db($policy, $database_policy);
$query_detalhes = "SELECT date_format(pol_aud_momento,'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_codigo, pol_aud_usuario, pol_aud_acao, pol_aud_ip, pol_aud_nivel, pol_aud_obs, pol_aud_relevancia, pol_apl_codigo FROM pol_auditoria WHERE pol_aud_codigo = $colname_detalhes";
$detalhes = mysqli_query($policy, $query_detalhes) or die(mysql_error());
$row_detalhes = mysqli_fetch_assoc($detalhes);
$totalRows_detalhes = mysqli_num_rows($detalhes);

/**/
$tratado = geraCodigo($colname_detalhes);
if (!file_exists("../../../../datafiles/servicos/policy/documentos/codigo_barra/".$tratado.".png")) {
	if (!file_exists("../../../../datafiles/servicos/policy/documentos/codigo_barra") ) {
		mkdir("../../../../datafiles/servicos/policy/documentos/codigo_barra",777);
		chmod("../../../../datafiles/servicos/policy/documentos/codigo_barra",0777);
	}

	require_once('../includes/gera_codigo_barras/regra.php');
}	
/**/
?><form name="form1" method="POST" id="form1" action="../includes/gera_pdf.php"><table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
<tr class="verdana_11">
<td height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Dados e ferramentas:</strong></td>
<td class="verdana_10" align="right" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">
        <input type="hidden"  onClick="encodeDocuments()" value="Assinar" class="back_input">
        <input type="hidden"  onClick="viewDocument()" value="Visualizar" class="back_input">
        <input type="hidden"  onClick="showConfig()" value="Configurar" class="back_input">
	    <input name="fileIndex" id="fileIndex" type="checkbox" onClick="markDocument(0, checked)" value="0" style="display:none">

| <a href="#" onclick="EditaObs();"><img src="../images/editar.gif" align="absmiddle" border="0" /></a> <a href="#" onclick="EditaObs('<?php echo $editFormAction; ?>');">Editar observa&ccedil;&atilde;o</a> | <input name="exportapdf" type="image" id="exportapdf" src="/e-solution/servicos/policy/images/pdf.gif" alt="Clique aqui para exportar as informa&ccedil;&otilde;es para PDF" align="absmiddle" />
 Exportar PDF <?php /*| <a href="#@" onClick="showConfig()" title="Clique aqui para configurar o dispositivo de assinatura digital"><img src="../images/configure.gif" align="absmiddle" border="0" /> Configurar</a> | <a href="#@" onClick="encodeDocuments()" title="Clique aqui assinar digitalmente este relatório"><img src="../images/assinar.gif" align="absmiddle" border="0" /> Assinar relatório</a><?php */ ?>
 
 </td>
</tr>
</table>
<br />
<table width="90%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td align="right"><strong>C&oacute;digo  Evento : </strong></td>
    <td align="left">&nbsp;<?php echo $row_detalhes['pol_aud_codigo']; ?>      </td>
  </tr>
  <tr>
    <td width="17%" align="right">
    <strong>Usu&aacute;rio&nbsp;:</strong></td>
    <td width="83%" align="left">&nbsp;<?php echo $row_detalhes['pol_aud_usuario']; ?>
      <input name="pol_aud_usuario" type="hidden" id="pol_aud_usuario" value="<?php echo $row_detalhes['pol_aud_usuario']; ?>" /></td>
  </tr>
  <tr>
    <td align="right"><strong>A&ccedil;&atilde;o&nbsp;:</strong></td>
    <td align="left">&nbsp;<?php echo $row_detalhes['pol_aud_acao']; ?>
      <input name="pol_aud_acao" type="hidden" id="pol_aud_acao" value="<?php echo $row_detalhes['pol_aud_acao']; ?>" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Momento&nbsp;:</strong></td>
    <td align="left">&nbsp;<?php echo $row_detalhes['momento']; ?>
      <input type="hidden" name="momento" id="momento" value="<?php echo $row_detalhes['momento'] ?>" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Localiza&ccedil;&atilde;o&nbsp;:</strong></td>
    <td align="left">&nbsp;<?php echo $row_detalhes['pol_aud_ip']; ?>
      <input name="pol_aud_ip" type="hidden" id="pol_aud_ip" value="<?php echo $row_detalhes['pol_aud_ip']; ?>" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Relev&acirc;ncia&nbsp;:</strong></td>
    <td align="left">&nbsp;<?php echo $row_detalhes['pol_aud_relevancia']; ?>
      <input name="pol_aud_relevancia" type="hidden" id="pol_aud_relevancia" value="<?php echo $row_detalhes['pol_aud_relevancia']; ?>" /></td>
  </tr>
  <tr>
    <td align="right"><strong>N&iacute;vel da A&ccedil;&atilde;o&nbsp;:</strong></td>
    <td align="left">&nbsp;<?php echo $row_detalhes['pol_aud_nivel']; ?>
      <input name="pol_aud_nivel" type="hidden" id="pol_aud_nivel" value="<?php echo $row_detalhes['pol_aud_nivel']; ?>" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Aplica&ccedil;&atilde;o&nbsp;:</strong></td>
    <td align="left">&nbsp;<?php echo $_GET['pol_apl_nome']; ?>
      <input name="pol_apl_nome" type="hidden" id="pol_apl_nome" value="<?php echo $_GET['pol_apl_nome']; ?>" /></td>
  </tr>  
  <tr id="original">
    <td align="right" valign="top"><strong>Observa&ccedil;&atilde;o&nbsp;:</strong></td>
    <td align="left" valign="top">&nbsp;<?php echo $row_detalhes['pol_aud_obs']; ?>
      <input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $row_detalhes['pol_apl_codigo']; ?>" />
      <input name="pol_aud_codigo" type="hidden" id="pol_aud_codigo" value="<?php echo $row_detalhes['pol_aud_codigo']; ?>" />
      <input name="pol_aud_obs" type="hidden" id="pol_aud_obs" value="<?php echo $row_detalhes['pol_aud_obs']; ?>" /></td>
  </tr>
  <tr id="caixa" style="visibility:hidden">
    <td align="right" valign="top"><strong>Observa&ccedil;&atilde;o :</strong></td>
    <td align="left" valign="top">&nbsp;<textarea name="obs" cols="45" rows="5" class="verdana_11" id="obs"><?php echo $row_detalhes['pol_aud_obs']; ?></textarea></td>
  </tr>
  <tr id="botoes" style="visibility:hidden">
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;<input class="back_input" onclick="FechaObs();" style="cursor:pointer" type="button" name="cancelaobs" id="cancelaobs" value="Cancelar" />
      <input class="back_input" style="cursor:pointer" type="button" onclick="javascript: document.getElementById('observacao').value = document.getElementById('obs').value; document.atualizaObs.submit();" name="alteraobs" id="alteraobs" value="Editar" /></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1" />
</form>

<form id="atualizaObs" name="atualizaObs" action="regra.php?<?php echo $_SERVER['QUERY_STRING']?>" method="post">
  <textarea name="observacao" cols="45" rows="5" class="verdana_11" id="observacao" style="display:none"><?php echo $row_detalhes['pol_aud_obs']; ?></textarea>	
  <input type="hidden" name="MM_update" value="atualizaObs" />
  <input name="pol_aud_codigo" type="hidden" id="pol_aud_codigo" value="<?php echo $row_detalhes['pol_aud_codigo']; ?>" />
</form>
<?php
//require_once("../includes/assinatura_digital/assinatura.php");

mysqli_free_result($detalhes);
?>
