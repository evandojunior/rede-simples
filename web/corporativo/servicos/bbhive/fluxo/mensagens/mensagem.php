<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

		
//recupera o código da mensagem
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_men_codigo")||($indice=="bbh_men_codigo")){ $bbh_men_codigo=$valor; }
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $cdFluxo = $bbh_flu_codigo=$valor; }
}

	$query_mensagens = "
					select 
					 m.bbh_men_codigo,
					 m.bbh_flu_codigo,
					 date_format(m.bbh_men_data_recebida,'%d/%m/%Y %H:%i') as momento,
					 date_format(m.bbh_men_data_leitura,'%d/%m/%Y %H:%i') as data_leitura,
					 m.bbh_men_assunto as assunto,
					 m.bbh_men_mensagem as mensagem,
					 r.bbh_usu_apelido as remetente,
					 r.bbh_usu_codigo as cdremetente,
					 d.bbh_usu_apelido as destinatario,
					 d.bbh_usu_codigo as cddestinatario
					 
					  from bbh_mensagens as m
						inner join bbh_usuario as r on m.bbh_usu_codigo_remet  = r.bbh_usu_codigo
						inner join bbh_usuario as d on m.bbh_usu_codigo_destin = d.bbh_usu_codigo
						
						  WHERE m.bbh_men_codigo = $bbh_men_codigo";
    list($mensagens, $row_mensagens, $totalRows_mensagens) = executeQuery($bbhive, $database_bbhive, $query_mensagens);
	
	if(($row_mensagens['data_leitura']=="00/00/0000" || $row_mensagens['data_leitura'] == NULL) && ($row_mensagens['cddestinatario'] == $_SESSION['usuCod'])){
		//MARCA HORÁRIO DE MENSAGEM LIDA
		$dataleitura = date('Y-m-d H:i:s');	
		$updateSQL = "UPDATE bbh_mensagens SET bbh_men_data_leitura= '$dataleitura' WHERE bbh_men_codigo = $bbh_men_codigo";

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	}

//Mensagem
 $detalheMensagem=true;
//ordem do menu
  require_once("menu/menu_ordem.php");
  
 
	$voltar = "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=".$bbh_flu_codigo."&exibeMensagem=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
	$compl = "&voltaFluxo=true";

//menu
  require_once("menu/menu.php");
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td colspan="2" height="27" background="/corporativo/servicos/bbhive/images/back_msg.jpg"><img src="/corporativo/servicos/bbhive/images/texto.gif" width="16" height="16" align="absmiddle" style="margin-left:5px;" /> <strong><?php echo $row_mensagens['assunto']; ?></strong>
    <label style="float:right; margin-top:-15px; margin-right:50px" class="verdana_11 color" id="loadMsg">&nbsp;</label>    </td>
    <td width="84" background="/corporativo/servicos/bbhive/images/back_msg.jpg"><a href="#@" onclick="return <?php echo $voltar; ?>;">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
   	  <span class="color"><strong>Voltar</strong></span>	</a></td>
  </tr>
  <tr>
    <td height="1" colspan="3" bgcolor="#FFFFFF"></td>
  </tr>
  
  <tr>
    <td width="70" height="25" align="right" bgcolor="#FBFBFB" class="color" style="border-left:#E4E6E9 solid 1px;border-top:#E4E6E9 solid 1px;">De :&nbsp;</td>
    <td width="441" height="25" align="left" bgcolor="#FBFBFB" class="color" style="border-left:#E4E6E9 solid 1px;border-top:#E4E6E9 solid 1px;">&nbsp;<?php echo strtoupper($row_mensagens['remetente']); ?></td>
    <td height="25" align="left" bgcolor="#FBFBFB" class="color" style="border-top:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;"><input type="hidden" name="bbh_men_codigo" id="bbh_men_codigo" value="<?php echo @$_GET['bbh_men_codigo']; ?>" />
      <input name="deleteMessage" type="hidden" id="deleteMessage" value="1" />
      <input type="hidden" name="bbh_usu_codigo_destin" id="bbh_usu_codigo_destin" value="<?php echo $row_mensagens['cddestinatario']; ?>" />
      <input type="hidden" name="bbh_usu_codigo_remet" id="bbh_usu_codigo_remet" value="<?php echo $row_mensagens['cdremetente']; ?>" />
      </td>
    </tr>
  <tr>
    <td height="1" colspan="3" background="/corporativo/servicos/bbhive/images/separador.gif" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;"></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg" style="border-left:#E4E6E9 solid 1px;border-bottom:#E4E6E9 solid 1px;">Para :&nbsp;</td>
    <td height="25" colspan="2" valign="middle" bgcolor="#FBFBFB" id="corpo_msg" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;">&nbsp;<strong><?php echo strtoupper($row_mensagens['destinatario']); ?></strong></td>
    </tr>
<?php if($row_mensagens['bbh_flu_codigo']>0){ 
	//--Descobe título da mensagem
		$sqlFluxo = "select bbh_flu_codigo, bbh_flu_titulo, concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) as caso from bbh_fluxo where bbh_flu_codigo=".$row_mensagens['bbh_flu_codigo'];
        list($fluxo, $row_fluxo, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $sqlFluxo);
	?> 
  <tr>
    <td height="25" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg3" style="border-left:#E4E6E9 solid 1px;border-bottom:#E4E6E9 solid 1px;"><strong><?php echo $p=mysqli_fetch_assoc($_SESSION['FluxoNome']); ?></strong>&nbsp;:</td>
    <td height="25" colspan="2" valign="middle" bgcolor="#FBFBFB" id="corpo_msg3" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;">&nbsp;<?php echo $row_fluxo['bbh_flu_titulo'].' - '.$row_fluxo['caso']; ?><input name="bbh_flu_codigo" type="hidden" id="bbh_flu_codigo" value="<?php echo $row_fluxo['bbh_flu_codigo']; ?>" /></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="25" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg2" style="border-left:#E4E6E9 solid 1px;"><strong>Assunto</strong> :&nbsp; </td>
    <td height="25" colspan="2" valign="middle" bgcolor="#FBFBFB" id="corpo_msg2" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;">&nbsp;<strong><?php echo $row_mensagens['assunto']; ?></strong></td>
    </tr>
  <tr>
    <td height="1" colspan="3" background="/corporativo/servicos/bbhive/images/separador.gif" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;"></td>
  </tr>
  <tr>
    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#FBFBFB" id="corpo_msg6" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;"><strong>&nbsp;Conte&uacute;do da mensagem:</strong></td>
    </tr>
  <tr>
    <td height="250" colspan="3" align="left" valign="top" bgcolor="#FBFBFB" id="corpo_msg4" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;"><div style="margin:10px;"><?php echo nl2br($row_mensagens['mensagem']); ?></div></td>
  </tr>
</table><label style="position:absolute" id="enviaMSG" class="color">&nbsp;</label>
<?php
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a página de visualização de mensagem (" . $bbh_men_codigo ." - " . $row_mensagens['assunto'] . ") - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/ 
?>