<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	$idMensagemFinal= 'carregaModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/alternativas/modelosFluxos.php';
	$homeDestinoII	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/alternativas/novo.php';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','cadatraAlternativa','cadatraAlt','Cadastrando dados...','cadatraAlternativa','1','".$TpMens."');";
	
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraMod")) {
	$novonome = ($_POST['bbh_flu_alt_titulo']);

	$query_validacao = "SELECT bbh_flu_alt_titulo FROM bbh_fluxo_alternativa WHERE bbh_flu_alt_titulo = '$novonome' and bbh_mod_ati_codigo=".$_POST['bbh_mod_ati_codigo'];
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	 $insertSQL = "INSERT INTO bbh_fluxo_alternativa (bbh_flu_alt_titulo, bbh_flu_observacao, bbh_mod_ati_codigo, bbh_atividade_predileta, bbh_mod_flu_codigo, bbh_mod_ati_ordem) VALUES ('".($_POST['bbh_flu_alt_titulo'])."', '".($_POST['bbh_flu_observacao'])."',".$_POST['bbh_mod_ati_codigo'].", ".$_POST['bbh_atividade_predileta'].", ".$_POST['bbh_mod_flu_codigo'].", ".$_POST['bbh_mod_ati_ordem'].")";
	 list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/modelosAtividades/alternativas/index.php?nv=1&bbh_mod_flu_codigo=".$_POST['bbh_mod_flu_codigo']."&bbh_mod_ati_codigo=".$_POST['bbh_mod_ati_codigo']."','menuEsquerda|conteudoGeral')</var>";
	  exit;
	} else {
		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;'>J&aacute; existe uma alternativa com este t&iacute;tulo&nbsp;</span>";
		exit;
	}
}
?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastro de Alternativas')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de modelos alternativas de atividades</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/alternativas/index.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_mod_ati_codigo=<?php echo $_GET['bbh_mod_ati_codigo']; ?>','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../cabecaModelo.php'); ?>
<?php require_once('cabecaAtividade.php'); ?>
<br />
<div style="position:absolute; margin-left:-2px;" id="carregaModelo"></div>
<div style="position:absolute; margin-top:-12px;" id="cadatraAlternativa"></div>
<form name="cadatraAlt" id="cadatraAlt" style="margin-top:-1px;">
    <table width="98%" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="24" background="/e-solution/servicos/bbhive/images/cabAtiv.gif" class="legandaLabel11"><strong>&nbsp;Cadastro de alternativas</strong>
        <div style="float:right; margin-top:-13px;">
                               <div class="show" align="right" id="escolhe">   
                                  <a href="#@" onClick="<?php echo $onClick; ?>; document.getElementById('bbh_atividade_predileta').className='hide'">&nbsp;Clique e escolha o modelo de <?php echo $_SESSION['adm_FluxoNome']; ?>! <img src="/e-solution/servicos/bbhive/images/var_alerta.gif" alt="" border="0" align="absmiddle" /></a></div>
                               <div class="hide" id="adicionado">
                                  <a href="#@" onClick="<?php echo $onClick; ?>; document.getElementById('bbh_atividade_predileta').className='hide'"><span class="color">&nbsp;Modelo adicionado com sucesso, clique em caso de altera&ccedil;&atilde;o!</span> <img src="/e-solution/servicos/bbhive/images/var[ok].gif" alt="" border="0" align="absmiddle" /></a>       </div> 
        </div>                          
        </td>
      </tr>
      <tr>
        <td height="100" valign="top" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
          <tr>
            <td width="590" height="60" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="15" colspan="2" align="right" id="cadastraModelo">&nbsp;</td>
                </tr>
              <tr>
                <td width="29%" height="25" align="right"><strong>Alternativa :&nbsp;</strong></td>
                <td width="71%">&nbsp;<input class="back_Campos" name="bbh_flu_alt_titulo" type="text" id="bbh_flu_alt_titulo" size="60" style="height:17px;border:#E3D6A4 solid 1px;"/></td>
              </tr>
              <tr>
                <td height="25" align="right"><strong>Modelo de  <?php echo $_SESSION['adm_FluxoNome']; ?>:&nbsp;</strong></td>
                <td align="left" id="modFlu" class="color"><span class="aviso">&nbsp;Modelo n&atilde;o adicionado.</span></td>
              </tr>
              <tr>
                <td height="25" align="right"><strong>Modelo atividade  :&nbsp;</strong></td>
                <td align="left" id="modAlt" class="color"><span class="aviso">&nbsp;Modelo n&atilde;o adicionado.</span></td>
              </tr>
              <tr>
                <td height="25" align="right"><strong>Ordena&ccedil;&atilde;o da predileta  :&nbsp;</strong></td>
                <td>
                <label>
                  <select name="bbh_atividade_predileta" id="bbh_atividade_predileta"  class="legandaLabel11">
                  	<?php for($a=1; $a<101; $a++){ ?>
                    	<option value="<?php echo $a; ?>"><?php echo $a; ?></option>
                    <?php } ?>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td height="25" align="right" valign="top"><strong>Observa&ccedil;&atilde;o  :&nbsp;</strong></td>
                <td><label>
                  <textarea class="back_Campos" name="bbh_flu_observacao" id="bbh_flu_observacao" rows="5" cols="70" style="border:#E3D6A4 solid 1px;"></textarea>
                </label></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="24" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td height="24" align="center"><label>
              <input type="hidden" name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo">
              <input type="hidden" name="bbh_mod_ati_ordem" id="bbh_mod_ati_ordem">
            </label></td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td height="24" class="legandaLabel11"><div style="float:right;">
                <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/alternativas/index.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_mod_ati_codigo=<?php echo $_GET['bbh_mod_ati_codigo']; ?>','menuEsquerda|conteudoGeral');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
                                               <input name="insereModelo" type="button" class="back_input" id="insereModelo" value="Cadastrar alternativa" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return validaForm('cadatraAlt', 'bbh_flu_alt_titulo|Escreva o t&iacute;tulo da alternativa, bbh_mod_flu_codigo|Escolha o modelo de fluxo', document.getElementById('acaoForm').value)"/>
                                               &nbsp;&nbsp;&nbsp;            </div>    </td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
        </table></td>
      </tr>
    </table>
<input type="hidden" name="MM_insert" value="cadastraMod" />
     <input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
     <input type="hidden" name="bbh_mod_ati_codigo" id="bbh_mod_ati_codigo" value="<?php echo $_GET['bbh_mod_ati_codigo']; ?>" />
</form>