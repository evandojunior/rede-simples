<?php
//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_indicio'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

	//RecordSet dos campos
	$query_campos_detalhamento = "select * from bbh_campo_tipo_indicio tp
							 inner join bbh_campo_indicio cp on tp.bbh_cam_ind_codigo = cp.bbh_cam_ind_codigo
							  where tp.bbh_tip_codigo = $codigo
								GROUP BY cp.bbh_cam_ind_codigo
							   order by tp.bbh_ordem_exibicao ASC";
    list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);

if($tabelaCriada==1){
	
?><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="justify">&nbsp;<img src="/servicos/bbhive/images/detalhamento.gif" align="absmiddle" />&nbsp;<strong>Informa&ccedil;&otilde;es complementares.</strong></td>
  </tr>
  <tr>
    <td height="1" colspan="2" bgcolor="#EDEDED"></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <?php 
  //--
  $cor = "";
  //--
  while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
			//Atributos de uma tabela dinâmica
			$tipoDeCampo 	= $row_campos_detalhamento['bbh_cam_ind_tipo']; 
			$nomeFisico 	= $row_campos_detalhamento['bbh_cam_ind_nome'];
			$titulo 		= $row_campos_detalhamento['bbh_cam_ind_titulo'];
			
				if(isset($bbh_flu_codigo) && $bbh_flu_codigo==0){
					//é inicio e não edição então deve pegar dos campos
					$valorPadrao 	= isset($row_tabela_fisica['bbh_cam_ind_default'])?$row_tabela_fisica['bbh_cam_ind_default']:''; 
				} else {
					$valorPadrao 	= isset($row_tabela_fisica[$nomeFisico])?$row_tabela_fisica[$nomeFisico]:''; 
				}
			
			$editListagem 	= $row_campos_detalhamento['bbh_cam_ind_default']; 
			$tamanho 		= $row_campos_detalhamento['bbh_cam_ind_tamanho']; 
			
			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}
			if($cor == "#ffffff") { $cor="#F5F5F5"; } else{ $cor="#ffffff"; } $cor = $cor;
	  ?>
  <tr bgcolor="<?php echo $cor; ?>">
    <td width="31%" height="25" align="left" valign="top" class="verdana_11"><strong>&nbsp;<?php echo $titulo; ?>:</strong></td>
    <td width="69%" align="left" valign="top" class="verdana_11"><?php 
				//Inclusão que isola o algoritmo que exibe cada tipo de campo
				include('includes/formDinamico.php');   
			?></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="2">&nbsp;</td>
    </tr>
</table>
<?php } ?>