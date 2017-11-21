<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");


	//****VERIFICO DE O XML EXISTE, CASO O MESMO NÃO EXISTA CRIO ELE NO ADMINISTRATIVO, 
	//POIS VOU REDIRECIONAR PARA O OK.PHP
	$arquivo = "../../../../../datafiles/servicos/bbhive/setup/config.xml";

	//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($arquivo);
		//-----	
		$root = $doc->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		$mensagens_com_fluxo = $prot->getAttribute("mensagens_com_fluxo");
		
//recupera o código da mensagem
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_men_codigo")||($indice=="bbh_men_codigo")){ $bbh_men_codigo=$valor; }
	if(($indice=="amp;usu_destino")||($indice=="usu_destino")){ $usu_destino=$valor; }
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
	$query_destinatario = "SELECT bbh_usuario.bbh_usu_apelido, bbh_usuario.bbh_usu_identificacao, bbh_usuario.bbh_usu_codigo FROM bbh_usuario Where bbh_usu_codigo=".$usu_destino;
    list($destinatario, $row_destinatario, $totalRows_destinatario) = executeQuery($bbhive, $database_bbhive, $query_destinatario);
 //----
 
 
 //Caixa de Entrada
 $novaMensagem=true;
 
 //ordem do menu
  require_once("../menu/menu_ordem.php");
	
	$bbh_flu_codigo = isset($_GET['bbh_flu_codigo']) ? $_GET['bbh_flu_codigo'] : 0;
	
	$voltar = "LoadSimultaneo('perfil/index.php?perfil=1&mensagens=1|mensagens/index.php?caixaEntrada=True|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita')";
	$compl = "";
		if($bbh_flu_codigo > 0){
			$voltar = "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=".$bbh_flu_codigo."|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
			$compl = "&voltaFluxo=true";
		}
		
	$homeDestino = "/corporativo/servicos/bbhive/mensagens/envio/executa.php";
	$onclick = "OpenAjaxPostCmd('".$homeDestino."?TS=".time()."','enviaMSG','formMsg','Carregando...','enviaMSG','1','2')";
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1.1";
	$Evento="Acessou a página de encaminhamento da mensagem - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/ 

$sqlFluxo = "select f.bbh_flu_codigo, f.bbh_flu_titulo,
						 concat(f.bbh_flu_autonumeracao,'/',f.bbh_flu_anonumeracao) as caso,
			(select count(a.bbh_ati_codigo) 
				from bbh_atividade as a where a.bbh_flu_codigo = f.bbh_flu_codigo and a.bbh_usu_codigo=".$_SESSION['usuCod'].") as prof1,
			(select count(a.bbh_ati_codigo) 
				from bbh_atividade as a where a.bbh_flu_codigo = f.bbh_flu_codigo and a.bbh_usu_codigo=$usu_destino) as prof2
		 from bbh_fluxo as f
		   where f.bbh_flu_codigo = '".$row_mensagens['bbh_flu_codigo']."'
		  having prof1 > 0 and prof2 > 0 
		   order by bbh_flu_titulo asc";
        list($fluxo, $rows, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $sqlFluxo, $initResult = false);
		
	if($totalRows_fluxo==0){
		echo "<div class='verdana_12' align='center'>Não é permitido enviar mensagem deste processo para este profissional, escolha uma das opções abaixo.<br><br>";
		$Equipe		= "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=0&prestadores=0&todosEmpresa=1&bbh_men_codigo=".$bbh_men_codigo."|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&exibeMensagem=true&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
		$Msg = "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&amp;mensagens=1|mensagens/mensagem.php?bbh_men_codigo=".$bbh_men_codigo."&|includes/colunaDireita.php?fluxo=1&amp;equipe=1&amp;arquivos=1&amp;relatorios=1','menuEsquerda|colCentro|colDireita');";
		
		echo '<a href="#@" onClick="'.$Equipe.'"><img src="/corporativo/servicos/bbhive/images/encaminhar.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> Encaminhar para outro profissional</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		//--
		echo '<a href="#@" onClick="'.$Msg.'"><img src="/corporativo/servicos/bbhive/images/encaminhar.gif" alt="" width="16" height="16" border="0" align="absmiddle" />Voltar para mensagem</a>';
		echo "</div>";
		exit;	
	}
?>
<form id="formMsg" name="formMsg" style="margin-top:-1">
<?php
//menu
  require_once("../menu/menu.php");
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="27" colspan="2" background="/corporativo/servicos/bbhive/images/back_msg.jpg"><img src="/corporativo/servicos/bbhive/images/msg.gif" width="15" height="14" align="absmiddle" style="margin-left:5px;" /> <strong>Encaminhar <?php echo $_SESSION['MsgNome']; ?></strong>
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
    <td height="25" colspan="2" valign="middle" bgcolor="#FBFBFB" id="corpo_msg" style="border-left:#E4E6E9 solid 1px;border-right:#E4E6E9 solid 1px; border-bottom:#E4E6E9 solid 1px;">&nbsp;<strong><?php echo strtoupper($row_destinatario['bbh_usu_apelido']);?>
      <input type="hidden" name="bbh_usu_destino" id="bbh_usu_destino" value="<?php echo $usu_destino; ?>" />
    </strong></td>
    </tr>
<?php if($mensagens_com_fluxo=="1" && $row_mensagens['bbh_flu_codigo']>0){ 
	//--Descobe título da mensagem
		$sqlFluxo = "select bbh_flu_codigo, bbh_flu_titulo, concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) as caso from bbh_fluxo where bbh_flu_codigo=".$row_mensagens['bbh_flu_codigo'];
        list($fluxo, $row_fluxo, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $sqlFluxo);
	?> 
  <tr>
    <td height="25" align="right" valign="middle" bgcolor="#FBFBFB" id="corpo_msg3" style="border-left:#E4E6E9 solid 1px;border-bottom:#E4E6E9 solid 1px;"><strong><?php echo $p=$_SESSION['FluxoNome']; ?></strong>&nbsp;:</td>
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
      <input type="button" name="Cancelar" id="Cancelar" value="&nbsp;&nbsp;&nbsp;&nbsp;Cancelar envio" class="cancelar" onclick="return <?php echo $voltar; ?>;" />      <input type="button" class="confirma" name="Enviar" id="Enviar" value="&nbsp;&nbsp;&nbsp;&nbsp;Confirmar envio" onclick="if(document.getElementById('bbh_men_assunto').value==''){alert('Informe o assunto!');}else{<?php echo $onclick; ?>}" /></td>
  </tr>
</table><label style="position:absolute;" id="enviaMSG" class="color verdana_12">&nbsp;</label>
</form>