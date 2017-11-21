<?php
	/* Comentado para evitar conflito no rotatividade 
	require_once('../../../../Connections/policy.php');
	*/
	require_once('functions.php');
	
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){

  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "/e-solution/servicos/policy/login.php";
  if ($logoutGoTo) {
    //header("Location: $logoutGoTo");
	?>
    <script>location.href="<?php echo $logoutGoTo; ?>";</script>
    <?php
    exit;
  }
}
?>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/functions.js"></script>
<div id="menu">
    <ul style="margin-left:-40px;">
    <?php if(isset($_SESSION['MM_Policy_Codigo'])){ ?>
            <li><a href="/e-solution/servicos/policy/aplicacoes/index.php">Principal</a></li>
            <li><a href="/e-solution/servicos/policy/perfil/index.php">Perfis</a></li>
            <li><a href="/e-solution/servicos/policy/configuracao/index.php">Configura&ccedil;&otilde;es</a></li>
    <?php } ?>       
            <li><a href="<?php echo $logoutAction ?>" title="Clique para fechar a sess&atilde;o do sistema">Sair</a></li>
<?php if(isset($_SESSION['MM_Policy_Codigo'])){ ?>
            <li>
             <?php 
			 $caminho = dirname(__FILE__);
			 $caminho = explode("policy",str_replace("\\","/",$caminho));
			 include($caminho[0]."policy/includes/busca_evento.php");
			?>
            </li>
    <?php } ?> 
  </ul>
</div>
