<?php
//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
list($rsColunas, $fetch, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

//Tabela física
$query_tabela_fisica = "SELECT * FROM bbh_detalhamento_protocolo WHERE bbh_pro_codigo = " . $bbh_pro_codigo;
list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		
	//RecordSet dos campos
	$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_disponivel ='1' order by bbh_cam_det_pro_ordem asc";
    list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);

if($tabelaCriada==1){
	if(!isset($semFormDetalhamento)){
?><form name="formDetlhamento" id="formDetlhamento">
	<?php } ?>
    <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <?php 
  $cor = "";
  $campos_obrigatorios ="";
  while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){

			//Atributos de uma tabela dinâmica
			$tipoDeCampo	= $row_campos_detalhamento['bbh_cam_det_pro_tipo']; 
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
			$obrigatorio = $row_campos_detalhamento['bbh_cam_det_pro_obrigatorio']=='1'?"*":"";
			$temObrigatorio = (isset($temObrigatorio))?$temObrigatorio:'';
			$temObrigatorio = $temObrigatorio + $row_campos_detalhamento['bbh_cam_det_pro_obrigatorio'];
			//--
			if($row_campos_detalhamento['bbh_cam_det_pro_obrigatorio']=='1' && isset($pgProtocolo) && (isset($codSta)&&($codSta==2)) && $row_campos_detalhamento['bbh_cam_det_pro_preencher_apos_receber']=="1"){
				$tp = $tipoDeCampo=="time_stamp"?"TS":"";
				$tp = $tipoDeCampo=="horario_editavel"?"Data":$tp;
				
				$campos_obrigatorios.= ",".($tp.$nomeFisico)."|Campo $titulo obrigatório.";
			}
			//--
	  ?>
  <tr bgcolor="<?php echo $cor; ?>" style="display:<?php echo $display; ?>">
    <td width="283" height="25" align="left" class="verdana_11"><strong>&nbsp;<?php echo $titulo; ?> <?php if(isset($pgProtocolo) && (isset($codSta)&&($codSta==2)) && $row_campos_detalhamento['bbh_cam_det_pro_preencher_apos_receber']=="1"&&$row_campos_detalhamento['bbh_cam_det_pro_obrigatorio']=='1'){echo '*';}?>:</strong></td>
    <td width="647" align="left" class="verdana_11 color"><?php 
				if($nomeFisico=="bbh_dep_codigo"){
					echo $row_strProtocolo['bbh_dep_nome'];
				}elseif($nomeFisico=="bbh_pro_flagrante"){
					echo $valorPadrao=="1"?"Sim":"Não";
				} elseif(isset($pgProtocolo) && (isset($codSta)&&($codSta==2)) && $row_campos_detalhamento['bbh_cam_det_pro_preencher_apos_receber']=="1"){
					include('includes/formDinamico.php');
					$enviaParaGravarDetalhamento = true;
			  	} else {
					//Inclusão que isola o algoritmo que exibe cada tipo de campo
					include('includes/listaDinamica.php');   
				}
			?></td>
  </tr>
  <?php } ?>
<?php if($temObrigatorio>0){ 
?>
  <tr>
    <td height="25" colspan="2" align="left" class="verdana_11">O campos marcados com '*' são obrigatórios.</td>
  </tr>
<?php } ?>
  <?php if(isset($pgProtocolo) && (isset($codSta)&&($codSta==2)) && isset($enviaParaGravarDetalhamento)){?>
  <tr>
    <td height="25" colspan="2" align="left" class="verdana_11"><input name="DetalhamentoAtualizado" id="DetalhamentoAtualizado" type="hidden" value="0" readonly="readonly" />
    	<div style="float:right" class="verdana_12"><a href="#@" onclick="validaForm('formDetlhamento','bbh_pro_codigo|Preencha o campo...<?php echo $campos_obrigatorios; ?>',document.getElementById('acaoFormDetalhamento').value);"><img src="/corporativo/servicos/bbhive/images/salvar.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;Atualizar dados do protocolo</a></div>
    	<div style="float:right; color:#090" class="verdana_12" id="loadFormDetalhamento">&nbsp;</div>
    </td>
  </tr>
  <?php } ?>
</table><input type="hidden" name="bbh_pro_codigo" id="bbh_pro_codigo" value="<?php echo $bbh_pro_codigo; ?>" />
<input type="hidden" name="acaoFormDetalhamento" id="acaoFormDetalhamento" value=" <?php echo isset($gravaDetalhamento) ? $gravaDetalhamento : null; ?>" />
	<?php if(!isset($semFormDetalhamento)){ ?>
        </form>
    <?php } ?>
<?php } ?>