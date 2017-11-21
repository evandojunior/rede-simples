<?php
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$query_dados = "SELECT DATE_FORMAT(bbh_usu_data_nascimento,'%d/%m/%Y') AS data_nascimento, bbh_departamento.bbh_dep_nome, bbh_usuario.* FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo WHERE bbh_usu_codigo =".$_SESSION['usuCod'];
list($dados, $row_dados, $totalRows_dados) = executeQuery($bbhive, $database_bbhive, $query_dados);

$query_chefe = "SELECT bbh_usu_nome AS chefe FROM bbh_usuario WHERE bbh_usu_codigo = ".$row_dados['bbh_usu_chefe'];
list($chefe, $row_chefe, $totalRows_chefe) = executeQuery($bbhive, $database_bbhive, $query_chefe);

?><link rel="stylesheet" href="../includes/bbhive.css" /><div style="position:absolute" id="upload"></div>
<form name="formEditaPerfil" id="formEditaPerfil"><input type="hidden" name="sexo" id="sexo"  value="" />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="verdana_11">
  <tr class="verdana_12">
    <td colspan="2" style="border-bottom:1px solid #333333;"><img src="/corporativo/servicos/bbhive/images/equipe-eu.gif" width="16" height="16" border="0" align="absmiddle"> <strong>MEUS DADOS</strong><div style="float:right; "><a href="#" onclick="return chamaUpload('/corporativo/servicos/bbhive/perfil/foto.php');">Trocar foto</a></div></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB"></td>
    <td align="right" bgcolor="#FBFBFB">
<div style="margin-right:90px; margin-top:1px;" id="btnCancelar" class="displayNone">
  <a href="#" onclick="return edita('/corporativo/servicos/bbhive/perfil/atualizados.php', 1, 'formEditaPerfil');">
	<img src="/corporativo/servicos/bbhive/images/cancel.gif" width="78" height="21" border="0" />
  </a>
</div>
    
<div style="margin-top:1px;" id="btnEditar">
  <a href="#" onclick="return edita('/corporativo/servicos/bbhive/perfil/dados.php', 2, '&1=1');">
	<img src="/corporativo/servicos/bbhive/images/edit.gif" width="78" height="21" border="0" />
  </a>
</div>

<div style="margin-top:-23px; display:none;" id="btnSalvar">
  <a href="#" onclick="return edita('/corporativo/servicos/bbhive/perfil/executa.php', 1, 'formEditaPerfil');">
	<img src="/corporativo/servicos/bbhive/images/save.gif" width="78" height="21" border="0" />
  </a>
</div>
</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB" class="verdana_11_cinza verdana_11_bold"><u>Pessoal</u>&nbsp;&nbsp;</td>
    <td height="20" bgcolor="#FBFBFB">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Nome :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_nome">&nbsp;<?php echo $row_dados['bbh_usu_nome']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Apelido:</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_apelido">&nbsp;<?php echo $row_dados['bbh_usu_apelido']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Idade :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="data_nascimento">&nbsp;<?php 
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
    <td align="right" bgcolor="#FBFBFB">Sexo :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_sexo">&nbsp;<?php if($row_dados['bbh_usu_sexo']==1){echo "Masculino"; }else{echo "Feminino"; }?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">RG :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_rg">&nbsp;<?php echo $row_dados['bbh_usu_rg']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">CPF :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_cpf">&nbsp;<?php echo $row_dados['bbh_usu_cpf']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Departamento :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_dep_nome">&nbsp;<?php echo $row_dados['bbh_dep_nome']; ?></td>
  </tr>
  <tr>
    <td style="border-bottom:1px dashed #CCCCCC;" align="right" bgcolor="#FBFBFB">Chefe :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="chefe" style="border-bottom:1px dashed #CCCCCC;">&nbsp;<?php echo $row_chefe['chefe']; ?></td>
  </tr>
  <tr>
    <td height="9" colspan="2" align="right" bgcolor="#FBFBFB">&nbsp;</td>
  </tr>
  <tr>
    <td width="24%" align="right" bgcolor="#FBFBFB" class="verdana_11_cinza verdana_11_bold"><u>Contato</u>&nbsp;&nbsp;</td>
    <td width="76%" height="20" bgcolor="#FBFBFB">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Tel. comercial :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_tel_comercial">&nbsp;<?php echo $row_dados['bbh_usu_tel_comercial']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Tel. residencial :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_tel_residencial">&nbsp;<?php echo $row_dados['bbh_usu_tel_residencial']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Celular :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_tel_celular">&nbsp;<?php echo $row_dados['bbh_usu_tel_celular']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Tel. para recados :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_tel_recados">&nbsp;<?php echo $row_dados['bbh_usu_tel_recados']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Fax :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_fax">&nbsp;<?php echo $row_dados['bbh_usu_fax']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">E-Mail :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_identificacao">&nbsp;<?php echo $row_dados['bbh_usu_identificacao']; ?></td>
  </tr>
  <tr>
    <td style="border-bottom:1px dashed #CCCCCC;" align="right" bgcolor="#FBFBFB">E-Mail alternativo :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_email_alternativo" style="border-bottom:1px dashed #CCCCCC;">&nbsp;<?php echo $row_dados['bbh_usu_email_alternativo']; ?></td>
  </tr>
  <tr>
    <td height="9" colspan="2" align="right" bgcolor="#FBFBFB"></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB" class="verdana_11_cinza verdana_11_bold"><u>Localiza&ccedil;&atilde;o</u>&nbsp;&nbsp;</td>
    <td height="20" bgcolor="#FBFBFB">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Endere&ccedil;o :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_endereco">&nbsp;<?php echo $row_dados['bbh_usu_endereco']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Cidade :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_cidade">&nbsp;<?php echo $row_dados['bbh_usu_cidade']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">Estado :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_estado">&nbsp;<?php echo $row_dados['bbh_usu_estado']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">CEP :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_cep">&nbsp;<?php echo $row_dados['bbh_usu_cep']; ?></td>
  </tr>
  <tr>
    <td style="border-bottom:1px dashed #CCCCCC;" align="right" bgcolor="#FBFBFB">Pa&iacute;s :</td>
    <td height="22" bgcolor="#FBFBFB" class="color" id="bbh_usu_pais" style="border-bottom:1px dashed #CCCCCC;">&nbsp;<?php echo $row_dados['bbh_usu_pais']; ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FBFBFB">&nbsp;</td>
    <td bgcolor="#FBFBFB" id="loadEdita" height="22">&nbsp;</td>
  </tr>
</table><input name="MM_update" type="hidden" id="MM_update" value="1">
</form>
<div id="resto" class="verdana_11 color" height="22" style="position:absolute; margin-top:-10px"></div>
<?php
mysqli_free_result($dados);
?>
