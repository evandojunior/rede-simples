<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
ob_flush();

	if(isset($_GET['qtRegistros'])){
		//Inicia sessão caso não esteja criada
		include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
		include($_SESSION['caminhoFisico']."/servicos/bbpass/includes/function.php");
		require_once("gerencia_perfil.php");
		
			$usuario = new perfil();//instância classe
			$usuario->dadosPerfil($database_bbpass, $bbpass);//chama método responsável pela atribuição das variáveis
	}

$qtRegistros = isset($_GET['qtRegistros'])?$_GET['qtRegistros']:0;

$registros  = $usuario->listaLog($_SESSION['EndURL_POLICY'],$qtRegistros);
$registros  = $registros->getElementsByTagName('auditoria')->item(0);
$total		= $registros->getAttribute("total");

$temLog=0;

//UTILIZAÇÃO DO OPEN AJAX CMD
	$pagina 	= "/servicos/bbpass/perfil/log.php";
	$camada 	= "listaLogs";
	$values 	= "?qtRegistros=xxx&ts=".time();
	$msg		= "Aguarde processando...";
	$divcarga	= "enviaLog";
	$metodo 	= "2";
	$tpmsg		= "1";

	$acaoClick	=  "OpenAjaxPostCmd('$pagina','$camada','$values','$msg','$divcarga','$metodo','$tpmsg')";
?>
<table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="fonteDestaque">
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFBF4" class="legendaLabel14" style="border-bottom:1px solid #FFECC7; border-top:1px solid #FFECC7;"><strong>Minhas a&ccedil;&otilde;es</strong></td>
    <td height="25" align="right" bgcolor="#FFFBF4" class="legendaLabel12" style="border-bottom:1px solid #FFECC7; border-top:1px solid #FFECC7;">
    	<?php
			if($qtRegistros>0){?>
				<input type="button" name="button" id="button" value="[ Anterior ]" onclick="<?php echo str_replace("xxx",$qtRegistros-20,$acaoClick); ?>" />
<?php	}
			
			if(($qtRegistros+20)<=$total){ ?>
				
<input type="button" name="button" id="button" value="[ Próximo ]" onclick="<?php echo str_replace("xxx",$qtRegistros+20,$acaoClick); ?>" />
			<?php	}
		?>
    &nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="3" bgcolor="#FFFFFF"></td>
  </tr>
 <?php foreach($registros->childNodes as $cadaLog) { $temLog=1; ?>
  <tr class="legendaLabel11" onmouseover="javascript: this.style.backgroundColor='#FAFBFB';" onmouseout="javascript: this.style.backgroundColor='#FFF';" style="cursor:pointer;">
    <td width="125" height="25" valign="top"><strong><?php echo substr($cadaLog->getAttribute("momento"),0,16); ?></strong></td>
    <td width="102" align="center" valign="top"><?php echo substr($cadaLog->getAttribute("ip"),0,14); ?></strong></td>
    <td width="353" valign="top" style="color:#06F"><?php echo utf8_decode($cadaLog->getAttribute("pol_aud_acao")); ?></td>
  </tr>
  <?php } ?>
  <?php if($temLog==0){ ?>
  <tr>
    <td height="1" colspan="3" align="center" class="verdana_11">N&atilde;o h&aacute; registros cadastrados</td>
  </tr>
  <?php } ?>
</table>