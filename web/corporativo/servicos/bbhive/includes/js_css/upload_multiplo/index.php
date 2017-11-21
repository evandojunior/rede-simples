<?php
if(!isset($_SESSION)){ session_start(); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<link rel="stylesheet" href="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/css/plupload.queue.css" type="text/css" media="screen" />
<title>Plupload - Queue widget example</title>
<style type="text/css">
body {background: #FAFAFA;}
.verdana_11 { 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 11px; 
	text-decoration: none;
}
</style>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
	var osArquivos = "";
	
    function roundNumber(rnum, rlength) { // Arguments: number to round, number of decimal places
      var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
      return newnumber; // Output the result to the form field (change for your purposes)
    }
	function pesquisaVetor(f){
		for (a = 0; a < osArquivos.length; a++) {
			fil = osArquivos[a];
				if(fil.id == f){
					//alert(fil.size + " => " + oId.id);
					return fil.size;
				}
		}
	}
	function chamaFinal(){
//		alert('Carregou tudo!');
		<?php echo $fecharPHP; ?>
		//parent.frames['arquivos'].location = "frame.php";
	}
</script>


<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/gears_init.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/browserplus-min.js"></script>
<!-- Load source versions of the plupload script files -->
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/plupload.js"></script>

<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/plupload.flash.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/plupload.browserplus.js"></script>
 <script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/plupload.html4.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/plupload.html5.js"></script><!-- -->
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/src/javascript/jquery.plupload.queue.js"></script>
<!--
<script type="text/javascript" src="../src/javascript/firebug-lite-compressed.js"></script> -->
<script>
$(function() {
	// Setup flash version
	$("#flash_uploader").pluploadQueue({
		// General settings
		runtimes : 'flash',
		url : '<?php echo $uploadPHP; //upload.php?>',
		max_file_size : '100mb',
		chunk2_size : '1mb',
		unique_names : true,
//		resize : {width : 320, height : 240, quality : 90},
		filters : [
			<?php echo $tipoArquivo; /*{title : "Arquivos de imagens", extensions : "jpg,gif,png,bmp"}*/ ?>
			//,{title : "Zip files", extensions : "zip"}
		],
ref_up2load : false,
		// Flash settings
		flash_swf_url : '/corporativo/servicos/bbhive/includes/js_css/upload_multiplo/js/plupload.flash.swf'
	});
});
</script>
</head>
<body>
<?php echo $barra; ?>
<form method="post">
<div>
	<div id="flash_uploader" style="width: 98%; height: 330px; margin-left: auto; margin-right: auto;" class="verdana_11">Seu navegador não possuí o flash instalado.</div>
</div>
	<br style="clear: both" />
</form>
</body>
</html>