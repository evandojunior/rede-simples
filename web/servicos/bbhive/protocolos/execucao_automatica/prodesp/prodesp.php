<?php
ini_set('display_errors',true);
//---
function arrumadataProdesp($data_errada)
 {return implode(preg_match("~\/~", $data_errada) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data_errada) == 0 ? "-" : "/", $data_errada)));
}

function RealProdesp($valor){  
	$valorretorno=number_format($valor, 2, ',', '.');  
	return $valorretorno;  
}

//---
if(!isset($_SESSION)){session_start();}

//--
$u = "http://10.138.11.138/blackbee/Lacracao.asmx/ConsultarPorRenavam";
$u = "http://projeto30.backsite.com.br/prodesp.xml";
//------------------------------------------------------------------------------------------------

//RECUPERO DADOS DA SESSÃO E ENVIO PARA O BANCO DE DADOS====================================================================
if(isset($_POST['gravaDadosProdesp'])){
		//--
		require_once("../../../../../Connections/bbhive.php");
		//--
		//--RECUPERA TODOS OS CAMPOS DA SESSÃO E ARMAZENA NAS VARIÃVEIS
		$bbh_pro_titulo 	= $_SESSION['prodesp']['bbh_pro_titulo'];
		$bbh_dep_codigo 	= $_SESSION['prodesp']['bbh_dep_codigo'];
		$bbh_pro_momento 	= $_SESSION['prodesp']['bbh_pro_momento'];
		$bbh_pro_email		= $_SESSION['prodesp']['bbh_pro_email'];
		$bbh_pro_flagrante	= $_SESSION['prodesp']['bbh_pro_flagrante'];
		
		$bbh_cam_det_pro_16	= $_SESSION['prodesp']['bbh_cam_det_pro_16'];
		$bbh_cam_det_pro_17 = $_SESSION['prodesp']['bbh_cam_det_pro_17'];
		$bbh_cam_det_pro_18 = $_SESSION['prodesp']['bbh_cam_det_pro_18'];
		$bbh_cam_det_pro_19 = $_SESSION['prodesp']['bbh_cam_det_pro_19'];
		$bbh_cam_det_pro_20 = $_SESSION['prodesp']['bbh_cam_det_pro_20'];
		$bbh_cam_det_pro_21 = $_SESSION['prodesp']['bbh_cam_det_pro_21'];
		$bbh_cam_det_pro_22 = $_SESSION['prodesp']['bbh_cam_det_pro_22'];
		$bbh_cam_det_pro_23 = $_SESSION['prodesp']['bbh_cam_det_pro_23'];
		$bbh_cam_det_pro_24 = $_SESSION['prodesp']['bbh_cam_det_pro_24'];
		$bbh_cam_det_pro_26 = $_SESSION['prodesp']['bbh_cam_det_pro_26'];
		$bbh_cam_det_pro_27 = $_SESSION['prodesp']['bbh_cam_det_pro_27'];
		$bbh_cam_det_pro_28	= $_SESSION['prodesp']['bbh_cam_det_pro_28'];
		$bbh_dep_nome		= $_SESSION['prodesp']['bbh_dep_nome'];
		//--
		//-----INSERT
		$insertSQL = "INSERT INTO bbh_protocolos 
						(bbh_pro_status, bbh_pro_titulo, bbh_pro_momento, bbh_pro_email, bbh_dep_codigo, bbh_pro_flagrante) 
							VALUES ('5', '$bbh_pro_titulo', '$bbh_pro_momento', '$bbh_pro_email', $bbh_dep_codigo, '$bbh_pro_flagrante')";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL, $initResult = false);
		$ultimoId = mysqli_insert_id($bbhive);

		//--Tabela de detalhamento
		$insertSQL = "INSERT INTO bbh_detalhamento_protocolo 
						(bbh_pro_codigo, bbh_cam_det_pro_16, bbh_cam_det_pro_17, bbh_cam_det_pro_18, bbh_cam_det_pro_19, bbh_cam_det_pro_20, bbh_cam_det_pro_21, bbh_cam_det_pro_22, bbh_cam_det_pro_23, bbh_cam_det_pro_24, bbh_cam_det_pro_26, bbh_cam_det_pro_27, bbh_cam_det_pro_28) 
							VALUES ($ultimoId, '$bbh_cam_det_pro_16', '$bbh_cam_det_pro_17', '$bbh_cam_det_pro_18', '$bbh_cam_det_pro_19', '$bbh_cam_det_pro_20', '$bbh_cam_det_pro_21', '$bbh_cam_det_pro_22', '$bbh_cam_det_pro_23', '$bbh_cam_det_pro_24', '$bbh_cam_det_pro_26', '$bbh_cam_det_pro_27', '$bbh_cam_det_pro_28')";
		mysqli_select_db($bbhive, $database_bbhive);
        //list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL, $initResult = false);
		//--
		
		//REMOVE SESSÃO POR SEGURANÃA
		unset($_SESSION['prodesp']);
		//==

		//--Alimenta dados do protocolo
		echo '<var style="display:none">
				document.getElementById("bbh_pro_cod").value = "'.$ultimoId .'";
			  </var>';	
		
		//--Redireciona
		echo '<var style="display:none">
				OpenAjaxPostCmd("/servicos/bbhive/protocolos/cadastro/executa.php?TS='.time().'","carregaDuplicadoProdesp","gerenciaProdesp","Carregando...","carregaDuplicadoProdesp","1","2");
			  </var>';
		exit;
}
//=============================================================================================================================

//REMOVE SESSÃO POR SEGURANÃA
unset($_SESSION['prodesp']);
//==

//CONSULTA RENAVAM NO WEBSERVICE DA PRODESP====================================================================================
if(((isset($_GET['renavam']) || isset($_POST['renavam'])) && (strlen($_POST['renavam'])>0 || strlen($_GET['renavam'])>0))){
	//--
	require_once("../../../../../Connections/bbhive.php");
	//--
	$r = isset($_POST['renavam']) ? $_POST['renavam'] : $_GET['renavam'];
	//--
	function consultaWebService($renavam, $u){
		require_once("../../../../../Connections/policy/http.php");

		set_time_limit(0);
		$http=new http_class;
		$http->timeout=0;
		$http->data_timeout=0;
		$http->debug=0;
		$http->html_debug=1;
	
		$url= $u;
		
		$error=$http->GetRequestArguments($url,$arguments);
		$arguments["RequestMethod"]="POST";
		$arguments["PostValues"]=array(
			"renavam"=>($renavam));
		
		
		$arguments["Referer"]="";
		flush();
		$error=$http->Open($arguments);
	
		if($error=="")
		{
			$error=$http->SendRequest($arguments);
			
		}
				for(;;)
				{
						$error=$http->ReadReplyBody($body,30000);
						if($error!=""|| strlen($body)==0)
							break;
						return $body;
				}
					flush();
		if(strlen($error))
			echo "<span class='verdana_11 color'>Erro ao consultar sistema da Prodesp!</span>";

		return $body;
	}
	//--
	$dados = consultaWebService($r, $u);

	//--
	$prodesp = new DOMDocument("1.0", "iso-8859-1"); 
	$prodesp->preserveWhiteSpace = false; //descartar espacos em branco    
	$prodesp->formatOutput = false; //gerar um codigo bem legivel   
	//$prodesp->load($url);
	$prodesp->loadXML($dados);

	//--
	function consultaDados($tipo, $valor){
		if($tipo == 1){
			$array = array(
			"1"=>"PRIMEIRO EMPLACAMENTO",
			"2"=>"AQUISICAO DE VEICULO NO PROPRIO MUNICIPIO",
			"3"=>"AQUISICAO DE VEICULO COM TROCA DE MUNICIPIO E/OU TROCA DE PLACA",
			"4"=>"EMISSAO DE 2VIA",
			"5"=>"ALTERACAO DE CARACTERISTICAS",
			"6"=>"TROCA DE MUNICIPIO E/OU TROCA DE PLACA",
			"7"=>"BAIXA DE VEICULO"
			);
			//--
			foreach($array as $i=>$v){
				if($i==$valor){
					return $v;
				}
			}
			//--
		}elseif($tipo == 2){
			$array = array(
			"031"=>"Taxa de LacraÃ§Ã£o e RelacraÃ§Ã£o - DETRAN. (Zero Km ou Transferido de outro estado - 1Âº emplacamento)",
			"032"=>"Taxa de LacraÃ§Ã£o e RelacraÃ§Ã£o - RESIDÃNCIA. (Zero Km ou Transferido de outro estado - 1Âº emplacamento)",
			"033"=>"Taxa de LacraÃ§Ã£o e RelacraÃ§Ã£o - DETRAN. (Veiculos Usados)",
			"034"=>"Taxa de LacraÃ§Ã£o e RelacraÃ§Ã£o - RESIDÃNCIA. (Veiculos Usados)"
				);
				//--
			foreach($array as $i=>$v){
				if($i==$valor){
					return $v;
				}
			}
			//--
		}else{
			$array = array(
			"01"=>"BICICLETA",
			"02"=>"CICLOMOTOR",
			"03"=>"MOTONETA",
			"04"=>"MOTOCICLETA",
			"05"=>"TRICICLO",
			"06"=>"AUTOMOVEL",
			"07"=>"MICROONIBUS",
			"08"=>"ONIBUS",
			"09"=>"BONDE",
			"10"=>"REBOQUE",
			"11"=>"SEMI-REBOQUE",
			"12"=>"CHARRETE",
			"13"=>"CAMIONETA",
			"14"=>"CAMINHAO",
			"15"=>"CARROCA",
			"16"=>"CARRO DE MAO",
			"17"=>"CAMINHAO TRATOR",
			"18"=>"TRATOR DE RODAS",
			"19"=>"TRATOR DE ESTEIRAS",
			"20"=>"TRATOR MISTO",
			"21"=>"QUADRICICLO",
			"22"=>"CHASSI PLATAFORMA",
			"23"=>"CAMINHONETE",
			"24"=>"SIDE-CAR",
			"25"=>"UTILITARIO",
			"26"=>"MOTOR-CASA"
			);
			//--
			foreach($array as $i=>$v){
				if($i==$valor){
					return $v;
				}
			}
			//--				
		}
	}
	//--
	$root = $prodesp->getElementsByTagName("Lacracao")->item(0);
	
	$CodigoErro 		= $root->getElementsByTagName("CodigoErro")->item(0)->nodeValue;
	$MensagemErro 		= $root->getElementsByTagName("MensagemErro")->item(0)->nodeValue;
	$Renavam 			= $root->getElementsByTagName("Renavam")->item(0)->nodeValue;
	$CodigoMunicipio 	= $root->getElementsByTagName("CodigoMunicipio")->item(0)->nodeValue;
	$DescricaoMunicipio = $root->getElementsByTagName("DescricaoMunicipio")->item(0)->nodeValue;
	$Placa 				= $root->getElementsByTagName("Placa")->item(0)->nodeValue;
	$CpfCnpj			= $root->getElementsByTagName("CpfCnpj")->item(0)->nodeValue;
	$TipoDocumentoPago 	= $root->getElementsByTagName("TipoDocumentoPago")->item(0)->nodeValue;
	$ValorPago 			= $root->getElementsByTagName("ValorPago")->item(0)->nodeValue;
	$Opcao 				= $root->getElementsByTagName("Opcao")->item(0)->nodeValue;
	$DataEmissao 		= $root->getElementsByTagName("DataEmissao")->item(0)->nodeValue;
	$TipoVeiculo		= $root->getElementsByTagName("TipoVeiculo")->item(0)->nodeValue;
	//--

	if($CodigoErro == 0 && ($Renavam == $r)){
		//--Departamento do usuÃ¡rio
		$query_dpto = "
		select usu.bbh_dep_codigo, dep.bbh_dep_nome
		 from bbh_usuario usu
		 INNER JOIN bbh_departamento dep ON dep.bbh_dep_codigo = usu.bbh_dep_codigo
		 where bbh_usu_codigo = ".$_SESSION['MM_BBhive_Codigo'];
        list($dpto, $row_dpto, $totalRows_dpto) = executeQuery($bbhive, $database_bbhive, $query_dpto);
	
		
		$bbh_pro_titulo     = $Placa;
		$bbh_dep_codigo 	= $row_dpto['bbh_dep_codigo'];
		$bbh_dep_nome		= $row_dpto['bbh_dep_nome'];
		$bbh_pro_momento	= date("Y-m-d H:i:s");
		$bbh_pro_email		= $_SESSION['MM_User_email'];
		$bbh_pro_flagrante	= 0;
		
		$bbh_cam_det_pro_16 = ($DescricaoMunicipio);
		$bbh_cam_det_pro_17 = $CodigoMunicipio;
		$bbh_cam_det_pro_18 = $CpfCnpj;
		$bbh_cam_det_pro_19 = (consultaDados(2, $TipoDocumentoPago));
		$bbh_cam_det_pro_20 = $Renavam;	
		$bbh_cam_det_pro_21 = $ValorPago;
		$bbh_cam_det_pro_22 = (consultaDados(1, $Opcao));
		$bbh_cam_det_pro_23 = str_replace('T',' ',$DataEmissao);
		$bbh_cam_det_pro_24 = (consultaDados(3, $TipoVeiculo));
		$bbh_cam_det_pro_26 = ($_POST['lacre']);
		$bbh_cam_det_pro_27 = ($_POST['tipoEmplacamento']);
		$bbh_cam_det_pro_28 = ($_POST['bbh_cam_det_pro_28']);
		
		
	$_SESSION['prodesp'] = array();
	$_SESSION['prodesp']['bbh_pro_titulo'] 		= $bbh_pro_titulo;
	$_SESSION['prodesp']['bbh_dep_codigo'] 		= $bbh_dep_codigo;
	$_SESSION['prodesp']['bbh_pro_momento']		= $bbh_pro_momento;
	$_SESSION['prodesp']['bbh_pro_email'] 		= $bbh_pro_email;
	$_SESSION['prodesp']['bbh_pro_flagrante'] 	= $bbh_pro_flagrante;
	
	$_SESSION['prodesp']['bbh_cam_det_pro_16'] 	= $bbh_cam_det_pro_16;
	$_SESSION['prodesp']['bbh_cam_det_pro_17'] 	= $bbh_cam_det_pro_17;
	$_SESSION['prodesp']['bbh_cam_det_pro_18']	= $bbh_cam_det_pro_18;
	$_SESSION['prodesp']['bbh_cam_det_pro_19']  = $bbh_cam_det_pro_19;
	$_SESSION['prodesp']['bbh_cam_det_pro_20']  = $bbh_cam_det_pro_20;
	$_SESSION['prodesp']['bbh_cam_det_pro_21']  = $bbh_cam_det_pro_21;
	$_SESSION['prodesp']['bbh_cam_det_pro_22']  = $bbh_cam_det_pro_22;
	$_SESSION['prodesp']['bbh_cam_det_pro_23']  = $bbh_cam_det_pro_23;
	$_SESSION['prodesp']['bbh_cam_det_pro_24']  = $bbh_cam_det_pro_24;
	$_SESSION['prodesp']['bbh_cam_det_pro_26']  = $bbh_cam_det_pro_26;
	$_SESSION['prodesp']['bbh_cam_det_pro_27']  = $bbh_cam_det_pro_27;
	$_SESSION['prodesp']['bbh_cam_det_pro_28']  = $bbh_cam_det_pro_28;
	$_SESSION['prodesp']['bbh_dep_nome']		= $bbh_dep_nome;	
	?>
    <br />
		<table width="930" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:1px #999 solid">
			<tr>
				<td height="25" style="border-bottom:1px dotted #000;font-size:13px;" colspan="2" align="left" class="legandaLabel11">&nbsp;<strong> Confirme os dados abaixo</strong></td>
			</tr>
            <tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Data de cadastro :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo arrumadataProdesp(substr($_SESSION['prodesp']['bbh_pro_momento'],0,10)).substr($_SESSION['prodesp']['bbh_pro_momento'],10,19);?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Renavam :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <strong><?php echo $_SESSION['prodesp']['bbh_cam_det_pro_20']; ?></strong></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> C&oacute;digo da Cidade :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo $_SESSION['prodesp']['bbh_cam_det_pro_17']; ?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Cidade :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo $_SESSION['prodesp']['bbh_cam_det_pro_16']; ?> &nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Placa :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo $_SESSION['prodesp']['bbh_pro_titulo']; ?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> CPF/CNPJ :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo $_SESSION['prodesp']['bbh_cam_det_pro_18'];?> </td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Tipo de Documento :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo $_SESSION['prodesp']['bbh_cam_det_pro_19']; ?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Valor :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo RealProdesp($_SESSION['prodesp']['bbh_cam_det_pro_21']); ?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Op&ccedil;&atilde;o :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo $_SESSION['prodesp']['bbh_cam_det_pro_22']; ?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Data de Emiss&atilde;o :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo arrumadataProdesp(substr($_SESSION['prodesp']['bbh_cam_det_pro_23'],0,10)); ?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Tipo de Ve&iacute;culo :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <?php echo $_SESSION['prodesp']['bbh_cam_det_pro_24']; ?></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Lacre :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <strong><?php echo $_SESSION['prodesp']['bbh_cam_det_pro_26']; ?></strong></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Tipo de emplacamento :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <strong><?php echo $_SESSION['prodesp']['bbh_cam_det_pro_27']; ?></strong></td>
			</tr>
			<tr>
				<td width="209" height="25" align="left" class="verdana_11">&nbsp;<strong> Nome da empresa :</strong></td>
				<td width="721" height="25" align="left" class="verdana_11"> <strong><?php echo $_SESSION['prodesp']['bbh_cam_det_pro_28']; ?></strong></td>
			</tr>
		</table>
        <?php 
		if($bbh_cam_det_pro_16 != $bbh_dep_nome)
		{
			echo "<div style='color:#F00;font-weight:bold;padding-bottom:5px;padding-top:5px' class='verdana_13'> As permiss&otilde;es de acesso deste CIRETRAN s&atilde;o incompat&iacute;veis para o munic&iacute;pio deste RENAVAM.</div>";
			unset($_SESSION['prodesp']);
			exit;
		}
		?>
        <p>&nbsp;</p>
        <input name="gravaDadosProdesp" id="gravaDadosProdesp" type="hidden" value="1" />
		<var style="display:none">
			document.formProdesp.cadastrar.value = "  Confirmar dados";
		</var>	
		<?php 
		exit;
	}else{
		echo "<span style='color:#F00;font-weight:bold' class='verdana_12'>Erro na consulta dos dados, poss&iacute;veis causas:<br><li>".($MensagemErro)."</li><li>N&uacute;mero do renavam incorreto</li><li><a href='#@' onClick=\"return showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/passo1.php?cadastroManual=true','colPrincipal');\"><span style='color:#F00'>Sistema da Prodesp inacess&iacute;vel, </span><span style='color:#00C'>neste caso clique aqui para preencher os dados manualmente.</span></a></li></span><br>";
		//echo "";
	}
	//$prodesp->saveXML();
 exit;
//=============================================================================================================================	
}
?>
<form id="formProdesp" name="formProdesp">
<table width="970" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" align="absmiddle" />&nbsp;<strong>Cadastro - <?php echo ($_SESSION['protNome']); ?></strong></td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="300" valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="">
  <tr>
    <td width="150%" height="25" colspan="4" align="left">&nbsp;<img src="/servicos/bbhive/images/messagebox_warning.gif" align="absmiddle" />&nbsp;Por favor preencha os dados abaixo para gerar um(a) <?php echo $_SESSION['protNome'];?>.</td>
    </tr>
  <tr>
    <td height="5" colspan="4" align="right"></td>
    </tr>
  <tr>
    <td height="5" colspan="4" align="left">
    <br />

        <table width="930" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr style="display:block">
            <td width="169" height="25" align="left" class="verdana_11"><strong>C&oacute;digo do&nbsp;Renavam :</strong></td>
            <td width="761" height="25" align="left" class="verdana_11">
              <label for="renavam"></label>
              <input name="renavam" type="text" class="verdana_12" id="renavam" onkeypress="SomenteNumerico(this)" maxlength="9" /></td>
          </tr>
          <tr style="display:block">
            <td width="169" height="25" align="left" class="verdana_11"><strong>Lacre :</strong></td>
            <td width="761" height="25" align="left" class="verdana_11">
              <label for="lacre"></label>
              <input name="lacre" type="text" class="verdana_12" id="lacre" size="25" maxlength="255" /></td>
          </tr>
          <tr style="display:block">
            <td width="169" height="25" align="left" class="verdana_11"><strong>Tipo de emplacamento :</strong></td>
            <td width="761" height="25" align="left" class="verdana_11">
              <label for="tipoEmplacamento"></label>
              <select name="tipoEmplacamento" id="tipoEmplacamento" class="verdana_12" onchange="if(this.value=='CREDENCIADA'){ document.getElementById('escolheEmpresa').style.display='block'; } else { document.getElementById('escolheEmpresa').style.display='none';}">
              	<option value="COMPLETO">COMPLETO</option>
              	<option value="PARCIAL">PARCIAL</option>
                <option value="CREDENCIADA">CREDENCIADA</option>
              </select>
              </td>
          </tr>
          <?php
		  //Aqui Ã© seu SELECT
		  //--
			$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
						WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
            list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
			//--
			$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
			//--
		  //RecordSet dos campos
			$query_combo_dinamico = "SELECT * FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_codigo ='28'";
            list($combo_dinamico, $rows, $totalRows_combo_dinamico) = executeQuery($bbhive, $database_bbhive, $query_combo_dinamico, $initResult = false);
			
			// -----------------------------------------------------------------------
if($tabelaCriada==1){
				
			 while($row_combo_dinamico = mysqli_fetch_assoc($combo_dinamico)){
			//Atributos de uma tabela dinÃ¢mica
			$tipoDeCampo 	= $row_combo_dinamico['bbh_cam_det_pro_tipo']; 
			$nomeFisico 	= $row_combo_dinamico['bbh_cam_det_pro_nome'];
			$titulo 		= $row_combo_dinamico['bbh_cam_det_pro_titulo'];
		
				//Dados que veio do ambiente corporativo
				//Ã© inicio e nÃ£o ediÃ§Ã£o entÃ£o deve pegar dos campos
				$valorPadrao 	= $row_combo_dinamico['bbh_cam_det_pro_default']; 
			
			$editListagem 	= $row_combo_dinamico['bbh_cam_det_pro_default']; 
			$tamanho 		= $row_combo_dinamico['bbh_cam_det_pro_tamanho']; 

			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}

			//--
	  ?>
          <tr style="display:none" id="escolheEmpresa">
            <td width="169" height="25" align="left" class="verdana_11"><strong>Nome da empresa credenciada :</strong></td>
            <td width="761" height="25" align="left" class="verdana_11">
            <?php
				//FuncionarÃ¡ somente se tiver departamentos, ou seja, este Ã© do protocolo
				if(isset($todosDepto) && $nomeFisico=="bbh_dep_codigo"){
					echo '<select name="'.$nomeFisico.'" id="'.$nomeFisico.'" class="back_input">';
						foreach($todosDepto as $i=>$v){
							//--
							$s = $editListagem == $i ? "selected" : "";
							//--
							echo '<option value="'.$i.'" '.$s.'>'.$v.'</option>';
						}
					echo '</select>';
				} else {
					//InclusÃ£o que isola o algoritmo que exibe cada tipo de campo
					include('../cadastro/detalhamento/includes/formDinamico.php');   
				}
			?>
            </td>
          </tr>
          <?php } ?>
       <?php } ?>
          <tr style="display:block">
            <td height="25" colspan="2"><div align="left" style="margin-right:5px" id="carregaDuplicadoProdesp" class="legandaLabel11 color">&nbsp;</div></td>
          </tr>
        </table>
        
    </td>
  </tr>
  <tr>
    <td height="5" colspan="4" align="right"><input name="cancelar" style="background:url(/servicos/bbhive/images/erro.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cancelar" value="&nbsp;Cancelar" onClick="LoadSimultaneo('protocolos/regra.php','conteudoGeral');"/>
            &nbsp;
			<input name="cadastrar" id="cadastrar" style="background:url(/servicos/bbhive/images/disk.gif);background-repeat:no-repeat;background-position:left;height:23px;width:180px;margin-right:1px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" value="&nbsp;Consultar" onClick="validaForm('formProdesp','renavam|Preencha o campo renavam,lacre|Informe o Lacre',document.getElementById('acaoFormProdesp').value);"/></td>
  </tr>

  </table>
</td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<input type="hidden" name="acaoFormProdesp" id="acaoFormProdesp" value="OpenAjaxPostCmd('/servicos/bbhive/protocolos/execucao_automatica/prodesp/prodesp.php','carregaDuplicadoProdesp','formProdesp','Aguarde cadastrando dados...','carregaDuplicadoProdesp','1','2');" />
</form>
<form name="gerenciaProdesp" id="gerenciaProdesp">
  <input type="hidden" name="gerProt" value="1" />
  <input type="hidden" name="bbh_pro_cod" id="bbh_pro_cod" value="" />
</form>