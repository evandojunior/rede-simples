<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_indicio'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

//Tabela física
$query_tabela_fisica = "SELECT * FROM bbh_indicio WHERE bbh_ind_codigo = " . $_GET['item'];
list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		
	//RecordSet dos campos
	$query_campos_detalhamento = "select * from bbh_campo_tipo_indicio tp
							 inner join bbh_campo_indicio cp on tp.bbh_cam_ind_codigo = cp.bbh_cam_ind_codigo
							  where tp.bbh_tip_codigo = ".$row_tabela_fisica['bbh_tip_codigo']."
							 group by cp.bbh_cam_ind_codigo
							   order by tp.bbh_ordem_exibicao ASC";
    list($campos_detalhamento, $copiaDetalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);

if($tabelaCriada==1 && $totalRows_tabela_fisica>0){
	
?>
<form name="edit_indicio_<?PHP echo $_GET['item']; ?>" name="edit_indicio_<?PHP echo $_GET['item']; ?>">
<table width="98%" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#FFFFCC">
  <tr>
    <td colspan="2" align="justify">
    <div style="float:left; width:95%">
    &nbsp;<img src="/servicos/bbhive/images/detalhamento.gif" align="absmiddle" />&nbsp;<strong>Informa&ccedil;&otilde;es complementares.</strong>
    </div>
    <div style="float:left; width:5%" align="right">
    <img src="/corporativo/servicos/bbhive/images/fecharUP.gif" border="0" align="absmiddle" title="Fechar detalhes" onclick="document.getElementById('item_<?php echo $_GET['item']; ?>').innerHTML=''" style="cursor:pointer" />
    </div>
    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" bgcolor="#EDEDED"></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <?php while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
			//Atributos de uma tabela dinâmica
			$bbh_tip_codigo = $row_tabela_fisica['bbh_tip_codigo']; 
			$bbh_ind_codigo = $row_tabela_fisica['bbh_ind_codigo']; 
			$tipoDeCampo	= $row_campos_detalhamento['bbh_cam_ind_tipo']; 
			$nomeFisico 	= $row_campos_detalhamento['bbh_cam_ind_nome'];
			$titulo 		= $row_campos_detalhamento['bbh_cam_ind_titulo'];
			$valorPadrao 	= $row_tabela_fisica[$nomeFisico]; 
			$editListagem 	= $row_campos_detalhamento['bbh_cam_ind_default']; 
			$tamanho 		= $row_campos_detalhamento['bbh_cam_ind_tamanho']; 
			
			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}
	  ?>
  <tr>
    <td width="237" height="25" align="left" class="verdana_11"><strong>&nbsp;<?php echo $titulo; ?> :</strong></td>
    <td width="329" align="left" class="verdana_11">&nbsp;
	<input type="hidden" id="bbh_ind_codigo" name="bbh_ind_codigo" value="<?PHP echo $bbh_ind_codigo; ?>" />
	<input type="hidden" id="codigo" name="codigo" value="<?PHP echo $bbh_tip_codigo; ?>" />
	<?php 
				//Inclusão que isola o algoritmo que exibe cada tipo de campo
				include('../detalhamento/includes/listaDinamicaFluxo.php');   
			?></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="1" colspan="2" bgcolor="#FFFFFF" align="right">
    <a href="javascript:void(0);" onclick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/protocolo/detalhamento/grava_dadosIndicio.php','loadMsg','edit_indicio_<?PHP echo $_GET['item']; ?>','Aguarde carregando dados...','loadMsg','1','2');">
    <img align="absmiddle" width="16" border="0" height="16" title="Salvar este indicio!" src="/corporativo/servicos/bbhive/images/salvar.gif"/> Salvar
    </a>
    &nbsp;&nbsp;&nbsp;
    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</form>
<?php } ?>