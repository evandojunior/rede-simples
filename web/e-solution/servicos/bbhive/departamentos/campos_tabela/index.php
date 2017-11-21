<?php
if(!isset($_SESSION)){session_start();}
//--
/*require_once("../../includes/autentica.php");
require_once("../../includes/functions.php");
require_once("../../fluxos/modelosFluxos/detalhamento/includes/functions.php");*/

//--
	$idMensagemFinal= 'carregaTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestinoII	= '/e-solution/servicos/bbhive/departamentos/campos_tabela/index.php';
	

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Alterando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$query_campos_detalhamento = "SELECT * FROM bbh_campo_indicio ORDER BY bbh_cam_ind_ordem";
list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_indicio'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

 $imagem_exclusao = "excluir.gif";
 $alt = "Excluir campo";
 $cadastrado = false;
 //--
 if($tabelaCriada==1){
	$imagem_exclusao = "excluir-negado.gif";
	$alt = "Os campos n&atilde;o podem ser exclu&iacute;dos";
	$cadastrado = true;
 }
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="90%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de campos - <?php echo $_SESSION['adm_componentesNome']; ?></td>
    <td width="10%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold">&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
</table>

<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  
  <tr class="legandaLabel11">
    <td width="7%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Ordem</strong></td>
    <td width="37%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>T&iacute;tulo</strong></td>
    <td width="12%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Tipo</strong></td>
    <td width="8%" align="center" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Ativado</strong></td>
    <td width="12%" align="center" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Tamanho</strong></td>
    <td width="15%" align="left" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Curinga</strong></td>
    <td colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center"></td>
    <td colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">
   <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_tabela/novo.php','menuEsquerda|conteudoGeral');" style="color:#0099FF">
    <img src="/e-solution/servicos/bbhive/images/novo.gif" alt="Novo campo de detalhamento" border="0" align="absmiddle" /></a>
    </td>
  </tr>
  <?PHP
  $anterior = 0;
  ?>
  <?php while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)) { ?>
      <tr class="legandaLabel11" bgcolor="<?php echo $row_campos_detalhamento['bbh_cam_ind_fixo']=="1"?"#FFFFE6":"#FFFFFF";?>">
        <td height="25" align="center" ><?php echo $t=$row_campos_detalhamento['bbh_cam_ind_ordem']; ?></td>
        <td height="25" align="left" >&nbsp;<?php echo $t=$row_campos_detalhamento['bbh_cam_ind_titulo']; ?></td>
        <td><?php echo $t=retornaTitulo($row_campos_detalhamento['bbh_cam_ind_tipo']); ?></td>
        <td align="center"><?php echo $a=$row_campos_detalhamento['bbh_cam_ind_disponivel'] ? 'Sim' : 'Não'; ?></td>
        <td align="center">
        <?php 
		if($row_campos_detalhamento['bbh_cam_ind_tipo'] == "data" || $row_campos_detalhamento['bbh_cam_ind_tipo'] == "texto_longo" || $row_campos_detalhamento['bbh_cam_ind_tipo'] == "lista_opcoes")
		{
			echo "-";	
		}else{
			echo $t=$row_campos_detalhamento['bbh_cam_ind_tamanho'];
		}
		?>        </td>
        <td><?php echo $a=empty($row_campos_detalhamento['bbh_cam_ind_curinga'])?"-":$a=$row_campos_detalhamento['bbh_cam_ind_curinga']; ?></td>
        
        
        <td align="center" valign="middle">
        <?PHP if( $anterior != 0 ){ ?>
        <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_tabela/editar.php?bbh_cam_ind_codigo=<?php echo $row_campos_detalhamento['bbh_cam_ind_codigo']; ?>&ordem=diminui','menuEsquerda|conteudoGeral');" style="color:#0099FF">
            <img src="/e-solution/servicos/bbhive/images/seta_cima.gif" width="20" height="17" border="0" />
        </a>
		<?PHP } $anterior++; ?>
        &nbsp;
        </td>
        <td align="center" valign="middle">
        <?PHP if( $anterior < $totalRows_campos_detalhamento ){ ?>
        <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_tabela/editar.php?bbh_cam_ind_codigo=<?php echo $row_campos_detalhamento['bbh_cam_ind_codigo']; ?>&ordem=soma','menuEsquerda|conteudoGeral');" style="color:#0099FF">
            <img src="/e-solution/servicos/bbhive/images/seta_baixo.gif" width="20" height="17" border="0" />
        </a>
		<?PHP }  ?>
        &nbsp;
		</td>
        
        <td width="3%" align="center">
          <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_tabela/editar.php?bbh_cam_ind_codigo=<?php echo $row_campos_detalhamento['bbh_cam_ind_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
        <img src="/e-solution/servicos/bbhive/images/editar.gif" alt="Editar campo de detalhamento" border="0" align="absmiddle" />        </a>        </td>
        <td width="6%" align="center">
         <?php if($cadastrado == false && $row_campos_detalhamento['bbh_cam_ind_fixo']=="0") { ?>
          <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_tabela/excluir.php?bbh_cam_ind_codigo=<?php echo $row_campos_detalhamento['bbh_cam_ind_codigo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
        <img src="/e-solution/servicos/bbhive/images/<?php echo $imagem_exclusao; ?>" alt="<?php echo $alt; ?>" border="0" align="absmiddle" /></a> 
        <?php }else{ ?>
                <img src="/e-solution/servicos/bbhive/images/<?php echo $imagem_exclusao; ?>" alt="<?php echo $alt; ?>" border="0" align="absmiddle" />
        <?php } ?>
        </td>
  </tr>
          <tr>
	    	<td height="1" colspan="8" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
		  </tr>
 <?php } ?>

   <?php if ($totalRows_campos_detalhamento == 0) { // Show if recordset not empty ?>
  <tr class="legandaLabel11">
    <td height="25" colspan="10" align="left">&nbsp;&nbsp;<img src="/e-solution/servicos/bbhive/images/alerta.gif" width="13" height="11" align="absmiddle"> N&atilde;o existem campos de detalhamento criados. Caso deseja criar um novo, clique <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_tabela/novo.php','menuEsquerda|conteudoGeral');" style="color:#0099FF">aqui</a></td>
  </tr>
  <?php } ?>

 <tr class="legandaLabel11">
    <td height="22" colspan="10" align="center">&nbsp;</td>
  </tr>
  <tr class="legandaLabel11">
    <td height="5" colspan="10" align="center"></td>
  </tr>
</table>
<?php
mysqli_free_result($campos_detalhamento);
?>