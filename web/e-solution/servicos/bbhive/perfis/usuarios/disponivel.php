<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


$perfil = -1;
if(isset($_GET['perfil'])){
	$perfil = $_GET['perfil'];
}

//Adicionados
$query_Adicionados = "SELECT bbh_usu_codigo FROM bbh_usuario_perfil WHERE bbh_per_codigo = $perfil";
list($Adicionados, $row_Adicionados, $totalRows_Adicionados) = executeQuery($bbhive, $database_bbhive, $query_Adicionados);

$UsuarioAdicionado="0";

if($totalRows_Adicionados>0){
	do{
		$UsuarioAdicionado .= ", ".$row_Adicionados['bbh_usu_codigo'];
		
	} while ($row_Adicionados = mysqli_fetch_assoc($Adicionados));
}

$query_perfis = "SELECT * FROM bbh_usuario WHERE bbh_usu_codigo NOT IN ($UsuarioAdicionado) ORDER BY bbh_usu_nome ASC";
list($perfis, $row_perfis, $totalRows_perfis) = executeQuery($bbhive, $database_bbhive, $query_perfis);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
       <?php if($totalRows_perfis>0){ ?>
          <?php do { 
  		        $codigoperfil = $row_perfis['bbh_usu_codigo'];
		  ?> 
  <tr onClick="return per_AdicionaPerfil(<?php echo $row_perfis['bbh_usu_codigo']; ?>);" id="l<?php echo $codigoperfil ?>" onMouseOver="ativaCor('l<?php echo $codigoperfil ?>');" onMouseOut="desativaCor('l<?php echo $codigoperfil ?>');">  
    <td height="25" width="315">&nbsp;<img src="/e-solution/servicos/bbhive/images/equipe-operacional.gif" alt="" align="absmiddle" />&nbsp;<?php echo $row_perfis['bbh_usu_nome']; ?></td>
    <td><img src="/e-solution/servicos/bbhive/images/v.gif" border="0" /></td>
  </tr>
		<?php } while ($row_perfis = mysqli_fetch_assoc($perfis)); ?>
       <?php } else { ?>  
  <tr>
    <td colspan="2" class="verdana_11">N&atilde;o existem usu&aacute;rios dispon&iacute;veis</td>
  </tr>
<?php } ?>
</table>
