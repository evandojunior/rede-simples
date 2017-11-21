<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#E0DFE3" style="margin-top:5px;" class="verdana_11">
  <tr>
        <td width="64" bgcolor="#F7F7F9"><strong><?php echo $n=($_SESSION['ProtNome']); ?></strong></td>
        <td width="182" height="22" bgcolor="#F7F7F9"><strong><?php echo($_SESSION['ProtOfiNome']);?></strong></td>
        <td width="178" bgcolor="#F7F7F9"><strong><?php echo($_SESSION['ProtIdentificacao']);?></strong></td>
        <td width="100" bgcolor="#F7F7F9"><strong>Criado em</strong></td>
        <td width="20" bgcolor="#F7F7F9">&nbsp;</td>
      </tr>
  
<?php 
	  while($row_strProtocolos = mysqli_fetch_assoc($strProtocolos)) {
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
          <td align="center"><a href="#" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $row_strProtocolos['bbh_pro_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/corporativo/servicos/bbhive/images/editarII.gif" width="16" height="16" border="0"></a></td>
        </tr>
  <?php } ?>
    </table>