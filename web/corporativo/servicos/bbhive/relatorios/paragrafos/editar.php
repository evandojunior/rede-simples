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
	$homeDestino	= '/corporativo/servicos/bbhive/relatorios/paragrafos/editar.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','formPar','Atualizando dados...','cadastraModelo','1','".$TpMens."');";
	
if(isset($_POST['insertPar'])){//insere parágrafo
	//verifica se tem um com o mesmo titulo e nome no mesmo modelo de atividade
	$bbh_mod_par_nome 		= apostrofo($_POST['bbh_mod_par_nome']);
	$bbh_mod_par_titulo 	= apostrofo($_POST['bbh_mod_par_titulo']);
	$bbh_mod_flu_codigo 	= $_POST['bbh_mod_flu_codigo'];
	$bbh_tip_flu_codigo		= $_POST['bbh_tip_flu_codigo'];
	$bbh_mod_par_paragrafo	= retiraHTML(retiraTagHTML(apostrofo($_POST['editor1'])));//
	$bbh_mod_par_codigo		= $_POST['bbh_mod_par_codigo'];

	if(empty($bbh_mod_par_titulo) || empty($bbh_mod_par_nome)){
		echo '<script type="text/javascript">alert(\'Informe o título e o nome deste parágrafo.\');</script>';
	  exit;
	}
	//--	

	$query_validacao = "SELECT * FROM bbh_modelo_paragrafo WHERE (bbh_mod_par_nome = '$bbh_mod_par_nome' OR bbh_mod_par_titulo = '$bbh_mod_par_titulo') AND bbh_mod_par_codigo != $bbh_mod_par_codigo AND bbh_mod_flu_codigo = $bbh_mod_flu_codigo";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);
	
	//edito fluxo
	if($totalRows_validacao==0){
	 $updateSQL = "UPDATE bbh_modelo_paragrafo SET bbh_mod_par_nome = '$bbh_mod_par_nome', bbh_mod_par_titulo = '$bbh_mod_par_titulo', bbh_mod_par_paragrafo = '$bbh_mod_par_paragrafo' WHERE bbh_mod_par_codigo = $bbh_mod_par_codigo";
	 list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	  // ?>
<script type="text/javascript">
		window.top.window.LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra3.php?bbh_tip_flu_codigo=<?php echo $bbh_tip_flu_codigo; ?>&bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>','menuEsquerda|colPrincipal')
</script>
      <?php
	  exit;
	} else {
		?>
	<script type="text/javascript">alert('Já existe um registro com este Nome ou Título nesse modelo.');</script>
        <?php
		exit;
	}
	//--
	exit;
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

	$query_paragrafos = "SELECT bbh_modelo_paragrafo.*, bbh_usu_nome FROM bbh_modelo_paragrafo
							 left join bbh_usuario on bbh_modelo_paragrafo.bbh_usu_autor = bbh_usuario.bbh_usu_codigo
							 	WHERE bbh_mod_par_codigo = ".$_GET['bbh_mod_par_codigo'];
    list($paragrafos, $row_paragrafos, $totalRows_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_paragrafos);
	
	$_SESSION['textoEdito'] 	= $row_paragrafos['bbh_mod_par_paragrafo'];
	$_SESSION['textoParNome']	= $row_paragrafos['bbh_mod_par_nome'];
	$_SESSION['textoParTitulo']	= $row_paragrafos['bbh_mod_par_titulo'];
	$_SESSION['textoParmomento']= arrumadata(substr($row_paragrafos['bbh_mod_par_momento'],0,10));
	$_SESSION['textoMonGrava']	= "";
	$_SESSION['textoParAutor']	= $row_paragrafos['bbh_usu_nome'];
?><var style="display:none">txtSimples('tagPerfil', 'Edi&ccedil;&atilde;o de par&aacute;grafos')</var><form name="formPar" id="formPar" style="width:600px;">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11" style="margin-top:-10px;">
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Edi&ccedil;&atilde;o de par&aacute;grafos</strong></span>
      <label style="float:right; ">
     <a href="#"  onClick="return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra3.php?bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?>&bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|colPrincipal');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="verdana_11">&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
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

<?php require_once("../painel/includes/curingas.php"); ?>
<table align="center" width="600" height="30px" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">    
<tr>
  <td width="600" height="490" align="left" valign="middle" class="verdana_12"><iframe src="/corporativo/servicos/bbhive/relatorios/paragrafos/editorTexto.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?>&arquivo=editar&acao=insertPar&bbh_mod_par_codigo=<?php echo $row_paragrafos['bbh_mod_par_codigo']; ?>" name="editor" id="editor" width="100%" height="100%" allowtransparency="1" frameborder="0" /></td>
</tr>
</table>
        </form>
