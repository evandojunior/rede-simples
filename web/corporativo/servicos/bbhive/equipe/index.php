<?php
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//MEUS DADOS
		$query_strPerfil = "SELECT * FROM bbh_usuario WHERE bbh_usu_codigo =".$_SESSION['usuCod'];
        list($strPerfil, $row_strPerfil, $totalRows_strPerfil) = executeQuery($bbhive, $database_bbhive, $query_strPerfil);

//MEU DEPARTAMENTO
		$query_strDpto = "SELECT bbh_dep_codigo FROM bbh_usuario WHERE bbh_usu_codigo =".$_SESSION['usuCod'];
        list($strDpto, $row_strDpto, $totalRows_strDpto) = executeQuery($bbhive, $database_bbhive, $query_strDpto);

//DADOS PRESTADORES DE SERVIÇOS

//DADOS TOMADORES DE SERVIÇOS


/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a página inicial de equipes - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/ 
 
?>
<var style="display:none">txtSimples('tagPerfil', 'Equipe')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td width="420" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><img src="/corporativo/servicos/bbhive/images/equipe-pequeno.gif" alt="" width="23" height="23" align="absmiddle" /> <strong class="verdana_11"><?php echo $_SESSION['EquipeNome']; ?></strong>
    <label></label></td>
  </tr>
  <tr>
    <td class="verdana_11">&nbsp;</td>
  </tr>
</table>
<?php if($_GET['chefe']==1){ 
  require_once('chefe.php');
  echo "<br />";
} ?>
<?php if($_GET['subordinados']==1){ 
  require_once('subordinado.php');
  echo "<br />";
} ?>
<?php if($_GET['tomadores']==1){ 
  //require_once('tomadores.php');
  echo "<br />";
} ?>
<?php if($_GET['prestadores']==1){ 
  //require_once('prestadores.php');
  echo "<br />";
} ?>

<?php if(isset($_GET['todosEmpresa'])){ 
  require_once('empresa.php');
  echo "<br />";
} ?>