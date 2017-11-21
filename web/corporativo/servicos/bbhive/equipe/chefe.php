<?php
//recupera o código da mensagem
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_men_codigo")||($indice=="bbh_men_codigo")){ $bbh_men_codigo=$valor; }
}

//DADOS DA CHEFIA
$AjusteTodosChefes = " bbh_usu_codigo = ".$row_strPerfil['bbh_usu_chefe'];
if(isset($_GET['todosChefes'])){
	$AjusteTodosChefes = " bbh_usu_chefe = bbh_usu_codigo";
}
		$query_strChefia = "select bbh_usu_codigo, bbh_usu_identificacao, bbh_usu_apelido, DATE_FORMAT(bbh_usu_data_nascimento,'%d/%m/%Y') AS bbh_usu_data_nascimento, bbh_usu_sexo, 
			bbh_dep_nome, bbh_usu_ultimoAcesso from bbh_usuario inner join bbh_departamento on 
				bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo WHERE $AjusteTodosChefes";

        list($strChefia, $row_strChefia, $totalRows_strChefia) = executeQuery($bbhive, $database_bbhive, $query_strChefia);
		
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td colspan="5" align="left" class="verdana_13" style="border-bottom:1px solid #666666;"><span class="verdana_13" style="border-bottom:1px solid #666666;"><a href="#@"><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a><strong>CHEFIA</strong></span></td>
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
			
		//verifico se é nova ou se estou encaminhando
		$pagina = isset($bbh_men_codigo) ? "encaminhar.php?bbh_men_codigo=$bbh_men_codigo&" : "regra.php?";
?>
        </td>
      </tr>
    </table></td>
    <!-- Dados -->
    <td width="155" valign="top" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&mensagens=1|mensagens/envio/<?php echo $pagina; ?>caixaEntrada=True&usu_destino=<?php echo $usuario; ?>|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita');" onmouseover="return Ativa('sub_<?php echo $codigo; ?>')" onmouseout="return Desativa('sub_<?php echo $codigo; ?>')" id="sub_<?php echo $codigo; ?>"><div style="margin-top:2px;">
      <p><?php echo $row_strChefia['bbh_usu_apelido']; ?><br />
            <?php echo $row_strChefia['bbh_dep_nome']; ?><br />
       <?php  /*Idade :
        
		  $Idade = determinar_idade($row_strChefia['bbh_usu_data_nascimento']);
	  	
	  	if($Idade>1){ 
			echo $Idade." Anos";
		} elseif($Idade==1) { 
			echo $Idade." Ano"; 
		} else {
			echo " ---";
		}*/
	  ?>
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
<?php mysql_free_result($strChefia); ?>
