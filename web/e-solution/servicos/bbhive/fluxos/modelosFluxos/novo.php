<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	$idMensagemFinal= 'carregaTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/escTipo.php';
	$homeDestinoII	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/novo.php';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Cadastrando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraMod")) {

	$novonome = $_POST['bbh_mod_flu_nome'];
	$campo=", bbh_mod_flu_sub";
	$value=", '0'";
	
	if(isset($_POST['bbh_mod_flu_sub'])){
		$campo = ", bbh_mod_flu_sub";
		$value = ", '1'";
	}

	$query_validacao = "SELECT bbh_mod_flu_nome FROM bbh_modelo_fluxo WHERE bbh_mod_flu_nome = '$novonome'";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	 $insertSQL = "INSERT INTO bbh_modelo_fluxo (bbh_tip_flu_codigo, bbh_mod_flu_nome, bbh_mod_flu_observacao $campo) VALUES (".$_POST['bbh_tip_flu_codigo'].", '".$novonome."', '".$_POST['bbh_mod_flu_observacao']."' $value)";
	 list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

	  //==Aqui é para pegar o último registro de modelo para inserir no detalhamento
		$query_ultimo_registro = "SELECT bbh_mod_flu_codigo FROM bbh_modelo_fluxo where bbh_mod_flu_codigo = last_insert_id()";
        list($ultimo_registro, $row_ultimo_registro, $totalRows_ultimo_registro) = executeQuery($bbhive, $database_bbhive, $query_ultimo_registro);
		
		$codigo_modelo = $row_ultimo_registro['bbh_mod_flu_codigo'];
		
          $insertSQL = "INSERT INTO bbh_detalhamento_fluxo (bbh_mod_flu_codigo) VALUES ($codigo_modelo)";
          list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	  //==Fim
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/index.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	} else {
		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;'>J&aacute; existe um modelo com a denomina&ccedil;&atilde;o: ".$_POST['bbh_mod_flu_nome']."</span>";
		exit;
	}
}
?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastro de modelos de  <?php echo $_SESSION['adm_FluxoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de modelos de <?php echo $_SESSION['adm_FluxoNome']; ?></td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/index.php','menuEsquerda|colCentro');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<form name="cadatraModelo" id="cadatraModelo" style="margin-top:-1px;">
    <table width="576" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;">
                    <tr>
                      <td width="28" height="21" align="center">&nbsp;</td>
                      <td width="28" height="21" align="center">&nbsp;</td>
                      <td width="28" align="center">&nbsp;</td>
                      <td width="28" align="center">&nbsp;</td>
                      <td width="28" align="center">&nbsp;</td>
                      <td width="28" align="center">&nbsp;</td>
                      <td width="28" align="center">&nbsp;</td>
                      <td width="28" align="center">&nbsp;</td>
                      <td width="28" align="center"></td>
                      <td width="322">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="21" colspan="10" align="left" background="/e-solution/servicos/bbhive/images/cabeca_tar.gif" class="verdana_11_bold color" id="titulo">&nbsp;Cadastro</td>
                    </tr>
                    <tr>
                      <td height="210" colspan="10" valign="top" id="corpoTarefa" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_12">
                          <tr>
                            <td height="1" colspan="3" align="left"></td>
                          </tr>
                          <tr>
                            <td height="25" colspan="3" align="left" bgcolor="#F4F5F9"><img src="/e-solution/servicos/bbhive/images/05_.gif" alt="" align="absmiddle" />&nbsp;Preencha os dados abaixo para cadastrar um novo modelo.</td>
                          </tr>
                          <tr>
                            <td height="1" colspan="3" align="left"></td>
                          </tr>
                          
                          
                          <tr>
                            <td width="17%" height="25">&nbsp;</td>
                            <td width="17%">&nbsp;</td>
                            <td width="66%">
                               <div class="show" align="right" id="escolhe">   
                                  <a href="#@" onClick="<?php echo $onClick; ?>">&nbsp;Clique e escolha o tipo do modelo! <img src="/e-solution/servicos/bbhive/images/var_alerta.gif" alt="" border="0" align="absmiddle" /></a>                           </div>
                               <div class="hide" id="adicionado">
                                  <a href="#@" onClick="<?php echo $onClick; ?>"><span class="color">&nbsp;Adicionado com sucesso, clique em caso de altera&ccedil;&atilde;o!</span> <img src="/e-solution/servicos/bbhive/images/var[ok].gif" alt="" border="0" align="absmiddle" /></a>       </div> 
                            </td>
                          </tr>
                          <tr>
                            <td height="25" colspan="3"><fieldset style="margin-left:2px; margin-right:2px;">
                              <legend><strong>Dados do modelo</strong></legend>
                              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                                
                                <tr>
                                  <td height="1" colspan="2" align="right" background="/servicos/bbhive/images/separador.gif"></td>
                                </tr>
                                <tr>
                                  <td height="22" align="right">Tipo do modelo :&nbsp;</td>
                                  <td align="left" id="titTipo"><span class="aviso">&nbsp;Tipo n&atilde;o adicionado.</span></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="2" align="right" background="/servicos/bbhive/images/separador.gif"></td>
                                </tr>
                                <tr>
                                  <td width="21%" height="22" align="right">T&iacute;tulo modelo:&nbsp;</td>
                                  <td width="79%" align="left"><input class="back_Campos" name="bbh_mod_flu_nome" type="text" id="bbh_mod_flu_nome" size="45" style="height:15px;" />
                                  <input type="hidden" name="bbh_tip_flu_codigo" id="bbh_tip_flu_codigo"></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="2" align="right" background="/servicos/bbhive/images/separador.gif"></td>
                                </tr>
                                <tr>
                                  <td height="22" align="right" bgcolor="#F4F5F9">Descri&ccedil;&atilde;o :&nbsp;</td>
                                  <td bgcolor="#F4F5F9">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="2" align="right" background="/servicos/bbhive/images/separador.gif"></td>
                                </tr>
                                <tr>
                                  <td height="30" colspan="2" align="center"><textarea class="back_Campos" name="bbh_mod_flu_observacao" id="bbh_mod_flu_observacao" cols="98" rows="7"></textarea></td>
                                </tr>
                                <tr>
                                  <td height="10" colspan="2"></td>
                                </tr>
                                <tr>
                                  <td height="1" colspan="2" align="right" background="/servicos/bbhive/images/separador.gif"></td>
                                </tr>
                                <tr>
                                  <td height="25" colspan="2" bgcolor="#F4F5F9" class="legandaLabel11">
                                    <input type="checkbox" name="bbh_mod_flu_sub" id="bbh_mod_flu_sub" style="margin-left:20px;" />
N&atilde;o &eacute; modelo principal ?</td>
                                </tr>
                              </table>
                            </fieldset></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="6" colspan="10" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;" class="legandaLabel11"><label>&nbsp;</label></td>
                    </tr>
                    <tr>
                      <td height="6" colspan="10" align="right" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;"><input name="button" type="button" class="back_input" id="button" value="Cancelar"  onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/index.php','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
                           <input name="insereModelo" type="button" class="back_input" id="insereModelo" value="Cadastrar modelo" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" disabled="disabled"  onclick="return validaForm('cadatraModelo', 'bbh_tip_flu_codigo|Escolha o tipo do modelo, bbh_mod_flu_nome|Descreva o nome deste modelo', document.getElementById('acaoForm').value)"/>&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="6" colspan="10" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="6" colspan="10" background="/e-solution/servicos/bbhive/images/rodape_tar.gif"></td>
                    </tr>
                  </table>
     <input type="hidden" name="MM_insert" value="cadastraMod" />
     <input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
</form>