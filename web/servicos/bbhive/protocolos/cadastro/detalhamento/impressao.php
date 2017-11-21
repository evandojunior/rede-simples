<?php
//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

//Tabela física
$query_tabela_fisica = "SELECT * FROM bbh_detalhamento_protocolo WHERE bbh_pro_codigo = " . $_SESSION['idProtocolo'];
list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		
	//RecordSet dos campos
	$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_disponivel ='1' order by bbh_cam_det_pro_ordem asc";
    list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);

if($tabelaCriada==1){
	
?><table width="585" border="0" align="center" cellpadding="0" cellspacing="0"  class="legandaLabel11">
  <?php 
  $cor = "";
  while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
			//Atributos de uma tabela dinâmica
			$tipoDeCampo	= $row_campos_detalhamento['bbh_cam_det_pro_tipo']; 
			$nomeFisico 	= $row_campos_detalhamento['bbh_cam_det_pro_nome'];
			$titulo 		= $row_campos_detalhamento['bbh_cam_det_pro_titulo'];
			$editListagem 	= $row_campos_detalhamento['bbh_cam_det_pro_default']; 
			$tamanho 		= $row_campos_detalhamento['bbh_cam_det_pro_tamanho']; 

			//Precisamos descobrir se é fixo ou dinâmico			
			if($row_campos_detalhamento['bbh_cam_det_pro_fixo']=="1"){
				$valorPadrao 	= $row_strProtocolo[$nomeFisico]; 
			} else {
				$valorPadrao 	= $row_tabela_fisica[$nomeFisico]; 
			}
			//--
						
			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}
			if($cor == "#ffffff") { $cor="#F5F5F5"; } else{ $cor="#ffffff"; } $cor = $cor;
			
			$visivel = "sim";
			if($row_campos_detalhamento['bbh_cam_det_pro_visivel']=="0"){
				$visivel = "nao";
				if($cor == "#ffffff") { $cor="#F5F5F5"; } else{ $cor="#ffffff"; } $cor = $cor;
			}
			//--Campo visível
			$display = $visivel=="sim"?"block":"none";
			//--
	  ?>
  <tr bgcolor="<?php echo $cor; ?>" style="display:<?php echo $display; ?>">
    <td width="201" height="25" align="left" valign="top" class="verdana_11"><strong>&nbsp;<?php echo $titulo; ?> :</strong></td>
    <td width="384" align="left" valign="top" class="verdana_11"><span class="verdana_11 color">
      <?php 
				if($nomeFisico=="bbh_dep_codigo"){
					echo $row_strProtocolo['bbh_dep_nome'];
				}elseif($nomeFisico=="bbh_pro_flagrante"){
					echo $valorPadrao=="1"?"Sim":"Não";
				} else {
					//Inclusão que isola o algoritmo que exibe cada tipo de campo
					include('includes/listaDinamica.php');   
				}
			?>
    </span></td>
  </tr>
  <?php } ?>
  </table>
<?php } ?>