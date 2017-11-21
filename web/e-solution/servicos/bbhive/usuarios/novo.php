<?php require_once('../../../../Connections/bbhive.php'); ?>
<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/usuarios/novo.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'cadastraUsuario';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	//SELECT DOS DEPARTAMENTOS
	$query_depto = "SELECT bbh_dep_codigo, bbh_dep_nome FROM bbh_departamento ORDER BY bbh_dep_nome ASC";
    list($depto, $row_depto, $totalRows_depto) = executeQuery($bbhive, $database_bbhive, $query_depto);
    list($deptoPermissao, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_depto);
	
	if($totalRows_depto==0){
		echo "<span class='verdana_11 aviso'>Cadastre departamentos antes de usu&aacute;rios. <a href='../departamentos/novo.php'>Clique aqui</a> para cadastrar departamentos.</span>";
		exit;	
	}
	
	//SELECT DOS POSSÍVEIS CHEFES
	$query_chefe = "SELECT bbh_usu_nome, bbh_usu_codigo FROM bbh_usuario ORDER BY bbh_usu_nome ASC";
    list($chefe, $row_chefe, $totalRows_chefe) = executeQuery($bbhive, $database_bbhive, $query_chefe);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraUsuario")) {

	$novoemail = $_POST['bbh_usu_identificacao'];
	$novocpf   = $_POST['bbh_usu_cpf'];
	
	//SELECT DA VALIDAÇÃO DE E-MAILS IGUAIS
	$query_validacao = "SELECT * FROM bbh_usuario WHERE bbh_usu_identificacao = '$novoemail' OR bbh_usu_cpf = '$novocpf'";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){

	 $bbh_usu_chefe = "";
	 
		if($_POST['bbh_usu_chefe']!="-2"){
			 $bbh_usu_chefe = $_POST['bbh_usu_chefe'];
		}
		
		function cadastraUsuario($database_bbhive, $bbhive, $bbh_usu_nome, $bbh_usu_identificacao, $bbh_usu_data_nascimento, $bbh_usu_sexo, $bbh_usu_rg, $bbh_usu_cpf, $bbh_dep_codigo, $bbh_usu_email_alternativo, $bbh_usu_tel_comercial, $bbh_usu_tel_recados, $bbh_usu_endereco, $bbh_usu_cidade, $bbh_usu_estado, $bbh_usu_cep, $bbh_usu_pais, $bbh_usu_apelido, $bbh_usu_chefe, $bbh_usu_cargo, $bbh_usu_permissao_dep, $bbh_usu_restringir_receb_solicitacao, $bbh_usu_restringir_ini_processo){
		
		$campo = $bbh_usu_chefe!=""?",bbh_usu_chefe":"";
		$valor = $bbh_usu_chefe!=""?",$bbh_usu_chefe":"";
			
			//CADASTRA O USUÁRIO
		  $insertSQL = "INSERT INTO bbh_usuario (bbh_usu_nome, bbh_usu_identificacao, bbh_usu_data_nascimento, bbh_usu_sexo, bbh_usu_rg, bbh_usu_cpf, bbh_dep_codigo, bbh_usu_email_alternativo, bbh_usu_tel_comercial, bbh_usu_tel_recados, bbh_usu_endereco, bbh_usu_cidade, bbh_usu_estado, bbh_usu_cep, bbh_usu_pais, bbh_usu_apelido, bbh_usu_permissao_dep, bbh_usu_cargo, bbh_usu_restringir_receb_solicitacao, bbh_usu_restringir_ini_processo $campo) VALUES ('$bbh_usu_nome','$bbh_usu_identificacao','$bbh_usu_data_nascimento','$bbh_usu_sexo','$bbh_usu_rg','$bbh_usu_cpf',$bbh_dep_codigo,'$bbh_usu_email_alternativo','$bbh_usu_tel_comercial','$bbh_usu_tel_recados','$bbh_usu_endereco','$bbh_usu_cidade','$bbh_usu_estado','$bbh_usu_cep','$bbh_usu_pais', '$bbh_usu_apelido', '$bbh_usu_permissao_dep', '$bbh_usu_cargo','$bbh_usu_restringir_receb_solicitacao','$bbh_usu_restringir_ini_processo' $valor)";
		  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
		
			//RECUPERA O CÓDIGO INSERIDO
			$query_usuario = "SELECT bbh_usu_codigo FROM bbh_usuario Where bbh_usu_codigo = LAST_INSERT_ID()";
            list($usuario, $row_usuario, $totalRows_usuario) = executeQuery($bbhive, $database_bbhive, $query_usuario);
			
			return $row_usuario['bbh_usu_codigo'];
		}
		
		//VERIFICA SE IRÁ COLOCAR ESTE ID COMO CHEFE
		function cadastraChefe($database_bbhive, $bbhive, $bbh_usu_codigo, $bbh_usu_chefe){
			$updateSQL = "UPDATE bbh_usuario SET bbh_usu_chefe = $bbh_usu_chefe WHERE bbh_usu_codigo = $bbh_usu_codigo";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		}

		//RECUPERA VARIÉVEIS POST
		$bbh_usu_nome				= ($_POST['bbh_usu_nome']);
		$bbh_usu_identificacao		= ($_POST['bbh_usu_identificacao']);
		$bbh_usu_data_nascimento	= dataSQL($_POST['bbh_usu_data_nascimento']);
		$bbh_usu_sexo				= $_POST['bbh_usu_sexo'];
		$bbh_usu_rg					= $_POST['bbh_usu_rg'];
		$bbh_usu_cpf				= $_POST['bbh_usu_cpf'];
		$bbh_dep_codigo				= $_POST['bbh_dep_codigo'];
		$bbh_usu_permissao_dep		= $_POST['bbh_usu_permissao_dep'];
		$bbh_usu_email_alternativo	= ($_POST['bbh_usu_email_alternativo']);
		$bbh_usu_tel_comercial		= ($_POST['bbh_usu_tel_comercial']);
		$bbh_usu_tel_recados		= ($_POST['bbh_usu_tel_recados']);
		$bbh_usu_endereco			= ($_POST['bbh_usu_endereco']);
		$bbh_usu_cidade				= ($_POST['bbh_usu_cidade']);
		$bbh_usu_estado				= $_POST['bbh_usu_estado'];
		$bbh_usu_cep				= $_POST['bbh_usu_cep'];
		$bbh_usu_pais				= ($_POST['bbh_usu_pais']);
		$bbh_usu_chefe				= $bbh_usu_chefe;
		$bbh_usu_apelido			= ($_POST['bbh_usu_apelido']);
		$bbh_usu_cargo				= ($_POST['bbh_usu_cargo']);
		$bbh_usu_restringir_receb_solicitacao = isset($_POST['bbh_usu_restringir_receb_solicitacao'])?1:0;
		$bbh_usu_restringir_ini_processo 		= isset($_POST['bbh_usu_restringir_ini_processo'])?1:0;
		
		$bbh_usu_codigo	= cadastraUsuario($database_bbhive, $bbhive, $bbh_usu_nome, $bbh_usu_identificacao, $bbh_usu_data_nascimento, $bbh_usu_sexo, $bbh_usu_rg, $bbh_usu_cpf, $bbh_dep_codigo, $bbh_usu_email_alternativo, $bbh_usu_tel_comercial, $bbh_usu_tel_recados, $bbh_usu_endereco, $bbh_usu_cidade, $bbh_usu_estado, $bbh_usu_cep, $bbh_usu_pais, $bbh_usu_apelido, $bbh_usu_chefe, $bbh_usu_cargo, $bbh_usu_permissao_dep, $bbh_usu_restringir_receb_solicitacao, $bbh_usu_restringir_ini_processo);
		
		//cadastra chefe, caso o mesmo não tenha sido selecionado
		if($bbh_usu_chefe==""){
			cadastraChefe($database_bbhive, $bbhive, $bbh_usu_codigo, $bbh_usu_codigo);
		}

	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|usuarios/index.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	} else {
		 $Erro ="<span class='aviso' style='font-size:11;'>J&aacute; existe um usu&aacute;rio com o e-mail ou CPF inseridos.</span>";
  		 echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
}

?><form method="POST" name="cadastraUsuario" id="cadastraUsuario">
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

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Cria&ccedil;&atilde;o de <?php echo $_SESSION['adm_usuariosNome']; ?></span></td>
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
        <td width="24%" align="right" class="color">Nome&nbsp;:</td>
        <td width="76%" height="24">&nbsp;
          <input class="back_input" name="bbh_usu_nome" type="text" id="bbh_usu_nome" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">E-Mail :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_usu_identificacao" type="text" id="bbh_usu_identificacao" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Apelido:</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_usu_apelido" type="text" id="bbh_usu_apelido" size="45" maxlength="255" /></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Data de nascimento :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_usu_data_nascimento" type="text" id="bbh_usu_data_nascimento" size="13" maxlength="10"> 
          <span class="verdana_11_cinza">(DD/MM/AAAA)</span></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Sexo : </td>
        <td height="24">&nbsp;<label><input type="radio" name="bbh_usu_sexo" value="0" id="bbh_usu_sexo_0" /> Feminino</label> <label><input name="bbh_usu_sexo" type="radio" id="bbh_usu_sexo_1" value="1" checked/> 
        Masculino</label></td>
      </tr>
      <tr>
        <td align="right" class="color">Matr&iacute;cula :</td>
        <td height="24">&nbsp;
        <input class="back_input" name="bbh_usu_rg" type="text" id="bbh_usu_rg" size="30" maxlength="50"></td>
      </tr>
      <tr>
        <td align="right" class="color">CPF :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_usu_cpf" type="text" id="bbh_usu_cpf" size="30" maxlength="50"></td>
      </tr>
      <tr>
        <td align="right" class="color">Departamento :</td>
        <td height="24">&nbsp;
			<select name="bbh_dep_codigo" id="bbh_dep_codigo" class="back_input">
          <?php do { ?>
              <option value="<?php echo $row_depto['bbh_dep_codigo']; ?>"><?php echo $row_depto['bbh_dep_nome']; ?></option>
           <?php } while ($row_depto = mysqli_fetch_assoc($depto)); ?>
            </select>
         </td>
      </tr>
      <tr>
        <td align="right" class="color">Cargo :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_usu_cargo" type="text" id="bbh_usu_cargo" size="30" maxlength="50" /></td>
      </tr>
      <tr>
        <td align="right" class="color">Permiss&atilde;o de Solicita&ccedil;&atilde;o:</td>
        <td height="24">&nbsp;
			<select name="bbh_usu_permissao_dep" id="bbh_usu_permissao_dep" class="back_input">
            <option value="0">Livre</option>
          <?php while ($row_depto = mysqli_fetch_assoc($deptoPermissao)) { ?>
              <option value="<?php echo $row_depto['bbh_dep_codigo']; ?>"><?php echo $row_depto['bbh_dep_nome']; ?></option>
           <?php } ?>
            </select>
         </td>
      </tr>
      <tr>
        <td align="right" class="color">Chefe :</td>
        <td height="24">&nbsp;
        <select name="bbh_usu_chefe" id="bbh_usu_chefe" class="back_input">
          <option value="-1">Selecione seu chefe abaixo</option>
          <option value="-1">-------------------------------</option>
          <?php if($totalRows_chefe==0){ ?>
          <option value="-2">N&atilde;o h&aacute; chefe cadastrado. Selecione esta op&ccedil;&atilde;o.</option>
          <?php } ?>
          <?php do { ?>
          <option value="<?php echo $row_chefe['bbh_usu_codigo']; ?>"><?php echo $row_chefe['bbh_usu_nome']; ?></option>
          <?php } while ($row_chefe = mysqli_fetch_assoc($chefe)); ?>
        </select></td>
      </tr>
      <tr>
        <td align="right" class="color">&nbsp;</td>
        <td height="24">&nbsp;<input type="checkbox" name="bbh_usu_restringir_receb_solicitacao" id="bbh_usu_restringir_receb_solicitacao" />
          <label for="bbh_usu_restringir_receb_solicitacao">
          Restringir recebimento de <?php echo $_SESSION['adm_protNome']; ?></label></td>
      </tr>
      <tr>
        <td align="right" class="color">&nbsp;</td>
        <td height="24">&nbsp;<input type="checkbox" name="bbh_usu_restringir_ini_processo" id="bbh_usu_restringir_ini_processo" />
          <label for="bbh_usu_restringir_ini_processo">
          Restringir in&iacute;cio de <?php echo $_SESSION['adm_FluxoNome']; ?> a partir de uma <?php echo $_SESSION['adm_protNome']; ?></label></td>
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
            <input class="back_input" name="bbh_usu_email_alternativo" type="text" id="bbh_usu_email_alternativo" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" class="color">Tel. comercial :</td>
        <td height="24">&nbsp;
            <input class="back_input" name="bbh_usu_tel_comercial" type="text" id="bbh_usu_tel_comercial" size="22" maxlength="20"></td>
      </tr>
      <tr>
        <td align="right" class="color">Tel. para recados :</td>
        <td height="24">&nbsp;
            <input class="back_input" name="bbh_usu_tel_recados" type="text" id="bbh_usu_tel_recados" size="22" maxlength="20"></td>
      </tr>
      <tr>
        <td align="right" class="color">Endere&ccedil;o :</td>
        <td height="24">&nbsp;
            <input class="back_input" name="bbh_usu_endereco" type="text" id="bbh_usu_endereco" size="60" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" class="color">Cidade :</td>
        <td height="24">&nbsp;
            <input class="back_input" name="bbh_usu_cidade" type="text" id="bbh_usu_cidade" size="35" maxlength="150"></td>
      </tr>
      <tr>
        <td align="right" class="color">Estado :</td>
        <td height="24">&nbsp;
            <select name="bbh_usu_estado" class="back_input" id="bbh_usu_estado">
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AM">AM</option>
                                <option value="AP">AP</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MG">MG</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="PR">PR</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="RS">RS</option>
                                <option value="SC">SC</option>
                                <option value="SE">SE</option>
                                <option value="SP" selected="selected">SP</option>
                                <option value="TO">TO</option>
                              </select></td>
      </tr>
      <tr>
        <td align="right" class="color">CEP :</td>
        <td height="24">&nbsp;
            <input class="back_input" name="bbh_usu_cep" type="text" id="bbh_usu_cep" size="14" maxlength="9"></td>
      </tr>
      <tr>
        <td align="right" class="color">Pa&iacute;s :</td>
        <td height="24">&nbsp;
            <input class="back_input" name="bbh_usu_pais" type="text" id="bbh_usu_pais" size="30" maxlength="80"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="24">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;<input style="cursor:pointer" type="button" name="button2" id="button2" value="Cancelar" class="button" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');" /> 
          <input style="cursor:pointer" type="button" name="button" id="button" value="Cadastrar" class="button" onClick="return validaForm('cadastraUsuario', 'bbh_usu_nome|Preencha o nome do usu&aacute;rio,bbh_usu_identificacao|Preencha o campo de e-mail,bbh_usu_apelido|Preencha o apelido do usu&aacute;rio,bbh_usu_data_nascimento|Preencha a data de nascimento,bbh_usu_rg|Preencha o campo de RG,bbh_usu_cpf|Preencha o campo de CPF,bbh_usu_chefe|Escolha uma op&ccedil;&atilde;o v&aacute;lida para chefe', document.getElementById('acaoForm').value)" />
                    <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="cadastraUsuario" />
</form>
<?php
mysqli_free_result($depto);
?>
