<?php
require_once("../../../../../Connections/bbhive.php");
//require_once("../../includes/functions.php");

//$_SESSION['caminhoPadraoCroqui'] = 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Blackbee better solutions</title>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #FFF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.verdana_11 { 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 11px; 
	text-decoration: none;
}
.verdana_14 { 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 14px; 
	text-decoration: none;
}
-->
</style>
<script type="text/javascript">
	function msgAguardando(){
		document.getElementById('msgC').style.display = 'block';	
	}
	function msgFinalizado(){
		document.getElementById('msgC').style.display = 'none';
		document.getElementById('botoes').style.display="block";
		alert('Imagem gerada com sucesso!\r\nPara visualizar essa imagem clique no GED do Fluxo.');
	}
	
</script>
</head>

<body>
       <div style="color:#06C; display:none" class="verdana_14" align="center" id="msgC">Gerando imagem&nbsp;<img src="/corporativo/servicos/bbhive/images/load_flash.gif" style="margin-top:2px;" /></div>
      	<div style="float:right;display:none;" id="botoes">
			<input type="button"  style="background-image:url(/corporativo/servicos/bbhive/images/continuar_rica.png); background-repeat:no-repeat; display:none;height:22px;margin-top:2px;cursor:pointer; width:174px; border:none;" name="button" id="button" value="" onClick="alert('Nao sei');">
        </div>
<?php /*
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="FlashID">
  <param name="movie" value="sistema.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  <param name="swfversion" value="9.0.45.0" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you dont want users to see the prompt. -->
  <param name="expressinstall" value="Scripts/expressInstall.swf" />
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="sistema.swf" width="100%" height="100%">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="transparent" />
    <param name="swfversion" value="9.0.45.0" />
    <param name="expressinstall" value="Scripts/expressInstall.swf" />
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    <div>
      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
<script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script>
*/
?>

<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="100%" HEIGHT="100%" id="sistema" ALIGN="">
 <PARAM NAME=movie VALUE="sistema.swf"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#ffffff> <EMBED src="sistema.swf" quality=high bgcolor=#ffffff  WIDTH="100%" HEIGHT="100%" NAME="sistema" ALIGN=""
 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>

</OBJECT>

<iframe style="display:none;" name="imprimeIMG" id="imprimeIMG" width="777" height="600"></iframe>
</body>
</html>