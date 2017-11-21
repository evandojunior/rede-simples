<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a ".mysqli_fetch_assoc("página")." para o tipo de ".$_SESSION['FluxoNome']." - BBHive.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/

if(isset($_GET['bbh_pro_codigo'])){
	//veio do protocolo
	$onClick = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=".$_GET['bbh_pro_codigo']."','menuEsquerda|conteudoGeral')";
} elseif(isset($_GET['bbh_ati_codigo'])){
	//veio das atividades
	$onClick = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|tarefas/regra.php?bbh_ati_codigo=".$_GET['bbh_ati_codigo']."','menuEsquerda|conteudoGeral')";
} else {
	$onClick = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1|includes/colunaDireita.php?arquivosFluxos=1&equipeFluxos=1&arquivos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
}
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['FluxoNome']; ?>')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Anexar <?php echo($_SESSION['ProtNome']); ?> - <?php echo $_SESSION['FluxoNome']; ?></strong></span>
      <label style="float:right;">
     <a href="#" onclick="return <?php echo $onClick; ?>">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
        <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td colspan="2" class="verdana_11" align="right" style="color:#999999">ambiente recomendado para Internet Explorer 6 ou superior&nbsp;</td>
  </tr>
</table>
<?php
//se tiver setado nº de protocolo exibe o cabeçalho do mesmo
 if(isset($_GET['bbh_pro_codigo'])){	
	require_once('../../protocolo/cabecaProtocolo.php');
 }
?>

<fieldset>
	<legend class="verdana_11"><strong>Selecione o tipo</strong></legend>
    	<br>
		<?php require_once("../arvore.php"); ?>
</fieldset>