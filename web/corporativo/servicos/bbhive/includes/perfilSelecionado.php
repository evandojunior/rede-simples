<?php
	if(!isset($_SESSION)){session_start();}

			$query_Perfil = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
      inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
           WHERE bbh_usu_codigo = ".$_SESSION['usuCod']."
                order by bbh_per_nome asc";
            list($Perfil, $row_Perfil, $totalRows_Perfil) = executeQuery($bbhive, $database_bbhive, $query_Perfil);

?>
<table width="142" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11"><strong>Perfil</strong></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
<?php if($totalRows_Perfil>0) { ?>
	 <?php  do { ?>
      <tr>
        <td height="19">
            <span class="verdana_9">&nbsp;<img src="/corporativo/servicos/bbhive/images/perfil.gif" width="14" height="14" align="absmiddle" />
                &nbsp;<?php echo $row_Perfil['bbh_per_nome']; ?></a></span></td>
      </tr>
     <?php }while($row_Perfil = mysqli_fetch_assoc($Perfil)); ?>
<?php } else { ?>
      <tr>
        <td height="19" align="center">
            <span class="verdana_9 color">N&atilde;o h&aacute; perfil adicionado</a></span></td>
      </tr>
<?php } ?>
 </table>
