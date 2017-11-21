<?php
//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

	//RecordSet dos campos
	$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_disponivel ='1'and bbh_cam_det_pro_preencher_apos_receber='0' order by bbh_cam_det_pro_ordem asc";
    list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);

if($tabelaCriada==1){
	
	//Tabela física
	$query_tabela_fisica = "SELECT * FROM bbh_detalhamento_protocolo WHERE bbh_pro_codigo = " . $bbh_pro_codigo;
    list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
	
?><table width="930" border="0" align="center" cellpadding="0" cellspacing="0">
  <?php 
  $cor = ""; $temObrigatorio=0; $campos_obrigatorios="";
  while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
			//Atributos de uma tabela dinâmica
			$tipoDeCampo 	= $row_campos_detalhamento['bbh_cam_det_pro_tipo']; 
			$nomeFisico 	= $row_campos_detalhamento['bbh_cam_det_pro_nome'];
			$titulo 		= $row_campos_detalhamento['bbh_cam_det_pro_titulo'];
			
			//Precisamos descobrir se é fixo ou dinâmico			
			if($row_campos_detalhamento['bbh_cam_det_pro_fixo']=="1"){
				$valorPadrao 	= $row_strProtocolo[$nomeFisico]; 
			} else {
				$valorPadrao 	= $row_tabela_fisica[$nomeFisico]; 
			}
			//--
			
			$editListagem 	= $row_campos_detalhamento['bbh_cam_det_pro_default']; 
			$tamanho 		= $row_campos_detalhamento['bbh_cam_det_pro_tamanho']; 
			
			if($valorPadrao == "")			{
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
			$obrigatorio = $row_campos_detalhamento['bbh_cam_det_pro_obrigatorio']=='1'?"*":"";
			$temObrigatorio = $temObrigatorio + $row_campos_detalhamento['bbh_cam_det_pro_obrigatorio'];
			//--
			if($row_campos_detalhamento['bbh_cam_det_pro_obrigatorio']=='1'){
				$tp = $tipoDeCampo=="time_stamp"?"TS":"";
				$tp = $tipoDeCampo=="horario_editavel"?"Data":$tp;
				
				$campos_obrigatorios.= ",".($tp.$nomeFisico)."|Campo $titulo obrigatório.";
			}
			//--
	  ?>
  <tr bgcolor="<?php echo $cor; ?>" style="display:<?php echo $display; ?>">
    <td width="283" height="25" align="left" class="verdana_11"><strong>&nbsp;<?php echo $titulo; ?> <?php echo $obrigatorio; ?>:</strong></td>
    <td width="647" align="left" class="verdana_11"><?php 
				//Funcionará somente se tiver departamentos ou seja este é do protocolo
				if(isset($todosDepto) && $nomeFisico=="bbh_dep_codigo"){
					echo '<select name="'.$nomeFisico.'" id="'.$nomeFisico.'" class="back_input">';
						foreach($todosDepto as $i=>$v){
							//--
							$s = $valorPadrao == $i ? "selected" : "";
							//--
							echo '<option value="'.$i.'" '.$s.'>'.$v.'</option>';
						}
					echo '</select>';
				} elseif($nomeFisico=="bbh_pro_flagrante"){
					echo '<select name="'.$nomeFisico.'" id="'.$nomeFisico.'" class="back_input">';
							//--
							$s = $valorPadrao == "1" ? "selected" : "";
							$n = $valorPadrao == "0" ? "selected" : "";
							//--
							echo '<option value="1" '.$s.'>Sim</option>';
							echo '<option value="0" '.$n.'>Não</option>';
						
					echo '</select>';
				} else {
					//Inclusão que isola o algoritmo que exibe cada tipo de campo
					include('includes/formDinamico.php');   
				}
			?></td>
  </tr>
  <?php } ?>
  <tr style="display:block">
    <td height="25" colspan="2">&nbsp;</td>
    </tr>
</table>
<?php } 
echo $temObrigatorio>0?"O campos marcados com '*' são obrigatórios.":""; 
?>