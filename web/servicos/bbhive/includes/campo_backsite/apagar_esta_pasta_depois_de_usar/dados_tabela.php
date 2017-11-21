<?php
//========== PÁGINA  COM A ARRAY COM OS NOMES DOS CAMPOS DA TABELA DE CAMPO ==========//
//
// NOME DA TABELA E CAMPOS QUE USAREI NA CLASSE
//
	if($qualTabela==0){
		$dadosTabela = array(
			"nmTabela_dinamica"		=> "ged_doc_",						// A STRING COMUM EM TODAS AS TABELAS DINAMICAS
			"nmTabela_campo" 		=> "ged_campo",						// NOME DA TABELA
			"nmCampo_codRegistro"	=> "arq_codigo",					// NOME DO CAMPO DO CÓDIGO DE REGISTRO
			"nmCampo_codigoCampo"	=> "cam_codigo",					// NOME DO CAMPO COM A CHAVE DA TABELA
			"nmCampo_codigoGrupo"	=> "doc_codigo",					// NOME DO CAMPO COM O CÓDIGO AGRUPADOR
			"nmCampo_titulo"		=> "cam_titulo",					// NOME DO CAMPO COM O TITULO DO CAMPO
			"nmCampo_nome"			=> "cam_nome",						// NOME DO CAMPO COM O NOME DO CAMPO
			"nmCampo_tamanho"		=> "cam_tamanho",					// NOME DO CAMPO COM O TAMNHO DO CAMPO
			"nmCampo_valorPadrao"	=> "cam_vl_default",				// NOME DO CAMPO COM O VALOR PADRÃO
			"nmCampo_tipo"			=> "cam_tipo",						// NOME DO CAMPO COM O TIPO DO CAMPO
			//ordem de exibição
			"nmCampo_ordemExibicao"	=> "cam_exibe",						// NOME DO CAMPO COM A ORDEM DE EXIBIÇÃO (SE VAZIO, NÃO ESTARÁ HABILITADO)
			//campo obrigatório
			"nmCampo_obrigatorio"	=> "cam_obrigatorio",				// NOME DO CAMPO QUE DIZ SE É OBRIGATÓRIO (SE VAZIO, NÃO ESTARÁ HABILITADO)
			//valor único
			"nmCampo_unico"			=> "cam_unico",						// NOME DO CAMPO QUE DIZ SE É VALOR ÚNICO (SE VAZIO, NÃO ESTARÁ HABILITADO)
			//layout dinamico
			"nmCampo_larguraTitulo"	=> "cam_largura_titulo",			// NOME DO CAMPO QUE CONTEM A LARGURA DO TITULO (SE VAZIO, NÃO ESTARÁ HABILITADO)
			"nmCampo_larguraCampo"	=> "cam_largura_campo",				// NOME DO CAMPO QUE CONTEM A LARGURA DO CAMPO 
			"nmCampo_linhaTitulo"	=> "cam_linha_titulo",				// NOME DO CAMPO QUE DIZ SE PULO A LINHA DO TITULO
			"nmCampo_linhaCampo"	=> "cam_linha_campo",				// NOME DO CAMPO QUE DIZ SE PULO A LINHA DO CAMPO ANTERIOR
			//busca dinâmica
			"nmCampo_buscaDinamica"	=> "cam_busca",						// NOME DO CAMPO QUE FAZ UMA BUSCA DINÂMICA (SE VAZIO, NÃO ESTARÁ HABILITADO)
			//redirecionamento documento
			"nmCampo_doc_redireciona"=> "doc_redireciona"				// NOME DO CAMPO QUE REDIRECIONA PARA OUTRO DOC (SE VAZIO, NÃO ESTARÁ HABILITADO)
		);
	}else{
		$dadosTabela = array(
			"nmTabela_dinamica"		=> "ged_atributos_",				// A STRING COMUM EM TODAS AS TABELAS DINAMICAS
			"nmTabela_campo"		=> "ged_campo_especifico",			// NOME DA TABELA
			"nmCampo_codRegistro"	=> "arq_codigo",					// NOME DO CAMPO DO CÓDIGO DE REGISTRO
			"nmCampo_codigoCampo"	=> "cam_codigo",					// NOME DO CAMPO COM A CHAVE DA TABELA
			"nmCampo_codigoGrupo"	=> "emp_codigo",					// NOME DO CAMPO COM O CÓDIGO QUE CONTEM O CONJUNTO DE CAMPOS
			"nmCampo_titulo"		=> "cam_titulo",					// NOME DO CAMPO COM O TITULO DO CAMPO
			"nmCampo_nome"			=> "cam_nome",						// NOME DO CAMPO COM O NOME DO CAMPO
			"nmCampo_tamanho"		=> "cam_tamanho",					// NOME DO CAMPO COM O TAMNHO DO CAMPO
			"nmCampo_valorPadrao"	=> "ged_cam_espe_vl_default",		// NOME DO CAMPO COM O VALOR PADRÃO
			"nmCampo_tipo"			=> "ged_cam_espe_cam_tipo",			// NOME DO CAMPO COM O TIPO DO CAMPO
			//ordem de exibição
			"nmCampo_ordemExibicao"	=> "",								// NOME DO CAMPO COM A ORDEM DE EXIBIÇÃO (SE NULO, NÃO ESTARÁ HABILITADO)
			//campo obrigatório
			"nmCampo_obrigatorio"	=> "ged_cam_espe_cam_obrigatorio",	// NOME DO CAMPO QUE DIZ SE É OBRIGATÓRIO (SE NULO, NÃO ESTARÁ HABILITADO)
			//valor único
			"nmCampo_unico"			=> "",								// NOME DO CAMPO QUE DIZ SE É VALOR ÚNICO (SE NULO, NÃO ESTARÁ HABILITADO)
			//layout dinamico
			"nmCampo_larguraTitulo"	=> "cam_largura_titulo",			// NOME DO CAMPO QUE CONTEM A LARGURA DO TITULO (SE VAZIO, NÃO ESTARÁ HABILITADO)
			"nmCampo_larguraCampo"	=> "cam_largura_campo",				// NOME DO CAMPO QUE CONTEM A LARGURA DO CAMPO 
			"nmCampo_linhaTitulo"	=> "cam_linha_titulo",				// NOME DO CAMPO QUE DIZ SE PULO A LINHA DO TITULO
			"nmCampo_linhaCampo"	=> "cam_linha_campo",				// NOME DO CAMPO QUE DIZ SE PULO A LINHA DO CAMPO ANTERIOR
			//busca dinâmica
			"nmCampo_buscaDinamica"	=> "",								// NOME DO CAMPO QUE FAZ UMA BUSCA DINÂMICA (SE NULO, NÃO ESTARÁ HABILITADO)
			//redirecionamento documento
			"nmCampo_doc_redireciona"=> ""								// NOME DO CAMPO QUE REDIRECIONA PARA OUTRO DOC (SE VAZIO, NÃO ESTARÁ HABILITADO)
		);
	}
//
//=========================================//
?>