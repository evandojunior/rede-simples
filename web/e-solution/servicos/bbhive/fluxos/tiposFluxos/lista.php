<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$query_tipofluxo = "SELECT COUNT(bbh_tip_flu_codigo) as TOTAL FROM bbh_tipo_fluxo";
list($tipofluxo, $row_tipofluxo, $totalRows_tipofluxo) = executeQuery($bbhive, $database_bbhive, $query_tipofluxo);

$page 		= "1";
$nElements 	= "30";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbhive/fluxos/tiposFluxos/tipos.php?Ts='.$_SERVER['REQUEST_TIME'];
$exibe			= 'conteudoGeral';
$pages 			= ceil($row_tipofluxo['TOTAL']/$nElements);

$query_tipofluxo = "SELECT * FROM bbh_tipo_fluxo ORDER BY bbh_tip_flu_identificacao ASC LIMIT $Inicio,$nElements";
list($tipofluxo, $row_tipofluxo, $totalRows_tipofluxo) = executeQuery($bbhive, $database_bbhive, $query_tipofluxo);

?><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="verdana_11_bold">
        <td height="22" style="border-bottom:1px solid #000000;">Identificador</td>
        <td style="border-bottom:1px solid #000000;">Nome</td>
        <td align="center" style="border-bottom:1px solid #000000;"><a href="#" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=2&menuEsquerda=1|fluxos/tiposFluxos/novo.php','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/novo.gif" alt="" width="12" height="15" border="0" align="absmiddle" /></a></td>
  </tr>
          <tr>
            <td colspan="3" align="center">&nbsp;</td>
          </tr>
	 <?php do { ?>
          <tr>
          <td width="22%" style="border-bottom:#999999 dotted 1px"><?php echo $row_tipofluxo['bbh_tip_flu_identificacao']; ?></td>
          <td width="60%" height="22" style="border-bottom:#999999 dotted 1px"><?php echo $row_tipofluxo['bbh_tip_flu_nome']; ?></td>
          <td width="18%" align="center" style="border-bottom:#999999 dotted 1px"><img src="/e-solution/servicos/bbhive/images/editar.gif" alt="" width="17" height="17" border="0" align="absmiddle" onclick="LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/tiposFluxos/editar.php?bbh_tip_flu_codigo=<?php echo $row_tipofluxo['bbh_tip_flu_codigo']; ?>','menuEsquerda|conteudoGeral')" style="cursor:pointer" />&nbsp;&nbsp;<img src="/e-solution/servicos/bbhive/images/excluir.gif" alt="" width="17" height="17" align="absmiddle" onclick="LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/tiposFluxos/excluir.php?bbh_tip_flu_codigo=<?php echo $row_tipofluxo['bbh_tip_flu_codigo']; ?>','menuEsquerda|conteudoGeral')" style="cursor:pointer" /></span></td>
     </tr>
        <?php } while ($row_tipofluxo = mysqli_fetch_assoc($tipofluxo)); ?>
          <tr>
            <td colspan="3" align="center"><?php require_once('../../includes/paginacao/paginacao.php');?></td>
          </tr>
    </table>
    <?php
mysqli_free_result($tipofluxo);
?>