<?php
//DADOS SUBORDINADOS
$AjusteToma = " LIMIT 0,10";
if(isset($_GET['subTomadores'])){
	$AjusteToma = "";
}
		$query_strTomadores = "select 
      bbh_usuario.bbh_usu_codigo, bbh_usuario.bbh_usu_identificacao, bbh_usuario.bbh_usu_apelido, 
      DATE_FORMAT(bbh_usuario.bbh_usu_data_nascimento,'%d/%m/%Y') AS bbh_usu_data_nascimento, 
      bbh_usuario.bbh_usu_sexo, bbh_usuario.bbh_usu_ultimoAcesso,bbh_dep_nome
      
 from bbh_atividade
  inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
   inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
    inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo
      Where bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod']." and bbh_fluxo.bbh_usu_codigo<>".$_SESSION['usuCod']."
      
        group by bbh_fluxo.bbh_usu_codigo $AjusteToma";
        list($strTomadores, $row_strTomadores, $totalRows_strTomadores) = executeQuery($bbhive, $database_bbhive, $query_strTomadores);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td colspan="5" align="left" class="verdana_13" style="border-bottom:1px solid #666666;"><a href="#@"><img src="/corporativo/servicos/bbhive/images/equipe-cliente.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a><strong> TOMADORES DE SERVI&Ccedil;OS</strong></td>
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
  
<?php if($totalRows_strTomadores>0){ ?>   
  <tr>
   <?php 
   $contador=0;
   do{ 
   		$usuario = $row_strTomadores['bbh_usu_codigo'];
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
<?php		$codigo = $row_strTomadores['bbh_usu_codigo'];
			$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";

			if(file_exists($ImagemOriginal)){
				//A função acima não deu certo!!!
				list($width, $height) = getimagesize($ImagemOriginal);
				echo imagem($width,$height,$ImagemOriginal,$aprox=60);
			} else {
				if($row_strTomadores['bbh_usu_sexo']=="1"){
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
    <td width="241" valign="top" onClick="LoadSimultaneo('perfil/index.php?perfil=1&amp;equipe=1|mensagens/mensagemEquipe.php?usumsg=<?php echo $usuario; ?>|includes/colunaDireita.php?tarefasDireita=1&amp;fluxosDireita=1&amp;equipeFluxos=1','menuEsquerda|colCentro|colDireita');" onMouseOver="return Ativa('toma_<?php echo $codigo; ?>')" onMouseOut="return Desativa('toma_<?php echo $codigo; ?>')" id="toma_<?php echo $codigo; ?>">
    <div style="margin-top:2px;">
    <p><?php echo $row_strTomadores['bbh_usu_apelido']; ?><br />
      <?php echo $row_strTomadores['bbh_dep_nome']; ?><br />
      Idade : <?php 
		  $Idade = determinar_idade($row_strTomadores['bbh_usu_data_nascimento']);
	  	
	  	if($Idade>1){ 
			echo $Idade." Anos";
		} elseif($Idade==1) { 
			echo $Idade." Ano"; 
		} else {
			echo " ---";
		}
	  ?><br />
      &Uacute;ltimo acesso: <?php echo arrumadata(substr($row_strTomadores['bbh_usu_ultimoAcesso'],0,10))." ".substr($row_strTomadores['bbh_usu_ultimoAcesso'],11,5); ?><br />
      </div>
      </td>
   <?php $contador = $contador + 1;
   	 if($contador!=2){
	 	echo "<td height='1'></td>";
	 }
   } while ($row_strTomadores = mysqli_fetch_assoc($strTomadores)); ?>
  </tr>
<?php } else { ?>
  <tr>
    <td height="1" colspan="5" class="color">N&atilde;o h&aacute; dados cadastrados!</td>
  </tr>
<?php } ?>
</table>
	<?php if(!isset($_GET['subTomadores'])){ ?>
    	<?php if($totalRows_strTomadores>0){ ?>   
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="verdana_9">
        <tr>
            <td align="right"><a href="#@" title="Clique para ver mais" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&subTomadores=1&tomadores=1&prestadores=0|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><span class="color">ver todos</span></a></td>
        </tr>
</table>
    <?php }
	}?>
<?php mysql_free_result($strTomadores); ?>