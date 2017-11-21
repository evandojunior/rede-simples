<?php if(!isset($_SESSION)){ session_start(); } 
	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '1';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/servicos/bbhive/protocolos/cadastro/executa.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','buscaProt','consultaProtocolo','Consultando dados...','buscaProt','1','".$TpMens."');";
?><form id="consultaProtocolo" name="consultaProtocolo"><table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/andamento.gif" align="absmiddle" />&nbsp;<strong>Consultar <?php echo ($_SESSION['protNome']); ?></strong></td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
       
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td colspan="3" bgcolor="#F6F6F6" class="legandaLabel">&nbsp;<img src="/servicos/bbhive/images/messagebox_warning.gif" align="absmiddle" />&nbsp;Verificar <?php echo $_SESSION['protNome'];?></td>
          </tr>
          <tr>
            <td height="1" colspan="3" bgcolor="#EDEDED"></td>
          </tr>
          <tr>
            <td height="5" colspan="3" bgcolor="#F6F6F6"></td>
          </tr>
          <tr>
            <td width="31%" height="25" bgcolor="#F6F6F6" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/para.gif" align="absmiddle" />&nbsp;N&ordm; - <?php echo $_SESSION['protNome']; ?></td>
            <td width="34%" bgcolor="#F6F6F6" class="legandaLabel11"><img src="/servicos/bbhive/images/calendario.gif" align="absmiddle" />&nbsp;Data do cadastro</td>
            <td bgcolor="#F6F6F6" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/input_text.gif" align="absmiddle" />&nbsp;<?php echo $_SESSION['ProtOfiNome']; ?></td>
          </tr>
          <tr>
            <td bgcolor="#F6F6F6">&nbsp;
              <input name="ck_prot" type="checkbox" id="ck_prot" checked="checked" onclick="javascript: if(this.checked==true){ document.getElementById('bbh_pro_codigo').className='btAceso'; document.getElementById('bbh_pro_codigo').disabled=0; document.getElementById('bbh_pro_codigo').focus();} else { document.getElementById('bbh_pro_codigo').className='btApagado'; document.getElementById('bbh_pro_codigo').disabled=1; }" />
<input class="btAceso" name="bbh_pro_codigo" type="text" id="bbh_pro_codigo" size="15" onKeyDown="return SomenteNumerico(this);" onKeyPress="return SomenteNumerico(this);" onKeyUp="return SomenteNumerico(this);"/></td>
            <td bgcolor="#F6F6F6">&nbsp;
              <input name="ck_data" type="checkbox" id="ck_data" onClick="javascript: if(this.checked==true){ document.getElementById('bbh_pro_data').className='btAceso'; document.getElementById('bbh_pro_data').disabled=0; document.getElementById('bbh_pro_data').focus();} else { document.getElementById('bbh_pro_data').className='btApagado'; document.getElementById('bbh_pro_data').disabled=1; }" />
            <input class="btApagado" name="bbh_pro_data" type="text" id="bbh_pro_data" size="13" maxlength="10" onKeyPress="MascaraData(event, this)" disabled="disabled"/></td>
            <td bgcolor="#F6F6F6">&nbsp;
              <input name="ck_tit" type="checkbox" id="ck_tit" onClick="javascript: if(this.checked==true){ document.getElementById('bbh_pro_titulo').className='btAceso'; document.getElementById('bbh_pro_titulo').disabled=0; document.getElementById('bbh_pro_titulo').focus();} else { document.getElementById('bbh_pro_titulo').className='btApagado'; document.getElementById('bbh_pro_titulo').disabled=1; }" />
            <input class="btApagado" name="bbh_pro_titulo" type="text" id="bbh_pro_titulo" size="15" disabled="disabled"/></td>
          </tr>
          <tr>
            <td height="5" colspan="3" bgcolor="#F6F6F6"></td>
          </tr>
          <tr>
            <td height="30" colspan="3" bgcolor="#F6F6F6">
            	<div class="legandaLabel11 tbConsulta" style="border:#CCCCCC solid 1px; height:20px; margin-right:5px; width:98px; float:right;">
                  <a href="#@" onclick="pesquisaProtocolo();" style="width:95px;">
                	&nbsp;<img src="/servicos/bbhive/images/pesquisar.gif" align="absmiddle" border="0"/>&nbsp;Pesquisar                  </a>                </div>            </td>
          </tr>
          <tr>
            <td height="5" colspan="3" bgcolor="#F6F6F6"  class="legandaLabel11" id="buscaProt"></td>
          </tr>
        </table>
    </td>
  </tr>
</table><input name="searchProtocolo" type="hidden" id="searchProtocolo" value="true"/><input type="hidden" name="acaoBusca" id="acaoBusca" value=" <?php echo $acao; ?>" /></form>