<?php
//recupera o código da mensagem
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_men_codigo")||($indice=="bbh_men_codigo")){ $bbh_men_codigo=$valor; }
}

//DADOS TODOS EMPRESA
$Slq="";
	if(isset($_GET['inicia'])){
		if($_GET['inicia']=="true"){
			$Slq = "";
		}else{
			$Slq = " Where bbh_usu_apelido LIKE '".$_GET['inicia']."%'";
		}
	}
		$query_strEmpresa = "select 
			bbh_usuario.bbh_usu_codigo, 
            bbh_departamento.bbh_dep_codigo, bbh_dep_nome, 
			 bbh_usuario.bbh_usu_identificacao, bbh_usuario.bbh_usu_apelido, 
			DATE_FORMAT(bbh_usuario.bbh_usu_data_nascimento,'%d/%m/%Y') AS bbh_usu_data_nascimento, bbh_usuario.bbh_usu_sexo, 
			bbh_usuario.bbh_usu_ultimoAcesso,bbh_dep_nome 
			from bbh_usuario 
			inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo 
			$Slq
			order by bbh_dep_codigo, bbh_usu_apelido asc";
        list($strEmpresa, $row_strEmpresa, $totalRows_strEmpresa) = executeQuery($bbhive, $database_bbhive, $query_strEmpresa);
		
$onClick = "onClick=\"return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=0&prestadores=0&todosEmpresa=1&inicia=x|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');\"";

//--Verifica se usuário tem perfil para acessar o corporativo
function verificaPerfil($database_bbhive, $bbhive, $usuario){
	//--verifica se tem acesso a este ambiente
	  $LoginRS__query=sprintf("SELECT COALESCE(MAX(p.bbh_per_corp),0) as corp,
		u.bbh_usu_codigo, u.bbh_usu_identificacao, u.bbh_usu_nivel, u.bbh_usu_apelido 
		FROM bbh_usuario as u
		 LEFT JOIN bbh_usuario_perfil as up on u.bbh_usu_codigo = up.bbh_usu_codigo
		 LEFT JOIN bbh_perfil as p on up.bbh_per_codigo = p.bbh_per_codigo
		  WHERE u.bbh_usu_codigo=$usuario AND bbh_usu_ativo='1' and bbh_usu_nivel=584
			 GROUP BY u.bbh_usu_codigo
			  HAVING corp = 0");

    list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbhive, $database_bbhive, $LoginRS__query);
	  //--Se tiver acesso continua senão veta
	  if ($loginFoundUser) {
		  return true;
	  }	
	return false;  
}
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td colspan="5" align="left" class="verdana_13" style="border-bottom:1px solid #666666;"><a href="#@"><img src="/corporativo/servicos/bbhive/images/empresa.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a><strong>EMPRESA</strong></td>
  </tr>
  
  <tr>
    <td width="56" height="1"></td>
    <td width="155" valign="top" height="1"></td>
    <td height="1"></td>
    <td width="55" height="1"></td>
    <td width="155" valign="top" height="1"></td>
  </tr>
  <tr>
    <td height="26" colspan="5" align="left" background="/corporativo/servicos/bbhive/images/back_msg.jpg">
<label style="margin-left:5px"><a href="#@" <?php echo str_replace("inicia=x","inicia=a",$onClick)?>>A</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=b",$onClick)?>>B</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=c",$onClick)?>>C</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=d",$onClick)?>>D</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=e",$onClick)?>>E</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=f",$onClick)?>>F</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=g",$onClick)?>>G</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=h",$onClick)?>>H</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=i",$onClick)?>>I</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=j",$onClick)?>>J</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=k",$onClick)?>>K</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=l",$onClick)?>>L</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=m",$onClick)?>>M</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=n",$onClick)?>>N</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=o",$onClick)?>>O</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=p",$onClick)?>>P</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=q",$onClick)?>>Q</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=r",$onClick)?>>R</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=s",$onClick)?>>S</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=t",$onClick)?>>T</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=u",$onClick)?>>U</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=v",$onClick)?>>V</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=x",$onClick)?>>X</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=y",$onClick)?>>Y</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=w",$onClick)?>>W</a></label>
    	<label>-<a href="#@" <?php echo str_replace("inicia=x","inicia=z",$onClick)?>>Z</a></label>
  <br />
  &nbsp;
	    <label><a href="#@" <?php echo str_replace("inicia=x","inicia=true",$onClick)?>>todos</a></label>   	</td>
  </tr>
  <tr>
    <td height="1" colspan="5" align="center" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11" style="margin-top:2px">
  
  <tr>
    <td height="2" colspan="3" align="center"></td>
  </tr>
<?php if($totalRows_strEmpresa>0){ ?>
<?php 
$dpto = "";
do { 
	$codigo = $row_strEmpresa['bbh_usu_codigo'];
	
		if($dpto!=$row_strEmpresa['bbh_dep_codigo']){
	?>  
  <tr class="comum">
    <td height="2" colspan="10" align="left" class="titulo_setor" style="font-size:14px;"><img src="/corporativo/servicos/bbhive/images/departamento.gif" width="16" height="16" align="absmiddle" />&nbsp;<strong><?php echo $row_strEmpresa['bbh_dep_nome']; //. " " . $Idade; ?></strong></td>
  </tr>
  <tr class="comum">
    <td height="2" colspan="10" align="center"></td>
  </tr>
  <?php } ?>
  <tr id="sub_<?php echo $codigo; ?>" class="comum">
    <td width="10%" align="right">
<?php
		$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";

		if(file_exists($ImagemOriginal)){
			//A função acima não deu certo!!!
			list($width, $height) = getimagesize($ImagemOriginal);
			echo imagem($width,$height,$ImagemOriginal,$aprox=51);
		} else {
			if($row_strEmpresa['bbh_usu_sexo']=="1"){
				$icone = "icone_H-medio";
			} else {
				$icone = "icone_M-medio";
			} 
			echo '<img src="/corporativo/servicos/bbhive/images/'.$icone.'.gif" border="0" />';
		}
?>
    </td><?php 
		  $Idade = determinar_idade($row_strEmpresa['bbh_usu_data_nascimento']);
	  	
	  	if($Idade>1){ 
			$Idade = $Idade." Anos";
		} elseif($Idade==1) { 
			$Idade = $Idade." Ano"; 
		} else {
			$Idade = " ---";
		}
		
		
		//verifico se é nova ou se estou encaminhando
		$pagina = isset($bbh_men_codigo) ? "encaminhar.php?bbh_men_codigo=$bbh_men_codigo&" : "regra.php?";
	  ?>
    <td width="80%" valign="top" onmouseover="return Ativa('sub_<?php echo $codigo; ?>')" onmouseout="return Desativa('sub_<?php echo $codigo; ?>')" ><strong><?php echo $row_strEmpresa['bbh_usu_apelido']; //. " " . $Idade; ?></strong><br />
      <?php echo $row_strEmpresa['bbh_dep_nome']; ?><br />
      &Uacute;ltimo acesso: <?php echo arrumadata(substr($row_strEmpresa['bbh_usu_ultimoAcesso'],0,10))." ".substr($row_strEmpresa['bbh_usu_ultimoAcesso'],11,5); ?></td>
    <td width="10%" align="center" valign="top" onmouseover="return Ativa('sub_<?php echo $codigo; ?>')" onmouseout="return Desativa('sub_<?php echo $codigo; ?>')">
    <?php if(verificaPerfil($database_bbhive, $bbhive, $codigo)){?>
    <a href="#@" onmouseover="return Ativa('sub_<?php echo $codigo; ?>')" onmouseout="return Desativa('sub_<?php echo $codigo; ?>')"><img src="/corporativo/servicos/bbhive/images/msgII.gif" border="0" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&mensagens=1|mensagens/envio/<?php echo $pagina; ?>caixaEntrada=True&usu_destino=<?php echo $codigo; ?>|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita');" /></a>
    <?php } ?>
    </td>
  </tr>
  <tr class="comum">
    <td height="2" colspan="3" align="center"></td>
  </tr>
  <tr>
    <td height="1" colspan="3" align="center" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <tr class="comum">
    <td height="2" colspan="10" align="center">&nbsp;</td>
  </tr>
<?php $dpto=$row_strEmpresa['bbh_dep_codigo'];
} while ($row_strEmpresa = mysqli_fetch_assoc($strEmpresa)); ?>
	<?php } else { ?>
      <tr>
        <td height="1" colspan="3" align="center" class="color">N&atilde;o h&aacute; dados cadastrados <?php 
			if(isset($_GET['inicia'])){
				if($_GET['inicia']!="true"){
					echo " com a letra <strong>'".$_GET['inicia']."'</strong>";
				}
			}
		?>.</td>
      </tr>
    <?php } ?>
</table>
<?php mysqli_free_result($strEmpresa); ?>