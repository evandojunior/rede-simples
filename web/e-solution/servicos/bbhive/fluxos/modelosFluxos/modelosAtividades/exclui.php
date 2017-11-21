<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/exclui.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','cadMod','Cadastrando dados...','cadastraModelo','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraMod")) {
	  
	  //reordeno as ordens selecionado todos depois de mim
		$query_modAti = "SELECT bbh_mod_ati_codigo, bbh_mod_ati_ordem FROM bbh_modelo_atividade WHERE bbh_mod_flu_codigo = ".$_POST['bbh_mod_flu_codigo']." and bbh_mod_ati_ordem>".$_POST['bbh_mod_ati_ordem'];
        list($modAti, $row_modAti, $totalRows_modAti) = executeQuery($bbhive, $database_bbhive, $query_modAti);
			
			if($totalRows_modAti>0){
			 do{
				$codModelo 		= $row_modAti['bbh_mod_ati_codigo'];
				$ordemModelo 	= $row_modAti['bbh_mod_ati_ordem'] - 1;
				
					//update em cada modelo de atividade
					$updateSQL = "UPDATE bbh_modelo_atividade SET bbh_mod_ati_ordem=$ordemModelo WHERE bbh_mod_ati_codigo = $codModelo";
                    list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
			  }while ($row_modAti = mysqli_fetch_assoc($modAti));
			}

	$deleteSQL = "DELETE FROM bbh_modelo_atividade WHERE bbh_mod_ati_codigo = ".$_POST['bbh_mod_ati_codigo'];
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	  	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=".$_POST['bbh_mod_flu_codigo']."','menuEsquerda|conteudoGeral')</var>";
	  exit;
}

	$query_perfil = "SELECT bbh_per_nome, bbh_per_codigo FROM bbh_perfil order by bbh_per_nome asc";
    list($perfil, $row_perfil, $totalRows_perfil) = executeQuery($bbhive, $database_bbhive, $query_perfil);

	$query_modAti = "SELECT * FROM bbh_modelo_atividade WHERE bbh_mod_ati_codigo = ".$_GET['bbh_mod_ati_codigo'];
    list($modAti, $row_modAti, $totalRows_modAti) = executeQuery($bbhive, $database_bbhive, $query_modAti);
	
	//verifica se tenho alternativas
	$query_alt = "select count(bbh_flu_alt_codigo) as total from bbh_fluxo_alternativa Where bbh_mod_ati_codigo= ".$_GET['bbh_mod_ati_codigo'];
    list($alt, $row_alt, $totalRows_alt) = executeQuery($bbhive, $database_bbhive, $query_alt);
	
	//verifico se tenho atividades
	$query_Ativ = "select count(bbh_mod_ati_codigo) as total from bbh_atividade
      Where bbh_mod_ati_codigo=".$_GET['bbh_mod_ati_codigo'];
    list($Ativ, $row_Ativ, $totalRows_Ativ) = executeQuery($bbhive, $database_bbhive, $query_Ativ);
	
	//verifico se tenho depencias sucessora
	$query_Suces = "select count(bbh_pre_mod_ati_codigo) as total from bbh_dependencia
      Where bbh_modelo_atividade_sucessora=".$_GET['bbh_mod_ati_codigo'];
    list($Suces, $row_Suces, $totalRows_Suces) = executeQuery($bbhive, $database_bbhive, $query_Suces);
	
	//verifico se tenho depencias predecessora
	$query_Predes = "select count(bbh_pre_mod_ati_codigo) as total from bbh_dependencia
      Where bbh_modelo_atividade_predecessora=".$_GET['bbh_mod_ati_codigo'];
    list($Predes, $row_Predes, $totalRows_Predes) = executeQuery($bbhive, $database_bbhive, $query_Predes);
?>
<link href="/e-solution/servicos/bbhive/includes/bbhive.css" rel="stylesheet" type="text/css" />
<var style="display:none">txtSimples('tagPerfil', 'Exclus&atilde;o de modelos de atividades')</var>
<link rel="stylesheet" type="text/css" href="../../../includes/bbhive.css">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de modelos de atividades</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('cabecaModelo.php'); ?>
<br />
<form name="cadMod" id="cadMod" style="margin-top:-1px;">
    <table width="595" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="24" background="/e-solution/servicos/bbhive/images/cabAtiv.gif" class="legandaLabel11"><strong>&nbsp;Exclus&atilde;o de modelo de atividade</strong></td>
      </tr>
      <tr>
        <td height="100" valign="top" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
          <tr>
            <td height="60" colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="15" colspan="2" align="right" id="cadastraModelo" class="aviso">
                <?php
	if(($row_alt['total']>0) || ($row_Ativ['total']>0) || ($row_Suces['total']>0) || ($row_Predes['total']>0)){
		echo "Este modelo n&atilde;o pode ser excluido!";
	}
				?>
                </td>
                </tr>
              <tr>
                <td width="22%" height="25" align="right"><strong>Perfil de acesso :&nbsp;</strong></td>
                <td width="78%"><label>
                                        <select name="bbh_per_codigo" id="bbh_per_codigo" class="legandaLabel11" style="height:17px;border:#E3D6A4 solid 1px;" disabled="disabled">
                                          <?php do {  ?>
                                          <option value="<?php echo $row_perfil['bbh_per_codigo']?>" <?php echo $row_perfil['bbh_per_codigo']==$row_modAti['bbh_per_codigo'] ? "selected": "";?>><?php echo $row_perfil['bbh_per_nome']?></option>
                                          <?php 
    } while ($row_perfil = mysqli_fetch_assoc($perfil));

      if($totalRows_perfil > 0) {
          mysqli_data_seek($perfil, 0);
          $row_perfil = mysqli_fetch_assoc($perfil);
      }
    ?>
                                        </select>
                                        <input name="bbh_mod_flu_codigo" type="hidden" id="bbh_mod_flu_codigo" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>"><input name="bbh_mod_ati_ordem" type="hidden" id="bbh_mod_ati_ordem" value="<?php echo $row_modAti['bbh_mod_ati_ordem']; ?>">
                                      </label></td>
              </tr>
              <tr>
                <td height="25" align="right"><strong>T&iacute;tulo do modelo :&nbsp;</strong></td>
                <td><input class="back_Campos" name="bbh_mod_ati_nome" type="text" id="bbh_mod_ati_nome" size="60" style="height:17px;border:#E3D6A4 solid 1px;" value="<?php echo $row_modAti['bbh_mod_ati_nome']; ?>"  disabled="disabled"/></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td width="286" height="24" valign="top"><table width="280" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
              <tr>
                <td height="20" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;Fluxograma</td>
              </tr>
              <tr>
                <td height="80" valign="top" bgcolor="#FBFAF4"><table width="277" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="3"></td>
                    <td height="2"></td>
                    <td height="2"></td>
                    <td height="2"></td>
                    <td height="2"></td>
                    <td height="2"></td>
                  </tr>
                  
      <tr>
      <?php
        //lista as opções de imagens para gif
        if ($handle = opendir('../../../../../../datafiles/servicos/bbhive/corporativo/images/tarefas/.')) {
             $cont  = 0;
             $dif	= 0;
             while (false !== ($file = readdir($handle))) {
             
                 if ($file != "." && $file != "..") {
                    if(strtolower($file)!="thumbs.db"){	
                       if($cont==6){
                         echo "</tr><tr><td colspan='6' height='7'></td></tr>
						 <tr>";
                        $cont=0;
                       }
                            $nmArquivo 	= strtolower($file);
                            $icone		= '<img src="/datafiles/servicos/bbhive/corporativo/images/tarefas/'.$nmArquivo.'" border="0" align="absmiddle" />';
                            $check="";

								if($row_modAti['bbh_mod_ati_icone']==$nmArquivo){
                                    $check= "checked";
								}
                            echo '<td><input name="bbh_mod_ati_icone" id="icone_'.$dif.'" type="radio" value="'.$nmArquivo.'" '.$check.'  disabled="disabled">'.$icone."</td>";
                            $cont++; 
                            $dif = $dif + 1;
                            //se chegar a 100 ele para
                        if ($cont == 100) { die;}	
                     }
                  }
            }
            closedir($handle);
        }
    ?></tr>
                </table></td>
              </tr>
            </table></td>
            <td width="304" valign="top" style="border-left:#CCCCCC solid 1px;"><table width="294" border="0" align="center" cellpadding="0" cellspacing="0"class="legandaLabel11">
              <tr>
                <td height="20" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;Tempo para inicio da atividade</td>
              </tr>
              <tr>
                <td height="28" valign="middle">
                                            &nbsp;
                                            <select name="bbh_mod_ati_inicio" class="legandaLabel11"  disabled="disabled">
                                                <option value="-1">Selecione um n&uacute;mero</option>
                                            <?php for($a=1; $a<101; $a++ ){ ?>	
                                                <option value="<?php echo $a; ?>" <?php if($row_modAti['bbh_mod_ati_inicio']==$a){ echo 'selected="selected"'; } ?>><?php echo $a; ?></option>
                                            <?php } ?>    
                                            </select>                </td>
              </tr>
              <tr>
                <td height="20" valign="top" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;Tempo de dura&ccedil;&atilde;o da atividade</td>
              </tr>
              <tr>
                <td height="28" valign="middle">
                                            &nbsp;
                                            <select name="bbh_mod_ati_duracao" class="legandaLabel11"  disabled="disabled">
                                                <option value="-1">Selecione um n&uacute;mero</option>
                                            <?php for($a=1; $a<101; $a++ ){ ?>	
                                                <option value="<?php echo $a; ?>" <?php if($row_modAti['bbh_mod_ati_duracao']==$a){ echo 'selected="selected"'; } ?>><?php echo $a; ?></option>
                                            <?php } ?>    
                                            </select>                </td>
              </tr>
              <tr>
                <td height="20" valign="middle" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;
                  <label>
                  <input type="checkbox" name="bbh_mod_atiInicio" id="bbh_mod_atiInicio" <?php if($row_modAti['bbh_mod_atiInicio']=='1'){ echo 'checked="checked"'; }  ?> disabled="disabled"/>
                  </label>
                  Atividade inicial</td>
              </tr>
              <tr>
                <td height="10" valign="middle"></td>
              </tr>
              <tr>
                <td height="20" valign="middle" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;<label>
                  <input type="checkbox" name="bbh_mod_atiFim" id="bbh_mod_atiFim" <?php if($row_modAti['bbh_mod_atiFim']=='1'){ echo 'checked="checked"'; }  ?> disabled="disabled"/>
                </label>
                  Atividade Final</td>
              </tr>
              <tr>
                <td height="10" valign="middle"></td>
              </tr>
              <tr>
                <td height="20" valign="middle" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;<label>
                  <input type="checkbox" name="bbh_mod_ati_relatorio" id="bbh_mod_ati_relatorio" <?php if($row_modAti['bbh_mod_ati_relatorio']=='1'){ echo 'checked="checked"'; }  ?> disabled="disabled"/>
                </label>
                  Relat&oacute;rio obrigat&oacute;rio</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="1" colspan="2" bgcolor="#E3D6A4"></td>
          </tr>
          <tr>
            <td height="24" colspan="2" class="legandaLabel11">&nbsp;<strong>Procedimento operacional padr&atilde;o</strong></td>
          </tr>
          <tr>
            <td height="24" colspan="2" align="center"><textarea class="back_Campos" name="bbh_mod_ati_observacao" id="bbh_mod_ati_observacao" cols="110" rows="7" style="border:#E3D6A4 solid 1px;"  disabled="disabled"><?php echo $row_modAti['bbh_mod_ati_observacao']; ?></textarea></td>
          </tr>
          <tr>
            <td height="5" colspan="2"></td>
          </tr>
          <tr>
            <td height="24" colspan="2" class="legandaLabel11"><input type="checkbox" name="bbh_mod_ati_mecanismo" id="bbh_mod_ati_mecanismo" style="margin-left:8px;" <?php if($row_modAti['bbh_mod_ati_mecanismo']=='1'){ echo 'checked="checked"'; }  ?>  disabled="disabled"/>
    Sele&ccedil;&atilde;o de profissionais automatica.
    	
        	<div style="float:right; margin-top:-15px;">
                <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
                                               <input name="insereModelo" type="button" class="back_input" id="insereModelo" value="Excluir modelo" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return validaForm('cadMod', 'bbh_mod_flu_codigo|Tratamento' ,  document.getElementById('acaoForm').value)" <?php if(($row_alt['total']>0) || ($row_Ativ['total']>0) || ($row_Suces['total']>0) || ($row_Predes['total']>0)){ echo 'disabled="disabled"'; }?>/>&nbsp;&nbsp;&nbsp;            </div>    </td>
          </tr>
          <tr>
            <td height="5" colspan="2"></td>
          </tr>
        </table></td>
      </tr>
    </table>
      <input type="hidden" name="MM_insert" value="cadastraMod" />
      <input type="hidden" name="bbh_mod_ati_codigo" id="bbh_mod_ati_codigo" value="<?php echo $_GET['bbh_mod_ati_codigo']; ?>" />
     <input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
</form>