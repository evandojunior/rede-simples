<?php
//========== PÁGINA DA CLASSE DO PLUGIN ==========//
//
// CLASSE
//
	include('config.php');
	class Campo_backsite{
	//
	// VARIÁVEIS
	//
		// BANCO DE DADOS
			public $sql 			= _sql;
			public $database_sql	= _database_sql;
			public $rsSQL;
			public $row_sql;
			public $totalRows_sql;
			public $codGrupo;
			public $codRegistro;
			public $stringExecucao	= array();
			public $tipoExibicao;
			public $localPadrao		= _localPadrao;
		// NOMES DOS CAMPOS DA TABELA QUE USO OBRIGATORIAMENTE NA CLASSE
			public $nmTabela_campo;
			public $nmTabela_dinamica;
			public $nmCampo_codRegistro;
			public $nmCampo_codigoCampo;
			public $nmCampo_codigoGrupo;
			public $nmCampo_titulo;
			public $nmCampo_nome;
			public $nmCampo_tamanho;
			public $nmCampo_valorPadrao;
			public $nmCampo_tipo;
		// NOMES DOS CAMPOS DA TABELA QUE USO OPCIONALMENTE NA CLASSE (OS 'PLUGINS' DA CLASSE)
			//campo automatico
			public $campo_automatico = array();
			//ordem de exibição
			public $nmCampo_ordemExibicao;
			//campo obrigatório
			public $nmCampo_obrigatorio;
			public $campo_obrigatorio;
			//valor único
			public $nmCampo_unico;
			public $campo_unico;
			//layout dinamico
			public $nmCampo_larguraTitulo;
			public $nmCampo_larguraCampo;
			public $nmCampo_linhaTitulo;
			public $nmCampo_linhaCampo;
			//busca dinâmica
			public $nmCampo_buscaDinamica;
		// XML
			public $domXML;
		// LAYOUT PADRÃO
			public $largura_pagina	= _largura_pagina;
			public $largura_titulo	= _largura_titulo;
			public $largura_campo	= _largura_campo;
			public $estilo_linha	= _estilo_linha;
			public $estilo_campo	= _estilo_campo;
		// RETORNO
			public $retorno;
	//
	// INICIA O EXECUTA
	//	
		function __construct($dadosTabela,$codGrupo){
			//seto as variáveis do array 'dadosTabela'
			$this->nmTabela_campo			= $dadosTabela["nmTabela_campo"];
			$this->nmTabela_dinamica		= $dadosTabela["nmTabela_dinamica"];
			$this->nmCampo_codRegistro		= $dadosTabela["nmCampo_codRegistro"];
			$this->nmCampo_codigoCampo		= $dadosTabela["nmCampo_codigoCampo"];
			$this->nmCampo_codigoGrupo		= $dadosTabela["nmCampo_codigoGrupo"];
			$this->nmCampo_titulo			= $dadosTabela["nmCampo_titulo"];
			$this->nmCampo_nome				= $dadosTabela["nmCampo_nome"];
			$this->nmCampo_tamanho			= $dadosTabela["nmCampo_tamanho"];
			$this->nmCampo_valorPadrao		= $dadosTabela["nmCampo_valorPadrao"];
			$this->nmCampo_tipo				= $dadosTabela["nmCampo_tipo"];
			$this->nmCampo_ordemExibicao	= $dadosTabela["nmCampo_ordemExibicao"];
			$this->nmCampo_obrigatorio		= $dadosTabela["nmCampo_obrigatorio"];
			$this->nmCampo_unico			= $dadosTabela["nmCampo_unico"];
			$this->nmCampo_larguraTitulo	= $dadosTabela["nmCampo_larguraTitulo"];
			$this->nmCampo_larguraCampo		= $dadosTabela["nmCampo_larguraCampo"];
			$this->nmCampo_linhaTitulo		= $dadosTabela["nmCampo_linhaTitulo"];
			$this->nmCampo_linhaCampo		= $dadosTabela["nmCampo_linhaCampo"];
			$this->nmCampo_buscaDinamica	= $dadosTabela["nmCampo_buscaDinamica"];
			//seto as variáveis que contem o código do grupo e o código do registro
			$this->codGrupo					= $codGrupo;
		}
	//
	// OS TIPOS DOS CAMPOS
	//
		function comboTipo(){
			$osTipos = array(
				 1 => 'Texto Simples',
				 2 => 'Data',
				 3 => 'Número Decimal',
				 4 => 'Número',
				 5 => 'Texto Longo',
				 6 => 'Lista de Opções',
				 7 => 'Endereço Web',
				 8 => 'Correio Eletrônico',
				 9 => 'Data e Hora Editável',
				10 => 'Data e Hora Atual',
				11 => 'Número Sequencial',
				12 => 'Hora',
				13 => 'Valor Agrupado',
				14 => 'Lista Dinâmica',
				15 => 'Telefone com DDI',
				16 => 'CNPJ',
				17 => 'Telefone',
				18 => 'Data com Calendário',
			);

			echo "<select name='{$this->nmCampo_tipo}' id='{$this->nmCampo_tipo}' class='{$this->estilo_campo}' onChange='mostraOpcaoTipo(this.value);'>";
				echo "<option title='Selecione' value='0'>Selecione</option>";
			foreach($osTipos as $chave => $valor){
				echo "<option title='$valor' value='$chave'>$valor</option>";
			}
			echo "</select>";	


		}
	//
	// EXIBE O FORMULÁRIO COM AS OPÇÕES DE CRIAÇÃO DOS CAMPOS
	//
		function exibeFormulario($nome_grupo){
			require_once($_SESSION['EndFisico'].$this->localPadrao.'criacao.php');
		}
	//
	// CRIA UMA STRING COM O NOME DOS CAMPOS E OS CAMPOS RECEBIDOS
	//
		function verificaCampo($nmCampo,$vlCampo){
			mysql_select_db($this->database_sql, $this->sql);
			$pesqSQL = mysql_query("SELECT $this->nmCampo_nome, $this->nmCampo_tipo FROM $this->nmTabela_campo WHERE $this->nmCampo_nome = '$nmCampo'", $this->sql);
			$row_pesqSQL = mysqli_fetch_assoc($pesqSQL);
			$totalRows_pesqSQL = mysql_num_rows($pesqSQL);
			if($totalRows_pesqSQL>0){
				$this->stringExecucao[$nmCampo.'|'.$row_pesqSQL[$this->nmCampo_tipo]] = $vlCampo;
			}
		}
	//
	// EXECUTA CAMPO
	//
		function executaCampoSQL($procedimento,$codGrupo,$codRegistro){
			//separa as variáveis
			$osCampos = '';
			$osValores = '';
			foreach($this->stringExecucao as $chave => $valor){
				$quebraNome = explode('|',$chave);
				switch($quebraNome[1]){
					case 3:
						if(empty($valor)){
							$valor = 0.00;
						}else{
							$valor = str_replace(".","",$valor);
							$valor = str_replace(",",".",$valor);
						}
						break;
					case 18:
						$valor = arrumadata($valor); 
				}
				switch($procedimento){
					case 'inserir':
						$osCampos 	.= ','.$quebraNome[0];
						$osValores	.= ",'".addslashes($valor)."'";
						break;
					case 'editar':
						$osCampos 	.= ','.$quebraNome[0]."='".addslashes($valor)."'";
						break;
				}
			}
			switch($procedimento){
				case 'inserir':
					$osCampos = substr($osCampos,1);
					$osValores = substr($osValores,1);
					//$stringSQL = "INSERT INTO {$this->nmTabela_dinamica}{$codGrupo} ($this->nmCampo_codRegistro,$osCampos) VALUES ($codRegistro,$osValores)";
					$stringSQL = "INSERT INTO {$this->nmTabela_dinamica} ($this->nmCampo_codRegistro,$osCampos) VALUES ($codRegistro,$osValores)";
					break;
				case 'editar':
					$osCampos = substr($osCampos,1);
					$stringSQL = "UPDATE {$this->nmTabela_dinamica}{$codGrupo} SET $osCampos WHERE $this->nmCampo_codRegistro=$codRegistro";
					break;
					
			}
			mysql_select_db($this->database_sql, $this->sql);
			mysql_query($stringSQL, $this->sql);
		}
	//
	// CRIA O XML COM TODOS OS CAMPOS DO GRUPO (COM SUPORTE AOS PLUGINS)
	//
		function criaXML(){
			//pesquiso todos os campos da tabela de campos onde o código do grupo é aquele que enviei no parâmetro da classe
			mysql_select_db($this->database_sql, $this->sql);
			$pesqSQL = mysql_query("SELECT * FROM {$this->nmTabela_campo} #WHERE {$this->nmCampo_codigoGrupo} = {$this->codGrupo}", $this->sql);
			$row_pesqSQL = mysqli_fetch_assoc($pesqSQL);
			//instancio a classe DOM que cria o XML e crio o nó principal
			$dom = new DOMDocument("1.0", "iso-8859-1");
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = false;
			$root = $dom->createElement("root");
			$i = 0;
			//pesquiso o valor do campo, caso eu já possua um registro
			if($this->codRegistro!=0){
				$queryConsulta = "SELECT * FROM {$this->nmTabela_dinamica}{$this->codGrupo} WHERE $this->nmCampo_codRegistro = ".$this->codRegistro;
				$this->consulta($queryConsulta);
			}
			//laço com todos os campos do grupo
			do{
				//se eu possuo o plugin de layout
				if($this->nmCampo_larguraTitulo!=''){
					//Crio uma nova linha se sou o primeiro nó ou se o campo não é junto com o anterior
					if(($row_pesqSQL[$this->nmCampo_linhaCampo]==0)||($i==0)){
						$i++;
						$linha = $dom->createElement("linha_".$i);
					}
				//se não possuo o plugin de layout cada campo ficará em uma nova linha
				}else{
					$linha = $dom->createElement("linha_".$i);
				}
				//seta no xml as variáveis padrão (coloquei os 'arrobas' para não mostrar os notices sobre a codigicação utf8)
				 $campo = $dom->createElement("campo_".$row_pesqSQL[$this->nmCampo_codigoCampo]);
				 $campo->setAttribute("cam_codigo",			$row_pesqSQL[$this->nmCampo_codigoCampo]);
				@$campo->setAttribute("cam_titulo",			$row_pesqSQL[$this->nmCampo_titulo]);
				 $campo->setAttribute("cam_nome",			$row_pesqSQL[$this->nmCampo_nome]);
				 $campo->setAttribute("cam_tamanho",		$row_pesqSQL[$this->nmCampo_tamanho]);
				@$campo->setAttribute("cam_valorPadrao",	$row_pesqSQL[$this->nmCampo_valorPadrao]);
				 $campo->setAttribute("cam_tipo",			$row_pesqSQL[$this->nmCampo_tipo]);
				//insiro no nó o valor do campo, caso eu já possua um registro
				if($this->codRegistro!=0){
					 @$campo->setAttribute("cam_vlRegistro",	$this->row_sql[$row_pesqSQL[$this->nmCampo_nome]]);
				}else{
					 $campo->setAttribute("cam_vlRegistro",	"");
				}
				//se eu possuo o plugin de layout
				if($this->nmCampo_larguraTitulo!=''){
					//seta no xml as variaveis do plugin de layout
					$campo->setAttribute("cam_tamTitulo",	$row_pesqSQL[$this->nmCampo_larguraTitulo]);
					$campo->setAttribute("cam_tamCampo",	$row_pesqSQL[$this->nmCampo_larguraCampo]);
					$campo->setAttribute("cam_linhaTitulo",	$row_pesqSQL[$this->nmCampo_linhaTitulo]);
				}
				//seta no xml as variaveis do plugin de valor unico
				if($this->nmCampo_unico!=''){
					$campo->setAttribute("cam_unico",$row_pesqSQL[$this->nmCampo_unico]);
				}					
				//seta no xml as variáveis do plugin de campo obrigatorio
				if($this->nmCampo_obrigatorio!=''){
					$campo->setAttribute("cam_obrigatorio",$row_pesqSQL[$this->nmCampo_obrigatorio]);
				}					
				//append dos nós-filhos
				$linha->appendChild($campo);
				$root->appendChild($linha);
			}while($row_pesqSQL = mysqli_fetch_assoc($pesqSQL));
			$dom->appendChild($root); 
			//coloco o XML em uma variável
			$this->domXML = $dom;
		}
	//
	// MONTA O LAYOUT
	//
		function montaLayout($tipo,$codRegistro=0){
			//seta tipo de exibição
			$this->tipoExibicao = $tipo;
			//seta o código do registro
			$this->codRegistro = $codRegistro;
			//crio o xml
			$this->criaXML();
			//pego o nó principal
			$principal = $this->domXML->getElementsByTagName("root")->item(0);
			//laço com todos os filhos do nó principal, ou seja, as linhas com os campos
			foreach($principal->childNodes as $linhas){
				//largura da página, ou seja, a div principal terá esta medida
				$largura_pagina = $this->largura_pagina;
				echo "<div width:{$largura_pagina}px'>";
				//laço com as colunas
				foreach($linhas->childNodes as $campos){
					//se eu possuo o plugin de layout
					if($this->nmCampo_larguraTitulo!=''){
						$cam_tamTitulo	= $campos->getAttribute('cam_tamTitulo')!=''?$campos->getAttribute('cam_tamTitulo'):$this->largura_titulo;
						$cam_tamCampo	= $campos->getAttribute('cam_tamCampo')!=''?$campos->getAttribute('cam_tamCampo'):$this->largura_campo;
					}else{
						$cam_tamTitulo	= $this->largura_titulo;
						$cam_tamCampo	= $this->largura_campo;
					}
					//se o tipo do campo for 'texto longo', a altura da DIV deve ser outra...
					if($campos->getAttribute('cam_tipo')==5){
						$quebraTamanho = explode('//',$campos->getAttribute('cam_tamanho'));
						$alturaDiv = 30*($quebraTamanho[0]/2);
					}elseif($campos->getAttribute('cam_tipo')=="texto_longo"){
						$quebraTamanho = explode('|',$campos->getAttribute('cam_tamanho'));
						$alturaDiv = 30*($quebraTamanho[1]/2);
					}else{
						$alturaDiv = 30;
					}
					//se eu possuir o plugin campo obrigatório e o campo for obrigatório, coloco um asterisco
					if($this->nmCampo_obrigatorio!=''){
						$cam_obrigatorio = $campos->getAttribute('cam_obrigatorio');
						if($cam_obrigatorio==1){
							$asterisco = '*';
						}else{
							$asterisco = '';
						}
					}else{
						$asterisco = '';	
					}
					$valorColunas = $cam_tamTitulo+$cam_tamCampo;
					
					echo "
					<div class='{$this->estilo_linha}' style='float:left;width:{$valorColunas}px;height:{$alturaDiv}px'>
					<div style='height:{$alturaDiv}px;text-align:right;float:left;width:{$cam_tamTitulo}px;'>".
					$asterisco.$campos->getAttribute('cam_titulo').":&nbsp;
					</div>
					<div style='height:{$alturaDiv}px;float:left;width:{$cam_tamCampo}px;'>";
					$this->exibeCampo($campos->getAttribute('cam_codigo'));
					echo "
					</div>
					</div>";
                }
				echo "</div>";
			}
			//plugin campo automatico
			$this->campoAutomatico();
			//plugin valor único
			if(!empty($this->campo_unico)){
				$this->retorno .= '#CAMPO_UNICO='.substr($this->campo_unico,9).'<%SEP_1%>'.$this->nmTabela_dinamica.$this->codGrupo;
			}
			//plugin campo obrigatorio
			if(!empty($this->campo_obrigatorio)){
				$this->retorno .= '#CAMPO_OBRIGATORIO='.substr($this->campo_obrigatorio,9);
			}
		}
	//
	// MONTA O CAMPO DE ACORDO COM O LAYOUT SOLICITADO
	//
		function exibeCampo($cam_codigo){
			//busca os valores no xml
			$cam_titulo		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_titulo');
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_tipo		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tipo');
			if($this->tipoExibicao==1){
				//plugin campo automático
				$posicao = stripos($cam_valorPadrao,'<DINAMICO');
				if($posicao !== false){
					$explodeCampoAutomatico = explode(':',$cam_valorPadrao);
					$this->campo_automatico[$cam_valorPadrao.$cam_codigo.','.$this->nmTabela_dinamica] = $explodeCampoAutomatico[1];
					$this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->setAttribute("cam_valorPadrao",'');
				}
				//plugin valor único
				if($this->nmCampo_unico!=''){
					$cam_unico = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_unico');
					if($cam_unico==1){
						$this->campo_unico  .= '<%SEP_2%>'.$cam_nome.'<%SEP_3%>'.$cam_titulo;
					}
				}	
				//plugin campo obrigatório
				if($this->nmCampo_obrigatorio!=''){
					$cam_obrigatorio = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_obrigatorio');
					if($cam_obrigatorio==1){
						//se eles não forem combos
						if(($cam_tipo!=2)&&($cam_tipo!=6)&&($cam_tipo!=9)&&($cam_tipo!=12)&&($cam_tipo!=14)){
							$this->campo_obrigatorio .= '<%SEP_2%>'.$cam_nome.'<%SEP_3%>'.$cam_titulo;
						}
					}
				}
			}
			//procedimento padrão
			switch($cam_tipo){
				case 2:
				case 9:
				case 12:
					$this->campoData($cam_codigo);				break;//campo do tipo data e/ou hora
				case 5:
					$this->campoTextArea($cam_codigo);			break;//campo text area
				case 6:
					$this->campoCombo($cam_codigo);				break;//campo do tipo combo
				case 10:
					$this->campoDataAtual($cam_codigo);			break;//campo data atual
				case 11;
					$this->campoNumeroSequencial($cam_codigo);	break;//campo número sequencial
				case 13;
					$this->campoValorAgrupado($cam_codigo);		break;//campo valor agrupado
				case 14:
					$this->campoComboDinamico($cam_codigo);		break;//campo do tipo combo dinâmico
				case 18:
					$this->campoDataCalendario($cam_codigo);	break;//campo data com calendário
				case 19:
					$this->campoComboLink($cam_codigo);			break;//campo combo-link
			

				case "horario_editavel":	
				case "data":
					$this->campoData($cam_codigo);				break;//campo do tipo data e/ou hora
				case "texto_longo":
					$this->campoTextArea($cam_codigo);			break;//campo text area
				case "lista_opcoes":
					$this->campoCombo($cam_codigo);				break;//campo do tipo combo
				case "time_stamp":
					$this->campoDataAtual($cam_codigo);			break;//campo data atual
					
				default:
					$this->campoSimples($cam_codigo);			break;//campos simples
			}
			//plugin preenchimento automático
			echo "<div id='botaoDinamico_".$cam_codigo."' style='display:inline'></div><div id='divDinamica_".$cam_codigo."' style='display:inline'></div>";
		}
	//
	// CAMPO SIMPLES (campos comuns, que recebem apenas uma máscara para tratar os caracteres)
	//
		function campoSimples($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_tamanho	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tamanho');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_tipo		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tipo');
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			$size 			 = $cam_tamanho<25?$cam_tamanho:'23';
			//array contendo os tipos de campos que possuem o campo simples, na chave, e suas respectivas máscaras, no valor
			$array = array(
				0=>'',															
				1=>'',															//Texto simples
				3=>'onKeyPress="return(campoDecimal(this,\'\',\',\',event));"',	//Numero decimal
				4=>"onKeyPress='mascara_campo(this,campoNumero);'",				//Numero
				7=>"onKeyPress='mascara_campo(this,campoWeb);'",				//Web
				8=>'',															//Correio eletronico
				15=>"onKeyPress='mascara_campo(this,campoTelefoneDDI);'",		//Telefone com DDI
				16=>"onKeyPress='mascara_campo(this,campoCNPJ);'",				//Cnpj
				17=>"onKeyPress='mascara_campo(this,campoTelefone);'",			//Telefone
				
				"texto_simples"=>'',
				"numero_decimal"=>'onKeyPress="return(campoDecimal(this,\'\',\',\',event));"',	//Numero decimal
				"numero"=>"onKeyPress='mascara_campo(this,campoNumero);'",				//Numero
				"endereco_web"=>"onKeyPress='mascara_campo(this,campoWeb);'"				//Web
			);
			//cria o input text
			if($this->codRegistro!=0){
				$cam_valorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				echo "<input name='$cam_nome' id='$cam_nome' type='text' value='$cam_valorPadrao' $array[$cam_tipo] class='{$this->estilo_campo}' size='$size' maxlength='$cam_tamanho' />";
			}else if($this->tipoExibicao==2){
				echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
			}
		}
	//
	// CAMPO COMBO (quando se quer criar um combo)
	//
		function campoCombo($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_tamanho	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tamanho');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$oValorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				//cria o combo
				//$osValores		= explode("<%SEPARA_VALOR%>",$cam_valorPadrao);	
				$osValores		= explode("|",$cam_valorPadrao);	
				$setaTamanho	= $cam_tamanho==0?'':"style='width:".$cam_tamanho."px;'";
				echo "<select name='$cam_nome' id='$cam_nome' class='{$this->estilo_campo}' $setaTamanho>";
				foreach($osValores as $valor){
					if(!empty($valor)){
						$selected = $oValorPadrao==$valor?'selected':'';
						echo "<option title='$valor' $selected value='$valor'>$valor</option>";
					}
				}
				echo "</select>";
			}else if($this->tipoExibicao==2){
				echo "<div style='display:inline;font-weight:normal'>".$oValorPadrao."</div>";
			}
		}
	//
	// CAMPO COMBO DINÂMICO (quando se quer criar um combo cujo valores são os dados de uma outra tabela dinâmica)
	//
		function campoComboDinamico($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_tamanho	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tamanho');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$oValorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				//quebra o valor
				$quebraValor = explode(':',$cam_valorPadrao);
				//busca o nome da tabela física
				$nmTabela = $this->nmTabela_dinamica.$quebraValor[1];
				//busca o nome do campo a buscar
				$this->consulta("SELECT $this->nmCampo_nome FROM $this->nmTabela_campo WHERE $this->nmCampo_codigoCampo = $quebraValor[2]");
				$nmCampo = $this->row_sql[$this->nmCampo_nome];
				//busca o nome do valor da busca 
				$this->consulta("SELECT $this->nmCampo_nome FROM $this->nmTabela_campo WHERE $this->nmCampo_codigoCampo = ".substr($quebraValor[3],0,-1));
				$nmValor = $this->row_sql[$this->nmCampo_nome];
				//resultado
				$this->consulta("SELECT $nmCampo, $nmValor FROM $nmTabela ORDER BY $nmCampo ASC");
				$string = '';
				do{
					$string .= str_replace('|','',str_replace(',','',$this->row_sql[$nmCampo])).'<%SEPARA_DADOS%>'.str_replace('|','',str_replace(',','',$this->row_sql[$nmValor])).'<%SEPARA_VALOR%>';
				}while($this->row_sql = mysqli_fetch_assoc($this->rsSQL));
				$string = substr($string,0,-16);
	
				$osValores		= explode("<%SEPARA_VALOR%>",$string);	
				$setaTamanho	= $cam_tamanho==0?'':"style='width:".$cam_tamanho."px;'";
				echo "<select name='$cam_nome' id='$cam_nome' class='{$this->estilo_campo}' $setaTamanho>";
				foreach($osValores as $valor){
					$quebraValor = explode("<%SEPARA_DADOS%>",$valor);
					$oCampo = $quebraValor[0];
					$oValor = $quebraValor[1];					
					$selected = $oValorPadrao==$oValor?'selected':'';
					echo "<option title='$oCampo' $selected value='$oValor'>$oCampo</option>";
				}
				echo "</select>";	
			}else if($this->tipoExibicao==2){
				echo "<div style='display:inline;font-weight:normal'>".$oValorPadrao."</div>";
			}
		}
	//
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
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_tamanho	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tamanho');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_tipo		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tipo');
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$cam_valorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				//se eu for data ou data com hora, crio os combos de data
				switch($cam_tipo){
					case 2:
						$cam_valorPadrao = !empty($cam_valorPadrao)?$cam_valorPadrao:date('Y-m-d H:i:s'); 
						$quebraData = explode('-',$cam_valorPadrao);
						$oDia = explode(' ',$quebraData[2]);
						$this->comboData($cam_nome,'data','_dia','1-31',$oDia[0]); echo "/";
						$this->comboData($cam_nome,'data','_mes','1-12',$quebraData[1]); echo "/";
						$this->comboData($cam_nome,'data','_ano','1910-2030',$quebraData[0]);
						echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='".date('Y-m-d')."' />";
						break;
					case 9:
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
						if(!empty($cam_valorPadrao)){
							$quebraData	= explode(' ',$cam_valorPadrao);
							$cam_valorPadrao = arrumadata($quebraData[0]);
						}else{
							$cam_valorPadrao = '';
						}
						echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
						break;
					case 9:
						if(!empty($cam_valorPadrao)){
							$quebraData	= explode(' ',$cam_valorPadrao);
							$cam_valorPadrao = arrumadata($quebraData[0]).' '.substr($quebraData[1],0,-3);
						}else{
							$cam_valorPadrao = '';
						}
						echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
						break;
					case 12:
						$cam_valorPadrao = empty($cam_valorPadrao)?'':substr($cam_valorPadrao,0,-3);
						echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
					break;
				}
			}
		}
	//
	// CAMPO TEXTO LONGO (cria-se uma textarea)
	//
		function campoTextArea($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_tamanho	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tamanho');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$cam_valorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				//cria a textarea, com a largura e altura informada
				//$quebraTamanho = explode('//',$cam_tamanho);
				$quebraTamanho = explode('|',$cam_tamanho);
				echo "<textarea name='$cam_nome' id='$cam_nome' class='{$this->estilo_campo}' rows='{$quebraTamanho[1]}' cols='{$quebraTamanho[0]}' >$cam_valorPadrao</textarea>";
			}else if($this->tipoExibicao==2){
				echo "<div style='display:inline;font-weight:normal'>".nl2br($cam_valorPadrao)."</div>";
			}
		}
	//
	// DATA E HORA ATUAL
	//
		function campoDataAtual($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			//cria o campo hidden
			if($this->codRegistro!=0){
				$cam_valorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				$dataAtual = date('Y-m-d H:i:s');
				echo "<div style='display:inline;font-weight:normal'>".date('d/m/Y H:i:s')."</div>";
				echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='$dataAtual' />";
			}else if($this->tipoExibicao==2){
				if(!empty($cam_valorPadrao)){
					$quebraData	= explode(' ',$cam_valorPadrao);
					$cam_valorPadrao = arrumadata($quebraData[0]);
				}else{
					$cam_valorPadrao = '';
				}
				echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
			}
		}
	//
	// NUMERO SEQUENCIAL
	//
		function campoNumeroSequencial($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_valorPadrao = '';
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$cam_valorPadrao = $cam_vlRegistro;
			}else{
				//busca quantos registros possuo na tabela  dinamica e adiciono 1.
				$this->consulta("SELECT COUNT({$this->nmTabela_dinamica}codigo) as id FROM ".$this->nmTabela_dinamica.$this->codGrupo);
				$cam_valorPadrao = $this->row_sql['id']+1;
			}
			if($this->tipoExibicao==1){
				echo "<div style='display:inline;font-weight:normal'>&nbsp;".$cam_valorPadrao."</div>";
				echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='$cam_valorPadrao' />";
			}else if($this->tipoExibicao==2){
				echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
			}
		}
	//
	// VALOR AGRUPADO
	//
		function campoValorAgrupado($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_tamanho	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tamanho');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$size 			 = $cam_tamanho<25?$cam_tamanho:'23';
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$oValorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				// valor padrão
				$quebraValor = explode('<%SEPARA_VALOR%>',$cam_valorPadrao);
				$separador	 = $quebraValor[1];
				$osCampos	 = $quebraValor[0];
				echo "<input name='$cam_nome' id='$cam_nome' type='hidden' value='' />";
				echo "<input name='{$cam_nome}_desab' id='{$cam_nome}_desab' type='text' disabled value='' class='{$this->estilo_campo}' size='$size' maxlength='$cam_tamanho' />";
				echo '&nbsp;<input name="insere" id="insere" value="Gerar" class="{$this->estilo_campo}" type="button" onClick="insereValorAgrupado(\''.$cam_valorPadrao.'\',\''.$cam_nome.'\')" />';
			}else if($this->tipoExibicao==2){
				echo "<div style='display:inline;font-weight:normal'>".$oValorPadrao."</div>";
			}
		}
	//
	// DATA COM CALENDÁRIO
	//
		function campoDataCalendario($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_valorPadrao = empty($cam_valorPadrao)?date('d/m/Y'):$cam_valorPadrao;
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$cam_valorPadrao = $cam_vlRegistro;
				$quebraData	= explode(' ',$cam_valorPadrao);
				$cam_valorPadrao = arrumadata($quebraData[0]);
			}
			if($this->tipoExibicao==1){
				//cria o campo
				echo '<input name="'.$cam_nome.'" id="'.$cam_nome.'" type="text" value="'.$cam_valorPadrao.'" onKeyPress="MascaraData(event, this)" size="8" maxlength="10" class="'.$this->estilo_campo.'" /><input type="button" style="width:23px;height:16px;" class="botao_calendar" onClick="displayCalendar(document.form1.'.$cam_nome.',\'dd/mm/yyyy\',this)"/>';
			}else if($this->tipoExibicao==2){
				$quebraData	= explode(' ',$cam_valorPadrao);
				$cam_valorPadrao = arrumadata($quebraData[0]);
				echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
			}
		}
	//
	// UM TIPO GAMBIARRENTO PRA ARCELORMITTAL - PADRONIZAR DEPOIS
	//
		function campoComboLink($cam_codigo){
			//busca os valores no xml
			$cam_nome		 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_nome');
			$cam_valorPadrao = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_valorPadrao');
			$cam_tamanho	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_tamanho');
			$setaTamanho	 = $cam_tamanho==0?'':"style='width:".$cam_tamanho."px;'";
			$cam_vlRegistro	 = $this->domXML->getElementsByTagName("campo_".$cam_codigo)->item(0)->getAttribute('cam_vlRegistro');
			if($this->codRegistro!=0){
				$cam_valorPadrao = $cam_vlRegistro;
			}
			if($this->tipoExibicao==1){
				//cria o combo
				echo '<select name="'.$cam_nome.'" id="'.$cam_nome.'" class="'.$this->estilo_campo.'" '.$setaTamanho.' onchange="habNext(this,\''.$cam_valorPadrao.'\');">';
					$selected = $cam_valorPadrao=='NAO'?'selected':'';
					echo '<option title="SIM" value="SIM">SIM</option>';
					echo '<option title="NÃO" value="NAO" $selected>NÃO</option>';
				echo '</select>';
			}else if($this->tipoExibicao==2){
				echo "<div style='display:inline;font-weight:normal'>".$cam_valorPadrao."</div>";
			}
		}
	//
	// FUNÇÃO DO PLUGIN CAMPO AUTOMÁTICO
	//
		function campoAutomatico(){
			if(!empty($this->campo_automatico)){
				//essa firula serve para organizar o array com os códigos do preenchimento automatico da seguinte forma:
				//eu pego os campos que são disparador e armazeno seu código na chave da array 
				//e todos os códigos deste disparador vão para o valor da array
				$osCampos = '';
				$campo = '';
				$array = array();
				$this->campo_automatico;
				foreach($this->campo_automatico as $indice => $valor){
					if($valor!=$campo){
						$array[$valor] = $indice;
					}else{
						$array[$valor] .= '|'.$indice;
					}
					$campo = $valor;
				}
				echo '<script>';
				//pego a array organizada e crio o botão que dispara para uma página php via ajax 
				//a busca pelos campos que devo preencher automaticamente
				//é nesta página que eu vou, via javascript, preencher os campos
				foreach($array as $indice => $valor){
					echo '
					document.getElementById("botaoDinamico_'.$indice.'").innerHTML = "<input name=\'botao_'.$indice.'\' id=\'botao_'.$indice.'\' type=\'button\' onclick=\'val=document.getElementById(\"cam_'.$indice.'\").value;OpenAjaxPostCmd(\"/servicos/ged/includes/campo_backsite/executa.php?\",\"divDinamica_'.$indice.'\",\"campoAutomatico='.$valor.'&result=\"+val,\"aguarde\",\"2\",\"2\");\' value=\'Preencher\' class=\''.$this->estilo_campo.'\' />";
					';
				}
				echo '</script>';
			}
		}
	//
	// BOTÃO EXECUTAR
	//
		function botao($alias,$string_retorno,$url_execucao,$url_retorno){
			//input que vai colocar o local padrão
			echo "<input name='url_localPadrao' id='url_localPadrao' value='".$this->localPadrao."' type='hidden' />";
			//input que vai colocar a url de execução
			echo "<input name='url_execucao' id='url_execucao' value='".$url_execucao."' type='hidden' />";
			//input que vai colocar a url de retorno
			echo "<input name='url_retorno' id='url_retorno' value='".$url_retorno."' type='hidden' />";
			//input que vai colocar o tipo de execução
			echo "<input name='executa' id='executa' value='' type='hidden' />";
			//input que vai colocar os valores do plugin valorUnico
			echo "<input name='valorUnico' id='valorUnico' value='' type='hidden' />";
			//botão
			echo '<input name="botao_executa" type="button" class="button" id="botao_executa" value="'.$alias.'" onClick="executaCampo(\''.$string_retorno.'\',\''.$url_execucao.'\');">';
			echo "<div id='div_executa' style='display:inline'></div>";
		}
	//
	// CONSULTA
	//
		function consulta($queryConsulta){
			mysql_select_db($this->database_sql, $this->sql);
			$this->rsSQL = mysql_query($queryConsulta, $this->sql);
			@$this->row_sql = mysqli_fetch_assoc($this->rsSQL);
			@$this->totalRows_sql = mysql_num_rows($this->rsSQL);
		}
	}
//ESTA FUNÇÃO PEGA O TIPO DA TABELA E EXIBE O INPUT COM A VALIDAÇÃO CORRETA E O TAMANHO CONFIGURADO
function exibeCampo($campo_tipo, $campo_nome, $campo_tamanho, $valor=NULL){
	$tamanho = $campo_tamanho<25?$campo_tamanho:'25';
	switch($campo_tipo){
		//campo busca simples
		case 1:
		case 5:
		case 7:
		case 8:
		case 13:
		case 15:
		case 16:
		case 17:
			echo "<input name='$campo_nome' disabled id='$campo_nome' type='text' value='' class='verdana_11' size='$tamanho' maxlength='$campo_tamanho'>";
			break;
		//campo duplo 'de' 'até'
		case 3:
		case 4:
		case 11:
			echo "De: <input name='$campo_nome' disabled id='$campo_nome' type='text' value='' class='verdana_11' size='$tamanho' maxlength='$campo_tamanho'>";
			echo "&nbsp;até:&nbsp;<input name='{$campo_nome}_fim' disabled id='{$campo_nome}_fim' type='text' value='' class='verdana_11' size='$tamanho' maxlength='$campo_tamanho'>";
			break;
		//campo duplo 'de' 'até' tipo data
		//se eu for data ou data com hora, crio os combos de data
		case 2:
		case 18:
			$cam_valorPadrao = date('Y-m-d H:i:s'); 
			$quebraData = explode('-',$cam_valorPadrao);
			$oDia = explode(' ',$quebraData[2]);
			echo "De: <select disabled name='{$campo_nome}_dia' id='{$campo_nome}_dia' class='verdana_11' onChange='preencheData(\"data\",\"$campo_nome\");'>";
			for($d=1;$d<=31;$d++){
				$dia=$d<10?'0'.$d:$d;
				$selected = $oDia[0]==$dia?'selected':'';
				echo "<option title='$dia' value='$dia' $selected>$dia</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_mes' id='{$campo_nome}_mes' class='verdana_11' onChange='preencheData(\"data\",\"$campo_nome\");'>";
			for($m=1;$m<=12;$m++){
				$mes=$m<10?'0'.$m:$m;
				$selected = $quebraData[1]==$mes?'selected':'';
				echo "<option title='$mes' value='$mes' $selected>$mes</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_ano' id='{$campo_nome}_ano' class='verdana_11' onChange='preencheData(\"data\",\"$campo_nome\");'>";
			for($ano=1910;$ano<=2030;$ano++){
				$selected = $quebraData[0]==$ano?'selected':'';
				echo "<option title='$ano' value='$ano' $selected>$ano</option>";
			}
			echo "</select>";
			echo "<input name='$campo_nome' id='$campo_nome' type='hidden' value='".date('Y-m-d')."' disabled />";

			echo "<br>Até:&nbsp;<select disabled name='{$campo_nome}_dia_fim' id='{$campo_nome}_dia_fim' class='verdana_11' onChange='preencheData(\"data_fim\",\"{$campo_nome}_fim\");'>";
			for($d=1;$d<=31;$d++){
				$dia=$d<10?'0'.$d:$d;
				$selected = $oDia[0]==$dia?'selected':'';
				echo "<option title='$dia' value='$dia' $selected>$dia</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_mes_fim' id='{$campo_nome}_mes_fim' class='verdana_11' onChange='preencheData(\"data_fim\",\"{$campo_nome}_fim\");'>";
			for($m=1;$m<=12;$m++){
				$mes=$m<10?'0'.$m:$m;
				$selected = $quebraData[1]==$mes?'selected':'';
				echo "<option title='$mes' value='$mes' $selected>$mes</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_ano_fim' id='{$campo_nome}_ano_fim' class='verdana_11' onChange='preencheData(\"data_fim\",\"{$campo_nome}_fim\");'>";
			for($ano=1910;$ano<=2030;$ano++){
				$selected = $quebraData[0]==$ano?'selected':'';
				echo "<option title='$ano' value='$ano' $selected>$ano</option>";
			}
			echo "</select>";
			echo "<input name='{$campo_nome}' id='{$campo_nome}_fim' type='hidden' value='".date('Y-m-d')."' disabled />";
			break;
		case 9:
		case 10:
			$cam_valorPadrao = date('Y-m-d H:i:s'); 
			$quebraData = explode('-',$cam_valorPadrao);
			$oDia = explode(' ',$quebraData[2]);
			echo "De: <select disabled name='{$campo_nome}_dia' id='{$campo_nome}_dia' class='verdana_11' onChange='preencheData(\"data_hora\",\"$campo_nome\");'>";
			for($d=1;$d<=31;$d++){
				$dia=$d<10?'0'.$d:$d;
				$selected = $oDia[0]==$dia?'selected':'';
				echo "<option title='$dia' value='$dia' $selected>$dia</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_mes' id='{$campo_nome}_mes' class='verdana_11' onChange='preencheData(\"data_hora\",\"$campo_nome\");'>";
			for($m=1;$m<=12;$m++){
				$mes=$m<10?'0'.$m:$m;
				$selected = $quebraData[1]==$mes?'selected':'';
				echo "<option title='$mes' value='$mes' $selected>$mes</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_ano' id='{$campo_nome}_ano' class='verdana_11' onChange='preencheData(\"data_hora\",\"$campo_nome\");'>";
			for($ano=1910;$ano<=2030;$ano++){
				$selected = $quebraData[0]==$ano?'selected':'';
				echo "<option title='$ano' value='$ano' $selected>$ano</option>";
			}
			echo "</select>";
			echo '&nbsp;&nbsp;'; $quebraHora = explode(':',$oDia[1]);
			echo "<select disabled name='{$campo_nome}_hora' id='{$campo_nome}_hora' class='verdana_11' onChange='preencheData(\"data_hora\",\"$campo_nome\");'>";
			for($h=0;$h<=23;$h++){
				$hora=$h<10?'0'.$h:$h;
				$selected = $quebraHora[0]==$hora?'selected':'';
				echo "<option title='$hora' value='$hora' $selected>$hora</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_min' id='{$campo_nome}_min' class='verdana_11' onChange='preencheData(\"data_hora\",\"$campo_nome\");'>";
			for($m=0;$m<=59;$m++){
				$min=$m<10?'0'.$m:$m;
				$selected = $quebraHora[1]==$min?'selected':'';
				echo "<option title='$min' value='$min' $selected>$min</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_seg' id='{$campo_nome}_seg' class='verdana_11' onChange='preencheData(\"data_hora\",\"$campo_nome\");'>";
			for($s=0;$s<=59;$s++){
				$seg=$s<10?'0'.$s:$s;
				$selected = $quebraHora[2]==$seg?'selected':'';
				echo "<option title='$seg' value='$seg' $selected>$seg</option>";
			}
			echo "</select>";	
			echo "<input name='$campo_nome' id='$campo_nome' type='hidden' value='".date('Y-m-d H:i:s')."' disabled />";

			echo "<br>Até:&nbsp;<select disabled name='{$campo_nome}_dia_fim' id='{$campo_nome}_dia_fim' class='verdana_11' onChange='preencheData(\"data_hora_fim\",\"{$campo_nome}_fim\");'>";
			for($d=1;$d<=31;$d++){
				$dia=$d<10?'0'.$d:$d;
				$selected = $oDia[0]==$dia?'selected':'';
				echo "<option title='$dia' value='$dia' $selected>$dia</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_mes_fim' id='{$campo_nome}_mes_fim' class='verdana_11' onChange='preencheData(\"data_hora_fim\",\"{$campo_nome}_fim\");'>";
			for($m=1;$m<=12;$m++){
				$mes=$m<10?'0'.$m:$m;
				$selected = $quebraData[1]==$mes?'selected':'';
				echo "<option title='$mes' value='$mes' $selected>$mes</option>";
			}
			echo "</select>/";	
			echo "<select disabled name='{$campo_nome}_ano_fim' id='{$campo_nome}_ano_fim' class='verdana_11' onChange='preencheData(\"data_hora_fim\",\"{$campo_nome}_fim\");'>";
			for($ano=1910;$ano<=2030;$ano++){
				$selected = $quebraData[0]==$ano?'selected':'';
				echo "<option title='$ano' value='$ano' $selected>$ano</option>";
			}
			echo "</select>";
			echo '&nbsp;&nbsp;'; $quebraHora = explode(':',$oDia[1]);
			echo "<select disabled name='{$campo_nome}_hora_fim' id='{$campo_nome}_hora_fim' class='verdana_11' onChange='preencheData(\"data_hora_fim\",\"{$campo_nome}_fim\");'>";
			for($h=0;$h<=23;$h++){
				$hora=$h<10?'0'.$h:$h;
				$selected = $quebraHora[0]==$hora?'selected':'';
				echo "<option title='$hora' value='$hora' $selected>$hora</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_min_fim' id='{$campo_nome}_min_fim' class='verdana_11' onChange='preencheData(\"data_hora_fim\",\"{$campo_nome}_fim\");'>";
			
			for($m=0;$m<=59;$m++){
				$min=$m<10?'0'.$m:$m;
				$selected = $quebraHora[1]==$min?'selected':'';
				echo "<option title='$min' value='$min' $selected>$min</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_seg_fim' id='{$campo_nome}_seg_fim' class='verdana_11' onChange='preencheData(\"data_hora_fim\",\"{$campo_nome}_fim\");'>";
			for($s=0;$s<=59;$s++){
				$seg=$s<10?'0'.$s:$s;
				$selected = $quebraHora[2]==$seg?'selected':'';
				echo "<option title='$seg' value='$seg' $selected>$seg</option>";
			}
			echo "</select>";	
			echo "<input name='{$campo_nome}_fim' id='{$campo_nome}_fim' type='hidden' value='".date('Y-m-d H:i:s')."' disabled />";
			break;
			//se eu for data com hora ou hora, crio os combos de hora
		case 12:
			$cam_valorPadrao = date('H:i:s'); 
			$quebraHora = explode(':',$cam_valorPadrao);
			echo "De: <select disabled name='{$campo_nome}_hora' id='{$campo_nome}_hora' class='verdana_11' onChange='preencheData(\"hora\",\"$campo_nome\");'>";
			for($h=0;$h<=23;$h++){
				$hora=$h<10?'0'.$h:$h;
				$selected = $quebraHora[0]==$hora?'selected':'';
				echo "<option title='$hora' value='$hora' $selected>$hora</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_min' id='{$campo_nome}_min' class='verdana_11' onChange='preencheData(\"hora\",\"$campo_nome\");'>";
			for($m=0;$m<=59;$m++){
				$min=$m<10?'0'.$m:$m;
				$selected = $quebraHora[1]==$min?'selected':'';
				echo "<option title='$min' value='$min' $selected>$min</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_seg' id='{$campo_nome}_seg' class='verdana_11' onChange='preencheData(\"hora\",\"$campo_nome\");'>";
			for($s=0;$s<=59;$s++){
				$seg=$s<10?'0'.$s:$s;
				$selected = $quebraHora[2]==$seg?'selected':'';
				echo "<option title='$seg' value='$seg' $selected>$seg</option>";
			}
			echo "</select>";	
			echo "<input name='$campo_nome' id='$campo_nome' type='hidden' value='".date('H:i:s')."' disabled />";

			echo "<br>Até:&nbsp;<select disabled name='{$campo_nome}_hora_fim' id='{$campo_nome}_hora_fim' class='verdana_11' onChange='preencheData(\"hora_fim\",\"{$campo_nome}_fim\");'>";
			for($h=0;$h<=23;$h++){
				$hora=$h<10?'0'.$h:$h;
				$selected = $quebraHora[0]==$hora?'selected':'';
				echo "<option title='$hora' value='$hora' $selected>$hora</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_min_fim' id='{$campo_nome}_min_fim' class='verdana_11' onChange='preencheData(\"hora_fim\",\"{$campo_nome}_fim\");'>";
			for($m=0;$m<=59;$m++){
				$min=$m<10?'0'.$m:$m;
				$selected = $quebraHora[1]==$min?'selected':'';
				echo "<option title='$min' value='$min' $selected>$min</option>";
			}
			echo "</select>:";	
			echo "<select disabled name='{$campo_nome}_seg_fim' id='{$campo_nome}_seg_fim' class='verdana_11' onChange='preencheData(\"hora_fim\",\"{$campo_nome}_fim\");'>";
			for($s=0;$s<=59;$s++){
				$seg=$s<10?'0'.$s:$s;
				$selected = $quebraHora[2]==$seg?'selected':'';
				echo "<option title='$seg' value='$seg' $selected>$seg</option>";
			}
			echo "</select>";	
			echo "<input name='{$campo_nome}_fim' id='{$campo_nome}_fim' type='hidden' value='".date('H:i:s')."' disabled />";
			break;
		//campo combo
		case 6:
			//cria o combo
			$osValores		= explode("<%SEPARA_VALOR%>",$valor);	
			$setaTamanho	= $campo_tamanho==0?'':"style='width:".$campo_tamanho."px;'";
			echo "<select disabled name='$campo_nome' id='$campo_nome' class='verdana_11' $setaTamanho>";
			foreach($osValores as $valores){
				$selected = $valor==$valores?'selected':'';
				echo "<option title='$valores' $selected value='$valores'>$valores</option>";
			}
			echo "</select>";
			break;
		case 14:
		case 19:
			$setaTamanho	= $campo_tamanho==0?'':"style='width:".$campo_tamanho."px;'";
			echo "<select disabled name='$campo_nome' id='$campo_nome' class='verdana_11' $setaTamanho>";
			$selected = $valor=='SIM'?'':'selected';
			echo "<option title='SIM' value='SIM'>SIM</option>";
			echo "<option title='NÃO' $selected value='NAO'>NÃO</option>";
			echo "</select>";
			break;
	}
}	

function trocaCodigoTabDin($valor, $database_ged, $ged){
	$quebraValor = explode(':',$valor);
	$tabela		 = $quebraValor[1];
	if(isset($quebraValor[3])){
		$campo		 = $quebraValor[2];
		$oValor		 = substr($quebraValor[3],0,-1);
	}else{
		$campo		 = substr($quebraValor[2],0,-1);
		$oValor		 = substr($quebraValor[2],0,-1);
	}
	//Pega o nome da tabela	
	mysql_select_db($database_ged, $ged);
	$query_tabelaTabDin = "SELECT doc_tabela FROM ged_documento WHERE doc_codigo = $tabela";
	$tabelaTabDin = mysql_query($query_tabelaTabDin, $ged) or die(mysql_error());
	$row_tabelaTabDin = mysqli_fetch_assoc($tabelaTabDin);
	$totalRows_tabelaTabDin = mysql_num_rows($tabelaTabDin);
	
	//Pega o nome do campo do busca	
	mysql_select_db($database_ged, $ged);
	$query_campoTabDin = "SELECT cam_nome FROM ged_campo WHERE cam_codigo = $campo";
	$campoTabDin = mysql_query($query_campoTabDin, $ged) or die(mysql_error());
	$row_campoTabDin = mysqli_fetch_assoc($campoTabDin);
	$totalRows_campoTabDin = mysql_num_rows($campoTabDin);

	//Pega o nome do valor do busca	
	mysql_select_db($database_ged, $ged);
	$query_valorTabDin = "SELECT cam_nome FROM ged_campo WHERE cam_codigo = $oValor";
	$valorTabDin = mysql_query($query_valorTabDin, $ged) or die(mysql_error());
	$row_valorTabDin = mysqli_fetch_assoc($valorTabDin);
	$totalRows_valorTabDin = mysql_num_rows($valorTabDin);
	
	$tabela		= $row_tabelaTabDin['doc_tabela'];
	$campo		= $row_campoTabDin['cam_nome'];
	$oValor		= $row_valorTabDin['cam_nome'];

	mysql_select_db($database_ged, $ged);
	$query_busca = "SELECT $campo, $oValor FROM $tabela ORDER BY $campo ASC";
	$busca = mysql_query($query_busca, $ged) or die(mysql_error());
	$row_busca = mysqli_fetch_assoc($busca);
	$totalRows_busca = mysql_num_rows($busca);
	
	$string = "";
	do{
		$string .= str_replace('|','',str_replace(',','',$row_busca[$campo])).'|'.str_replace('|','',str_replace(',','',$row_busca[$oValor])).',';
	}while($row_busca = mysqli_fetch_assoc($busca));
	$string = substr($string,0,-1);

	return  $string;
}

//
//=========================================//
?>