<?php
if(!isset($_SESSION)){session_start();}

if ((isset($_POST["MM_criaTab"])) && ($_POST["MM_criaTab"] == "form1")) {
	require_once("../../includes/autentica.php");
	require_once("../../includes/functions.php");
	require_once("../../fluxos/modelosFluxos/detalhamento/includes/functions.php");
}
//--
	$idMensagemFinal= 'carregaTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestinoII	= '/e-solution/servicos/bbhive/configuracao/detalhamento/index.php';
	

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Alterando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_criaTab"])) && ($_POST["MM_criaTab"] == "form1")) {
	
	//Obtendo os campos do detlhamento:
	$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_protocolo";
    list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);
	
	$nome_tabela = "bbh_detalhamento_protocolo";
	
	//=================Iniciando a criação da tabela
			 $criaTabela = "CREATE TABLE `".$nome_tabela."` (
					  `bbh_det_pro_codigo` int(11) NOT NULL auto_increment, PRIMARY KEY  (`bbh_det_pro_codigo`)";

		do{					  
	  		$criaTabela .= "," . descobreValorDinamico($row_campos_detalhamento['bbh_cam_det_pro_nome'], $row_campos_detalhamento['bbh_cam_det_pro_tipo'],$row_campos_detalhamento['bbh_cam_det_pro_tamanho'],0,$row_campos_detalhamento['bbh_cam_det_pro_default']);
			
			}while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento));
		 $criaTabela .= " ,`bbh_pro_codigo` int(11) default NULL";
		 $criaTabela .=  ") COLLATE='latin1_swedish_ci' ENGINE=InnoDB ROW_FORMAT=DEFAULT;";

        list($resultado, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $criaTabela);
		 //--
		 
		 $criaIntegridade =  "ALTER TABLE `bbh_detalhamento_protocolo` ADD CONSTRAINT `fk_bbh_pro_codigo` FOREIGN KEY (`bbh_pro_codigo`) REFERENCES `bbh_protocolos` (`bbh_pro_codigo`) ON UPDATE NO ACTION";
        list($resultado, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $criaIntegridade);

	 	 echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php','menuEsquerda|colCentro')</var>";
	 exit;
	//=================Fim

}
$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_protocolo ORDER BY bbh_cam_det_pro_ordem";
list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);
//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
list($sqlColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr>
    <td>
    
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de detalhamento - <?php echo $_SESSION['adm_protNome']; ?> </td>
  </tr>
  <tr>
    <td height="8"></td>
  </tr>
</table>

<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<?php if($totalRows_campos_detalhamento>0){ ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" height="25px;" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0099FF;padding-bottom:10px;">
    <?php if($tabelaCriada == 0){ 
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td colspan="3" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td width="9%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td width="14%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">
    <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">
    <td colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">
   <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/detalhamento/novo.php','menuEsquerda|conteudoGeral');" style="color:#0099FF">
    <img src="/e-solution/servicos/bbhive/images/novo.gif" alt="Novo campo de detalhamento" border="0" align="absmiddle" /></a>
    </td>
  </tr>
  <tr class="legandaLabel11">
    <td width="5%" height="25" align="left" class="verdana_11_bold">Ordem</td>
    <td width="35%" align="left" class="verdana_11_bold">T&iacute;tulo</td>
    <td width="14%" class="verdana_11_bold">Tipo</td>
    <td width="7%" align="center" class="verdana_11_bold">Ativado</td>
    <td width="7%" align="center" class="verdana_11_bold">Vis&iacute;vel</td>
    <td align="center" class="verdana_11_bold">Tamanho</td>
    <td class="verdana_11_bold">Curinga</td>
    <td width="3%" align="center">&nbsp;</td>
    <td width="3%" align="center">&nbsp;</td>
    <td width="3%" align="center">&nbsp;</td>
    <td width="6%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="1" colspan="9" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <?PHP
  $anterior = 0;
  ?>
      <?php while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)) { ?>
      <tr class="legandaLabel11" bgcolor="<?php echo $row_campos_detalhamento['bbh_cam_det_pro_fixo']=="1"?"#FFFFE6":"#FFFFFF";?>">
        <td height="25" align="center" >&nbsp;<?php echo $t=$row_campos_detalhamento['bbh_cam_det_pro_ordem']; ?></td>
        <td height="25" align="left" >&nbsp;<?php echo $t=$row_campos_detalhamento['bbh_cam_det_pro_titulo']; ?></td>
        <td><?php echo $t=retornaTitulo($row_campos_detalhamento['bbh_cam_det_pro_tipo']); ?></td>
        <td align="center"><?php echo $a=$row_campos_detalhamento['bbh_cam_det_pro_disponivel'] ? 'Sim' : 'Não'; ?></td>
        <td align="center"><?php echo $a=$row_campos_detalhamento['bbh_cam_det_pro_visivel'] ? 'Sim' : 'Não'; ?></td>
        <td align="center">
          <?php 
		if(in_array($row_campos_detalhamento['bbh_cam_det_pro_tipo'], ['data','texto_longo','json']))
		{
			echo "-";	
		}else{
			echo $t=$row_campos_detalhamento['bbh_cam_det_pro_tamanho'];
		}
		?>        </td>
        <td><?php echo $c=$row_campos_detalhamento['bbh_cam_det_pro_curinga']; ?></td>
      
      
        <td align="center" valign="middle">
        <?PHP if( $anterior != 0 ){ ?>
        <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/detalhamento/editar.php?bbh_cam_det_pro_codigo=<?php echo $row_campos_detalhamento['bbh_cam_det_pro_codigo']; ?>&ordem=diminui','menuEsquerda|conteudoGeral');" style="color:#0099FF">
            <img src="/e-solution/servicos/bbhive/images/seta_cima.gif" width="20" height="17" border="0" />
        </a>
		<?PHP } $anterior++; ?>
        &nbsp;
        </td>
        <td align="center" valign="middle">
        <?PHP if( $anterior < $totalRows_campos_detalhamento ){ ?>
        <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/detalhamento/editar.php?bbh_cam_det_pro_codigo=<?php echo $row_campos_detalhamento['bbh_cam_det_pro_codigo']; ?>&ordem=soma','menuEsquerda|conteudoGeral');" style="color:#0099FF">
            <img src="/e-solution/servicos/bbhive/images/seta_baixo.gif" width="20" height="17" border="0" />
        </a>
		<?PHP }  ?>
        &nbsp;
		</td>
       
       
        <td align="center">
          <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/detalhamento/editar.php?bbh_cam_det_pro_codigo=<?php echo $row_campos_detalhamento['bbh_cam_det_pro_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
        <img src="/e-solution/servicos/bbhive/images/editar.gif" alt="Editar campo de detalhamento" border="0" align="absmiddle" />        </a>        </td>
        <td align="center">
         <?php if($cadastrado == false && $row_campos_detalhamento['bbh_cam_ind_fixo']=="0") { ?>
          <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/detalhamento/excluir.php?bbh_cam_det_pro_codigo=<?php echo $row_campos_detalhamento['bbh_cam_det_pro_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
        <img src="/e-solution/servicos/bbhive/images/<?php echo $imagem_exclusao; ?>" alt="<?php echo $alt; ?>" border="0" align="absmiddle" /></a> 
        <?php }else{ ?>
                <img src="/e-solution/servicos/bbhive/images/<?php echo $imagem_exclusao; ?>" alt="<?php echo $alt; ?>" border="0" align="absmiddle" />
        <?php } ?>
        </td>
  </tr>
          <tr>
	    	<td height="1" colspan="9" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
		  </tr>
 <?php } ?>

   <?php if ($totalRows_campos_detalhamento == 0) { // Show if recordset not empty ?>
  <tr class="legandaLabel11">
    <td height="25" colspan="9" align="left">&nbsp;&nbsp;<img src="/e-solution/servicos/bbhive/images/alerta.gif" width="13" height="11" align="absmiddle"> N&atilde;o existem campos de detalhamento criados. Caso deseja criar um novo, clique <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/detalhamento/novo.php','menuEsquerda|conteudoGeral');" style="color:#0099FF">aqui</a></td>
  </tr>
  <?php } ?>

 <tr class="legandaLabel11">
    <td height="22" colspan="9" align="center">&nbsp;</td>
  </tr>
  <tr class="legandaLabel11">
    <td height="5" colspan="9" align="center"></td>
  </tr>
</table>
</td>
</tr>
</table>
<?php
mysqli_free_result($campos_detalhamento);
?>
<br />
<form method="POST" action="" name="form1"><input type="hidden" name="MM_criaTab" value="form1" readonly /></form>