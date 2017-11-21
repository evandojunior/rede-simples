<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	if(isset($_GET['bbh_interface_codigo'])){
		$_SESSION['bbh_flu_codigo'] = $_GET['bbh_interface_codigo'];
		?>
        <form name="executaInterfaceRica" id="executaInterfaceRica" method="get" action="/corporativo/servicos/bbhive/fluxograma/interface_rica/index.php" target="_blank">
        </form>
        <var style="display:none">
        	document.executaInterfaceRica.submit();
        </var>
        <?php
		exit;
	}

	//verifica se a atividade foi lida
		$CodFluxo = $_GET['bbh_flu_codigo'];
	
	//descobre o Fluxo desta atividade
	$query_Fluxo =  "select bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_flu_observacao,
					 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome, MAX(bbh_ati_final_previsto) as final
					 	from bbh_fluxo 
					
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
						Where bbh_fluxo.bbh_flu_codigo = $CodFluxo
							group by bbh_fluxo.bbh_flu_codigo
								order by bbh_flu_codigo desc LIMIT 0,1";
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	
//quantas mensagens eu tenho
	$query_strMinhasMensagens = "select count(bbh_men_codigo) as total from bbh_mensagens Where bbh_men_data_leitura is NULL and bbh_flu_codigo=$CodFluxo";
    list($strMinhasMensagens, $row_strMinhasMensagens, $totalRows_strMinhasMensagens) = executeQuery($bbhive, $database_bbhive, $query_strMinhasMensagens);
	
//quantas tarefas eu tenho
	$query_strMinhasTarefas = "select count(bbh_ati_codigo) as total from bbh_atividade Where bbh_flu_codigo=$CodFluxo";
    list($strMinhasTarefas, $row_strMinhasTarefas, $totalRows_strMinhasTarefas) = executeQuery($bbhive, $database_bbhive, $query_strMinhasTarefas);
?>
<var style="display:none">txtSimples('tagPerfil', 'Detalhes <?php echo $_SESSION['FluxoNome']; ?>')</var>
<?php
//se tiver setado nº de protocolo exibe o cabeçalho do mesmo
 if(isset($_GET['bbh_pro_codigo'])){	
	require_once('../../protocolo/cabecaProtocolo.php');
 }
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong><?php echo $_SESSION['FluxoNome']; ?></strong></span>
      <label style="float:right;">
     <a href="#" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/busca/regra2.php?bbh_pro_codigo=<?php echo $_GET['bbh_pro_codigo']; ?>&anexar_fluxo=true','menuEsquerda|conteudoGeral')";>
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td colspan="2" class="verdana_11">&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;">
          <tr>
           <td width="28" height="21" align="center">&nbsp;</td>
            <td width="28" height="21" align="center">&nbsp;</td>
            <td width="28" align="center">&nbsp;</td>
            <td width="28" align="center">&nbsp;</td>
            <td width="28" align="center">&nbsp;</td>
            <td width="28" align="center">&nbsp;</td>
            <td width="28" align="center">&nbsp;</td>
            <td width="28" align="center">&nbsp;</td>
            
            <td width="28" align="center"></td>
          <td width="322">&nbsp;</td>
          </tr>
          <tr>
            <td height="21" colspan="10" background="/corporativo/servicos/bbhive/images/cabeca_tar.gif" id="titulo" class="verdana_11_bold color">&nbsp;Detalhes <?php echo $_SESSION['FluxoNome']; ?></td>
          </tr>
          <tr>
            <td height="210" colspan="10" valign="top" id="corpoTarefa" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
              <tr>
                <td width="26%" height="22">&nbsp;</td>
                <td width="74%">&nbsp;</td>
              </tr>
              <tr>
                <td height="22" align="right"><strong>T&iacute;tulo do <?php echo $_SESSION['FluxoNome']; ?> :</strong></td>
                <td class="legandaLabel14">&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_flu_titulo']; ?></span></td>
              </tr>
              <tr>
                <td height="22" align="right"><strong>Tipo do <?php echo $_SESSION['FluxoNome']; ?> :</strong></td>
                <td>&nbsp;<?php echo normatizaCep($row_Fluxo['bbh_tip_flu_identificacao'])."&nbsp;".$row_Fluxo['bbh_tip_flu_nome']; ?></td>
              </tr>
              <tr>
                <td height="22" align="right"><strong>Modelo <?php echo $_SESSION['FluxoNome']; ?> :</strong></td>
                <td>&nbsp;<?php echo $row_Fluxo['bbh_mod_flu_nome']; ?></td>
              </tr>
              <tr>
                <td height="22" align="right"><strong>Origem :</strong></td>
                <td>&nbsp;<?php echo $row_Fluxo['bbh_dep_nome']; ?></td>
              </tr>
              <tr>
                <td height="22" align="right"><strong>Status :</strong></td>
                <td>&nbsp;<?php echo $row_Fluxo['concluido']; ?>%</td>
              </tr>

            </table>
            
            	<br>
            	<fieldset style="margin-left:20px; margin-right:20px;">
                	<legend class="legandaLabel12">Informa&ccedil;&otilde;es complementares</legend>
                    	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr class="legandaLabel">
                              <td width="50%" height="15"><a href="#"><?php echo strtolower($_SESSION['MsgNome']); ?></a></td>
                              <td width="50%">Iniciado em</td>
                            </tr>
                            <tr class="legandaLabel">
                              <td height="15"><a href="#"><img src="/corporativo/servicos/bbhive/images/msgIII.gif" border="0" align="absmiddle">&nbsp;<?php echo $row_strMinhasMensagens['total']; ?></a></td>
                              <td height="15">&nbsp;<strong><?php echo $row_Fluxo['bbh_flu_data_iniciado']; ?></strong></td>
                            </tr>
                            <tr class="legandaLabel">
                              <td height="4" colspan="2"></td>
                            </tr>
                            <tr class="legandaLabel">
                              <td height="15"><a href="#"><?php echo strtolower($_SESSION['TarefasNome']); ?></a></td>
                              <td height="15">T&eacute;rmino previsto</td>
                            </tr>
                            <tr class="legandaLabel">
                              <td height="15"><a href="#"><img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle">&nbsp;<?php echo $row_strMinhasTarefas['total']; ?></a></td>
                              <td height="15">&nbsp;<strong><?php echo arrumadata($row_Fluxo['final']); ?></strong></td>
                            </tr>
                        </table>
                        <br>
            	</fieldset>            </td>
          </tr>
          <tr>
            <td height="6" colspan="10" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;">&nbsp;</td>
          </tr>
          <tr>
            <td height="6" colspan="10" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;" align="right"><input name="Anexar" type="button" class="back_input" id="Anexar" value="Anexar neste <?php echo $_SESSION['FluxoNome']; ?>" style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/busca/executa.php','loadFluxo','anexaProtocolo','Aguarde','loadFluxo','1','2')">
              <input name="insereModelo2" type="button" class="back_input" id="insereModelo2" value="Fluxograma" style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return OpenAjaxPostCmd('/corporativo/servicos/bbhive/consulta/regra.php?bbh_interface_codigo=<?php echo $row_Fluxo['bbh_flu_codigo']; ?>&','loadFluxo','','Aguarde','loadFluxo','2','2')"/>
            
            <input name="insereModelo" type="button" class="back_input" id="insereModelo" value="Mais detalhes" style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_Fluxo['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_Fluxo['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');"/>&nbsp;</td>
          </tr>
          <tr>
            <td height="6" colspan="10" style="border-left:#878787 solid 1px; border-right:#878787 solid 1px;">&nbsp;<label id="loadFluxo"></label></td>
          </tr>
          <tr>
            <td height="6" colspan="10" background="/corporativo/servicos/bbhive/images/rodape_tar.gif"></td>
          </tr>
</table>
<form name="anexaProtocolo" id="anexaProtocolo">
	<input type="hidden" id="bbh_pro_codigo" name="bbh_pro_codigo" value="<?php echo $_GET['bbh_pro_codigo']; ?>" />
	<input type="hidden" id="bbh_flu_codigo" name="bbh_flu_codigo" value="<?php echo $_GET['bbh_flu_codigo']; ?>" />
</form>