<?php
$compl = isset($bbh_pro_codigoInd) ? "bbh_protocolos.bbh_pro_codigo=".$bbh_pro_codigoInd : "bbh_protocolos.bbh_flu_codigo = $bbh_flu_codigo OR bbh_protocolos.bbh_flu_pai = $bbh_flu_codigo "; 

	$query_strProtocolos = "SELECT bbh_protocolos.*, bbh_dep_nome, 
				 (
				  select count(i.bbh_pro_codigo) from bbh_indicio i where i.bbh_pro_codigo = bbh_protocolos.bbh_pro_codigo
				 ) as total from bbh_protocolos 
		  inner join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo WHERE $compl ORDER BY bbh_pro_codigo DESC";
    list($strProtocolos, $row_strProtocolos, $totalRows_strProtocolos) = executeQuery($bbhive, $database_bbhive, $query_strProtocolos, $initResult = false);

$compl = "";
$strAud= "";
if(($indice=="amp;bbh_flu_codigo_p")||($indice=="bbh_flu_codigo_p")){ $bbh_flu_codigo_p=$valor; }
if(isset($bbh_flu_codigo_p)){ $compl = "&bbh_flu_codigo_p=".$bbh_flu_codigo_p; }	
	
$onLink = "onClick=\"return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/regra.php?bbh_flu_codigo=x".$compl."','menuEsquerda|conteudoGeral');\"";	
	
?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/protocolo.gif" border="0" align="absmiddle" />&nbsp;<strong><?php if(isset($titIndicio)){ echo $titIndicio; } else { ?>(<?php echo $totalRows_strProtocolos; ?>) <?php echo($_SESSION['ProtNome']); ?> deste <?php echo $_SESSION['FluxoNome']; } ?><div align="right" style="text-align:right; margin-top:-15px;"> <a href="#@" <?php echo str_replace("bbh_flu_codigo=x","bbh_flu_codigo=".$bbh_flu_codigo,$onLink); ?> style="color:#2550B1;">Atualizar lista de <?php echo strtolower(($_SESSION['ProtNome'])); ?> de <?php echo strtolower($_SESSION['FluxoNome']); ?></a></div></strong></td>
  </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="display:block;border-left:#E6E6E6 solid 1px;border-right:#E6E6E6 solid 1px;border-bottom:#E6E6E6 solid 1px;" class="legandaLabel11">
  <tr>
    <td width="55" height="25" align="left" bgcolor="#F0F0F0"><strong>&nbsp;N.&ordm;</strong></td>
    <td width="164" align="left" bgcolor="#F0F0F0"><strong><?php echo ($_SESSION['ProtOfiNome']);?></strong></td>
    <td width="197" align="left" bgcolor="#F0F0F0"><strong><?php echo($_SESSION['ProtSolNome']);?></strong></td>
    <td width="115" align="left" bgcolor="#F0F0F0"><strong>Criado em</strong></td>
    <td colspan="3" align="center" bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
  </tr>
 <?php 
 $p=0;
 while($row_strProtocolos = mysqli_fetch_assoc($strProtocolos)){
	//--
	$codProtocolo = $row_strProtocolos['bbh_pro_codigo'];
	//status com base no vetor
	$codSta		= $row_strProtocolos['bbh_pro_status'];
	$cada	 	= explode("|",$status[$codSta]);
	$situacao 	= $cada[0];
	$corFundo 	= $cada[1];
	//--
	$corFonte	= $row_strProtocolos['bbh_pro_flagrante'] == "1" ? "#F00" : "#000";
	$situacao	= $row_strProtocolos['bbh_pro_flagrante'] == "1" ? "Flagrante - ".$situacao : $situacao;
	//--	
//		if($p == 0 && $row_Fluxo['bbh_flu_finalizado']=='1'){//recupero informações do primeiro protocolo
		if(!isset($bbh_pro_codigoInd)){
			if($row_strProtocolos['bbh_flu_codigo'] == $bbh_flu_codigo){//recupero informações do protocolo
				$nv_bbh_pro_flagrante 		= $row_strProtocolos['bbh_pro_flagrante'];
				$nv_bbh_pro_identificacao 	= $row_strProtocolos['bbh_pro_identificacao'];
				$nv_bbh_pro_autoridade 		= $row_strProtocolos['bbh_pro_autoridade'];
				$nv_bbh_pro_titulo 			= $row_strProtocolos['bbh_pro_titulo'];
				$nv_bbh_pro_data 			= arrumadata($row_strProtocolos['bbh_pro_data']);
				$nv_bbh_pro_descricao 		= $row_strProtocolos['bbh_pro_descricao'];
			}
		}
		
		//conta quantos arquivos tenho anexado a este protocolo
		$cont = 0;
		if ($handle = @opendir(str_replace("web","database",$_SESSION['caminhoFisico'])."/servicos/bbhive/protocolo/protocolo_".$codProtocolo."/.")) {
		
		while (false !== ($file = readdir($handle))) {
		  if ($file != "." && $file != "..") {
					$cont++; 
				if ($cont == 800) {
				die;
				}
			 }
		  }
		 closedir($handle);
		}
	?>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td rowspan="2" align="left" valign="top">&nbsp;<strong><?php echo $codProtocolo; ?></strong></td>
    <td rowspan="2" align="left" valign="top"><img src="/corporativo/servicos/bbhive/images/setaIII.gif" width="4" height="8">&nbsp;<?php echo $a=$row_strProtocolos['bbh_pro_titulo']; ?></td>
    <td rowspan="2" align="left" valign="top"><?php echo $a=$row_strProtocolos['bbh_pro_identificacao']; ?></td>
    <td rowspan="2" align="left" valign="top"><?php echo arrumadata(substr($row_strProtocolos['bbh_pro_momento'],0,10))." ".substr($row_strProtocolos['bbh_pro_momento'],11,5); ?></td>
    <td width="23" height="25" align="center">
    	<img src="/corporativo/servicos/bbhive/images/caixa.gif" border="0" align="absmiddle" />
    </td>
    <td width="23" align="center"><img src="/corporativo/servicos/bbhive/images/clipes.gif" border="0" align="absmiddle" /></td>
    <td width="21" align="center"><a href="#@"  onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $row_strProtocolos['bbh_pro_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Clique para visualizar todos os detalhes deste protocolo"><img src="/corporativo/servicos/bbhive/images/editarII.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td height="10" align="center" title="<?php echo $row_strProtocolos['total']; echo $_SESSION['componentesNome'];?>">
	    (<?php echo $row_strProtocolos['total']; ?>)
    </td>
    <td align="center" title="<?php echo $cont; ?> arquivos digitalizado">(<?php echo $p=$cont; ?>)</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td height="2" colspan="7" align="left" valign="top" bgcolor="#FFFFFF"></td>
  </tr>
  <?php $p++; } ?>
</table>  