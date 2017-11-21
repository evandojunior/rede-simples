<?php
	if(!isset($_SESSION)){session_start();}
if(getCurrentPage()!="/corporativo/servicos/bbhive/equipe/gerencia.php"){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
}

	$query_Adicionados = "select bbh_usuario.bbh_usu_codigo, bbh_usu_nome, DATE_FORMAT(bbh_usu_data_nascimento,'%d/%m/%Y') as bbh_usu_data_nascimento, bbh_usu_tel_celular, bbh_usuario_perfil.bbh_per_codigo, DATE_FORMAT(bbh_usu_ultimoAcesso, '%d/%m/%Y %H:%i:%s') as bbh_usu_ultimoAcesso, bbh_dep_nome
	from bbh_usuario
      inner join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
	  inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
           Where bbh_usuario_perfil.bbh_per_codigo=".$_GET['bbh_per_codigo']." and bbh_usu_chefe=".$_SESSION['usuCod']." 
		   group by bbh_usuario_perfil.bbh_usu_codigo
		order by bbh_usu_nome asc";
    list($Adicionados, $row_Adicionados, $totalRows_Adicionados) = executeQuery($bbhive, $database_bbhive, $query_Adicionados);

	$TimeStamp 		= time();
	$idMensagemFinal= '"loadPerfil"';
	$infoGet_Post	= '"&1=1"';//Se envio for POST, colocar nome do formulário
	$Mensagem		= '"Atualizando dados..."';
	$idResultado	= '"direita"';
	$Metodo			= '"2"';//1-POST, 2-GET
	$TpMens			= '"1"';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '"/corporativo/servicos/bbhive/equipe/profissionais.php?bbh_per_codigo='.$_GET['bbh_per_codigo'].'&Ts='.$TimeStamp.'"';
		
	//esquerda	
	echo "<var style=\"display:none\">OpenAjaxPostCmd($homeDestino,$idResultado,$infoGet_Post,$Mensagem,$idMensagemFinal,$Metodo,$TpMens)</var>".chr(13).chr(10);
?>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" colspan="2" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Profissionais adicionados</strong></td>
  </tr>
<?php 
	$HTML="N&atilde;o h&aacute; registros a adicionados.";

if($totalRows_Adicionados>0) { ?>
	 <?php  
	 	$HTML="";
	 do { 
		$codigo = $row_Adicionados['bbh_usu_codigo'];
				$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";
		
				if(file_exists($ImagemOriginal)){
					//A função acima não deu certo!!!
					list($width, $height) = getimagesize($ImagemOriginal);
					$Foto = imagem($width,$height,$ImagemOriginal,$aprox=51);
				} else {
					if($row_Profissionais['bbh_usu_sexo']=="1"){
						$icone = "icone_H-medio";
					} else {
						$icone = "icone_M-medio";
					} 
					$Foto = '<img src="/corporativo/servicos/bbhive/images/'.$icone.'.gif" border="0" />';
				}
		
		$Idade = determinar_idade($row_Adicionados['bbh_usu_data_nascimento']);
			if($Idade>1){ 
				$Idade = $Idade." Anos";
			} elseif($Idade==1) { 
				$Idade = $Idade." Ano"; 
			} else {
				$Idade = " ---";
			}
				
	
		$HTML.= $Foto;
		$HTML.= '&nbsp;<label style="position:absolute; margin-left:10px;text-align:left" class="verdana_11 color"><span class="color"><strong>'.$row_Adicionados['bbh_usu_nome'].'</strong></span><br /><span>'.$row_Adicionados['bbh_dep_nome'].'</span><br /><span>&Uacute;ltimo acesso: '.arrumadata(substr($row_Adicionados['bbh_usu_ultimoAcesso'],0,10))." ".substr($row_Adicionados['bbh_usu_ultimoAcesso'],11,5).'</span></label><br/>';
	 ?>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td width="172" align="left"><a href="#" onClick="return gerencia('/corporativo/servicos/bbhive/equipe/atribuicao.php?bbh_usu_codigo=<?php echo $row_Adicionados['bbh_usu_codigo']; ?>&bbh_per_codigo=<?php echo $_GET['bbh_per_codigo']; ?>','del');">&nbsp;<img src="/corporativo/servicos/bbhive/images/perfil.gif" width="14" height="14" align="absmiddle" border="0" />&nbsp;<?php echo $row_Adicionados['bbh_usu_nome']; ?></a></td>
    <td width="28" align="center"><img src="/corporativo/servicos/bbhive/images/exc.gif" width="16" height="15"></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
     <?php }while($row_Adicionados = mysqli_fetch_assoc($Adicionados)); ?>
<?php } else { ?> 
  <tr>
    <td colspan="2" height="19" align="center">
            <span class="verdana_9 color">N&atilde;o h&aacute; registros a adicionados.</span></td>
  </tr>
<?php } ?>
</table><var style="display:none">document.getElementById('filho_<?php echo $_GET['bbh_per_codigo']; ?>').innerHTML='<?php echo $HTML; ?>'</var>