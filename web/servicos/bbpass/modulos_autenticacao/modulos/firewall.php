<?php  if(!isset($_SESSION)){session_start();}
//conexão com banco de dados
$dirLock = str_replace("\\","/",dirname(__FILE__));
$dirLock = explode("web", $dirLock);
$rootPath = $dirLock[0]."web";
$caminhoLock = $rootPath."/Connections/bbpass.php";
require_once($caminhoLock);

// FUNÇÕES GLOBAIS
include($rootPath."/../database/config/globalFunctions.php");

function verificaAcesso($database_bbpass, $bbpass,$Ip){
	$query_Login = "SELECT * FROM bbp_adm_lock_firewall WHERE bbp_adm_lock_fir_ip='$Ip'";
    list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);

		if($totalRows_Login>0){
			$_SESSION['MM_Email_Padrao'] = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:"freepass@bbpass";
    		$_SESSION['MM_BBpass_Codigo']= isset($_SESSION['MM_BBpass_Codigo'])?$_SESSION['MM_BBpass_Codigo']:$row_Login['bbp_adm_lock_fir_codigo'];	
		}
	return $totalRows_Login;
}
	
 @$idLock = isset($_GET['id'])?$_GET['id']:$idLock;
 @$idAplic;
 
 if(isset($_POST['autenticaFirewall'])){
 $idAplicacao= $_POST['idAplicacao'];
  $idLock	 = $_POST['idLock'];
	$Ip	 	 = $_POST['ipCliente'];
	$result  = verificaAcesso($database_bbpass, $bbpass, $Ip);
	$liberado= 0;

		if($result==1){
			//efetua a baixa dos locks na sessão da aplicação
			include($dirLock[0]."web/servicos/bbpass/includes/function.php");
			$_SESSION['EmailTratado'] = trataEmail($_SESSION['MM_Email_Padrao']);
			
			include($dirLock[0]."web/servicos/bbpass/perfil/gerencia_perfil.php");
			$usuario = new perfil();//instância classe
			$usuario->atualizaLogon($database_bbpass, $bbpass);
			
			//monta XML de sessão para autenticação das demais aplicações
			$idLockLiberado = $idLock;
			include($dirLock[0]."web/servicos/bbpass/credencial/gerencia_credencial/libera_credencial.php");
			?>
				<span style="font-family:verdana;font-size:11px;color:#0C0">Aguarde redirecionando...</span>
				<script type="text/javascript">
				  <?php if($idAplicacao==""){ ?>
						window.top.window.limpaMsgPadrao("<?php echo $result; ?>");
						window.top.window.voltarURL("/servicos/bbpass/home.php");
				  <?php } else { ?>		
						location.href="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/autenticaRemoto.php?idApl=<?php echo @$idAplicacao; ?>";
				 <?php } ?>
				</script>
			<?php
			exit;
		}
 }
 
  if($_SERVER['SCRIPT_NAME']=="/servicos/bbpass/modulos_autenticacao/autenticaRemoto.php"){	
	$liberado = 0;
  }
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/includes/autenticacao.css">
<?php  

 if(@!array_key_exists($idLock,$_SESSION['modulosLiberados'])){
	require_once("firewall/formulario.php"); 
 } else { 
    //redireciona para página de sucesso
 	echo "<div class='sucesso' align='center'>Parabéns, credencial liberada.</span>";?>
	<script type="text/javascript">
		window.top.window.limpaMsgPadrao("1");
	    window.top.window.voltarURL("/servicos/bbpass/home.php");
	</script>
<?php }?>