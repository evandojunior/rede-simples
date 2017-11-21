<?php
//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

//Tabela física
$query_tabela_fisica = "SELECT * FROM bbh_detalhamento_protocolo WHERE bbh_pro_codigo = " . $_SESSION['idProtocolo'];
list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		
	//RecordSet dos campos
	$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_protocolo order by bbh_cam_det_pro_ordem asc";
    list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);

if($tabelaCriada==1){
	
?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="justify">&nbsp;<img src="/servicos/bbhive/images/detalhamento.gif" align="absmiddle" />&nbsp;<strong>Informa&ccedil;&otilde;es complementares.</strong></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#EDEDED"></td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
  <?php 
  $cor = "";
  while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
			//Atributos de uma tabela dinâmica
			$tipoDeCampo	= $row_campos_detalhamento['bbh_cam_det_pro_tipo']; 
			$nomeFisico 	= $row_campos_detalhamento['bbh_cam_det_pro_nome'];
			$titulo 		= $row_campos_detalhamento['bbh_cam_det_pro_titulo'];
			$valorPadrao 	= $row_tabela_fisica[$nomeFisico]; 
			$editListagem 	= $row_campos_detalhamento['bbh_cam_det_pro_default']; 
			$tamanho 		= $row_campos_detalhamento['bbh_cam_det_pro_tamanho']; 
			
			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}
			if($cor == "#ffffff") { $cor="#F5F5F5"; } else{ $cor="#ffffff"; } $cor = $cor;
	  ?>
  <tr bgcolor="<?php echo $cor; ?>">
    <td height="25" align="left" class="verdana_11"><strong>&nbsp;<?php echo $titulo; ?> :</strong></td>
  </tr>
  <tr bgcolor="<?php echo $cor; ?>">
    <td height="25" align="left" class="verdana_11">&nbsp;&nbsp;&nbsp;      <?php 
				//Inclusão que isola o algoritmo que exibe cada tipo de campo
				include('includes/listaDinamica.php');   
			?></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="25">&nbsp;</td>
    </tr>
</table>
<?php } ?>