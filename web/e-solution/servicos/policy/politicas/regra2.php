<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
	require_once("includes/gerencia_politicas.php");
	require_once("includes/gerencia_xml.php");
	
if (!isset($_SESSION)) {
  session_start();
}

//XML
$xml 	= new gerenciaXML();
$nmFile = $_GET['id_file'];

if($xml->verificaExiste($nmFile)==0){//só cria se não existir
	$doc = $xml->criaXML($nmFile);
	$xml->gravaArquivo($nmFile, $doc);//grava XML

	header("Location: regra2.php?".$_SERVER['QUERY_STRING']);
} else { //leitura
	//leitura
	$doc = $xml->leituraXML($nmFile);
	//atualizamos o XML com informações do GET
	require_once("includes/atualiza_condicao.php");
	//atualiza arquivo físico
	$doc = $xml->gravaArquivo($nmFile, $doc);
}
$doc = $xml->leituraXML($nmFile);
//$xml->exibeTela($doc);
//exit;

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
	
	$cond = $doc->getElementsByTagName('ordenacao')->item(0);
	//Quem
	 $chk_quem 		= $cond->getElementsByTagName('quem')->item(0)->getAttribute("publicado")=="1"?"1":"";//checar
	 $condicao_quem	= $cond->getElementsByTagName('quem')->item(0)->getAttribute("tipoCondicao");
	 $pol_quem		= utf8_decode($cond->getElementsByTagName('quem')->item(0)->getAttribute("valor"));
	 
	 //Quando
	 $chk_quando	 = $cond->getElementsByTagName('quando')->item(0)->getAttribute("publicado")=="1"?"1":"";//checar;
	 $condicao_quando= $cond->getElementsByTagName('quando')->item(0)->getAttribute("tipoCondicao");
	 $pol_quando	 = $cond->getElementsByTagName('quando')->item(0)->getAttribute("valor");
	 
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
 //instância a classe
	$condicao = new gerenciaPoliticas();
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
            <td style="border-bottom:1px solid #CCCCCC;" width="15%" colspan="-2" align="center" valign="middle" class="verdana_11"><span class="verdana_11_bold"><a href='#' onclick="javascript:history.go(-1);">.: Voltar :.</a></span></td>
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
                    <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
                      <tr>
                        <td height="25" colspan="2" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Campos selecionados</strong></td>
                      </tr>
<?php 
//varre XML
$xml 		= $doc->getElementsByTagName('politica')->item(0);
$condicoes	= $xml->getElementsByTagName('condicao')->item(0);
$contador	= 0;

	 foreach($condicoes->childNodes as $Condicao){
	   if($Condicao->getAttribute("publicado")=="1"){ 
     	  $contador++;
		  
		   $valor = utf8_decode($Condicao->getAttribute("valor"));
		   
			 if($Condicao->getAttribute("campoData")=="1"){
				 $valor = explode("|",$valor);
				 $valor = $valor[0]." à ".$valor[1];
			 }
?>
                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><strong><?php echo utf8_decode($Condicao->getAttribute("nome")); ?></strong>&nbsp;:&nbsp;</td>
                        <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $valor; ?></td>
                      </tr>
<?php } 
	 }
     if($contador==0){ ?>
                      <tr>
                        <td height="20" colspan="2" align="center" bgcolor="#FFFFFF">Todos os campos adicionados</td>
                        </tr>
<?php } ?>
                    </table><br />
                    <form action="regra3.php" method="get" enctype="application/x-www-form-urlencoded" name="form1" id="form1">
                      <table width="590" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
                        <?php $Ordem = "1"; ?>
                          <tr>
                            <td height="25" colspan="3" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg" style="border-bottom:dotted 1px #333333;"><strong>Escolha a ordena&ccedil;&atilde;o dos campos</strong></td>
                            </tr>
                          <tr>
                            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->checkBox("chk_quem", $chk_quem); ?></td>
                            <td width="21%" height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboNumerico("order_quem", "5", "1", $condicao_quem); ?>
                              Quem :&nbsp;</td>
                            <td width="75%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboOrdenacao("estr_quem", $pol_quem); ?></td>
                          </tr>
                          <tr>
                            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->checkBox("chk_quando", $chk_quando); ?></td>
                            <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboNumerico("order_quando", "5", "2", $condicao_quando); ?>
                              Quando :&nbsp;</td>
                            <td width="75%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboOrdenacao("estr_quando", $pol_quando); ?></td>
                          </tr>
                          <tr>
                            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->checkBox("chk_onde", $chk_onde); ?></td>
                            <td height="20" align="right" bgcolor="#F7F7F7" style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboNumerico("order_onde", "5", "3", $condicao_onde); ?>
                              Onde :&nbsp;</td>
                            <td width="75%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboOrdenacao("estr_onde", $pol_onde); ?></td>
                          </tr>
                          <tr>
                            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->checkBox("chk_oque", $chk_oque); ?></td>
                            <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboNumerico("order_oque", "5", "4", $condicao_oque); ?>
                              O qu&ecirc; :&nbsp;</td>
                            <td width="75%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboOrdenacao("estr_oque", $pol_oque); ?></td>
                          </tr>
                          <tr>
                            <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->checkBox("chk_relevancia", $chk_relevancia); ?></td>
                            <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboNumerico("order_relevancia", "5", "5", $condicao_relevancia); ?>
                              Relev&acirc;ncia :&nbsp;</td>
                            <td width="75%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $condicao->comboOrdenacao("estr_relevancia", $pol_relevancia); ?></td>
                          </tr>
                          <tr>
                            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            <td bgcolor="#FFFFFF"><input name="id_file" type="hidden" id="id_file" value="<?php echo $nmFile; ?>" /></td>
                          </tr>
                          <tr>
                            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            <td align="right" bgcolor="#FFFFFF">
    <?php if(isset($_GET['pol_pol_codigo'])){ ?>
      <input name="pol_pol_codigo" type="hidden" id="pol_pol_codigo" value="<?php echo $_GET['pol_pol_codigo']; ?>">
    <?php } ?>
                            <input name="id_file2" type="hidden" id="id_file2" value="<?php echo $_GET['id_file']; ?>" />
                              <input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $_GET['pol_apl_codigo']; ?>" />
                              <input name="button" type="button" class="back_input" id="button2" value="Voltar" style="cursor:pointer" onclick="javascript:history.go(-1);"/>
<input name="Submit" type="submit" class="back_input" id="button" value="Avancar" style="cursor:pointer" />                              
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