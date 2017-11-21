<?php require_once('../../../../Connections/bbhive.php'); ?>
<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/usuarios/editar.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'editaUsuario';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editaUsuario")) {

	$novonome					= ($_POST['bbh_usu_nome']);
	$novoemail					= ($_POST['bbh_usu_identificacao']);
	$novocpf					= ($_POST['bbh_usu_cpf']);
	$novadata					= dataSQL($_POST['bbh_usu_data_nascimento']);
	$novosexo 					= $_POST['bbh_usu_sexo'];
	$novorg    					= ($_POST['bbh_usu_rg']);
	$novodepto					= $_POST['bbh_dep_codigo'];
	$bbh_usu_permissao_dep		= $_POST['bbh_usu_permissao_dep'];
	$novochefe					= $_POST['bbh_usu_chefe'];
	$novoemalt 					= ($_POST['bbh_usu_email_alternativo']);
	$novotelco					= ($_POST['bbh_usu_tel_comercial']);
	$novotelre = ($_POST['bbh_usu_tel_recados']);
	$novoend   = ($_POST['bbh_usu_endereco']);
	$novacidad = ($_POST['bbh_usu_cidade']);
	$novoestado= $_POST['bbh_usu_estado'];
	$novocep   = ($_POST['bbh_usu_cep']);
	$novopais  = ($_POST['bbh_usu_pais']);
	$novocod   = $_POST['bbh_usu_codigo'];
	$bbh_usu_ativo = $_POST['bbh_usu_ativo'];
	$novoapelido = ($_POST['bbh_usu_apelido']);
	$bbh_usu_cargo				= $_POST['bbh_usu_cargo'];
	$bbh_usu_restringir_receb_solicitacao = isset($_POST['bbh_usu_restringir_receb_solicitacao'])?1:0;
	$bbh_usu_restringir_ini_processo 		= isset($_POST['bbh_usu_restringir_ini_processo'])?1:0;
	
	//SELECT DA VALIDAÇÃO DE E-MAILS IGUAIS
	$query_validacao = "SELECT * FROM bbh_usuario WHERE (bbh_usu_identificacao = '$novoemail' OR bbh_usu_cpf = '$novocpf') AND bbh_usu_codigo != $novocod";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	$updateSQL = "UPDATE bbh_usuario SET bbh_usu_nome = '$novonome', bbh_usu_identificacao = '$novoemail', bbh_usu_apelido = '$novoapelido',bbh_usu_cpf = '$novocpf', bbh_usu_data_nascimento = '$novadata', bbh_usu_sexo = '$novosexo', bbh_usu_rg = '$novorg', bbh_dep_codigo = $novodepto, bbh_usu_chefe = $novochefe, bbh_usu_email_alternativo = '$novoemalt', bbh_usu_tel_comercial = '$novotelco', bbh_usu_tel_recados = '$novotelre', bbh_usu_endereco = '$novoend', bbh_usu_cidade = '$novacidad', bbh_usu_estado = '$novoestado', bbh_usu_cep = '$novocep', bbh_usu_pais = '$novopais', bbh_usu_ativo='$bbh_usu_ativo', bbh_usu_permissao_dep = '$bbh_usu_permissao_dep', bbh_usu_cargo = '$bbh_usu_cargo', bbh_usu_restringir_receb_solicitacao='$bbh_usu_restringir_receb_solicitacao', bbh_usu_restringir_ini_processo='$bbh_usu_restringir_ini_processo'  WHERE bbh_usu_codigo = $novocod";
	list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|usuarios/index.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	} else {
		 $Erro ="<span class='aviso' style='font-size:11;'>J&aacute; existe um usu&aacute;rio com o e-mail ou CPF inseridos.</span>";
  		 echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
}


	$codigo = -1;
	if(isset($_GET['bbh_usu_codigo'])){
		$codigo = $_GET['bbh_usu_codigo'];
	}

	//SELECT PARA INFORMAÇÕES DO USUÁRIO
	$query_usuario = "SELECT * FROM bbh_usuario WHERE bbh_usu_codigo = $codigo";
    list($usuario, $row_usuario, $totalRows_usuario) = executeQuery($bbhive, $database_bbhive, $query_usuario);

	//SELECT DO DEPARTAMENTO DO USUÁRIO
	$query_deptoUsu = "SELECT bbh_usuario.bbh_usu_identificacao, bbh_departamento.bbh_dep_nome, bbh_usuario.bbh_usu_codigo, bbh_departamento.bbh_dep_codigo FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo WHERE bbh_usu_codigo = $codigo";
    list($deptoUsu, $row_deptoUsu, $totalRows_deptoUsu) = executeQuery($bbhive, $database_bbhive, $query_deptoUsu);

	//SELECT DOS DEPARTAMENTOS
	$query_depto = "SELECT bbh_dep_codigo, bbh_dep_nome FROM bbh_departamento WHERE bbh_dep_nome != '".$row_deptoUsu['bbh_dep_nome']."' ORDER BY bbh_dep_nome ASC";
    list($depto, $row_depto, $totalRows_depto) = executeQuery($bbhive, $database_bbhive, $query_depto);
    list($deptoPermissao, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_depto, $initResult = false);
	
	//SELECT DO CHEFE
	$query_chefeUsu = "select bbh_usu_codigo, bbh_usu_nome from bbh_usuario Where  bbh_usu_ativo='1' ORDER BY bbh_usu_nome ASC";
    list($chefeUsu, $row_chefeUsu, $totalRows_chefeUsu) = executeQuery($bbhive, $database_bbhive, $query_chefeUsu);

?><form method="POST" name="editaUsuario" id="editaUsuario">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_usuariosNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-usuarios-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_usuariosNome']; ?>
      <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Edi&ccedil;&atilde;o de <?php echo $_SESSION['adm_usuariosNome']; ?></span></td>
  </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="93%" id="erroDep">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" class="color"><strong><u>Informa&ccedil;&atilde;o obrigat&oacute;ria :</u></strong></td>
        <td height="24">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" class="color">Usu&aacute;rio ativo :          </td>
        <td height="24"><span class="color">
          &nbsp;
          <select name="bbh_usu_ativo" id="bbh_usu_ativo" class="back_input">
            <option value="1" <?php if($row_usuario['bbh_usu_ativo']=="1"){ echo "selected"; } ?>>Sim</option>
            <option value="0" <?php if($row_usuario['bbh_usu_ativo']=="0"){ echo "selected"; } ?>>N&atilde;o</option>
          </select>
        </span></td>
      </tr>
      <tr>
        <td width="24%" align="right" class="color">Nome&nbsp;:</td>
        <td width="76%" height="24">&nbsp;
          <input name="bbh_usu_nome" type="text" class="back_input" id="bbh_usu_nome" value="<?php echo $row_usuario['bbh_usu_nome']; ?>" size="45" maxlength="255">
          <input name="bbh_usu_codigo" type="hidden" id="bbh_usu_codigo" value="<?php echo $row_usuario['bbh_usu_codigo']; ?>" /></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">E-Mail :</td>
        <td height="24">&nbsp;
          <input name="bbh_usu_identificacao" type="text" class="back_input" id="bbh_usu_identificacao" value="<?php echo $row_usuario['bbh_usu_identificacao']; ?>" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Apelido:</td>
        <td height="24">&nbsp; <input name="bbh_usu_apelido" type="text" class="back_input" id="bbh_usu_apelido" value="<?php echo $row_usuario['bbh_usu_apelido']; ?>" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Data de nascimento :</td>
        <td height="24">&nbsp;
          <input name="bbh_usu_data_nascimento" type="text" class="back_input" id="bbh_usu_data_nascimento" value="<?php echo arrumadata($row_usuario['bbh_usu_data_nascimento']); ?>" size="13" maxlength="10"> 
          <span class="verdana_11_cinza">(DD/MM/AAAA)</span></td>
      </tr>
      <tr>
        <?php
		$masculino = "";
		$feminino  = "";
		
		if($row_usuario['bbh_usu_sexo']==1){
			$masculino = "checked=checked";
		}else{
			$feminino  = "checked=checked";
		}
		?>
        <td align="right" valign="top" class="color">Sexo : </td>
        <td height="24">&nbsp;<label><input type="radio" name="bbh_usu_sexo" value="0" id="bbh_usu_sexo_0" <?php echo $feminino; ?> /> Feminino</label> <label><input name="bbh_usu_sexo" type="radio" id="bbh_usu_sexo_1" value="1" <?php echo $masculino; ?> /> 
        Masculino</label></td>
      </tr>
      <tr>
        <td align="right" class="color">Matr&iacute;cula :</td>
        <td height="24">&nbsp;
        <input name="bbh_usu_rg" type="text" class="back_input" id="bbh_usu_rg" value="<?php echo $row_usuario['bbh_usu_rg']; ?>" size="30" maxlength="50" /></td>
      </tr>
      <tr>
        <td align="right" class="color">CPF :</td>
        <td height="24">&nbsp;
          <input name="bbh_usu_cpf" type="text" class="back_input" id="bbh_usu_cpf" value="<?php echo $row_usuario['bbh_usu_cpf']; ?>" size="30" maxlength="50"></td>
      </tr>
      <tr>
        <td align="right" class="color">Departamento :</td>
        <td height="24">&nbsp;
            <select name="bbh_dep_codigo" id="bbh_dep_codigo" class="back_input">
              <option value="<?php echo $row_deptoUsu['bbh_dep_codigo']; ?>"><?php echo $row_deptoUsu['bbh_dep_nome']; ?></option>
          <?php do { ?>
              <option value="<?php echo $row_depto['bbh_dep_codigo']; ?>"><?php echo $row_depto['bbh_dep_nome']; ?></option>
           <?php } while ($row_depto = mysqli_fetch_assoc($depto)); ?>
            </select>        </td>
      </tr>
      <tr>
        <td align="right" class="color">Cargo :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_usu_cargo" type="text" id="bbh_usu_cargo" value="<?php echo $row_usuario['bbh_usu_cargo']; ?>" size="30" maxlength="50" /></td>
      </tr>
      <tr>
        <td align="right" class="color">Permiss&atilde;o de Solicita&ccedil;&atilde;o:</td>
        <td height="24">&nbsp;
			<select name="bbh_usu_permissao_dep" id="bbh_usu_permissao_dep" class="back_input">
            <option value="0" <?PHP if( empty($row_usuario['bbh_usu_permissao_dep'])){ echo 'selected'; } ?>>Livre</option>
          <?php while ($row_depto = mysqli_fetch_assoc($deptoPermissao)) { ?>
              <option value="<?php echo $row_depto['bbh_dep_codigo']; ?>" <?PHP if($row_usuario['bbh_usu_permissao_dep']==$row_depto['bbh_dep_codigo']){ echo 'selected'; } ?>><?php echo $row_depto['bbh_dep_nome']; ?></option>
           <?php } ?>
            </select>
		</td>
      </tr>
      <tr>
        <td align="right" class="color">Chefe :</td>
        <td height="24">&nbsp;
        <select name="bbh_usu_chefe" id="bbh_usu_chefe" class="back_input">
          <?php do { ?>
           <option value="<?php echo $row_chefeUsu['bbh_usu_codigo']; ?>" <?php if($row_usuario['bbh_usu_chefe']==$row_chefeUsu['bbh_usu_codigo']){echo 'selected="selected"'; }?>><?php echo $row_chefeUsu['bbh_usu_nome']; ?></option>
          <?php } while ($row_chefeUsu = mysqli_fetch_assoc($chefeUsu)); ?>
        </select>
        <span class="verdana_10" style="color:#999999">Se este usu&aacute;rio n&atilde;o tiver chefe, selecione ele mesmo.</span></td>
      </tr>
      <tr>
        <td align="right" class="color">&nbsp;</td>
        <td height="24">&nbsp;<input type="checkbox" name="bbh_usu_restringir_receb_solicitacao" id="bbh_usu_restringir_receb_solicitacao" <?php if($row_usuario['bbh_usu_restringir_receb_solicitacao']=='1'){echo 'checked="checked"'; }?> />
          <label for="bbh_usu_restringir_receb_solicitacao">
          Restringir recebimento de <?php echo $_SESSION['adm_protNome']; ?></label></td>
      </tr>
      <tr>
        <td align="right" class="color">&nbsp;</td>
        <td height="24">&nbsp;<input type="checkbox" name="bbh_usu_restringir_ini_processo" id="bbh_usu_restringir_ini_processo" <?php if($row_usuario['bbh_usu_restringir_ini_processo']=='1'){echo 'checked="checked"'; }?>/>
          <label for="bbh_usu_restringir_ini_processo">
          Restringir in&iacute;cio de <?php echo $_SESSION['adm_FluxoNome']; ?> a partir de uma <?php echo $_SESSION['adm_FluxoNome']; ?></label></td>
      </tr>
      <tr>
        <td height="5" colspan="2" style="border-bottom:#999999 1px dotted;"></td>
        </tr>
      <tr>
        <td align="right" class="color"><strong><u>Informa&ccedil;&atilde;o opcional :</u></strong></td>
        <td height="24">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" class="color">E-Mail alternativo :</td>
        <td height="24">&nbsp;
            <input name="bbh_usu_email_alternativo" type="text" class="back_input" id="bbh_usu_email_alternativo" value="<?php echo $row_usuario['bbh_usu_email_alternativo']; ?>" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" class="color">Tel. comercial :</td>
        <td height="24">&nbsp;
            <input name="bbh_usu_tel_comercial" type="text" class="back_input" id="bbh_usu_tel_comercial" value="<?php echo $row_usuario['bbh_usu_tel_comercial']; ?>" size="22" maxlength="20"></td>
      </tr>
      <tr>
        <td align="right" class="color">Tel. para recados :</td>
        <td height="24">&nbsp;
            <input name="bbh_usu_tel_recados" type="text" class="back_input" id="bbh_usu_tel_recados" value="<?php echo $row_usuario['bbh_usu_tel_recados']; ?>" size="22" maxlength="20"></td>
      </tr>
      <tr>
        <td align="right" class="color">Endere&ccedil;o :</td>
        <td height="24">&nbsp;
            <input name="bbh_usu_endereco" type="text" class="back_input" id="bbh_usu_endereco" value="<?php echo $row_usuario['bbh_usu_endereco']; ?>" size="60" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" class="color">Cidade :</td>
        <td height="24">&nbsp;
            <input name="bbh_usu_cidade" type="text" class="back_input" id="bbh_usu_cidade" value="<?php echo $row_usuario['bbh_usu_cidade']; ?>" size="35" maxlength="150"></td>
      </tr>
      <tr>
        <td align="right" class="color">Estado :</td>
        <td height="24">&nbsp;
        
            <select name="bbh_usu_estado" class="back_input" id="bbh_usu_estado">
                                <option value="AC" <?php if ($row_usuario['bbh_usu_estado']=="AC") {echo "selected=\"selected\"";} ?>>AC</option>
                                <option value="AL" <?php if ($row_usuario['bbh_usu_estado']=="AL") {echo "selected=\"selected\"";} ?>>AL</option>
                                <option value="AM" <?php if ($row_usuario['bbh_usu_estado']=="AM") {echo "selected=\"selected\"";} ?>>AM</option>
                                <option value="AP" <?php if ($row_usuario['bbh_usu_estado']=="AP") {echo "selected=\"selected\"";} ?>>AP</option>
                                <option value="BA" <?php if ($row_usuario['bbh_usu_estado']=="BA") {echo "selected=\"selected\"";} ?>>BA</option>
                                <option value="CE" <?php if ($row_usuario['bbh_usu_estado']=="CE") {echo "selected=\"selected\"";} ?>>CE</option>
                                <option value="DF" <?php if ($row_usuario['bbh_usu_estado']=="DF") {echo "selected=\"selected\"";} ?>>DF</option>
                                <option value="ES" <?php if ($row_usuario['bbh_usu_estado']=="ES") {echo "selected=\"selected\"";} ?>>ES</option>
                                <option value="GO" <?php if ($row_usuario['bbh_usu_estado']=="GO") {echo "selected=\"selected\"";} ?>>GO</option>
                                <option value="MA" <?php if ($row_usuario['bbh_usu_estado']=="MA") {echo "selected=\"selected\"";} ?>>MA</option>
                                <option value="MG" <?php if ($row_usuario['bbh_usu_estado']=="MG") {echo "selected=\"selected\"";} ?>>MG</option>
                                <option value="MS" <?php if ($row_usuario['bbh_usu_estado']=="MS") {echo "selected=\"selected\"";} ?>>MS</option>
                                <option value="MT" <?php if ($row_usuario['bbh_usu_estado']=="MT") {echo "selected=\"selected\"";} ?>>MT</option>
                                <option value="PA" <?php if ($row_usuario['bbh_usu_estado']=="PA") {echo "selected=\"selected\"";} ?>>PA</option>
                                <option value="PB" <?php if ($row_usuario['bbh_usu_estado']=="PB") {echo "selected=\"selected\"";} ?>>PB</option>
                                <option value="PE" <?php if ($row_usuario['bbh_usu_estado']=="PE") {echo "selected=\"selected\"";} ?>>PE</option>
                                <option value="PI" <?php if ($row_usuario['bbh_usu_estado']=="PI") {echo "selected=\"selected\"";} ?>>PI</option>
                                <option value="PR" <?php if ($row_usuario['bbh_usu_estado']=="PR") {echo "selected=\"selected\"";} ?>>PR</option>
                                <option value="RJ" <?php if ($row_usuario['bbh_usu_estado']=="RJ") {echo "selected=\"selected\"";} ?>>RJ</option>
                                <option value="RN" <?php if ($row_usuario['bbh_usu_estado']=="RN") {echo "selected=\"selected\"";} ?>>RN</option>
                                <option value="RO" <?php if ($row_usuario['bbh_usu_estado']=="RO") {echo "selected=\"selected\"";} ?>>RO</option>
                                <option value="RR" <?php if ($row_usuario['bbh_usu_estado']=="RR") {echo "selected=\"selected\"";} ?>>RR</option>
                                <option value="RS" <?php if ($row_usuario['bbh_usu_estado']=="RS") {echo "selected=\"selected\"";} ?>>RS</option>
                                <option value="SC" <?php if ($row_usuario['bbh_usu_estado']=="SC") {echo "selected=\"selected\"";} ?>>SC</option>
                                <option value="SE" <?php if ($row_usuario['bbh_usu_estado']=="SE") {echo "selected=\"selected\"";} ?>>SE</option>
                                <option value="SP" <?php if ($row_usuario['bbh_usu_estado']=="SP") {echo "selected=\"selected\"";} ?>>SP</option>
                                <option value="TO" <?php if ($row_usuario['bbh_usu_estado']=="TO") {echo "selected=\"selected\"";} ?>>TO</option>
                              </select></td>
      </tr>
      <tr>
        <td align="right" class="color">CEP :</td>
        <td height="24">&nbsp;
            <input name="bbh_usu_cep" type="text" class="back_input" id="bbh_usu_cep" value="<?php echo $row_usuario['bbh_usu_cep']; ?>" size="14" maxlength="9"></td>
      </tr>
      <tr>
        <td align="right" class="color">Pa&iacute;s :</td>
        <td height="24">&nbsp;
            <input name="bbh_usu_pais" type="text" class="back_input" id="bbh_usu_pais" value="<?php echo $row_usuario['bbh_usu_pais']; ?>" size="30" maxlength="80"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="24">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;<input style="cursor:pointer" type="button" name="button2" id="button2" value="Cancelar" class="button" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');" /> 
          <input style="cursor:pointer" type="button" name="button" id="button" value="Editar" class="button" onClick="return validaForm('editaUsuario', 'bbh_usu_nome|Preencha o nome do usu&aacute;rio,bbh_usu_identificacao|Preencha o campo de e-mail,bbh_usu_apelido|Preencha o apelido do usu&aacute;rio,bbh_usu_data_nascimento|Preencha a data de nascimento,bbh_usu_rg|Preencha o campo de RG,bbh_usu_cpf|Preencha o campo de CPF,bbh_usu_chefe|Escolha uma op&ccedil;&atilde;o v&aacute;lida para chefe', document.getElementById('acaoForm').value)" />
                    <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_update" value="editaUsuario" />
</form>
<?php
mysqli_free_result($depto);
?>