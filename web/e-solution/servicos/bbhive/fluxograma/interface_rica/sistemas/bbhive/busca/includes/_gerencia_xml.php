<?php
class GerenciaXML{
	//construtor do XML
	public function criaXML($nomeNoh){
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel 

		$root = $doc->createElement($nomeNoh);//cria elemento pai de todos
		$doc->appendChild($root);//adiciona noh no objeto XML
		return $doc;	
	}
	//Adiciona PREMISSAS no XML
	public function adicionaPremissas($atividades, $domXML, $database_bbhive, $bbhive){
		$root = $domXML->getElementsByTagName('fluxo')->item(0);
			//=========================================================================
			$totFilhos = $root->childNodes->length;
				//navego em todas as atividades
				for($a=0; $a<$totFilhos; $a++){
					
					$cadaAtividade 	= $root->childNodes->item($a);
					$codAtividade	= $cadaAtividade->getAttribute("id");
					$codModelo		= $cadaAtividade->getAttribute("cod_modelo");
					$pesoAtividade	= $cadaAtividade->getAttribute("peso");
					
						//recupero a tag premissa
							$cadaPremissa = $cadaAtividade->childNodes->item(0);
							//verifico as premissas
							$asPremissas  =	$atividades->listaPremissas($codModelo, $database_bbhive, $bbhive);
							
							for($g=0; $g<count($asPremissas);$g++){
								$aPremissa = $domXML->createElement('atividade');
								$aPremissa->setAttribute("id",$asPremissas[$g]);
								
								$cadaPremissa->appendChild($aPremissa);
							}
				}
	  	$domXML->appendChild($root);//adiciona no objeto principal
	  	return $domXML;//retorna objeto para o solicitante
	}
	//Adiciona ALTERNATIVAS no XML===============================================================================================
	public function adicionaAlternativas($atividades, $domXML, $database_bbhive, $bbhive){
		$root = $domXML->getElementsByTagName('fluxo')->item(0);
			$s = 0;
			//=========================================================================
			$totFilhos = $root->childNodes->length;
				//navego em todas as atividades
				for($a=0; $a<$totFilhos; $a++){
					
					$cadaAtividade 	= $root->childNodes->item($a);
					$codAtividade	= $cadaAtividade->getAttribute("id");
					$codModelo		= $cadaAtividade->getAttribute("cod_modelo");
					$pesoAtividade	= $cadaAtividade->getAttribute("peso");
					
					if($pesoAtividade!="100"){
						//recupero a tag premissa
							$cadaAlternativa = $cadaAtividade->childNodes->item(1);
							//verifico as alternativas
							$osSubFluxos  = $atividades->listaSubFluxo($codModelo, $database_bbhive, $bbhive);
							
								for($h=0; $h<count($osSubFluxos);$h++){
										$dados 	= explode("|",$osSubFluxos[$h]);
										$oId	= $dados[0];
										$oNome	= $dados[1];
									
										$oSub = $domXML->createElement('atividade');
										$oSub->setAttribute("id",$oId);//TRATAMENTO DE ERRO - DEVE SUBTRAÍR OS TRÊS ÚLIMOS CHAR
										$oSub->setAttribute("nome",($oNome));
										$oSub->setAttribute("cor","0x66CC00");
										$oSub->setAttribute("icone","mc_vazio.swf");
										$oSub->setAttribute("status","sub_fluxo.swf");
										$oSub->setAttribute("pai","==>");
										$oSub->setAttribute("cod_atividade_pai", $codAtividade);
										$oSub->setAttribute("tag", "bbh_mod_flu_codigo");//
										
										$cadaAlternativa->appendChild($oSub);	
										$s++;
								}
					}
				}
			//recupera os nhós adicionados=============================================
			$add = $root->getAttribute("totNohs");
			$root->setAttribute("totNohs", $add + $s);
			
	  	$domXML->appendChild($root);//adiciona no objeto principal
	  	return $domXML;//retorna objeto para o solicitante
	}
	//Adiciona DETALHES no XML===============================================================================================
	public function adicionaDetalhes($strDetalhes, $nvXML, $bbh_ati_codigo, $souFluxoModelo, $codFluxoModelo, $tituloSubFluxo, $codigoAnterior, $tituloAnterior){
		$root 	= $nvXML->getElementsByTagName('atividade_fluxo')->item(0);	
		$tot	= count($strDetalhes);
		
		$fluxo = $souFluxoModelo == "1" ? "1" : "0";
		$modelo= $souFluxoModelo == "0" ? "1" : "0";
		$codigo= $codFluxoModelo;
		
			for($a=0; $a<$tot;$a++){
				$cadaDetalhe = $nvXML->createElement('detalhes');
				$cadaDetalhe->setAttribute("tag", ($strDetalhes[$a][0]));//
				$cadaDetalhe->setAttribute("valor", ($strDetalhes[$a][1]));//
				$cadaDetalhe->setAttribute("publicado", "1");//
				
				$root->appendChild($cadaDetalhe);
			}
			
		$root->setAttribute("id", $bbh_ati_codigo);//grava o atributo
		$root->setAttribute("fluxo", $fluxo);//grava o atributo
		$root->setAttribute("modelo",$modelo);//grava o atributo
		$root->setAttribute("codigo",$codigo);//grava o atributo
		$root->setAttribute("tituloAnterior",$tituloAnterior);//grava o atributo
		$root->setAttribute("codigoAnterior",$codigoAnterior);//grava o atributo
	    $nvXML->appendChild($root);//adiciona no objeto principal
	    return $nvXML;//retorna objeto para o solicitante
	}
}
?>