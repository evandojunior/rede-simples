<?php if (!isset($_SESSION)) {  session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");

$pagina = "protocolos/regra.php?";
//-----------------------------------------------------------------------------------------


$url = "";
foreach($_GET as $indice=>$valor){
	if(($indice=="amp;busca")||($indice=="busca")){	$busca= $valor; $url="&busca=".$busca; } 
	if(($indice=="amp;todos")||($indice=="todos")){	$todos= $valor; $url="&todos=".$todos; } 
	if(($indice=="amp;status")||($indice=="status")){ $Ostatus= $valor; $url="&status=".$Ostatus; }
	if(($indice=="amp;inicio")||($indice=="inicio")){ $inicio= $valor;} 
}

if(!isset($busca)){//sem filtro
 	$stringAnd 	= " AND bbh_pro_momento BETWEEN '".date('Y-m-d')." 00:00:00' AND '".date('Y-m-d')." 23:59:59'";
	
} else {//vim do filtro
	$stringAnd	= " AND bbh_pro_codigo IN ($busca)";
}
if(isset($Ostatus)){
	$stringAnd = " AND bbh_pro_status='$Ostatus'";
}
if(isset($todos)){
	$stringAnd	= "";
}
//----------------------------------------------------------------------------------------------------
/*$Inicio	= isset($inicio) && $inicio > 0 ? $inicio : 0;
$maximo = 20;*/

//SQL PADRÃO PARA EXECUÇÃO DE DADOS DESTA PÁGINA
$sqlPadrao = "SELECT bbh_per_codigo, bbh_protocolos.*, bbh_dep_nome  FROM bbh_protocolos 
					  left join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo 
					  left join bbh_usuario on bbh_protocolos.bbh_pro_email = bbh_usuario.bbh_usu_identificacao
					  left join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
					  
					  WHERE 
						  (bbh_pro_email='freepass@bbpass'
        						OR (bbh_per_codigo IS NULL OR bbh_per_codigo IN (
		      					  select bbh_per_codigo from bbh_usuario_perfil
			         				   inner join bbh_usuario on bbh_usuario_perfil.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					        			 where (bbh_usu_identificacao = '".$_SESSION['MM_User_email']."')
							    			)))
						  $stringAnd 
						    ";
//----------------------------------------------------------------------------------------------------

/*
//total de protocolos sem fluxo
$totNovas = total($database_bbhive, $bbhive, "SELECT * FROM bbh_protocolos Where bbh_pro_status is NULL");

//total de todos os protocolos para paginação
$totpagina= total($database_bbhive, $bbhive, $sqlPadrao);*/

//lógica para paginação com todos os dados do GET
/*	//Primeiro------------------------------------------------------------------------------------------------------
	if($Inicio > 0){
		//$LinkPag= "LoadSimultaneo('perfil/index.php?perfil=1|".$pagina."inicio=0$url','menuEsquerda|conteudoGeral')";
		$LinkPag= "LoadSimultaneo('".$pagina."inicio=0$url','conteudoGeral')";
		$primeira = "<a href='#@' onClick=\"$LinkPag\">Primeira</a>";
	}
	//Próximo-------------------------------------------------------------------------------------------------------
	if($Inicio > 0){
		//$LinkPag= "LoadSimultaneo('perfil/index.php?perfil=1|".$pagina."inicio=".($Inicio-$maximo)."$url','menuEsquerda|conteudoGeral')";
		$LinkPag= "LoadSimultaneo('".$pagina."inicio=".($Inicio-$maximo)."$url','conteudoGeral')";
		$anterior = "<a href='#@' onClick=\"$LinkPag\">Anterior</a>";
	}
	//Anterior------------------------------------------------------------------------------------------------------
	if(ceil($totpagina/$maximo) > 0 && (($Inicio+$maximo) < $totpagina)){
		//$LinkPag= "LoadSimultaneo('perfil/index.php?perfil=1|".$pagina."inicio=".($Inicio+$maximo)."$url','menuEsquerda|conteudoGeral')";
		$LinkPag= "LoadSimultaneo('".$pagina."inicio=".($Inicio+$maximo)."$url','conteudoGeral')";
		$proximo = "<a href='#@' onClick=\"$LinkPag\">Próxima</a>";
	}
	//Último--------------------------------------------------------------------------------------------------------
	if(($Inicio+$maximo) < $totpagina){
		//$LinkPag= "LoadSimultaneo('perfil/index.php?perfil=1|".$pagina."inicio=".($totpagina - $maximo)."$url','menuEsquerda|conteudoGeral')";
		$LinkPag= "LoadSimultaneo('".$pagina."inicio=".($totpagina - $maximo)."$url','conteudoGeral')";
		$ultima = "<a href='#@' onClick=\"$LinkPag\">Última</a>";
	}
*/

//Dados para paginação
$dadosURL = "";
//--GET
	foreach($_GET as $i=>$v){
		$dadosURL.= "&".$i."=".$v;
	}
//--POST
	foreach($_POST as $i=>$v){
		$dadosURL.= "&".$i."=".$v;
	}

	$query_prot =$sqlPadrao. "group by bbh_protocolos.bbh_pro_codigo
							 ORDER BY bbh_pro_codigo DESC";
    list($prot, $row_prot, $totalRows_prot) = executeQuery($bbhive, $database_bbhive, $query_prot);

	$page 		= "1";
	$nElements 	= "20";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= '/servicos/bbhive/protocolos/regra.php?Ts='.$_SERVER['REQUEST_TIME'].$dadosURL;
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($totalRows_prot/$nElements);
	//--

	$query_strProtocolos = $sqlPadrao. "group by bbh_protocolos.bbh_pro_codigo
								 ORDER BY bbh_pro_codigo DESC LIMIT $Inicio,$nElements";
    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolos);

	$onclick = "OpenAjaxPostCmd('/servicos/bbhive/protocolos/cadastro/executa.php?TS=".time()."','loadTudo','gerencia','Carregando...','loadTudo','1','2');";
	
	//Apaga caso senha vindo do fluxo
	 $_SESSION['pacoteNovoProtocolo'] = NULL;
	 unset($_SESSION['pacoteNovoProtocolo']);
	//--
?>
<table width="970" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="387" height="28" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px;">
    <div style="position:absolute;margin-left:475px;" id="loadTudo"></div>
    &nbsp;<img src="/servicos/bbhive/images/profile.gif" align="absmiddle" />&nbsp;<strong><?php echo $_SESSION['MM_User_email']; ?></strong>
   
    </td>
    <td width="456" align="right" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11"><div style="float:right">
      
      <?php if(isset($busca) || isset($todos)){ 
	?>
      <strong><a href="#@" onclick="LoadSimultaneo('protocolos/regra.php','conteudoGeral')">Limpar filtro</a></strong>
      <?php } else { 
	

		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Acessou a página principal do ambiente público - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	
	?>
      <strong><a href="#@" onclick="LoadSimultaneo('protocolos/regra.php?todos=true','conteudoGeral')">Exibir todos</a></strong>
      <?php } ?>
    </div></td>
    <td width="127" align="right" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><div class="legandaLabel11 tbConsulta" style="border:#CCCCCC solid 1px; height:20px; margin-right:5px; width:100px; float:right;" align="center"> <a href="#@" onClick="return showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/passo1.php','colPrincipal');"  style="width:95px;"> &nbsp;<img src="/servicos/bbhive/images/application_add.gif" align="absmiddle" border="0"/>&nbsp;Cadastrar </a> </div></td>
  </tr>
  <tr>
    <td height="80" colspan="3" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
    <?php require_once("../includes/legenda.php"); ?>
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="300" valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%" colspan="4" align="justify">&nbsp;<img src="/servicos/bbhive/images/messagebox_warning.gif" align="absmiddle" />&nbsp;N&atilde;o esque&ccedil;a de efetuar em Encerrar Sess&atilde;o, quando n&atilde;o desejar mais usar o sistema.</td>
              </tr>
              <tr>
                <td height="1" colspan="4" bgcolor="#EDEDED"></td>
              </tr>
            </table>
            <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"  class="borderAlljanela legandaLabel11" style="margin-top:5px;">
              <tr>
                <td width="13%" background="/servicos/bbhive/images/barra_horizontal2.jpg"><strong>&nbsp;<?php echo $p=$_SESSION['protNome']; ?></strong></td>
                <td width="36%" height="22" background="/servicos/bbhive/images/barra_horizontal2.jpg"><strong>&nbsp;<?php echo $a=$_SESSION['ProtOfiNome']; ?></strong></td>
                <td width="23%" background="/servicos/bbhive/images/barra_horizontal2.jpg"><strong>&nbsp;<?php echo $a=$_SESSION['ProtIdentificacao']; ?></strong></td>
                <td width="20%" background="/servicos/bbhive/images/barra_horizontal2.jpg"><strong>&nbsp;Cadastrado em</strong></td>
                <td width="8%" background="/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
              </tr>
<?php if($totalRows_strProtocolo>0) {
   do { 
		//status com base no vetor
		$codSta		= $row_strProtocolo['bbh_pro_status'];
		$cada	 	= explode("|",$status[$codSta]);
		$situacao 	= $cada[0];
		$corFundo 	= $cada[1];
		
		$corFonte	= $row_strProtocolo['bbh_pro_flagrante'] == "1" ? "#F00" : "#000";
		$situacao	= $row_strProtocolo['bbh_pro_flagrante'] == "1" ? $_SESSION['FlagNome']." - ".$situacao : $situacao;
	
	$andamento = "Em homologação!!!";
	?>
              <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>; color:<?php echo $corFonte; ?>" >
                <td>&nbsp;<strong><?php echo $b= $row_strProtocolo['bbh_pro_codigo']; ?></strong></td>
                <td height="22">&nbsp;<?php echo $b= $row_strProtocolo['bbh_pro_titulo']; ?></td>
                <td>&nbsp;<?php echo $a = $row_strProtocolo['bbh_pro_identificacao']; ?></td>
                <td>&nbsp;<?php echo $d = arrumadata(substr($row_strProtocolo['bbh_pro_momento'],0,10))." ".substr($row_strProtocolo['bbh_pro_momento'],11,5); ?></td>
                <td align="right">
                <?php if($codSta=="1"){ ?>
	                <img src="/servicos/bbhive/images/pesquisar.gif" border="0" align="absmiddle" title="Imprimir <?php echo $_SESSION['protNome'];?>" onClick="javascript: document.getElementById('bbh_pro_cod').value='<?php echo $row_strProtocolo['bbh_pro_codigo']; ?>'; <?php echo $onclick; ?>" />
                	<img src="/servicos/bbhive/images/editar.gif" border="0" align="absmiddle" title="Editar esta solicitação"  onClick="javascript: document.getElementById('bbh_pro_cod').value='<?php echo $row_strProtocolo['bbh_pro_codigo']; ?>'; <?php echo $onclick; ?>" style="margin-right:2px;"/>
                <?php } else { ?>
				<img src="/servicos/bbhive/images/pesquisar.gif" border="0" align="absmiddle" onClick="javascript: document.getElementById('bbh_pro_cod').value='<?php echo $row_strProtocolo['bbh_pro_codigo']; ?>'; <?php echo $onclick; ?>"  style="margin-right:2px;"/>                
                <?php } ?>
                </td>
              </tr>
              <tr>
                <td height="1" colspan="5" bgcolor="#EDEDED"></td>
              </tr>
     <?php }while ($row_strProtocolo = mysqli_fetch_assoc($strProtocolo)); ?>
<?php } else {?>
              <tr>
                <td height="22" colspan="5" align="center">N&atilde;o h&aacute; registros cadastrados!</td>
              </tr>
<?php } ?>
            </table>
        <div class="verdana_12" align="center" style="margin-top:5px;">
    	<?php 
		//PAGINAÇÃO
			require_once('../includes/paginacao/paginacao.php');
			/*echo isset($primeira) ? $primeira."&nbsp;&nbsp;" : "";
			echo isset($anterior) ? $anterior."&nbsp;&nbsp;" : "";
			echo isset($proximo)  ? $proximo."&nbsp;&nbsp;"  : "";
			echo isset($ultima)   ? $ultima."&nbsp;&nbsp;"   : "";*/
		?>
        </div>
            </td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table><form name="gerencia" id="gerencia">
  <input type="hidden" name="gerProt" value="1" />
  <input type="hidden" name="bbh_pro_cod" id="bbh_pro_cod" value="" />
</form>