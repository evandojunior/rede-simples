<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//if(isset($_SESSION['dtAtual'])){ unset($_SESSION['dtAtual']); }
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a página de consulta de ".$_SESSION['FluxoNome']." - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
$compl = "";
//anexar fluxo
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_flu_codigo_p")||($indice=="bbh_flu_codigo_p")){ $bbh_flu_codigo_p=$valor; }
	if(($indice=="amp;bbh_pro_codigo")||($indice=="bbh_pro_codigo")){ $bbh_pro_codigo_p=$valor; }
}
 if(isset($bbh_flu_codigo_p)){ 
 	$compl = "&bbh_flu_codigo_p=".$bbh_flu_codigo_p; 
	$bbh_flu_codigo = $bbh_flu_codigo_p;
	require_once("includes/cabecaFluxo.php");
	require_once("includes/detalheResumo.php");
 } elseif(isset($bbh_pro_codigo_p)){
	$compl = "&bbh_pro_codigo_p=".$bbh_pro_codigo_p;  
 }

require_once("includes/parametros_consulta.php");

$TimeStamp 		= time();
$homeDestino1	= '/corporativo/servicos/bbhive/consulta/index.php?Ts='.$TimeStamp."&inicia=x".$compl;
$onClick  		= "onclick=\"OpenAjaxPostCmd('".$homeDestino1."','conteudoGeral','&1=1','Consultando informa&ccedil;&otilde;es...','conteudoGeral','2','2');\"";

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= 'consulta/index.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'conteudoGeral';
	$infoGet_Post	= 'form1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Consultando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
		//chama página de busca
	$envolvido="";
	if(isset($_GET['envolvidos'])){ 
		$envolvido='envolvidos=true&';
	}
	
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/consulta/index.php?'.$envolvido.'Ts='.$TimeStamp.$compl;
	$carregaPagina5  = "OpenAjaxPostCmd('".$homeDestino."','conteudoGeral','&1=1','Carregando informa&ccedil;&otilde;es...','conteudoGeral','2','2');";

	$query_Procedimentos = "select
      round(sum(bbh_per_fluxo)) as bbh_per_fluxo
    from bbh_perfil
      inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
           WHERE bbh_usu_codigo = ".$_SESSION['usuCod']."
                     group by bbh_usu_codigo";
    list($Procedimentos, $row_Procedimentos, $totalRows_Procedimentos) = executeQuery($bbhive, $database_bbhive, $query_Procedimentos);
?>
<var style="display:none">txtSimples('tagPerfil', 'Consulta <?php echo $_SESSION['FluxoNome']; ?>')</var>
<?php
 if(isset($bbh_flu_codigo_p)){ 
	require_once("includes/cabecaResumo.php");
 } elseif(isset($bbh_pro_codigo_p)){
	 require_once("../protocolo/includes/resumo.php");
 }
?>
<div class="verdana_11">
<div style="float:left;border-bottom:#069 solid 1px;" class="verdana18"><strong><?php echo $_SESSION['FluxoNome']; ?></strong></div>
        <div style="float:right">
		<?php if(!isset($bbh_flu_codigo_p)){ ?>
                 <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/avancada/regra.php','menuEsquerda|conteudoGeral');">
                    <img src="/corporativo/servicos/bbhive/images/avancada.gif" border="0" align="absmiddle" />&nbsp;<strong>Busca avançada</strong>
         </a><?php } ?>
        </div>
        <div style="float:right">
                 <a href="#@" onclick="if(document.getElementById('consoleBusca').style.display=='none'){document.getElementById('consoleBusca').style.display='block'; }else{document.getElementById('consoleBusca').style.display='none';}">
                    <img src="/corporativo/servicos/bbhive/images/avancada.gif" border="0" align="absmiddle" />&nbsp;<strong>Busca simples</strong>
         </a>
        </div>
        <?php if($row_Procedimentos['bbh_per_fluxo']>=1){ ?>
        <div style="float:right; margin-right:10px;">
        	&nbsp;<a href="#" onClick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/regra.php','menuEsquerda|colPrincipal');"><img src="/corporativo/servicos/bbhive/images/bt_novo.gif" border="0" align="absmiddle" />
               <strong>Novo(a) <?php echo $a=$_SESSION['FluxoNome']; ?></strong></a>
        </div>
        <?php } ?>
</div>
<div style="clear:both"></div>
<div style="display:none" id="consoleBusca">
<form name="form1" id="form1" style="margin-top:-1px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td colspan="2" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">
        <div style="float:left">
        &nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong>Console de busca <?php echo $_SESSION['FluxoNome']; ?></strong>
		</div>
        </td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_11"><?php 
		$nProt	= "8px";
		$nDtP	= "3px";
		$ofc	= "56px";
		$desc	= "35px";
		require_once("busca_protocolo.php"); ?></td>
    </tr>
      <tr>
        <td width="4%" height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="busca_nome" id="busca_nome" <?php echo pesquisaVetor("0", "busca_nome", ""); ?> />
        </label></td>
        <td width="96%" class="verdana_11">&nbsp;T&iacute;tulo do(s) <?php echo $_SESSION['FluxoNome']; ?> :<input name="bbh_flu_titulo" type="text" id="bbh_flu_titulo" value="<?php echo pesquisaVetor("1", "busca_nome", ""); ?><?php //echo isset($_POST['bbh_busca_nome'])?$_POST['bbh_busca_nome']:""; ?>" size="40" class="back_Campos"  style="height:17px;border:#E3D6A4 solid 1px;margin-left:0px;"/>     
        </td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><input type="checkbox"name="busca_codigo" id="busca_codigo" <?php echo pesquisaVetor("0", "busca_codigo", ""); ?>/></td>
        <td width="96%">&nbsp;C&oacute;digo de barras :
          <label>
            <input name="bbh_flu_codigobarras" type="text" value="<?php echo pesquisaVetor("1", "busca_codigo", ""); ?>" class="back_Campos" id="bbh_flu_codigobarras"  style="height:17px;border:#E3D6A4 solid 1px;" size="20" maxlength="20"/>
          </label></td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><input type="checkbox" name="busca_descricao" id="busca_descricao" <?php echo pesquisaVetor("0", "busca_descricao", ""); ?> /></td>
        <td class="verdana_11">&nbsp;Descri&ccedil;&atilde;o :
          <label>
            <input name="bbh_flu_observacao" value="<?php echo pesquisaVetor("1", "busca_descricao", ""); ?>" type="text" class="back_Campos" id="bbh_flu_observacao"  style="height:17px;border:#E3D6A4 solid 1px;margin-left:35px;" size="40"/>
        </label></td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="busca_data" id="busca_data" <?php echo pesquisaVetor("0", "busca_data", ""); ?> />
        </label></td>
        <td class="verdana_11">&nbsp;<label class="verdana_9" style="margin-top:2px;">De :
            <input name="DataInicio" type="text" class="formulario2" id="DataInicio" value="<?php 
			
			$d = pesquisaVetor("1", "busca_data", "0");
			echo empty($d)?date('d/m/Y'):$d; 
			
			?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
            <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.DataInicio,'dd/mm/yyyy',this)"/>
        </label>
          <label> At&eacute; :
          <input name="DataFim" type="text" class="formulario2" id="DataFim" value="<?php 
			
			$d = pesquisaVetor("1", "busca_data", "1");
			echo empty($d)?date('d/m/Y'):$d; 
			
			?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
          <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.DataFim,'dd/mm/yyyy',this)"/>
          </label>
      <?php
		$homeDestino	= '/corporativo/servicos/bbhive/consulta/index.php?Ts='.$TimeStamp."&decisao=xxx&buscaDia=true".$compl;
		$carregaPagina  = "OpenAjaxPostCmd('".$homeDestino."','conteudoGeral','&1=1','Carregando informa&ccedil;&otilde;es...','conteudoGeral','2','2');";
	   ?></td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><input type="checkbox" name="busca_envolvido" id="busca_envolvido" <?php echo pesquisaVetor("0", "busca_envolvido", ""); ?>/></td>
        <td class="verdana_11">&nbsp;<?php echo $_SESSION['FluxoNome']; ?> que participo</td>
      </tr>
      <?php if(isset($_SESSION['consultaAvancada']) && $_SESSION['consultaAvancada']!="0"){ ?>
      <?php //if(pesquisaVetor("0", "busca_avancada", "")=="checked"){ ?>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><input name="busca_avancada" type="checkbox" id="busca_avancada" checked="checked" <?php echo pesquisaVetor("0", "busca_avancada", ""); ?>/></td>
        <td class="verdana_11">&nbsp;<strong>Pesquisa avan&ccedil;ada</strong><input name="bscAvc" id="bscAvc" type="text" value="<?php echo $_SESSION['consultaAvancada']; ?>" /></td>
      </tr>
      <?php } ?>
      <tr>
        <td height="22" colspan="2" align="right" bgcolor="#EFEFE7" class="verdana_11">
        <div style="float:left">
        	<div style=" <?php echo pesquisaVetor("0", "inicia", "")!="checked"?"visibility:hidden":""; ?>">
            	<div style="float:left; width:40px;" align="center"><input type="checkbox" name="inicia" id="inicia" <?php echo pesquisaVetor("0", "inicia", ""); ?>/></div>
                <div style="float:left; width:320px;" align="left">&nbsp;<strong>Iniciado com a letra: "<?php echo pesquisaVetor("1", "inicia", ""); ?>" <input name="bbh_inicia" type="hidden" value="<?php echo pesquisaVetor("1", "inicia", ""); ?>" class="back_Campos" id="bbh_inicia"  style="height:17px;border:#E3D6A4 solid 1px;" size="20" maxlength="20"/></strong></div>
            </div>
        </div>
        <div style="float:right">
        <?php if(isset($bbh_flu_codigo_p)){ ?>
        <input type="hidden" name="bbh_flu_codigo_p" id="bbh_flu_codigo_p" value="<?php echo $bbh_flu_codigo_p; ?>" />
        <?php } ?>
        <?php if(isset($bbh_pro_codigo_p)){ ?>
        <input type="hidden" name="bbh_pro_codigo_p" id="bbh_pro_codigo_p" value="<?php echo $bbh_pro_codigo_p; ?>" />
        <?php } ?>
        <input class="formulario2" id="web" type="button" value="Pesquisar" name="web"  style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return <?php echo $acao; ?>"/>&nbsp;
        </div>
        </td>
      </tr>
      <tr>
        <td height="1" colspan="2" align="right" bgcolor="#FFFFFF" class="verdana_11"></td>
      </tr>
  </table>
</form>  
<?php if(isset($_SESSION['consultaAvancada']) && $_SESSION['consultaAvancada']!="0" && $_SESSION['buscaAvancada']==0){ ?>
<var style="display:none">
	<?php echo $acao; ?>
</var>
<?php  } ?>  
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
      
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
		?><label style="margin-left:5px"><a href="#@" <?php echo str_replace("XXX","a",$busca_porPalavra)?>>A</a></label>
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
            <label>-<a href="#@" <?php echo str_replace("XXX","z",$busca_porPalavra)?>>Z</a></label> 
        </td>
      </tr>
      <tr>
        <td height="1" colspan="5" align="center" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
    </table>
</div>    
    <div id="resultBusca" class="verdana_12"><?php
    	require_once("busca.php");
	?></div>
	<var style="display:none"><?php //if(isset($_SESSION['consultaAvancada']) && $_SESSION['consultaAvancada']!="0"){  echo $acao;} else { echo $carregaPagina5; }  ?></var>