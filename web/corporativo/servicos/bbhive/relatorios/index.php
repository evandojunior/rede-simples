<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//if(isset($_SESSION['dtAtual'])){ unset($_SESSION['dtAtual']); }
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a página de relatórios - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/

//DESCISÃO SE A BUSCA INICIAL É POR TODOS OU ESPECÍFICO===========================================
$condicao="&filtro=aberto";

if(isset($_GET['filtro'])){
	if($_GET['filtro']=="aberto"){	
		$condicao = "&filtro=aberto";
	} elseif($_GET['filtro']=="fechado"){
		$condicao = "&filtro=fechado";
	}
}
//================================================================================================

//PÁGINA PADRÃO DE RESULTADO DA BUSCA=============================================================
$destinoBusca = '/corporativo/servicos/bbhive/relatorios/index.php?Ts='.time() . $condicao;
//================================================================================================

//ESTRUTURA ASSÍNCRONA, APENAS STRING=============================================================
$chamadaAJAX	= "OpenAjaxPostCmd('PAGINADESTINO','conteudoGeral','infoGet_Post','Consultando informa&ccedil;&otilde;es...','conteudoGeral','METODO','2');";//1-POST  2-GET
//================================================================================================
if( !isset($buscaPorIniciais) ) $buscaPorIniciais = '';
if( !isset($buscaPorDia) ) 		$buscaPorDia= '';
$onClick 		= str_replace("METODO","2",str_replace("infoGet_Post","&1=1",str_replace("PAGINADESTINO", $buscaPorIniciais ,$chamadaAJAX)));
$carregaPagina	= str_replace("METODO","2",str_replace("infoGet_Post","&1=1",str_replace("PAGINADESTINO", $buscaPorDia ,$chamadaAJAX)));
$acao			= str_replace("METODO","1",str_replace("infoGet_Post","form1",str_replace("PAGINADESTINO", $destinoBusca ,$chamadaAJAX)));

//-------------------------
require_once("includes/parametros_consulta.php");
//--
?>
<var style="display:none">txtSimples('tagPerfil', 'Consulta <?php echo $_SESSION['relNome']; ?>')</var>

<div class="verdana_11">
    <div style="float:left;border-bottom:#069 solid 1px;" class="verdana18">
        <strong><?php echo $_SESSION['relNome']; ?></strong>
    </div>
    <div style="float:right">
                 <a href="#@" onclick="if(document.getElementById('consoleBusca').style.display=='none'){document.getElementById('consoleBusca').style.display='block'; }else{document.getElementById('consoleBusca').style.display='none';}">
                    <img src="/corporativo/servicos/bbhive/images/avancada.gif" border="0" align="absmiddle" />&nbsp;<strong>Busca simples</strong>
         </a>
        </div>
</div>
<div style="clear:both"></div>
<div style="display:none" id="consoleBusca">
<form name="form1" id="form1" style="margin-top:-1px;">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
      <tr>
        <td colspan="2" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong>Console de busca <?php echo $_SESSION['relNome']; ?></strong>
        <label style="float:right; ">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="#@" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&perfis=1|principal.php','menuEsquerda|conteudoGeral')";>
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>        </td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_11"><?php 
		$nProt	= "9px";
		$nDtP	= "4px";
		$ofc	= "56px";
		$desc	= "35px";
		require_once("../consulta/busca_protocolo.php"); ?></td>
      </tr>
      <tr>
        <td width="4%" height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="busca_nome" id="busca_nome" <?php echo pesquisaVetor("0", "busca_nome", ""); ?> />
        </label></td>
        <td width="96%" class="verdana_11">&nbsp;T&iacute;tulo do relat&oacute;rio:&nbsp;
          <label>
          <input name="bbh_busca_nome" type="text" id="bbh_busca_nome" value="<?php echo pesquisaVetor("1", "busca_nome", ""); ?>" size="40" class="back_Campos"  style="height:17px;border:#E3D6A4 solid 1px;"/>
        </label>        </td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="busca_data" id="busca_data" <?php echo pesquisaVetor("0", "busca_data", ""); ?> />
        </label></td>
        <td class="verdana_11">&nbsp;<label class="verdana_9" style="margin-top:2px;">De :
            <input name="DataInicio" value="<?php 
			
			$d = pesquisaVetor("1", "busca_data", "0");
			echo empty($d)?date('d/m/Y'):$d; 
			
			?>" type="text" class="formulario2" id="DataInicio" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
            <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.DataInicio,'dd/mm/yyyy',this)"/>
        </label>
          <label> At&eacute; :
          <input name="DataFim" value="<?php 
			
			$d = pesquisaVetor("1", "busca_data", "1");
			echo empty($d)?date('d/m/Y'):$d; 
			
			?>" type="text" class="formulario2" id="DataFim"  size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
          <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.DataFim,'dd/mm/yyyy',this)"/>
          </label>
	</td>
      </tr>
      <tr>
        <td height="1" colspan="2" align="left" bgcolor="#EFEFE7" class="verdana_11">
        	<div style="display:none">
            	<div style="float:left; width:40px;" align="center"><input type="checkbox" name="situacao" id="situacao" <?php echo pesquisaVetor("0", "situacao", ""); ?>/></div>
                <div style="float:left; width:320px;" align="left">&nbsp;<strong>Relatórios: "<?php echo pesquisaVetor("1", "situacao", ""); ?>" <input name="bbh_situacao" type="hidden" value="<?php echo pesquisaVetor("1", "situacao", ""); ?>" class="back_Campos" id="bbh_situacao"  style="height:17px;border:#E3D6A4 solid 1px;" size="20" maxlength="20"/></strong></div>
            </div>
        </td>
    </tr>
      <tr>
        <td height="22" colspan="2" align="right" bgcolor="#EFEFE7" class="verdana_11">
        <div style="float:left">
        	<div style=" <?php echo pesquisaVetor("0", "inicia", "")!="checked"?"visibility:hidden":""; ?>">
            	<div style="float:left; width:40px;" align="center"><input type="checkbox" name="inicia" id="inicia" <?php echo pesquisaVetor("0", "inicia", ""); ?>/></div>
                <div style="float:left; width:320px;" align="left">&nbsp;<strong>Iniciado com a letra: "<?php echo pesquisaVetor("1", "inicia", ""); ?>" <input name="bbh_inicia" type="hidden" value="<?php echo pesquisaVetor("1", "inicia", ""); ?>" class="back_Campos" id="bbh_inicia"  style="height:17px;border:#E3D6A4 solid 1px;" size="20" maxlength="20"/></strong></div>
            </div>
        </div>
        <div style="float:right">
        <input class="formulario2" id="web" type="button" value="Pesquisar" name="web"  style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return <?php echo $acao; ?>"/>&nbsp;
        </div></td>
      </tr>
      <tr>
        <td height="1" colspan="2" align="right" bgcolor="#FFFFFF" class="verdana_11"></td>
      </tr>
  </table>
</form>   
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9" style="margin-left:5px;">
      
<tr>
        <td width="56" height="1"></td>
        <td width="155" valign="top" height="1"></td>
        <td height="1"></td>
        <td width="55" height="1"></td>
        <td width="155" valign="top" height="1"></td>
      </tr>
      <tr>
        <td height="26" colspan="5" align="left" background="/corporativo/servicos/bbhive/images/back_msg.jpg">
<?php
        	$busca_porPalavra = "onclick=\"document.getElementById('bbh_inicia').value='XXX'; document.getElementById('inicia').checked=true;".$acao."\"";
		?>
      <label style="margin-left:5px"><a href="#@" <?php echo str_replace("XXX","a",$busca_porPalavra)?>>A</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","b",$busca_porPalavra)?>>B</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","c",$busca_porPalavra)?>>C</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","d",$busca_porPalavra)?>>D</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","e",$busca_porPalavra)?>>E</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","f",$busca_porPalavra)?>>F</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","g",$busca_porPalavra)?>>G</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","h",$busca_porPalavra)?>>H</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","i",$busca_porPalavra)?>>I</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","j",$busca_porPalavra)?>>J</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","k",$busca_porPalavra)?>>K</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","l",$busca_porPalavra)?>>L</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","m",$busca_porPalavra)?>>M</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","n",$busca_porPalavra)?>>N</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","o",$busca_porPalavra)?>>O</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","p",$busca_porPalavra)?>>P</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","q",$busca_porPalavra)?>>Q</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","r",$busca_porPalavra)?>>R</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","s",$busca_porPalavra)?>>S</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","t",$busca_porPalavra)?>>T</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","u",$busca_porPalavra)?>>U</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","v",$busca_porPalavra)?>>V</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","x",$busca_porPalavra)?>>X</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","y",$busca_porPalavra)?>>Y</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","w",$busca_porPalavra)?>>W</a></label>
            <label>-<a href="#@" <?php echo str_replace("XXX","z",$busca_porPalavra)?>>Z</a></label>        </td>
      </tr>
      <tr>
        <td height="1" colspan="5" align="center" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
    </table>
    </div>
    
    <div id="resultBusca" class="verdana_12">
    	<?php require_once("busca.php"); ?>
    </div>
<var style="display:none"><?php //echo str_replace(";\"","",str_replace("onclick=\"","",str_replace("METODO","2",str_replace("infoGet_Post","&1=1",str_replace("PAGINADESTINO", $destinoBusca ,$chamadaAJAX))))); ?></var>