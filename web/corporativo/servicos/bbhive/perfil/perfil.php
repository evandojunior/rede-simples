<?php
	if(!isset($_SESSION)){session_start();}
if(getCurrentPage()!="/corporativo/servicos/bbhive/perfil/detalhes.php"){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
}

	$query_Perfil = "select bbh_usu_codigo, bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_GET['usuario']."
		order by bbh_per_nome asc";
    list($Perfil, $row_Perfil, $totalRows_Perfil) = executeQuery($bbhive, $database_bbhive, $query_Perfil);
	
	$TimeStamp 		= time();
	$idMensagemFinal= '"loadPerfil"';
	$infoGet_Post	= '"&1=1"';//Se envio for POST, colocar nome do formulário
	$Mensagem		= '"Atualizando dados..."';
	$idResultado	= '"direita"';
	$Metodo			= '"2"';//1-POST, 2-GET
	$TpMens			= '"1"';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '"/corporativo/servicos/bbhive/perfil/addPerfil.php?usuario='.$_GET['usuario'].'&Ts='.$TimeStamp.'"';
		
	//esquerda	
	echo "<var style=\"display:none\">OpenAjaxPostCmd($homeDestino,$idResultado,$infoGet_Post,$Mensagem,$idMensagemFinal,$Metodo,$TpMens)</var>".chr(13).chr(10);
?>
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="26" colspan="2" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Perfis adicionados</strong></td>
  </tr>
<?php 
$HTML="";
if($totalRows_Perfil>0) {  ?>
	 <?php  do { 
	 	$HTML.= '<img src="/corporativo/servicos/bbhive/images/perfil.gif" alt="" width="14" height="14" align="absmiddle" />&nbsp;'.$row_Perfil['bbh_per_nome'].'<br/><img src="/corporativo/servicos/bbhive/images/espaco.gif" align="absmiddle" /><br/>';
	 ?>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td width="172" align="left"><a href="#" onClick="return gerencia('/corporativo/servicos/bbhive/perfil/executa.php?bbh_usu_codigo=<?php echo $_GET['usuario']; ?>&bbh_per_codigo=<?php echo $row_Perfil['bbh_per_codigo']; ?>','del');">&nbsp;<img src="/corporativo/servicos/bbhive/images/perfil.gif" width="14" height="14" align="absmiddle" border="0" />&nbsp;<?php echo $row_Perfil['bbh_per_nome']; ?></a></td>
    <td width="28" align="center"><img src="/corporativo/servicos/bbhive/images/exc.gif" width="16" height="15"></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
     <?php }while($row_Perfil = mysqli_fetch_assoc($Perfil)); ?>
<?php } else { 
	$HTML.= "N&atilde;o h&aacute; perfil adicionado";
?> 
  <tr>
    <td colspan="2" height="19" align="center">
            <span class="verdana_9 color">N&atilde;o h&aacute; perfil adicionado</a></span></td>
  </tr>
<?php } ?>
</table><var style="display:none">document.getElementById('listaPerfil').innerHTML='<?php echo $HTML; ?>'</var>