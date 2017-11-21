<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

if(isset($_SESSION['dtAtual'])){ unset($_SESSION['dtAtual']); }
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a ".mysqli_fetch_assoc("página")." para o tipo de ".$_SESSION['FluxoNome']." - BBHive.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/

$TimeStamp 		= time();
$homeDestino1	= '/corporativo/servicos/bbhive/fluxo/busca/busca.php?Ts='.$TimeStamp."&inicia=x&cod_pro_codigo=".$_GET['bbh_pro_codigo']."&bbh_tip_flu_codigo=".$_GET['bbh_tip_flu_codigo'];
$onClick  		= "onclick=\"OpenAjaxPostCmd('".$homeDestino1."','resultBusca','&1=1','Consultando informa&ccedil;&otilde;es...','resultBusca','2','2');\"";

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/fluxo/busca/busca.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'resultBusca';
	$infoGet_Post	= 'form1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Consultando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
		//chama página de busca
	$envolvido="";
	
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/fluxo/busca/busca.php?'.$envolvido.'Ts='.$TimeStamp."&cod_pro_codigo=".$_GET['bbh_pro_codigo']."&bbh_tip_flu_codigo=".$_GET['bbh_tip_flu_codigo'];
	$carregaPagina5  = "OpenAjaxPostCmd('".$homeDestino."','resultBusca','&1=1','Carregando informa&ccedil;&otilde;es...','resultBusca','2','2');";
?>
<var style="display:none">txtSimples('tagPerfil', 'Consulta <?php echo $_SESSION['FluxoNome']; ?>')</var>
<?php
//se tiver setado nº de protocolo exibe o cabeçalho do mesmo
 if(isset($_GET['bbh_pro_codigo'])){	
	require_once('../../protocolo/cabecaProtocolo.php');
 }
?>
<form name="form1" id="form1" style="margin-top:-1px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td colspan="2" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong>Console de busca <?php echo $_SESSION['FluxoNome']; ?></strong>       <label style="float:right;">
     <a href="#" onclick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/busca/regra.php?cod_pro_codigo=<?php echo $_GET['bbh_pro_codigo'];?>&anexar_fluxo=true&bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?>','menuEsquerda|colPrincipal')">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
        <span class="color"><strong>Voltar</strong></span>     </a>    </label></td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_11"><?php 
		$nProt	= "8px";
		$nDtP	= "3px";
		$ofc	= "56px";
		require_once("../../consulta/busca_protocolo.php"); ?></td>
    </tr>
      <tr>
        <td width="4%" height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="busca_nome" id="busca_nome" <?php echo isset($_POST['busca_nome'])?"checked":""; ?> />
        </label></td>
        <td width="96%" class="verdana_11">&nbsp;Nome do <?php echo $_SESSION['FluxoNome']; ?> &nbsp;&nbsp;&nbsp;:&nbsp;
<label>
          <input name="bbh_busca_nome" type="text" id="bbh_busca_nome" <?php echo isset($_POST['bbh_busca_nome'])?$_POST['bbh_busca_nome']:""; ?> size="40" class="back_Campos"  style="height:17px;border:#E3D6A4 solid 1px;"/>
        </label>        
        </td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="busca_data" id="busca_data" <?php echo isset($_POST['busca_data'])?"checked":""; ?> />
        </label></td>
        <td class="verdana_11">&nbsp;<label class="verdana_9" style="margin-top:2px;">De :
            <input name="DataInicio" type="text" class="formulario2" id="DataInicio" value="<?php echo isset($_POST['DataInicio'])?$_POST['DataInicio']: date('d/m/Y'); ?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
            <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.DataInicio,'dd/mm/yyyy',this)"/>
        </label>
          <label> At&eacute; :
          <input name="DataFim" type="text" class="formulario2" id="DataFim" value="<?php echo isset($_POST['DataFim'])?$_POST['DataFim']: date('d/m/Y'); ?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
          <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.DataFim,'dd/mm/yyyy',this)"/>
          </label>
      <?php
		$homeDestino	= '/corporativo/servicos/bbhive/fluxo/busca/busca.php?Ts='.$TimeStamp."&decisao=xxx&buscaDia=true&cod_pro_codigo=".$_GET['bbh_pro_codigo']."&bbh_tip_flu_codigo=".$_GET['bbh_tip_flu_codigo'];
		$carregaPagina  = "OpenAjaxPostCmd('".$homeDestino."','resultBusca','&1=1','Carregando informa&ccedil;&otilde;es...','resultBusca','2','2');";
	   ?></td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><input type="checkbox" name="busca_envolvido" id="busca_envolvido" <?php if(isset($_GET['envolvidos'])){ echo 'checked="checked"'; } ?>/></td>
        <td class="verdana_11">&nbsp;<?php echo $_SESSION['FluxoNome']; ?> que participo</td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="right" bgcolor="#EFEFE7" class="verdana_11"><input name="bbh_tip_flu_codigo" type="hidden" id="bbh_tip_flu_codigo" value="<?php echo $_GET['bbh_tip_flu_codigo']; ?>">
          <input name="cod_pro_codigo" type="hidden" id="cod_pro_codigo" value="<?php echo $_GET['bbh_pro_codigo']; ?>">
        <input class="formulario2" id="web" type="button" value="Pesquisar" name="web"  style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return <?php echo $acao; ?>"/>&nbsp;</td>
      </tr>
      <tr>
        <td height="1" colspan="2" align="right" bgcolor="#FFFFFF" class="verdana_11"></td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="right" bgcolor="#EFEFE7" class="verdana_11">
        <label style="float:left;" id="dtPesquisa"></label>
        <label style="float:right;">
      <a href="#" onClick="return <?php echo str_replace("decisao=xxx","Menos=1",$carregaPagina); ?>">
        <img src="/corporativo/servicos/bbhive/images/voltar.gif" border="0" align="absmiddle"> Dia anterior      </a> | 
      <a href="#" onClick="return <?php echo str_replace("decisao=xxx","Mais=1",$carregaPagina); ?>">
        Pr&oacute;ximo dia 	<img src="/corporativo/servicos/bbhive/images/proximoII.gif" border="0" align="absmiddle">      </a>    </label>        </td>
      </tr>
  </table>
</form>    
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
      
<tr>
        <td width="56" height="1"></td>
        <td width="155" valign="top" height="1"></td>
        <td height="1"></td>
        <td width="55" height="1"></td>
        <td width="155" valign="top" height="1"></td>
  </tr>
      <tr>
        <td height="26" colspan="5" align="left" background="/corporativo/servicos/bbhive/images/back_msg.jpg"><label style="margin-left:5px"><a href="#" <?php echo str_replace("inicia=x","inicia=a",$onClick)?>>A</a></label>

            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=b",$onClick)?>>B</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=c",$onClick)?>>C</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=d",$onClick)?>>D</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=e",$onClick)?>>E</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=f",$onClick)?>>F</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=g",$onClick)?>>G</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=h",$onClick)?>>H</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=i",$onClick)?>>I</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=j",$onClick)?>>J</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=k",$onClick)?>>K</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=l",$onClick)?>>L</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=m",$onClick)?>>M</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=n",$onClick)?>>N</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=o",$onClick)?>>O</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=p",$onClick)?>>P</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=q",$onClick)?>>Q</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=r",$onClick)?>>R</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=s",$onClick)?>>S</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=t",$onClick)?>>T</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=u",$onClick)?>>U</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=v",$onClick)?>>V</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=x",$onClick)?>>X</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=y",$onClick)?>>Y</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=w",$onClick)?>>W</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=z",$onClick)?>>Z</a></label> 
            -&nbsp;
          <label><a href="#" <?php echo str_replace("inicia=x","inicia=true",$onClick)?>>todos</a></label>        </td>
      </tr>
      <tr>
        <td height="1" colspan="5" align="center" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
</table>
    <div id="resultBusca" class="verdana_12"></div>
	<var style="display:none"><?php echo $carregaPagina5; ?></var>