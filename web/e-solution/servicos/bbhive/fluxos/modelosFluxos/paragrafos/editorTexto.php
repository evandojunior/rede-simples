<?php if(!isset($_SESSION)){ session_start(); } ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editor paragrafo</title>
	<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/editorTexto/ckeditor.js"></script>
	<script src="/e-solution/servicos/bbhive/includes/editorTexto/_samples/sample.js" type="text/javascript"></script>
	<script src="/e-solution/servicos/bbhive/includes/openAjax.js" type="text/javascript"></script>
    
	<link href="/e-solution/servicos/bbhive/includes/editorTexto/_samples/sample.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbhive/includes/relatorio.css"/>
    <style type="text/css">
		.verdana_9{
			font-family:Verdana, Geneva, sans-serif;
			font-size:9px;	
		}
	</style>	
</head>

<body>
	<form name="editorForm" id="editorForm" action="/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/<?php echo $_GET['arquivo']; ?>.php" method="post" target="acaoGrava">
    <table align="center" width="98%" height="150" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">    
    <tr>
      <td height="10" align="left" valign="middle" class="verdana_12">&nbsp;</td>
      <td align="right" valign="middle" class="verdana_12"><a href="#@" onclick="window.top.window.LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/paragrafos/index.php?bbh_mod_flu_codigo=<?php if(!isset($_POST['bbh_mod_flu_codigo'])){echo $_GET['bbh_mod_flu_codigo']; }else{ echo $_POST['bbh_mod_flu_codigo']; } ?>','menuEsquerda|conteudoGeral');"><span style="color:#F60"><strong>Fechar editor</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></label></td>
    </tr>
    <tr>
      <td width="135" height="25" align="left" valign="middle" class="verdana_12">Nome do par&aacute;grafo: </td>
      <td width="455" align="left" valign="middle" class="verdana_12"><input name="bbh_mod_par_nome" type="text" class="back_Campos" id="bbh_mod_par_nome" style="height:17px;border:#E3D6A4 solid 1px;" value="<?php echo @$_SESSION['textoParNome']; ?>" size="60"/></td>
    </tr>
    <tr>
      <td height="25" align="left" valign="middle" class="verdana_12">T&iacute;tulo do par&aacute;grafo: </td>
      <td height="25" align="left" valign="middle" class="verdana_12"><input class="back_Campos" name="bbh_mod_par_titulo" type="text" id="bbh_mod_par_titulo" size="60" style="height:17px;border:#E3D6A4 solid 1px;" value="<?php echo @$_SESSION['textoParTitulo']; ?>"/></td>
      </tr>
    <tr>
      <td height="25" align="left" valign="middle" class="verdana_12">Autor do par&aacute;grafo:</td>
      <td height="25" align="left" valign="middle" class="verdana_12"><strong><?php echo @$_SESSION['textoParAutor']; ?></strong></td>
    </tr>
    <tr>
      <td height="25" align="left" valign="middle" class="verdana_12">
      <label style="margin-left:14px;">
        Momento cria&ccedil;&atilde;o:</label></td>
      <td height="25" align="left" valign="middle" class="verdana_12"><strong><?php echo $_SESSION['textoParmomento']; ?></strong>
        <input name="bbh_mod_par_momento" type="hidden" value="<?php echo $_SESSION['textoMonGrava']; ?>" />
      </td>
    </tr>
    <tr>
      <td height="5" colspan="2" align="left" valign="middle" class="verdana_9">Caminho relativo com imagens no datafiles: &quot;../../../../../../&quot;</td>
      </tr>
    </table>
<textarea cols="80" id="editor1" name="editor1" rows="10"><?php echo @htmlentities($_SESSION['textoEdito']);?></textarea>
			<script type="text/javascript">
			//<![CDATA[
				CKEDITOR.replace( 'editor1',
					{
						fullPage : true
					});

			//]]>
			</script>
		</p> 
<input name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" type="hidden" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>" />
<input name="bbh_adm_codigo" type="hidden" id="bbh_adm_codigo" value="<?php echo $_GET['bbh_adm_codigo']; ?>" />
	<?php if(isset($_GET['bbh_mod_par_codigo'])){?>
    	<input name="bbh_mod_par_codigo" type="hidden" id="bbh_mod_par_codigo" value="<?php echo $_GET['bbh_mod_par_codigo']; ?>">
    <?php } ?>
<input name="<?php echo $_GET['acao'] ?>" id="<?php echo $_GET['acao'] ?>" type="hidden" value="1" />
</form>
<iframe id="acaoGrava" name="acaoGrava" src="#" width="500" height="500" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>

</body>
</html>