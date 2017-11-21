<?php if(!isset($_SESSION)){session_start();} ?>
<table width="992" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;">
  <tr>
    <td height="667" align="center" valign="top" bgcolor="#FFFFFF">
		<?php require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/relatorios/painel".$_GET['pag']); ?>
    </td>
  </tr>
</table>
<!-- filter:alpha(opacity=100); -moz-opacity:1.0;opacity:1.0;margin-left:1px; -->