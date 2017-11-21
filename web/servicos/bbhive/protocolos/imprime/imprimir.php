<?php if (!isset($_SESSION)) {  session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/protocolos/cadastro/detalhamento/includes/functions.php");

	//POIS VOU REDIRECIONAR PARA O OK.PHP
	$arquivo = "../../../../datafiles/servicos/bbhive/setup/config.xml";
	
	//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($arquivo);
		//-----	
		$root = $doc->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		//$detalhamento 	= $prot->getAttribute("detalhamento");

	$query_strProtocolo = "SELECT bbh_protocolos.*, bbh_dep_nome, r.bbh_usu_nome, u.bbh_usu_nome as protocolado 
			from bbh_protocolos 
		  		inner join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
		  		left join bbh_usuario as r on bbh_protocolos.bbh_pro_recebido = r.bbh_usu_identificacao 
		  		left join bbh_usuario as u on bbh_protocolos.bbh_pro_email = u.bbh_usu_identificacao
		  			Where bbh_pro_codigo =".$_SESSION['idProtocolo'];
    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);

		//status com base no vetor
		$codSta		= $row_strProtocolo['bbh_pro_status'];
		$cada	 	= explode("|",$status[$codSta]);
		$situacao 	= $cada[0];
		$corFundo 	= $cada[1];	
		$autor		= $row_strProtocolo['protocolado'];
		
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Acessou a página de impressão do protocolo número (".$_SESSION['idProtocolo'].")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBHIVE - Confirma&ccedil;&atilde;o de solicita&ccedil;&atilde;o</title>
<link rel="stylesheet" type="text/css" href="../../includes/bbhive.css">
<script type="text/javascript" src="../../includes/bbhive.js"></script>
<style type="text/css">
body{
 background:#FFFFFF;
}
.TituloInformacao{
	color:#921616;
	font-family:Tahoma;
	font-size:22px;
	letter-spacing:0.05em;
	font-weight:bold;
}
.TituloTopico{
	color:#C60;
	font-family:Tahoma;
	font-size:16px;
	letter-spacing:0.05em;
	font-weight:bold;
}
.corFundoImpressao{
	background-color:#FAFAFA;	
}
</style>
</head>

<body>
<p>&nbsp;</p>
<table width="595" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;">
  <tr>
    <td width="333" height="28" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;<img src="/servicos/bbhive/images/visto.gif" align="absmiddle" />&nbsp;<strong><?php if(!isset($_GET['consulta'])){ echo "Cadastro efetuado com sucesso!!!"; } else { echo "Consulta de solicita&ccedil;&atilde;o!!!"; } ?></strong></td>
    <td width="237" align="center" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><input name="cadastrar" style="background:url(/servicos/bbhive/images/door_out.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="Finalizar" onclick="javascript: window.close();"/>
&nbsp;
<input name="cadastrar2" style="background:url(/servicos/bbhive/images/printII.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;Imprimir" onclick="javasript: print();"/></td>
  </tr>
  <tr>
    <td height="80" colspan="2" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="250" valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%" align="justify">&nbsp;<img src="/servicos/bbhive/images/messagebox_warning.gif" align="absmiddle" />&nbsp;ATEN&Ccedil;&Atilde;O - IMPRIMA ESTE COMPROVANTE PARA FUTURA CONSULTA.</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#EDEDED"></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td height="1" align="left" bgcolor="#5A5A5A"></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF"><span class="legandaLabel16"><strong><?php echo $_SESSION['protNome'];?> :</strong>&nbsp;<?php echo $row_strProtocolo['bbh_pro_codigo']; ?></span></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" height="25"><span class="legandaLabel12"><strong>Autor :</strong>&nbsp;<?php echo converte($autor); ?></span></td>
              </tr>
              <tr>
                <td height="1" align="left" bgcolor="#5A5A5A"></td>
              </tr>
              
              
              <tr>
                <td height="5" align="left"></td>
              </tr>
              <tr>
                <td height="20" align="left"><?php require_once("../cadastro/detalhamento/impressao.php"); ?></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php if(isset($_GET['consulta'])){ 

	$query_strProtocolo = "SELECT * FROM bbh_protocolos WHERE bbh_pro_codigo = ".$_SESSION['idProtocolo'];
    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);
	
	$andamento = "0";
	if($row_strProtocolo['bbh_flu_codigo']!=NULL){
		$codFluxo = $row_strProtocolo['bbh_flu_codigo'];
		$temFluxo = 1;
	}
	
?><br />
<table width="595" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/icon_lado.gif" align="absmiddle" />&nbsp;<strong>Situa&ccedil;&atilde;o da solicita&ccedil;&atilde;o</strong>
      <label style="margin-left:205px;"></label>
    </td>
  </tr>
  <tr>
    <td height="80" valign="top" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              
              <tr>
                <td height="1" bgcolor="#EDEDED"></td>
              </tr>
              
              <tr>
                <td height="25" align="left">
<fieldset style="margin-top:2px; margin-bottom:2px;">
                    <legend class="legandaLabel11">Informa&ccedil;&otilde;es do <?php echo $_SESSION['protNome']; ?></legend>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
                          <tr style="background-color:<?php echo $corFundo; ?>">
                            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/engrenagem.gif" alt="" border="0" align="absmiddle"></td>
                            <td height="25"><strong>Situa&ccedil;&atilde;o: <span style="color:#033"><?php echo strtoupper($situacao); ?></span></strong></td>
                          </tr>
                          <?php if($codSta!="1") { ?>
                          <tr>
                            <td height="25" align="center">&nbsp;</td>
                            <td height="25"><strong>Recebido por:&nbsp;<span style="color:#F60"><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;<?php echo !empty($row_strProtocolo['bbh_usu_nome']) ? $row_strProtocolo['bbh_usu_nome'] : $row_strProtocolo['bbh_pro_recebido']; ?></span></strong></td>
                          </tr>
                          <tr>
                            <td width="9%" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" alt="" border="0" align="absmiddle"></td>
                            <td width="91%">&nbsp;<strong><span style="color:#F60">Em:</span>&nbsp;<?php echo arrumadata(substr($row_strProtocolo['bbh_pro_dt_recebido'],0,10)) ." ".substr($row_strProtocolo['bbh_pro_dt_recebido'],11,5); ?></strong></td>
                          </tr>
                          <?php } ?>
                        </table>
                      </fieldset>
                </td>
              </tr>
              
			<?php if(isset($temFluxo)){ ?> 
              <tr>
                <td height="25" align="left">
                	<?php require_once('../cadastro/fluxo.php'); ?></td>
              </tr>
		   <?php } ?>
           <?php if($codSta==6) { ?>              
              <tr>
                <td height="25" align="left" style="color:#36C"><?php echo nl2br($row_strProtocolo['bbh_pro_obs']); ?></td>
              </tr>
           <?php } ?>  
            </table>
            </td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php } ?><br />
<table width="595" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="3" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<strong>Arquivos digitalizados</strong></td>
  </tr>
  <?php $cont = 0;
if ($handle = @opendir(str_replace("web","database",$_SESSION['caminhoFisico'])."/servicos/bbhive/protocolo/protocolo_".$_SESSION['idProtocolo']."/.")) {


while (false !== ($file = readdir($handle))) {
  if ($file != "." && $file != "..") {

		$excluir ="&nbsp;";
		  if(empty($bbh_flu_codigo)){ 
		  	$excluir = "<a href='#@' onClick=\"document.removeArquivo.bbh_pro_arquivo.value='".$file."'; document.removeArquivo.bbh_pro_codigo.value='".$_SESSION['idProtocolo']."'; document.removeArquivo.submit();\"><img src='/corporativo/servicos/bbhive/images/excluir.gif' alt='Excluir arquivo' width='17' height='17' border='0'></a>";
		  }

		echo "<tr class='verdana_12'>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'><a href='#@' onClick='javascript: document.getElementById(\"bbh_pro_arquivo\").value=\"".$file."\"; document.abreArquivo.bbh_pro_codigo.value=\"".$_SESSION['idProtocolo']."\"; document.abreArquivo.submit();'><img src='/corporativo/servicos/bbhive/images/download.gif' alt='Download do arquivo' width='17' height='17' border='0'></a></td>
                <td width='90%' align='left' bgcolor='#FFFFFF' class='verdana_11' style='border-bottom:#cccccc solid 1px;'>&nbsp;".$file."</td>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'>&nbsp;</td>
              </tr>
              <tr>
                <td height='1' colspan='3' align='right' background='/servicos/bbhive/images/separador.gif'></td>
              </tr>";
$cont++; 
		if ($cont == 300) {
		die;
		}
     }
  }
 closedir($handle);
}
?> 
<?php if($cont==0){?>
  <tr>
    <td height="20" colspan="3" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe arquivos digitalizados</td>
  </tr>
<?php } ?>
</table><br />
<table width="605" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="legandaLabel11">
	<?php 
	$impressao = true;
	require_once("../indicios/index.php");
	?>
    </td>
  </tr>
</table>
<?php /*
<table width="566" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="4" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" alt="" align="absmiddle" />&nbsp;<strong>Ind&iacute;cios cadastrados</strong></td>
  </tr>
  <?php $cod=0; $dep=0;
  while($row_ind = mysqli_fetch_assoc($ind)){
  	if($dep!=$row_ind['bbh_dep_codigo']){
  ?>
  <tr>
    <td height="20" colspan="4" class="titulo_setor" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><?php echo $row_ind['bbh_dep_nome']; ?></td>
  </tr>
  <?php }
  if($cod!=$row_ind['bbh_tip_codigo']){ 
  		$txt = explode("*|*",$row_ind['bbh_tip_campos']);
		$cp1 = !empty($txt[0]) ? $txt[0] : "Campo1";
		$cp2 = !empty($txt[1]) ? $txt[1] : "Campo2";
  ?>
  <tr>
    <td height="20" colspan="4" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;&nbsp;&nbsp;<strong><u><?php echo $row_ind['bbh_tip_nome']; ?></u></strong></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="3" class="legandaLabel11" style="border-bottom:#cccccc solid 1px; border-right:#cccccc solid 1px;">
    <?php echo "<strong>".$cp1 . "</strong>: ".$row_ind['bbh_ind_campo1']; ?>
    </td>
  </tr>
  <tr>
    <td height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="3" class="legandaLabel11" style="border-bottom:#cccccc solid 1px; border-right:#cccccc solid 1px;">
    <?php echo "<strong>".$cp2 . "</strong>: ".$row_ind['bbh_ind_campo2']; ?>
    </td>
  </tr>
  <tr>
    <td height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="3" class="legandaLabel11" style="border-bottom:#cccccc solid 1px; border-right:#cccccc solid 1px;">
      	<div style="float:left"><strong>Quantidade</strong>:&nbsp;<?php echo $row_ind['bbh_ind_quantidade']; ?></div>
        <div style="float:left; margin-left:100px;"><strong>Unidade de medida</strong>:&nbsp;<?php echo unidadeMedida($row_ind['bbh_ind_unidade'], 1); ?></div>
    </td>
  </tr>
  <tr>
    <td width="29" height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td width="409" height="20" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></td>
    <td width="128" height="20" colspan="2" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;border-right:#cccccc solid 1px;" title="Código de barras"><?php echo $cd=$row_ind['bbh_ind_codigo_barras']; ?>&nbsp;</td>
  </tr>
  <?php $cod=$row_ind['bbh_tip_codigo']; $dep=$row_ind['bbh_dep_codigo'];
  } ?>
  <?php if($totalRows_ind==0){?>
  <tr>
    <td height="20" colspan="4" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe registros cadastrados</td>
  </tr>
  <?php } ?>
</table> */
?>

<script type="text/javascript">
//window.print();
</script>
</body>
</html>