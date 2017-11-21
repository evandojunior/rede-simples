<?php 
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");

//initialize the session
if (!isset($_SESSION)) {
  session_start();
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
            
        <form name="form1" id="form1" method="get" action="/e-solution/servicos/policy/detalhes/regra.php">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="25" colspan="2" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">
            <div style="float:left">
            	<strong>Escolha a ordena&ccedil;&atilde;o desejada</strong>
            </div>
            <div style="float:right">
            	<strong><a href='index.php?<?php echo $_SERVER['QUERY_STRING']; ?>'>.: Voltar :.</a></strong> </div>
    <strong></strong>
    </td>
  </tr>
  <tr>
    <td height="20" align="right"  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
    <td  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
  </tr>

<?php if(isset($_GET['chk_quem'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Quem &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $_GET['pol_quem']; ?>
      <input name="condicao_quem" id="condicao_quem" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['condicao_quem']; ?>">
      <input name="pol_quem" id="pol_quem" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['pol_quem']; ?>">
      </td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_quando'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Quando &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $_GET['data_inicio']; ?> - <?php echo $_GET['data_fim']; ?>
<input name="data_inicio" id="data_inicio" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['data_inicio']; ?>">
<input name="data_fim" id="data_fim" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['data_fim']; ?>"></td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_onde'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"> Onde &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $_GET['pol_onde']; ?><input name="condicao_onde" id="condicao_onde" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['condicao_onde']; ?>">
      <input name="pol_onde" id="pol_onde" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['pol_onde']; ?>"></td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_oque'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">O qu&ecirc; &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $_GET['pol_oque']; ?> <input name="condicao_oque" id="condicao_oque" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['condicao_oque']; ?>">
      <input name="pol_oque" id="pol_oque" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['pol_oque']; ?>"></td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_relevancia'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Relev&acirc;ncia &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $_GET['pol_relevancia']; ?>
      <input name="condicao_relevancia" id="condicao_relevancia" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['condicao_relevancia']; ?>">
      <input name="pol_relevancia" id="pol_relevancia" type="hidden" class="back_Campos" readonly="readonly" value="<?php echo $_GET['pol_relevancia']; ?>"></td>
    </tr>
<?php } ?>
    <tr>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
</table>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <?php $Ordem = "1"; ?>

    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_quem" id="chk_quem">
      </label></td>
      <td width="18%" height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_quem" class="verdana_9" id="order_quem" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==$Ordem){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Quem :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_quem" class="formulario2" id="estr_quem">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_quando" id="chk_quando">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_quando" class="verdana_9" id="order_quando" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==2){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Quando :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_quando" class="formulario2" id="estr_quando">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_onde" id="chk_onde">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7" style="border-bottom:dotted 1px #333333;">
    <select name="order_onde" class="verdana_9" id="order_onde" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==3){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Onde :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_onde" class="formulario2" id="estr_onde">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_oque" id="chk_oque">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_oque" class="verdana_9" id="order_oque" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==4){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      O qu&ecirc; :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_oque" class="formulario2" id="estr_oque">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_relevancia" id="chk_relevancia">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_relevancia" class="verdana_9" id="order_relevancia" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==5){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Relev&acirc;ncia :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_relevancia" class="formulario2" id="estr_relevancia">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td align="right" bgcolor="#FFFFFF">
        <input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $_GET['pol_apl_codigo']; ?>">
         <input name="sqlWhere" type="hidden" id="sqlWhere" value="1" readonly="readonly">
         <input name="detalhes" type="hidden" id="detalhes" value="1" readonly="readonly">
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