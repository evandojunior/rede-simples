<?php   ini_set('display_erros',true);
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//caminho onde está o XML com os títulos
	$UrlXML = "../../../../datafiles/servicos/bbhive/setup/titulo.xml";
	
	//cria objeto xml
	$objXML = new DOMDocument("1.0", "iso-8859-1"); 
	$objXML->preserveWhiteSpace = false; //descartar espacos em branco    
	$objXML->formatOutput = false; //gerar um codigo bem legivel 
	$objXML->load($UrlXML); //coloca conteúdo no objeto
		
	//le url a ser consultada
	$ConfigXML	= $objXML->getElementsByTagName("titulos")->item(0);
	
	//--Atualiza informações do XML
	if(isset($_POST['mmUpdate'])){
		//Começa a varrer o POST
		foreach($_POST as $indice=>$valor){
			$input = explode("_",$indice);
			//--
				if(!empty($input[0]) && !empty($input[1])){
					$elementoXML = $input[0];
					//--
					$atributo	 = $input[1];
					$vrAtributo	 = ($valor);
					//--
					//echo $input[0]." - ".$input[1]."=".($vrAtributo)."<hr>";
					$ConfigXML->getElementsByTagName($elementoXML)->item(0)->setAttribute($atributo, $vrAtributo);
					//--
					//echo $ConfigXML->getElementsByTagName($elementoXML)->item(0)->getAttribute($atributo)."<hr>";
				}
		}
		
		//grava objeto
		$objXML->appendChild($ConfigXML);
		
		//remove o arquivo
		chmod($UrlXML,0777);
		unlink($UrlXML);
		
		//cria arquivo
		$objXML->save($UrlXML); //salvar arquivo
		
		//muda permissão do arquivo
		chmod($UrlXML,0777);
	
		echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');</var>";
		exit;
	}
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/dicionario/index.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'editaTermo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo ($_SESSION['adm_dicionarioNome']); ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="91%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-dicionario-16px.gif" width="14" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_dicionarioNome']; ?></td>
    <td width="9%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
  <tr style="font-weight:bold;">
    <td height="22" colspan="2" style="border-bottom:1px solid #333333;">Altere os t&iacute;tulos e legendas que ser&atilde;o exibidos durante todo o sistema para os usu&aacute;rios.</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
  <tr>
    <td height="22" colspan="2"><form id="editaTermo" name="editaTermo"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#F1F1F1">
    <?php foreach($ConfigXML->childNodes as $cadaLinha){
			//--
			$nmInput  = $cadaLinha->tagName . "_titulo";
			$LegInput = $cadaLinha->tagName . "_legenda";
			//--
		?>
      <tr>
        <td height="25" colspan="2" align="left" bgcolor="#F5F5F5"><strong>&nbsp;<?php echo converte(($cadaLinha->getAttribute("nome")));?></strong></td>
      </tr>
      <tr>
        <td width="11%" height="25" align="right" bgcolor="#FFFFFF">T&iacute;tulo:</td>
        <td width="89%" bgcolor="#FFFFFF"><input id="<?php echo $nmInput;?>" class="back_input" size="60" name="<?php echo $nmInput;?>" value="<?php echo (($cadaLinha->getAttribute("titulo")));?>" /></td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#FFFFFF">Legenda:</td>
        <td bgcolor="#FFFFFF">

<?php  if (strlen($cadaLinha->getAttribute("legenda"))>80){;?>
        <textarea class="formulario2" id="<?php echo $LegInput;?>" name="<?php echo $LegInput;?>" cols="70" rows="3"><?php echo (($cadaLinha->getAttribute("legenda")));?></textarea>
<?php }else{ ?>
        <input id="<?php echo $LegInput;?>"class="back_input" size="70" name="<?php echo $LegInput;?>" value="<?php echo (($cadaLinha->getAttribute("legenda")));?>" />
<?php } ?>
           </td>
      </tr>
      <tr>
        <td colspan="2" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    <?php } ?>
      <tr>
        <td height="25" colspan="2" align="right" bgcolor="#FFFFFF">
        <div id="menLoad" style="float:left" class="verdana_12">&nbsp;</div>
        <div style="float:right">
        <input type="hidden" name="mmUpdate" id="mmUpdate" /><input class="button" type="button" name="button" id="button" value="Cancelar" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');" />
        &nbsp;
          <input class="button" type="button" name="button2" id="button2" value="Salvar" onclick="<?php echo $acao; ?>" />
          </div>
          </td>
        </tr>
    </table>
    </form></td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>