<?php
	$query_strProtocolo = "SELECT bbh_protocolos.*, bbh_dep_nome, r.bbh_usu_nome, u.bbh_usu_nome as protocolado 
			from bbh_protocolos 
		  		inner join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
		  		left join bbh_usuario as r on bbh_protocolos.bbh_pro_recebido = r.bbh_usu_identificacao 
		  		left join bbh_usuario as u on bbh_protocolos.bbh_pro_email = u.bbh_usu_identificacao
		  			Where bbh_pro_codigo =".$_SESSION['idProtocolo'];
    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);
	
	$bbh_flu_codigo = $row_strProtocolo['bbh_flu_codigo'];

	$andamento = "0";
	if($row_strProtocolo['bbh_pro_status']!='3'){
		if($row_strProtocolo['bbh_flu_codigo']!=NULL){
			$codFluxo = $row_strProtocolo['bbh_flu_codigo'];
			$temFluxo = 1;
		} else {
			//ainda está em andamento
			$andamento=0;
		}
	} else {
		//foi indeferido
		$andamento = '-1';
	}
	
	//status com base no vetor
	$codSta		= $row_strProtocolo['bbh_pro_status'];
	$cada	 	= explode("|",$status[$codSta]);
	$situacao 	= $cada[0];
	$corFundo 	= $cada[1];	
?>
<div class="legandaLabel11"><?php if($codSta=="1"){?>
	<a href="#@" onClick="LoadSimultaneo('protocolos/cadastro/editar.php?bbh_pro_codigo=<?php echo $_SESSION['idProtocolo']; ?>','conteudoGeral');"><img src="/servicos/bbhive/images/editar.gif" border="0" align="absmiddle" title="Editar esta solicitação" style="margin-right:2px;"/> Atualizar informações</a> |
<?php	
	if($digitalizar!="dig_nunca"){
		echo '<a href="#@" onClick="LoadSimultaneo(\'protocolos/cadastro/passo2.php?confirmaDigitalizacao=true\',\'conteudoGeral\');"><img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" border="0" align="absmiddle" style="margin-right:2px;"/> Digitaliza&ccedil;&atilde;o</a> |';
	}
	
	if($indicios!="ind_nunca"){
			echo ' <a href="#@" onClick="LoadSimultaneo(\'protocolos/cadastro/passo2.php?confirmaCadastroIndicios=true\',\'conteudoGeral\');"><img src="/servicos/bbhive/images/page_white_add.gif" border="0" align="absmiddle" style="margin-right:2px;"/> Cadastro de '.$_SESSION['componentesNome'].'</a> |';
	}
}	
	if($imprimir!="imp_nunca"){
		echo ' <a href="#@" onClick="LoadSimultaneo(\'protocolos/cadastro/passo2.php?confirmaImpressao=true\',\'conteudoGeral\');"><img src="/servicos/bbhive/images/printII.gif" border="0" align="absmiddle" style="margin-right:2px;"/> Impressão</a>';
	}
?></div>
<?php if($_SERVER['PHP_SELF']!="/servicos/bbhive/protocolos/cadastro/ok.php"){ ?>
<br />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" valign="top" style="border:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td width="62%" bgcolor="#FFFFFF"><span class="legandaLabel16"><strong><?php echo $_SESSION['protNome']; ?> :</strong>&nbsp;<?php echo $row_strProtocolo['bbh_pro_codigo']; ?></span></td>
            <td width="38%" align="right" bgcolor="#FFFFFF" class="legandaLabel11" style="color:#F60"><input type="checkbox" name="exibe" id="exibe" onClick="javascript: if(this.checked==true){document.getElementById('cxCompleta').style.display='block';}else{document.getElementById('cxCompleta').style.display='none';}">
            &nbsp;Visualiza&ccedil;&atilde;o - <?php echo ($_SESSION['protNome']); ?></td>
          </tr>
          <tr>
            <td height="1" colspan="2" valign="top" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F6F6F6" id="cxCompleta" style="display:<?php echo "none";?>">
  <tr>
    <td width="100%" height="5" align="right"></td>
  </tr>
  <tr>
    <td height="25"  align="left">
<table width="930" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="283" height="25" align="left" class="verdana_11"><strong>&nbsp;Data de cadastro :</strong></td>
    <td width="647" height="25" align="left" class="verdana_11"><?php echo $d = arrumadata(substr($row_strProtocolo['bbh_pro_momento'],0,10))." ".substr($row_strProtocolo['bbh_pro_momento'],11,5); ?></td>
  </tr>
</table>
	<?php require_once("../cadastro/detalhamento/lista.php"); ?></td>
    </tr>
</table>
            </td>
          </tr>
          <tr>
            <td height="1" colspan="2" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<br />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/icon_lado.gif" align="absmiddle" />&nbsp;<strong>Situa&ccedil;&atilde;o da solicita&ccedil;&atilde;o</strong>
      <label style="margin-left:205px;"></label>
    </td>
  </tr>
  <tr>
    <td height="20" valign="top" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<fieldset style="margin-top:2px; margin-bottom:2px;">
                    <legend class="legandaLabel11">Informa&ccedil;&otilde;es - <?php echo ($_SESSION['protNome']); ?></legend>
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
                <td height="25" colspan="2" align="left">
                	<?php require_once('fluxo.php'); ?>
                </td>
              </tr>
		   <?php } ?>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php } ?>