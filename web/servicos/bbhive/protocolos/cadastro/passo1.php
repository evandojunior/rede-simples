<?php if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
	include($_SESSION['caminhoFisico']."/servicos/bbhive/protocolos/cadastro/detalhamento/includes/functions.php");
	
	//--VERIFICO SE EXISTE ALGUM ALGORITMO PARA FAZER A INSERÇÃO PERSONALIZADA	
	require_once("execucao_automatica.php");
	//--

	// Qual o departamento permitido
	$departamentoPermitido = permissoes_nivel();
	
	// Caso Limitado
	if( $departamentoPermitido['per_departamento'] > 0 )
		$query_dpto = "select bbh_dep_codigo, bbh_dep_nome from bbh_departamento WHERE bbh_dep_codigo = ".$departamentoPermitido['per_departamento']." order by bbh_dep_nome ASC";
	else
		$query_dpto = "select bbh_dep_codigo, bbh_dep_nome from bbh_departamento order by bbh_dep_nome ASC";


	list($dpto, $fetch, $totalRows_dpto) = executeQuery($bbhive, $database_bbhive, $query_dpto, $initResult = false);

	$todosDepto = array();
	//--
	while($row_dpto = mysqli_fetch_assoc($dpto)){
		$todosDepto[$row_dpto['bbh_dep_codigo']] = $row_dpto['bbh_dep_nome'];
	}
	//--
	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '1';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/servicos/bbhive/protocolos/cadastro/executa.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','carregaDuplicado','solicitacao','Aguarde cadastrando dados...','carregaDuplicado','1','".$TpMens."');";
	
	//se tiver o pacote de novo protocolo recupero as informações dele.
	if(isset($_SESSION['pacoteNovoProtocolo'])){
		$bbh_flu_pai 			= $_SESSION['pacoteNovoProtocolo']['bbh_flu_pai'];
		$bbh_pro_flagrante 		= $_SESSION['pacoteNovoProtocolo']['bbh_pro_flagrante'];
		$bbh_pro_identificacao	= $_SESSION['pacoteNovoProtocolo']['bbh_pro_identificacao'];
		$bbh_pro_autoridade 	= $_SESSION['pacoteNovoProtocolo']['bbh_pro_autoridade'];
		$bbh_pro_titulo 		= $_SESSION['pacoteNovoProtocolo']['bbh_pro_titulo'];
		$bbh_pro_data			= $_SESSION['pacoteNovoProtocolo']['bbh_pro_data'];
		$bbh_pro_descricao 		= $_SESSION['pacoteNovoProtocolo']['bbh_pro_descricao'];
	}
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Acessou a página para cadastro de (".$_SESSION['protNome'].") - BBHive público.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/

?><form id="solicitacao" name="solicitacao"><table width="970" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" align="absmiddle" />&nbsp;<strong>Cadastro - <?php echo ($_SESSION['protNome']); ?></strong></td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="300" valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="150%" height="25" colspan="4" align="left">&nbsp;<img src="/servicos/bbhive/images/messagebox_warning.gif" align="absmiddle" />&nbsp;Por favor preencha os dados abaixo para gerar um(a) <?php echo $_SESSION['protNome'];?>.</td>
    </tr>
  <tr>
    <td height="5" colspan="4" align="right"></td>
    </tr>
  <tr>
    <td height="5" colspan="4" align="left" valign="top">
<table width="930" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="283" height="25" align="left" class="verdana_11"><strong>&nbsp;Data de cadastro :</strong></td>
    <td width="647" height="25" align="left" class="verdana_11"><?php echo date("d/m/Y - H:i:s");?>
                        <input name="bbh_pro_momento" type="hidden" id="bbh_pro_momento" value="<?php echo date('Y-m-d H:i:s'); ?>" /></td>
  </tr>
</table>
	<?php require_once("detalhamento/regra.php"); ?>
    <?php if(isset($bbh_pro_descricao)){?>
<table width="930" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="283" height="25" align="left" valign="top" class="verdana_11"><strong>&nbsp;Dados cadastrados anteriormente:</strong></td>
    <td width="647" height="25" align="left" valign="top" class="verdana_11"><textarea class="formulario2" name="descricao" id="descricao" cols="60" rows="5" style="width:98%" readonly="readonly"><?php echo ($bbh_pro_descricao); ?></textarea></td>
  </tr>
  <tr>
    <td height="5" colspan="2" align="left" valign="top" class="verdana_11"></td>
    </tr>
</table>
<?php } ?>
    </td>
  </tr>
  <tr>
    <td height="5" colspan="4" align="right" valign="top"><?php if(isset($bbh_flu_pai)){?>
                <input name="bbh_flu_pai" id="bbh_flu_pai" type="hidden" value="<?php echo $bbh_flu_pai; ?>" />
                <?php } ?>
			<input class="back_Campos" name="bbh_pro_email" type="hidden" id="bbh_pro_email" size="30" style="height:17px;" value="<?php echo $_SESSION['MM_User_email']; ?>"/>
			<input name="cadastrar" style="background:url(/servicos/bbhive/images/erro.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;Cancelar" onClick="LoadSimultaneo('protocolos/regra.php','conteudoGeral');"/>
            &nbsp;<?php if($totalRows_dpto>0){ ?>
			<input name="cadastrar" style="background:url(/servicos/bbhive/images/disk.gif);background-repeat:no-repeat;background-position:left;height:23px;width:180px;margin-right:1px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;Cadastrar <?php echo ($_SESSION['protNome']); ?>" onclick="validaForm('solicitacao','insertProtocolo|Preencha o campo...<?php echo $campos_obrigatorios; ?>',document.getElementById('acaoForm').value);"/><?php } else { echo "Não há departamentos cadastrados.";}?></td>
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
<div align="right" style="margin-right:5px" id="carregaDuplicado" class="legandaLabel11 color">&nbsp;</div><input type="hidden" name="insertProtocolo" id="insertProtocolo" value="true" /><input type="hidden" name="acaoForm" id="acaoForm" value="<?php
	if(isset($temCampoFlagrante)){ ?>
		if(confirm('Tem certeza que a opção <?php echo $_SESSION['FlagNome'];?> está correta?!\n     Clique em OK em caso de confirmação.')){
	<?php }
?><?php echo $acao; ?><?php echo isset($temCampoFlagrante)?"}":"";?>" />
</form>