<?php  if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_pro_codigo")||($indice=="bbh_pro_codigo")){	$bbh_pro_codigo= $valor; } 
	if(($indice=="amp;bbh_pro_titulo")||($indice=="bbh_pro_titulo")){	$bbh_pro_titulo= $valor; } 
	if(($indice=="amp;bbh_pro_data")||($indice=="bbh_pro_data")){ $bbh_pro_data= $valor; } 
}

	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '1';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/corporativo/servicos/bbhive/protocolo/executa.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','resultBusca','consultaProtocolo','Consultando dados...','resultBusca','1','".$TpMens."');";

?>
<var style="display:none">txtSimples('tagPerfil', 'P&aacute;gina de <?php echo($_SESSION['ProtNome']); ?>')</var>
		<table width="98%" border="0" align="center" cellpadding="0"  cellspacing="0" class="verdana_11">
		  <tr>
			<td width="485" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">
				<strong>Painel de <?php echo ($_SESSION['ProtNome']); ?></strong>
			</td>
			<td width="101" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><strong><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/index.php?todos=true','menuEsquerda|conteudoGeral');">Exibir todos</a></strong></td>
		  </tr>
		</table>
        
<form id="consultaProtocolo" name="consultaProtocolo">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/andamento.gif" align="absmiddle" />&nbsp;<strong>Consultar <?php echo ($_SESSION['ProtNome']); ?></strong></td>
  </tr>
  <tr>
    <td height="50" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
       
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td width="27%" bgcolor="#F6F6F6" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/para.gif" align="absmiddle" />&nbsp;N&ordm; - <?php echo ($_SESSION['ProtNome']); ?></td>
            <td width="33%" bgcolor="#F6F6F6" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/calendario.gif" align="absmiddle" />&nbsp;Data do cadastro</td>
            <td colspan="2" bgcolor="#F6F6F6" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/input_text.gif" align="absmiddle" />&nbsp;<?php echo $o=($_SESSION['ProtOfiNome']);?></td>
          </tr>
          <tr>
            <td bgcolor="#F6F6F6">&nbsp;
              <input name="ck_prot" type="checkbox" id="ck_prot" checked="checked" onclick="javascript: if(this.checked==true){ document.getElementById('bbh_pro_codigo').className='btAceso'; document.getElementById('bbh_pro_codigo').disabled=0; document.getElementById('bbh_pro_codigo').focus();} else { document.getElementById('bbh_pro_codigo').className='btApagado'; document.getElementById('bbh_pro_codigo').disabled=1; }" />
<input class="btAceso" name="bbh_pro_codigo" type="text" id="bbh_pro_codigo" size="15" onKeyDown="return SomenteNumerico(this);" onKeyPress="return SomenteNumerico(this);" onKeyUp="return SomenteNumerico(this);"/></td>
            <td bgcolor="#F6F6F6">&nbsp;
              <input name="ck_data" type="checkbox" id="ck_data" onclick="javascript: if(this.checked==true){ document.getElementById('bbh_pro_data').className='btAceso'; document.getElementById('bbh_pro_data').disabled=0; document.getElementById('bbh_pro_data').focus();} else { document.getElementById('bbh_pro_data').className='btApagado'; document.getElementById('bbh_pro_data').disabled=1; }" />
            <input class="btApagado" name="bbh_pro_data" type="text" id="bbh_pro_data" size="13" maxlength="10" onkeypress="MascaraData(event, this)" disabled="disabled"/></td>
            <td width="25%" bgcolor="#F6F6F6">&nbsp;
              <input name="ck_tit" type="checkbox" id="ck_tit" onclick="javascript: if(this.checked==true){ document.getElementById('bbh_pro_titulo').className='btAceso'; document.getElementById('bbh_pro_titulo').disabled=0; document.getElementById('bbh_pro_titulo').focus();} else { document.getElementById('bbh_pro_titulo').className='btApagado'; document.getElementById('bbh_pro_titulo').disabled=1; }" />
            <input class="btApagado" name="bbh_pro_titulo" type="text" id="bbh_pro_titulo" size="15" disabled="disabled"/></td>
            <td width="15%" bgcolor="#F6F6F6"><div class="legandaLabel11 tbConsulta" style="border:#CCCCCC solid 1px; height:20px; margin-right:5px; width:98px; float:right;">
                  <a href="#@" onclick="pesquisaProtocolo();" style="width:95px;">
                	&nbsp;<img src="/servicos/bbhive/images/pesquisar.gif" align="absmiddle" border="0"/>&nbsp;Pesquisar                  </a>                </div></td>
          </tr>
          <tr>
            <td height="5" colspan="4" bgcolor="#F6F6F6"></td>
          </tr>
        </table>
    </td>
  </tr>
</table><input name="searchProtocolo" type="hidden" id="searchProtocolo" value="true"/><input type="hidden" name="acaoBusca" id="acaoBusca" value=" <?php echo $acao; ?>" /></form>
   
<?php require_once('protocolo.php'); ?>
    <div id="resultBusca" class="verdana_12"></div>
<var style="display:none">
   <?php if(!isset($bbh_pro_codigo) && !isset($bbh_pro_titulo) && !isset($bbh_pro_data)){?>
    document.getElementById('ck_prot').checked = true;
    document.getElementById('bbh_pro_codigo').disabled=0; 
    document.getElementById('bbh_pro_codigo').className = 'btAceso';
	document.getElementById('bbh_pro_codigo').focus();
   <?php } ?>
   <?php if(isset($bbh_pro_codigo)){?>
    	document.getElementById('ck_prot').checked = true;
		document.getElementById('bbh_pro_codigo').disabled=0; 
    	document.getElementById('bbh_pro_codigo').className = 'btAceso';
    	document.getElementById('bbh_pro_codigo').value = '<?php echo $bbh_pro_codigo; ?>';
    <?php } else { ?>
    document.getElementById('ck_prot').checked = false;
    document.getElementById('bbh_pro_codigo').disabled=1; 
    document.getElementById('bbh_pro_codigo').className = 'btApagado';
    <?php } ?>
   <?php if(isset($bbh_pro_data)){?>
    	document.getElementById('ck_data').checked = true;
		document.getElementById('bbh_pro_data').disabled=0; 
    	document.getElementById('bbh_pro_data').className = 'btAceso';
    	document.getElementById('bbh_pro_data').value = '<?php echo $bbh_pro_data; ?>';
    <?php } ?>
   <?php if(isset($bbh_pro_titulo)){?>
    	document.getElementById('ck_tit').checked = true;
		document.getElementById('bbh_pro_titulo').disabled=0; 
    	document.getElementById('bbh_pro_titulo').className = 'btAceso';
    	document.getElementById('bbh_pro_titulo').value = '<?php echo $bbh_pro_titulo; ?>';
    <?php } ?>
</var>