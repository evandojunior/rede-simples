<?php
//conexão com banco de dados
require_once("../../../../Connections/bbpass.php");

//mensagem para o usuário
	$msg 		= "<span class='falha'>Credencial negada.</span>";
	$liberado	= 0;
?>
<script type="text/javascript">window.top.window.limpaMsgPadrao(<?php echo $liberado; ?>);</script>
<style type="text/css">
.sucesso{
	color:#03F; font-family:Tahoma, Geneva, sans-serif;font-size:14px;
}
.falha{
	color:#F00; font-family:Tahoma, Geneva, sans-serif;font-size:14px;
}
</style>
<div align="center"><?php echo $msg; ?></div>