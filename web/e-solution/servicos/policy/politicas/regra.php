<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
	require_once("includes/gerencia_politicas.php");
	require_once("includes/gerencia_xml.php");
	
if (!isset($_SESSION)) {
  session_start();
}

 
//instância a classe
$condicao = new gerenciaPoliticas();

//verifica XMl
$xml 	= new gerenciaXML();
$nmFile = session_id();

	//Quem
	 $chk_quem="";
	 $condicao_quem="";
	 $pol_quem="";
	 
	 //Quando
	 $chk_quando="";
	 $condicao_quando="";
	 $pol_quando="";
	 
	 //Onde
	 $chk_onde="";
	 $condicao_onde="";
	 $pol_onde="";
	 
	 //Oque
	 $chk_oque="";
	 $condicao_oque="";
	 $pol_oque="";
	 
	 //Relevancia
	 $chk_relevancia="";
	 $condicao_relevancia="";
	 $pol_relevancia="";
	 
if($xml->verificaExiste($nmFile)==1){//só cria se não existir
	$doc = $xml->leituraXML($nmFile);
	
	$cond = $doc->getElementsByTagName('condicao')->item(0);
	//Quem
	 $chk_quem 		= $cond->getElementsByTagName('quem')->item(0)->getAttribute("publicado")=="1"?"1":"";//checar
	 $condicao_quem	= $cond->getElementsByTagName('quem')->item(0)->getAttribute("tipoCondicao");
	 $pol_quem		= utf8_decode($cond->getElementsByTagName('quem')->item(0)->getAttribute("valor"));
	 
	 //Quando
	 $chk_quando	 = $cond->getElementsByTagName('quando')->item(0)->getAttribute("publicado")=="1"?"1":"";//checar;
	 $condicao_quando= $cond->getElementsByTagName('quando')->item(0)->getAttribute("tipoCondicao");
	 $pol_quando	 = $cond->getElementsByTagName('quando')->item(0)->getAttribute("valor");
	 	if($pol_quando!=""){
			$valor = explode("|",$pol_quando);
			$data_inicio = $valor[0];
			$data_fim	 = $valor[1];
		}
	 
	 //Onde
	 $chk_onde		 = $cond->getElementsByTagName('onde')->item(0)->getAttribute("publicado")=="1"?"1":"";//checar;;
	 $condicao_onde  = $cond->getElementsByTagName('onde')->item(0)->getAttribute("tipoCondicao");
	 $pol_onde	 	 = utf8_decode($cond->getElementsByTagName('onde')->item(0)->getAttribute("valor"));
	 
	 //Oque
	 $chk_oque		 = $cond->getElementsByTagName('oque')->item(0)->getAttribute("publicado")=="1"?"1":"";//checar;;
	 $condicao_oque  = $cond->getElementsByTagName('oque')->item(0)->getAttribute("tipoCondicao");
	 $pol_oque	 	 = utf8_decode($cond->getElementsByTagName('oque')->item(0)->getAttribute("valor"));
	 
	 //Relevancia
	 $chk_relevancia	  = $cond->getElementsByTagName('relevancia')->item(0)->getAttribute("publicado")=="1"?"1":"";//checar;
	 $condicao_relevancia = $cond->getElementsByTagName('relevancia')->item(0)->getAttribute("tipoCondicao");
	 $pol_relevancia	  = utf8_decode($cond->getElementsByTagName('relevancia')->item(0)->getAttribute("valor"));
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="../includes/boxover.js"></script>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/functions.js"></script>
<script type="text/javascript">
function Popula(valor){
		document.getElementById(valor).className = "ativo";
}

function Desativa(valor){
		document.getElementById(valor).className = "comum";
}
</script>
</head>

<body >
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
            <td style="border-bottom:1px solid #CCCCCC;" width="85%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Cadastro de Pol&iacute;ticas</strong></td>
            <td style="border-bottom:1px solid #CCCCCC;" width="15%" colspan="-2" align="center" valign="middle" class="verdana_11"><span class="verdana_11_bold"><a href='/e-solution/servicos/policy/politicas/index.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>'>.: Voltar :.</a></span></td>
          </tr>
          </table>
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
              
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="21%" valign="top" class="verdana_11" style="border-right:dashed 1px #999999;"><?php require_once("../includes/cabecalhoaplvert.php"); ?></td>
                    <td width="78%" height="400" align="left" valign="top" class="verdana_11">
<?php if(isset($_GET['pol_pol_codigo'])){ ?>
 <?php require_once("includes/cabeca.php"); ?>
<br />
<?php }?>                   
<form name="form1" id="form1" method="get" action="regra2.php">
<table width="590" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="25" colspan="3" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Escolha os campos para o filtro</strong>
    
    </td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="right"  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
    <td  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
  </tr>

  <tr>
    <td width="4%" height="27" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
    	<?php echo $condicao->checkBox("chk_quem", $chk_quem); ?>
    </label></td>
    <td width="14%" height="22" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><input type="hidden" name="quemOk" id="quemOk" />
      Quem :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
    	<?php echo $condicao->comboCondicao("condicao_quem", $condicao_quem);?>
        <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'quem', 'quemdet=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a> 
        
      <label id="quem">
      	<?php echo $condicao->inputPadrao("pol_quem", $pol_quem, " size='40'"); ?>
      </label>      </td>
  </tr>
  <tr>
    <td width="4%" height="27" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
    	<?php echo $condicao->checkBox("chk_quando", $chk_quando); ?>
    </label></td>
    <td height="22" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><input type="hidden" name="quandoOk" id="quandoOk" />
      Quando :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
<div style='margin-top:0px;; line-height:25px; margin-right:5px;'>          
	<label>&nbsp;<strong>Inicio :</strong>
	&nbsp;<?php 
		$dIni = isset($data_inicio)?$data_inicio:date("d/m/Y");
		$dFim = isset($data_fim)?$data_fim:date("d/m/Y");
	echo $condicao->inputPadrao("data_inicio", $dIni, "onkeypress='MascaraData(event, this)' maxlength='10' size='10'"); ?>
      <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.data_inicio,'dd/mm/yyyy',this)"/>
	</label>

<label>&nbsp;&nbsp;<strong>Final :</strong>&nbsp;<?php echo $condicao->inputPadrao("data_fim", $dFim, "onkeypress='MascaraData(event, this)' maxlength='10' size='10'"); ?>
      <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.data_fim,'dd/mm/yyyy',this)"/>
</label>
</div>
    </td>
  </tr>
  <tr>
    <td width="4%" height="27" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
    	<?php echo $condicao->checkBox("chk_onde", $chk_onde); ?>
    </label></td>
    <td height="22" align="right" bgcolor="#F7F7F7" style="border-bottom:dotted 1px #333333;"> <input type="hidden" name="ondeOk" id="ondeOk" />
      Onde :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboCondicao("condicao_onde", $condicao_onde);?>
      <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'onde', 'ip=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a>
        <label id="onde">
        	<?php echo $condicao->inputPadrao("pol_onde", $pol_onde, " size='40'"); ?>
        </label>    </td>
  </tr>
  <tr>
    <td width="4%" height="27" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
    	<?php echo $condicao->checkBox("chk_oque", $chk_oque); ?>
    </label></td>
    <td height="22" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><input type="hidden" name="oqueOk" id="oqueOk" />
      O qu&ecirc; :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboCondicao("condicao_oque", $condicao_oque);?>
      <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'oque', 'acao=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a>
        <label id="oque">
        	<?php echo $condicao->inputPadrao("pol_oque", $pol_oque, " size='40'"); ?>
        </label>    </td>
  </tr>
  <tr>
    <td width="4%" height="27" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
    	<?php echo $condicao->checkBox("chk_relevancia", $chk_relevancia); ?>
    </label></td>
    <td height="22" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><input type="hidden" name="relevanciaOk" id="relevanciaOk" />
      Relev&acirc;ncia :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboCondicao("condicao_relevancia", $condicao_relevancia);?>
	  <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'relevancia', 'relevanciadet=true');"><img src="../images/combo.gif" width="18" height="17" border="0" align="absmiddle"></a>
        <label id="relevancia">
       	  <?php echo $condicao->inputPadrao("pol_relevancia", $pol_relevancia, " size='40'"); ?>
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
    <td align="right" bgcolor="#FFFFFF">
    <?php if(isset($_GET['pol_pol_codigo'])){ ?>
      <input name="pol_pol_codigo" type="hidden" id="pol_pol_codigo" value="<?php echo $_GET['pol_pol_codigo']; ?>">
    <?php } ?>
      <input name="id_file" type="hidden" id="id_file" value="<?php echo $nmFile; ?>" />
      <input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $_GET['pol_apl_codigo']; ?>">
      <input name="button" type="button" class="back_input" id="button2" value="Cancelar" style="cursor:pointer" onclick="javascript:history.go(-1);"/>
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