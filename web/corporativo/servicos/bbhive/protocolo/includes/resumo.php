<?php
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/protocolo/detalhamento/includes/functions.php");

	$dr = str_replace("\\","/",explode("web",dirname(__FILE__)));

	//POIS VOU REDIRECIONAR PARA O OK.PHP
	$arquivo = $dr[0]."web/datafiles/servicos/bbhive/setup/config.xml";
	
	//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($arquivo);
		//-----	

		//--
		$root = $doc->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		//$detalhamento 	= $prot->getAttribute("detalhamento");
		
//recuperação de variáveis do GET e SESSÃO
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_pro_codigo")||($indice=="bbh_pro_codigo")){ $bbh_pro_codigo = $valor; }
}

//dados do protocolo
	$query_strProtocolo = "SELECT bbh_protocolos.*, bbh_dep_nome, r.bbh_usu_apelido, u.bbh_usu_apelido as protocolado from bbh_protocolos 
		  inner join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
		  left join bbh_usuario as r on bbh_protocolos.bbh_pro_recebido = r.bbh_usu_identificacao 
		  left join bbh_usuario as u on bbh_protocolos.bbh_pro_email = u.bbh_usu_identificacao
		  	Where bbh_pro_codigo = $bbh_pro_codigo";
    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);

		$bbh_flu_codigo = $row_strProtocolo['bbh_flu_codigo'];
		$codSta			= $row_strProtocolo['bbh_pro_status'];
		$cada	 		= explode("|",$status[$codSta]);
		$situacao 		= $cada[0];
		$corFundo 		= $cada[1];

/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de protocolo de " . $_SESSION['FluxoNome'] . " (" . $bbh_flu_codigo . ") - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/		

?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIVI.gif" border="0" align="absmiddle" />&nbsp;<strong><?php echo converte($_SESSION['ProtNome']); ?>  DE SERVI&Ccedil;OS BBHIVE</strong></td>
  </tr>
  </table>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECFFEC" style="border-left:#E6E6E6 solid 1px;border-right:#E6E6E6 solid 1px;border-bottom:#E6E6E6 solid 1px;">
  <tr>
    <td width="25" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/nome.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td colspan="2" class="legandaLabel16" style="color:#F60"><strong>&nbsp;N&Uacute;MERO 
        <?php echo $bbh_pro_codigo; ?></strong></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td width="23" align="center"><img src="/corporativo/servicos/bbhive/images/numero.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td width="552" class="legandaLabel16" style="color:#36C">&nbsp;<strong><?php echo converte($_SESSION['ProtOfiNome']);?>: <?php echo $titOficio = $row_strProtocolo['bbh_pro_titulo']; ?></strong></td>
  </tr>
</table>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel12" style="margin-top:10px;">
  <tr>
    <td width="35" height="25" class="titulo_setor" align="center"><img src="/corporativo/servicos/bbhive/images/visualizar.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td colspan="3" class="titulo_setor legandaLabel12">&nbsp;<strong>Dados b&aacute;sicos</strong></td>
  </tr>
  <tr>
    <td height="25" colspan="4" align="left">
<fieldset style="margin-top:2px; margin-bottom:2px;">
        <legend class="legandaLabel11">Informa&ccedil;&otilde;es complementares</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
          <tr style="background-color:<?php echo $corFundo; ?>">
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/engrenagem.gif" alt="" border="0" align="absmiddle"></td>
            <td height="25"><strong>Situa&ccedil;&atilde;o: <span style="color:#033"><?php echo strtoupper($situacao); ?></span></strong></td>
          </tr>
          <?php if($codSta!="1") { ?>
          <tr>
            <td height="25" align="center">&nbsp;</td>
            <td height="25"><strong>Recebido por:<span style="color:#F60"></span></strong></td>
          </tr>
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" /></td>
            <td><?php echo !empty($row_strProtocolo['bbh_usu_apelido']) ? $row_strProtocolo['bbh_usu_apelido'] : $row_strProtocolo['bbh_pro_recebido']; ?></td>
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
  <tr>
    <td height="25" colspan="2" align="left" class="verdana_11"><strong>&nbsp;Criado em :&nbsp;</strong></td>
    <td width="626" colspan="2" class="verdana_11">&nbsp;<span class="color"><strong><?php echo arrumadata(substr($row_strProtocolo['bbh_pro_momento'],0,10)) . " " . substr($row_strProtocolo['bbh_pro_momento'],11,5); ?></strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#F5F5F5" class="verdana_11"><strong>&nbsp;Protocolado por :&nbsp;</strong></td>
    <td colspan="2" bgcolor="#F5F5F5" class="verdana_11"><span class="color"><strong>&nbsp;<?php echo !empty($row_strProtocolo['protocolado']) ? $row_strProtocolo['protocolado'] : $row_strProtocolo['bbh_pro_email']; ?></strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="4" align="left" valign="middle" bgcolor="#FFFFFF"><?php require_once($dr[0]."web/corporativo/servicos/bbhive/protocolo/detalhamento/lista.php");?></td>
  </tr>

  <tr>
    <td height="5"><span style="font-size:4px;">&nbsp;</span></td>
    <td width="195"><span style="font-size:4px;">&nbsp;</span></td>
    <td colspan="2"><span style="font-size:4px;">&nbsp;</span></td>
  </tr>
</table>
<input type="hidden" name="bbh_pro_codigo" id="bbh_pro_codigo" value="<?php echo $bbh_pro_codigo; ?>" />
<br />