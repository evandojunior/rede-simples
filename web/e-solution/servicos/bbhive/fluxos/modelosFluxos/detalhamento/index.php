<?php require_once('../../../../../../Connections/bbhive.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php
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
	$homeDestinoII	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/detalhamento/index.php';
	
    //ALTER TABLE projeto01.bbh_campo_detalhamento_fluxo ADD bbh_cam_det_flu_obrigatorio char(1) DEFAULT '1' NOT NULL;

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Alterando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

	$codigo_modelo_fluxo = $_POST['bbh_mod_flu_codigo'];

	//Obtendo os campos do detlhamento:
	$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo 
	INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = 
	bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo 
	WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo";
    list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);
	
	$nome_tabela = "bbh_modelo_fluxo_".$codigo_modelo_fluxo."_detalhado";
	
	//=================Iniciando a criação da tabela
			 $criaTabela = "CREATE TABLE `".$nome_tabela."` (
					  `bbh_mod_flu_".$codigo_modelo_fluxo."_det_codigo_pk` int(11) NOT NULL auto_increment";

		do{					  
	  		$criaTabela .= "," . descobreValorDinamico($row_campos_detalhamento['bbh_cam_det_flu_nome'], $row_campos_detalhamento['bbh_cam_det_flu_tipo'],$row_campos_detalhamento['bbh_cam_det_flu_tamanho'],0,$row_campos_detalhamento['bbh_cam_det_flu_default']);
			
			}while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento));
		 $criaTabela .= " ,`bbh_flu_codigo` int(11) default NULL";
		 $criaTabela .= ", PRIMARY KEY  (`bbh_mod_flu_".$codigo_modelo_fluxo."_det_codigo_pk`)";
		 $criaTabela .=  ") ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;";

        list($resultado, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $criaTabela);
		 
		 $criaIntegridade =  "ALTER TABLE `".$nome_tabela."`
  ADD FOREIGN KEY (`bbh_flu_codigo`) REFERENCES `bbh_fluxo` (`bbh_flu_codigo`) ON UPDATE NO ACTION;";
        list($resultado, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $criaIntegridade);
		 
		 //**Update, pois a tabela já foi criada:
		   $updateSQL = sprintf("UPDATE bbh_detalhamento_fluxo SET bbh_det_flu_tabela_criada=%s WHERE bbh_det_flu_codigo=%s",
                       GetSQLValueString($bbhive, 1, "int"),
                       GetSQLValueString($bbhive, $_POST['bbh_det_flu_codigo'], "int"));
        list($resultado, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	 	 echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/detalhamento/index.php?bbh_mod_flu_codigo=".$_POST['bbh_mod_flu_codigo']."','menuEsquerda|conteudoGeral')</var>";

	 exit;

	//=================Fim

}

$codigo_modelo_fluxo = $_GET['bbh_mod_flu_codigo'];

$query_detalhamento = sprintf("SELECT * FROM bbh_detalhamento_fluxo WHERE bbh_mod_flu_codigo = %s", GetSQLValueString($bbhive, $codigo_modelo_fluxo, "int"));
list($detalhamento, $row_detalhamento, $totalRows_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_detalhamento);

$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo 
INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = 
bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo 
WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo";
list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);
?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastro de modelos de  <?php echo $_SESSION['adm_FluxoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de detalhamento de  <?php echo $_SESSION['adm_FluxoNome']; ?></td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/index.php','menuEsquerda|colCentro');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>

<?php require_once('../modelosAtividades/cabecaModelo.php'); ?>
<br />
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<?php if ($totalRows_campos_detalhamento > 0) { // Show if recordset not empty ?>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" height="25px;" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0099FF;padding-bottom:10px;">
    <?php if($row_detalhamento['bbh_det_flu_tabela_criada'] == 0){ 
		 $imagem_exclusao = "excluir.gif";
		 $alt = "Excluir campo";
		 $cadastrado = false;
	?>
      <input name="cadastrar" style="background:url(/e-solution/servicos/bbhive/images/disk.gif);background-repeat:no-repeat;background-position:left;height:23px;width:180px;margin-right:5px;" type="button" class="back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cadastrar definitivamente" onclick="if(confirm('Tem certeza que deseja cadastrar esta tabela com estes campos? Este procedimento não poderá ser desfeito.')){<?php echo $acao; ?>}"/>
    <?php }else{
			$imagem_exclusao = "excluir-negado.gif";
			 $alt = "Os campos n&atilde;o podem ser exclu&iacute;dos";
	 		 $cadastrado = true;
			echo "Os campos j&aacute; foram cadastrados definitivamente, portanto n&atilde;o podem ser exclu&iacute;dos.";
		  }
	 ?>
  
    </td>
  </tr>
</table>
<?php } ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  
  <tr class="legandaLabel11">
    <td width="24%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td width="12%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td width="12%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td width="27%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">
     <?php if ($totalRows_campos_detalhamento > 0) { // Show if recordset not empty ?>
   <a href="#" onclick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/detalhamento/novo.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
    <img src="/e-solution/servicos/bbhive/images/novo.gif" alt="Novo campo de detalhamento" border="0" align="absmiddle" /></a>
    <?php }?>    </td>
  </tr>
   <?php if ($totalRows_campos_detalhamento > 0) { // Show if recordset not empty ?>
   
  <tr class="legandaLabel11">
    <td height="25" align="left" class="verdana_11_bold">T&iacute;tulo</td>
    <td width="19%" class="verdana_11_bold">Tipo</td>
    <td width="9%" class="verdana_11_bold">Ativado</td>
    <td width="9%" class="verdana_11_bold">Obrigatório</td>
    <td align="center" class="verdana_11_bold">Tamanho</td>
    <td class="verdana_11_bold">Curinga</td>
    <td width="3%" align="center">&nbsp;</td>
    <td width="6%" align="center">&nbsp;</td>
  </tr>
  <?php } ?>
  
    <?php if ($totalRows_campos_detalhamento > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <tr class="legandaLabel11">
        <td height="25" align="left" >&nbsp;<?php echo $t=$row_campos_detalhamento['bbh_cam_det_flu_titulo']; ?></td>
        <td><?php echo $t=retornaTitulo($row_campos_detalhamento['bbh_cam_det_flu_tipo']); ?></td>
        <td align="center"><?php echo $a=$row_campos_detalhamento['bbh_cam_det_flu_disponivel'] ? 'Sim' : 'Não'; ?></td>
        <td align="center"><?php echo $row_campos_detalhamento['bbh_cam_det_flu_obrigatorio'] ? 'Sim' : 'Não'; ?></td>
        <td align="center">
        <?php 
		if(in_array($row_campos_detalhamento['bbh_cam_det_flu_tipo'], ['data','texto_longo','json']))
		{
			echo "-";	
		}else{
			echo $t=$row_campos_detalhamento['bbh_cam_det_flu_tamanho'];
		}
		?>        </td>
        <td><?php echo $c=$row_campos_detalhamento['bbh_cam_det_flu_curinga']; ?></td>
        <td align="center">
          <a href="#" onclick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/detalhamento/editar.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_cam_det_flu_codigo=<?php echo $row_campos_detalhamento['bbh_cam_det_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
        <img src="/e-solution/servicos/bbhive/images/editar.gif" alt="Editar campo de detalhamento" border="0" align="absmiddle" />        </a>        </td>
        <td align="center">
         <?php if($cadastrado == false) { ?>
          <a href="#" onclick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/detalhamento/excluir.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_cam_det_flu_codigo=<?php echo $row_campos_detalhamento['bbh_cam_det_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
        <img src="/e-solution/servicos/bbhive/images/<?php echo $imagem_exclusao; ?>" alt="<?php echo $alt; ?>" border="0" align="absmiddle" /></a> 
        <?php }else{ ?>
                <img src="/e-solution/servicos/bbhive/images/<?php echo $imagem_exclusao; ?>" alt="<?php echo $alt; ?>" border="0" align="absmiddle" />
        <?php } ?>
               </td>
        </tr>
          <tr>
	    	<td height="1" colspan="8" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
		  </tr>
        <?php } while ($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)); ?>
      <?php } // Show if recordset not empty ?>

   <?php if ($totalRows_campos_detalhamento == 0) { // Show if recordset not empty ?>
  <tr class="legandaLabel11">
    <td height="25" colspan="7" align="left">&nbsp;&nbsp;<img src="/e-solution/servicos/bbhive/images/alerta.gif" width="13" height="11" align="absmiddle"> N&atilde;o existem campos de detalhamento criados. Caso deseja criar um novo, clique <a href="#" onclick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/detalhamento/novo.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">aqui</a></td>
  </tr>
<?php } ?>

 <tr class="legandaLabel11">
    <td height="22" colspan="7" align="center">&nbsp;</td>
  </tr>
  <tr class="legandaLabel11">
    <td height="5" colspan="7" align="center"></td>
  </tr>
</table>
<?php
mysqli_free_result($campos_detalhamento);
?>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
	<input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
    <input name="bbh_mod_flu_codigo" type="hidden" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>" />
     <input name="bbh_det_flu_codigo" type="hidden" value="<?php echo $row_detalhamento['bbh_det_flu_codigo']; ?>" />
     <input type="hidden" name="MM_insert" value="form1" />
    
</form>
