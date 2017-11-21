<?php
 if(!isset($_SESSION)){ session_start(); }
 //Arquivo de conexão GERAL
 require_once("../includes/autentica.php");
 
  	foreach($_GET as $indice => $valor){
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
		if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){ $bbh_ati_codigo=$valor; }
	}

	$query_arquivo = "SELECT bbh_fluxo.bbh_flu_titulo, bbh_arquivo.* FROM bbh_arquivo INNER JOIN bbh_fluxo ON bbh_fluxo.bbh_flu_codigo = bbh_arquivo.bbh_flu_codigo WHERE bbh_arq_codigo = ".$_GET['bbh_arq_codigo'];
    list($arquivo, $row_arquivo, $totalRows_arquivo) = executeQuery($bbhive, $database_bbhive, $query_arquivo);

	$query_fluxos = "SELECT bbh_usu_apelido FROM bbh_usuario WHERE bbh_usu_codigo =". $_SESSION['usuCod'];
    list($fluxos, $row_fluxos, $totalRows_fluxos) = executeQuery($bbhive, $database_bbhive, $query_fluxos);

/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de edição de arquivos (".$row_arquivo['bbh_arq_titulo'].") do ".$_SESSION['arqNome']." - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/

$_SESSION['bbh_flu_codigo'] = ($row_arquivo['bbh_flu_codigo']);
$_SESSION['bbh_arq_compartilhado'] = ($row_arquivo['bbh_arq_compartilhado']);
$_SESSION['bbh_arq_publico'] = ($row_arquivo['bbh_arq_publico']);
$_SESSION['bbh_arq_obs_publico'] = ($row_arquivo['bbh_arq_obs_publico']);
$_SESSION['bbh_arq_autor'] = ($row_arquivo['bbh_arq_autor']);
$_SESSION['MM_update'] = 'update';
?>
<link rel="stylesheet" type="text/css" href="../includes/bbhive.css">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><img src="/corporativo/servicos/bbhive/images/anexos-pequeno.gif" alt="" width="23" height="23" align="absmiddle" /><strong>&nbsp;<?php echo $_SESSION['arqNome']; ?> - EDI&Ccedil;&Atilde;O</strong>
      <label class="color" id="idTxt"></label></td>
  </tr>
</table>
<br>
<form name="formUpload" id="formUpload" action="/corporativo/servicos/bbhive/arquivos/upload/executa.php" method="post" enctype="multipart/form-data" target="upload_target">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" colspan="3" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px;">&nbsp;<span class="verdana_12"><img src="/corporativo/servicos/bbhive/images/icon_05.gif" width="15" height="12" /></span>&nbsp;<strong>Atualize as informa&ccedil;&otilde;es necess&aacute;rias</strong></td>
  </tr>
  
  <tr>
    <td width="34" height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td width="144" align="right" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">&nbsp;<?php echo $_SESSION['FluxoNome']; ?>:&nbsp;</td>
    <td width="417" align="left" valign="middle" bgcolor="#FFFFFF" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px"><span class="verdana_12">&nbsp;<?php echo $row_arquivo['bbh_flu_titulo']; ?></span></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td width="144" align="right" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">Autor:&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF" class="verdana_12" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;<?php echo $row_fluxos['bbh_usu_apelido']; ?></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td width="144" align="right" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">T&iacute;tulo do arquivo:&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;<input title="D&ecirc; um t&iacute;tulo para o arquivo que ser&aacute; enviado" name="bbh_arq_titulo" type="text" class="back_Campos" id="bbh_arq_titulo" value="<?php echo $row_arquivo['bbh_arq_titulo']; ?>" size="50" maxlength="255" style="height:17px;" /></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td width="144" align="right" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">Descri&ccedil;&atilde;o:&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">      &nbsp;<textarea title="Escreva uma breve descri&ccedil;&atilde;o do arquivo" class="formulario2" name="bbh_arq_descricao" id="bbh_arq_descricao" cols="70" rows="5"><?php echo $row_arquivo['bbh_arq_descricao']; ?></textarea></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#ECECEC" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td width="144" align="right" valign="middle" bgcolor="#FFFFFF"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">Observa&ccedil;&atilde;o:&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">      &nbsp;<textarea title="Escreva uma breve observacao do arquivo" class="formulario2" name="bbh_arq_obs_publico" id="bbh_arq_obs_publico" cols="70" rows="5"><?php echo str_replace("<br />","",$row_arquivo['bbh_arq_obs_publico']); ?></textarea></td>
  </tr>

  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#F7F7F7" style="border-left:#CCCCCC solid 1px;border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#F7F7F7"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px"><span class="verdana_11 color">
      <input type="checkbox" name="bbh_arq_compartilhado" id="bbh_arq_compartilhado" <?php if($row_arquivo['bbh_arq_compartilhado']==1){ echo "checked=checked"; } ?>/>
      Compartilhar arquivo com equipe</span></td>
  </tr>
  
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#F7F7F7" style="border-left:#CCCCCC solid 1px;border-bottom:#CCCCCC solid 1px">&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#F7F7F7"class="verdana_11" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;color:#393">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#F7F7F7" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px"><span class="verdana_11 color">
      <input type="checkbox" name="bbh_arq_publico" id="bbh_arq_publico" <?php if($row_arquivo['bbh_arq_publico']==1){ echo "checked=checked"; } ?>/>
      <?php echo $_SESSION['arqPublLegenda']; ?></span></td>
  </tr>  
  <tr>
    <td height="30" colspan="3" align="right" valign="middle" bgcolor="#F7F7F7" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px">
      <span class="verdana_11">
      <input name="bbh_arq_codigo" type="hidden" id="bbh_arq_codigo" value="<?php echo $_GET['bbh_arq_codigo']; ?>" />
      <input name="MM_update" type="hidden" id="MM_update" value="1">
      </span>
      <?php if(isset($_GET['bbh_flu_codigo'])){ ?>
      <input name="bbh_flu_codigo_sel" id="bbh_flu_codigo_sel" type="hidden" value="<?php echo $_GET['bbh_flu_codigo']; ?>">
    <?php }
    	if(isset($bbh_ati_codigo)){
	?>
    	<input name="bbh_ati_codigo" id="bbh_ati_codigo" type="hidden" value="<?php echo $bbh_ati_codigo; ?>">
    <?php } ?>
      <input type="button" name="button" id="button" value="Voltar" class="back_input" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;arquivos=1|arquivos/index.php?<?php if(isset($_GET['bbh_flu_codigo'])){ echo "bbh_flu_codigo=".$_GET['bbh_flu_codigo']; } if(isset($bbh_ati_codigo)){echo "&bbh_ati_codigo=".$bbh_ati_codigo;} ?>|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;equipeArquivos=1','menuEsquerda|colCentro|colDireita');" style="cursor:pointer;" />
      
  <input type="button" name="button" id="button" value="Atualizar" class="back_input" onclick="if(document.getElementById('bbh_arq_titulo').value!=''){ document.getElementById('barra_progresso').style.display='block'; document.formUpload.submit(); } else { alert('Erro no formulário:\n.:: Informe um título.') }" style="cursor:pointer;" />
      </td>
  </tr>
</table>
<div class="color verdana_11" id="barra_progresso" style="display:none; width:595px;" align="center">
Aguarde enviando dados...<br>
<img src="/corporativo/servicos/bbhive/images/loader.gif" />
</div>
</form>
<iframe id="upload_target" name="upload_target" class="hide" src="#" style="height:50px;width:595px;border:0px solid #fff;"></iframe>