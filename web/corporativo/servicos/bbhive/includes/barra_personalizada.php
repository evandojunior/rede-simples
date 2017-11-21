<?php
	$query_strProtocolos = "SELECT bbh_per_codigo, bbh_protocolos.*, bbh_dep_nome FROM bbh_protocolos 
					  left join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo 
					  left join bbh_usuario on bbh_protocolos.bbh_pro_email = bbh_usuario.bbh_usu_identificacao
					  left join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
					  
					  WHERE 
					   bbh_protocolos.bbh_dep_codigo = (select bbh_dep_codigo from bbh_usuario where bbh_usu_identificacao = '".$_SESSION['MM_User_email']."')						
						AND (bbh_pro_status = '1' OR bbh_pro_status = '2' OR bbh_pro_status = '3' OR bbh_pro_status = '7')
						 group by bbh_protocolos.bbh_pro_codigo
						  ORDER BY bbh_pro_codigo DESC";
    list($strProtocolos, $row_strProtocolos, $totalRows_strProtocolos) = executeQuery($bbhive, $database_bbhive, $query_strProtocolos);

?><?php if($totalRows_strProtocolos>0 && $Protocolo==1) { ?>
<fieldset style="width:95%; margin-left:5px;">
	<legend class="legandaLabel16"><strong><?php echo ($_SESSION['ProtLeg']); ?> (<?php echo $totalRows_strProtocolos; ?>)</strong></legend>
    <?php /*
    <div id="exibe" style="display:none; background-color:#EED7A1; height:22px; line-height:22px; cursor:pointer; font-weight:bold;" class="verdana_12" align="center" onclick="this.style.display='none'; document.getElementById('oculta').style.display='block'; document.getElementById('exibeProtocolo').style.display='block';">Clique aqui para expandir a lista de <?php echo ($_SESSION['protNome']); ?></div>
    
  <div id="oculta" style="display:block; background-color:#EED7A1; height:22px; line-height:22px; cursor:pointer; font-weight:bold;" class="verdana_12" align="center" onclick="this.style.display='none'; document.getElementById('exibe').style.display='block'; document.getElementById('exibeProtocolo').style.display='none';">Clique aqui para ocultar a lista de <?php echo($_SESSION['ProtNome']); ?></div> */ ?>
  
    <div id="exibeProtocolo" style="display:block">
    <div class="verdana_11">
    <?php require_once("protocolo/menu.php");?>
    </div>
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#E0DFE3" style="margin-top:5px;" class="verdana_11">
      <tr>
        <td width="70" bgcolor="#F7F7F9"><strong><?php echo ($_SESSION['protNome']); ?></strong></td>
        <td width="176" height="22" bgcolor="#F7F7F9"><strong><?php echo $_SESSION['ProtOfiNome']; ?></strong></td>
        <td width="178" bgcolor="#F7F7F9"><strong><?php echo $_SESSION['ProtIdentificacao']; ?></strong></td>
        <td width="100" bgcolor="#F7F7F9"><strong>Criado em</strong></td>
        <td width="20" bgcolor="#F7F7F9">&nbsp;</td>
      </tr>
<?php 
	  do { 
	  $codProtocolo = $row_strProtocolos['bbh_pro_codigo'];
		
		//status com base no vetor
		$codSta		= $row_strProtocolos['bbh_pro_status'];
		$cada	 	= explode("|",$status[$codSta]);
		$situacao 	= $cada[0];
		$corFundo 	= $cada[1];
		
		$corFonte	= $row_strProtocolos['bbh_pro_flagrante'] == "1" ? "#F00" : "#000";
		$situacao	= $row_strProtocolos['bbh_pro_flagrante'] == "1" ? $_SESSION['FlagNome']." - ".$situacao : $situacao;
	  /*
		  1 - iniciou fluxo
		  2 - aguardando
		  3 - indeferido
	  */
	  /*if($row_strProtocolos['bbh_pro_status']=="1"){
	     $codProtocolo = $row_strProtocolos['bbh_flu_codigo'];
		 include('andamentoProtocolo.php');
	  } elseif($row_strProtocolos['bbh_pro_status']=="2") {
	  	$andamento = "<label style='color:#666'>Aguardando</label>";
	  } elseif($row_strProtocolos['bbh_pro_status']=="3") {
	  	$andamento = "<label class='aviso'>Indefirido</label>";
	  } else {
	  	$andamento = "<label class='color'>&nbsp;S/Info</label>";
	  }*/
	  ?>
        <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>" >
           <td><?php echo $codProtocolo; ?></td>
           <td height="22">&nbsp;<img src="/corporativo/servicos/bbhive/images/setaIII.gif" width="4" height="8">&nbsp;<?php echo $a=$row_strProtocolos['bbh_pro_titulo']; ?></td>
          <td>&nbsp;<?php echo $a=$row_strProtocolos['bbh_pro_identificacao']; ?></td>
          <td>&nbsp;<?php echo arrumadata(substr($row_strProtocolos['bbh_pro_momento'],0,10))." ".substr($row_strProtocolos['bbh_pro_momento'],11,5); ?></td>
          <td align="center"><a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $row_strProtocolos['bbh_pro_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/corporativo/servicos/bbhive/images/editarII.gif" width="16" height="16" border="0"></a></td>
        </tr>
        <?php } while ($row_strProtocolos = mysqli_fetch_assoc($strProtocolos)); ?>
    </table>
    </div>
</fieldset>
<br><?php } else{ ?>
<span class="verdana_12">
Aguarde redirecionando para página de consulta...</span>
<var style="display:none">showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php','menuEsquerda|conteudoGeral');</var>
<?php } ?><br>