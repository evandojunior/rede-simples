<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$query_usuarios = "
SELECT 
u.bbh_usu_nome,
u.bbh_usu_identificacao, 
u.bbh_usu_ultimoAcesso, 
u.bbh_usu_codigo, 
u.bbh_usu_ativo, 
if(u.bbh_usu_chefe>0,c.bbh_usu_apelido,'---') as chefe,
d.bbh_dep_nome,
u.bbh_usu_cargo
FROM bbh_usuario as u
LEFT JOIN bbh_usuario as c on c.bbh_usu_codigo = u.bbh_usu_chefe
LEFT JOIN bbh_departamento as d on d.bbh_dep_codigo = u.bbh_dep_codigo
group by u.bbh_usu_codigo
ORDER BY u.bbh_usu_nome ASC
";
list($usuarios, $row_usuarios, $totalRows_usuarios) = executeQuery($bbhive, $database_bbhive, $query_usuarios);
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_usuariosNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="6" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-administrador-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_usuariosNome']; ?>
<div style="float:right;"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div>
</td>
  </tr>
  <tr>
    <td height="8" colspan="6"><table width="500" border="0" cellspacing="0" cellpadding="0" style="margin:3px;">
      <tr>
        <td width="23" height="20" bgcolor="#FF9999">&nbsp;</td>
        <td width="477">&nbsp;<strong><?php echo $_SESSION['adm_usuariosNome']; ?> inativos</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr class="verdana_11_bold">
    <td style="border-bottom:1px solid #000000;" width="19%" height="22">Nome</td>
    <td style="border-bottom:1px solid #000000;" width="19%">E-Mail</td>
    <td style="border-bottom:1px solid #000000;" width="13%">Chefe</td>
    <td style="border-bottom:1px solid #000000;" width="16%">Departamento</td>
    <td style="border-bottom:1px solid #000000;" width="14%">Cargo</td>
    <td style="border-bottom:1px solid #000000;" width="19%" align="center"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/novo.php','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/novo.gif" alt="Criar novo usu&aacute;rio" title="Criar novo usu&aacute;rio" width="12" height="15" border="0" align="absmiddle" /></a></td>
  </tr>
<?php if ($totalRows_usuarios > 0) { // Show if recordset not empty ?>
  <?php do {
		$query_quantperfis = "SELECT COUNT(bbh_usu_codigo) as TOTAL, bbh_usu_codigo FROM bbh_usuario_perfil WHERE bbh_usu_codigo=".$row_usuarios['bbh_usu_codigo']." GROUP BY bbh_usu_codigo";
        list($quantperfis, $row_quantperfis, $totalRows_quantperfis) = executeQuery($bbhive, $database_bbhive, $query_quantperfis);

		$query_Perfil = "select count(bbh_usu_per_codigo) as total from bbh_perfil
	inner join bbh_usuario_nomeacao on bbh_perfil.bbh_per_codigo = bbh_usuario_nomeacao.bbh_per_codigo
	   WHERE bbh_usu_codigo = ".$row_usuarios['bbh_usu_codigo'];
        list($Perfil, $row_Perfil, $totalRows_Perfil) = executeQuery($bbhive, $database_bbhive, $query_Perfil);
  ?>
  <tr class="verdana_10" <?php if($row_usuarios['bbh_usu_ativo']=="0") { ?>style="background-color:#FF9999"<?php } ?>>    
      <td style="border-bottom:1px dotted #999999;" height="25">
	  <?php
	  if(strlen($row_usuarios['bbh_usu_nome'])>28){	  
	      echo substr($row_usuarios['bbh_usu_nome'],0,25)."...";
	  }else{
		  echo $row_usuarios['bbh_usu_nome'];	  	
	  }
	  ?>      </td>
      <td style="border-bottom:1px dotted #999999;">
  <?php
		if(strlen($row_usuarios['bbh_usu_identificacao'])>65){
			echo substr($row_usuarios['bbh_usu_identificacao'],0,62)."...";
		}else{
			echo $row_usuarios['bbh_usu_identificacao'];
		}
      ?>      </td>
      <td style="border-bottom:1px dotted #999999;"><?php echo $row_usuarios['chefe'];?></td>
      <td style="border-bottom:1px dotted #999999;"><?php echo $row_usuarios['bbh_dep_nome']; ?></td>
      <td style="border-bottom:1px dotted #999999;"><?php echo $row_usuarios['bbh_usu_cargo']; ?></td>
      <td align="center" style="border-bottom:1px dotted #999999;"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/editar.php?bbh_usu_codigo=<?php echo $row_usuarios['bbh_usu_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/editar.gif" alt="Editar usu&aacute;rio" title="Editar usu&aacute;rio" width="17" height="17" border="0" align="absmiddle" /></a>&nbsp;&nbsp;<a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/excluir.php?bbh_usu_codigo=<?php echo $row_usuarios['bbh_usu_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/excluir.gif" alt="Excluir usu&aacute;rio" title="Excluir usu&aacute;rio" width="17" height="17" border="0" align="absmiddle" /></a>&nbsp;&nbsp;<a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|usuarios/perfil/index.php?bbh_usu_codigo=<?php echo $row_usuarios['bbh_usu_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/ger-perfis-16px.gif" alt="Atribuir perfis" title="Atribuir perfis" width="14" height="14" border="0" align="absmiddle" /><?php if($row_quantperfis['TOTAL']>0){echo $row_quantperfis['TOTAL'];}else{echo "0";}; ?></a>
      &nbsp;&nbsp;
      <a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/colaboradores/regra.php?bbh_usu_codigo=<?php echo $row_usuarios['bbh_usu_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/coladoradores.gif" alt="Atribuir perfis" title="Perfis para colaboradores" width="25" height="16" border="0" align="absmiddle" /> <?php echo $row_Perfil['total']; ?></a>
      </td>
  </tr>
  <?php } while ($row_usuarios = mysqli_fetch_assoc($usuarios)); ?>
      <?php }else{ // Show if recordset not empty ?>
      <tr>
        <td class="color" colspan="6">Voc&ecirc; n&atilde;o possui nenhum usu&aacute;rio cadastrado. <a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/novo.php','menuEsquerda|colCentro');">Clique aqui</a> para cadastrar um novo.</td>
      </tr>
      <?php } ?>

  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<?php
mysqli_free_result($usuarios);
?>