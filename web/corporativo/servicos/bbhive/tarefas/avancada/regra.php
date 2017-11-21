<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
?><var style="display:none">txtSimples('tagPerfil', 'Consulta avançada')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td colspan="2" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong>Console de busca avan&ccedil;ada <?php echo $_SESSION['FluxoNome']; ?>/<?php echo $_SESSION['TarefasNome']; ?></strong></td>
      </tr>
      <tr>
        <td width="4%" height="22" align="center" bgcolor="#EFEFE7" class="verdana_11">&nbsp;</td>
        <td width="96%" class="verdana_11">
<div style="float:right;">
        <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php','menuEsquerda|conteudoGeral');">
       	   <img src="/corporativo/servicos/bbhive/images/busca.gif" border="0" align="absmiddle" />&nbsp;<strong>Busca simples</strong>
        </a>   
        </div>
        </td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7">&nbsp;</td>
        <td width="96%">
        <fieldset>
            <legend class="verdana_11"><strong>Selecione o tipo</strong></legend>
                <br>
                <div style="margin-left:5px;">
                 <?php require_once("../../fluxo/arvore.php"); ?>
                </div>
        </fieldset>
        </td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="right" bgcolor="#EFEFE7" class="verdana_11"></td>
      </tr>
  </table>