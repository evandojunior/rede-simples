<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//Parametros de busca
$SQL ="";
$SQL.= isset($_POST['busca_responsavel']) ? " AND (bbh_usu_nome LIKE '%".mysqli_fetch_assoc($_POST['bbh_busca_responsavel'])."%' OR bbh_ind_responsavel LIKE '%".mysqli_fetch_assoc($_POST['bbh_busca_responsavel'])."%')" : "";

$SQL.= isset($_POST['busca_departamento']) ? " AND d.bbh_dep_codigo = ".$_POST['bbh_dep_codigo'] : "";
$SQL.= isset($_POST['busca_tipo']) ? " AND t.bbh_tip_codigo = ".$_POST['bbh_tip_codigo'] : "";
$SQL.= isset($_POST['busca_cbarras']) ? " AND i.bbh_ind_codigo_barras = '".$_POST['bbh_ind_codigo_barras']."'" : "";
//--
//-se tiver busca e paginação devo levar os dados no GET
$get="";


//busca pelos dados do protocolo
   $SQL			.= isset($_POST['ck_prot']) ? " AND p.bbh_pro_codigo=".$_POST['bbh_pro_codigo'] : "";
   $SQL			.= isset($_POST['ck_data']) ? " AND p.bbh_pro_momento BETWEEN '".arrumadata($_POST['bbh_pro_data'])." 00:00:00' AND '".arrumadata($_POST['bbh_pro_data'])." 23:59:59'" : "";
   $SQL			.= isset($_POST['ck_tit']) ? " AND p.bbh_pro_titulo LIKE '%".mysqli_fetch_assoc($_POST['bbh_pro_titulo'])."%'" : "";
//-----------------------------

	//select para descobrir o total de registros na base
	$campos	= "count(i.bbh_ind_codigo) as total";
	$sql 	= "select CAMPOS from bbh_indicio i
			 	 inner join bbh_protocolos p on i.bbh_pro_codigo = p.bbh_pro_codigo
				 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
				 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
				 left join bbh_usuario u on i.bbh_ind_responsavel = u.bbh_usu_identificacao
				   Where 1=1 $SQL
					order by i.bbh_ind_responsavel, d.bbh_dep_codigo, t.bbh_tip_codigo asc";
    $query_ind = str_replace("CAMPOS", $campos, $sql);
    list($ind, $row_ind, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind);
	
	$page 		= "1";
	$nElements 	= "50";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= '/corporativo/servicos/bbhive/central_indicios/busca_profissional/busca.php?Ts='.time() . $get;
	$exibe			= 'resultBusca';
	$pages 			= ceil($row_ind['total']/$nElements);

	$campos = "  d.bbh_dep_codigo, d.bbh_dep_nome, i.*, t.bbh_tip_nome, bbh_usu_nome, p.bbh_pro_codigo, p.bbh_pro_momento, p.bbh_pro_titulo";
    $query_ind = str_replace("CAMPOS", $campos, $sql) . " LIMIT $Inicio,$nElements";
	list($ind, $rows, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind, $initResult = false);

	$buscaadt = "";
	$buscaadt.= isset($_POST['busca_responsavel']) ? " Responsável: " . mysqli_fetch_assoc($_POST['bbh_busca_responsavel']) : "";

	$buscaadt.= isset($_POST['busca_departamento']) ? " Departamento: " . $_POST['bbh_dep_codigo'] : "";
	$buscaadt.= isset($_POST['busca_tipo']) ? " Tipo: " . $_POST['bbh_tip_codigo'] : "";
	$buscaadt.= isset($_POST['busca_cbarras']) ? " Código de Barras: " . $_POST['bbh_ind_codigo_barras']."'" : "";

	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Acessou a página de busca de (".$_SESSION['componentesNome'].") ($buscaadt) - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
?>
<table width="595" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:#cccccc solid 1px;">
  <?php $cod=0; $dep=0; $prof="";
  while($row_ind = mysqli_fetch_assoc($ind)){ ?>

  <?php if($prof != $row_ind['bbh_ind_responsavel']){ ?>
  <tr>
    <td height="20" colspan="5" align="left" class="titulo_setor" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;border-top:#cccccc solid 1px; "><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" title="Profissional responsável" />&nbsp;<?php echo !empty($row_ind['bbh_usu_nome']) ? $row_ind['bbh_usu_nome'] : $row_ind['bbh_ind_responsavel']; ?></td>
  </tr>
  <?php } //fecha o profissional ?>

  <?php if($dep != $row_ind['bbh_dep_codigo']){?>
  <tr>
    <td width="10" height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;border-top:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-top:#cccccc solid 1px; border-right:#cccccc solid 1px;"><img src="/corporativo/servicos/bbhive/images/departamentoII.gif" width="16" height="16" border="0" align="absmiddle" title="Departamento" /><strong>&nbsp;<?php echo $row_ind['bbh_dep_nome']; ?></strong></td>
  </tr>
  <?php } //fecha o departamento ?> 

  <?php if( $cod!=$row_ind['bbh_tip_codigo'] || $prof != $row_ind['bbh_ind_responsavel']){ ?>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;">&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/tipo.gif" width="16" height="16" border="0" align="absmiddle" title="Tipo do indício" /> &nbsp;<strong><u><?php echo $row_ind['bbh_tip_nome']; ?></u></strong></td>
  </tr>
  <?php } //fecha o tipo de indicio ?>
  
  <tr>
    <td width="10" height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td width="40" height="20" align="right" valign="top" class="legandaLabel11">
    <img src="/corporativo/servicos/bbhive/images/circulo.gif" width="16" height="16" border="0" align="absmiddle" title="Indício" />
    </td>
    <td width="372" align="left" valign="top" class="legandaLabel11">
    <div style="margin-left:5px">
    	<span class="color"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></span>
    </div>
    </td>
    <td width="173" height="20" align="left" valign="top" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><strong>Desde</strong>:&nbsp;<?php echo $dt=arrumadata(substr($row_ind['bbh_ind_dt_recebimento'],0,10)) ." ".substr($row_ind['bbh_ind_dt_recebimento'],11,5); ?><a href="#@" title="Visualizar detalhes deste indício" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1|central_indicios/indicio.php?bbh_ind_codigo=<?php echo $row_ind['bbh_ind_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/corporativo/servicos/bbhive/images/visualizar_indicio.gif" width="16" height="16" border="0" align="absmiddle" style="margin-left:2px;"/></a></td>
  </tr>
  <?php 
  	$cod	=	$row_ind['bbh_tip_codigo']; 
	$dep	=	$row_ind['bbh_dep_codigo']; 
	$prof	= 	$row_ind['bbh_ind_responsavel'];
  } ?>
  <?php if($totalRows_ind==0){?>
  <tr>
    <td height="20" colspan="5" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe registros cadastrados</td>
  </tr>
  <?php } ?>
</table>
<?php require_once('../../includes/paginacao/paginacao.php');?>