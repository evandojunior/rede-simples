<?php
class XML{
	//cria objeto XML que será armazenado no banco
	public function criaXML(){
			//crio o primeiro elemento
			$doc = new DOMDocument("1.0", "utf-8");
			$doc->preserveWhiteSpace = false; //descartar espacos em branco    
			$doc->formatOutput = false; //gerar um codigo bem legivel    
			$root = $doc->createElement("despacho"); //cria o 1 no, todos os nos vao ser inseridos nesse
			$doc->appendChild($root);
			return $doc;
	}
	public function adicionaDespacho($doc, $profissional, $mensagem){
			$root = $doc->getElementsByTagName("despacho")->item(0);
			//crio o nó contendo a imagem
			$desp =  $doc->createElement('conversa');
			$desp->setAttribute("momento", date('d/m/Y H:i'));
			$desp->setAttribute("profissional", $profissional);
			$desp->setAttribute("mensagem", $mensagem);
			$root->appendChild($desp);
			//-----	
			$doc->appendChild($root);
			//-----
			return $doc;
	}
	public function leXML($campoXML){
			$doc = new DOMDocument("1.0", "utf-8");
			$doc->preserveWhiteSpace = false; //descartar espacos em branco    
			$doc->formatOutput = false; //gerar um codigo bem legivel   
			$doc->loadXML($campoXML);
			return $doc;
	}
}
?>