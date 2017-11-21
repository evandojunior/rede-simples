<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/protocolos/cadastro/detalhamento/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_pro_codigo")||($indice=="bbh_pro_codigo")){	$bbh_pro_codigo= $valor; } 
}

//POIS VOU REDIRECIONAR PARA O OK.PHP
$arquivo = "../../../../datafiles/servicos/bbhive/setup/config.xml";

//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
	$doc = new DOMDocument("1.0", "iso-8859-1"); 
	$doc->preserveWhiteSpace = false; //descartar espacos em branco    
	$doc->formatOutput = false; //gerar um codigo bem legivel   
	$doc->load($arquivo);
	//-----	
	$root = $doc->getElementsByTagName("config")->item(0);
	$prot = $root->getElementsByTagName("protocolo")->item(0);
	//-----
	//$detalhamento 	= $prot->getAttribute("detalhamento");

	$query_strProtocolo = "SELECT * FROM bbh_protocolos where bbh_pro_codigo =  $bbh_pro_codigo";
    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);
	
	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '1';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/servicos/bbhive/protocolos/cadastro/executa.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','carregaDuplicado','solicitacao','Aguarde atualizando dados...','carregaDuplicado','1','".$TpMens."');";

	$query_dpto = "select bbh_dep_codigo, bbh_dep_nome from bbh_departamento order by bbh_dep_nome ASC";
    list($dpto, $rows, $totalRows_dpto) = executeQuery($bbhive, $database_bbhive, $query_dpto, $initResult = false);

	$todosDepto = array();
	//--
	while($row_dpto = mysqli_fetch_assoc($dpto)){
		$todosDepto[$row_dpto['bbh_dep_codigo']] = $row_dpto['bbh_dep_nome'];
	}
	//--
	
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Acessou a página de atualização do (".$_SESSION['protNome'].") número (".$bbh_pro_codigo.")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
?><form id="solicitacao" name="solicitacao">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/editar.gif" border="0" align="absmiddle" title="Editar esta solicita&ccedil;&atilde;o" />&nbsp;<strong>Atualizar solicita&ccedil;&atilde;o</strong></td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="300" valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" colspan="4" align="left">&nbsp;<img src="/servicos/bbhive/images/messagebox_warning.gif" align="absmiddle" />&nbsp;Atualize as informa&ccedil;&otilde;es necess&aacute;rias.</td>
    </tr>
  <tr>
    <td height="5" colspan="4" align="right"></td>
    </tr>
  <tr>
    <td height="25" colspan="4"  align="left">
<table width="930" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="283" height="25" align="left" class="verdana_11"><strong>&nbsp;Data de cadastro :</strong></td>
    <td width="647" height="25" align="left" class="verdana_11"><?php echo $d = arrumadata(substr($row_strProtocolo['bbh_pro_momento'],0,10))." ".substr($row_strProtocolo['bbh_pro_momento'],11,5); ?></td>
  </tr>
</table>
	<?php require_once("detalhamento/edita.php"); ?></td>
    </tr>
  <tr>
    <td width="21%" height="25" align="right">&nbsp;</td>
    <td width="29%" valign="middle">&nbsp;</td>
    <td width="50%" colspan="2" align="right"><input class="back_Campos" name="bbh_pro_codigo" type="hidden" id="bbh_pro_codigo" size="30" style="height:17px;" value="<?php echo $bbh_pro_codigo; ?>"/>
			<input name="cadastrar" style="background:url(/servicos/bbhive/images/erro.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;Cancelar" onClick="showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/ok.php','colPrincipal')"/>
            &nbsp;<?php if($totalRows_dpto>0){ ?>
			<input name="cadastrar" style="background:url(/servicos/bbhive/images/disk.gif);background-repeat:no-repeat;background-position:left;height:23px;width:180px;margin-right:1px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;Atualizar solicita&ccedil;&atilde;o" onclick="validaForm('solicitacao','alteraProtocolo|Preencha o campo...<?php echo $campos_obrigatorios; ?>',document.getElementById('acaoForm').value);"/><?php } else { echo "Não há departamentos cadastrados.";}?></td>
    </tr>
</table></td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table><div align="right" style="margin-right:5px" id="carregaDuplicado" class="legandaLabel11 color">&nbsp;</div><input type="hidden" name="alteraProtocolo" id="alteraProtocolo" value="true" /><input type="hidden" name="acaoForm" id="acaoForm" value=" <?php echo $acao; ?>" /></form>