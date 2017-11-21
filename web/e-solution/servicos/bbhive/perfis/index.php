<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$query_perfis = "SELECT * FROM bbh_perfil";
list($perfis, $row_perfis, $totalRows_perfis) = executeQuery($bbhive, $database_bbhive, $query_perfis);

$fluxos 	= "";
$mensagens  = "";
$arquivos	= "";
$equipe		= "";
$tarefas	= "";
$relatorios = "";
$protocolos = "";
$corporativo= "";
$publico	= "";
//
// Lê as confirgurações
$xmlParse = simplexml_load_file( $_SESSION['caminhoFisico']."/../database/servicos/bbhive/nivel_informacao.xml" );
foreach( $xmlParse as $value ){ $values[ (int) $value['nivel'] ] = (string) $value['valor']; }
// Fim das configurações
//

?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_perfNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" colspan="5" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-perfis-16px.gif" width="14" height="14" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_perfNome']; ?></td>
    <td width="18%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="6"></td>
  </tr>
  <tr class="verdana_11_bold">
    <td style="border-bottom:1px solid #000000;" width="16%" height="22">Nome</td>
    <td style="border-bottom:1px solid #000000;" width="19%">Descri&ccedil;&atilde;o</td>
    <td style="border-bottom:1px solid #000000;" width="25%">Atribui&ccedil;&otilde;es</td>
    <td style="border-bottom:1px solid #000000;" width="11%">Perm. Matriz</td>
    <td style="border-bottom:1px solid #000000;" width="11%">Perm. Unidade</td>
    <td style="border-bottom:1px solid #000000;" width="18%" align="center">
    <a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|perfis/novo.php','menuEsquerda|colCentro');">
    <img src="/e-solution/servicos/bbhive/images/novo.gif" alt="" width="12" height="15" border="0" align="absmiddle" />
    </a>
    </td>
  </tr>
<?php if ($totalRows_perfis > 0) { // Show if recordset not empty ?>
  <?php do { 
 //consulta pra saber o total de usuários com este perfil
		$query_quantusuarios = "SELECT COUNT(bbh_per_codigo) as TOTAL, bbh_per_codigo FROM bbh_usuario_perfil WHERE bbh_per_codigo = ".$row_perfis['bbh_per_codigo']." GROUP BY bbh_per_codigo";
        list($quantusuarios, $row_quantusuarios, $totalRows_quantusuarios) = executeQuery($bbhive, $database_bbhive, $query_quantusuarios);

 //bloco de if que mostra as imagens das permissões  
		if($row_perfis['bbh_per_fluxo']==1){
			$fluxos 	= "&nbsp;<img src='/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif' width='16' height='16' title='".$_SESSION['adm_FluxoNome']."' align='absmiddle' />";
		}else{ $fluxos = "<span style='color:#fff'>.</span>"; }
		if($row_perfis['bbh_per_mensagem']==1){
			$mensagens  = "&nbsp;<img src='/e-solution/servicos/bbhive/images/ger-mensagens-16px.gif' width='16' height='16' title='".$_SESSION['adm_MsgNome']."' align='absmiddle' />";
		}else{ $mensagens = ""; }
		if($row_perfis['bbh_per_arquivos']==1){
			$arquivos   = "&nbsp;<img src='/e-solution/servicos/bbhive/images/arquivos16px.gif' width='16' height='16' title='GED' align='absmiddle' />";
		}else{ $arquivos = ""; }
		if($row_perfis['bbh_per_equipe']==1){
			$equipe     = "&nbsp;<img src='/e-solution/servicos/bbhive/images/ger-usuarios-16px.gif' width='16' height='16' title='Equipe' align='absmiddle' />";
		}else{ $equipe = ""; }
		if($row_perfis['bbh_per_tarefas']==1){
			$tarefas    = "&nbsp;<img src='/e-solution/servicos/bbhive/images/tarefa.gif' width='16' height='16' title='Tarefas' align='absmiddle' />";
		}else{ $tarefas = ""; }
		if($row_perfis['bbh_per_relatorios']==1){
			$relatorios = "&nbsp;<img src='/e-solution/servicos/bbhive/images/relatorio.gif' width='16' height='16' title='Relat&oacute;rios' align='absmiddle' />";
		}else{ $relatorios = ""; }
		if($row_perfis['bbh_per_protocolos']==1){
			$protocolos = "&nbsp;<img src='/e-solution/servicos/bbhive/images/ger-protocolos-16px.gif' width='16' height='16' title='".$_SESSION['adm_protNome']."' align='absmiddle' />";
		}else{ $protocolos = ""; }
		if($row_perfis['bbh_per_central_indicios']==1){
			$central="&nbsp;<img src='/e-solution/servicos/bbhive/images/central_indicios.gif' width='16' height='16' title='Central de".$_SESSION['adm_componentesNome']."' align='absmiddle' />";
		}else{
			$central="";	
		}
		//--
		if($row_perfis['bbh_per_corp']==1){
			$corporativo="&nbsp;<img src='/e-solution/servicos/bbhive/images/cadeado_off.gif' width='16' height='16' title='Sem acesso corporativo' align='absmiddle' />";
		}
		//--
		if($row_perfis['bbh_per_pub']==1){
			$publico="&nbsp;<img src='/e-solution/servicos/bbhive/images/cadeado_off.gif' width='16' height='16' title='Sem acesso publico' align='absmiddle' />";
		}
		if($row_perfis['bbh_per_bi']==1){
			$bi="&nbsp;<img src='/e-solution/servicos/bbhive/images/bi.gif' width='16' height='16' title='BI' align='absmiddle' />";
		}else{
			$bi="";	
		}
		if($row_perfis['bbh_per_geo']==1){
			$geo="&nbsp;<img src='/e-solution/servicos/bbhive/images/geoprocessamento.gif' width='16' height='16' title='GEO' align='absmiddle' />";
		}else{
			$geo="";	
		}
		if($row_perfis['bbh_per_peoplerank']==1){
			$peoplerank="&nbsp;<img src='/e-solution/servicos/bbhive/images/peoplerank.gif' width='16' height='16' title='Peoplerank' align='absmiddle' />";
		}else{
			$peoplerank="";	
		}
	?>
  <tr>
    <td style="border-bottom:1px dotted #999999;" height="22">
	  <?php
	  if(strlen($row_perfis['bbh_per_nome'])>14){	  
	      echo substr($row_perfis['bbh_per_nome'],0,11)."...";
	  }else{
		  echo $row_perfis['bbh_per_nome'];	  	
	  }
	  ?>
    </td>
    <td style="border-bottom:1px dotted #999999;">
	  <?php
		if(strlen($row_perfis['bbh_per_observacao'])==0){
			echo $o="<span style='color:#fff'>.</span>";
		}
	  elseif(strlen($row_perfis['bbh_per_observacao'])>30){	  
	      echo $o=substr($row_perfis['bbh_per_observacao'],0,27)."...";
	  }else{
		  echo $o=$row_perfis['bbh_per_observacao'];	  	
	  }
	  ?>
    </td>
    <td style="border-bottom:1px dotted #999999;"><?php echo $fluxos.$mensagens.$arquivos.$equipe.$tarefas.$relatorios.$protocolos.$central.$corporativo.$publico.$bi.$geo.$peoplerank; ?></td>
    <td style="border-bottom:1px dotted #999999;"><?PHP echo $values[$row_perfis['bbh_per_matriz']]; ?></td>
    <td style="border-bottom:1px dotted #999999;"><?PHP echo $values[$row_perfis['bbh_per_unidade']]; ?></td>
   
    <td style="border-bottom:1px dotted #999999;" align="center"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|perfis/editar.php?bbh_per_codigo=<?php echo $row_perfis['bbh_per_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/editar.gif" alt="" width="17" height="17" border="0" align="absmiddle" /></a>&nbsp;&nbsp;<a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|perfis/excluir.php?bbh_per_codigo=<?php echo $row_perfis['bbh_per_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/excluir.gif" alt="" width="17" height="17" border="0" align="absmiddle" /></a>&nbsp;&nbsp;<a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|perfis/usuarios/index.php?bbh_per_codigo=<?php echo $row_perfis['bbh_per_codigo']; ?>','menuEsquerda|colCentro');"><img title="Usu&aacute;rios com este perfil" src="/e-solution/servicos/bbhive/images/equipe.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a>
    <?php if($row_quantusuarios['TOTAL']>0){echo $row_quantusuarios['TOTAL'];}else{echo "0";} ?></td>
  </tr>
  <?php } while ($row_perfis = mysqli_fetch_assoc($perfis)); ?>
      <?php }else{ // Show if recordset not empty ?>
  <tr>
    <td class="color" colspan="6">Voc&ecirc; n&atilde;o possui nenhum perfil cadastrado. <a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|perfis/novo.php','menuEsquerda|colCentro');">Clique aqui</a> para cadastrar um novo.</td>
  </tr>
      <?php } ?>

  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
