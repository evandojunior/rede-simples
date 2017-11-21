<?php
	require_once('includes/functions.php');
	
	if(!isset($_SESSION)){ session_start(); }

	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");		

	foreach($_GET as $indice=>$valor){
		if(($indice=="amp;bbh_mod_flu_codigo")||($indice=="bbh_mod_flu_codigo")){ $codigo_modelo_fluxo= $valor; } 
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
	}

$idMensagemFinal= 'conteudoDetalhamento';
$infoGet_Post	= 'bbh_mod_flu_codigo='.$codigo_modelo_fluxo . '&bbh_flu_codigo=' . $bbh_flu_codigo;//Se envio for POST, colocar nome do formulário
$Mensagem		= 'Carregando dados...';
$idResultado	= $idMensagemFinal;
$Metodo			= '2';//1-POST, 2-GET
$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
$homeDestino	= '/corporativo/servicos/bbhive/fluxo/detalhamento/edita.php?';
$homeDestinoII	= '/corporativo/servicos/bbhive/fluxo/detalhamento/regra.php';

$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";

//Pegando o código do modelo do fluxo e o nome da tabela
$nome_tabela = "bbh_modelo_fluxo_". $codigo_modelo_fluxo ."_detalhado";
	
//Dados do detalhamento
$query_detalhamento = "SELECT * FROM bbh_detalhamento_fluxo WHERE bbh_mod_flu_codigo = $codigo_modelo_fluxo";
list($detalhamento, $row_detalhamento, $totalRows_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_detalhamento);

if($row_detalhamento['bbh_det_flu_tabela_criada'] == 1 ){
		
		//RecordSet dos campos
		$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo  INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo  WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo AND bbh_cam_det_flu_disponivel='1'";
        list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);
		
		//Tabela física
		$query_tabela_fisica = "SELECT * FROM $nome_tabela WHERE bbh_flu_codigo = " . $bbh_flu_codigo;
        list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);

$query_fluxo = sprintf("SELECT bbh_flu_finalizado FROM bbh_fluxo WHERE bbh_flu_codigo = %s", GetSQLValueString($bbhive, $bbh_flu_codigo, "int"));
list($fluxo, $row_fluxo, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $query_fluxo);

	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Visualizou a página de detalhamento do fluxo () - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/

?>
		
		<table width="98%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="179" align="left" valign="top" class="verdana_11_bold" style="padding-top:10px;">
            <td width="410" align="right" valign="top">&nbsp;</td>
          </tr>
		
<?php	
		$contador = 0;
    	//RecordSet dos campos da tabela dinâmica
		do{
			
			//Atributos de uma tabela dinâmica
			$tipoDeCampo = $row_campos_detalhamento['bbh_cam_det_flu_tipo']; 
			$nomeFisico = $row_campos_detalhamento['bbh_cam_det_flu_nome'];
			$titulo = $row_campos_detalhamento['bbh_cam_det_flu_titulo'];
			$valorPadrao = $row_tabela_fisica[$nomeFisico]; 
			$editListagem = $row_campos_detalhamento['bbh_cam_det_flu_default']; 
			$tamanho = $row_campos_detalhamento['bbh_cam_det_flu_tamanho']; 
			
			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}
			
			if($contador % 2 == 0)
			{
				$cor = "#F5F5F5";
			}else{
				$cor = "#FFFFFF";
			}
			?>
			
			
        
          <tr bgcolor="<?php echo $cor; ?>">
            <td align="left" valign="top" bgcolor="<?php echo $cor; ?>" class="verdana_11_bold" style="padding-top:10px;"><?php echo $titulo; ?> :&nbsp;            
            <td align="left" valign="top">
            <?php 
				//Inclusão que isola o algoritmo que exibe cada tipo de campo
				include('includes/listaDinamica.php');   

			?>            </td>
          </tr>
		
		
<?php	$contador++;
		}while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)); ?>
          <tr>
          <td></td>
            <td align="right" valign="middle" class="verdana_11_bold" style="padding-top:10px;">
            <?php if($row_fluxo['bbh_flu_finalizado']=='0') { ?>
            <a href="#" onClick="return <?php echo $onClick; ?>">
            <img src="/corporativo/servicos/bbhive/images/edit.gif" width="78" height="21" border="0">
            </a>
            <?php } else { echo "&nbsp;"; } ?>
            </td>
          </tr>
</table>	
		
<?php

}else{ //Se não tiver tabela dinâmica criada.
	echo "<div class='verdana_11'>&nbsp;<img src='/corporativo/servicos/bbhive/images/alerta.gif' align='absmiddle' />&nbsp;N&atilde;o existem detalhamentos para este " . $_SESSION['FluxoNome'] ."<div>";
}
?>
<input type="hidden" name="MM_update" value="form1" />
<?php
mysqli_free_result($fluxo);
?>
<var>
<?php 
	$idMensagemFinal= 'conteudoDetalhamento';
	$infoGet_Post	= 'bbh_mod_flu_codigo='.$codigo_modelo_fluxo . '&bbh_flu_codigo=' . $bbh_flu_codigo;//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/corporativo/servicos/bbhive/fluxo/detalhamento/edita.php?';
	
echo	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
?>
</var>