<?php
if($_SERVER['QUERY_STRING']!=""){
	//Inicia sessão caso não esteja criada
	if(!isset($_SESSION)){session_start();}
	
	$getURL = base64_decode(base64_decode($_GET['idCred']));
	$getURL = explode("|",$getURL);
	
	$email	= $getURL[0];
	@$chave	= $getURL[1];
	
	//trata dados do email
	$email	= str_replace("email=","",$email);
	//trata dados da chave
	$chave	= str_replace("chave=","",$chave);
	
	//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
	//diretórios padrões
	$divisor = "web";
	$dirPadrao = explode($divisor,str_replace("\\","/",dirname(__FILE__)));
	$dirOnde = $dirPadrao[1];

	function devolveDiretorio($dirOnde){
		$dirOnde = str_replace("/servicos/","",$dirOnde);	//servicos
		$dirOnde = str_replace("/corporativo","",$dirOnde);	//corporativo
		$dirOnde = str_replace("/e-solution","",$dirOnde);	//e-solution
		$dirOnde = explode("/",$dirOnde);
		return $dirOnde[0];
	}
	//em qual aplicação estou======================================================================
	$apl_atual = devolveDiretorio($dirOnde);
	//monta diretório no datafiles=================================================================
	$dirDinamico = $dirPadrao[0]."web/datafiles/servicos/".$apl_atual."/cred_temp/";

	//página principal.
	$pagPrincipal = str_replace("includes/bbpass","",$dirOnde);
	
	//verifica se credencial existe		
	if(!file_exists($dirDinamico.$chave.".xml")){
		header("Location: ".$pagPrincipal."login.php?abandona=sim&msg=true");
		exit;
	}
	
	//recupera dados da credencial e redireciona para página principal da aplicação
		$objDOM = new DOMDocument();
		$objDOM->load($dirDinamico.$chave.".xml"); //coloca conteúdo no objeto
		$root = $objDOM->getElementsByTagName('credencial')->item(0);
		$_SESSION['MM_Email_Padrao'] = base64_decode($root->getAttribute("email"));
		$_SESSION['chaveAcesso'] 	 = base64_decode($root->getAttribute("chave"));

		//destrói a credencial
		unlink($dirDinamico.$chave.".xml");

		//header("Location: ".$pagPrincipal."login.php");
	?>
    <span style="font-family:verdana;font-size:11px;color:#0C0">Aguarde redirecionando...</span>
    <form name="autPacoteBBPASS" id="autPacoteBBPASS" method="post" action="<?php echo $pagPrincipal."login.php"; ?>" style="position:absolute">
     <input name="Email_Padrao" id="Email_Padrao" type="hidden" value="<?php echo $email; ?>" />
    </form>
	<script type="text/javascript">
		document.autPacoteBBPASS.submit();
    </script>
    <?php	
	//processo finalizado==========================================================================
}
?>