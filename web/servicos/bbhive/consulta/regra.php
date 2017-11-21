<?php if (!isset($_SESSION)) {  session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
ini_set("display_errors",true);
$pagina = "protocolos/regra.php?";
//-----------------------------------------------------------------------------------------

$url = "";
//----------------------------------------------------------------------------------------------------

$Inicio	= isset($inicio) && $inicio > 0 ? $inicio : 0;
$maximo = 20;

//SQL PADRÃO PARA EXECUÇÃO DE DADOS DESTA PÁGINA
 $sqlPadrao = "select bbh_arq_codigo, bbh_flu_codigo,
		 DATE_FORMAT(bbh_arq_data_modificado, '%d/%m/%Y %H:%i:%s') as publicado,
		 bbh_arq_tipo as tipo,
		 bbh_arq_titulo as titulo,
		 bbh_arq_autor as autor,
		 bbh_arq_mime,
		 bbh_arq_compartilhado,
		 bbh_arq_publico,
		 bbh_arquivo.bbh_flu_codigo,
		 concat(bbh_arq_localizacao,'/',bbh_arq_nome) arquivo,
		 bbh_arq_obs_publico
		from bbh_arquivo 
			Where bbh_arquivo.bbh_arq_publico = 1 
		  	 ORDER BY bbh_arquivo.bbh_flu_codigo DESC, bbh_arq_codigo ASC  LIMIT $Inicio,$maximo";
//----------------------------------------------------------------------------------------------------
list($fluxos, $row_fluxos, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $sqlPadrao, $initResult = false);

//total de protocolos sem fluxo
//$totNovas = total($database_bbhive, $bbhive, "SELECT * FROM bbh_protocolos Where bbh_pro_status is NULL");
//total de todos os protocolos para paginação
$totpagina= $totalRows_strProtocolo;

//lógica para paginação com todos os dados do GET
	//Primeiro------------------------------------------------------------------------------------------------------
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
?>
<table width="970" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="518" height="28" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px;">
    <div style="position:absolute;margin-left:475px;" id="loadTudo"></div>
    &nbsp;<img src="/servicos/bbhive/images/profile.gif" align="absmiddle" />&nbsp;<strong><?php echo $_SESSION['MM_User_email']; ?></strong>
   
    </td>
    <td width="320" align="right" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11">&nbsp;</td>
    <td width="124" align="right" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-right:#cccccc solid 1px;">&nbsp;</td>
  </tr>
  <tr>
    <td height="80" colspan="3" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
   
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="300" valign="top" bgcolor="#F6F6F6" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="1" bgcolor="#EDEDED"></td>
              </tr>
            </table>
            <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"  class="borderAlljanela legandaLabel11" style="margin-top:5px;">
              <tr>
                <td width="75%" height="22" background="/servicos/bbhive/images/barra_horizontal2.jpg"><strong>&nbsp;<?php echo $_SESSION['arqPublNome']; ?></strong></td>
                <td width="12%" background="/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Criado em</strong></td>
                <td width="9%" background="/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Tamanho</strong></td>
                <td width="4%" background="/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
              </tr>
              
<?php 
$codFlu = 0;
$corFundo="";
while($row_fluxos = mysqli_fetch_assoc($fluxos)){ $exite = true;

		$oMime		= ("mime-".strtolower($row_fluxos['tipo']) . ".gif");

		  if(!file_exists("../../../../datafiles/servicos/bbhive/images/mimes/".$oMime)){
			  $oMime = "mime-etc.gif";
		  }
				//--
				$caminhoFile	= $dirPacote[0]."database/servicos/bbhive/".$row_fluxos['arquivo'];
			//--	
			if($corFundo == "#ffffff") { $corFundo="#F5F5F5"; } else{ $corFundo="#ffffff"; } $corFundo = $corFundo;
?>
              <tr style="cursor:pointer;" bgcolor="<?php echo $corFundo; ?>">
                <td height="22" valign="top">&nbsp;<a href="/servicos/bbhive/consulta/download/index.php?file=<?php echo $row_fluxos['bbh_arq_codigo']; ?>" title="Download de <?php echo $row_fluxos['titulo']; ?>" target="_blank">&nbsp;&nbsp;
             <?php echo '<img src="'.$CaminhoIconesMime."/".$oMime.'" alt="" border="0" align="absmiddle"  />'?>
            &nbsp;<?php echo $t = $row_fluxos['titulo']; ?>
            <div class="color" style="margin-left:20px; margin-top:2px; margin-bottom:2px;">
            	<?php 
				$v = strpos($row_fluxos['bbh_arq_obs_publico'],"<br />");
					if(!strlen($v)>0){
						echo nl2br($row_fluxos['bbh_arq_obs_publico']);
					} else {
						echo $row_fluxos['bbh_arq_obs_publico'];	
					}?>
            </div> </a>
                </td>
                <td valign="top"><?php echo $d=substr($row_fluxos['publicado'],0,16); ?></td>
                <td valign="top">&nbsp;<?
echo TamanhoArquivo($caminhoFile);
?></td>
                <td align="center" valign="top"><img src="/servicos/bbhive/images/application_add.gif" align="absmiddle" border="0" onclick="OpenAjaxPostCmd('/servicos/bbhive/consulta/envia_protocolo.php','montaForm','?id=<?php echo $row_fluxos['bbh_flu_codigo']; ?>','Aguarde','montaForm','2','2')" style="cursor:pointer" title="Criar solicitação a partir deste registro"/></td>
              </tr>
  <?php } ?>
  <?php if(!isset($exite)){ ?>
          <tr>
            <td height="25" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF" class="verdana_11 color">N&atilde;o h&aacute; registros cadastrados</td>
          </tr>
 <?php } ?>  

            </table>
        <div class="verdana_12" align="center" style="margin-top:5px;">
    	<?php 
		//PAGINAÇÃO
			echo isset($primeira) ? $primeira."&nbsp;&nbsp;" : "";
			echo isset($anterior) ? $anterior."&nbsp;&nbsp;" : "";
			echo isset($proximo)  ? $proximo."&nbsp;&nbsp;"  : "";
			echo isset($ultima)   ? $ultima."&nbsp;&nbsp;"   : "";
		?>
        </div>
            </td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"><?php require_once('../includes/rodape.php'); ?></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<div id="montaForm"></div>