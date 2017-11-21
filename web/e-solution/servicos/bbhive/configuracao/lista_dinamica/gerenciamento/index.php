<?php
if(!isset($_SESSION)){session_start();}
require_once('../../../../../../Connections/bbhive.php');
require_once('../../../../../../../database/config/globalFunctions.php');

if ((isset($_GET["page"]))) {
	require_once('../../../../../../Connections/bbhive.php');
	require_once("../../../includes/autentica.php");
	require_once("../../../includes/functions.php");
	require_once("../../../fluxos/modelosFluxos/detalhamento/includes/functions.php");
}

//-- SQL Paginação SIMPLES
$query_paginacaoSimples = "SELECT * FROM bbh_campo_lista_dinamica where bbh_cam_list_titulo='".$_GET['bbh_cam_list_titulo']."' AND bbh_cam_list_tipo = 'S'";
list($paginacaoSimples, $rows, $totalRows_paginacaoSimples) = executeQuery($bbhive, $database_bbhive, $query_paginacaoSimples, $initResult = false);
/*solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/trocaOrdem.php&page=2&Ts=1321035724774 was not found on this server*/
if ($totalRows_paginacaoSimples > 0) {
//--Paginação
$page 		= "1";
$nElements 	= "100";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/index.php?Ts='.$_SERVER['REQUEST_TIME']."&bbh_cam_list_titulo=".$_GET['bbh_cam_list_titulo'];
$exibe			= 'conteudoGeral';
$pages 			= ceil($totalRows_paginacaoSimples/$nElements);
}
/* /e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/trocaOrdem.php&page=2&Ts=1321036797554 */
//-- SQL Paginação ÁRVORE
$query_paginacaoArvore = "SELECT * FROM bbh_campo_lista_dinamica where bbh_cam_list_titulo='".$_GET['bbh_cam_list_titulo']."' AND bbh_cam_list_tipo = 'A'";
list($paginacaoArvore, $rows, $totalRows_paginacaoArvore) = executeQuery($bbhive, $database_bbhive, $query_paginacaoArvore, $initResult = false);

if ($totalRows_paginacaoArvore > 0) {
    //--Paginação
    $page 		= "1";
    $nElements 	= "100";
        if(isset($_GET["page"])){
            $page 	= $_GET["page"];
        }
    $Inicio = ($nElements*$page)-$nElements;
    $homeDestino	= '/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/index.php?Ts='.$_SERVER['REQUEST_TIME']."&bbh_cam_list_titulo=".$_GET['bbh_cam_list_titulo'];
    $exibe			= 'conteudoGeral';
    $pages 			= ceil($totalRows_paginacaoArvore/$nElements);
}

//-- Árvore
$query_gerenciamentoArvore = "SELECT * FROM bbh_campo_lista_dinamica where bbh_cam_list_titulo='".$_GET['bbh_cam_list_titulo']."' AND bbh_cam_list_tipo = 'A' ORDER BY bbh_cam_list_mascara limit $Inicio, $nElements";
list($gerenciamentoArvore, $row_gerenciamentoArvore, $totalRows_gerenciamentoArvore) = executeQuery($bbhive, $database_bbhive, $query_gerenciamentoArvore);

//--Simples
$query_gerenciamentoSimples = "SELECT * FROM bbh_campo_lista_dinamica where bbh_cam_list_titulo='".$_GET['bbh_cam_list_titulo']."' AND bbh_cam_list_tipo = 'S' ORDER BY bbh_cam_list_mascara  limit $Inicio,$nElements";
list($gerenciamentoSimples, $row_gerenciamentoSimples, $totalRows_gerenciamentoSimples) = executeQuery($bbhive, $database_bbhive, $query_gerenciamentoSimples);

//ordenação
if($totalRows_gerenciamentoSimples >0 ){
	$primeiro = $row_gerenciamentoSimples["bbh_cam_list_codigo"];
	mysqli_data_seek($gerenciamentoSimples, $totalRows_gerenciamentoSimples-1);
		
	$row_ultimo = mysqli_fetch_assoc($gerenciamentoSimples);
	$ultimo = $row_ultimo["bbh_cam_list_codigo"];
	mysqli_data_seek($gerenciamentoSimples, 0);
}

$homeDestinoOrdem = "/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/trocaOrdem.php";

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
	<tr>
    	<td>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
          <tr>
            <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de op&ccedil;&otilde;es de lista din&acirc;mica</td>
            <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=1','menuEsquerda|colCentro')"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
          </tr>
          <tr>
            <td height="8"></td>
          </tr>
    	</table>
        <div id="loadOrdena" class="legandaLabel11">&nbsp;</div>
        <div style="position:absolute; height:5px;" id="loadInser" class="legandaLabel11"></div>
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
              <tr class="legandaLabel11">
                <td width="3%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
                <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">
                <?php if($totalRows_gerenciamentoArvore > 0){ ?>
                    <strong><?php echo $row_gerenciamentoArvore['bbh_cam_list_titulo'];?></strong>
                <?php }else{ ?>
                    <strong><?php echo $row_gerenciamentoSimples['bbh_cam_list_titulo'];?></strong>
                <?php } ?>
                </td>
              </tr>
              <tr class="legandaLabel11">
                <td height="25" align="center">&nbsp;</td>
                <td class="legandaLabel10">
                <?php if($totalRows_gerenciamentoArvore > 0){ ?>
                    <strong>Tipo</strong> <?php echo '&Aacute;rvore';?>
                <?php }else{ ?>
                    <strong>Tipo</strong> <?php echo 'Simples';?>
                <?php } ?>
                 
                </td>
              </tr>
              <tr>
                <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
              </tr>
              <tr class="legandaLabel11">
                <td height="5" colspan="2" align="center"></td>
              </tr>
        </table>
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
            <?php if ($totalRows_gerenciamentoArvore > 0) { 
                	include('inclueArvore.php');
            	  } 
			?>
              <br />
            <?php if ($totalRows_gerenciamentoSimples > 0) { 
                	include('inclueSimples.php');
          		  } ?>
        
         <tr class="legandaLabel11">
            <td height="22" colspan="9" align="center">&nbsp;</td>
          </tr>
          <tr class="legandaLabel11">
            <td height="5" colspan="9" align="center">&nbsp;</td>
          </tr>
        </table>
		</td>
	</tr>
</table>
<?php
mysqli_free_result($gerenciamentoSimples);
mysqli_free_result($gerenciamentoArvore);
?>
<br />
