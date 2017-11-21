<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/novo.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'cadastraTit';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";

	$query_administrador = "SELECT bbh_adm_codigo, bbh_adm_nome FROM bbh_administrativo WHERE bbh_adm_codigo = '".$_SESSION['es_usuCod']."'";
    list($administrador, $row_administrador, $totalRows_administrador) = executeQuery($bbhive, $database_bbhive, $query_administrador);
	
	if ((isset($_POST["MM_insert"]))) {
		
		//verifica se tem um com o mesmo titulo e nome no mesmo modelo de atividade
		$bbh_mod_par_nome 		= apostrofo($_POST['bbh_mod_par_nome']);
		$bbh_mod_par_titulo 	= apostrofo($_POST['bbh_mod_par_titulo']);
		$bbh_mod_flu_codigo 	= $_POST['bbh_mod_flu_codigo'];
		$bbh_mod_par_momento	= $_POST['bbh_mod_par_momento'];
		$bbh_mod_par_paragrafo	= retiraHTML(retiraTagHTML(apostrofo($_POST['editor1'])));//
	
		if(empty($bbh_mod_par_titulo) || empty($bbh_mod_par_nome)){
			echo '<script type="text/javascript">alert(\'Informe o título e o nome deste parágrafo.\');</script>';
		  exit;
		}
		//--
		$query_validacao = "SELECT * FROM bbh_modelo_paragrafo WHERE (bbh_mod_par_nome = '$bbh_mod_par_nome' OR bbh_mod_par_titulo = '$bbh_mod_par_titulo') AND bbh_mod_flu_codigo = $bbh_mod_flu_codigo";
        list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	  $insertSQL = "INSERT INTO bbh_modelo_paragrafo (bbh_adm_codigo, bbh_mod_par_nome, bbh_mod_par_titulo, bbh_mod_par_paragrafo, bbh_mod_par_momento, bbh_mod_flu_codigo) VALUES (".$_POST['bbh_adm_codigo'].",'".$bbh_mod_par_nome."', '".$bbh_mod_par_titulo."', '".$bbh_mod_par_paragrafo."', '".$bbh_mod_par_momento."', ".$bbh_mod_flu_codigo.")";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
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
}else{
	$query_modFluxos = "select count(bbh_mod_ati_codigo) as total FROM bbh_modelo_atividade Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
	list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);
}

	$_SESSION['textoEdito'] 	= "";
	$_SESSION['textoParNome']	= "";
	$_SESSION['textoParTitulo']	= "";
	$_SESSION['textoParmomento']= date('d/m/Y H:i:s');
	$_SESSION['textoMonGrava']	= date('Y-m-d H:i:s');
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
<form id="cadastraTit" name="cadastraTit" method="post">
<?php require_once("curingas.php"); ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10" style="border:1px outset #999999; margin-top:6px">
  <tr>
    <td width="593" height="24" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><strong>&nbsp;Cadastro de textos pr&eacute;-definidos</strong></td>
    </tr>
    <tr>
      <td height="530" id="erroTit">
<iframe src="/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/editorTexto.php?bbh_mod_flu_codigo=<?php if(!isset($_POST['bbh_mod_flu_codigo'])){echo $_GET['bbh_mod_flu_codigo']; }else{ echo $_POST['bbh_mod_flu_codigo']; } ?>&arquivo=novo&acao=MM_insert&bbh_adm_codigo=<?php echo $row_administrador['bbh_adm_codigo']; ?>" name="editor" id="editor" width="100%" height="100%" allowtransparency="1" frameborder="0" />
      </td>
  </tr>
  </table>
</form>