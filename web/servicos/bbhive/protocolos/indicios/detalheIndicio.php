<?php
if(!isset($_SESSION)){ session_start(); } 
ini_set("display_errors", true);
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/autentica.php");
//include($_SESSION['caminhoFisico']."/servicos/bbhive/protocolos/indicios/detalhamento/includes/functions.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_indicio'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

	foreach($_GET as $indice=>$valor){
		if(($indice=="amp;noIco")||($indice=="noIco")){	$noIco= $valor; } 
		if(($indice=="amp;item")||($indice=="item")){	$item= $valor; } 
	}
	
//Tabela física
$query_tabela_fisica = "SELECT * FROM bbh_indicio WHERE bbh_ind_codigo = " . $_GET['item'];
list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		
	//RecordSet dos campos
  $query_campos_detalhamento = "select * from bbh_campo_tipo_indicio tp
							 inner join bbh_campo_indicio cp on tp.bbh_cam_ind_codigo = cp.bbh_cam_ind_codigo
							  where tp.bbh_tip_codigo = ".$row_tabela_fisica['bbh_tip_codigo']."
								GROUP BY cp.bbh_cam_ind_codigo
							   order by tp.bbh_ordem_exibicao ASC";
  list($campos_detalhamento, $copiaDetalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);

if($tabelaCriada==1 && $totalRows_tabela_fisica>0){
	
?><table width="98%" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#FFFFCC">
  <tr>
    <td colspan="2" align="justify">
    <div style="float:left; width:95%">
    &nbsp;<img src="/servicos/bbhive/images/detalhamento.gif" align="absmiddle" />&nbsp;<strong>Informa&ccedil;&otilde;es complementares.</strong>
    </div>
    <div style="float:left; width:5%" align="right"><?php if(!isset($noIco)){?>
    <img src="/corporativo/servicos/bbhive/images/fecharUP.gif" border="0" align="absmiddle" title="Fechar detalhes" onclick="document.getElementById('item_<?php echo $_GET['item']; ?>').innerHTML=''" style="cursor:pointer" /><?php } ?>
    </div>
    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" bgcolor="#EDEDED"></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td height="25" align="left" class="verdana_11"><strong>&nbsp;Autor:</strong></td>
    <td align="left" class="verdana_11">
    <?PHP 
	$usuario = permissoes_nivel($row_tabela_fisica['bbh_usu_codigo']);
	echo $usuario['nome'];
	?>
    </td>
  </tr>
  <tr>
    <td height="25" align="left" class="verdana_11"><strong>&nbsp;Data de cria&ccedil;&atilde;o :</strong></td>
    <td align="left" class="verdana_11"><?PHP echo converteData($row_tabela_fisica['bbh_ind_cadastro']); ?></td>
  </tr>
  <tr>
    <td height="25" align="left" class="verdana_11"><strong>&nbsp;Credibilidade da Fonte :</strong></td>
    <td align="left" class="verdana_11">
	<?PHP
	// Credibilidade
	$credibilidade = array();
	
	// Pecorre
	while($row_copiaDet = mysqli_fetch_assoc($copiaDetalhamento))
	{
		// Caso seja
		if( $row_copiaDet['bbh_cam_ind_nome'] == 'bbh_ind_confiabilidade_fonte' || $row_copiaDet['bbh_cam_ind_nome'] == 'bbh_ind_veracidade_informacao' )
		{
			$credibilidade[ $row_copiaDet['bbh_cam_ind_nome'] ] = $row_tabela_fisica[ $row_copiaDet['bbh_cam_ind_nome'] ]; 
		}
	}
	
	// Concatena
	echo (isset($credibilidade['bbh_ind_confiabilidade_fonte'])?$credibilidade['bbh_ind_confiabilidade_fonte']:'');
	echo (isset($credibilidade['bbh_ind_veracidade_informacao'])?$credibilidade['bbh_ind_veracidade_informacao']:'');
	?>    
    </td>
  </tr>
  <?php while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
	  
			
			//Atributos de uma tabela dinâmica
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
    <td height="25" align="left" class="verdana_11"><strong>&nbsp;<?php echo $titulo; ?> :</strong></td>
    <td align="left" class="verdana_11">&nbsp;<?php 
				//Inclusão que isola o algoritmo que exibe cada tipo de campo
				include('detalhamento/includes/listaDinamica.php');   
			?></td>
  </tr>
  <?php } ?>
</table>
<?php } ?>