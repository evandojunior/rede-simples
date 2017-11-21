<?php
class gerenciaXML{
	function __construct(){
	//include('../includes/functions.php');
	$caminho = $this->diretorio();
	 //verifica se é possível abrir diretório
		if ($handle = opendir($caminho)) {
		   //varre diretório em busca de arquivos
			while (false !== ($file = readdir($handle))) {
				$extensao[strtolower(strrchr($file, "."))] = 1; 
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
						if($Tempo>5){
							@chmod($caminho, 0777);
							@unlink($caminho . $file);
						}
						//echo date ("H:i:s", filemtime($caminho."\\".$file))."<hr>";
					}
			}
		 closedir($handle);
		}
	}
	//monta caminho do diretório
	public function diretorio(){
		$caminho = str_replace("\\","/",dirname(__FILE__));
		$caminho = explode("web", $caminho);
		$caminho = $caminho[0]."web";
		$caminho = $caminho."/datafiles/servicos/policy/sessao/";
		if(!file_exists($caminho)){
			mkdir($caminho,777);
			chmod($caminho,0777);
		}
		return $caminho;
	}
	//cria xml padrão
	public function criaXML($nmXML){
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel 
		$root = $doc->createElement('politica');//cria elemento pai de todos
			//adiciona elementos principais
			$condicao = array("quem|Quem|pol_aud_usuario|0","quando|Quando|pol_aud_momento|1","onde|Onde|pol_aud_ip|0","oque|O que|pol_aud_acao|0","relevancia|Relevância|pol_aud_relevancia|0");
			$elementos= array("condicao","ordenacao");
			for($a=0;$a<2;$a++){
				$elemArray = $doc->createElement($elementos[$a]);//cria elemento pai de todos
	
				foreach($condicao as $indice=>$valor){
					$inf = explode("|",$valor);
					$elemento = $doc->createElement($inf[0]);//cria elemento
					$elemento->setAttribute("nome",utf8_encode($inf[1]));//grava o atributo
					$elemento->setAttribute("campo",$inf[2]);//grava o atributo
					$elemento->setAttribute("tipoCondicao","");//grava o atributo
					$elemento->setAttribute("valor","");//grava o atributo
					$elemento->setAttribute("campoData",$inf[3]);//grava o atributo
					$elemento->setAttribute("publicado","0");//grava o atributo
					
					$elemArray->appendChild($elemento);//adiciona noh no objeto XML
				}
				$root->appendChild($elemArray);
			 }
			//elementos adicionados
		$doc->appendChild($root);//adiciona noh no objeto XML
		return $doc;
	}
	//atualiza os filhos do XML
	public function atualizaFilhos($doc, $elementoPai, $elementoFilho, $Condicao, $Conteudo, $publicado){
		$politica 		= $doc->getElementsByTagName('politica')->item(0);
		$elementoPai 	= $doc->getElementsByTagName($elementoPai)->item(0);
		/*--------------------------------------------------------*/
			$elemento = $elementoPai->getElementsByTagName($elementoFilho)->item(0);
			$elemento->setAttribute("tipoCondicao",$Condicao);//grava o atributo
			$elemento->setAttribute("valor",utf8_encode($Conteudo));//grava o atributo
			$elemento->setAttribute("publicado",$publicado);//grava o atributo
			$elementoPai->appendChild($elemento);//adiciona noh no objeto XML
			$politica->appendChild($elementoPai);
		/*--------------------------------------------------------*/
		//$doc->appendChild($politica);//adiciona noh no objeto XML
		return $doc;
	}
	//exibe xml na tela
	public function exibeTela($doc){
		echo $doc->saveXML();
	}
	//leitura XML
	public function leituraXML($nmArquivo){
		$arquivo = $this->diretorio().$nmArquivo.".xml";
		$doc = new DOMDocument();
		$doc->load($arquivo); //coloca conteúdo no objeto
		return $doc;
	}
	//verifica se xml existe
	public function verificaExiste($nmArquivo){
		$existe = 0;
		 if(file_exists($this->diretorio().$nmArquivo.".xml")){
			$existe=1; 
		 }
		 return $existe;
	}
	//grava arquivo
	public function gravaArquivo($nmFile, $doc){
		$doc->save($this->diretorio().$nmFile.".xml");//grava XML alterado no diretório
	}
	//le formato string
	public function leFormatoString($nmFile){
		return file_get_contents($this->diretorio().$nmFile.".xml");
	}
	public function removeArquivo($nmFile){
		//caminho
		unlink($this->diretorio().$nmFile.".xml");
	}
}
?>