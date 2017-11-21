<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");



	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '1';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/corporativo/servicos/bbhive/relatorios/paragrafos/excluir.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','formPar','Excluindo dados...','cadastraModelo','1','".$TpMens."');";
	
if(isset($_POST['insertPar'])){//insere parágrafo
	//verifica se tem um com o mesmo titulo e nome no mesmo modelo de atividade
	$novoflucod = $_POST['bbh_mod_flu_codigo'];
	$tpFluxo	= $_POST['bbh_tip_flu_codigo'];

	$deleteSQL = "DELETE FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = ".$_POST['bbh_mod_par_codigo'];
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	 
	 echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra3.php?bbh_tip_flu_codigo=".$tpFluxo."&bbh_mod_flu_codigo=".$novoflucod."','menuEsquerda|colPrincipal');</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
}

	$query_Fluxos = "select 
		bbh_modelo_fluxo.*, bbh_per_nome, bbh_usu_codigo, bbh_tip_flu_identificacao, bbh_tip_flu_nome
		
		from bbh_modelo_fluxo
		#Tipo de fluxo
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		
		#Modelo Fluxo com permissão fluxo
		inner join bbh_permissao_fluxo on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_permissao_fluxo.bbh_mod_flu_codigo
		
		#Permissão Fluxo com perfil
		inner join bbh_perfil on bbh_permissao_fluxo.bbh_per_codigo = bbh_perfil.bbh_per_codigo
		
		#Perfil com Usuário Perfil
		inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
		
		Where bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_modelo_fluxo.bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo']."
		
		order by bbh_mod_flu_nome asc";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);

	$query_paragrafos = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = ".$_GET['bbh_mod_par_codigo'];
    list($paragrafos, $row_paragrafos, $totalRows_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_paragrafos);
?>
<var style="display:none">txtSimples('tagPerfil', 'Exclus&atilde;o de par&aacute;grafos')</var><form name="formPar" id="formPar"><table width="101%" border="0" cellspacing="0" cellpadding="0" class="verdana_11" style="margin-top:-10px;">
  <tr>
    <td width="98%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Exclus&atilde;o de par&aacute;grafos</strong></span>
      <label style="float:right; ">
     <a href="#@"  onClick="return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra3.php?bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?>&bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|colPrincipal');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="verdana_11">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td width="16%" height="18" align="right" class="color"><strong>C&oacute;d. tipo :&nbsp;</strong></td>
    <td width="84%">&nbsp;<?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao']); ?></td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Tipo :&nbsp;</strong></td>
    <td>&nbsp;<?php echo $row_Fluxos['bbh_tip_flu_nome']; ?></td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Modelo :&nbsp;</strong></td>
    <td>&nbsp;<?php echo $row_Fluxos['bbh_mod_flu_nome']; ?><input type="hidden" name="bbh_flu_data_iniciado" id="bbh_flu_data_iniciado" value="<?php echo date("Y-m-d");?>" /></td>
  </tr>
</table>


<table align="center" width="98%" height="30px" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">    
<tr>
  <td height="15" colspan="10" align="left" valign="middle" class="verdana_12" id="cadastraModelo">&nbsp;</td>
</tr>
<tr>
  <td height="25" colspan="10" align="left" valign="middle" class="verdana_12">Nome do par&aacute;grafo: <input class="back_Campos" name="bbh_mod_par_nome" type="text" id="bbh_mod_par_nome"  value="<?php echo $row_paragrafos['bbh_mod_par_nome']; ?>" size="60" style="height:17px;border:#E3D6A4 solid 1px;" disabled="disabled"/></td>
  </tr>
<tr>
  <td height="25" colspan="10" align="left" valign="middle" class="verdana_12">T&iacute;tulo do par&aacute;grafo: <input class="back_Campos" name="bbh_mod_par_titulo" type="text" id="bbh_mod_par_titulo" size="60" style="height:17px;border:#E3D6A4 solid 1px; margin-left:2px;" value="<?php echo $row_paragrafos['bbh_mod_par_titulo']; ?>" disabled="disabled"/></td>
  </tr>
<tr>
  <td height="25" colspan="10" align="left" valign="middle" class="verdana_12">Autor do par&aacute;grafo: <strong><?php echo $_SESSION['usuNome']; ?></strong></td>
</tr>
<tr>
  <td height="25" colspan="10" align="left" valign="middle" class="verdana_12">Descri&ccedil;&atilde;o do par&aacute;grafo</td>
</tr>
    <tr>
      <td height="5" colspan="10" align="left"></td>
    </tr>
    <tr>
      <td colspan="10" align="left">
      <?php echo nl2br($row_paragrafos['bbh_mod_par_paragrafo']); ?>
      </td>
    </tr>
    <tr>
    <td height="5" colspan="10" align="left"> </td>
    </tr>
    <tr>
      <td colspan="10" align="right">
      <input type="button" value="Cancelar" style="cursor:pointer;" class="back_input" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra3.php?bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?>&bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|colPrincipal');"/>
      <input type="button" value="Excluir par&aacute;grafo" onclick="javascript: if(confirm('Tem certeza que deseja excluir este modelo?\n         Clique em Ok para confirmar.')){ <?php echo $acao; ?> }" style="cursor:pointer;" class="back_input"/>
&nbsp;</td>
    </tr>
</table>
  <input name="bbh_mod_par_privado" id="bbh_mod_par_privado" type="hidden" value="1" />
	<input name="bbh_mod_par_codigo" type="hidden" id="bbh_mod_par_codigo" value="<?php echo $row_paragrafos['bbh_mod_par_codigo']; ?>">
  <input name="insertPar" id="insertPar" type="hidden" value="1" />
  <input name="bbh_tip_flu_codigo" id="bbh_tip_flu_codigo" type="hidden" value="<?php echo $_GET['bbh_tip_flu_codigo']; ?>" />
  <input name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" type="hidden" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>" />
  <input name="bbh_usu_autor" id="bbh_usu_autor" type="hidden" value="<?php echo $_SESSION['usuCod']; ?>" />
</form>