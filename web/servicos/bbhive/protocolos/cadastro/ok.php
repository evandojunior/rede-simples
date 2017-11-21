<?php if (!isset($_SESSION)) {  session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/protocolos/cadastro/detalhamento/includes/functions.php");

	//POIS VOU REDIRECIONAR PARA O OK.PHP
	$arquivo = "../../../../datafiles/servicos/bbhive/setup/config.xml";

	$query_strProtocolo = "SELECT bbh_protocolos.*, bbh_dep_nome, r.bbh_usu_nome, u.bbh_usu_nome as protocolado 
			from bbh_protocolos 
		  		inner join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
		  		left join bbh_usuario as r on bbh_protocolos.bbh_pro_recebido = r.bbh_usu_identificacao 
		  		left join bbh_usuario as u on bbh_protocolos.bbh_pro_email = u.bbh_usu_identificacao
		  			Where bbh_pro_codigo =".$_SESSION['idProtocolo'];

    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);

	//Verificar se está finalizado
	$CriouRelatorio=0;

		$query_rel = "select MAX(r.bbh_rel_codigo) as bbh_rel_codigo, bbh_rel_titulo from bbh_protocolos as p
					  inner join bbh_fluxo as f on p.bbh_flu_codigo = f.bbh_flu_codigo
					  inner join bbh_atividade as a on f.bbh_flu_codigo = a.bbh_flu_codigo
					  inner join bbh_modelo_atividade as ma on a.bbh_mod_ati_codigo = ma.bbh_mod_ati_codigo
					  inner join bbh_relatorio as r on a.bbh_ati_codigo = r.bbh_ati_codigo
					   Where ma.bbh_mod_ati_relatorio = '1' AND r.bbh_rel_pdf='1' AND p.bbh_pro_codigo = ".$_SESSION['idProtocolo'];
        list($rel, $row_rel, $totalRows_rel) = executeQuery($bbhive, $database_bbhive, $query_rel);
		$CriouRelatorio = $row_rel['bbh_rel_codigo'] > 0 ? 1 : 0;
	//--

	$arquivo = "../../../../datafiles/servicos/bbhive/setup/config.xml";

	//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($arquivo);
		//-----	
		$root = $doc->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		$digitalizar 	= $prot->getAttribute("digitalizar");
		$indicios 		= $prot->getAttribute("indicios");
		$imprimir 		= $prot->getAttribute("imprimir");
		//$detalhamento 	= $prot->getAttribute("detalhamento");
		
	//status com base no vetor
	$codSta		= $row_strProtocolo['bbh_pro_status'];
	$cada	 	= explode("|",$status[$codSta]);
	$situacao 	= $cada[0];
	$corFundo 	= $cada[1];	
	
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Acessou a página de visualização do (".$_SESSION['protNome'].") número (".$_SESSION['idProtocolo'].")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
?><?php require_once("../includes/cabecaProtocolo.php"); ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">
    <div style="float:left">
    &nbsp;<img src="/servicos/bbhive/images/visto.gif" align="absmiddle" />&nbsp;<strong><?php if(!isset($_GET['consulta'])){ echo "Cadastro efetuado com sucesso!!!"; } else { echo "Consulta de solicita&ccedil;&atilde;o!!!"; } ?></strong>
    </div>
    <div style="float:right">
    <div class="legandaLabel11 tbConsulta" style="border:#CCCCCC solid 1px; height:20px; margin-right:5px; width:110px; float:right;" align="center"> <a href="#@" onClick="return showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/passo1.php','colPrincipal');"  style="width:95px;"> &nbsp;<img src="/servicos/bbhive/images/application_add.gif" align="absmiddle" border="0"/>&nbsp;Novo cadastro</a> </div>
    </div>
    </td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="250" valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height="25" align="left"><img src="/servicos/bbhive/images/messagebox_warning.gif" align="absmiddle" />&nbsp;ATEN&Ccedil;&Atilde;O - IMPRIMA ESTE COMPROVANTE PARA FUTURA CONSULTA.</td>
    </tr>
  <tr>
    <td height="5" align="right"></td>
    </tr>
  <tr>
    <td height="25" align="left" bgcolor="#FFFFFF" style="border-bottom:#5A5A5A solid 1px; border-top:#5A5A5A solid 1px;"><span class="legandaLabel16"><strong><?php echo ($_SESSION['protNome']); ?> :</strong>&nbsp;<?php echo $row_strProtocolo['bbh_pro_codigo']; ?></span></td>
    </tr>
  <tr>
    <td height="5" align="right"></td>
    </tr>
  <tr>
    <td height="25"  align="left">
<table width="930" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="283" height="25" align="left" class="verdana_11"><strong>&nbsp;Data de cadastro :</strong></td>
    <td width="647" height="25" align="left" class="verdana_11"><?php echo $d = arrumadata(substr($row_strProtocolo['bbh_pro_momento'],0,10))." ".substr($row_strProtocolo['bbh_pro_momento'],11,5); ?></td>
  </tr>
</table>
	<?php require_once("detalhamento/lista.php"); ?></td>
    </tr>

</table></td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php if(isset($_GET['consulta'])){ 

	$query_strProtocolo = "SELECT * FROM bbh_protocolos WHERE bbh_pro_codigo = ".$_SESSION['idProtocolo'];
    list($strProtocolo, $row_strProtocolo, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);
	
	$andamento = "0";
	if($row_strProtocolo['bbh_flu_codigo']!=NULL){
		$codFluxo = $row_strProtocolo['bbh_flu_codigo'];
		$temFluxo = 1;
	}
	
?><br />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/icon_lado.gif" align="absmiddle" />&nbsp;<strong>Situa&ccedil;&atilde;o da solicita&ccedil;&atilde;o</strong>
      <label style="margin-left:205px;"></label>
    </td>
  </tr>
  <tr>
    <td height="80" valign="top" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              
              <tr>
                <td width="100%" height="1" bgcolor="#EDEDED"></td>
              </tr>
              
              <tr>
                <td height="25" align="left">
                <fieldset style="margin-top:2px; margin-bottom:2px;">
                    <legend class="legandaLabel11">Informa&ccedil;&otilde;es - <?php echo ($_SESSION['protNome']); ?></legend>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
                          <tr style="background-color:<?php echo $corFundo; ?>">
                            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/engrenagem.gif" alt="" border="0" align="absmiddle"></td>
                            <td height="25"><strong>Situa&ccedil;&atilde;o: <span style="color:#033"><?php echo converte($situacao); ?></span></strong></td>
                          </tr>
                          <?php if($codSta!="1") { ?>
                          <tr>
                            <td height="25" align="center">&nbsp;</td>
                            <td height="25"><strong>Recebido por:&nbsp;<span style="color:#F60"><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;<?php echo !empty($row_strProtocolo['bbh_usu_nome']) ? $row_strProtocolo['bbh_usu_nome'] : $row_strProtocolo['bbh_pro_recebido']; ?></span></strong></td>
                          </tr>
                          <tr>
                            <td width="9%" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" alt="" border="0" align="absmiddle"></td>
                            <td width="91%">&nbsp;<strong><span style="color:#F60">Em:</span>&nbsp;<?php echo arrumadata(substr($row_strProtocolo['bbh_pro_dt_recebido'],0,10)) ." ".substr($row_strProtocolo['bbh_pro_dt_recebido'],11,5); ?></strong></td>
                          </tr>
                          <?php } ?>
                        </table>
                      </fieldset>
                
                </td>
              </tr>
			<?php if(isset($temFluxo)){ ?> 
              <tr>
                <td height="25" align="left">
                	<?php require_once('fluxo.php'); ?>
                </td>
              </tr>
		   <?php } ?>
           <?php if($codSta==5 && $CriouRelatorio>0) { $_SESSION['usuCod'] = $_SESSION['MM_BBhive_Codigo']; ?>              
              <tr>
                <td height="25" align="left" style="color:#36C">
				<?php
                    $query_relatorios = "SELECT bbh_relatorio.bbh_usu_codigo, bbh_rel_protegido FROM bbh_relatorio 
                        inner join bbh_atividade on bbh_relatorio.bbh_ati_codigo = bbh_atividade.bbh_ati_codigo
                        WHERE bbh_rel_codigo = ".$row_rel['bbh_rel_codigo']." and bbh_rel_pdf='1' 
                            GROUP BY bbh_relatorio.bbh_rel_codigo order by bbh_rel_codigo desc LIMIT 0,1";
                    list($relatorios, $row_relatorios, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relatorios);
                //--	  
                if($_SESSION['usuCod'] == $row_relatorios['bbh_usu_codigo']){//Sou dono então não tenho restrição
                    echo 'Download : <a title="Download do '.$row_rel['bbh_rel_titulo'].'" href="#@" onclick="document.actionDownloadPDF.submit();"> <img src="/corporativo/servicos/bbhive/images/mime-pdf.gif" width="16" height="16" align="absmiddle" border="0"/> '.$row_rel['bbh_rel_titulo'].' </a>';
                
				} elseif($row_relatorios['bbh_rel_protegido'] == '0'){//Não dou o dono só exibo se não tiver protegido
                    echo 'Download : <a title="Download do '.$row_rel['bbh_rel_titulo'].'" href="#@" onclick="document.actionDownloadPDF.submit();"> <img src="/corporativo/servicos/bbhive/images/mime-pdf.gif" width="16" height="16" align="absmiddle" border="0"/> '.$row_rel['bbh_rel_titulo'].' </a>';
					
                } else {//Não sou o dono e está protegido
                    echo '<span style="color:#999">Download protegido pelo autor</span>';		
                }
                ?>                
                </td>
              </tr>
           <?php } ?>  
            </table>
            </td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>

<form name="actionDownloadPDF" id="actionDownloadPDF" action="/corporativo/servicos/bbhive/relatorios/painel/download.php" target="_blank" method="post">
<input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
    <input type="hidden" name="bbh_rel_codigo" id="bbh_rel_codigo" value="<?php echo $row_rel['bbh_rel_codigo']; ?>" />
</form>

<p>
  <?php } ?>
</p>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="3" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<strong>Arquivos digitalizados</strong></td>
  </tr>
  <?php $cont = 0;
if ($handle = @opendir(str_replace("web","database",$_SESSION['caminhoFisico'])."/servicos/bbhive/protocolo/protocolo_".$_SESSION['idProtocolo']."/.")) {


while (false !== ($file = readdir($handle))) {
  if ($file != "." && $file != "..") {

		$excluir ="&nbsp;";
		  if(empty($bbh_flu_codigo)){ 
		  	$excluir = "";//"<a href='#@' onClick=\"document.removeArquivo.bbh_pro_arquivo.value='".$file."'; document.removeArquivo.bbh_pro_codigo.value='".$_SESSION['idProtocolo']."'; document.removeArquivo.submit();\"><img src='/corporativo/servicos/bbhive/images/excluir.gif' alt='Excluir arquivo' width='17' height='17' border='0'></a>";
		  }

		echo "<tr class='verdana_12'>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'><a href='#@' onClick='javascript: document.getElementById(\"bbh_pro_arquivo\").value=\"".$file."\"; document.abreArquivo.bbh_pro_codigo.value=\"".$_SESSION['idProtocolo']."\"; document.abreArquivo.submit();'><img src='/corporativo/servicos/bbhive/images/download.gif' alt='Download do arquivo' width='17' height='17' border='0'></a></td>
                <td width='90%' align='left' bgcolor='#FFFFFF' class='verdana_11' style='border-bottom:#cccccc solid 1px;'>&nbsp;".$file."</td>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'>&nbsp;</td>
              </tr>
              <tr>
                <td height='1' colspan='3' align='right' background='/servicos/bbhive/images/separador.gif'></td>
              </tr>";
$cont++; 
		if ($cont == 300) {
		die;
		}
     }
  }
 closedir($handle);
}
?> 
<?php if($cont==0){?>
  <tr>
    <td height="20" colspan="3" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe arquivos digitalizados</td>
  </tr>
<?php } ?>
</table>
<br />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="3" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/historico.gif" alt="" border="0" align="absmiddle" />&nbsp;<strong>(<label id="totDesp">0</label>) Histórico - <?php echo ($_SESSION['despachoprotLegenda']); ?></strong></td>
  </tr>
  <tr>
    <td height="20" colspan="3" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;"><?php require_once("despachos/despacho.php"); ?></td>
  </tr>

</table><br />
<?php require_once("../indicios/index.php"); ?>
<?php /*
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="4" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" alt="" align="absmiddle" />&nbsp;<strong>Ind&iacute;cios cadastrados</strong></td>
  </tr>
  <?php $cod=0; $dep=0;
  while($row_ind = mysqli_fetch_assoc($ind)){
  	if($dep!=$row_ind['bbh_dep_codigo']){
  ?>
  <tr>
    <td height="20" colspan="4" class="titulo_setor" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><?php echo $row_ind['bbh_dep_nome']; ?></td>
  </tr>
  <?php }
  if($cod!=$row_ind['bbh_tip_codigo']){ 
  		$txt = explode("*|*",$row_ind['bbh_tip_campos']);
		$cp1 = !empty($txt[0]) ? $txt[0] : "Campo1";
		$cp2 = !empty($txt[1]) ? $txt[1] : "Campo2";
  ?>
  <tr>
    <td height="20" colspan="4" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;&nbsp;&nbsp;<strong><u><?php echo $row_ind['bbh_tip_nome']; ?></u></strong></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="3" class="legandaLabel11" style="border-bottom:#cccccc solid 1px; border-right:#cccccc solid 1px;">
    <?php echo "<strong>".$cp1 . "</strong>: ".$row_ind['bbh_ind_campo1']; ?>
    </td>
  </tr>
  <tr>
    <td height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="3" class="legandaLabel11" style="border-bottom:#cccccc solid 1px; border-right:#cccccc solid 1px;">
    <?php echo "<strong>".$cp2 . "</strong>: ".$row_ind['bbh_ind_campo2']; ?>
    </td>
  </tr>
  <tr>
    <td height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="3" class="legandaLabel11" style="border-bottom:#cccccc solid 1px; border-right:#cccccc solid 1px;">
      	<div style="float:left"><strong>Quantidade</strong>:&nbsp;<?php echo $row_ind['bbh_ind_quantidade']; ?></div>
        <div style="float:left; margin-left:100px;"><strong>Unidade de medida</strong>:&nbsp;<?php echo unidadeMedida($row_ind['bbh_ind_unidade'], 1); ?></div>
    </td>
  </tr>
  <tr>
    <td width="29" height="20" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td width="409" height="20" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></td>
    <td width="128" height="20" colspan="2" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;border-right:#cccccc solid 1px;" title="Código de barras"><?php echo $cd=$row_ind['bbh_ind_codigo_barras']; ?>&nbsp;</td>
  </tr>
  <?php $cod=$row_ind['bbh_tip_codigo']; $dep=$row_ind['bbh_dep_codigo'];
  } ?>
  <?php if($totalRows_ind==0){?>
  <tr>
    <td height="20" colspan="4" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe registros cadastrados</td>
  </tr>
  <?php } ?>
</table>*/?><p>&nbsp;</p>
<form id="abreArquivo" name="abreArquivo" action="/servicos/bbhive/protocolos/download/anexos.php" method="post" style="position:absolute" target="_blank">
<input name="bbh_pro_arquivo" id="bbh_pro_arquivo" type="hidden" value="0" />
<input name="bbh_pro_codigo" id="bbh_pro_codigo" type="hidden" value="0" />
</form>