<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/usuarios/excluir.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'excluiUsuario';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
	$desabilita = "style='cursor:pointer'";
	
	$usuarioGet = -1;
	if(isset($_GET['bbh_usu_codigo'])){
		$usuarioGet = $_GET['bbh_usu_codigo'];
	}elseif(isset($_POST['bbh_usu_codigo'])){
		$usuarioGet = $_POST['bbh_usu_codigo'];
	}
	
	//Selects de validação
	//SELECT PARA INFORMAÇÕES DO USUÁRIO
	$query_usuario = "SELECT * FROM bbh_usuario WHERE bbh_usu_codigo = $usuarioGet";
    list($usuario, $row_usuario, $totalRows_usuario) = executeQuery($bbhive, $database_bbhive, $query_usuario);
	
	//SELECT DOS DEPARTAMENTOS
	$query_depto = "SELECT bbh_dep_codigo, bbh_dep_nome FROM bbh_departamento WHERE bbh_dep_nome != '".$row_deptoUsu['bbh_dep_nome']."' ORDER BY bbh_dep_nome ASC";
    list($depto, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_depto, $initResult = false);
    list($deptoPermissao, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_depto, $initResult = false);

	//SELECT DO DEPARTAMENTO DO USUÁRIO
	$query_deptoUsu = "SELECT bbh_usuario.bbh_usu_identificacao, bbh_departamento.bbh_dep_nome, bbh_usuario.bbh_usu_codigo, bbh_departamento.bbh_dep_codigo FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo WHERE bbh_usu_codigo = $usuarioGet";
    list($deptoUsu, $row_deptoUsu, $totalRows_deptoUsu) = executeQuery($bbhive, $database_bbhive, $query_deptoUsu);
	
	//SELECT DO CHEFE ATUAL - PARTE I
	$query_chefeUsu = "SELECT bbh_usu_chefe FROM bbh_usuario WHERE bbh_usu_codigo = $usuarioGet";
    list($chefeUsu, $row_chefeUsu, $totalRows_chefeUsu) = executeQuery($bbhive, $database_bbhive, $query_chefeUsu);
	
	//SELECT DO CHEFE ATUAL - PARTE II
	$query_chefeUsu2 = "SELECT bbh_usu_nome, bbh_usu_codigo FROM bbh_usuario WHERE bbh_usu_codigo = ".(int)$row_chefeUsu['bbh_usu_chefe'];
    list($chefeUsu2, $row_chefeUsu2, $totalRows_chefeUsu2) = executeQuery($bbhive, $database_bbhive, $query_chefeUsu2);
	
	//Começa os selects de validação.
	$negacao = "A exclus&atilde;o n&atilde;o ser&aacute; poss&iacute;vel pelo(s) seguinte(s) motivo(s):<br />";//define começo da mensagem de erro

	$query_validaChefe = "SELECT bbh_usu_chefe FROM bbh_usuario WHERE bbh_usu_chefe = $usuarioGet";
    list($validaChefe, $row_validaChefe, $totalRows_validaChefe) = executeQuery($bbhive, $database_bbhive, $query_validaChefe);

	if($totalRows_validaChefe>0){ $negacao .= "- O usu&aacute;rio &eacute; chefe de outro usu&aacute;rio.<br />"; }

	$query_validaArquivo = "SELECT bbh_usu_codigo FROM bbh_arquivo WHERE bbh_usu_codigo = $usuarioGet";
    list($validaArquivo, $row_validaArquivo, $totalRows_validaArquivo) = executeQuery($bbhive, $database_bbhive, $query_validaArquivo);
	
	if($totalRows_validaArquivo>0){ $negacao .= "- O usu&aacute;rio &eacute; dono de um arquivo de um fluxo.<br />"; }

	$query_validaAtividade = "SELECT bbh_usu_codigo FROM bbh_atividade WHERE bbh_usu_codigo = $usuarioGet";
    list($validaAtividade, $row_validaAtividade, $totalRows_validaAtividade) = executeQuery($bbhive, $database_bbhive, $query_validaAtividade);
	
	if($totalRows_validaAtividade>0){ $negacao .= "- O usu&aacute;rio est&aacute; vinculado &agrave; uma atividade.<br />"; }

	$query_validaFluxo = "SELECT bbh_usu_codigo FROM bbh_fluxo WHERE bbh_usu_codigo = $usuarioGet";
    list($validaFluxo, $row_validaFluxo, $totalRows_validaFluxo) = executeQuery($bbhive, $database_bbhive, $query_validaFluxo);
	
	if($totalRows_validaFluxo>0){ $negacao .= "- O usu&aacute;rio tem um fluxo iniciado.<br />"; }

	$query_validaMsg = "SELECT bbh_usu_codigo_remet, bbh_usu_codigo_destin FROM bbh_mensagens WHERE bbh_usu_codigo_remet = $usuarioGet OR bbh_usu_codigo_destin = $usuarioGet";
    list($validaMsg, $row_validaMsg, $totalRows_validaMsg) = executeQuery($bbhive, $database_bbhive, $query_validaMsg);
	
	if($totalRows_validaMsg>0){ $negacao .= "- O usu&aacute;rio possui mensagens no sistema que ainda n&atilde;o foram exclu&iacute;das pelo administrador.<br />"; }

	$query_validaServicos = "SELECT bbh_usu_codigo_tomador, bbh_usu_codigo_prestador FROM bbh_servicos WHERE bbh_usu_codigo_tomador = $usuarioGet OR bbh_usu_codigo_prestador = $usuarioGet";
    list($validaServicos, $row_validaServicos, $totalRows_validaServicos) = executeQuery($bbhive, $database_bbhive, $query_validaServicos);
	
	if($totalRows_validaServicos>0){ $negacao .= "- O usu&aacute;rio &eacute; prestador ou tomador de servi&ccedil;o de outros usu&aacute;rios.<br />"; }

	$query_validaNomeacao = "SELECT bbh_usu_codigo FROM bbh_usuario_nomeacao WHERE bbh_usu_codigo = $usuarioGet";
    list($validaNomeacao, $row_validaNomeacao, $totalRows_validaNomeacao) = executeQuery($bbhive, $database_bbhive, $query_validaNomeacao);

	if($totalRows_validaNomeacao>0){ $negacao .= "- O usu&aacute;rio &eacute; nomeador de perfis.<br />"; }

	$query_validaPerfil = "SELECT bbh_usu_codigo FROM bbh_usuario_perfil WHERE bbh_usu_codigo = $usuarioGet";
    list($validaPerfil, $row_validaPerfil, $totalRows_validaPerfil) = executeQuery($bbhive, $database_bbhive, $query_validaPerfil);
	
	if($totalRows_validaPerfil>0){ $negacao .= "- O usu&aacute;rio est&aacute; vinculado &agrave; perfis existentes."; }

	//Se algum valor bater, exibe erro
	if($totalRows_validaFluxo>0 || $totalRows_validaArquivo>0 || $totalRows_validaAtividade>0 || $totalRows_validaFluxo>0 || $totalRows_validaMsg>0 || $totalRows_validaServicos>0 || $totalRows_validaNomeacao>0 || $totalRows_validaPerfil>0){

	 $Erro = "<span class='aviso' style='font-size:11;'>".$negacao."</span>";
     echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";	 
	 
	 $desabilita  = "disabled='disabled'";

	//Senão permite a exclusão
	}else{
		if ((isset($_POST['bbh_usu_codigo'])) && ($_POST['bbh_usu_codigo'] != "")) {
		
		  $deleteSQL = "DELETE FROM bbh_usuario WHERE bbh_usu_codigo = ".$_POST['bbh_usu_codigo'];
		  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
		  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|usuarios/index.php','menuEsquerda|conteudoGeral')</var>";
		exit;
		}
	}
?>
<form method="post" name="excluiUsuario" id="excluiUsuario">
  <var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_usuariosNome']; ?>')</var>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
    <tr>
      <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-usuarios-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_usuariosNome']; ?>
          <div style="float:right;"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
    </tr>
    <tr>
      <td height="14" colspan="2"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Exclus&atilde;o de <?php echo $_SESSION['adm_usuariosNome']; ?></span></td>
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
                <input name="bbh_usu_nome" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_nome" value="<?php echo $row_usuario['bbh_usu_nome']; ?>" size="45" maxlength="255" />
                <input name="bbh_usu_codigo" type="hidden" disabled="disabled" id="bbh_usu_codigo" value="<?php echo $row_usuario['bbh_usu_codigo']; ?>" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="color">E-Mail :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_identificacao" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_identificacao" value="<?php echo $row_usuario['bbh_usu_identificacao']; ?>" size="45" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="color">Apelido:</td>
          <td height="24">&nbsp;
          <input name="bbh_usu_apelido" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_nome" value="<?php echo $row_usuario['bbh_usu_apelido']; ?>" size="45" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="color">Data de nascimento :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_data_nascimento" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_data_nascimento" value="<?php echo arrumadata($row_usuario['bbh_usu_data_nascimento']); ?>" size="13" maxlength="10" />
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
          <td height="24">&nbsp;
                <label>
                  <input type="radio" name="bbh_usu_sexo" value="0" disabled="disabled" id="bbh_usu_sexo_0" <?php echo $feminino; ?> />
                  Feminino</label>
                <label>
                  <input name="bbh_usu_sexo" type="radio" disabled="disabled" id="bbh_usu_sexo_1" value="1" <?php echo $masculino; ?> />
                  Masculino</label></td>
        </tr>
        <tr>
          <td align="right" class="color">Matr&iacute;cula :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_rg" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_rg" value="<?php echo $row_usuario['bbh_usu_rg']; ?>" size="30" maxlength="50" /></td>
        </tr>
        <tr>
          <td align="right" class="color">CPF :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_cpf" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_cpf" value="<?php echo $row_usuario['bbh_usu_cpf']; ?>" size="30" maxlength="50" /></td>
        </tr>
        <tr>
          <td align="right" class="color">Departamento :</td>
          <td height="24">&nbsp;
                <select name="bbh_dep_codigo" disabled="disabled" id="bbh_dep_codigo" class="back_Campos">
                  <option value="<?php echo $row_deptoUsu['bbh_dep_codigo']; ?>"><?php echo $row_deptoUsu['bbh_dep_nome']; ?></option>
                </select>
          </td>
        </tr>
      <tr>
        <td align="right" class="color">Cargo :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_usu_cargo" disabled="disabled" type="text" id="bbh_usu_cargo" value="<?php echo $row_usuario['bbh_usu_cargo']; ?>" size="30" maxlength="50" /></td>
      </tr>
      <tr>
        <td align="right" class="color">Permiss&atilde;o de Solicita&ccedil;&atilde;o:</td>
        <td height="24">&nbsp;
			<select name="bbh_usu_permissao_dep" id="bbh_usu_permissao_dep" class="back_input" disabled="disabled">
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
                <select name="bbh_usu_chefe" disabled="disabled" id="bbh_usu_chefe" class="back_Campos">
                  <option value="<?php echo $row_chefeUsu2['bbh_usu_codigo']; ?>"><?php echo $row_chefeUsu2['bbh_usu_nome']; ?></option>
                </select></td>
        </tr>
      <tr>
        <td align="right" class="color">&nbsp;</td>
        <td height="24">&nbsp;<input type="checkbox" name="bbh_usu_restringir_receb_solicitacao" id="bbh_usu_restringir_receb_solicitacao" <?php if($row_usuario['bbh_usu_restringir_receb_solicitacao']=='1'){echo 'checked="checked"'; }?> disabled="disabled"/>
          <label for="bbh_usu_restringir_receb_solicitacao">
          Restringir recebimento de <?php echo $_SESSION['adm_FluxoNome']; ?></label></td>
      </tr>
      <tr>
        <td align="right" class="color">&nbsp;</td>
        <td height="24">&nbsp;<input type="checkbox" name="bbh_usu_restringir_ini_processo" id="bbh_usu_restringir_ini_processo" <?php if($row_usuario['bbh_usu_restringir_ini_processo']=='1'){echo 'checked="checked"'; }?> disabled="disabled"/>
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
                <input name="bbh_usu_email_alternativo" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_email_alternativo" value="<?php echo $row_usuario['bbh_usu_email_alternativo']; ?>" size="45" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" class="color">Tel. comercial :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_tel_comercial" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_tel_comercial" value="<?php echo $row_usuario['bbh_usu_tel_comercial']; ?>" size="22" maxlength="20" /></td>
        </tr>
        <tr>
          <td align="right" class="color">Tel. para recados :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_tel_recados" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_tel_recados" value="<?php echo $row_usuario['bbh_usu_tel_recados']; ?>" size="22" maxlength="20" /></td>
        </tr>
        <tr>
          <td align="right" class="color">Endere&ccedil;o :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_endereco" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_endereco" value="<?php echo $row_usuario['bbh_usu_endereco']; ?>" size="60" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" class="color">Cidade :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_cidade" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_cidade" value="<?php echo $row_usuario['bbh_usu_cidade']; ?>" size="35" maxlength="150" /></td>
        </tr>
        <tr>
          <td align="right" class="color">Estado :</td>
          <td height="24">&nbsp;
                <select name="bbh_usu_estado" class="back_Campos" disabled="disabled" id="bbh_usu_estado">
                  <option value="<?php echo $row_usuario['bbh_usu_estado']; ?>" selected="selected"><?php echo $row_usuario['bbh_usu_estado']; ?></option>
              </select></td>
        </tr>
        <tr>
          <td align="right" class="color">CEP :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_cep" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_cep" value="<?php echo $row_usuario['bbh_usu_cep']; ?>" size="14" maxlength="9" /></td>
        </tr>
        <tr>
          <td align="right" class="color">Pa&iacute;s :</td>
          <td height="24">&nbsp;
                <input name="bbh_usu_pais" type="text" class="back_Campos" disabled="disabled" id="bbh_usu_pais" value="<?php echo $row_usuario['bbh_usu_pais']; ?>" size="30" maxlength="80" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="24">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="35">&nbsp;
                <input style="cursor:pointer" type="button" name="button2" id="button2" value="Cancelar" class="button" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');" />
                <input <?php echo $desabilita; ?> type="button" name="button" id="button" value="Excluir" class="button" onClick="return validaForm('excluiUsuario', 'bbh_usu_nome|Preencha o nome', document.getElementById('acaoForm').value)" />
                <input id="acaoForm" name="acaoForm" type="hidden" value="<?php echo $acao; ?>" />
                </td>
        </tr>
        <tr>
          <td colspan="2" id="menLoad">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
