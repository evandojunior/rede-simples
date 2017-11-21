<?php
//conexão com banco de dados
$dirLock = str_replace("\\","/",dirname(__FILE__));
$dirLock = explode("web", $dirLock);
$rootPath = $dirLock[0]."web";
$caminhoLock = $rootPath."/Connections/bbpass.php";
require_once($caminhoLock);

// FUNÇÕES GLOBAIS
include($rootPath."/../database/config/globalFunctions.php");

function verificaAcesso($database_bbpass, $bbpass, $Email, $Chave, $ipAcessoSMS){
	$query_Login = "SELECT * FROM bbp_adm_lock_sms WHERE bbp_adm_lock_sms_email='$Email'";
    list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);

	if($totalRows_Login>0){	
  	 $totalRows_Login = 0;
	//compara as chaves
		$bbp_adm_lock_sms_chave  = $row_Login['bbp_adm_lock_sms_chave'];
		
		if(($Chave==$bbp_adm_lock_sms_chave)&&($Chave!='0')){
			//apaga a chave que esta gravada na base - UPDATE para 0
			 $updateSQL = "UPDATE bbp_adm_lock_sms SET bbp_adm_lock_sms_chave = '0', bbp_adm_lock_sms_acesso='".date('Y-m-d H:i:s')."' WHERE bbp_adm_lock_sms_codigo=".$row_Login['bbp_adm_lock_sms_codigo'];

             list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);

			$_SESSION['MM_Email_Padrao'] = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$row_Login['bbp_adm_lock_sms_email'];
			$_SESSION['MM_BBpass_Codigo']= isset($_SESSION['MM_BBpass_Codigo'])?$_SESSION['MM_BBpass_Codigo']:$row_Login['bbp_adm_lock_sms_codigo'];	
			$totalRows_Login = 1;
		} else {
			require_once("sms/enviaSMS.php");//ENVIA MENSAGEM PARA O USUÁRIO, ENVIA SMS
			echo '<link rel="stylesheet" type="text/css" href="'.$_SESSION['EndURL_BBPASS'].'/servicos/bbpass/includes/autenticacao.css">';
			require_once("sms/formulario.php");
			exit;
		}
	} else {//Não tem EMAIL - MENSAGEM DE ERRO
			$erro = 1;
			echo '<link rel="stylesheet" type="text/css" href="'.$_SESSION['EndURL_BBPASS'].'/servicos/bbpass/includes/autenticacao.css">';
			require_once("sms/formulario.php");
			exit;
	}
	return $totalRows_Login;
}

 @$idLock = isset($_GET['id'])?$_GET['id']:$idLock;
 @$idAplic;
 
 if(isset($_POST['autenticaSMS'])){
 $idAplicacao= $_POST['idAplicacao'];
  $idLock	 = $_POST['idLock'];
	$Email	 = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$_POST['bbp_adm_lock_sms_email'];
	$Chave	 = $_POST['bbp_adm_lock_sms_chave'];
	$result  = verificaAcesso($database_bbpass, $bbpass, $Email, $Chave, $ipAcessoSMS);
	$liberado= 0;
		if($result==1){
			//efetua a baixa dos locks na sessão da aplicação
			include($dirLock[0]."web/servicos/bbpass/includes/function.php");
			$_SESSION['EmailTratado'] = trataEmail($Email);

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
  }else{
	$liberado = 0;  
  }
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/includes/autenticacao.css">
<?php  
 if($liberado==0){ 
	require_once("sms/formulario.php"); 
 } else { 
    //redireciona para página de sucesso
 	echo "<div class='sucesso' align='center'>Parabéns, credencial liberada.</span>";?>
	<script type="text/javascript">
	    window.top.window.voltarURL("/servicos/bbpass/home.php");
	</script>
<?php }?>