<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/functions.php");

//Pegando o código do modelo do fluxo e o nome da tabela
$codigo_modelo_fluxo = $bbh_mod_flu_codigo;	
$bbh_flu_codigo 	 = $bbh_flu_codigo;	
$nome_tabela 		 = "bbh_modelo_fluxo_". $codigo_modelo_fluxo ."_detalhado";
	
//Dados do detalhamento
$query_detalhamento = "SELECT * FROM bbh_detalhamento_fluxo WHERE bbh_mod_flu_codigo = $codigo_modelo_fluxo";
list($detalhamento, $row_detalhamento, $totalRows_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_detalhamento);

if($row_detalhamento['bbh_det_flu_tabela_criada'] == 1 ){
		
		//RecordSet dos campos
		$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo  INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo  WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo AND bbh_cam_det_flu_disponivel='1' AND bbh_cam_det_flu_codigo in ($camposExibicao)";
        list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);
		
		//Tabela física		
		$nome_tabela = "bbh_modelo_fluxo_". $codigo_modelo_fluxo ."_detalhado";
		$query_tabela_fisica = "SELECT * FROM $nome_tabela WHERE bbh_flu_codigo = " . $bbh_flu_codigo;
        list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		//--
		$query_fisica = "SELECT table_name FROM information_schema.tables
    WHERE table_schema = '$database_bbhive' and table_name = '$nome_tabela'";
        list($fisica, $row_fisica, $totalRows_fisica) = executeQuery($bbhive, $database_bbhive, $query_fisica);
		//precisa verificar se é inicio de um fluxo, se for devo montar tudo com base nos campos e não na tabela
		if($bbh_flu_codigo==0){
			//é inicio e não edição então deve pegar dos campos
			$totalRows_tabela_fisica = 1;
		}
		
		?>
		
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
		
<?php	
if($totalRows_fisica>0){
    	//RecordSet dos campos da tabela dinâmica
		do{
			
			//Atributos de uma tabela dinâmica
			$tipoDeCampo 	= $row_campos_detalhamento['bbh_cam_det_flu_tipo']; 
			$nomeFisico 	= $row_campos_detalhamento['bbh_cam_det_flu_nome'];
			$titulo 		= $row_campos_detalhamento['bbh_cam_det_flu_titulo'];
			$observacao 	= $row_campos_detalhamento['bbh_cam_det_flu_descricao'];
			
				if($bbh_flu_codigo==0){
					//é inicio e não edição então deve pegar dos campos
					$valorPadrao 	= $row_tabela_fisica['bbh_cam_det_flu_default']; 
				} else {
					$valorPadrao 	= $row_tabela_fisica[$nomeFisico]; 
				}
			$editListagem 	= $row_campos_detalhamento['bbh_cam_det_flu_default']; 
			$tamanho 		= $row_campos_detalhamento['bbh_cam_det_flu_tamanho']; 

			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}
			?>
			
			
          <tr>
            <td width="38%" align="left" valign="middle" class="verdana_11_bold" style="padding-top:10px;"><?php echo $titulo; ?> :&nbsp;            
            <div style="margin-top:5px;margin-left:40px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;font-weight:normal;">
            <?php 
				//Inclusão que isola o algoritmo que exibe cada tipo de campo
				
				include('includes/formDinamico.php');   
			?>
            </div>            </td>
          </tr>
<?php		}while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento));
}
?>
</table>	
<?php } ?>
<input type="hidden" name="nome_tabela" value="<?php echo $nome_tabela; ?>"  />
<input type="hidden" name="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
<input type="hidden" name="bbh_mod_flu_codigo" value="<?php echo $codigo_modelo_fluxo; ?>" />
<input type="hidden" name="colunasDet" value="<?php echo $camposExibicao; ?>" readonly="readonly" />