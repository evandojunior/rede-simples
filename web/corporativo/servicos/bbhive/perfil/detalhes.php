<?php require_once('../../../../Connections/bbhive.php'); ?><?php
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$usuario = -1;
if(isset($_GET['usuario'])){
	$usuario = $_GET['usuario'];
}

$query_dados = "SELECT DATE_FORMAT(bbh_usu_data_nascimento,'%d/%m/%Y') AS data_nascimento, bbh_departamento.bbh_dep_nome, bbh_per_nome, bbh_usuario.* FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo left JOIN bbh_usuario_perfil ON bbh_usuario_perfil.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo LEFT JOIN bbh_perfil ON bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo WHERE bbh_usuario.bbh_usu_codigo = $usuario";
list($dados, $row_dados, $totalRows_dados) = executeQuery($bbhive, $database_bbhive, $query_dados);

$query_chefe = "SELECT bbh_usu_apelido AS chefe FROM bbh_usuario WHERE bbh_usu_codigo = ".$row_dados['bbh_usu_chefe'];
list($chefe, $row_chefe, $totalRows_chefe) = executeQuery($bbhive, $database_bbhive, $query_chefe);

?><link rel="stylesheet" href="../includes/bbhive.css" /><?php require_once('gerencia.php'); ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="34%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/corporativo/servicos/bbhive/images/ferramentas.gif" width="23" height="23" align="absmiddle" /> Ferramentas: </td>
    <td width="31%" align="right" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><a href="#" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php?subordinado=<?php echo $usuario; ?>|includes/colunaDireita.php?fluxosDireita=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita')"><img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" /> Gerenciar <?php echo $q=$_SESSION['TarefasNome']; ?>&nbsp;&nbsp;</a></td>
    <td width="15%" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11"><a href="#" onclick="return gerenciaPerfil('/corporativo/servicos/bbhive/perfil/perfil.php?usuario=<?php echo $usuario; ?>')"><img src="/corporativo/servicos/bbhive/images/perfil.gif" alt="" width="14" height="14" border="0" align="absmiddle" /> Atribuir perfil</a></td>
    <?php
	
	?>
    <td width="20%" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11"><a href="#" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&mensagens=1|mensagens/envio/regra.php?caixaEntrada=True&usu_destino=<?php echo $usuario; ?>|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/enviarmsg.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> Enviar mensagem</a></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FBFBFB" class="verdana_11">
  <tr class="verdana_12">
    <td rowspan="6" align="center">
      <table style="height:90px; width:79px; margin-top:5px; border:1px groove #CCCCCC;"><tr><td><?php
		$codigo = $row_dados['bbh_usu_codigo'];
	
		$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";

		if(file_exists($ImagemOriginal)){
			//A função acima não deu certo!!!
			list($width, $height) = getimagesize($ImagemOriginal);
			echo imagem($width,$height,$ImagemOriginal,$aprox=90);
		} else {
			if($row_dados['bbh_usu_sexo']=="1"){
				$icone = "icone_H-medio";
			} else {
				$icone = "icone_M-medio";
			} 
			echo '<img src="/corporativo/servicos/bbhive/images/'.$icone.'.gif" border="0" />';
		}
?></td></tr></table></td>
    <td colspan="2"><strong class="verdana18"><?php echo $row_dados['bbh_usu_apelido']; ?></strong></td>
  </tr>
  <tr>
    <td width="16%" align="left">&nbsp;Idade </td>
    <td width="65%" class="color"><span style="color:#000000">:</span>&nbsp;<?php 
		  $Idade = determinar_idade($row_dados['data_nascimento']);
	  	
	  	if($Idade>1){ 
			echo $Idade." anos";
		} elseif($Idade==1) { 
			echo $Idade." ano"; 
		} else {
			echo " ---";
		}
	  ?></td>
  </tr>
  <tr>
    <td align="left">&nbsp;Sexo </td>
    <td class="color"><span style="color:#000000">:</span>&nbsp;<?php if($row_dados['bbh_usu_sexo']=1){echo "Masculino"; }else{echo "Feminino"; }?></td>
  </tr>
  <tr>
    <td align="left">&nbsp;Departamento </td>
    <td class="color"><span style="color:#000000">:</span>&nbsp;<?php echo $row_dados['bbh_dep_nome']; ?></td>
  </tr>
  <tr>
    <td align="left">&nbsp;Chefe </td>
    <td class="color"><span style="color:#000000">:</span>&nbsp;<?php echo $row_chefe['chefe']; ?></td>
  </tr>
  <tr class="verdana_12">
    <td colspan="2" valign="top"></td>
  </tr>
  <tr>
    <td colspan="3" align="right" style="border-bottom:dashed 1pz #CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="9" colspan="3"><fieldset><legend>Perfil</legend>
    <div id="listaPerfil">
<?php do { ?>
<img src="/corporativo/servicos/bbhive/images/perfil.gif" alt="" width="14" height="14" align="absmiddle" />&nbsp;<?php
				if($row_dados['bbh_per_nome']!=NULL){
				  echo $row_dados['bbh_per_nome'].'<br/><img src="/corporativo/servicos/bbhive/images/espaco.gif" align="absmiddle" /><br/>';
			 	} else { echo "Esse usu&aacute;rio n&atilde;o possui perfis"; };
			 ?>            <?php } while ($row_dados = mysqli_fetch_assoc($dados));

                    list($dados, $row_dados, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_dados);
			?>
    </div>	
    </fieldset></td>
  </tr>
  <tr>
    <td height="9" colspan="3" style="border-bottom:1px dashed #CCCCCC;">&nbsp;</td>
  </tr>
  <tr>
    <td height="9" colspan="3" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="19%" align="right"  class="verdana_11_cinza_escuro verdana_11_bold"><u>Contato</u>&nbsp;&nbsp;</td>
    <td height="20" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Tel. comercial :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_tel_comercial">&nbsp;<?php echo $row_dados['bbh_usu_tel_comercial']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Tel. residencial :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_tel_residencial">&nbsp;<?php echo $row_dados['bbh_usu_tel_residencial']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Celular :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_tel_celular">&nbsp;<?php echo $row_dados['bbh_usu_tel_celular']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Tel. para recados :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_tel_recados">&nbsp;<?php echo $row_dados['bbh_usu_tel_recados']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Fax :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_fax">&nbsp;<?php echo $row_dados['bbh_usu_fax']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">E-Mail :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_identificacao">&nbsp;<?php echo $row_dados['bbh_usu_identificacao']; ?></td>
  </tr>
  <tr>
    <td style="border-bottom:1px dashed #CCCCCC;" align="right" class="verdana_11_cinza_escuro">E-Mail alternativo :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_email_alternativo" style="border-bottom:1px dashed #CCCCCC;">&nbsp;<?php echo $row_dados['bbh_usu_email_alternativo']; ?></td>
  </tr>
  <tr>
    <td height="9" colspan="3" align="right"></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro verdana_11_bold"><u>Localiza&ccedil;&atilde;o</u>&nbsp;&nbsp;</td>
    <td height="20" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Endere&ccedil;o :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_endereco">&nbsp;<?php echo $row_dados['bbh_usu_endereco']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Cidade :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_cidade">&nbsp;<?php echo $row_dados['bbh_usu_cidade']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">Estado :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_estado">&nbsp;<?php echo $row_dados['bbh_usu_estado']; ?></td>
  </tr>
  <tr>
    <td align="right" class="verdana_11_cinza_escuro">CEP :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_cep">&nbsp;<?php echo $row_dados['bbh_usu_cep']; ?></td>
  </tr>
  <tr>
    <td style="border-bottom:1px dashed #CCCCCC;" align="right" class="verdana_11_cinza_escuro">Pa&iacute;s :</td>
    <td height="20" colspan="2" class="color" id="bbh_usu_pais" style="border-bottom:1px dashed #CCCCCC;">&nbsp;<?php echo $row_dados['bbh_usu_pais']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2" id="loadEdita">&nbsp;</td>
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
</table>
<?php
mysqli_free_result($dados);

	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Visualizou a página com os detalhes do perfil de (" . $row_dados['bbh_usu_apelido'] . ") - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
?>
