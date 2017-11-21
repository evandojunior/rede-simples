<?php
// VALORES DO LAYOUT
//
	define("_largura_pagina",950);			// DEFINE O TAMANHO LIMITE DA PÁGINA, EM PIXELS
	define("_largura_titulo",250);			// DEFINE O TAMANHO PADRÃO DO TÍTULO, EM PIXELS
	define("_largura_campo",700);			// DEFINE O TAMANHO PADRÃO DO CAMPO, EM PIXELS
	define("_estilo_linha","verdana_11_bold");	// O ESTILO USADO NA LINHA
	define("_estilo_campo","verdana_11");	// O ESTILO USADO NO CAMPO
	define("_estilo_titulo","verdana_13_bold");	// O ESTILO USADO NO TITULO
//

class estruturaDetalhamento{
	//--
	var $objXML;
	var $codigoTagXML;
	var $nomeXML;
	var $tituloXML;
	var $defaultXML;
	var $tipoXML;
	var $tamanhoXML;
	var $obrigatorioXML;
	var $unicoXML;
	var $larguraTituloXML;
	var $larguraCampoXML;
	var $mesmaLinhaXML;
	var $exibeCampoXML;
	var $valorXML;
	var $chavePrimariaXML;
	var $exibeLinhaXML;
	var $camposObrigatorios;
	var $elemento;
	//--
	var $tipoExibicao;
	var $estilo_campo;
	var $estilo_linha;
	var $estilo_titulo;
	//--
	var $tabela;
	//--
	var $destino;
	var $acaoForm;
	var $metodo;
	
	//--Decide se montará FORM
	function gerenciaFormulario($destino, $metodo, $exibeBotao, $acao, $titBtnCancelar, $titBtnCadastrar){
		$this->destino			= $destino;
		$this->metodo			= $metodo;
		$this->acaoForm			= $acao;
		$this->exibeBotao		= $exibeBotao;
		$this->titBtnCancelar	= ($titBtnCancelar);
		$this->titBtnCadastrar	= ($titBtnCadastrar);
	}
	//--
	function estruturaDet($xml, $tipoExibicao){
		$this->objXML 		= $xml;
		$this->tipoExibicao = $tipoExibicao;
		$this->estilo_campo = _estilo_campo;
		$this->estilo_linha = _estilo_linha;
		$this->estilo_titulo= _estilo_titulo;
	}
	//Recebe dados
	function recebeDados($xml, $acao){
		$this->objXML = $xml;
		$campos = "";
		$valores= "";
		$dados	= array();
		//--
		//pego o nó principal
		$principal 	  = $this->objXML->getElementsByTagName("dados")->item(0);
		//--
		$tabMultiplas = $principal->getAttribute("tabelasMultiplas");
		$tabPrincipal = $principal->getAttribute("nomedaTabela");
		//--
		//laço com todos os filhos do nó principal, ou seja, as linhas com os campos
		foreach($principal->childNodes as $tituloLinhas){
			//--Identifica as tabelas
			if($tabMultiplas==1){
				$multiplas 		= true;
				$this->tabela 	= $tituloLinhas->getAttribute("nomedaTabela");
			}
			//--Lista os campos deste grupo
			foreach($tituloLinhas->childNodes as $linhas){
				//--Nome das Colunas
				$nomeCP					= ($linhas->getAttribute("nome"));
				$this->chavePrimariaXML = ($linhas->getAttribute("chavePrimaria"));
				//--Valores de cada coluna baseados no POST
				$cdVr = $_POST[$nomeCP];
				//--
				if($this->chavePrimariaXML==1 && !$this->retiraExcessoDeEspaco($cdVr)==""){
					$campoPrimario		= $nomeCP . " = '" .$this->retiraExcessoDeEspaco($cdVr). "'";
				}
				//--
								
				//Verifica se é inserção ou atualização
				if($acao=="insert" && $this->chavePrimariaXML=="0"){
					if(!$this->retiraExcessoDeEspaco($cdVr)==""){
						$campos.= ", ".$nomeCP;
						$valores.=", '".$cdVr."'";
					}
				} elseif($acao=="update" && $this->chavePrimariaXML=="0") {
					if(!$this->retiraExcessoDeEspaco($cdVr)==""){
						$campos.= ", ".$nomeCP." = '".$cdVr."'";
					}
				}
			}
			//--
			if(isset($multiplas)&& $acao=="insert"){
				//--
				$dados[] = "INSERT INTO ".$this->tabela." (".substr($campos,1) . ") VALUES (".substr($valores,1).")";
				//--
				$campos = "";
				$valores= "";
			}elseif(isset($multiplas)&& $acao=="update"){
				//--UPDATE `bbh_protocolos` SET `bbh_pro_titulo`='125/2011' WHERE `bbh_pro_codigo`=403 LIMIT 1|
				$dados[] = "UPDATE INTO ".$this->tabela." SET ".substr($campos,1)." WHERE " . $campoPrimario;
				//--
				$campos = "";
			}
			//--
		}
		//--
		if(!isset($multiplas) && $acao=="insert"){
			$dados[] = "INSERT INTO ".$tabPrincipal." (".substr($campos,1).") VALUES (".substr($valores,1).")";
		} elseif(!isset($multiplas) && $acao=="update"){
			$dados[] = "UPDATE INTO ".$tabPrincipal." SET ".substr($campos,1)." WHERE " . $campoPrimario;
		}
		//--
		return $dados;
	}
	// Monta Layout
	function montaLayout(){
		$_SESSION['aDIV']='fechada';
		//pego o nó principal
		$principal = $this->objXML->getElementsByTagName("dados")->item(0);
		//--
		$c = 0;
		//--Decide se monta FORM
		if(!empty($this->destino) && !empty($this->metodo)){
				echo '<form action="'.$this->destino.'" method="'.$this->metodo.'" name="form1" onsubmit="validaFormDinamico(this); return false">';
				$form = true;
		}
		//laço com todos os filhos do nó principal, ou seja, as linhas com os campos
		foreach($principal->childNodes as $tituloLinhas){
			//--
			$this->exibeLinhaXML = $tituloLinhas->getAttribute("exibeCampo");
			$exibeCampo			 = $this->exibeLinhaXML == 0 ? "visibility:hidden;" : "padding-top:15px;margin-bottom:15px;";
			//--
			//largura da página, ou seja, a div principal terá esta medida
			echo "<div class='{$this->estilo_titulo}' style='width:98%; clear:both;{$exibeCampo}; border-bottom:#FEB600 solid 2px;'>".($tituloLinhas->getAttribute("titulo"))."</div>";
			
			//--Lista os campos deste grupo
			foreach($tituloLinhas->childNodes as $linhas){
				/*
				//--Alimenta atributos da classe recuperando atributos do XML
				$this->codigoTagXML		= $c;
				$this->nomeXML			= ($linhas->getAttribute("nome"));
				$this->tituloXML		= ($linhas->getAttribute("titulo"));
				$this->defaultXML		= ($linhas->getAttribute("default"));
				$this->tipoXML			= ($linhas->getAttribute("tipo"));
				$this->tamanhoXML		= ($linhas->getAttribute("tamanho"));
				$this->obrigatorioXML	= ($linhas->getAttribute("obrigatorio"));
				$this->unicoXML			= ($linhas->getAttribute("unico"));
				$this->larguraTituloXML	= ($linhas->getAttribute("larguraTitulo"));
				$this->larguraCampoXML	= ($linhas->getAttribute("larguraCampo"));
				$this->mesmaLinhaXML	= ($linhas->getAttribute("mesmaLinha"));
				$this->exibeCampoXML	= ($linhas->getAttribute("exibeCampo"));
				$this->valorXML			= ($linhas->getAttribute("valor"));
				$this->chavePrimariaXML	= ($linhas->getAttribute("chavePrimaria"));
				$this->elemento			= $linhas;
				//--
				
				$cam_tamTitulo	= $this->larguraTituloXML > 0 ? $this->larguraTituloXML : _largura_titulo;
				$cam_tamCampo	= $this->larguraCampoXML > 0 ? $this->larguraCampoXML : _largura_campo;
				//$mesmaLinha		= $this->mesmaLinhaXML == 0 ? "clear:both;" : "";
				$mesmaLinha		= $this->mesmaLinhaXML == 0 ? "" : "";
				//--
				//--
				$exibeCampo		= $this->exibeCampoXML == 0 ? "display:none;" : "";
				//--
				//se o tipo do campo for 'texto longo', a altura da DIV deve ser outra...
				if($this->tipoXML=="texto_longo"){
					$quebraTamanho = explode('|',$this->tamanhoXML);
					$alturaDiv = 30 * ($quebraTamanho[1]/2);
				} else {
					$alturaDiv = 30;
				}
				//--
				//se eu possuir o plugin campo obrigatório e o campo for obrigatório, coloco um asterisco
				if($this->obrigatorioXML!=''){
					if($this->obrigatorioXML=="1"){
						$asterisco = '*';
					}else{
						$asterisco = '';
					}
				}else{
					$asterisco = '';	
				}
				//--
				//plugin campo obrigatorio
				if(!empty($this->obrigatorioXML) && $this->obrigatorioXML=="1"){
					$this->camposObrigatorios .= '!@#'.$this->nomeXML."|".$this->tituloXML;
				}	
				
				$valorColunas 	= $cam_tamTitulo + $cam_tamCampo;
				//--
				if($this->tipoXML=="chave_primaria"){
					echo "<input name='".$this->nomeXML."' id='".$this->nomeXML."' readonly='readonly' type='hidden' value='".$this->valorXML	."' />";
				} else {
					//ADICIONAR DICA DO CALOPSITA
					//<div style="width:100%;">
					echo "
					<div class='{$this->estilo_linha}' style='float:left;width:{$valorColunas}px;{$exibeCampo}'>
							<div style='text-align:right;float:left;width:{$cam_tamTitulo}px;'>".
							  $asterisco.($linhas->getAttribute("titulo")).":&nbsp;</div>";
							  $this->exibeCampo();
					   echo "
					</div>";
				}*/
				//--Cada Linha
				//if($linhas->getAttribute("estilo")=="normal"){
					echo "<div>";
						echo $linhas->tagName;
					echo "</div>";
				//}
				$c++;	
			}
		}
		//--
		echo "<input name='campos_obrigatorios' id='campos_obrigatorios' readonly='readonly' type='hidden' value='".substr($this->camposObrigatorios,3)."' />";
		echo "<input name='".$this->acaoForm."' id='".$this->acaoForm."' readonly='readonly' type='hidden' value='1' />";
		
		if(!empty($this->camposObrigatorios)){
			echo "<div style='width:98%; clear:both; color:#339900; padding-top:20px;' align='right'>Os campos marcados com * são obrigatórios.</div>";
		}
		//--
		//Exibe botão
		$lagBtn1 = round(strlen($this->titBtnCancelar) * 8.82);
		$lagBtn2 = round(strlen($this->titBtnCadastrar) * 9.97);
		//--
		if($this->exibeBotao==1){
		echo '<div style="clear:both; padding-top:20px;" align="right">
                	<input name="button" type="button" class="botaoCancelar" id="button" value="'.$this->titBtnCancelar.'" onclick="javascript: history.back();" style="width:'.$lagBtn1.'px;" />
                	<input name="button" type="submit" class="botaoCadastro" id="button" value=" '.$this->titBtnCadastrar.'" style="width:'.$lagBtn2.'px;" />&nbsp;
                </div>';
		}
		//Verifica se fecha form
		if(isset($form)){
			echo "</form>";
		}
	}
	//--
function exibeCampo(){
			//busca os valores no xml
			$cam_codigo		 = $this->codigoTagXML;
			$cam_titulo		 = $this->tituloXML;
			$cam_nome		 = $this->nomeXML;
			$cam_valorPadrao = $this->defaultXML;
			$cam_tipo		 = $this->tipoXML;
			//procedimento padrão
			switch($cam_tipo){
				case "data":
				case "data_hora":
				case "hora":
					$this->campoData($cam_codigo);				break;//campo do tipo data e/ou hora
				case "time_stamp":
					$this->campoDataAtual($cam_codigo);			break;//campo data atual
				case 5:
				case "texto_longo":
					$this->campoTextArea($cam_codigo);			break;//campo text area
				case 6:
				case "lista_opcoes":
					$this->campoCombo($cam_codigo);				break;//campo do tipo combo	
				case "lista_opcoes_dinamica":
					$this->campoComboDinamico($cam_codigo);		break;//campo do tipo combo	 dinâmico
				default:
					$this->campoSimples($cam_codigo);			break;//campos simples
			}
			//plugin preenchimento automático
			//echo "<div id='botaoDinamico_".$cam_codigo."' style='display:inline'></div><div id='divDinamica_".$cam_codigo."' style='display:inline'></div>";
		}
	//--
	//
	// CAMPO SIMPLES (campos comuns, que recebem apenas uma máscara para tratar os caracteres)
	//
		function campoSimples($cam_codigo){
			//busca os valores no xml
			$cam_titulo		 = $this->tituloXML;
			$cam_nome		 = $this->nomeXML;
			$cam_valorPadrao = $this->defaultXML;
			$cam_tipo		 = $this->tipoXML;
			$cam_tamanho	 = $this->tamanhoXML;
			$cam_vlRegistro	 = $this->valorXML;
			$size 			 = $cam_tamanho > 90 ? '90' : $cam_tamanho;
			//array contendo os tipos de campos que possuem o campo simples, na chave, e suas respectivas máscaras, no valor
			$array = array(
				0=>'',															
				1=>'',															//Texto simples
				//3=>'onKeyPress="return(campoDecimal(this,\'.\',\',\',event));"',	//Numero decimal
				3=>'onKeyUp="maskIt(this,event,\'###.###.###.###.###.###.###,##\',true)"',//Numero decimal
				4=>"onKeyPress='mascara_campo(this,campoNumero);'",				//Numero
				7=>"onKeyPress='mascara_campo(this,campoWeb);'",				//Web
				8=>'',															//Correio eletronico
				15=>"onKeyPress='mascara_campo(this,campoTelefoneDDI);'",		//Telefone com DDI
				16=>"onKeyPress='mascara_campo(this,campoCNPJ);'",				//Cnpj
				17=>"onKeyPress='mascara_campo(this,campoTelefone);'",			//Telefone
				
				"texto_simples"=>'',
//				"numero_decimal"=>'onKeyPress="return(campoDecimal(this,\'.\',\',\',event));"',	//Numero decimal
				"numero_decimal"=>'onKeyUp="maskIt(this,event,\'###.###.###.###.###.###.###,##\',true)"',//Numero decimal
				"numero"=>"onKeyPress='mascara_campo(this,campoNumero);'",				//Numero
				"endereco_web"=>"onKeyPress='mascara_campo(this,campoWeb);'"				//Web
			);
			//cria o input text
			$cam_valorPadrao = $cam_vlRegistro;
			ob_flush();
			if($this->tipoExibicao==1){
				echo "<input name='$cam_nome' id='$cam_nome' type='text' value='$cam_valorPadrao' $array[$cam_tipo] class='{$this->estilo_campo}' size='$size' maxlength='$cam_tamanho' />";
			}else if($this->tipoExibicao==2){
				echo "<div style='float:left;display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
			}
			ob_flush();
		}
	//
	// CAMPO COMBO (quando se quer criar um combo)
	//
		function campoCombo($cam_codigo){
			//busca os valores no xml
			$cam_titulo		 = $this->tituloXML;
			$cam_nome		 = $this->nomeXML;
			$cam_valorPadrao = $this->defaultXML;
			$cam_tipo		 = $this->tipoXML;
			$cam_tamanho	 = $this->tamanhoXML;
			$cam_vlRegistro	 = $this->valorXML;
			$oValorPadrao 	 = $cam_vlRegistro;

			if($this->tipoExibicao==1){
				//cria o combo	
				$osValores		= explode("|",$cam_valorPadrao);	
				$setaTamanho	= $cam_tamanho==0?'':"style='width:".$cam_tamanho."px;'";
				//--
				ob_flush();
				echo "<select name='$cam_nome' id='$cam_nome' class='{$this->estilo_campo}' $setaTamanho>";
				foreach($osValores as $valor){
					if(!empty($valor)){
						$selected = $oValorPadrao==$valor?'selected':'';
						echo "<option title='$valor' $selected value='$valor'>$valor</option>";
					}
				}
				echo "</select>";
				ob_flush();
			}else if($this->tipoExibicao==2){
				ob_flush();
				echo "<div style='float:left;display:inline;font-weight:normal'>".$oValorPadrao."</div>";
				ob_flush();
			}
		}
	//
	// CAMPO COMBO DINAMICO
		function campoComboDinamico($cam_codigo){
			//busca os valores no xml
			$cam_titulo		 = $this->tituloXML;
			$cam_nome		 = $this->nomeXML;
			$cam_valorPadrao = $this->defaultXML;
			$cam_tipo		 = $this->tipoXML;
			$cam_tamanho	 = $this->tamanhoXML;
			$cam_vlRegistro	 = $this->valorXML;
			$oValorPadrao 	 = $cam_vlRegistro;
			$elemento		 = $this->elemento;
			
			if($this->tipoExibicao==1){
				//cria o combo	
				$setaTamanho	= $cam_tamanho==0?'':"style='width:".$cam_tamanho."px;'";
				//--
				ob_flush();
				echo "<select name='$cam_nome' id='$cam_nome' class='{$this->estilo_campo}' $setaTamanho>";
				foreach($elemento->childNodes as $cadaOpcao){
						$selected = $cadaOpcao->getAttribute("id")==$oValorPadrao?'selected':'';
						echo "<option title='$valor' $selected value='".$cadaOpcao->getAttribute("id")."'>".($cadaOpcao->getAttribute("label"))."</option>";
				}
				echo "</select>";
				ob_flush();
			}else if($this->tipoExibicao==2){
				ob_flush();
				foreach($elemento->childNodes as $cadaOpcao){
						$oValorPadrao = $cadaOpcao->getAttribute("id")==$oValorPadrao?($cadaOpcao->getAttribute("label")):'';
						break;
				}
				
				echo "<div style='float:left;display:inline;font-weight:normal'>".$oValorPadrao."</div>";
				ob_flush();
			}
		}
	// CAMPO TEXTO LONGO (cria-se uma textarea)
	//
		function campoTextArea($cam_codigo){
			//busca os valores no xml
			$cam_titulo		 = $this->tituloXML;
			$cam_nome		 = $this->nomeXML;
			$cam_valorPadrao = $this->defaultXML;
			$cam_tipo		 = $this->tipoXML;
			$cam_tamanho	 = $this->tamanhoXML;
			$cam_vlRegistro	 = $this->valorXML;
			$oValorPadrao 	 = $cam_vlRegistro;

			if($this->tipoExibicao==1){
				//cria a textarea, com a largura e altura informada
				$quebraTamanho = explode('|',$cam_tamanho);
				ob_flush();
				echo "<textarea name='$cam_nome' id='$cam_nome' class='{$this->estilo_campo}' rows='{$quebraTamanho[1]}' cols='{$quebraTamanho[0]}' >$cam_valorPadrao</textarea>";
				ob_flush();
			}else if($this->tipoExibicao==2){
				ob_flush();
				echo "<div style='float:left;display:inline;font-weight:normal'>".nl2br($cam_valorPadrao)."</div>";
				ob_flush();
			}
		}
	//
	// DATA E HORA ATUAL
	//
		function campoDataAtual($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->nomeXML;
			$cam_vlRegistro	 = $this->valorXML;
			$oValorPadrao 	 = $cam_vlRegistro;
			
			if($this->tipoExibicao==1){
				$dataAtual = date('Y-m-d H:i:s');
				echo "<div style='float:left;display:inline;font-weight:normal'>".date('d/m/Y H:i:s')."</div>";
				echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='$dataAtual' />";
			}else if($this->tipoExibicao==2){
				if(!empty($cam_valorPadrao)){
					$quebraData	= explode(' ',$cam_valorPadrao);
					$cam_valorPadrao = arrumadata($quebraData[0]);
				}else{
					$cam_valorPadrao = '';
				}
				echo "<div style='float:left;display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
			}
		}
	// COMBO DATA
	//
		function comboData($cam_nome,$tipo,$compl,$intervalo,$valorPadrao){
			$quebra = explode('-',$intervalo);
			echo "<select name='{$cam_nome}{$compl}' id='{$cam_nome}{$compl}' class='{$this->estilo_campo}' onChange='preencheData(\"{$tipo}\",\"$cam_nome\");'>";
			for($d=$quebra[0];$d<=$quebra[1];$d++){
				$dia=$d<10?'0'.$d:$d;
				$selected = $valorPadrao==$dia?'selected':'';
				echo "<option title='$dia' value='$dia' $selected>$dia</option>";
			}
			echo "</select>";	
		}
	//
	// CAMPO DATA
	//		
		function campoData($cam_codigo){
			//busca os valores no xml
			$cam_titulo		 = $this->tituloXML;
			$cam_nome		 = $this->nomeXML;
			$cam_valorPadrao = $this->defaultXML;
			$cam_tipo		 = $this->tipoXML;
			$cam_tamanho	 = $this->tamanhoXML;
			$cam_vlRegistro	 = $this->valorXML;
			$oValorPadrao 	 = $cam_vlRegistro;

			if($this->tipoExibicao==1){
				//se eu for data ou data com hora, crio os combos de data
				switch($cam_tipo){
					case 2:
					case "data":
						$cam_valorPadrao = !empty($cam_valorPadrao)?$cam_valorPadrao:date('Y-m-d H:i:s'); 
						$quebraData = explode('-',$cam_valorPadrao);
						$oDia = explode(' ',$quebraData[2]);
						$this->comboData($cam_nome,'data','_dia','1-31',$oDia[0]); echo "/";
						$this->comboData($cam_nome,'data','_mes','1-12',$quebraData[1]); echo "/";
						$this->comboData($cam_nome,'data','_ano','1910-2030',$quebraData[0]);
						echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='".date('Y-m-d')."' />";
						break;
					case 9:
					case "data_hora":
						$cam_valorPadrao = !empty($cam_valorPadrao)?$cam_valorPadrao:date('Y-m-d H:i:s'); 
						$quebraData = explode('-',$cam_valorPadrao);
						$oDia = explode(' ',$quebraData[2]);
						$this->comboData($cam_nome,'data_hora','_dia','1-31',$oDia[0]); echo "/";
						$this->comboData($cam_nome,'data_hora','_mes','1-12',$quebraData[1]); echo "/";
						$this->comboData($cam_nome,'data_hora','_ano','1910-2030',$quebraData[0]);
						echo '&nbsp;&nbsp;'; $quebraHora = explode(':',$oDia[1]);
						$this->comboData($cam_nome,'data_hora','_hora','0-23',$quebraHora[0]); echo ":";
						$this->comboData($cam_nome,'data_hora','_min','0-59',$quebraHora[1]); echo ":";
						$this->comboData($cam_nome,'data_hora','_seg','0-59',$quebraHora[2]);
						echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='".date('Y-m-d H:i:s')."' />";
						break;
					case 12:
					case "hora":
						$cam_valorPadrao = !empty($cam_valorPadrao)?$cam_valorPadrao:date('H:i:s'); 
						$quebraHora = explode(':',$cam_valorPadrao);
						$this->comboData($cam_nome,'hora','_hora','0-23',$quebraHora[0]); echo ":";
						$this->comboData($cam_nome,'hora','_min','0-59',$quebraHora[1]); echo ":";
						$this->comboData($cam_nome,'hora','_seg','0-59',$quebraHora[2]);
						echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='".date('H:i:s')."' />";
						break;
				}
			}else if($this->tipoExibicao==2){
				switch($cam_tipo){
					case 2:
					case "data":
						if(!empty($cam_valorPadrao)){
							$quebraData	= explode(' ',$cam_valorPadrao);
							$cam_valorPadrao = arrumadata($quebraData[0]);
						}else{
							$cam_valorPadrao = '';
						}
						echo "<div style='float:left;display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
						break;
					case 9:
					case "data_hora":
						if(!empty($cam_valorPadrao)){
							$quebraData	= explode(' ',$cam_valorPadrao);
							$cam_valorPadrao = arrumadata($quebraData[0]).' '.substr($quebraData[1],0,-3);
						}else{
							$cam_valorPadrao = '';
						}
						echo "<div style='float:left;display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
						break;
					case 12:
					case "hora":
						$cam_valorPadrao = empty($cam_valorPadrao)?'':substr($cam_valorPadrao,0,-3);
						echo "<div style='float:left;display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
					break;
				}
			}
		}
	//
	function retiraExcessoDeEspaco($str){
		return preg_replace('/\s\s+/', ' ', trim($str));
	}
}
?>