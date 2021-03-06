<?php
	require_once("../../includes/autentica.php");
	require_once("../../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_policy, $policy);
$query_pegacodigo = "SELECT pol_apl_codigo FROM pol_aplicacao ORDER BY pol_apl_codigo DESC";
$pegacodigo = mysql_query($query_pegacodigo, $policy) or die(mysql_error());
$row_pegacodigo = mysql_fetch_assoc($pegacodigo);
$totalRows_pegacodigo = mysql_num_rows($pegacodigo);

mysql_select_db($database_policy, $policy);
$query_strPolitica = "select * from pol_politica 
WHERE pol_apl_codigo = " .$_GET['pol_apl_codigo'] . " 
 order by pol_pol_titulo ASC, pol_pol_criacao DESC";
$strPolitica = mysql_query($query_strPolitica, $policy) or die(mysql_error());
$row_strPolitica = mysql_fetch_assoc($strPolitica);
$totalRows_strPolitica = mysql_num_rows($strPolitica);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ( isset ($_GET['pol_graf_tipo']) && $_GET['pol_graf_tipo'] == 'linha' ) {
	$grafico = $_GET['pol_graf_tipo'];
}
if ( isset ($_GET['pol_pol_codigo']) ) {
	$codigoPolitica = $_GET['pol_pol_codigo'];
}

if ( isset ($_POST['pol_graf_grupo']) )  {

 $goTo = "passo4.php?pol_graf_grupo=".$_POST['pol_graf_grupo'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $goTo .= (strpos($goTo, '?')) ? "&" : "?";
    $goTo .= $_SERVER['QUERY_STRING'];
  }
 header("Location: $goTo");

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>


</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:25px;">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="top"><?php require_once('../../includes/cabecalho.php'); ?></td>
      </tr>
      
      <tr>
        <td height="20" bgcolor="#FFFFFF"><?php require_once('../../includes/menu_horizontal.php'); ?></td>
      </tr>
      <tr>
        <td height="22" align="right" valign="top" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
      </tr>
      <tr>
        <td height="75" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="92%" align="left" bgcolor="#FFFFFF" class="verdana_11_bold">&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt="Novo Gr&aacute;fico" align="absmiddle"/>&nbsp;Escolha a pol&iacute;tica</td>
            <td width="8%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="8%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
        </table>
          <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FBFFFB" style="border:1px solid #BBCCBB;">
            <tr>
              <td colspan="2" align="right" class="verdana_11"><?php if(isset($_POST['pol_apl_nome'])){ echo "J&aacute; existe uma aplica&ccedil;&atilde;o com o nome ".$_POST['pol_apl_nome']; }?>                              </td>
                </tr>
              
        <tr>
                <td width="20%" height="15" align="right" class="verdana_11"></td>
                <td width="80%" align="left" class="verdana_11">&nbsp;<input name="pol_graf_tipo_hidden" type="hidden" class="verdana_11" id="pol_graf_tipo_hidden" value="<?php if (isset($_GET['pol_graf_tipo']) && $_GET['pol_graf_tipo'] == 'linha') { echo 'linha"'; } ?>" size="35" maxlength="75" /></td>
              </tr>
              
              <tr>
                <td height="50" align="right" valign="middle" class="verdana_11">Tipo : </td>
                <td height="50" align="left">&nbsp;
                <input name="pol_graf_tipo" id="pol_graf_tipo_pizza" type="radio" value="pizza"  disabled="disabled"><img src="/e-solution/servicos/policy/images/pizza.gif" width="46" height="45" alt="" title="" border="0" align="absmiddle" />
                
                &nbsp;<input name="pol_graf_tipo" id="pol_graf_tipo_barra" type="radio" value="barra"  disabled="disabled" ><img src="/e-solution/servicos/policy/images/barra.gif" width="46" height="45" alt="" title="" border="0" align="absmiddle" />
                
                &nbsp;<input name="pol_graf_tipo" id="pol_graf_tipo_linha" type="radio" value="linha" <?php if (isset($_GET['pol_graf_tipo']) && $_GET['pol_graf_tipo'] == 'linha') { echo 'checked="checked"'; } ?> disabled="disabled"><img src="/e-solution/servicos/policy/images/linha.gif" width="46" height="45" alt="" title="" border="0" align="absmiddle" />                  </td>
              </tr>
              <tr>
                <td height="30" align="right" class="verdana_11">Pol&iacute;tica :</td>
                <td height="30" align="left"><label>
                  &nbsp;
                  <select class="formulario2" name="pol_pol_codigo" id="pol_pol_codigo" disabled="disabled">
                    <option value="0" selected="selected">Selecione uma política </option>
                  	<?php do { ?>  
                    <option value="<?php echo $row_strPolitica['pol_pol_codigo']; ?>" <?php if ( $row_strPolitica['pol_pol_codigo'] == $_GET['pol_pol_codigo']) { echo 'selected="selected"'; }  ?> >
					<?php echo $row_strPolitica['pol_pol_titulo']; ?>					 </option>
                   <?php
				  
				    }  while ( $row_strPolitica = mysql_fetch_assoc($strPolitica) );  ?>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td height="26" align="right" valign="top" class="verdana_11" style="margin-top:5px;padding-top:5px">Grupo :</td>
                <td align="left" class="verdana_11">
                 
                    <label>
                      <input type="radio" name="pol_graf_grupo" value="1" id="pol_graf_grupo_1" />
                      Quem</label>
                    <br />
                    <label>
                      <input type="radio" name="pol_graf_grupo" value="2" id="pol_graf_grupo_2" />
                      O quê</label>
                    <br />
                   
                    <label>
                      <input type="radio" name="pol_graf_grupo" value="4" id="pol_graf_grupo_4" />
                      Onde</label>
                    <br />
                    <label>
                      <input type="radio" name="pol_graf_grupo" value="5" id="pol_graf_grupo_5" />
                      Relevância</label>
                    <br />
                  </p></td>
              </tr>
              <tr>
                <td height="26" align="right">&nbsp;</td>
                <td align="left">
                 <?php
				 /*
				//lista as opções de imagens para gif
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
								if($dif==0){
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
				*/
            ?>                </td>
              </tr>
              <tr>
                <td height="26" align="right">&nbsp;</td>
                <td align="left"><input name="button2" type="button" class="button" id="button2" onclick="location.href='javascript: history.back(-1)'" value="Voltar" />
                <input name="button" type="submit" class="button" id="button" value="Avan&ccedil;ar" /></td>
            </tr>
              <tr>
                <td colspan="2" align="right">&nbsp;</td>
                </tr>
          </table>
            <input type="hidden" name="MM_insert" value="form1" />
          </form>
       
          </td>
      </tr>
      
      <tr>
        <td height="130" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>