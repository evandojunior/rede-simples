<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/perfis/excluir.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'excluiPerfil';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
	$desabilita = "style='cursor:pointer'";
	
	$user = -1;
	if(isset($_GET['bbh_per_codigo'])){
		$user = $_GET['bbh_per_codigo'];
	}elseif(isset($_POST['bbh_per_codigo'])){
		$user = $_POST['bbh_per_codigo'];
	}

	$query_perfil = "SELECT * FROM bbh_perfil WHERE bbh_per_codigo = '$user'";
    list($perfil, $row_perfil, $totalRows_perfil) = executeQuery($bbhive, $database_bbhive, $query_perfil);
	
	//faz a primeira linha do erro
	$negacao = "A exclus&atilde;o n&atilde;o ser&aacute; poss&iacute;vel pelo(s) seguinte(s) motivo(s):<br />";

	//selects de validação
	$query_validusuario = "SELECT bbh_per_codigo FROM bbh_usuario_perfil WHERE bbh_per_codigo = '$user'";
    list($validusuario, $row_validusuario, $totalRows_validusuario) = executeQuery($bbhive, $database_bbhive, $query_validusuario);

	if($totalRows_validusuario>0){ $negacao .= "- O perfil tem usu&aacute;rios vinculados.<br />"; }

	$query_validnomeacao = "SELECT bbh_per_codigo FROM bbh_usuario_nomeacao WHERE bbh_per_codigo = '$user'";
    list($validnomeacao, $row_validnomeacao, $totalRows_validnomeacao) = executeQuery($bbhive, $database_bbhive, $query_validnomeacao);

	if($totalRows_validnomeacao>0){ $negacao .= "- O perfil possui nomea&ccedil;&otilde;es.<br />"; }

	$query_validatividade = "SELECT bbh_per_codigo FROM bbh_modelo_atividade WHERE bbh_per_codigo = '$user'";
    list($validatividade, $row_validatividade, $totalRows_validatividade) = executeQuery($bbhive, $database_bbhive, $query_validatividade);

	if($totalRows_validatividade>0){ $negacao .= "- O perfil est&aacute; vinculado &agrave; modelos de atividades.<br />"; }

	$query_validpermissao = "SELECT bbh_per_codigo FROM bbh_permissao_fluxo WHERE bbh_per_codigo = '$user'";
    list($validpermissao, $row_validpermissao, $totalRows_validpermissao) = executeQuery($bbhive, $database_bbhive, $query_validpermissao);

	if($totalRows_validpermissao>0){ $negacao .= "- O perfil est&aacute; vinculado &agrave; permiss&otilde;es de modelos de fluxos.<br />"; }
	
	//Se algum valor bater, exibe erro
	if($totalRows_validusuario>0 || $totalRows_validnomeacao>0 || $totalRows_validatividade>0 || $totalRows_validpermissao>0){

	 $Erro = "<span class='aviso' style='font-size:11;'>".$negacao."</span>";
     echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";	 
	 $desabilita  = "disabled='disabled'";

	}else{
	  if ((isset($_POST['bbh_per_codigo'])) && ($_POST['bbh_per_codigo'] != "")) {		
		$deleteSQL = "DELETE FROM bbh_perfil WHERE bbh_per_codigo = ".$_POST['bbh_per_codigo'];
		list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	    echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|perfis/index.php','menuEsquerda|conteudoGeral')</var>";
	    exit;
	  }
	}
	
//
// Lê as confirgurações
$xmlParse = simplexml_load_file( $_SESSION['caminhoFisico']."/../database/servicos/bbhive/nivel_informacao.xml" );
foreach( $xmlParse as $value ){ $values[ (int) $value['nivel'] ] = (string) $value['valor']; }
// Fim das configurações
//
	
?>
<form method="POST" name="excluiPerfil" id="excluiPerfil">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_perfNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-perfis-16px.gif" width="14" height="14" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_perfNome']; ?>
      <div style="float:right;"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|perfis/index.php','menuEsquerda|colCentro');"><span 


class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Exclus&atilde;o do perfis</span></td>
  </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="93%" id="erroDep">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="18%" align="right" class="color">Nome&nbsp;:</td>
        <td width="82%">&nbsp;
          <input disabled="disabled" name="bbh_per_nome" type="text" class="back_Campos" id="bbh_per_nome" value="<?php echo $row_perfil['bbh_per_nome']; ?>" size="45" maxlength="255">
          <input name="bbh_per_codigo" type="hidden" id="bbh_per_codigo" value="<?php echo $row_perfil['bbh_per_codigo']; ?>"></td>
      </tr>
      <tr>
        <td height="8" colspan="2" align="right" valign="top" class="color"></td>
        </tr>
      <tr>
        <td align="right" valign="top" class="color">Permiss&otilde;es : </td>
        <td><table class="verdana_9" style="margin-left:6px; border:#E1EDFF 1px solid;" width="450" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10">&nbsp;</td>
            <td width="197"><input disabled="disabled" name="bbh_per_fluxo" type="checkbox" id="bbh_per_fluxo" value="1" <?php if($row_perfil['bbh_per_fluxo']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" alt="" width="16" height="16" align="absmiddle" />&nbsp;<?php echo $_SESSION['adm_FluxoNome']; ?></td>
            <td width="169"><input disabled="disabled" name="bbh_per_tarefas" type="checkbox" id="bbh_per_tarefas" value="1" <?php if($row_perfil['bbh_per_tarefas']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/tarefa.gif" alt="" width="16" height="16" align="absmiddle" /> Tarefas</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input disabled="disabled" name="bbh_per_mensagem" type="checkbox" id="bbh_per_mensagem" value="1" <?php if($row_perfil['bbh_per_mensagem']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/ger-mensagens-16px.gif" alt="" width="16" height="16" align="absmiddle" />&nbsp;<?php echo $_SESSION['adm_MsgNome']; ?></td>
            <td><input disabled="disabled" name="bbh_per_relatorios" type="checkbox" id="bbh_per_relatorios" value="1" <?php if($row_perfil['bbh_per_relatorios']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/relatorio.gif" alt="" width="16" height="16" align="absmiddle" /> Relat&oacute;rios</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input disabled="disabled" name="bbh_per_arquivos" type="checkbox" id="bbh_per_arquivos" value="1" <?php if($row_perfil['bbh_per_arquivos']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/arquivos16px.gif" alt="" width="16" height="16" align="absmiddle" /> GED</td>
            <td><input disabled="disabled" name="bbh_per_protocolos" type="checkbox" id="bbh_per_protocolos" value="1" <?php if($row_perfil['bbh_per_protocolos']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/ger-protocolos-16px.gif" alt="" width="16" height="16" align="absmiddle" /><?php echo $_SESSION['adm_protNome']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input disabled="disabled" name="bbh_per_equipe" type="checkbox" id="bbh_per_equipe" value="1" <?php if($row_perfil['bbh_per_equipe']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/ger-usuarios-16px.gif" alt="" width="16" height="16" align="absmiddle" /> Equipe</td>
            <td><input name="bbh_per_central_indicios" type="checkbox" id="bbh_per_central_indicios" value="1" <?php if($row_perfil['bbh_per_central_indicios']>0){echo "checked";} ?> disabled="disabled" />
            <img src="/e-solution/servicos/bbhive/images/central_indicios.gif" alt="" width="16" height="16" align="absmiddle" />
            Central de informa&ccedil;&otilde;es</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input disabled="disabled" name="bbh_per_corp" type="checkbox" id="bbh_per_corp" value="1"  <?php if($row_perfil['bbh_per_corp']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/cadeado_off.gif" alt="" width="16" height="16" align="absmiddle" /> Sem acesso corporativo</td>
            <td><input disabled="disabled" name="bbh_per_pub" type="checkbox" id="bbh_per_pub" value="1"  <?php if($row_perfil['bbh_per_pub']>0){echo "checked";} ?> />
              <img src="/e-solution/servicos/bbhive/images/cadeado_off.gif" alt="" width="16" height="16" align="absmiddle" /> Sem acesso publico</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input name="bbh_per_peoplerank" type="checkbox" id="bbh_per_peoplerank" value="1"  <?php if($row_perfil['bbh_per_peoplerank']>0){echo "checked";} ?> disabled="disabled" />
              <img src="/e-solution/servicos/bbhive/images/peoplerank.gif" alt="" width="16" height="16" align="absmiddle" /> Peoplerank</td>
            <td><input name="bbh_per_bi" type="checkbox" id="bbh_per_bi" value="1"  <?php if($row_perfil['bbh_per_bi']>0){echo "checked";} ?> disabled="disabled" />
              <img src="/e-solution/servicos/bbhive/images/bi.gif" alt="" width="16" height="16" align="absmiddle" /> BI</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input name="bbh_per_geo" type="checkbox" id="bbh_per_geo" value="1"  <?php if($row_perfil['bbh_per_geo']>0){echo "checked";} ?> disabled="disabled" />
              <img src="/e-solution/servicos/bbhive/images/geoprocessamento.gif" alt="" width="16" height="16" align="absmiddle" /> GEO</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="8" colspan="2" align="right" valign="top" class="color"></td>
        </tr>
              <tr>
        <td align="right" valign="top" class="color">Permiss&otilde;es na Matriz&nbsp;:</td>
        <td>&nbsp;
        	<select name="bbh_per_matriz"  id="bbh_per_matriz" class="back_Campos" style="width:200px" disabled="disabled">
            <?PHP //
			reset( $values );
							
			//
			foreach( $values as $indice => $value )
			{
				$select = ($indice==$row_perfil['bbh_per_matriz'])?' selected':'';
				echo sprintf( "<option value='%s'%s>%s</option>", $indice, $select, $value);
			}
			?>
            </select>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Permiss&otilde;es na Unidade&nbsp;:</td>
        <td>&nbsp;
        	<select name="bbh_per_unidade" id="bbh_per_unidade" class="back_Campos" style="width:200px" disabled="disabled">
			<?PHP //
			reset( $values );
							
			//
			foreach( $values as $indice => $value )
			{
				$select = ($indice==$row_perfil['bbh_per_unidade'])?' selected':'';
				echo sprintf( "<option value='%s'%s>%s</option>", $indice, $select, $value);
			}
			?>
            </select>
        </td>
      </tr>

      <tr>
        <td align="right" valign="top" class="color">Descri&ccedil;&atilde;o&nbsp;:</td>
        <td >&nbsp;<textarea disabled="disabled" class="formulario2" name="bbh_per_observacao" id="bbh_per_observacao" cols="44" rows="7"><?php if(isset($_POST['bbh_per_observacao'])){ echo $_POST['bbh_per_observacao']; }else{echo $row_perfil['bbh_per_observacao'];}?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;
              <input type="button" name="button2" id="button2" value="Cancelar" class="button" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|perfis/index.php','menuEsquerda|colCentro');">
            <input <?php echo $desabilita; ?> type="button" name="button" id="button" value="Excluir" class="button" onclick="return validaForm('excluiPerfil', 'bbh_per_nome|Preencha o nome do perfil', document.getElementById('acaoForm').value)"> <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>