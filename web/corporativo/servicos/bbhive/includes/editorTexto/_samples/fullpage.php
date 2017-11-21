<?php if(!isset($_SESSION)){ session_start(); } ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Full Page Editing - CKEditor Sample</title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<script type="text/javascript" src="../ckeditor.js"></script>
	<script src="sample.js" type="text/javascript"></script>
	<script src="/corporativo/servicos/bbhive/includes/openAjax.js" type="text/javascript"></script>
	<link href="sample.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../relatorio.css"/>
</head>
<body>
    <div id="loadEditor" style="position:absolute">&nbsp;</div>
<!--   <a href="javascript:void(0)" onclick="idNavegador('Robson Cruz', 'editorForm', 'editor1');">Adicionar - Robson Cruz</a>-->
	<form name="editorForm" id="editorForm" action="sample_posteddata.php" method="post" target="acaoGrava"><div class="verdana_12" style="margin-top:2px; margin-bottom:2px;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T&iacute;tulo : 
      <input name="bbh_par_titulo" type="text" class="back_Campos" id="bbh_par_titulo" size="60" style="height:20px; line-height:20px;" value="<?php echo @($_SESSION['bbh_par_titulo']);?>" /><label style="margin-left:200px;"><a href="#@" onclick="window.top.document.getElementById('carregaTudo').innerHTML = '&nbsp;';"><span style="color:#F60"><strong>Fechar editor</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="middle" /></a></label></div>
			<!--<input type="button" value="Salvar" onclick="enviaEditor('sample_posteddata.php')" /> -->
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
 <input name="retorno" id="retorno" type="hidden" value="<?php echo $_GET['urlRetorno']; ?>" />
 <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $_GET['bbh_rel_codigo']; ?>" />
 <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $_GET['bbh_ati_codigo']; ?>" />
 <input type="hidden" name="bbh_par_momento" id="bbh_par_momento" value="<?php echo date('Y-m-d'); ?>" />
 <input type="hidden" name="bbh_par_autor" id="bbh_par_autor" value="<?php echo $_SESSION['usuNome']; ?>" />
</form>
<iframe id="acaoGrava" name="acaoGrava" src="#" width="500" height="500" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>
</body>
</html>
