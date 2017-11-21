<?php
require_once("../../../Connections/bbhive.php");

	$dirEt 		= explode("web",str_replace("\\","/", strtolower(dirname(__FILE__))));
	$etiquetas 	= $dirEt[0]."database/servicos/bbhive/etiqueta.xml";
	
	$qtd = (int)$_POST['quantidade'];
		if(empty($qtd)){
			echo "<var style='display:none'>alert('Informe o número de etiquetas que deseja imprimir');</var>";
		} else {
			//recupera a quantidade inicial do XML
			$doc = new DOMDocument("1.0", "iso-8859-1"); 
			$doc->preserveWhiteSpace = false; //descartar espacos em branco    
			$doc->formatOutput = false; //gerar um codigo bem legivel   
			$doc->load($etiquetas);
			//-----	
			$root = $doc->getElementsByTagName("etiqueta")->item(0);
			$et   = $root->getElementsByTagName("info")->item(0);
			//-----	
			$nvQt = $et->getAttribute("inicio");
			
			$et->setAttribute("inicio",($nvQt + $qtd));
			$root->appendChild($et);
			//-----	
			$doc->appendChild($root);
			//salvo o xml
			$doc->save($etiquetas);
		
			echo "<var style='display:none'>document.getElementById('inicio').value='".$nvQt."'; document.enviaFormEtiqueta.submit();</var>";
			
			/*===============================INICIO AUDITORIA POLICY=========================================*/
			$_SESSION['relevancia']="0";
			$_SESSION['nivel']="1";
			$Evento="Enviou para impressora $qtd etiquetas, iniciando em $nvQt e terminando em ".($nvQt + $qtd)." - BBHive público.";
			EnviaPolicy($Evento);
			/*===============================FIM AUDITORIA POLICY============================================*/
		}
?>