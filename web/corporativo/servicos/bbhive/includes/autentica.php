<?php  if(!isset($_SESSION)){session_start();}
/*
ESTRUTURA BÁSICA PADRÃO BBPASS - NÃO ALTERAR NENHUMA LINHA ENTRE OS BLOCOS PRINCIPAIS
*/
//faz inclusão do pacote de autenticação====================================================================
	//redireciona
	if(isset($_GET['abandona'])&&$_GET['abandona']=="sim"){
	 header("Location: ".$_SERVER['SCRIPT_NAME']);
	}
	//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
	$divisor = "web";//padrão letra minuscula
	$dirPadrao = explode($divisor,str_replace("\\","/",dirname(__FILE__)));
	$dirOnde = $dirPadrao[1];
	
	require_once($dirPadrao[0]."web/Connections/bbhive.php");//BBHIVE
	require_once($dirPadrao[0]."database/config/globalFunctions.php");//BBHIVE

	//em qual aplicação estou======================================================================
	$apl_atual 	 = resolveDiretorio($dirOnde);
	$dirDinamico = $dirPadrao[0]."web/".detalhaDiretorio($dirOnde)."servicos/".$apl_atual."/includes/autenticacao/.";

	//faz inclusão de todos os arquivos do diretório connections
		if ($handle = opendir($dirDinamico)) {
			$cont  = 0;
			$dif	= 0;
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(strtolower($file)!="thumbs.db"){	

		if($file=="verifica_autenticidade.php"){	
		  if($_SERVER['SCRIPT_NAME']!="/".detalhaDiretorio($dirOnde)."servicos/".$apl_atual."/login.php"){
			require_once("autenticacao/".$file);
		  }
		} else {
			//faz as inclusoes
			require_once("autenticacao/".$file);			
		}
						if ($cont == 250) { die;}	
					}
				}
			}
			closedir($handle);
		}
/*=========================================================================================================*/	
?>