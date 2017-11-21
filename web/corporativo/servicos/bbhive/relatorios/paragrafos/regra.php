<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");



	
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a ".("página")." para o tipo de ".$_SESSION['FluxoNome']." - BBHive.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	$onClick = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&relatorios=1|relatorios/index.php?menu=1|includes/colunaDireita.php?fluxosDireita=1&eventos=1','menuEsquerda|colCentro|colDireita');";
?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastro de par&aacute;grafos')</var>
<table width="98%%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Cadastro de par&aacute;grafos</strong></span>
      <label style="float:right; ">
     <a href="#@" onclick="return <?php echo $onClick; ?>">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
        <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td colspan="2" class="verdana_11" align="right" style="color:#999999">ambiente recomendado para Internet Explorer 6 ou superior&nbsp;</td>
  </tr>
</table>
<fieldset>
<legend class="verdana_11"><strong>Selecione o tipo</strong></legend>
    	<br>
		<?php require_once("arvore.php"); ?>
</fieldset>