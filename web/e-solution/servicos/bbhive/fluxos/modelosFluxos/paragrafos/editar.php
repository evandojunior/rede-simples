<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/editar.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'editaTit';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
		
	if ((isset($_POST["MM_update"]))) {
		//verifica se tem um com o mesmo titulo e nome no mesmo modelo de atividade
		$bbh_mod_par_nome 		= apostrofo($_POST['bbh_mod_par_nome']);
		$bbh_mod_par_titulo 	= apostrofo($_POST['bbh_mod_par_titulo']);
		$bbh_mod_flu_codigo 	= $_POST['bbh_mod_flu_codigo'];
		$bbh_mod_par_paragrafo	= retiraHTML(retiraTagHTML(apostrofo($_POST['editor1'])));//
		$bbh_mod_par_codigo		= $_POST['bbh_mod_par_codigo'];
	
		if(empty($bbh_mod_par_titulo) || empty($bbh_mod_par_nome)){
			echo '<script type="text/javascript">alert(\'Informe o título e o nome deste parágrafo.\');</script>';
		  exit;
		}
		//--	

		$query_validacao = "SELECT * FROM bbh_modelo_paragrafo WHERE (bbh_mod_par_nome = '$bbh_mod_par_nome' OR bbh_mod_par_titulo = '$bbh_mod_par_titulo') AND bbh_mod_par_codigo != $bbh_mod_par_codigo AND bbh_mod_flu_codigo = $bbh_mod_flu_codigo";
        list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	  $updateSQL = "UPDATE bbh_modelo_paragrafo SET bbh_mod_par_nome = '$bbh_mod_par_nome', bbh_mod_par_titulo = '$bbh_mod_par_titulo', bbh_mod_par_paragrafo = '$bbh_mod_par_paragrafo' WHERE bbh_mod_par_codigo = $bbh_mod_par_codigo";
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

	  // ?>
<script type="text/javascript">
		window.top.window.LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/paragrafos/index.php?bbh_mod_flu_codigo=<?php echo $_POST['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral')
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
}else{
	
	$codPar = -1;
	if(isset($_GET['bbh_mod_par_codigo'])){
		$codPar = $_GET['bbh_mod_par_codigo'];
	}

	$query_modFluxos = "select count(bbh_mod_ati_codigo) as total FROM bbh_modelo_atividade Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
	list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);

	$query_paragrafos = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = $codPar";
	list($paragrafos, $row_paragrafos, $totalRows_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_paragrafos);

	$query_administrador = "SELECT bbh_adm_nome FROM bbh_modelo_paragrafo
INNER JOIN bbh_administrativo ON bbh_administrativo.bbh_adm_codigo = bbh_modelo_paragrafo.bbh_adm_codigo WHERE bbh_mod_par_codigo = $codPar";
	list($administrador, $row_administrador, $totalRows_administrador) = executeQuery($bbhive, $database_bbhive, $query_administrador);

	$query_usuautor = "SELECT bbh_usu_nome FROM bbh_modelo_paragrafo INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_modelo_paragrafo.bbh_usu_autor WHERE bbh_mod_par_codigo = $codPar";
	list($usuautor, $row_usuautor, $totalRows_usuautor) = executeQuery($bbhive, $database_bbhive, $query_usuautor);
}

	$_SESSION['textoEdito'] 	= $row_paragrafos['bbh_mod_par_paragrafo'];
	$_SESSION['textoParNome']	= $row_paragrafos['bbh_mod_par_nome'];
	$_SESSION['textoParTitulo']	= $row_paragrafos['bbh_mod_par_titulo'];
	$_SESSION['textoParmomento']= arrumadata(substr($row_paragrafos['bbh_mod_par_momento'],0,10));
	$_SESSION['textoMonGrava']	= "";
	$_SESSION['textoParAutor']	= $row_administrador['bbh_adm_nome'];
?>
<var style="display:none">txtSimples('tagPerfil', 'Modelos de par&aacute;grafos')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de textos pr&eacute;-definidos</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/paragrafos/index.php?bbh_mod_flu_codigo=<?php if(!isset($_POST['bbh_mod_flu_codigo'])){echo $_GET['bbh_mod_flu_codigo']; }else{ echo $_POST['bbh_mod_flu_codigo']; } ?>','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../modelosAtividades/cabecaModelo.php'); ?>
<form id="editaTit" name="editaTit" method="post" style="width:600px;">
<?php require_once("curingas.php"); ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10" style="border:1px outset #999999; margin-top:6px">
  <tr>
    <td width="655" height="24" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><strong>&nbsp;Edi&ccedil;&atilde;o de textos pr&eacute;-definidos</strong></td>
    </tr>
    <tr>
      <td height="530" id="erroTit6"><iframe src="/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/editorTexto.php?bbh_mod_flu_codigo=<?php if(!isset($_POST['bbh_mod_flu_codigo'])){echo $_GET['bbh_mod_flu_codigo']; }else{ echo $_POST['bbh_mod_flu_codigo']; } ?>&arquivo=editar&acao=MM_update&bbh_adm_codigo=0&bbh_mod_par_codigo=<?php echo $row_paragrafos['bbh_mod_par_codigo']; ?>" name="editor" id="editor" width="100%" height="100%" allowtransparency="1" frameborder="0" /></td>
    </tr>
</table>
</form>