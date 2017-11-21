<?php
class gerenciaXML{
	public $docXML;
	public $caminhoObjXML;
	
	//responsável pela criação de qualquer XML de locks BBPASS
	public function criaXML(){
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel 

		$root = $doc->createElement('modulos_autenticacao');//cria elemento pai de todos
		$doc->appendChild($root);//adiciona noh no objeto XML
		return $doc;
	}
	
	//responsável pela leitura completa do XML de locks BBPASS
	public function leXML($nmSessao,$caminhoObjXML){
		$objDOM = new DOMDocument();
		$objDOM->load($caminhoObjXML.$nmSessao.".xml"); //coloca conteúdo no objeto
		
		$root = $objDOM->getElementsByTagName('modulos_autenticacao')->item(0);
		$qtLoc= $root->childNodes->length;
					
			if($qtLoc>0){
				$_SESSION['modulosLiberados'] = array();
				foreach($root->childNodes as $cadaLock){
					if($cadaLock->getAttribute("autenticado")=="1"){
						$_SESSION['modulosLiberados'][$cadaLock->getAttribute("id")]=true;
					}
				}
			}
	}
	
	//responsável pela leitura completa do XML de locks BBPASS
	public function destroiLockXML($nmSessao,$caminhoObjXML,$idLockLiberado){
	    global $database_bbpass, $bbpass, $global;
		//A LÓGICA INICIAL ESTA CORRETA PORÉM FUNCIONANDO DE FORMA ERRADA, UMA VEZ QUE EU SAIO DE QUALQUER APLICAÇÃO MINHA CREDENCIAL É DESTRUÍDA, ASSIM EVITO QUALQUER INCONCISTÊNCIA FAZENDO COM QUE NO PRÓXIMO LOGON EU SEJA OBRIGADO A CRIAR NOVA CREDÊNCIAL
		$this->apagaXML($caminhoObjXML, $nmSessao);

		//======================================================================================================
		//CRIA XML PARA O PRÓXIMO LOGON=================================================================
		//caminho do módulo e-solution
        include(__DIR__ . "/../../../../Connections/bbpass.php");
		require_once($_SESSION['caminhoFisico']."/servicos/bbpass/modulo/gerencia_modulo.php");
		$modulo 				= new Modulo();//instância classe de módulos
		$modulosCadastrados		= $modulo->adicionaArray($database_bbpass, $bbpass);
			
			$nvXML = $this->criaXML();//cria XML
			//monta nohs do XML
			$arrayModulo = $modulosCadastrados;//Lista os locks cadastrados e move para o XML
			 if(count($arrayModulo)>0){//só adiciona se tiver resultados
				//$nvXML = $this->adicionaModulo($nvXML, $arrayModulo);//verifica os locks
				$nvXML = $this->adicionaLogout($nvXML, $arrayModulo);
			 }
			$this->gravaXML($nvXML, $nmSessao, $caminhoObjXML);//grava em diretório físico
		//==============================================================================================
	}
	
	//responsével pela escrita completa do XML de locks BBPASS
	public function escreveXML($nmSessao,$caminhoObjXML,$idLockLiberado){
		$objDOM = new DOMDocument();
		$objDOM->load($caminhoObjXML.$nmSessao.".xml"); //coloca conteúdo no objeto
		$root = $objDOM->getElementsByTagName('modulos_autenticacao')->item(0);
		$qtLoc= $root->childNodes->length;
			
			if($qtLoc>0){
				foreach($root->childNodes as $cadaLock){
					if($cadaLock->tagName=="mod_".$idLockLiberado){
						$cadaLock->setAttribute("autenticado","1");
					}
				}
			 $objDOM->appendChild($root);//adiciona no objeto principal
			 $this->gravaXML($objDOM, $nmSessao, $caminhoObjXML);//grava em diretório físico
			}
	}
	
	//verifica sessão do xml
	public function sessaoXML($sessaoCapturada,$nmSessao,$caminhoObjXML){
		$objDOM = new DOMDocument();
		$objDOM->load($caminhoObjXML.$nmSessao.".xml"); //coloca conteúdo no objeto
		$root = $objDOM->getElementsByTagName('modulos_autenticacao')->item(0);
			if($root->getAttribute("chave")!=$sessaoCapturada){//zero a sessão caso seja diferente
				$root->setAttribute("chave",$sessaoCapturada);
				$root->setAttribute("momento",@date("d/m/Y H:i:s"));
				
				 $objDOM->appendChild($root);//adiciona no objeto principal
				 $this->gravaXML($objDOM, $nmSessao, $caminhoObjXML);//grava em diretório físico
				 $this->destroiLockXML($nmSessao,$caminhoObjXML,"");//destrói os locks
			}
	}
	
	//cria nohs com locks no xml
	public function adicionaModulo($nvXML, $arrayModulo){
		$root = $nvXML->getElementsByTagName('modulos_autenticacao')->item(0);
		$root->setAttribute("momento",date("d/m/Y H:i:s"));//grava o atributo
		$root->setAttribute("chave",session_id());//grava o atributo
		
		for($a=0;$a<count($arrayModulo); $a++){	
			$dados = explode("|",$arrayModulo[$a]);//recupera os dados do módulo
			$cadaModulo = $nvXML->createElement('mod_'.$dados[0]);//grava o ID como nome do nó
			$cadaModulo->setAttribute("id",$dados[0]);//grava o atributo Id
			$cadaModulo->setAttribute("nomeModulo",($dados[1]));//grava o atributo nome
			
			//TRATAMENTO PARA FREEPASS
			  $aut = 0;	
				if(trim(strtolower($dados[1])) == "freepass"){// || $_SESSION['idLockLoginSenha']==$dados[0]){
					$aut = 1;
				}
			
			$cadaModulo->setAttribute("autenticado",$aut);//grava o atributo nome
			
			$root->appendChild($cadaModulo);//adiciona no objeto principal quando o mesmo rodar
		}

	  $nvXML->appendChild($root);//adiciona no objeto principal
	  return $nvXML;//retorna objeto para o solicitante
	}
	
	//Reautenticação - LOGOUT
	public function adicionaLogout($nvXML, $arrayModulo){
		$root = $nvXML->getElementsByTagName('modulos_autenticacao')->item(0);
		$root->setAttribute("momento",date("d/m/Y H:i:s"));//grava o atributo
		$root->setAttribute("chave",session_id());//grava o atributo
		
		for($a=0;$a<count($arrayModulo); $a++){	
			$dados = explode("|",$arrayModulo[$a]);//recupera os dados do módulo
			$cadaModulo = $nvXML->createElement('mod_'.$dados[0]);//grava o ID como nome do nó
			$cadaModulo->setAttribute("id",$dados[0]);//grava o atributo Id
			$cadaModulo->setAttribute("nomeModulo",($dados[1]));//grava o atributo nome
			
				//TRATAMENTO PARA FREEPASS
			  $aut = 0;	
				if(trim(strtolower($dados[1])) == "freepass"){
					$aut = 1;
				}
			$cadaModulo->setAttribute("autenticado",$aut);//grava o atributo nome
			
			$root->appendChild($cadaModulo);//adiciona no objeto principal quando o mesmo rodar
		}

	  $nvXML->appendChild($root);//adiciona no objeto principal
	  return $nvXML;//retorna objeto para o solicitante
	}
	
	//verifica se XML existe
	public function xmlExiste($database_bbpass, $bbpass, $gerencia, $nmSessao,$caminhoObjXML){
		if(!file_exists($caminhoObjXML.$nmSessao.".xml")){
			$nvXML = $this->criaXML();//cria XML
			//monta nohs do XML
			$arrayModulo = $gerencia->listaModulos($database_bbpass, $bbpass);//Lista os locks cadastrados e move para o XML
			 if(count($arrayModulo)>0){//só adiciona se tiver resultados
				$nvXML = $this->adicionaModulo($nvXML, $arrayModulo);//verifica os locks
			 }
			$this->gravaXML($nvXML, $nmSessao, $caminhoObjXML);//grava em diretório físico
		}
	}
	
	//grava XML no diretório
	public function gravaXML($objXML, $nmSessao, $caminhoObjXML){
		$objXML->save($caminhoObjXML.$nmSessao.".xml");//grava XML alterado no diretório
	}
	//responsável pela remoção do XML criado pelo BBPASS
	public function apagaXML($caminhoObjXML, $nmSessao){
		unlink($caminhoObjXML.$nmSessao.".xml");
	}
	//exibe o XML na tela
	public function exibeXML($objXML){
		echo $objXML->saveXML();
	}
}
?>