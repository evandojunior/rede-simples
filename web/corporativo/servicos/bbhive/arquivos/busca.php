<?php 
 /*if(!isset($_SESSION)){ session_start(); }
 //Arquivo de conexão GERAL
 require_once("../includes/autentica.php");
 $pagina = "/corporativo/servicos/bbhive/arquivos/includes/agrupado.php";
 
/*===============================INICIO AUDITORIA POLICY=========================================
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de busca de arquivos do ".$_SESSION['arqNome']." - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================

*/
$pagina = "/corporativo/servicos/bbhive/arquivos/includes/agrupado.php";
//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= 'arquivos/index.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'conteudoGeral';
	$infoGet_Post	= 'buscaArquivo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Consultando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
?>
<link rel="stylesheet" type="text/css" href="../includes/bbhive.css">
<input name="pagBusca" type="hidden" id="pagBusca" value="<?php echo $pagina; ?>"/>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" /><strong>&nbsp;Console de busca de arquivos</strong></td>
  </tr>
</table>
<form id="buscaArquivo" name="buscaArquivo">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
		<td height="28" colspan="3" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px;">&nbsp;<span class="verdana_13" style="border-bottom:1px solid #666666;"><img src="/corporativo/servicos/bbhive/images/busca.gif" alt="" width="16" height="16" align="absmiddle" /></span>&nbsp;<strong>Selecione os campos necess&aacute;rios para efetuar a busca</strong><strong></strong></td>
    </tr>
          <tr>
            <td width="39" height="22" align="center" valign="middle" bgcolor="#EFEFE7"><input type="checkbox" name="chkNmArquivo" id="chkNmArquivo" value="1" <?php echo pesquisaVetor("0", "chkNmArquivo", ""); ?> /></td>
            <td width="146" align="left" valign="middle" bgcolor="#FFFFFF"class="verdana_11" >&nbsp;Nome do arquivo:&nbsp;</td>
            <td width="670" align="left" valign="middle" bgcolor="#FFFFFF"><a href="#@" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbNomeLogico','?tipo=bbh_arq_nome_logico&amp;tagInput=lbNomeLogico&amp;tagIcone=iconeNomeLogico&amp;ts=<?php echo time(); ?>','Carregando...','lbNomeLogico','2','2');"></a><span class="verdana_11" style="line-height:25px;height:25px;margin-left:2px;">
        <label id="iconeNomeLogico"><a href="#@" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbNomeLogico','?tipo=bbh_arq_nome_logico&amp;tagInput=lbNomeLogico&amp;tagIcone=iconeNomeLogico&amp;ts=<?php echo time(); ?>','Carregando...','lbNomeLogico','2','2');"></a> </label>
              <label id="lbNomeLogico">
                <input name="bbh_arq_nome_logico" type="text" class="formulario2" id="bbh_arq_nome_logico" size="80" style="height:17px;border:#E3D6A4 solid 1px;" value="<?php echo pesquisaVetor("1", "chkNmArquivo", ""); ?>"/>
              </label>
            </span></td>
            <td width="3">
            </td>
          </tr>
          <tr>
            <td colspan="3" align="center" valign="middle" bgcolor="#ECECEC" height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
          </tr>
          <tr>
            <td height="22" align="center" valign="middle" bgcolor="#EFEFE7"><input type="checkbox" name="chkTituloArquivo" id="chkTituloArquivo" value="1" <?php echo pesquisaVetor("0", "chkTituloArquivo", ""); ?> /></td>
            <td width="146" align="left" valign="middle" bgcolor="#FFFFFF"class="verdana_11">&nbsp;T&iacute;tulo do arquivo:&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF"><a href="#" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbTitulo','?tipo=bbh_arq_titulo&amp;tagInput=lbTitulo&amp;tagIcone=iconeTitulo&amp;ts=<?php echo time(); ?>','Carregando...','lbTitulo','2','2');"></a><span class="verdana_11" style="line-height:25px;height:25px;margin-left:2px;">
        <label id="iconeTitulo"><a href="#" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbTitulo','?tipo=bbh_arq_titulo&amp;tagInput=lbTitulo&amp;tagIcone=iconeTitulo&amp;ts=<?php echo time(); ?>','Carregando...','lbTitulo','2','2');"></a> </label>
              <label id="lbTitulo">
                <input name="bbh_arq_titulo" type="text" class="formulario2" id="bbh_arq_titulo" size="80" style="height:17px;border:#E3D6A4 solid 1px;" value="<?php echo pesquisaVetor("1", "chkTituloArquivo", ""); ?>" />
              </label>
            </span></td>
          </tr>
          <tr>
            <td colspan="3" align="center" valign="middle" bgcolor="#ECECEC" height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
          </tr>
          <tr>
            <td height="22" align="center" valign="middle" bgcolor="#EFEFE7"><input type="checkbox" name="chkAutorArquivo" id="chkAutorArquivo" value="1" <?php echo pesquisaVetor("0", "chkAutorArquivo", ""); ?> /></td>
            <td width="146" align="left" valign="middle" bgcolor="#FFFFFF"class="verdana_11">&nbsp;Autores compartilhados:&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF"><a href="#" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbAutor','?tipo=bbh_arq_autor&amp;tagInput=lbAutor&amp;tagIcone=iconeAutor&amp;ts=<?php echo time(); ?>','Carregando...','lbAutor','2','2');"></a><span class="verdana_11" style="line-height:25px;height:25px;margin-left:2px;">
        <label id="iconeAutor"><a href="#" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbAutor','?tipo=bbh_arq_autor&amp;tagInput=lbAutor&amp;tagIcone=iconeAutor&amp;ts=<?php echo time(); ?>','Carregando...','lbAutor','2','2');"></a> </label>
              <label id="lbAutor">
                <input name="bbh_arq_autor" type="text" class="formulario2" id="bbh_arq_autor" size="80" style="height:17px;border:#E3D6A4 solid 1px;" value="<?php echo pesquisaVetor("1", "chkAutorArquivo", ""); ?>" />
              </label>
            </span></td>
          </tr>
          <tr>
            <td colspan="3" align="center" valign="middle" bgcolor="#ECECEC" height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
          </tr>
          <tr>
            <td height="22" align="center" valign="middle" bgcolor="#EFEFE7"><input type="checkbox" name="chkFluxoArquivo" id="chkFluxoArquivo" value="1" <?php echo pesquisaVetor("0", "chkFluxoArquivo", ""); ?>/></td>
            <td width="146" align="left" valign="middle" bgcolor="#FFFFFF"class="verdana_11">&nbsp;<?php echo $_SESSION['FluxoNome']; ?>:</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF"><a href="#" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbFluxo','?tipo=bbh_flu_titulo&amp;tagInput=lbFluxo&amp;tagIcone=iconeFluxo&amp;ts=<?php echo time(); ?>','Carregando...','lbFluxo','2','2');"></a><span class="verdana_11" style="line-height:25px;height:25px;margin-left:2px;">
        <label id="iconeFluxo"><a href="#" onclick="return OpenAjaxPostCmd('<?php echo $pagina; ?>','lbFluxo','?tipo=bbh_flu_titulo&amp;tagInput=lbFluxo&amp;tagIcone=iconeFluxo&amp;ts=<?php echo time(); ?>','Carregando...','lbFluxo','2','2');"></a> </label>
              <label id="lbFluxo">
                <input name="bbh_flu_titulo" type="text" class="formulario2" id="bbh_flu_titulo" size="80" style="height:17px;border:#E3D6A4 solid 1px;"  value="<?php echo pesquisaVetor("1", "chkFluxoArquivo", ""); ?>"/>
              </label>
            </span></td>
          </tr>
          <tr>
            <td colspan="3" align="center" valign="middle" bgcolor="#ECECEC" height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
          </tr>
          <tr>
            <td height="22" align="center" valign="middle" bgcolor="#EFEFE7"><input type="checkbox" name="busca_data" id="busca_data" value="1" <?php echo pesquisaVetor("0", "busca_data", ""); ?>/></td>
            <td width="146" align="left" valign="middle" bgcolor="#FFFFFF"class="verdana_11">&nbsp;Data da publica&ccedil;&atilde;o:&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF"><input name="DataInicio" type="text" class="formulario2" id="DataInicio" value="<?php 
			
			$d = pesquisaVetor("1", "busca_data", "0");
			echo empty($d)?date('d/m/Y'):$d; 
			
			?>" size="13" maxlength="10" onkeypress="MascaraData(event, this)"/>
              <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.buscaArquivo.DataInicio,'dd/mm/yyyy',this)"/>
at&eacute;&nbsp;
<input name="DataFim" type="text" class="formulario2" id="DataFim" value="<?php 
			
			$d = pesquisaVetor("1", "busca_data", "1");
			echo empty($d)?date('d/m/Y'):$d; 
			
			?>" size="13" maxlength="10" onkeypress="MascaraData(event, this)"/>
<input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.buscaArquivo.DataFim,'dd/mm/yyyy',this)"/></td>
          </tr>
      <tr>
        <td height="25" colspan="3" align="left" bgcolor="#EFEFE7" class="verdana_11">
            <div style=" <?php echo pesquisaVetor("0", "situacao", "")!="checked"?"visibility:hidden":""; ?>">
            	<div style="float:left; width:24px;" align="center"><input type="checkbox" name="situacao" id="situacao" <?php echo pesquisaVetor("0", "situacao", ""); ?>/></div>
                <div style="float:left; width:320px;" align="left">&nbsp;<strong>Arquivos: "<?php echo pesquisaVetor("1", "situacao", ""); ?>" <input name="bbh_situacao" type="hidden" value="<?php echo pesquisaVetor("1", "situacao", ""); ?>" class="back_Campos" id="bbh_situacao"  style="height:17px;border:#E3D6A4 solid 1px;" size="20" maxlength="20"/></strong></div>
            </div>
        </td>
    </tr>
          <tr>
            <td height="22" colspan="3" align="right" valign="middle" bgcolor="#EFEFE7"><input name="busca_arquivo" type="hidden" id="busca_arquivo" value="1" />
              <input type="button" name="web" id="web" value="Pesquisar" class="back_input" onclick="<?php echo $acao; ?>" style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" />
            &nbsp;</td>
          </tr>
    </table>
</form>