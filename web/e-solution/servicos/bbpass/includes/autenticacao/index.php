<?php
 //Inicia sessão caso não esteja criada
 if(!isset($_SESSION)){session_start();}
 
	//redireciona
	if(isset($_GET['abandona'])&&$_GET['abandona']=="sim"){
	 header("Location: ".$_SERVER['SCRIPT_NAME']);
	}
	
 //VERIFICA SE TEM SESSÃO DO CAMINHO CRIADA
 function verificaSessao(){
	if(!isset($_SESSION['caminhoFisico'])){
		include(str_replace("\\","/",$_SERVER['DOCUMENT_ROOT'])."/Connections/bbpass.php");
		$_SESSION['caminhoFisico'] = $caminhoFisico;
	}
 }
 verificaSessao();
 
 //INCLUSÃO DO ARQUIVO DE CONEXÃO - responsável pela conexão com o banco de dados
 include($_SESSION['caminhoFisico']."/Connections/bbpass.php");

 // FUNÇÕES GLOBAIS
 include($_SESSION['caminhoFisico']."/../database/config/globalFunctions.php");

 //INCLUSÃO DO ARQUIVO AUTENTICA - responsável pelo login/senha do usuário
 include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/autenticacao/autentica.php");
 
 //INCLUSÃO DO ARQUIVO VERIFICA - responsável por validar se o usuário está logado
  //tela de login não precisa ser verificada constantemente
  if($_SERVER['SCRIPT_NAME']!="/e-solution/servicos/bbpass/login.php"){
	include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/autenticacao/verifica_autenticidade.php");
  }
  
 //INCLUSÃO DO ARQUIVO LOGOUT - responsável pela destruição de todas as sessões do sistema
 include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/autenticacao/logout.php");
?>