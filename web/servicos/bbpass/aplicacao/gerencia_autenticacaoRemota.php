<?php

require_once($_SESSION['caminhoFisico']."/servicos/bbpass/includes/RecoverConnection.php");

class AutenticacaoRemota extends RecoverConnection {

	public function __construct($database_bbpass, $bbpass, $idAplic, $nmSessao){
		//apaga logs gerados a mais de 24horas
		$this->removeFiles();
		//verifica o nopass
		$this->verificaNoPass($database_bbpass, $bbpass, $idAplic);
		//verifica os locks cadastrados para esta aplicação
	 	$this->verificaLocks($database_bbpass, $bbpass, $idAplic, $nmSessao);
		//verifica se os locks da aplicação é compatível com locks do usuário
		$this->verificaUsuarioAplicacao($database_bbpass, $bbpass, $nmSessao, $idAplic);
		//Verifica qual não está autenticado
		$this->analisaLock($nmSessao, $idAplic);
	}
	
	/*========================================VERIFICAÇÃO DOS LOCKS DO USUÁRIO X APLICAÇÃO==============*/	
	public function verificaUsuarioAplicacao($database_bbpass, $bbpass, $nmSessao, $idAplic){
        $this->getConnection();

		if(isset($_SESSION['MM_Email_Padrao'])){//verifica se o usuário está na sessão

			require_once($_SESSION['caminhoFisico']."/servicos/bbpass/perfil/gerencia_perfil.php");
			$usuario = new perfil();//instância classe
			$usuario->atualizaLogon($database_bbpass, $bbpass);

			//verifica se existe xml
			require_once(@$_SESSION['caminhoFisico']."/servicos/bbpass/credencial/gerencia_credencial/gerencia.php");
			
			//abre XML do usuário
			$objUSER = new DOMDocument();
			$objUSER->load(str_replace("sessao","credencial",$this->diretorio().$_SESSION['EmailTratado'].".xml"));
			$user 	 = $objUSER->getElementsByTagName('modulos_autenticacao')->item(0);

			//abre XML da aplicação
			$objAPLIC = new DOMDocument();
			$objAPLIC->load($this->diretorio().$nmSessao.".xml");
			$aplic 	 = $objAPLIC->getElementsByTagName('modulos_autenticacao')->item(0);

			//comparação entre dados dos XML's
			  foreach($aplic->childNodes as $nodesAPLIC){
				  $nohXML = $nodesAPLIC->getAttribute("id");
				  	if($user->getElementsByTagName('mod_'.$nohXML)->item(0)){
						if($user->getElementsByTagName('mod_'.$nohXML)->item(0)->getAttribute("autenticado")=="1"){
						  //dou baixa deste lock no objeto XML
						  $aplic->getElementsByTagName('mod_'.$nohXML)->item(0)->setAttribute("autenticado","1");
						 //echo 'tenho aplic no user';
						}
					}
			  }
			  $objAPLIC->appendChild($aplic);
			  //gravo xml no local físico
			  $this->gravaXML($objAPLIC, $nmSessao);

		//verifico se XML esta totalmente autenticado
		$xmlAutenticado 	= 0;
		$totLocksAplicacao	= $aplic->childNodes->length;
		
			foreach($aplic->childNodes as $nodesAPLIC){
				if($nodesAPLIC->getAttribute("autenticado")=="1"){
					$xmlAutenticado++;
				}
			}

		  //se o que o usuário já tiver for maior que o solicitado por esta aplicação, libera acesso
		  if($xmlAutenticado==$totLocksAplicacao){ 
		  	//remove arquivo
			 unlink($this->diretorio().$nmSessao.".xml");
		  	?>
            <span style="font-family:verdana;font-size:11px;color:#099">Aplica&ccedil;&atilde;o autenticada redirecionando...</span>
            <form name="autPacoteBBPASS" id="autPacoteBBPASS" method="post" action="<?php echo $this->enderecoAplicacao($database_bbpass, $bbpass, $idAplic)."login.php"; ?>" style="position:absolute" target="_top"><input name="Email_Padrao" id="Email_Padrao" type="hidden" value="<?php echo $_SESSION['MM_Email_Padrao']; ?>" />
            </form>
            <script type="text/javascript">
                document.autPacoteBBPASS.submit();
            </script>
          <?php   
			exit;  
		  } /*?>

          <span style="font-family:verdana;font-size:11px;color:#F00">Não foi possível efetuar a autenticação.<br /><br />Possível causa:<br />
          <br />
          <li>Usuário logado não possuí credencias sulficientes para acesso a este ambiente.</li>
          </span>
		 <?php exit;*/
		}
	}
	/*========================================VERIFICAÇÃO DOS LOCKS DO USUÁRIO X APLICAÇÃO==============*/	
	
	/*========================================VERIFICAÇÃO DOS LOCKS=====================================*/
	public function verificaLocks($database_bbpass, $bbpass,$idAplic, $nmSessao){
	    $this->getConnection();

		//verifica se tem locks e/ou no pass
		  $Aut_query ="select * from bbp_adm_lock_aplicacao inner join bbp_adm_lock on bbp_adm_lock_aplicacao.bbp_adm_loc_codigo = bbp_adm_lock.bbp_adm_loc_codigo WHERE bbp_adm_apl_codigo=".$idAplic;
          list($Aut, $row_Aut, $totalRows) = executeQuery($bbpass, $database_bbpass, $Aut_query);

		  	if($totalRows>0){//Gera XML com dados da aplicação
				//verifica se xml com credencial existe
				if(!file_exists($this->diretorio().$nmSessao.".xml")){
				  $objDOM  = $this->criaCredenciaAplicacao();
				  $root = $objDOM->getElementsByTagName('modulos_autenticacao')->item(0);
				  
					do{//recupera os locks na ordem
						$cadaModulo = $objDOM->createElement('mod_'.$row_Aut['bbp_adm_loc_codigo']);//grava o ID como nome do nó
						$cadaModulo->setAttribute("id",$row_Aut['bbp_adm_loc_codigo']);//grava o atributo Id
						$cadaModulo->setAttribute("nomeModulo",($row_Aut['bbp_adm_loc_nome']));//grava o atributo nome
						$cadaModulo->setAttribute("arquivo",$row_Aut['bbp_adm_loc_arquivo']);//grava o atributo nome
						$cadaModulo->setAttribute("autenticado","0");//grava o atributo nome
						
						$root->appendChild($cadaModulo);//adiciona no objeto principal quando o mesmo rodar
					}while($row_Aut = mysqli_fetch_assoc($Aut));
					
				  $objDOM->appendChild($root);//adiciona no objeto principal
				  $this->gravaXML($objDOM, $nmSessao)	;//Grava XML Padrão
				}
				//==
			}else{//Barra aplicação
		   	   $msg = "<span class='falha'>Erro de autentica&ccedil;&atilde;o, acesso negado.</span>";
			   $this->mensagemPadrao($msg);
			   exit;
			}
	}
	/*========================================VERIFICAÇÃO DOS LOCKS=====================================*/
	
	/*========================================VERIFICAÇÃO DO NOPASS=====================================*/
	public function verificaNoPass($database_bbpass, $bbpass,$idAplic){
        $this->getConnection();

		//verifica se tem locks e/ou no pass
		$Aut_query ="select bbp_adm_lock_codigo from bbp_adm_lock_aplicacao inner join bbp_adm_lock on bbp_adm_lock_aplicacao.bbp_adm_loc_codigo = bbp_adm_lock.bbp_adm_loc_codigo WHERE bbp_adm_apl_codigo=".$idAplic." and bbp_adm_loc_diretorio='nopass'";
        list($Aut, $row_Aut, $totalRows) = executeQuery($bbpass, $database_bbpass, $Aut_query);

		   if($totalRows>0){//Barra a aplicação
		   	   $msg = "<span class='falha'>Erro de autentica&ccedil;&atilde;o, acesso negado.</span>";
			   $this->mensagemPadrao($msg);
			   exit;
		   }
	}
	/*========================================VERIFICAÇÃO DO NOPASS=====================================*/
	
	/*========================================CRIA XML PADRÃO==========================================*/
	public function criaCredenciaAplicacao(){
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel 

		$root = $doc->createElement('modulos_autenticacao');//cria elemento pai de todos
		$doc->appendChild($root);//adiciona noh no objeto XML
		return $doc;
	}
	/*========================================CRIA XML PADRÃO==========================================*/
	
	/*========================================INFORMA LOCK NÃO AUTENTICADO=============================*/
	public function analisaLock($nmSessao, $idAplic){
		$objDOM = new DOMDocument();
		$objDOM->load($this->diretorio().$nmSessao.".xml"); //coloca conteúdo no objeto
		
		$root = $objDOM->getElementsByTagName('modulos_autenticacao')->item(0);
		$qtLoc= $root->childNodes->length;
			
		foreach($root->childNodes as $cadaLock){
			if($cadaLock->getAttribute("autenticado")=="0"){
				
				$caminho = str_replace("\\","/",dirname(__FILE__));
				$caminho = explode("web", $caminho);
				$caminho = $caminho[0]."web";
				$caminho = $caminho."/servicos/bbpass/modulos_autenticacao/modulos/";
				
				$idLock	 = $cadaLock->getAttribute("id");

				require_once($caminho.$cadaLock->getAttribute("arquivo"));//inclui módulo da vez
				exit;
			}
		}
	}	
	/*========================================INFORMA LOCK NÃO AUTENTICADO=============================*/
	
	/*========================================GRAVA XML PADRÃO=========================================*/
	public function gravaXML($objXML, $nmSessao){
		$objXML->save($this->diretorio().$nmSessao.".xml");//grava XML alterado no diretório
	}
	/*========================================GRAVA XML PADRÃO=========================================*/
	
	/*========================================DESCOBRE DIRETÓRIO=======================================*/
	public function diretorio(){
		$caminho = str_replace("\\","/",dirname(__FILE__));
		$caminho = explode("web", $caminho);
		$caminho = $caminho[0]."web";
		$caminho = $caminho."/datafiles/servicos/bbpass/sessao/";
		if(!file_exists($caminho)){
			mkdir($caminho,777);
			chmod($caminho,0777);
		}
		return $caminho;
	}
	/*========================================DESCOBRE DIRETÓRIO=======================================*/
	
	/*========================================MENSAGEM PADRÃO PARA O USUÁRIO===========================*/
	public function mensagemPadrao($txtMsg){
		echo $txtMsg;	
	}
	/*========================================MENSAGEM PADRÃO PARA O USUÁRIO===========================*/
	
	/*========================================ENDEREÇO DA APLICAÇÃO====================================*/
	public function enderecoAplicacao($database_bbpass, $bbpass, $idAplic){
        $this->getConnection();

		  $Aut_query 	="select bbp_adm_apl_url from bbp_adm_aplicacao WHERE bbp_adm_apl_codigo=".$idAplic;
        list($Aut, $row_Aut, $totalRows) = executeQuery($bbpass, $database_bbpass, $Aut_query);

		  return $row_Aut['bbp_adm_apl_url'];
	}
	/*========================================ENDEREÇO DA APLICAÇÃO====================================*/
	
	/*========================================REMOVE LOGS A MAIS DE 24H================================*/
	public function removeFiles(){
		$caminho = str_replace("\\","/",dirname(__FILE__));
		$caminho = explode("web", $caminho);
		$caminho = $caminho[0]."web";
		
		require_once($caminho."/servicos/bbpass/includes/function.php");

		$caminho = $this->diretorio();
		 //verifica se é possível abrir diretório
			if ($handle = opendir($caminho)) {
			   //varre diretório em busca de arquivos
				while (false !== ($file = readdir($handle))) {
					//$extensao[strtolower(strrchr($file, "."))] = 1; 
					if ($file != "." && $file != "..") {
					 $tam = strlen($file);
						//ext de 3 chars
						if( $file[($tam)-4] == '.' ){
							$extensao = substr($file,-3);
						}
						
						//verifica os arquivos com mais de 5 minutos e exclui
						$data1 = date("d/m/Y H:i", filemtime($caminho.$file));
						$data2 = date("d/m/Y H:i");//"04/02/2006 11:30";
						
						//chama função e verifica diferenca de datas
						$Tempo = Diferenca($data1,$data2,"m"); 
							//remove arquivo maior que 5 minutos
							if($Tempo>=30){
								//unlink($caminho."\\".$file);
								@chmod($caminho, 0777);
								@unlink($caminho . $file);
							}
						}
				}
			 closedir($handle);
			}
	}
	/*========================================REMOVE LOGS A MAIS DE 24H================================*/
}