<?php  if(!isset($_SESSION)){session_start();}
//conexão com banco de dados
$dirLock = str_replace("\\","/",dirname(__FILE__));
$dirLock = explode("web", $dirLock);
$rootPath = $dirLock[0]."web";
$caminhoLock = $rootPath."/Connections/bbpass.php";

 $ondeJar = $_SESSION['EndURL_BBPASS']."/servicos/bbpass/modulos_autenticacao/modulos/ass_digital/";
 
require_once($caminhoLock);

// FUNÇÕES GLOBAIS
include($rootPath."/../database/config/globalFunctions.php");

function verificaAcesso($database_bbpass, $bbpass, $cert, $key, $email){
	//chama arquivo responsável pelo tratamento dos dados
	require_once("ass_digital/function.php");

	$query_Login = "SELECT * FROM bbp_adm_lock_assinatura WHERE bbp_adm_lock_ass_cpf=$bbp_adm_loc_ass_cpf and bbp_adm_lock_ass_email='$email'";
    list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);

		if($totalRows_Login>0){
			$_SESSION['MM_Email_Padrao'] = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$row_Login['bbp_adm_lock_ass_email'];
    		$_SESSION['MM_BBpass_Codigo']= isset($_SESSION['MM_BBpass_Codigo'])?$_SESSION['MM_BBpass_Codigo']:$row_Login['bbp_adm_lock_ass_codigo'];	
		}
	return $totalRows_Login;
}
		
 @$idLock = isset($_GET['id'])?$_GET['id']:$idLock;
 @$idAplic;
 
 if(isset($_POST) && isset($_POST['cert']) && (strlen($_POST['cert'])>15)){
 $idAplicacao= $_POST['idAplicacao'];
  $idLock	 = $_POST['idLock'];
  $cert 	 = $_POST['cert'];
  $key 	     = $_POST['response'];
  $email	 = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$_POST['bbp_adm_lock_ass_email'];
		
	$result  = verificaAcesso($database_bbpass, $bbpass, $cert, $key, $email);
	$liberado= 0;

		if($result==1){
			//efetua a baixa dos locks na sessão da aplicação
			include($dirLock[0]."web/servicos/bbpass/includes/function.php");
			$_SESSION['EmailTratado'] = trataEmail($email);
			
			include($dirLock[0]."web/servicos/bbpass/perfil/gerencia_perfil.php");
			$usuario = new perfil();//instância classe
			
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
  }else{
	$liberado = 0; 
  }
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/includes/autenticacao.css">
<?php  
 if(@!array_key_exists($idLock,$_SESSION['modulosLiberados'])){ 
    echo '<script type="text/javascript">window.top.window.limpaMsgPadrao('.$liberado.');</script>';
	require_once("ass_digital/formulario.php");
	exit;
 } else { 
    //redireciona para página de sucesso
 	echo "<div class='sucesso' align='center'>Parabéns, credencial liberada.</span>";?>
	<script type="text/javascript">
		window.top.window.limpaMsgPadrao("1");
	    window.top.window.voltarURL("/servicos/bbpass/home.php");
	</script>
    <?php
 }?>