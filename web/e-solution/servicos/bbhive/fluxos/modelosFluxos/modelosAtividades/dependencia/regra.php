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
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/dependencia/regra.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','cadatraDep','Cadastrando dados...','cadastraModelo','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraMod")) {

//apaga todas as dependencias que eu sou sucessora
	$bbh_mod_ati_codigo = $_POST['bbh_mod_ati_codigo'];
	
	$deleteSQL = "DELETE FROM bbh_dependencia WHERE bbh_modelo_atividade_sucessora = $bbh_mod_ati_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);

	//recebe o dado responsável pela inserção das dependencias
	if($_POST['tratado']!=""){
		$dependencias 	= explode(",", substr($_POST['tratado'],1));
		$totDep			= count($dependencias);
	
			for($a=0; $a<$totDep; $a++){
				$cadaInsert = explode("|",$dependencias[$a]);
					$atiPred= $cadaInsert[0];//atividade predecessora
					$atiSuce= $cadaInsert[1];//atividade sucessora
					
					$insertSQL = "INSERT INTO bbh_dependencia (bbh_modelo_atividade_predecessora, bbh_modelo_atividade_sucessora) VALUES ($atiPred, $atiSuce)";
                    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
			}
	}
	
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=".$_POST['bbh_mod_flu_codigo']."','menuEsquerda|conteudoGeral')</var>";
exit;
}	

	if(isset($_GET['nv'])){
		$con=0;
		foreach($_GET as $indice=>$valor){
			$con=$con+1;
			if($con==2){ $bbh_mod_flu_codigo = $valor;}
			if($con==3){ $bbh_mod_ati_codigo = $valor;}
		}
	} else {
		$bbh_mod_ati_codigo = $_GET['bbh_mod_ati_codigo'];
		$bbh_mod_flu_codigo = $_GET['bbh_mod_flu_codigo'];
	}	

	$query_Dep = "select 
 bbh_modelo_atividade.bbh_mod_ati_codigo, bbh_modelo_atividade.bbh_mod_flu_codigo, bbh_mod_ati_nome, bbh_mod_ati_duracao, 
 bbh_mod_ati_inicio, bbh_modelo_atividade.bbh_mod_ati_ordem, bbh_mod_ati_mecanismo, bbh_mod_ati_icone, bbh_mod_ati_Inicio, 
 bbh_mod_atiFim, bbh_per_nome 

 from bbh_modelo_atividade
 
      left join bbh_fluxo_alternativa on bbh_modelo_atividade.bbh_mod_ati_codigo = bbh_fluxo_alternativa.bbh_mod_ati_codigo
      inner join bbh_perfil on bbh_modelo_atividade.bbh_per_codigo = bbh_perfil.bbh_per_codigo
       Where bbh_modelo_atividade.bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']." #and bbh_modelo_atividade.bbh_mod_ati_codigo<$bbh_mod_ati_codigo
	   group by bbh_mod_ati_codigo 
            order by bbh_modelo_atividade.bbh_mod_ati_ordem ASC ";
    list($Dep, $row_Dep, $totalRows_Dep) = executeQuery($bbhive, $database_bbhive, $query_Dep);
?>
<var style="display:none">txtSimples('tagPerfil', 'Depend&ecirc;ncia da atividade')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de depend&ecirc;ncias de atividades</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../cabecaModelo.php'); ?>
<?php require_once('../alternativas/cabecaAtividade.php'); ?>
<br>
<form name="cadatraDep" id="cadatraDep" style="margin-top:-1px;">
<table width="595" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="24" background="/e-solution/servicos/bbhive/images/cabAtiv.gif" class="legandaLabel11"><strong>&nbsp;Selecione as atividades predecessoras</strong></td>
      </tr>
      <tr>
        <td height="100" valign="top" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
          <tr>
            <td height="20" valign="top" align="right" id="cadastraModelo">&nbsp;</td>
          </tr>
          <tr>
            <td width="590" height="60" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"class="legandaLabel11" style="margin-top:2px;">
<?php if($totalRows_Dep>0) { ?> 
		<?php do { 
		
			//verifica se é predecessora
			$query_Pred = "select * from bbh_dependencia Where bbh_modelo_atividade_predecessora=".$row_Dep['bbh_mod_ati_codigo']." and bbh_modelo_atividade_sucessora=".$_GET['bbh_mod_ati_codigo'];
            list($Pred, $row_Pred, $totalRows_Pred) = executeQuery($bbhive, $database_bbhive, $query_Pred);
		?>             
              <tr>
                <td height="20" colspan="3" valign="top" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;
                    <label>
                    <input type="checkbox" name="bbh_dep_<?php echo $row_Dep['bbh_mod_ati_codigo']; ?>" id="bbh_dep_<?php echo $row_Dep['bbh_mod_ati_codigo']; ?>" value="<?php echo $row_Dep['bbh_mod_ati_codigo']; ?>|<?php echo $_GET['bbh_mod_ati_codigo']; ?>" <?php if($totalRows_Pred>0) { echo "checked"; } ?>/>
                    </label>
                  <?php echo $row_Dep['bbh_mod_ati_nome']; ?></td>
              </tr>
  <?php 
  	$Icone = '<img src="/datafiles/servicos/bbhive/corporativo/images/tarefas/'.$row_Dep['bbh_mod_ati_icone'].'" border="0" align="absmiddle" />';
  ?>
              <tr>
                <td width="9%" height="28" align="right" valign="middle"><?php echo $Icone; ?></td>
                <td width="67%" valign="middle">&nbsp;Perfil :&nbsp;<?php echo $row_Dep['bbh_per_nome']; ?>
        <label style="float:right; margin-top:-13px;">
        	<?php if($row_Dep['bbh_mod_ati_mecanismo']=="1"){ echo "autom&aacute;tico";} else { echo "<span class='color'>manual</span>"; }  ?> |&nbsp;        </label></td>
                <td width="24%" valign="middle">dura&ccedil;&atilde;o:&nbsp;<?php echo $row_Dep['bbh_mod_ati_duracao']; ?> dia(s)</td>
              </tr>
              <tr>
                <td height="5" colspan="3" valign="middle"></td>
              </tr>
 		<?php }while ($row_Dep = mysqli_fetch_assoc($Dep)); ?>
<?php } ?>

            </table></td>
          </tr>
          
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td height="24" class="legandaLabel11"><div style="float:right;">
                <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>','menuEsquerda|conteudoGeral');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
                                               <input name="insereModelo" type="button" class="back_input" id="insereModelo" value="Salvar dependencias" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" <?php if($totalRows_modAtividade==0) { echo "disabled"; } ?> onClick="return verificaDep('cadatraDep', document.getElementById('acaoForm').value);"/>
                                               &nbsp;&nbsp;&nbsp;            </div>    </td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
        </table></td>
      </tr>
    </table>
      <input type="hidden" name="MM_insert" value="cadastraMod" />
     <input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
     <input type="hidden" name="bbh_mod_ati_codigo" id="bbh_mod_ati_codigo" value="<?php echo $_GET['bbh_mod_ati_codigo']; ?>" />
     <input type="hidden" name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>" />
     <input type="hidden" name="tratado" id="tratado" value="">
</form>