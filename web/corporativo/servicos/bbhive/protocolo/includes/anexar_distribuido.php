<?php
	require_once("resumo.php");
	$anexaProtocolo = true;
	
	foreach($_GET as $indice => $valor){
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
	}
?>
<div align="center">
<img src="/corporativo/servicos/bbhive/images/seta_verde.gif" width="48" height="48">
<img src="/corporativo/servicos/bbhive/images/seta_laranja.gif" width="48" height="48">
</div>
<?php
	include("includes/cabecaFluxo.php");
	require_once("includes/resumo.php");
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/protocolo/regra.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'loadForm';
	$infoGet_Post	= 'formProtocolo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
?><form name="formProtocolo" id="formProtocolo">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
                <tr>
                  <td height="1" bgcolor="#EDEDED"></td>
                </tr>
                <tr>
                  <td align="center" style="color:#F30">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" style="color:#F30"><strong>Aten&ccedil;&atilde;o, certifique-se que o n&uacute;mero do <?php echo $_SESSION['FluxoNome']; ?> esteja correto, </strong></td>
                </tr>
                <tr>
                  <td height="25" class="legandaLabel11" align="center" style="color:#F30"><strong>pois se houver algum erro, o administrador do sistema dever&aacute; ser contatado.</strong></td>
                </tr>
                <tr>
                  <td height="20" align="center">&nbsp;
                    <input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/relacao.gif);background-repeat:no-repeat;background-position:left;height:23px;width:250px;margin-right:5px; cursor:pointer;background-color:#FFFFFF; font-weight:bold" type="button" class="back_input" id="cadastrar2" value="&nbsp;Relacionar protocolo ao <?php echo $_SESSION['FluxoNome']; ?>" onclick="javascript: if(retiraEspacos(document.getElementById('bbh_flu_codigo').value)==''){ alert('O campo número não pode ser vazio!'); document.getElementById('bbh_flu_codigo').value=''; document.getElementById('bbh_flu_codigo').focus(); } else { if(confirm('Você esta certo que este é o número desejado?\n    Clique em OK em caso de confirmação.')){  <?php echo $acao; ?>  } } "/>
        </td>
                </tr>
                <tr>
                  <td height="5" align="right"><input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" class="back_Campos" value="<?php echo $bbh_flu_codigo; ?>">
                    <input type="hidden" name="MM_Update" id="MM_Update" value="formProtocolo" />
                  <input type="hidden" name="acao" id="acao" value="-1" />
                  <input name="bbh_pro_codigo" type="hidden" id="bbh_pro_codigo" value="<?php echo $bbh_pro_codigo; ?>">&nbsp;</td>
                </tr>
              </table></form>
<div id="loadForm" style="position:absolute; width:600px; color:#F60" align="right" class="verdana_12">&nbsp;</div>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
    <td bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
  </tr>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/voltar.gif" width="14" height="15" /></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $bbh_pro_codigo; ?>','menuEsquerda|conteudoGeral');">Voltar para p&aacute;gina - <?php echo($_SESSION['ProtNome']); ?></a></td>
  </tr>
</table>