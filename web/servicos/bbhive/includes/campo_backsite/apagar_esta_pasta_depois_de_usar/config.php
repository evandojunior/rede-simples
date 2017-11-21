<?php	
//========== PÁGINA DE CONFIGURAÇÕES DO PLUGIN ==========//
//
// VALORES DO BANCO DE DADOS (OBRIGATÓRIO)
//
	define("_database_sql",$database_bbhive);	// NOME DO BANCO (geralmente encontra-se na inclusão do Connections)
	define("_sql",$bbhive);					// NOME DA CONEXÃO COM O BANCO (geralmente encontra-se na inclusão do Connections)
	define("_localPadrao","/servicos/bbhive/includes/campo_backsite/");	// O CAMINHO RELATIVO DO DOCUMENTO
//
// VALORES DO LAYOUT
//
	define("_largura_pagina",950);			// DEFINE O TAMANHO LIMITE DA PÁGINA, EM PIXELS
	define("_largura_titulo",250);			// DEFINE O TAMANHO PADRÃO DO TÍTULO, EM PIXELS
	define("_largura_campo",700);			// DEFINE O TAMANHO PADRÃO DO CAMPO, EM PIXELS
	define("_estilo_linha","verdana_11_b");	// O ESTILO USADO NA LINHA
	define("_estilo_campo","verdana_11");	// O ESTILO USADO NO CAMPO
//
// ATRIBUTOS DA CLASSE
//
	//$codigo_modelo						// O CÓDIGO DO MODELO QUE VOU SELECIONAR OS CAMPOS 
	//$dadosTabela							// ATRIBUTO OPCIONAL - ESTA É A ARRAY QUE CONTÉM OS DADOS DA TABELA, USO SOMENTE SE EXISTIR MAIS DE
											// UMA TABELA COM CAMPOS NO SISTEMA
//
//=========================================//
?>