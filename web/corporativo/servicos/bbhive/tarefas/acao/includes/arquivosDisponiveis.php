<?php
$query_relatorios = "SELECT count(bbh_paragrafo.bbh_par_codigo) as paragrafos, bbh_relatorio.*,date_format(bbh_rel_data_criacao,'%d/%m/%Y') as criacao FROM bbh_relatorio  LEFT JOIN bbh_paragrafo ON bbh_paragrafo.bbh_rel_codigo = bbh_relatorio.bbh_rel_codigo WHERE bbh_ati_codigo = ".$CodAtividade." and bbh_rel_pdf='1' GROUP BY bbh_relatorio.bbh_rel_codigo order by bbh_rel_codigo desc LIMIT 0,1";

list($relatorios, $row_relatorios, $totalRows_relatorios) = executeQuery($bbhive, $database_bbhive, $query_relatorios);

$cdF	= $atividade->codigoFluxo;
$cdRel 	= $row_relatorios['bbh_rel_codigo'];
$cmRelat= $dirPadrao[0]."database/servicos/bbhive/fluxo/fluxo_$cdF/documentos/$cdRel/relatorio_final.pdf";

unset($_SESSION['naoFile']);
//--
function linkDownload($titulo){
	return '&nbsp;Download : 
        <a title="Download do '.$titulo.'" href="#@" onclick="document.actionDownloadPDF.submit();">
        <img src="/corporativo/servicos/bbhive/images/mime-pdf.gif" width="16" height="16" align="absmiddle" border="0"/>
          '.$titulo.'
        </a>';
}
//--
if($row_relatorios['bbh_rel_pdf']=='1') {
	if(file_exists($cmRelat)){
?>
<br />
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="584" height="33" background="/corporativo/servicos/bbhive/images/backTopII.jpg" style="border-left:#D7D7D7 solid 1px;">
    <div id="acao" style="width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong>Laudo</strong></div>
    
	<label style="position:absolute; margin-top:-25px; margin-left:130px;" class="verdana_12"></label>
    <div id="menAcao" class="verdana_11 color" style="position:absolute;z-index:500000; margin-top:-27px; margin-left:280px">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td height="30" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px" id="sub" class="verdana_11 color"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="22" bgcolor="#F3F3F7"><?php
		if($_SESSION['usuCod'] == $row_relatorios['bbh_usu_codigo']){//Sou dono então não tenho restrição
			
			echo linkDownload($row_relatorios['bbh_rel_titulo']);
		
		} elseif($row_relatorios['bbh_rel_protegido'] == '0'){//Não dou o dono só exibo se não tiver protegido
			
			echo linkDownload($row_relatorios['bbh_rel_titulo']);
			
		} else {//Não sou o dono e está protegido
			
			echo "Download protegido pelo autor";		
		}
		?>
        </td>
        </tr>
      <tr>
        <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
        </tr>
   
      <tr>
        <td height="22">&nbsp;</td>
      </tr>
        
    </table></td>
  </tr>
</table><?php  } else { 
   					$naoLink = 0;
   					$_SESSION['naoFile'] = true;?>
<table width="595" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="584" height="33" background="/corporativo/servicos/bbhive/images/backTopII.jpg" style="border-left:#D7D7D7 solid 1px;">
    <div id="acao" style="width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold; color:#F00" class="verdana_12">&nbsp;<strong>Aten&ccedil;&atilde;o</strong></div>
    
	<label style="position:absolute; margin-top:-25px; margin-left:130px;" class="verdana_12"></label></td>
  </tr>
  <tr>
    <td height="30" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px; color:#F00;" id="sub" class="verdana_12 color"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr onclick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|relatorios/painel/index.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>','menuEsquerda|colPrincipal');" title="Clique para gerenciar o <?php echo $_SESSION['relNome']; ?>" style="cursor:pointer">
        <td height="22" bgcolor="#F3F3F7">
		&nbsp;Existe <?php echo $_SESSION['relNome']; ?> pronto, por&eacute;m o mesmo n&atilde;o foi gerado. Clique em gerar PDF no ambiente de gerenciamento de <?php echo $_SESSION['relNome']; ?>.</td>
        </tr>
        
    </table></td>
  </tr>
</table>
                    <?php
 				}
} ?>