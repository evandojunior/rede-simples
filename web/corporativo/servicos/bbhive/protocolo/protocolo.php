<?php
$pagina = "protocolo/index.php?";
//-----------------------------------------------------------------------------------------
$url = "";
foreach($_GET as $indice=>$valor){
	if(($indice=="amp;busca")||($indice=="busca")){	$busca= $valor; $url="&busca=".$busca; } 
	if(($indice=="amp;todos")||($indice=="todos")){	$todos= $valor; $url="&todos=".$todos; } 
	if(($indice=="amp;status")||($indice=="status")){ $Ostatus= $valor; $url="&status=".$Ostatus; } 
	if(($indice=="amp;inicio")||($indice=="inicio")){ $inicio= $valor;} 
}

if(isset($busca)){
	$stringAnd	= " AND bbh_pro_codigo IN ($busca)";
}

if(isset($Ostatus)){
	$stringAnd = " AND bbh_pro_status='$Ostatus'";
}
if(isset($todos)){
	$stringAnd	= "";
}

//Dados para paginação
$dadosURL = "";
//--GET
	foreach($_GET as $i=>$v){
		$dadosURL.= "&".$i."=".$v;
	}
//--POST
	foreach($_POST as $i=>$v){
		$dadosURL.= "&".$i."=".$v;
	}
	
//SQL PADRÃO PARA EXECUÇÃO DE DADOS DESTA PÁGINA
$sqlPadrao = "SELECT bbh_pro_codigo FROM bbh_protocolos 
				  left join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo 
				  left join bbh_usuario on bbh_protocolos.bbh_pro_email = bbh_usuario.bbh_usu_identificacao
				  left join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
				  WHERE 
					bbh_protocolos.bbh_dep_codigo = (select bbh_dep_codigo from bbh_usuario where bbh_usu_identificacao = '".$_SESSION['MM_User_email']."') $stringAnd";
//----------------------------------------------------------------------------------------------------

$query_strProtocolos = $sqlPadrao. "group by bbh_protocolos.bbh_pro_codigo";
list($strProtocolo, $rows, $totalRows_strProtocolos) = executeQuery($bbhive, $database_bbhive, $query_strProtocolos, $initResult = false);

	$page 		= "1";
	$nElements 	= "100";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= 'protocolo/index.php?Ts='.$_SERVER['REQUEST_TIME'].$dadosURL;
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($totalRows_strProtocolos/$nElements);

$sqlPadrao = "SELECT bbh_per_codigo, bbh_protocolos.*, bbh_dep_nome FROM bbh_protocolos 
				  left join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo 
				  left join bbh_usuario on bbh_protocolos.bbh_pro_email = bbh_usuario.bbh_usu_identificacao
				  left join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
				  WHERE 
					bbh_protocolos.bbh_dep_codigo = (select bbh_dep_codigo from bbh_usuario where bbh_usu_identificacao = '".$_SESSION['MM_User_email']."') $stringAnd";
//----------------------------------------------------------------------------------------------------

$query_strProtocolos = $sqlPadrao. "group by bbh_protocolos.bbh_pro_codigo
							 ORDER BY bbh_pro_codigo DESC LIMIT $Inicio,$nElements";
list($strProtocolos, $rows, $totalRows_strProtocolos) = executeQuery($bbhive, $database_bbhive, $query_strProtocolos, $initResult = false);

/*
//total de protocolos sem fluxo
$totNovas = total($database_bbhive, $bbhive, "SELECT * FROM bbh_protocolos Where bbh_pro_status is NULL");
//total de todos os protocolos para paginação
$totpagina= total($database_bbhive, $bbhive, $sqlPadrao);

//lógica para paginação com todos os dados do GET
	*/
?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11" style="margin-top:10px; border:#069 solid 1px;">
  <tr>
    <td height="30" bgcolor="#D6D6D6" class="verdana_12 color">&nbsp;<strong><?php echo ($_SESSION['ProtNome']); ?> de acesso p&uacute;blico</strong> <label style="color:#333333"><strong><?php //if($totNovas>1) { echo "(".$totNovas." novas solicita&ccedil;&otilde;es)"; } elseif($totNovas==1){ echo "(".$totNovas." nova solicita&ccedil;&atilde;o)"; } ?></strong></label></td>
  </tr>
  <tr>
    <td height="200" valign="top" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;">
    
	<?php require_once("menu.php");?>
<br />
  		<?php require_once("lista.php"); ?>
        <div class="verdana_12" align="center" style="margin-top:5px;">
    	<?php 
		//PAGINAÇÃO
			require_once('../includes/paginacao/paginacao.php');
		?>
        </div>
    </td>
  </tr>
  <tr>
    <td height="6"></td>
  </tr>
</table>
<?php
mysqli_free_result($strProtocolos);
?>
