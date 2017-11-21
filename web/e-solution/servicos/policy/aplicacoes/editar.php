<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
	if(isset($_POST['pol_apl_nome'])){
	//Aqui começa o Recordset que faz validação de nomes iguais.
	mysqli_select_db($policy, $database_policy);
	$query_validaaplicacao = sprintf("SELECT pol_apl_nome, pol_apl_codigo, pol_apl_icone FROM pol_aplicacao WHERE pol_apl_nome = '".$_POST['pol_apl_nome']."' AND pol_apl_codigo !=".$_GET['pol_apl_codigo']);
	$validaaplicacao = mysqli_query($policy, $query_validaaplicacao) or die(mysql_error());
	$row_validaaplicacao = mysqli_fetch_assoc($validaaplicacao);
	$totalRows_validaaplicacao = mysqli_num_rows($validaaplicacao);
	//Aqui termina o Recordset

if($totalRows_validaaplicacao==0){
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

$pol_apl_icone		= $_POST['pol_apl_icone'];
$pol_apl_relevancia = $_POST['pol_apl_relevancia'];

  $updateSQL = sprintf("UPDATE pol_aplicacao SET pol_apl_nome=%s, pol_apl_descricao=%s, pol_apl_url=%s, pol_apl_icone='$pol_apl_icone', pol_apl_relevancia=$pol_apl_relevancia WHERE pol_apl_codigo=%s",
                       GetSQLValueString($policy, $_POST['pol_apl_nome'], "text"),
                       GetSQLValueString($policy, $_POST['pol_apl_descricao'], "text"),
					   GetSQLValueString($policy, $_POST['pol_apl_url'], "text"),
                       GetSQLValueString($policy, $_POST['pol_apl_codigo'], "int"));

  mysqli_select_db($policy, $database_policy);
  $Result1 = mysqli_query($policy, $updateSQL) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}
}
$colname_aplicacao = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_aplicacao = $_GET['pol_apl_codigo'];
}

mysqli_select_db($policy, $database_policy);
$query_aplicacao = sprintf("SELECT * FROM pol_aplicacao WHERE pol_apl_codigo = %s", GetSQLValueString($policy, $colname_aplicacao, "int"));
$aplicacao = mysqli_query($policy, $query_aplicacao) or die(mysql_error());
$row_aplicacao = mysqli_fetch_assoc($aplicacao);
$totalRows_aplicacao = mysqli_num_rows($aplicacao);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
	function exibeIcone(nmIcone){
	
		document.getElementById('iconeSelecionado').innerHTML = "&nbsp;<img src='/datafiles/servicos/policy/aplicacoes/"+nmIcone+"'  align='absmiddle' /><input name='pol_apl_icone' id='pol_apl_icone' type='hidden' value='"+nmIcone+"' />";
	}
</script>
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:25px;">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="top"><?php require_once('../includes/cabecalho.php'); ?></td>
      </tr>
      
      <tr>
        <td height="20" bgcolor="#FFFFFF"><?php require_once('../includes/menu_horizontal.php'); ?></td>
      </tr>
      <tr>
        <td height="22" align="right" valign="top" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
      </tr>
      <tr>
        <td height="75" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="92%" align="left" bgcolor="#FFFFFF" class="verdana_11_bold">&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Editar Aplica&ccedil;&atilde;o</td>
            <td width="8%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="8%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
        </table>
          <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST"><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FBFFFB" style="border:1px solid #000000">
            <tr>
              <td align="right" class="verdana_11">&nbsp;</td>
                <td align="left" class="verdana_11_vermelho"><?php if(isset($_POST['pol_apl_nome'])){ echo "J&aacute; existe uma aplica&ccedil;&atilde;o com o nome ".$_POST['pol_apl_nome']; }?></td>
              </tr>
              

              <tr>
                <td height="28" align="right" class="verdana_11">Nome :</td>
                <td align="left" class="verdana_11">&nbsp;<span id="sprytextfield1"><input name="pol_apl_nome" type="text" class="verdana_11" id="pol_apl_nome" value="<?php echo $row_aplicacao['pol_apl_nome']; ?>" size="35" maxlength="75" />
                  <span class="textfieldRequiredMsg">Campo obrigat&oacute;rio.</span></span>
                  <input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $row_aplicacao['pol_apl_codigo']; ?>" /></td>
              </tr>
              <tr>
                <td height="26" align="right" class="verdana_11">URL :</td>
                <td align="left" class="verdana_11">&nbsp;<input name="pol_apl_url" type="text" class="verdana_11" id="pol_apl_url" value="<?php echo $row_aplicacao['pol_apl_url']; ?>" size="35" maxlength="75" /></td>
              </tr>
              <tr>
                <td height="26" align="right" valign="middle" class="verdana_11">Relev&acirc;ncia :</td>
                <td align="left" class="verdana_11"><label>
                  &nbsp;
                  <select name="pol_apl_relevancia" id="pol_apl_relevancia" class="formulario2">
                    <option value="-1" <?php if ($row_aplicacao['pol_apl_relevancia'] == -1 ) { echo 'selected="selected"'; } ?>>Sem valor</option>
                    <option value="0" <?php if ($row_aplicacao['pol_apl_relevancia'] == 0 ) { echo 'selected="selected"'; } ?>>0</option>
                    <option value="1" <?php if ($row_aplicacao['pol_apl_relevancia'] == 1 ) { echo 'selected="selected"'; } ?>>1</option>
                    <option value="2" <?php if ($row_aplicacao['pol_apl_relevancia'] == 2 ) { echo 'selected="selected"'; } ?>>2</option>
                    <option value="3" <?php if ($row_aplicacao['pol_apl_relevancia'] == 3 ) { echo 'selected="selected"'; } ?>>3</option>
                    <option value="4" <?php if ($row_aplicacao['pol_apl_relevancia'] == 4 ) { echo 'selected="selected"'; } ?>>4</option>
                    <option value="5" <?php if ($row_aplicacao['pol_apl_relevancia'] == 5 ) { echo 'selected="selected"'; } ?>>5</option>
                    <option value="6" <?php if ($row_aplicacao['pol_apl_relevancia'] == 6 ) { echo 'selected="selected"'; } ?>>6</option>
                    <option value="7" <?php if ($row_aplicacao['pol_apl_relevancia'] == 7 ) { echo 'selected="selected"'; } ?>>7</option>
                    <option value="8" <?php if ($row_aplicacao['pol_apl_relevancia'] == 8 ) { echo 'selected="selected"'; } ?>>8</option>
                    <option value="9" <?php if ($row_aplicacao['pol_apl_relevancia'] == 9 ) { echo 'selected="selected"'; } ?>>9</option>
                    <option value="10" <?php if ($row_aplicacao['pol_apl_relevancia'] == 10 ) { echo 'selected="selected"'; } ?>>10</option>
                    <?php /* for ($i=11;$i<=20;$i++) { ?>
                    <option value="<?php echo $i; ?>" <?php if ($row_aplicacao['pol_apl_relevancia'] == 10 ) { echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
                    <?php } */ ?>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td height="26" align="right" valign="top" class="verdana_11">Descri&ccedil;&atilde;o :</td>
                <td align="left" class="verdana_11">&nbsp;<textarea name="pol_apl_descricao" cols="60" rows="6" class="verdana_11" id="pol_apl_descricao"><?php echo $row_aplicacao['pol_apl_descricao']; ?></textarea></td>
              </tr>
              <tr>
                <td height="26" align="right">&nbsp;</td>
                <td align="left"><?php
				 
				//lista as op&ccedil;&otilde;es de imagens para gif
				if ($handle = opendir('../../../../datafiles/servicos/policy/aplicacoes/.')) {
					$cont  = 0;
					$dif	= 0;
					while (false !== ($file = readdir($handle))) {
					
				//	$excessao = array_key_exists(str_replace(".png","",$file), $cadaCampo);
					
						if ($file != "." && $file != ".." ) {
							if(strtolower($file)!="thumbs.db"){	
								if($cont==1){
									echo "<br/>";
									$cont=0;
								}
								$alt = explode(".",$file);
								$nmArquivo 	= strtolower($file);
								$icone		= '<img src="/datafiles/servicos/policy/aplicacoes/'.$nmArquivo.'" alt="'.$alt[0].'" title="'.$alt[0].'" border="0" align="absmiddle" />';
								$check="";
								if($row_aplicacao['pol_apl_icone'] == $nmArquivo){
									$check= "checked";
									
								}
								echo '<input name="pol_apl_icone" id="icone_'.$dif.'" type="radio" value="'.$nmArquivo.'" '.$check.'>'.$icone;
								$cont++; 
								$dif = $dif + 1;
								//se chegar a 100 ele para
								if ($cont == 250) { die;}	
							}
						}
					}
					closedir($handle);
				}
            ?></td>
              </tr>
              <tr>
                <td height="26" align="right">&nbsp;</td>
                <td align="left"><input name="button2" type="button" class="button" id="button2" onclick="location.href='index.php'" value="Cancelar" />
                <input name="button" type="submit" class="button" id="button" value="Editar" /></td>
            </tr>
              <tr>
                <td height="10" colspan="2" align="right">&nbsp;</td>
                </tr>
          </table>
            
            <input type="hidden" name="MM_update" value="form1" />
          </form>
          
          
          
          </td>
      </tr>
      
      <tr>
        <td height="130" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($aplicacao);
?>