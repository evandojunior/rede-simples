<?php
	$query_strProtocolos = "SELECT bbh_protocolos.*, bbh_dep_nome, 
				 (
				  select count(i.bbh_pro_codigo) from bbh_indicio i where i.bbh_pro_codigo = bbh_protocolos.bbh_pro_codigo
				 ) as total from bbh_protocolos 
		  inner join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo WHERE bbh_protocolos.bbh_flu_codigo = $bbh_flu_codigo ORDER BY bbh_pro_codigo DESC";
    list($strProtocolos, $rows, $totalRows_strProtocolos) = executeQuery($bbhive, $database_bbhive, $query_strProtocolos, $initResult = false);
?><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/protocolo.gif" border="0" align="absmiddle" />&nbsp;<strong>(<?php echo $totalRows_strProtocolos; ?>) <?php echo($_SESSION['ProtNome']); ?> desta(e) <?php echo $_SESSION['FluxoNome']; ?></strong>
    </td>
  </tr>
  </table>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border-left:#E6E6E6 solid 1px;border-right:#E6E6E6 solid 1px;border-bottom:#E6E6E6 solid 1px;" class="legandaLabel11">
  <tr>
    <td width="55" height="25" align="left" bgcolor="#F0F0F0"><strong>&nbsp;N.&ordm;</strong></td>
    <td width="122" align="left" bgcolor="#F0F0F0"><strong><?php echo ($_SESSION['ProtOfiNome']);?></strong></td>
    <td width="220" align="left" bgcolor="#F0F0F0"><strong><?php echo($_SESSION['ProtSolNome']);?></strong></td>
    <td width="120" align="left" bgcolor="#F0F0F0"><strong>Criado em</strong></td>
    <td width="81" align="left" bgcolor="#F0F0F0"><strong>Situa&ccedil;&atilde;o</strong></td>
  </tr>
  <tr>
    <td height="1" colspan="5" align="center" bgcolor="#CCCCCC"></td>
  </tr>
 <?php while($row_strProtocolos = mysqli_fetch_assoc($strProtocolos)){
	 $codProtocolo = $row_strProtocolos['bbh_pro_codigo'];
	//status com base no vetor
	$codSta		= $row_strProtocolos['bbh_pro_status'];
	$cada	 	= explode("|",$status[$codSta]);
	$situacao 	= $cada[0];
	$corFundo 	= $cada[1];
	
	$corFonte	= $row_strProtocolos['bbh_pro_flagrante'] == "1" ? "#F00" : "#000";
	$situacao	= $row_strProtocolos['bbh_pro_flagrante'] == "1" ? "Flagrante - ".$situacao : $situacao;
	?>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td align="left" valign="top">&nbsp;<strong><?php echo $codProtocolo; ?></strong></td>
    <td align="left" valign="top"><img src="/corporativo/servicos/bbhive/images/setaIII.gif" width="4" height="8">&nbsp;<?php echo $a=$row_strProtocolos['bbh_pro_titulo']; ?></td>
    <td align="left" valign="top"><?php echo $a=$row_strProtocolos['bbh_pro_identificacao']; ?></td>
    <td align="left" valign="top"><?php echo arrumadata(substr($row_strProtocolos['bbh_pro_momento'],0,10))." ".substr($row_strProtocolos['bbh_pro_momento'],11,5); ?></td>
    <td height="25" align="left" valign="top"><strong><?php echo $situacao; ?></strong></td>
  </tr>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td height="2" colspan="5" align="right" valign="top" bgcolor="#FFFFFF"><?php
    	include("protocolo/anexos.php"); 
		include("protocolo/indicios.php");
	?></td>
  </tr>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td height="2" colspan="5" align="left" valign="top" bgcolor="#FFFFFF"></td>
  </tr>
  <?php } ?>
</table>
  