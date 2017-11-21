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
					 d.bbh_usu_apelido as destinatario
					 
					  from bbh_mensagens as m
						inner join bbh_usuario as r on m.bbh_usu_codigo_remet  = r.bbh_usu_codigo
						inner join bbh_usuario as d on m.bbh_usu_codigo_destin = d.bbh_usu_codigo
						
						  WHERE m.bbh_men_codigo = $bbh_men_codigo";
    list($mensagens, $row_mensagens, $totalRows_mensagens) = executeQuery($bbhive, $database_bbhive, $query_mensagens);

 //Destinatário da mensagem
	$query_destinatario = "SELECT bbh_usuario.bbh_usu_apelido, bbh_usuario.bbh_usu_identificacao, bbh_usuario.bbh_usu_codigo FROM bbh_usuario INNER JOIN bbh_atividade ON bbh_usuario.bbh_usu_codigo = bbh_atividade.bbh_usu_codigo WHERE bbh_flu_codigo = $bbh_flu_codigo GROUP BY bbh_usuario.bbh_usu_codigo";
    list($destinatario, $row_destinatario, $totalRows_destinatario) = executeQuery($bbhive, $database_bbhive, $query_destinatario);
 //----
 
 
 //Caixa de Entrada
 $novaMensagem=true;
 
 //ordem do menu
  require_once("../menu/menu_ordem.php");
	
	$bbh_flu_codigo = $bbh_flu_codigo;
	
	$voltar = "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=".$bbh_flu_codigo."&exibeMensagem=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
	$compl = "&voltaFluxo=true";
		
	$homeDestino = "/corporativo/servicos/bbhive/fluxo/mensagens/envio/executa.php";
	$onclick = "OpenAjaxPostCmd('".$homeDestino."?TS=".time()."','enviaMSG','updateFluxo','Carregando...','enviaMSG','1','2')";
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1.1";
	$Evento="Acessou a página de encaminhamento da mensagem - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/ 

//menu
  require_once("../menu/menu.php");
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="27" colspan="2" background="/corporativo/servicos/bbhive/images/back_msg.jpg"><img src="/corporativo/servicos/bbhive/images/msg.gif" width="15" height="14" align="absmiddle" style="margin-left:5px;" /> <strong>Encaminhar <?php echo mysqli_fetch_assoc($_SESSION['MsgNome']); ?></strong>
    <label style="float:right; margin-top:-15px; margin-right:50px" class="verdana_11 color" id="loadMsg">&nbsp;</label>    </td>
    <td width="74" background="/corporativo/servicos/bbhive/images/back_msg.jpg">    <a href="#@" onclick="return <?php echo $voltar; ?>;">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    	<span class="color"><strong>Voltar</strong></span>	</a></td>
  </tr>
  <tr>
    <td height="1" colspan="3" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td width="96" height="25" align="right" bgcolor="#FBFBFB" class="color" style="border-left:#E4E6E9 solid 1px;border-top:#E4E6E9 solid 1px;">De :&nbsp;</td>
    <td width="532" height="25" align="left" bgcolor="#FBFBFB" class="color" style="border-left:#E4E6E9 solid 1px;border-top:#E4E6E9 solid 1px;">&nbsp;<?php echo strtoupper($_SESSION['usuNome']); ?></td>
    <td height="25" align="left" bgcolor="#FBFBFB" class="color" style="border-top:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;">&nbsp;</td>
    </tr>
  <tr>
    <td height="1" colspan="3" background="/corporativo/servicos/bbhive/images/separador.gif" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;"></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg" style="border-left:#E4E6E9 solid 1px;border-bottom:#E4E6E9 solid 1px;">Para :&nbsp;</td>
    <td height="25" colspan="2" valign="middle" bgcolor="#FBFBFB" id="corpo_msg" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;">&nbsp;<strong><select name="bbh_usu_destino" class="back_input" id="bbh_usu_destino">
      <option value="-1">Selecione o destinat&aacute;rio</option>
      <option value="-1">-------------------------</option>
      <?php
do {  
?>
      <option value="<?php echo $row_destinatario['bbh_usu_codigo']?>"><?php echo $row_destinatario['bbh_usu_apelido']?></option>
      <?php
} while ($row_destinatario = mysqli_fetch_assoc($destinatario));
  $rows = mysqli_num_rows($destinatario);
  if($rows > 0) {
      mysqli_data_seek($destinatario, 0);
	  $row_destinatario = mysqli_fetch_assoc($destinatario);
  }
?>
    </select>
    </strong></td>
    </tr>
<?php if($row_mensagens['bbh_flu_codigo']>0){ 
	//--Descobe título da mensagem
		$sqlFluxo = "select bbh_flu_codigo, bbh_flu_titulo, concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) as caso from bbh_fluxo where bbh_flu_codigo=".$row_mensagens['bbh_flu_codigo'];
        list($fluxo, $row_fluxo, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $sqlFluxo);
	?> 
  <tr>
    <td height="25" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg3" style="border-left:#E4E6E9 solid 1px;border-bottom:#E4E6E9 solid 1px;"><strong><?php echo $p=mysqli_fetch_assoc($_SESSION['FluxoNome']); ?></strong>&nbsp;:</td>
    <td height="25" colspan="2" valign="middle" bgcolor="#FBFBFB" id="corpo_msg3" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;">&nbsp;<?php echo $row_fluxo['bbh_flu_titulo'].' - '.$row_fluxo['caso']; ?><input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $row_mensagens['bbh_flu_codigo']; ?>" /></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="25" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg2" style="border-left:#E4E6E9 solid 1px;"><strong>Assunto</strong> :&nbsp; </td>
    <td height="25" colspan="2" valign="middle" bgcolor="#FBFBFB" id="corpo_msg2" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;">&nbsp;<input name="bbh_men_assunto" type="text" class="back_Campos" id="bbh_men_assunto" size="60" style="height:20px; line-height:20px;" value="Enc: <?php echo $row_mensagens['assunto']; ?>" /></td>
    </tr>
  <tr>
    <td height="1" colspan="3" background="/corporativo/servicos/bbhive/images/separador.gif" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;"></td>
  </tr>
  <tr>
    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#FBFBFB" id="corpo_msg6" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px;"><strong>&nbsp;Conte&uacute;do da mensagem:</strong></td>
    </tr>
  <tr>
    <td height="25" colspan="3" align="center" valign="top" bgcolor="#FBFBFB" id="corpo_msg4" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;"><textarea name="bbh_men_mensagem" cols="114" rows="20" class="formulario2 verdana_12" id="bbh_men_mensagem">


---
<?php echo ($row_mensagens['mensagem']); ?></textarea></td>
  </tr>
  <tr>
    <td height="25" colspan="3" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg5" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;">
      <input name="MM_EnviaMensagem" type="hidden" id="MM_EnviaMensagem" value="1" />
      <input type="button" name="Cancelar" id="Cancelar" value="&nbsp;&nbsp;&nbsp;&nbsp;Cancelar envio" class="cancelar" onclick="return <?php echo $voltar; ?>;" />      <input type="button" class="confirma" name="Enviar" id="Enviar" value="&nbsp;&nbsp;&nbsp;&nbsp;Confirmar envio" onclick="if(document.getElementById('bbh_men_assunto').value=='' || document.getElementById('bbh_usu_destino').value==-1){alert('Informe o assunto e/ou o destinatário!');}else{<?php echo $onclick; ?>}" /></td>
  </tr>
</table><label style="position:absolute;" id="enviaMSG" class="color verdana_12">&nbsp;</label>