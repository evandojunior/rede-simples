<?php
	if(!isset($_SESSION)){session_start();}

if(getCurrentPage()!="/corporativo/servicos/bbhive/equipe/gerencia.php"){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
}

	$query_Profissionais = "select bbh_usuario.bbh_usu_codigo from bbh_usuario
      inner join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
           Where bbh_per_codigo =".$_GET['bbh_per_codigo']." and bbh_usu_chefe=".$_SESSION['usuCod'];
    list($Profissionais, $row_Profissionais, $totalRows_Profissionais) = executeQuery($bbhive, $database_bbhive, $query_Profissionais);
	
	$exceto=0;
	 if($totalRows_Profissionais>0){
		do{
			$exceto.=", ".$row_Profissionais['bbh_usu_codigo'];
			
		}while($row_Profissionais = mysqli_fetch_assoc($Profissionais));
	  }

	$query_Nomeia = "select bbh_usuario.bbh_usu_codigo, bbh_usu_apelido, bbh_usu_tel_celular, bbh_usuario_perfil.bbh_per_codigo 
	from bbh_usuario
      left join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
           Where bbh_usuario.bbh_usu_codigo not in($exceto) and bbh_usu_chefe=".$_SESSION['usuCod']." 
		   group by bbh_usuario.bbh_usu_codigo
		order by bbh_usu_apelido asc";
    list($Nomeia, $row_Nomeia, $totalRows_Nomeia) = executeQuery($bbhive, $database_bbhive, $query_Nomeia);
?>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" colspan="2" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Adicionar profissional</strong></td>
  </tr>
<?php if($totalRows_Nomeia>0) { ?>
	 <?php  do { ?>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td width="172" align="left"><a href="#" onClick="return gerencia('/corporativo/servicos/bbhive/equipe/atribuicao.php?bbh_usu_codigo=<?php echo $row_Nomeia['bbh_usu_codigo']; ?>&bbh_per_codigo=<?php echo $_GET['bbh_per_codigo']; ?>','add');">&nbsp;<img src="/corporativo/servicos/bbhive/images/perfil.gif" width="14" height="14" align="absmiddle" border="0" />&nbsp;<?php echo $row_Nomeia['bbh_usu_apelido']; ?></a></td>
    <td width="28" align="center"><img src="/corporativo/servicos/bbhive/images/vistoII.gif" width="14" height="11"></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
     <?php }while($row_Nomeia = mysqli_fetch_assoc($Nomeia)); ?>
<?php } else { ?> 
  <tr>
    <td colspan="2" height="19" align="center">
            <span class="verdana_9 color">N&atilde;o h&aacute; registros a serem adicionado</a></span></td>
  </tr>
<?php } ?>
</table>