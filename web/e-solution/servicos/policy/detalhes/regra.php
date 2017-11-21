<?php
		require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

//--
$cd = $_GET['pol_apl_codigo']; 
 //--AJAX
			 $openAjax = 'OpenAjaxPostCmd("../aplicacoes/dados.php","ip_'.$cd.'","?pol_apl_codigo='.$cd.'","Aguarde carregando...","ip_'.$cd.'",2,2);';
//--
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/assinatura_digital/assinatura.js"></script>
<script type="text/javascript" src="../includes/boxover.js"></script>
<script type="text/javascript" src="../includes/functions.php"></script>
<script type="text/javascript">
function Popula(valor){
		document.getElementById(valor).className = "ativo";
}

function Desativa(valor){
		document.getElementById(valor).className = "comum";
}

<?php if(isset($_GET['ass'])){ ?>
function downloadAssinado(){
	location.href="/e-solution/servicos/policy/includes/assinatura_digital/mensagem.php?<?php echo $_SERVER['QUERY_STRING']; ?>&id=<?php echo $_GET['impressaodet']; ?>";	
}
<?php }?>
function checaAssinatura(){
	//markDocument(0, 'checked');
}
</script>
</head>

<body onload="coletaDados();<?php if(isset($_GET['ass'])){ ?>downloadAssinado();<?php }?><?php if(isset($_GET['impressao'])){ ?>checaAssinatura();<?php }?>" >
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
            			   
						   <?php if(isset($_GET["quem"])){
								echo "Quem utilizou a aplica&ccedil;&atilde;o";
						    } else if(isset($_GET["oquefez"])){
								echo "O que foi feito na aplica&ccedil;&atilde;o";
							} else if(isset($_GET["onde"])){
								echo "De onde usaram a aplica&ccedil;&atilde;o";
							} else if(isset($_GET["relevancia"])){
								echo "Quais as relev&acirc;ncias das a&ccedil;&otilde;es";
							} else if(isset($_GET["quando"])){
								echo "Calend&aacute;rio Mensal";
							} else if(isset($_GET["quando_dias"])){
								echo "Calend&aacute;rio Di&aacute;rio";
							} else if(isset($_GET['detalhes'])){
								echo "Relat&oacute;rio detalhado";
							} else if(isset($_GET['impressao'])){
								echo "Informa&ccedil;&otilde;es do evento";
							} else if(isset($_GET['pol_pol_codigo'])){
								echo "Pol&iacute;ticas do evento";
							} else {
								echo "Houve um erro na aplica&ccedil;&atilde;o, contate o administrador";
							}
							?>	   
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
					  <?php if(isset($_GET["quem"])){
								require_once("quem.php");
						  } else if(isset($_GET["oquefez"])){
						  		require_once("oquefez.php");
							} else if(isset($_GET["onde"])){
								require_once("onde.php");
							} else if(isset($_GET["relevancia"])){
								require_once("relevancia.php");
							} else if(isset($_GET["quando"])){
								require_once("quando.php");
							} else if(isset($_GET["quando_dias"])){
								require_once("quando_dias.php");
							} else if(isset($_GET["detalhes"])){
								require_once("detalhes.php");
							} else if(isset($_GET['impressao'])){
								require_once("impressao.php");
							} else if(isset($_GET['pol_pol_codigo'])){
								require_once("../politicas/lista.php");
							} else {
								echo "Houve um erro na aplica&ccedil;&atilde;o, contate o administrador.";
							}					   
						  ?></td>
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
<script type="text/javascript">
	function coletaDados(){
		<?php echo $openAjax; ?>	
	}
</script>
</body>
</html>