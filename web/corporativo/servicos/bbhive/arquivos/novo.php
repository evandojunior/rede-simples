<?php
 if(!isset($_SESSION)){ session_start(); }
 //Arquivo de conexão GERAL
 require_once("../includes/autentica.php");
 $bbh_flu_codigo=0;
  	foreach($_GET as $indice => $valor){
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
		if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){ $bbh_ati_codigo=$valor; }
	}

	$query_fluxos = "SELECT bbh_tipo_fluxo.bbh_tip_flu_codigo,
			bbh_atividade.bbh_flu_codigo, 
			 bbh_tip_flu_nome,
			  bbh_mod_flu_nome, 
				bbh_fluxo.bbh_flu_titulo, 
				 bbh_usuario.bbh_usu_apelido, 
				 bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao,
				 concat(bbh_fluxo.bbh_flu_autonumeracao,'/',bbh_fluxo.bbh_flu_anonumeracao) as caso
			FROM bbh_atividade 
			 INNER JOIN bbh_fluxo ON bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo 
			 INNER JOIN bbh_modelo_fluxo ON bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
			 INNER JOIN bbh_tipo_fluxo ON bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
			 INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_atividade.bbh_usu_codigo
	WHERE bbh_usuario.bbh_usu_identificacao = '".$_SESSION['MM_User_email']."'
			AND bbh_fluxo.bbh_flu_finalizado = 0 GROUP BY bbh_fluxo.bbh_flu_codigo
   			  ORDER BY bbh_tipo_fluxo.bbh_tip_flu_codigo ASC";
    list($fluxos, $row_fluxos, $totalRows_fluxos) = executeQuery($bbhive, $database_bbhive, $query_fluxos);
	
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de cadastro de arquivos do ".$_SESSION['arqNome']." - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>
<link rel="stylesheet" type="text/css" href="../includes/bbhive.css">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><img src="/corporativo/servicos/bbhive/images/meus_documentos.gif" alt="" width="24" height="24" align="absmiddle" /><strong>&nbsp;<?php echo $_SESSION['arqNome']; ?> - CADASTRO</strong>
      <label class="color" id="idTxt"></label></td>
  </tr>
</table>
<br>
<form name="formUpload" id="formUpload" action="/corporativo/servicos/bbhive/arquivos/upload/executa.php" method="post" enctype="multipart/form-data" target="upload_target">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" colspan="3" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px;">&nbsp;<span class="verdana_12"><img src="/corporativo/servicos/bbhive/images/icon_05.gif" width="15" height="12" /></span>&nbsp;<strong>Escolha o <?php echo $_SESSION['FluxoNome']; ?> antes de efetuar upload do arquivo</strong></td>
  </tr>
  <tr>
    <td width="20" height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td height="50" colspan="2" align="left" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">
      <?php echo $_SESSION['FluxoNome']; ?><br />
      <?php if($totalRows_fluxos>0){ ?>
      &nbsp;<select name="bbh_flu_codigo" id="bbh_flu_codigo" class="formulario2" style="width:550px;">
        <option value="-1">-----------Selecione-----------</option>
          <?php
    $tipo = 0;
        do {  
		
		//--
			$nomeFluxo 		= $row_fluxos['bbh_mod_flu_nome'];
			$autoNumeracao	= $row_fluxos['bbh_flu_autonumeracao'];
			$tipoProcesso	= explode(".",$row_fluxos['bbh_tip_flu_identificacao']);
			$tipoProcesso	= (int)$tipoProcesso[0];
			$anoNumeracao	= $row_fluxos['bbh_flu_anonumeracao'];
			//--
			$numeroProcesso	= $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
			//--
		//--	

            if($tipo != $row_fluxos['bbh_tip_flu_codigo']){
    ?>
          <optgroup label="----------------------------------">----------------------------------</optgroup>
        <optgroup label="<?php echo strtolower($row_fluxos['bbh_tip_flu_nome']); ?>"><?php echo strtolower($row_fluxos['bbh_tip_flu_nome']); ?></optgroup>
        <?php } ?>
        <option value="<?php echo $row_fluxos['bbh_flu_codigo']?>" <?php if($bbh_flu_codigo == $row_fluxos['bbh_flu_codigo']){echo 'selected="selected"'; } ?>>&nbsp;&nbsp;<?php echo strtolower($row_fluxos['bbh_flu_titulo']) . " - " . $numeroProcesso; ?></option>
        <?php
        $tipo = $row_fluxos['bbh_tip_flu_codigo'];	
    } while ($row_fluxos = mysqli_fetch_assoc($fluxos));
      $rows = mysqli_num_rows($fluxos);
      if($rows > 0) {
          mysqli_data_seek($fluxos, 0);
          $row_fluxos = mysqli_fetch_assoc($fluxos);
      }
    ?>
        </select>
      
      <?php } else { echo "Voc&ecirc; n&atilde;o pertence a um processo. Entre em contato com o administrador."; exit;} ?></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td colspan="2" align="left" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">Autor:&nbsp;&nbsp;<span style="color:#000"><?php echo $row_fluxos['bbh_usu_apelido']; ?></span><input name="bbh_arq_autor" type="hidden" id="bbh_arq_autor" value="<?php echo $row_fluxos['bbh_usu_apelido']; ?>" /></td>
    </tr>

  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#F7F7F7" style="border-left:#CCCCCC solid 1px;border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td colspan="2" align="left" valign="middle" bgcolor="#F7F7F7"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393"><span class="verdana_11 color">
      <input name="bbh_arq_compartilhado" type="checkbox" id="bbh_arq_compartilhado" checked="checked" />
      Compartilhar arquivo com equipe</span></td>
    </tr>
    
    <tr>
    <td height="30" align="center" valign="middle" bgcolor="#F7F7F7" style="border-left:#CCCCCC solid 1px;border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td colspan="2" align="left" valign="middle" bgcolor="#F7F7F7"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393"><span class="verdana_11 color">
      <input name="bbh_arq_publico" type="checkbox" id="bbh_arq_publico" />
      <?php echo $_SESSION['arqPublLegenda']; ?></span></td>
    </tr>
    
    <tr>
    <td height="30" align="center" valign="middle" bgcolor="#F7F7F7" style="border-left:#CCCCCC solid 1px;border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td colspan="2" align="left" valign="top" bgcolor="#F7F7F7"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393"><span class="verdana_11 color">
    &nbsp; Observação:&nbsp;</span><textarea cols="45" rows="2" name="bbh_arq_obs_publico" id="bbh_arq_obs_publico" ></textarea></td>
    </tr>
    
  <tr style="display:none">
    <td height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td width="124" align="right" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">Arquivo:&nbsp;</td>
    <td width="451" align="left" valign="middle" bgcolor="#FFFFFF" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px"><span class="verdana_11">&nbsp;
      <input name="myfile" id="myfile" type="file" size="30" value="" class="back_input"/>
    </span></td>
  </tr>
  <tr>
    <td height="30" colspan="3" align="right" valign="middle" bgcolor="#F7F7F7" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">
	<span style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">
	<input name="bbh_arq_descricao" id="bbh_arq_descricao" type="hidden" value="" />
	<input title="D&ecirc; um t&iacute;tulo para o arquivo que ser&aacute; enviado" name="bbh_arq_titulo" type="hidden" class="back_Campos" id="bbh_arq_titulo" value="" size="50" maxlength="255" style="height:17px;" />
	</span>
	<?php if(isset($_GET['bbh_flu_codigo'])){ ?>
    	<input name="bbh_flu_codigo_sel" id="bbh_flu_codigo_sel" type="hidden" value="<?php echo $_GET['bbh_flu_codigo']; ?>">
    <?php }
    	if(isset($bbh_ati_codigo)){
	?>
    	<input name="bbh_ati_codigo" id="bbh_ati_codigo" type="hidden" value="<?php echo $bbh_ati_codigo; ?>">
    <?php } ?>
   
    <input name="MM_insert" type="hidden" id="MM_insert" value="1" />
    <input type="button" name="button" id="button" value="Voltar" class="back_input" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;arquivos=1|arquivos/index.php?<?php if(isset($_GET['bbh_flu_codigo'])){ echo "bbh_flu_codigo=".$_GET['bbh_flu_codigo']; }?>&<?php if(isset($bbh_ati_codigo)){echo "bbh_ati_codigo=".$bbh_ati_codigo;} ?>|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;equipeArquivos=1','menuEsquerda|colCentro|colDireita');" style="cursor:pointer;" />
    
<input type="button" name="button" id="button" value="Cadastrar" class="back_input" onclick="if(document.getElementById('bbh_flu_codigo').value != '-1'){ <?php /*submeteArquivo(document.getElementById('bbh_flu_codigo').value, document.getElementById('bbh_arq_compartilhado').checked,document.getElementById('bbh_arq_publico').checked,'<?php echo $row_fluxos['bbh_usu_apelido']; ?>')*/?>OpenAjaxPostCmd('/corporativo/servicos/bbhive/arquivos/regra.php','ambienteRelatorio','formUpload','<strong>Aguarde...</strong>','ambienteRelatorio','1','2');}else{alert('Informe o fluxo')}" style="cursor:pointer;" />
    </td>
  </tr>
</table>
<div class="color verdana_11" id="barra_progresso" style="display:none; width:595px;" align="center">
Aguarde enviando dados...<br>
<img src="/corporativo/servicos/bbhive/images/loader.gif" />
</div>
<div id="loadNovo"></div>
</form>
<iframe id="upload_target" name="upload_target" frameborder="0" width="590"></iframe>