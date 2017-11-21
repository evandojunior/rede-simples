<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//select para descobrir o total de registros na base
	$campos	= "count(d.bbh_dep_codigo) as total";
	$sql 	= "select CAMPOS
				  from bbh_departamento d
				   inner join bbh_tipo_indicio t on d.bbh_dep_codigo = t.bbh_dep_codigo
					 order by bbh_dep_nome, t.bbh_tip_codigo asc";

	$query_ind = str_replace("CAMPOS", $campos, $sql);
    list($ind, $row_ind, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind);
	
	$page 		= "1";
	$nElements 	= "50";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= '/e-solution/servicos/bbhive/departamentos/tipos_indicios/index.php?Ts='.time();
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($row_ind['total']/$nElements);

	$campos = "  d.bbh_dep_codigo, d.bbh_dep_nome, t.bbh_tip_codigo, t.bbh_tip_nome, t.bbh_tip_descricao,
				  (
				   select count(i.bbh_tip_codigo) from bbh_indicio i where i.bbh_tip_codigo = t.bbh_tip_codigo
				  ) as total";
	$query_ind = str_replace("CAMPOS", $campos, $sql) . " LIMIT $Inicio,$nElements";
    list($ind, $rows, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind, $initResult = false);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="535" height="26" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/tipos_indicios.gif" width="16" height="16" border="0" align="absmiddle" />
      
      Gerenciamento de tipos de ind&iacute;cios</td>
    <td width="60" height="26" align="right" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/index.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
    </tr>
  <tr>
    <td height="25" align="right"><a href="#@"" onclick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/tipos_indicios/novo.php','menuEsquerda|conteudoGeral');"></a>&nbsp;</td>
    <td height="25" align="center"><a href="#@"" onclick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/tipos_indicios/novo.php','menuEsquerda|conteudoGeral');"><img 

src="/e-solution/servicos/bbhive/images/novo.gif" alt="Novo tipo de indício" title="Novo tipo de indício" width="12" height="15" border="0" align="absmiddle" /></a></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <?php $cod=0; $dep=0;
  while($row_ind = mysqli_fetch_assoc($ind)){ ?>

  <?php if($dep != $row_ind['bbh_dep_codigo']){?>
  <tr>
    <td height="25" colspan="3" align="left" class="titulo_setor"><img src="/corporativo/servicos/bbhive/images/departamentoII.gif" width="16" height="16" border="0" align="absmiddle" title="Departamento" /><strong>&nbsp;<?php echo $row_ind['bbh_dep_nome']; ?></td>
  </tr>
  <?php } //fecha o departamento ?>

  <?php //if( $cod!=$row_ind['bbh_tip_codigo']){ ?>
  <tr>
    <td width="9" height="24" align="left" class="legandaLabel11">&nbsp;</td>
    <td width="535" height="20" align="left" class="legandaLabel11" style="border-bottom:1px dotted #999999;">&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/tipo.gif" width="16" height="16" border="0" align="absmiddle" title="Tipo do indício" /> &nbsp;<u><?php echo $row_ind['bbh_tip_nome']; ?></u></td>
    <td width="51" height="20" align="center" class="legandaLabel11" style="border-bottom:1px dotted #999999;"><a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/tipos_indicios/editar.php?bbh_tip_codigo=<?php echo $row_ind['bbh_tip_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/editar.gif" width="17" height="17" border="0" align="absmiddle" title="Editar este tipo" /></a>
        &nbsp;
        <?php if($row_ind['total'] == 0){?>
        <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/tipos_indicios/excluir.php?bbh_tip_codigo=<?php echo $row_ind['bbh_tip_codigo']; ?>','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/excluir.gif" width="17" height="17" border="0" align="absmiddle" title="Excluir este tipo" /></a>
        <?php } else { ?>
        <img src="/e-solution/servicos/bbhive/images/excluir-negado.gif" width="17" height="17" align="absmiddle" title="Este registro não pode ser excluído">
        <?php } ?>
        </td>
  </tr>
  <?php //} //fecha o tipo de indicio ?>
  
  <?php 
  	/*$cod	=	$row_ind['bbh_tip_codigo']; */
	$dep	=	$row_ind['bbh_dep_codigo'];
  } ?>
  <?php if($totalRows_ind==0){?>
  <tr>
    <td height="20" colspan="3" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe registros cadastrados</td>
  </tr>
  <?php } ?>
</table>
<div align="center"><?php require_once('../../includes/paginacao/paginacao.php');?></div>