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
//--
$cdAcao 		= isset($_GET['codigo'])?(int)$_GET['codigo']:(int)$_POST['codigo'];

//Descobre ação, para não passar por get
$sqlAcao = "select a.pol_aud_acao from pol_auditoria as a where a.pol_aud_codigo = $cdAcao limit 1";
mysqli_select_db($policy, $database_policy);
$acao = mysqli_query($policy, $sqlAcao) or die(mysql_error());
$row_acao = mysqli_fetch_assoc($acao);
//--
	if(isset($_POST['medir'])){
	  $_POST['apo_tempo_execucao'] = (int)$_POST['apo_tempo_execucao'] > 0 ? $_POST['apo_tempo_execucao'] : 0;
		
	  if($_POST['apo_codigo']==0){	
	  //--Insert
	 	$sql = "INSERT INTO pol_apontamento (pol_apl_codigo, pol_aud_acao, apo_tempo_execucao, apo_observacao) values ('".mysql_real_escape_string($_POST['pol_apl_codigo'])."','".mysql_real_escape_string($row_acao['pol_aud_acao'])."','".mysql_real_escape_string($_POST['apo_tempo_execucao'])."','".mysql_real_escape_string($_POST['apo_observacao'])."')";
	  } else {
	  //--Update
	 	$sql = "UPDATE pol_apontamento SET apo_tempo_execucao='".mysql_real_escape_string($_POST['apo_tempo_execucao'])."', apo_observacao='".mysql_real_escape_string($_POST['apo_observacao'])."' WHERE apo_codigo = ".$_POST['apo_codigo'];
	  }
	  //--
	  mysqli_select_db($policy, $database_policy);
	  $Result1 = mysqli_query($policy, $sql) or die(mysql_error());
	 //--
	 header("Location: regra.php?".$_POST['url']);
	 exit();	
	}


$cdAplicacao 	= (int)$_GET['pol_apl_codigo'];
//--Verifica se tem esta ação cadastrada, novo ou edição
	$sqlApont = "select ap.apo_codigo, ap.apo_tempo_execucao, ap.apo_observacao from pol_apontamento as ap where ap.pol_apl_codigo = $cdAplicacao and ap.pol_aud_acao = '".mysql_real_escape_string($row_acao['pol_aud_acao'])."' limit 1";
	mysqli_select_db($policy, $database_policy);
	$Apont 			 = mysqli_query($policy, $sqlApont) or die(mysql_error());
	$row_Apont 		 = mysqli_fetch_assoc($Apont);
	$totalRows_Apont = mysqli_num_rows($Apont);
//--
 $url = "";
 foreach($_GET as $i=>$v){
	 if($i!="codigo"){
	 	$url.="&".$i."=".$v;
	 }
 }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">
<script type="text/javascript" src="/e-solution/servicos/policy/includes/function.js"></script>
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
            <td style="border-bottom:1px solid #CCCCCC;" width="85%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;
            			  Medir tempo da ação
				</strong></td>
            <td style="border-bottom:1px solid #CCCCCC;" width="15%" colspan="-2" align="center" valign="middle" class="verdana_11"><span class="verdana_11_bold"><a href='javascript:history.go(-1);'>.: Voltar :.</a></span></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="15%" colspan="-2" align="center" valign="middle" class="verdana_12">&nbsp;</td>
          </tr>
        </table>
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
              
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="21%" valign="top" class="verdana_11" style="border-right:dashed 1px #999999;"><?php require_once("../includes/cabecalhoaplvert.php"); ?></td>
                    <td width="78%" height="400" align="center" valign="top" class="verdana_11">
	<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">				
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="25" colspan="2" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">
            <div style="float:left">
            	<strong>Informe o tempo para execu&ccedil;&atilde;o desta a&ccedil;&atilde;o</strong>
            </div>
            <strong></strong>
    </td>
  </tr>
  <tr>
    <td height="20" align="right"  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
    <td  style="border-bottom:dotted 1px #333333;">&nbsp;<input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $cdAplicacao; ?>" readonly="readonly" />
    <input name="url" type="hidden" id="url" value="<?php echo substr($url,1); ?>" readonly="readonly" />
    <input name="apo_codigo" type="hidden" id="apo_codigo" value="<?php echo $totalRows_Apont>0?$row_Apont['apo_codigo']:0; ?>" readonly="readonly" />
    <input name="codigo" type="hidden" id="codigo" value="<?php echo $cdAcao; ?>" readonly="readonly" />
    <input name="medir" type="hidden" id="medir" value="1" readonly="readonly" />
    </td>
  </tr>

    <tr>
      <td height="20" align="right" valign="top" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">O qu&ecirc;:&nbsp;</td>
      <td width="82%" height="25" valign="top" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><div style="margin:2px; font-weight:bold"><?php echo $row_acao['pol_aud_acao']; ?></div></td>
    </tr>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Tempo para a&ccedil;&atilde;o:&nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><input name="apo_tempo_execucao" type="text" class="verdana_11" id="apo_tempo_execucao" size="8" maxlength="15" onkeyup="SomenteNumerico(this)" value="<?php echo $row_Apont['apo_tempo_execucao']; ?>" /> <label style="margin-left:5px; color:#999999">(em minutos)</label></td>
    </tr>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"> Observa&ccedil;&atilde;o:&nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><textarea name="apo_observacao" cols="60" rows="3" class="verdana_11" id="apo_observacao"><?php echo $row_Apont['apo_observacao']; ?></textarea></td>
    </tr>
    <tr>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td align="right" bgcolor="#FFFFFF"><input name="button2" type="button" class="button" id="button2" onclick="javascript:history.go(-1);" value="Cancelar" />
        <input name="button" type="submit" class="button" id="button" value="<?php echo $totalRows_Apont==0?"Cadastrar" : "Atualizar";?>" /></td>
    </tr>
</table>
    </form>                
                    </td>
                  </tr>
                  
                  <tr>
                    <td align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                    <td height="1" align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                  </tr>
                  <tr>
                    <td align="right" class="verdana_11"></td>
                    <td height="1" align="right" class="verdana_11"></td>
                  </tr>
              </table>
              
              
              </td>
            </tr>
<tr class="verdana_11_bold">
              <td valign="top"></td>
            </tr>
          </table></td>
      </tr>
      
      <tr>
        <td height="1" bgcolor="#FFFFFF"></td>
      </tr>
            <tr>
      	<td height="0" bgcolor="#FFFFFF"><?php require_once('../includes/rodape.php'); ?></td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>