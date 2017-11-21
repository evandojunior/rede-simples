<?php
if(!isset($_SESSION)){ session_start(); }
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/functions.php");
	
	$bbh_flu_codigo = $_GET['bbh_flu_codigo'];

	$query_Fluxos = "select bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, bbh_fluxo.bbh_usu_codigo, 
			DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_flu_observacao,
					 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido,
					 bbh_usu_apelido, bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao
					 
					 	from bbh_fluxo 
					
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					
						Where bbh_fluxo.bbh_flu_codigo = $bbh_flu_codigo
							group by bbh_fluxo.bbh_flu_codigo
								order by bbh_flu_codigo desc LIMIT 0,1";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
	
	//quantas atividades tenho status maior que ciente?!
	$sql = "select 
			  sum(if(bbh_sta_ati_codigo = 1 OR bbh_sta_ati_codigo = 3, 0, 1)) as total from bbh_atividade
				where bbh_flu_codigo = $bbh_flu_codigo";
    list($Ati, $row_Ati, $totalRows_Ati) = executeQuery($bbhive, $database_bbhive, $sql);
	$totAtividade = $row_Ati['total'];
	
	$bbh_flu_codigo = $row_Fluxos['bbh_flu_codigo'];
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Visualizou os detalhes do fluxo (".$row_Fluxos['bbh_flu_titulo'].") - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
	
?><div id="fluxos" class="show">
<var style="display:none">document.getElementById('statusFluxo').innerHTML='<?php echo $row_Fluxos['concluido']; ?>%'</var>

<form name="formFluxo" id="formFluxo">
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
      <tr>
        <td width="570" height="25" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong><?php echo $row_Fluxos['bbh_flu_titulo']; ?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="2">&nbsp;&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/casos.gif" width="24" height="24" align="absmiddle" />&nbsp;<strong><?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao'])."&nbsp;".$row_Fluxos['bbh_mod_flu_nome']; ?></strong></strong>&nbsp;</td>
      </tr>

      <tr>
        <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
      <tr>
        <td height="22" colspan="2">&nbsp;&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/marcador.gif" width="4" height="6" />&nbsp;<strong>T&iacute;tulo:</strong>
        <?php if($row_Fluxos['bbh_usu_codigo']==$_SESSION['usuCod'] && $totAtividade==0) { ?>
        <input name="bbh_flu_titulo" type="text" class="back_Campos" id="bbh_flu_titulo" value="<?php echo $row_Fluxos['bbh_flu_titulo']; ?>" size="55" />
        <input name="bbh_flu_titulo_anterior" type="hidden" class="back_Campos" id="bbh_flu_titulo_anterior" value="<?php echo $row_Fluxos['bbh_flu_titulo']; ?>" />
        <?php } else { ?>
        <input name="bbh_flu_titulo" id="bbh_flu_titulo" type="hidden" value="<?php echo ($row_Fluxos['bbh_flu_titulo']); ?>" />
            <?php echo $row_Fluxos['bbh_flu_titulo']; ?>
        <?php } ?>
        </td>
      </tr>
      <tr>
        <td height="22" colspan="2"><label style="float:right;margin-right:15px;" class="color">Iniciado em <?php echo $row_Fluxos['bbh_flu_data_iniciado']; ?></label></td>
      </tr>

      <tr>
        <td height="22" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;<strong>Autor do <?php echo $_SESSION['FluxoNome']; ?> :</strong>&nbsp;<?php echo $row_Fluxos['bbh_usu_apelido']; ?></td>
      </tr>
      <tr>
        <td height="5" colspan="2" bgcolor="#FFFFFF"></td>
      </tr>

      <tr>
        <td height="22" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle" />&nbsp;<strong>Descri&ccedil;&atilde;o do <?php echo $_SESSION['FluxoNome']; ?> </strong></td>
      </tr>
      <tr>
        <td height="5" colspan="2"></td>
      </tr>
      <tr>
        <td height="22" colspan="2">
        <?php if($row_Fluxos['bbh_usu_codigo']==$_SESSION['usuCod'] && $totAtividade==0) { ?>
        &nbsp;<textarea name="bbh_flu_observacao" id="bbh_flu_observacao" cols="80" rows="5" class="formulario2"><?php echo ($row_Fluxos['bbh_flu_observacao']); ?></textarea>
                <input name="bbh_flu_observacao_anterior" id="bbh_flu_observacao_anterior" type="hidden" value="<?php echo ($row_Fluxos['bbh_flu_observacao']); ?>" />
        <?php } else { ?>
          <input name="bbh_flu_observacao" id="bbh_flu_observacao" type="hidden" value="<?php echo ($row_Fluxos['bbh_flu_observacao']); ?>" />
            <?php echo nl2br($row_Fluxos['bbh_flu_observacao']); ?>
        <?php } ?>
        </td>
      </tr>
      <tr>
        <td height="22" colspan="2">
     <?php
        $codigo_modelo_fluxo = $row_Fluxos['bbh_mod_flu_codigo'];
        $nome_tabela = "bbh_modelo_fluxo_". $codigo_modelo_fluxo ."_detalhado";

    //Dados do detalhamento
    $query_detalhamento = "SELECT bbh_detalhamento_fluxo.*, bbh_flu_codigo FROM bbh_detalhamento_fluxo
       inner join bbh_modelo_fluxo on bbh_detalhamento_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
       inner join bbh_fluxo on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_fluxo.bbh_mod_flu_codigo
         Where bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo AND bbh_flu_codigo = $bbh_flu_codigo";
    list($detalhamento, $row_detalhamento, $totalRows_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_detalhamento);

    if($row_detalhamento['bbh_det_flu_tabela_criada'] == 1 ){

            //RecordSet dos campos
            $query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo  INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo  WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo AND bbh_cam_det_flu_disponivel='1'";
            list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);

            //Tabela física
            $query_tabela_fisica = "SELECT * FROM $nome_tabela Where bbh_flu_codigo = $bbh_flu_codigo";
            list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
    ?>

          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr style="display:inline-block">
                <td width="372" align="left" valign="middle" class="verdana_11_bold" style="padding-top:10px;">
                <td width="578" align="right">&nbsp;</td>
              </tr>
              <tr style="display:inline-block">
              <td colspan="2" align="left" valign="middle" bgcolor="#FAFAFA" class="verdana_11_bold"><img src="/corporativo/servicos/bbhive/images/detalhe_tar.gif" width="16" height="16" align="absmiddle" /> Campos adicionais          </tr>
              <tr style="display:inline-block">
                <td colspan="2" align="left" valign="middle" class="verdana_11_bold" style="padding-top:10px;">        </tr>

    <?php
            $contador = 0;
            $campos   = "";
            //RecordSet dos campos da tabela dinâmica
            do{
                //Atributos de uma tabela dinâmica
                $tipoDeCampo 	= $row_campos_detalhamento['bbh_cam_det_flu_tipo'];
                $nomeFisico 	= $row_campos_detalhamento['bbh_cam_det_flu_nome'];
                $titulo 		= $row_campos_detalhamento['bbh_cam_det_flu_titulo'];
                $valorPadrao 	= $row_tabela_fisica[$nomeFisico];
                $editListagem 	= $row_campos_detalhamento['bbh_cam_det_flu_default'];
                $tamanho 		= $row_campos_detalhamento['bbh_cam_det_flu_tamanho'];

                if (in_array($tipoDeCampo, ['hidden','json'])) {
                    include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/listaDinamica.php");
                    continue;
                }

                if($valorPadrao == "")
                {
                    $campo_exibido = $editListagem;
                }else{
                    $campo_exibido = $valorPadrao;
                }

                if($contador % 2 == 0)
                {
                    $cor = "#FFFFFF";
                }else{
                    $cor = "#F5F5F5";
                }
                $style = 'style="display:inline-block"';
                if($contador>=6){
                    $style = 'style="display:none"';
                    $campos.= ",det_".$contador;
                }
                ?>
              <tr bgcolor="<?php echo $cor; ?>" <?php echo $style; ?> id="det_<?php echo $contador; ?>">
                <td align="left" width="372" valign="middle" class="verdana_11_bold" style="padding-top:10px;"><?php echo $titulo; ?> :&nbsp;
                <td width="578" align="left">
       <?php
            //Inclusão que isola o algoritmo que exibe cada tipo de campo
            include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/listaDinamica.php");
       ?>            </td>
              </tr>


    <?php	$contador++;
            }while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)); ?>
              <tr style="display:inline-block">
              <td width="372"></td>
                <td align="right" width="578" valign="middle" class="verdana_11_bold" style="padding-top:10px;">
                <?php if($contador>6) { ?>
                 <div style="display:inline-block; cursor:pointer; color:#F60;" id="Exibe" onclick="gerenciaCamposDetalhamento('Exibe,Esconde,<?php echo substr($campos,1);?>')">
                    Exibir campos ocultos &nbsp;<img src="/e-solution/servicos/bbhive/images/debito.gif" border="0" align="absmiddle" />
                 </div>
                 <div style="display:none; cursor:pointer; color:#F60;" id="Esconde" onclick="gerenciaCamposDetalhamento('Exibe,Esconde,<?php echo substr($campos,1);?>')">
                    Ocultar campos&nbsp;<img src="/e-solution/servicos/bbhive/images/credito.gif" border="0" align="absmiddle" />
                 </div>
                <?php } ?>
                &nbsp;</td>
              </tr>
    </table>
        <?php } ?>
        </td>
      </tr>
    </table>
    </div>
</form>