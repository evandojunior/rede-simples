<?php
			$dirCred = str_replace("\\","/",dirname(__FILE__));
			$dirCred = explode("web", $dirCred);
			$caminhoCred = $dirCred[0]."web";

			 include($caminhoCred."/servicos/bbpass/credencial/gerencia_credencial/gerencia.php");
			 $gerencia->inicio();//grava informações nas variáveis
			 //verifica se a sessão que está no xml é igual
			 $gerencia->sessaoIgual();
			 //============================================

			 $gerencia->moduloLiberado($gerencia->emailLogado,$gerencia->caminhoXML,$idLockLiberado);
			 $gerenciaXML 	= new gerenciaXML();//inicio da classe XML
			 $gerencia->criaSessaoXML($gerenciaXML, $gerencia->caminhoXML);//coloca autenicados na sessão
?>