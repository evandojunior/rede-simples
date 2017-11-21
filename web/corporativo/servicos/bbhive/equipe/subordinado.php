<?php
//DADOS SUBORDINADOS
$AjusteSub = " LIMIT 0,10";
if(isset($_GET['subTodos'])){
	$AjusteSub = "";
}
		$query_strSubordinados = "select Subordinados.bbh_usu_codigo, Subordinados.bbh_usu_identificacao, Subordinados.bbh_usu_apelido, 
      DATE_FORMAT(Subordinados.bbh_usu_data_nascimento,'%d/%m/%Y') AS bbh_usu_data_nascimento, 
      Subordinados.bbh_usu_sexo, Subordinados.bbh_usu_ultimoAcesso,bbh_dep_nome 
      from bbh_usuario
      inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
       inner join bbh_usuario as Subordinados on bbh_usuario.bbh_usu_codigo = Subordinados.bbh_usu_chefe
            Where Subordinados.bbh_usu_chefe=".$_SESSION['usuCod']."
                 order by bbh_usu_apelido asc $AjusteSub";
        list($strSubordinados, $row_strSubordinados, $totalRows_strSubordinados) = executeQuery($bbhive, $database_bbhive, $query_strSubordinados);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td colspan="5" align="left" class="verdana_13" style="border-bottom:1px solid #666666;"><img src="/corporativo/servicos/bbhive/images/equipe-operacional.gif" alt="" width="16" height="16" align="absmiddle" /> <strong>OPERACIONAL</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="59" height="1"></td>
    <td width="241" valign="top" height="1"></td>
    <td width="85" height="1"></td>
    <td width="55" height="1"></td>
    <td width="155" valign="top" height="1"></td>
  </tr>
  
<?php if($totalRows_strSubordinados>0){ ?>  
  <tr>
   <?php 
   $contador=0;
   do{ 
   		if($contador==2){
			echo "</tr><tr>";
			$contador=0;
                }
   ?>
   <!-- Imagem -->
    <td width="59">
    	<table style="height:52px; width:59px; border:1px groove #CCCCCC; margin-top:5px; background:#FFFFFF">
        	<tr>
            	<td>
<?php		$codigo = $row_strSubordinados['bbh_usu_codigo'];
			$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";

			if(file_exists($ImagemOriginal)){
				//A função acima não deu certo!!!
				list($width, $height) = getimagesize($ImagemOriginal);
				echo imagem($width,$height,$ImagemOriginal,$aprox=60);
			} else {
				if($row_strSubordinados['bbh_usu_sexo']=="1"){
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
    <td width="241" valign="top" onClick="LoadSimultaneo('perfil/index.php?perfil=1&amp;equipe=1|perfil/detalhes.php?usuario=<?php echo $row_strSubordinados['bbh_usu_codigo']; ?>|includes/colunaDireita.php?tarefasDireita=1&amp;fluxosDireita=1&amp;equipeFluxos=1','menuEsquerda|colCentro|colDireita');" onMouseOver="return Ativa('sup_<?php echo $codigo; ?>')" onMouseOut="return Desativa('sup_<?php echo $codigo; ?>')" id="sup_<?php echo $codigo; ?>">
    <div style="margin-top:2px;">
    <p><?php echo $row_strSubordinados['bbh_usu_apelido']; ?><br />
      <?php echo $row_strSubordinados['bbh_dep_nome']; ?><br />
       <?php /*Idade : 
		  $Idade = determinar_idade($row_strSubordinados['bbh_usu_data_nascimento']);
	  	
	  	if($Idade>1){ 
			echo $Idade." Anos";
		} elseif($Idade==1) { 
			echo $Idade." Ano"; 
		} else {
			echo " ---";
		}*/
	  ?><br />
      &Uacute;ltimo acesso: <?php echo arrumadata(substr($row_strSubordinados['bbh_usu_ultimoAcesso'],0,10))." ".substr($row_strSubordinados['bbh_usu_ultimoAcesso'],11,5); ?><br />
      </div>
      </td>
   <?php $contador = $contador + 1;
   	 if($contador!=2){
	 	echo "<td height='1'></td>";
	 }
   } while ($row_strSubordinados = mysqli_fetch_assoc($strSubordinados)); ?>
<?php } else { ?>
  <tr>
    <td height="1" colspan="5" class="color">N&atilde;o h&aacute; dados cadastrados!</td>
  </tr>
<?php } ?>
  </tr>
</table>
<?php if(!isset($_GET['subTodos'])){ ?>
 <?php if($totalRows_strSubordinados>0){ ?>  
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
	<tr>
    	<td align="right"><a href="#@" title="Clique para ver mais" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=1&subTodos=1&tomadores=0&prestadores=0|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><span class="color">ver todos</span></a></td>
    </tr>
</table>
<?php }
}?>
<?php mysqli_free_result($strSubordinados); ?>