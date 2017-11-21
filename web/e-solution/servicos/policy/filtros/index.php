<?php 
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

//Auditoria do próprio Policy
/*$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
EnviaPolicy("Acessou a página inicial do sistema");*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/functions.js"></script>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/boxover.js"></script>

</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:25px;">
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
        <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="border-bottom:1px solid #CCCCCC;" width="85%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Escolha o tipo de busca que deseja efetuar</strong></td>
            <td style="border-bottom:1px solid #CCCCCC;" width="15%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="15%" colspan="-2" align="center" valign="middle" class="verdana_12">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="21%" align="left" valign="top" class="verdana_11" style="border-right:dashed 1px #999999;"><?php require_once("../includes/cabecalhoaplvert.php"); ?></td>
            <td width="78%" height="400" align="left" valign="top" class="verdana_11">
            
        <form name="form1" id="form1" method="get" action="regra.php">
        <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
          <tr>
            <td height="25" colspan="3" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">
            <div style="float:left">
            	<strong>Escolha a op&ccedil;&atilde;o desejada</strong>
            </div>
            <div style="float:right">
            	<strong><a href='/e-solution/servicos/policy/detalhes/index.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>'>.: Voltar :.</a></strong> </div>
            </td>
          </tr>
          <tr>
            <td height="20" colspan="2" align="right"  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
            <td  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
          </tr>
        
          <tr>
            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
              <input type="checkbox" name="chk_quem" id="chk_quem">
              <input name="quemOk" id="quemOk" type="hidden" value="0" />
            </label></td>
            <td width="14%" height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">Quem :&nbsp;</td>
            <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
                <select name='condicao_quem' id='condicao_quem' class='verdana_9' style="margin-left:5px;">
                  <option value='='>=</option>
                  <option value='&lt;'>&lt;</option>
                  <option value='&gt;'>&gt;</option>
                  <option value='&lt;&gt;'>&lt;&gt;</option>
                  <option value='inicio'>inicie com</option>
                  <option value='fim'>termine com</option>
                  <option value='contenha'>contenha</option>
              </select>
                <a href="#@" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'quem', 'quemdet=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a> 
                
              <label id="quem">
                  <input name="pol_quem" type="text" class="back_Campos" size="40">
              </label>      </td>
          </tr>
          <tr>
            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
              <input type="checkbox" name="chk_quando" id="chk_quando">
            </label></td>
            <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">Quando :&nbsp;</td>
            <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <div style='margin-top:0px;; line-height:25px; margin-right:5px;'>          
            <label>&nbsp;<strong>Inicio :</strong>
            &nbsp;<input name="data_inicio" type="text" class="back_Campos" id="data_inicio" value="<?php echo date("d") . "/" . date("m") . "/" . date("Y"); ?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
              <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.data_inicio,'dd/mm/yyyy',this)"/>
            </label>
        
        <label>&nbsp;&nbsp;<strong>Final :</strong>&nbsp;<input name="data_fim" type="text" class="back_Campos" id="data_fim" value="<?php echo date("d") . "/" . date("m") . "/" . date("Y"); ?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
              <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.data_fim,'dd/mm/yyyy',this)"/>
        </label>
        </div>
            </td>
          </tr>
          <tr>
            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
              <input type="checkbox" name="chk_onde" id="chk_onde">
              <input name="ondeOk" id="ondeOk" type="hidden" value="0" />
            </label></td>
            <td height="20" align="right" bgcolor="#F7F7F7" style="border-bottom:dotted 1px #333333;"> Onde :&nbsp;</td>
            <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><select name='condicao_onde' id='condicao_onde' class='verdana_9' style="margin-left:5px;">
                <option value='='>=</option>
                <option value='&lt;'>&lt;</option>
                <option value='&gt;'>&gt;</option>
                <option value='&lt;&gt;'>&lt;&gt;</option>
                <option value='inicio'>inicie com</option>
                <option value='fim'>termine com</option>
                <option value='contenha'>contenha</option>
              </select>
              <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'onde', 'ip=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a>
                <label id="onde">
                    <input name="pol_onde" type="text" class="back_Campos" size="40">
                </label>    </td>
          </tr>
          <tr>
            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
              <input type="checkbox" name="chk_oque" id="chk_oque">
              <input name="oqueOk" id="oqueOk" type="hidden" value="0" />
            </label></td>
            <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">O qu&ecirc; :&nbsp;</td>
            <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><select name='condicao_oque' id='condicao_oque' class='verdana_9' style="margin-left:5px;">
                <option value='='>=</option>
                <option value='&lt;'>&lt;</option>
                <option value='&gt;'>&gt;</option>
                <option value='&lt;&gt;'>&lt;&gt;</option>
                <option value='inicio'>inicie com</option>
                <option value='fim'>termine com</option>
                <option value='contenha'>contenha</option>
              </select>
              <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'oque', 'acao=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a>
                <label id="oque">
                    <input name="pol_oque" id="pol_oque" value="" type="text" class="back_Campos" size="40">
                </label></td>
          </tr>
          <tr>
            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
              <input type="checkbox" name="chk_relevancia" id="chk_relevancia">
              <input name="relevanciaOk" id="relevanciaOk" type="hidden" value="0" />
            </label></td>
            <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">Relev&acirc;ncia :&nbsp;</td>
            <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><select name='condicao_relevancia' id='condicao_relevancia' class='verdana_9' style="margin-left:5px;">
                <option value='='>=</option>
                <option value='&lt;'>&lt;</option>
                <option value='&gt;'>&gt;</option>
                <option value='&lt;&gt;'>&lt;&gt;</option>
                <option value='inicio'>inicie com</option>
                <option value='fim'>termine com</option>
                <option value='contenha'>contenha</option>
              </select>
              <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'relevancia', 'relevanciadet=true');"><img src="../images/combo.gif" width="18" height="17" border="0" align="absmiddle"></a>
                <label id="relevancia">
                    <input name="pol_relevancia" type="text" class="back_Campos" size="40">
                </label>    </td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="right" bgcolor="#FFFFFF"><input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $_GET['pol_apl_codigo']; ?>">
              <input name="Submit" type="submit" class="back_input" id="button" value="Avancar" style="cursor:pointer">
        &nbsp;</td>
          </tr>
        
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
            <td bgcolor="#FFFFFF">&nbsp;</td>
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
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>