<?php
class GerenciaAtividades{
	//lista todas as atividades de determinado fluxo===========================================================================
	public function listaAtividades($bbh_flu_codigo, $database_bbhive, $bbhive){
		$sql = "select bbh_ati_codigo,
		  bbh_atividade.bbh_sta_ati_codigo, bbh_modelo_atividade.bbh_mod_ati_codigo, bbh_ati_inicio_previsto, 
		  bbh_ati_final_previsto,
		  bbh_ati_inicio_real, bbh_ati_final_real, bbh_mod_ati_nome, bbh_sta_ati_peso, bbh_mod_ati_icone,
		  bbh_flu_titulo, concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) as numero, bbh_sta_ati_peso,
		  bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_mod_flu_nome, bbh_flu_anonumeracao
		   from bbh_atividade
			right join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
			inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
			inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
			
			inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
			inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
			 Where bbh_atividade.bbh_flu_codigo = $bbh_flu_codigo
			   ORDER BY bbh_mod_ati_ordem ASC";
        list($Atividades, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
		return $Atividades;
	}
	//========================================================================================================================
	
	//Adiciona atividades no XML==============================================================================================
	public function adicionaAtividades($Atividades, $nvXML, $database_bbhive, $bbhive){
		$root = $nvXML->getElementsByTagName('fluxo')->item(0);
		$a=0;
		$s=0;
			while ($row_Atividades = mysqli_fetch_assoc($Atividades)){
			   $bbh_ati_codigo	= $row_Atividades['bbh_ati_codigo'];
			   //DESCISÃO DE ESCOLHA DE COR=========================================================
			   $InicioPrevisto 	= $row_Atividades['bbh_ati_inicio_previsto'];
			   $FinalPrevisto	= $row_Atividades['bbh_ati_final_previsto'];
			   $InicioReal		= $row_Atividades['bbh_ati_inicio_real'];
			   $FinalReal		= $row_Atividades['bbh_ati_final_real'];
			   $PesoStatus		= $row_Atividades['bbh_sta_ati_peso'];
			   $iconSt 			= explode("|",$this->descisaoCor($InicioPrevisto, $FinalPrevisto, $PesoStatus));
			   $color			= $iconSt[0];
			   $iconeStatus		= $iconSt[1];
			   //===================================================================================
			   
			   //DEFINIÇÃO DE DATAS=================================================================
			   $dataAtividade = $InicioPrevisto;
			   if(isset($FinalReal)){
				   $dataAtividade = $this->arrumadata($FinalReal);
			   } else if (isset($InicioReal)){
				   $dataAtividade = $this->arrumadata($InicioReal);
			   } else {
				   $dataAtividade = $this->arrumadata($InicioPrevisto);
			   }
			   //===================================================================================
			   
			   //DEFINIÇÃO DO ÍCONE=================================================================
			   $icone = str_replace(".gif","",$row_Atividades['bbh_mod_ati_icone']);
			   //===================================================================================
			   
				$cadaAtividade = $nvXML->createElement('atividade');//
				$cadaAtividade->setAttribute("id", $bbh_ati_codigo);//
				$cadaAtividade->setAttribute("nome", ($row_Atividades['bbh_mod_ati_nome']));//
				$cadaAtividade->setAttribute("status", $iconeStatus);//
				$cadaAtividade->setAttribute("icone", "mc_".$icone.".swf");//
				$cadaAtividade->setAttribute("data", $dataAtividade);//
				$cadaAtividade->setAttribute("cor","0x".$color);//
				$cadaAtividade->setAttribute("peso", $row_Atividades['bbh_sta_ati_peso']);//
				$cadaAtividade->setAttribute("cod_modelo", $row_Atividades['bbh_mod_ati_codigo']);//
				$cadaAtividade->setAttribute("tag", "bbh_ati_codigo");//
				
					//cada premissa=================================================================
					$cadaPremissa = $nvXML->createElement('premissas');//
					$cadaAtividade->appendChild($cadaPremissa);
					//==============================================================================
					
					//cada alternativa==============================================================
					$cadaAlternativa = $nvXML->createElement('alternativas');//
					$cadaAtividade->appendChild($cadaAlternativa);
					//==============================================================================
				
				$root->appendChild($cadaAtividade);//
				
				$tituloFluxo = ($row_Atividades['bbh_flu_titulo']);
				$numeroFluxo = $row_Atividades['numero'];
				//--
				$nomeFluxo 		= ($row_Atividades['bbh_mod_flu_nome']);
				$autoNumeracao	= $row_Atividades['bbh_flu_autonumeracao'];
				$tipoProcesso	= explode(".",$row_Atividades['bbh_tip_flu_identificacao']);
				$tipoProcesso	= (int)$tipoProcesso[0];
				$anoNumeracao	= $row_Atividades['bbh_flu_anonumeracao'];
				//--$nomeFluxo . " - " . $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
				$numeroProcesso	= $tituloFluxo . " - " . $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
				//--
				$a++;
			}
			
		$root->setAttribute("nome", $numeroProcesso);//grava o atributo
		$root->setAttribute("totNohs",$a);//grava o atributo
		
	  $nvXML->appendChild($root);//adiciona no objeto principal
	  return $nvXML;//retorna objeto para o solicitante
	}
	//=========================================================================================================================
	
	//descisão de cor e ícone==================================================================================================
	public function descisaoCor($InicioPrevisto, $FinalPrevisto, $PesoStatus){
		$dataAtual 	= date("Y-m-d");
		$cor		= "FAFBFD";
		
			//NOVA TAREFA
			if($PesoStatus=="0"){
				$status	= explode("|",$this->statusAtividade($InicioPrevisto, $FinalPrevisto, $PesoStatus));
				$cor	= $status[0];
				$icon 	= $status[1]=="0" ? "estrela.swf" : "bomba.swf";

				
			//TAREFA CIENTE
			} elseif ($PesoStatus=="5"){
				$status	= explode("|",$this->statusAtividade($InicioPrevisto, $FinalPrevisto, $PesoStatus));
				$cor	= $status[0];
				$icon 	= $status[1]=="0" ? "carimbo.swf" : "bomba.swf";
				
			//TAREFA EM ANDAMENTO
			} elseif ($PesoStatus>"5" && $PesoStatus<"100"){
				$status	= explode("|",$this->statusAtividade($InicioPrevisto, $FinalPrevisto, $PesoStatus));
				$cor	= $status[0];
				$icon 	= $status[1]=="0" ? "engrenagem.swf" : "bomba.swf";
				
			//TAREFA COUNCLUÍDA
			} elseif ($PesoStatus=="100"){
				$icon 	= "visto_final.swf";
				$cor	= "0066FF";
			}
			
			return $cor . "|" . $icon;
	}
	//=========================================================================================================================
	
	//descisão de status atividade=============================================================================================
	public function statusAtividade($InicioPrevisto, $FinalPrevisto, $PesoStatus){
		$dataAtual 	= date("Y-m-d");
			//TAREFA ATRASADA
			if(($dataAtual >= $FinalPrevisto)&&($PesoStatus!="100")){
				return "FF7979|1";
			
			//TAREFA QUE MERECE ATENÇÃO
			} elseif(($dataAtual > $InicioPrevisto)&&($dataAtual < $FinalPrevisto)&&($PesoStatus!="100")){
				return "FFDEDE|0";
				
			//TAREFA FINALIZADA
			} elseif($PesoStatus=="100"){
				return "0066FF|0";
				
			//TAREFA NÃO INICIADA				
			} elseif ($PesoStatus=="0"){
				return "CCFFCC|0";
				
			//TAREFA EM DIA	
			} else {
				return "FAFBFD|0";
			}			
	}
	//=========================================================================================================================
	
	//PREMISSAS DAS ATIVIDADES=================================================================================================
	public function listaPremissas($bbh_mod_ati_codigo, $database_bbhive, $bbhive){
		$sql = "select bbh_modelo_atividade_predecessora from bbh_dependencia
  					Where bbh_modelo_atividade_sucessora  = $bbh_mod_ati_codigo";
        list($Premissas, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
			$todasPremissas = array();
				while ($row_Premissas = mysqli_fetch_assoc($Premissas)){
					array_push($todasPremissas, $row_Premissas['bbh_modelo_atividade_predecessora']);
				}
			
		return $todasPremissas;	
	}
	//=========================================================================================================================
	
	//SOMENTE SUBFLUXO DAS ATIVIDADES==========================================================================================
	public function listaSubFluxo($bbh_mod_ati_codigo, $database_bbhive, $bbhive){
		$sql = "select 
				 bbh_mod_ati_codigo, bbh_modelo_fluxo.bbh_mod_flu_codigo, bbh_mod_flu_nome
				 from bbh_fluxo_alternativa
				   inner join bbh_modelo_fluxo on bbh_fluxo_alternativa.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
					Where bbh_mod_ati_codigo = $bbh_mod_ati_codigo
						 Order by bbh_atividade_predileta ASC";
        list($SubFluxo, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
			$todosSub = array();
				while ($row_SubFluxo = mysqli_fetch_assoc($SubFluxo)){
					array_push($todosSub, $row_SubFluxo['bbh_mod_flu_codigo']."|".$row_SubFluxo['bbh_mod_flu_nome']);
				}
			
		return $todosSub;	
	}
	//=========================================================================================================================
	
	//DETALHES DAS ATIVIDADES==================================================================================================
	public function listaDetalhes($bbh_ati_codigo, $database_bbhive, $bbhive, $bbh_usu_codigo){
		$sql = "select 
			bbh_flu_titulo,
			concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) as numero,
		 	bbh_mod_ati_nome,
		  	if(bbh_ati_inicio_previsto is null,'sem informação',bbh_ati_inicio_previsto) as bbh_ati_inicio_previsto,
		  	if(bbh_ati_inicio_real is null,'sem informação',bbh_ati_inicio_real) as bbh_ati_inicio_real,
		  	if(bbh_ati_final_previsto is null,'sem informação',bbh_ati_final_previsto) as bbh_ati_final_previsto,
		    if(bbh_ati_final_real is null,'sem informação',bbh_ati_final_real) as bbh_ati_final_real,
			
		   	bbh_sta_ati_nome,
		  	bbh_mod_ati_observacao, bbh_usu_nome, bbh_departamento.bbh_dep_codigo, bbh_dep_nome
		   from bbh_atividade
			right join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
			inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
			inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		    inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
	        inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
			 Where bbh_atividade.bbh_ati_codigo = $bbh_ati_codigo";
        list($Detalhes, $row_Detalhes, $totalRows_Detalhes) = executeQuery($bbhive, $database_bbhive, $sql);

			$todosDet = array();
			 if($totalRows_Detalhes>0){
				//Título do fluxo
				$tituloFluxo 		= array("Título do fluxo:", $row_Detalhes['bbh_flu_titulo']." - ".$row_Detalhes['numero']);
				array_push($todosDet, $tituloFluxo);
				//Título da atividade
				$tituloAtividade 	= array("Título da Atividade:", $row_Detalhes['bbh_mod_ati_nome']);
				array_push($todosDet, $tituloAtividade);
				//Ínicio previsto
				$inicioPrevisto 	= array("Início previsto:", $this->arrumadata($row_Detalhes['bbh_ati_inicio_previsto']));
				array_push($todosDet, $inicioPrevisto);
				//Início real
				$inicioReal 		= array("Início real:", $this->arrumadata($row_Detalhes['bbh_ati_inicio_real']));
				array_push($todosDet, $inicioReal);
				//Final previsto
				$finalPrevisto 		= array("Final previsto:", $this->arrumadata($row_Detalhes['bbh_ati_final_previsto']));
				array_push($todosDet, $finalPrevisto);
				//Final real
				$finalReal 			= array("Final real:", $this->arrumadata($row_Detalhes['bbh_ati_final_real']));
				array_push($todosDet, $finalReal);
				//Departamento / Profissional==========================================================================
				    $depCodigo	= $this->departamentoUsuario($database_bbhive, $bbhive, $bbh_usu_codigo);
				    $depUsuario	= $row_Detalhes['bbh_dep_codigo'];
				    $depNome	= $row_Detalhes['bbh_dep_nome'];
				    $usuNome	= $row_Detalhes['bbh_usu_nome'];
				    $usuDep 	= explode("|",$this->usuario_departamento($depCodigo, $depUsuario, $depNome, $usuNome));
					$titUsuDep	= $usuDep[0] == "D" ? "Departamento:" : "Profissional:";
					
				$Departamento 		= array($titUsuDep, $usuDep[1]);
				array_push($todosDet, $Departamento);
				//=====================================================================================================
				//Status
				$Status 		= array("Status:", $row_Detalhes['bbh_sta_ati_nome']);
				array_push($todosDet, $Status);
				//Descrição
				$Descricao 		= array("Descrição:", $row_Detalhes['bbh_mod_ati_observacao']);
				array_push($todosDet, $Descricao);
			 }

		return $todosDet;
	}
	//=========================================================================================================================
	
	//DEPARTAMENTOS DAS ATIVIDADES=============================================================================================
	public 	function departamentoUsuario($database_bbhive, $bbhive, $bbh_usu_codigo){
		//verifica departamento do usuário logado
		$query_Depto = "select bbh_dep_codigo from bbh_usuario Where bbh_usu_codigo=$bbh_usu_codigo";
        list($Depto, $row_Depto, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_Depto);
		return $row_Depto['bbh_dep_codigo'];
	}
	//=========================================================================================================================
	//DEPARTAMENTOS DAS ATIVIDADES=============================================================================================
	function usuario_departamento($depCodigo, $depUsuario, $depNome, $usuNome){
		if($depCodigo == $depUsuario){
			return "U|".$usuNome;
		} else {
			return "D|".$depNome;
		}
	}
	//=========================================================================================================================
	
	//SOU FLUXO, MODELO OU NADA================================================================================================
	public function verificaAtiv($bbh_ati_codigo, $database_bbhive, $bbhive){
		//verifico o peso do estado==================================================
		$sqlPeso = "select bbh_sta_ati_peso from bbh_atividade
 						inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
  							Where bbh_ati_codigo = $bbh_ati_codigo";
        list($Peso, $row_Peso, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlPeso);
		//===========================================================================
		
		//verifico de sou pai de algum fluxo=========================================
		$sqlFluxoPai = "select bbh_atividade.bbh_flu_codigo, bbh_flu_titulo from bbh_fluxo
   							inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
         						Where bbh_flu_tarefa_pai = $bbh_ati_codigo
									group by bbh_atividade.bbh_flu_codigo";
        list($FluxoPai, $row_FluxoPai, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlFluxoPai);
		//===========================================================================
			if($row_Peso["bbh_sta_ati_peso"] == "100" && !empty($row_FluxoPai["bbh_flu_codigo"])){
				return "1|".$row_FluxoPai["bbh_flu_codigo"]."|".$row_FluxoPai["bbh_flu_titulo"];
			} else {
				return "-1|0|--";
			}
	}
	//=========================================================================================================================
	
	public function dadosAtiv($bbh_ati_codigo, $database_bbhive, $bbhive){
		$sqlAtividade = "select bbh_atividade.bbh_flu_codigo, bbh_flu_titulo from bbh_fluxo
   							inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
         						Where bbh_ati_codigo =$bbh_ati_codigo";
        list($atividade, $row_atividade, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlAtividade);
		return $row_atividade["bbh_flu_codigo"]."|".$row_atividade["bbh_flu_titulo"];
	}
	
	public function listaModelo($bbh_mod_flu_codigo, $database_bbhive, $bbhive){
		$sqlModelo = "select * from bbh_modelo_fluxo Where bbh_mod_flu_codigo = $bbh_mod_flu_codigo";
        list($modelo, $row_modelo, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlModelo);

		$todosDet = array();
				//Título do fluxo
				$tituloFluxo 		= array("Modelo :", $row_modelo['bbh_mod_flu_nome']);
				array_push($todosDet, $tituloFluxo);

		return $todosDet;
	}
	
	public function atividadesModelo($bbh_mod_flu_codigo, $database_bbhive, $bbhive){
		$sqlModelo = "select bbh_mod_ati_codigo, bbh_mod_ati_nome, bbh_mod_ati_icone, bbh_mod_flu_nome
						from bbh_modelo_atividade 
						 inner join bbh_modelo_fluxo on bbh_modelo_atividade.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
						  where bbh_modelo_atividade.bbh_mod_flu_codigo = $bbh_mod_flu_codigo
								order by bbh_mod_ati_ordem ASC";
        list($modelo, $row_modelo, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlModelo, $initResult = false);
		return $modelo;
	}
	
	public function adicionaAtividadesModelo($Atividades, $domXML, $database_bbhive, $bbhive){
		$root = $domXML->getElementsByTagName('fluxo')->item(0);
		$a=0;
		$s=0;
		$tituloFluxo = "";
			while ($row_Atividades = mysqli_fetch_assoc($Atividades)){
		   
			   //DEFINIÇÃO DO ÍCONE=================================================================
			   $icone = str_replace(".gif","",$row_Atividades['bbh_mod_ati_icone']);
			   //===================================================================================
		   
				$cadaAtividade = $domXML->createElement('atividade');//
				$cadaAtividade->setAttribute("id", $row_Atividades['bbh_mod_ati_codigo']);//
				$cadaAtividade->setAttribute("nome", ($row_Atividades['bbh_mod_ati_nome']));//
				$cadaAtividade->setAttribute("status", "sub_fluxo.swf");//
				$cadaAtividade->setAttribute("icone", "mc_".$icone.".swf");//
				$cadaAtividade->setAttribute("data", "Modelo");//
				$cadaAtividade->setAttribute("cor","0x66CC00");//
				$cadaAtividade->setAttribute("peso", "0");//
				$cadaAtividade->setAttribute("cod_modelo", $row_Atividades['bbh_mod_ati_codigo']);//
				$cadaAtividade->setAttribute("tag", "bbh_mod_ati_codigo");//
				
					//cada premissa=================================================================
					$cadaPremissa = $domXML->createElement('premissas');//
					$cadaAtividade->appendChild($cadaPremissa);
					//==============================================================================
					
					//cada alternativa==============================================================
					$cadaAlternativa = $domXML->createElement('alternativas');//
					$cadaAtividade->appendChild($cadaAlternativa);
					//==============================================================================
				
				$root->appendChild($cadaAtividade);//
				
				$tituloFluxo = $row_Atividades['bbh_mod_flu_nome'];
				$a++;
			}
			
		$root->setAttribute("nome", ($tituloFluxo));//grava o atributo
		$root->setAttribute("totNohs",$a);//grava o atributo
		
	  $domXML->appendChild($root);//adiciona no objeto principal
	  return $domXML;//retorna objeto para o solicitante	
	}
	
	public function listaModeloAtividades($bbh_mod_ati_codigo, $database_bbhive, $bbhive){
		$sql = "select bbh_modelo_atividade.*, bbh_mod_flu_nome from bbh_modelo_atividade 
					inner join bbh_modelo_fluxo on bbh_modelo_atividade.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
						Where bbh_mod_ati_codigo = $bbh_mod_ati_codigo";
        list($Detalhes, $row_Detalhes, $totalRows_Detalhes) = executeQuery($bbhive, $database_bbhive, $sql);
		
			$todosDet = array();
				//Título do fluxo
				$tituloFluxo 		= array("Título do modelo do Fluxo:", $row_Detalhes['bbh_mod_flu_nome']);
				array_push($todosDet, $tituloFluxo);
				//Título da atividade
				$tituloAtividade 	= array("Título do modelo da Atividade:", $row_Detalhes['bbh_mod_ati_nome']);
				array_push($todosDet, $tituloAtividade);
				//Descrição
				$Descricao 		= array("Descrição:", $row_Detalhes['bbh_mod_ati_observacao']);
				array_push($todosDet, $Descricao);
			return 	$todosDet;
	}
	
	public function arrumadata($data_errada)
	 {return implode(preg_match("~\/~", $data_errada) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data_errada) == 0 ? "-" : "/", $data_errada)));
	}
}
?>