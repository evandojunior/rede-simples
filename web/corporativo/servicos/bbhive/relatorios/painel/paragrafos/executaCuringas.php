<?php
	//dados básicos do parágrafo
	$conteudo		 	= $bbh_par_paragrafo;
	//dados do detalhamento
	$dadosDetalhamento 	= recuperaCampos($bbh_ati_codigo);
	$curinga 			= $_SESSION['arrayCuringa'];
	$detalhamento 		= $_SESSION['arrayDetalhamento'];
	//tratamento dos dados do curinda e parágrafo em questão
	$cont 		= 0;
	$totDetalhamento = count($detalhamento);
	
	for($x=0; $x<$totDetalhamento;$x++){
		//-- Caso seja um curinga "Lista dinâmica árvore"
			if( preg_match("|([0-9]{2}\.?)+\s.*|", trim($detalhamento[$x])) )
			{
				$detalhamento[$x] = explode(' ', $detalhamento[$x]);
				array_shift($detalhamento[$x]);
				$detalhamento[$x] = implode(' ', $detalhamento[$x]);
			}
		$conteudo = str_replace($curinga[$x],$detalhamento[$x],$conteudo);
	}
	

	//verifico se foi criado a partir de um protocolo
		$query_prot = "SELECT 
						  bbh_pro_codigo, bbh_pro_identificacao, bbh_pro_titulo, bbh_dep_nome, 
						  date_format(bbh_pro_data, '%d/%m/%Y') as bbh_pro_data, 
						  date_format(bbh_pro_momento, '%d/%m/%Y %H:%i') as bbh_pro_momento, 
						  if(bbh_pro_flagrante=0, 'Não','Sim') as bbh_pro_flagrante, 
						  bbh_pro_descricao,
						  bbh_pro_recebido, date_format(bbh_pro_dt_recebido, '%d/%m/%Y %H:%i') as bbh_pro_dt_recebido,
						  bbh_pro_autoridade  
						FROM bbh_protocolos p
						  inner join bbh_fluxo f on p.bbh_flu_codigo = f.bbh_flu_codigo
						  inner join bbh_atividade a on a.bbh_flu_codigo = f.bbh_flu_codigo
						  inner join bbh_relatorio r on a.bbh_ati_codigo = r.bbh_ati_codigo
						  inner join bbh_departamento d on p.bbh_dep_codigo = d.bbh_dep_codigo
						   where r.bbh_rel_codigo = $bbh_rel_codigo LIMIT 1";
        list($prot, $row_prot, $totalRows_prot) = executeQuery($bbhive, $database_bbhive, $query_prot);
		//se tiver protocolo faço a firula
		if($totalRows_prot>0){
		  $curinga = array();

			$query_curingas = "
			SELECT 
			bbh_cam_det_pro_titulo, bbh_cam_det_pro_curinga, bbh_cam_det_pro_nome, bbh_cam_det_pro_tipo
			FROM bbh_campo_detalhamento_protocolo AS detPro";
            list($Ccuringas, $rows, $totalRows_curingas) = executeQuery($bbhive, $database_bbhive, $query_curingas, $initResult = false);

			$query_Oscuringas = "select * from bbh_detalhamento_protocolo as dp
 inner join bbh_protocolos as p on dp.bbh_pro_codigo = p.bbh_pro_codigo
  where dp.bbh_pro_codigo = ".$row_prot['bbh_pro_codigo'];
            list($Oscuringas, $row_Oscuringas, $totalRows_Oscuringas) = executeQuery($bbhive, $database_bbhive, $query_Oscuringas);
			
			$curingas = array();
			while($row_curingas = mysqli_fetch_assoc($Ccuringas)){
			  $vr = $row_Oscuringas[$row_curingas['bbh_cam_det_pro_nome']];
			//Campos específicos
				if($row_curingas['bbh_cam_det_pro_nome']=="bbh_dep_codigo"){
                     $sdp = "select bbh_dep_nome from bbh_departamento where bbh_dep_codigo = ".$row_curingas['bbh_cam_det_pro_nome'];
                     list($dpto, $row_dpto, $totalRows) = executeQuery($bbhive, $database_bbhive, $sdp);
                    //--
                    $vr = $row_dpto['bbh_dep_nome'];
				} elseif($row_curingas['bbh_cam_det_pro_nome']=="bbh_pro_flagrante"){
					$vr = $vr == '1' ? "Sim" : "Não";
				} elseif($row_curingas['bbh_cam_det_pro_tipo'] == "json"){
                    $objJson = json_decode(str_replace("`", "\"", $vr), true);
                    $vr = recursiveArrayToList($objJson);
                }

				$curingas[$row_curingas['bbh_cam_det_pro_curinga']]=$vr;
			}
		  
			foreach($curingas as $indice=>$valor){
				array_push($curinga, $valor);
			}

            $curingasProt = $curingas;
            //----
			//recupero os campos do protocolo
			/*foreach($curingasProt as $indice => $valor){
				$curingasProt[$indice] = $row_prot[$indice];
			}*/
			//----

			//efetua o laço trocando o necessário
			$x=0;
			foreach($curingasProt as $indice => $valor){
				//-- Caso seja um curinga "Lista dinâmica árvore"
				if(!isHtml($valor) && preg_match("|([0-9]{2}\.?)+\s.*|", trim($valor)) )
				{
					$valor = explode(' ', $valor);
					array_shift($valor);
					$valor = implode(' ', $valor);
				}
				$conteudo = str_replace($indice,$valor,$conteudo);
			 $x++;
			}
			//----
		}
		//Modelo do fluxo
		$sql = "select CONCAT(bbh_flu_autonumeracao,'/', bbh_flu_anonumeracao) as bbh_caso, bbh_usu_nome, bbh_fluxo.bbh_flu_codigo, bbh_mod_flu_codigo from bbh_fluxo 
						inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
						inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					where bbh_ati_codigo = $bbh_ati_codigo";
        list($flux, $row_flux, $totalRows_flux) = executeQuery($bbhive, $database_bbhive, $sql);
		
		$sql = "select cdf.bbh_cam_det_flu_nome, cdf.bbh_cam_det_flu_curinga from bbh_detalhamento_fluxo as df
 inner join bbh_campo_detalhamento_fluxo as cdf on df.bbh_det_flu_codigo = cdf.bbh_det_flu_codigo
  where df.bbh_mod_flu_codigo  = ".$row_flux['bbh_mod_flu_codigo'];
        list($vrCuringas, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
  
	  $tb_detalhamento = "bbh_modelo_fluxo_".$row_flux['bbh_mod_flu_codigo']."_detalhado";
	  $sql = "select * from $tb_detalhamento where bbh_flu_codigo = ".$row_flux['bbh_flu_codigo'];
        list($OsvrCuringas, $Osrow_vrCuringas, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);
		
			$curingas = array();
			while($row_vrCuringas = mysqli_fetch_assoc($vrCuringas)){
				$curingas[$row_vrCuringas['bbh_cam_det_flu_curinga']]=$Osrow_vrCuringas[$row_vrCuringas['bbh_cam_det_flu_nome']];
			}
		  
			foreach($curingas as $indice=>$valor){
				array_push($curinga, $valor);
			}
			
			$curingasFlux = $curingas;
			
			//efetua o laço trocando o necessário
			$x=0;
			foreach($curingasFlux as $indice => $valor){
				//-- Caso seja um curinga "Lista dinâmica árvore"
				if( preg_match("|([0-9]{2}\.?)+\s.*|", trim($valor)) )
				{
					$valor = explode(' ', $valor);
					array_shift($valor);
					$valor = implode(' ', $valor);
				}
				$conteudo = str_replace($indice,$valor,$conteudo);
			 $x++;
			}
			//----
			//exit($conteudo);

		//--
		  /*$curinga = array();
			foreach($curingasFluxo as $indice=>$valor){
				array_push($curinga, $valor);
			}
			//----
			//recupero os campos do protocolo
			foreach($curingasFlux as $indice => $valor){
				$curingasFlux[$indice] = $row_flux[$indice];
			}
			//----
			//efetua o laço trocando o necessário
			$x=0;
			foreach($curingasFlux as $indice => $valor){
				
				//-- Caso seja um curinga "Lista dinâmica árvore"
				if( preg_match("|([0-9]{2}\.?)+\s.*|", trim($valor)) )
				{
					$valor = explode(' ', $valor);
					array_shift($valor);
					$valor = implode(' ', $valor);
				}
				
				$conteudo = str_replace($curinga[$x],$valor,$conteudo);
			 $x++;
			}*/
			//----
		//--
	//----
?>