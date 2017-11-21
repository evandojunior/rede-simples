<?php
if(!isset($_SESSION)){ session_start(); }
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
//DADOS PRESTADORES
		$query_strPrestadores = "select bbh_usuario.bbh_usu_codigo, bbh_usuario.bbh_usu_identificacao, bbh_usuario.bbh_usu_apelido, 
      DATE_FORMAT(bbh_usuario.bbh_usu_data_nascimento,'%d/%m/%Y') AS bbh_usu_data_nascimento, 
      bbh_usuario.bbh_usu_sexo, bbh_usuario.bbh_usu_ultimoAcesso,bbh_dep_nome, bbh_usu_chefe 
       from bbh_usuario
        inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
            Where bbh_usuario.bbh_usu_chefe=".$_SESSION['usuCod']." and bbh_usu_codigo<>".$_SESSION['usuCod']."
         					group by bbh_usuario.bbh_usu_codigo
                 order by bbh_usu_apelido asc";
    list($strPrestadores, $row_strPrestadores, $totalRows_strPrestadores) = executeQuery($bbhive, $database_bbhive, $query_strPrestadores);

	$homeDestino 	= '/corporativo/servicos/bbhive/tarefas/acao/includes/executa.php?atrProf=true&bbh_ati_codigo='.$_GET['bbh_ati_codigo'].'&profissional=xxx&Ts='.time();

	if(($_SESSION['euChefe']==$_SESSION['usuCod']) && ($_SESSION['quem'] != $_SESSION['usuCod'])){
		$query_strChefia = "select bbh_usu_codigo, bbh_usu_identificacao, bbh_usu_apelido, DATE_FORMAT(bbh_usu_data_nascimento,'%d/%m/%Y') AS bbh_usu_data_nascimento, bbh_usu_sexo, 
			bbh_dep_nome, bbh_usu_ultimoAcesso from bbh_usuario inner join bbh_departamento on 
				bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo WHERE bbh_usu_codigo =".$_SESSION['euChefe'];
        list($strChefia, $row_strChefia, $totalRows_strChefia) = executeQuery($bbhive, $database_bbhive, $query_strChefia);
?>
        
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td colspan="5" align="left" class="verdana_13" style="border-bottom:1px solid #666666;"><span class="verdana_13"><a href="#@"><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a><strong>CHEFIA</strong></span></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="56" height="1"></td>
    <td width="155" valign="top" height="1"></td>
    <td height="1"></td>
    <td width="55" height="1"></td>
    <td width="155" valign="top" height="1"></td>
  </tr>
  <tr>
<?php if($totalRows_strChefia>0){ ?>
    <?php 
   $contador=0;
   do{ 
   	$usuario = $row_strChefia['bbh_usu_codigo'];
   		if($contador==2){
			echo "</tr><tr>";
			$contador=0;
                }
   ?>
    <!-- Imagem -->
    <td width="56"><table style="height:52px; width:59px; border:1px groove #CCCCCC; margin-top:5px; background:#FFFFFF">
      <tr>
        <td><?php		$codigo = $row_strChefia['bbh_usu_codigo'];
			$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";

			if(file_exists($ImagemOriginal)){
				//A função acima não deu certo!!!
				list($width, $height) = getimagesize($ImagemOriginal);
				echo imagem($width,$height,$ImagemOriginal,$aprox=60);
			} else {
				if($row_strChefia['bbh_usu_sexo']=="1"){
					$icone = "icone_H-medio";
				} else {
					$icone = "icone_M-medio";
				} 
				echo '<img src="/corporativo/servicos/bbhive/images/'.$icone.'.gif" border="0" />';
			}
			
	$dados 	= $row_strChefia['bbh_usu_codigo']."|".$row_strChefia['bbh_usu_apelido']."|".$row_strChefia['bbh_dep_nome'];
	$link 	= str_replace("profissional=xxx","profissional=".$dados, $homeDestino);
$acaoDecisao= "OpenAjaxPostCmd('".$link."','menLoad','&1=1','Atualizando informa&ccedil;&otilde;es...','menLoad','2','2');";
?>
        </td>
      </tr>
    </table></td>
    <!-- Dados -->
    <td width="155" valign="top" onClick="javascript: if(confirm('     Tem certeza que deseja prosseguir com esta ação?!\n Ao clicar em OK esta atividade se destinará a outro profissional!')){<?php echo $acaoDecisao; ?>}" onmouseover="return Ativa('sub_<?php echo $codigo; ?>')" onmouseout="return Desativa('sub_<?php echo $codigo; ?>')" id="sub_<?php echo $codigo; ?>"><div style="margin-top:2px;">
      <p><?php echo $row_strChefia['bbh_usu_apelido']; ?><br />
            <?php echo $row_strChefia['bbh_dep_nome']; ?><br />
        <br />
        &Uacute;ltimo acesso: <?php echo arrumadata(substr($row_strChefia['bbh_usu_ultimoAcesso'],0,10))." ".substr($row_strChefia['bbh_usu_ultimoAcesso'],11,5); ?><br />
      </p>
    </div></td>
    <?php $contador = $contador + 1;
   	 if($contador!=2){
	 	echo "<td height='1'></td>";
	 }
   } while ($row_strChefia = mysqli_fetch_assoc($strChefia)); ?>
  </tr>
<?php } else { ?>
  <tr>
    <td height="1" colspan="5" class="color">N&atilde;o h&aacute; dados cadastrados!</td>
  </tr>
<?php } ?>
</table>

        <?php
	}
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td colspan="5" align="left" class="verdana_13" style="border-bottom:1px solid #666666;"><a href="#@"><img src="/corporativo/servicos/bbhive/images/equipe-cliente.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a><strong> PRESTADORES DE SERVI&Ccedil;OS</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="56" height="1"></td>
    <td width="155" valign="top" height="1"></td>
    <td height="1"></td>
    <td width="55" height="1"></td>
    <td width="155" valign="top" height="1"></td>
  </tr>
  
<?php if($totalRows_strPrestadores>0){ ?>    
  <tr>
   <?php 
   $contador=0;
   do{ 
   		$usuario = $row_strPrestadores['bbh_usu_codigo'];
   		if($contador==2){
			echo "</tr><tr>";
			$contador=0;
                }
   ?>
   <!-- Imagem -->
    <td width="56">
    	<table style="height:52px; width:59px; border:1px groove #CCCCCC; margin-top:5px; background:#FFFFFF">
        	<tr>
            	<td>
<?php		$codigo = $row_strPrestadores['bbh_usu_codigo'];
			$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";

			if(file_exists($ImagemOriginal)){
				//A função acima não deu certo!!!
				list($width, $height) = getimagesize($ImagemOriginal);
				echo imagem($width,$height,$ImagemOriginal,$aprox=60);
			} else {
				if($row_strPrestadores['bbh_usu_sexo']=="1"){
					$icone = "icone_H-medio";
				} else {
					$icone = "icone_M-medio";
				} 
				echo '<img src="/corporativo/servicos/bbhive/images/'.$icone.'.gif" border="0" />';
			}
?>                </td>
            </tr>
        </table>
    </td>
   <!-- Dados -->
   <?php
	$dados 	= $row_strPrestadores['bbh_usu_codigo']."|".$row_strPrestadores['bbh_usu_apelido']."|".$row_strPrestadores['bbh_dep_nome'];
	$link 	= str_replace("profissional=xxx","profissional=".$dados, $homeDestino);
$acaoDecisao= "OpenAjaxPostCmd('".$link."','menLoad','&1=1','Atualizando informa&ccedil;&otilde;es...','menLoad','2','2');";

   ?>
    <td width="155" valign="top" onClick="javascript: if(confirm('     Tem certeza que deseja prosseguir com esta ação?!\n Ao clicar em OK esta atividade se destinará a outro profissional!')){<?php echo $acaoDecisao; ?>}" onMouseOver="return Ativa('prest_<?php echo $codigo; ?>')" onMouseOut="return Desativa('prest_<?php echo $codigo; ?>')" id="prest_<?php echo $codigo; ?>">
    <div style="margin-top:2px;">
    <p><?php echo $row_strPrestadores['bbh_usu_apelido']; ?><br />
      <?php echo $row_strPrestadores['bbh_dep_nome']; ?><br /><br />
      &Uacute;ltimo acesso: <?php echo arrumadata(substr($row_strPrestadores['bbh_usu_ultimoAcesso'],0,10))." ".substr($row_strPrestadores['bbh_usu_ultimoAcesso'],11,5); ?><br />
      </div>
      </td>
   <?php $contador = $contador + 1;
   	 if($contador!=2){
	 	echo "<td height='1'></td>";
	 }
   } while ($row_strPrestadores = mysqli_fetch_assoc($strPrestadores)); ?>
  </tr>
<?php } else { ?>
  <tr>
    <td height="1" colspan="5" class="color">N&atilde;o h&aacute; dados cadastrados!</td>
  </tr>
<?php } ?>
</table>