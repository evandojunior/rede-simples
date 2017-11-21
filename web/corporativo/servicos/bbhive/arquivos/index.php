<?php 
 if(!isset($_SESSION)){ session_start(); }
 //Arquivo de conexão GERAL
 require_once("../includes/autentica.php");
 require_once("../includes/functions.php");
 //Caminho do cabeçalho padrão do título do fluxo
 $dirFluxo 		= "/corporativo/servicos/bbhive/fluxo/cabecalhoModeloFluxo.php";

 	// Limpa a sessão
	if(isset($_GET['lp']) && $_GET['lp'] == 'true'){
		limpaDiretorio($_SESSION['caminhoFisico'] . '/datafiles/servicos/bbhive/sessao/');
		
 		unset($_SESSION['bbh_flu_codigo']);
		unset($_SESSION['bbh_usu_apelido']);
		unset($_SESSION['bbh_arq_compartilhado']);
		
		unset($_SESSION['MM_insert']);
		unset($_SESSION['MM_update']);
		unset($_SESSION['MM_delete']);
		echo("<var style='display:none'>limpaAmbiente();</var>");
	}
	
$bbh_usu_codigo = $_SESSION['usuCod'];	
$bbh_flu_codigo = 0;
$compl = empty($busca) ? " AND bbh_arquivo.bbh_usu_codigo NOT IN ($bbh_usu_codigo)" : "";

 	//recuperação de variáveis do GET e SESSÃO
  	foreach($_GET as $indice => $valor){
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
		if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){ $bbh_ati_codigo=$valor; }
		if(($indice=="amp;equipe")||($indice=="equipe")){ $equipe=$valor; }
		if(($indice=="amp;busca_arquivo")||($indice=="busca_arquivo")){ $busca_arquivo=$valor; }
	}

 require_once("includes/parametros_consulta.php");
 //--
	$SQL	= "";
	$compl 	= "";
	$strAud	= "";
	$bsc	= 1;

 	$bbh_usu_codigo = $_SESSION['usuCod'];
		$nElements 	= "50";
	//--
		if(isset($bbh_flu_codigo) && $bbh_flu_codigo>0){
			$SQL.= " and bbh_arquivo.bbh_flu_codigo = $bbh_flu_codigo and (bbh_arq_compartilhado='1' OR bbh_arquivo.bbh_usu_codigo=$bbh_usu_codigo)";
			$nElements 	= "500";
			//--
			unset($_SESSION[$nmSessao]);
			unset($_SESSION['consultaAvancada']);
			unset($_SESSION['buscaAvancada']);
		}	
	//--Consulta com base no array==========================================================================
		if(isset($_SESSION[$nmSessao])){
			foreach($_SESSION[$nmSessao] as $i=>$v){
				if($v[0] == "1"){
					if($i=="ck_data"){
						$SQL.= str_replace("@sub#Var@Black",arrumadata($v[3]),$v[2]);
						$strAud	.= " (".arrumadata($v[3]).")";
						//echo arrumadata($v[3]);
					} elseif($i=="busca_data"){
						$vr = explode("|",$v[3]);
						$ini= arrumadata($vr[0]);
						$fin= arrumadata($vr[1]);
						//--	
							$vS = str_replace("@subDtInicial@",$ini,$v[2]);
							$vS = str_replace("@subDtFinal@",$fin,$vS);
						//--
						$strAud	.= " (".$ini." - ".$fin.")";
						$SQL.= $vS;
					} elseif($i=="busca_avancada"){
						$SQL.= str_replace("@sub#Var@Black", $_SESSION['consultaAvancada'],$v[2]);	
						$_SESSION['buscaAvancada'] = 1;
					}elseif($i!="busca_data"){
						$SQL.= str_replace("@sub#Var@Black", ($v[3]),$v[2]);
						$strAud	.= " (".($v[3]).")";
						//echo $v[2]."=".$v[3]."<br>";
					}
				}
			}
		}
		//
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Acessou a página de consulta de ".$_SESSION['FluxoNome']." $strAud - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/

	$titulo = ' "Meus arquivos"';
	//--Padrão de consulta verificando Array();
	if(isset($_SESSION[$nmSessao]) && $_SESSION[$nmSessao]['situacao'][0]==1){
		$acao = ($_SESSION[$nmSessao]['situacao'][3]);
		//--
		if($acao == "Meus arquivos"){
			$SQL.= " and bbh_arquivo.bbh_usu_codigo = $bbh_usu_codigo";
			$titulo = ' "Meus arquivos"';
			$bsc = 0;
		} elseif($acao == "Arquivos da equipe"){
			$meusAcessos = "0";
			//--Somente os fluxos que tenho acesso
            $query_somenteEsses = "select bbh_fluxo.bbh_flu_codigo from bbh_fluxo
  inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
  inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
    Where bbh_atividade.bbh_usu_codigo = $bbh_usu_codigo or bbh_usuario.bbh_usu_chefe = $bbh_usu_codigo group by bbh_fluxo.bbh_flu_codigo";

            list($somenteEsses, $row_somenteEsses, $totalRows_somenteEsses) = executeQuery($bbhive, $idArquivo, $query_somenteEsses, $initResult = false);

			while($row_somenteEsses = mysqli_fetch_assoc($somenteEsses)){
				$meusAcessos.= ",".$row_somenteEsses['bbh_flu_codigo'];
			}
			$meusAcessos = strlen($meusAcessos)>1 ? " AND bbh_arquivo.bbh_flu_codigo IN ($meusAcessos)" : "";
			//--
			$SQL.= " and (bbh_arquivo.bbh_usu_codigo = $bbh_usu_codigo OR (bbh_arq_compartilhado='1' $meusAcessos)) ";
			$titulo = ' "Arquivos da equipe"';
			$bsc = 0;
		}
	}
 //-- 
	$meus 					= "";
	$fluxosCompartilhados 	= "";
	$meusSubordinados		= "";
	//--Baseado na busca
		if($bbh_flu_codigo==0 && $bsc == 1){
			$SQL.= " and bbh_arquivo.bbh_usu_codigo = $bbh_usu_codigo";
		}
	//SQL PADRÃO
	$sqlDinamico = "select 
		 bbh_arq_codigo, bbh_arquivo.bbh_usu_codigo, bbh_usu_apelido,
		 DATE_FORMAT(bbh_arq_data_modificado, '%d/%m/%Y %H:%i:%s') as publicado,
		 bbh_arq_tipo as tipo,
		 bbh_arq_titulo as titulo,
		 bbh_arq_autor as autor,
		 bbh_flu_titulo as titulo_fluxo,
		 bbh_arq_mime,
		 bbh_arq_compartilhado,
		 bbh_arquivo.bbh_flu_codigo,
		 bbh_mod_flu_nome,
		 bbh_flu_finalizado,
		 bbh_arq_publico,
		 bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao,
		 concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) numero,
		 concat(bbh_arq_localizacao,'/',bbh_arq_nome) arquivo
		from bbh_arquivo 
		  inner join bbh_fluxo on bbh_arquivo.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		  inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		  inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		  inner join bbh_usuario on bbh_arquivo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
			Where 1=1 $SQL
			   ORDER BY bbh_arquivo.bbh_flu_codigo DESC, bbh_arq_codigo ASC";
	
//------------------------------------------------------------------------------------------\\
    list($arquivos, $rows, $totalRows_arquivos) = executeQuery($bbhive, $database_bbhive, $sqlDinamico, $initResult = false);

	$page 		= "1";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= 'arquivos/index.php?Ts='.$_SERVER['REQUEST_TIME'];
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($totalRows_arquivos/$nElements);

    list($arquivos, $rows, $totalRows_arquivos) = executeQuery($bbhive, $database_bbhive, $sqlDinamico . " LIMIT $Inicio,$nElements", $initResult = false);
		
		//echo "<hr>".$SQL."<hr>";
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de visualização de arquivos do ".$_SESSION['arqNome']." - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
//echo "EM DESENVOLVIMENTO!";
?>
<link rel="stylesheet" type="text/css" href="../includes/bbhive.css">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['arqNome']; ?>')</var>
<?php include("busca.php"); ?>
</br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="370" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><img src="/corporativo/servicos/bbhive/images/meus_documentos.gif" alt="" width="24" height="24" align="absmiddle" /><strong>&nbsp;<?php echo $_SESSION['arqNome']; ?> - <?php echo $titulo; ?></strong><label class="color" id="idTxt"></label></td>
    <td width="101" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="124" align="center" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">
	<?php if(isset($bbh_ati_codigo)){?><a href="#@" onclick="showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/acao/regra.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>','menuEsquerda|colPrincipal');"><strong>Voltar para atividade</strong></a>      
	<?php } elseif(isset($bbh_flu_codigo)){ ?>
		<a href="#@" onClick="return  showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar detalhes do fluxo"><span class="color"><strong>Voltar para <?php echo $_SESSION['FluxoNome']; ?></strong></span></a>
	<?php } ?></td>
  </tr>
</table>
<br />
<form name="formArquivos" id="formArquivos">
<input type="hidden" name="MM_delete_multiplo" id="MM_delete_multiplo" value="multiplo">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
  <tr>
    <td width="388" height="25" bgcolor="#FFFFFF">
    <?php if($totalRows_arquivos>0){ ?>
    <a href="#@" onclick="selecionaTudo();">Selecionar todos</a>&nbsp;&nbsp;<a href="#@" onclick="if(confirm('Tem certeza que deseja excluir os arquivos selecionados?')){  OpenAjaxPostCmd('/corporativo/servicos/bbhive/arquivos/upload/executa.php','carrega_exclui','formArquivos','Excluindo...','carrega_exclui','1','2');}"><img src="/corporativo/servicos/bbhive/images/excluir.gif" border="0" align="absmiddle"/>&nbsp;Excluir selecionados</a>&nbsp;&nbsp;&nbsp;&nbsp;<span id="carrega_exclui">&nbsp;</span>
    <?php } ?>
    </td>
    <td width="207" align="right" bgcolor="#FFFFFF">
    <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;arquivos=1|arquivos/novo.php?<?php if(isset($bbh_flu_codigo)){ echo "bbh_flu_codigo=$bbh_flu_codigo"; } if(isset($bbh_ati_codigo)){echo "&bbh_ati_codigo=".$bbh_ati_codigo;}?>|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;equipeArquivos=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/novo.gif" border="0" align="absmiddle" />&nbsp;Anexar</a>&nbsp;</td>
  </tr>
</table>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
	  <tr>
		<td height="28" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11"><strong>Nome
		</strong></td>
		<td width="110" height="28" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11"><strong>Modificado em</strong></td>
		<td width="161" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11"><strong>Autor</strong></td>
		<td width="53" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11"><strong>Tamanho</strong></td>
		<td height="28" colspan="2" align="center" background="/corporativo/servicos/bbhive/images/back_top.gif" class="legandaLabel11">&nbsp;</td>
	  </tr>
	  <?php $codFlu = 0;
	  while($row_arquivos = mysqli_fetch_assoc($arquivos)){ $exite = true;
		  //recupera o mime do arquivo
		  //$oMime		= pegaMimeType($row_arquivos['bbh_arq_mime']);
		  $oMime		= ("mime-".strtolower($row_arquivos['tipo']) . ".gif");

		  if(!file_exists("../../../../datafiles/servicos/bbhive/images/mimes/".$oMime)){
			  $oMime = "mime-etc.gif";
		  }
		  
		  $caminhoFile	= $dirPacote[0]."database/servicos/bbhive/".$row_arquivos['arquivo'];
		  
		  if($codFlu != $row_arquivos['bbh_flu_codigo']){
			//--
				$nomeFluxo 		= $row_arquivos['bbh_mod_flu_nome'];
				$autoNumeracao	= $row_arquivos['bbh_flu_autonumeracao'];
				$tipoProcesso	= explode(".",$row_arquivos['bbh_tip_flu_identificacao']);
				$tipoProcesso	= (int)$tipoProcesso[0];
				$anoNumeracao	= $row_arquivos['bbh_flu_anonumeracao'];
				//--
				$numeroProcesso	= $nomeFluxo . " - " . $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
				//--
			//--	
	  ?>
      
          <tr>
            <td height="25" colspan="6" bgcolor="#FFFFFF" align="left" class="titulo_setor" style="font-size:13px;"><span class="color"><img src="/corporativo/servicos/bbhive/images/fluxo_22.gif" alt="" width="22" height="22" align="absmiddle" /></span>&nbsp;<a href="#@" onClick="return  showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_arquivos['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_arquivos['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar detalhes do fluxo"><span class="color">&nbsp;<?php echo $numeroProcesso; ?></span>&nbsp;(<?php echo $row_arquivos['titulo_fluxo']; ?>)</a></td>
          </tr>
       <?php } ?>   
          <tr>
            <td width="217" height="27" align="left" bgcolor="#FFFFFF" class="verdana_11">
			<?php if($row_arquivos['bbh_flu_finalizado']!='1'){ ?>
            	<input type="checkbox" name="chb_exclui_<?php echo $row_arquivos['bbh_arq_codigo']; ?>" id="chb_exclui_<?php echo $row_arquivos['bbh_arq_codigo']; ?>" value="<?php echo $row_arquivos['bbh_arq_codigo']; ?>" />
            <?php }?>
            
            <a href="/corporativo/servicos/bbhive/arquivos/download/index.php?file=<?php echo $row_arquivos['bbh_arq_codigo']; ?>" title="Download de <?php echo $row_arquivos['titulo']; ?>" target="_blank">&nbsp;&nbsp;
			<?php if($row_arquivos['bbh_arq_publico']=='1'){ ?>
            <img src="/corporativo/servicos/bbhive/images/publicado.gif" alt="Arquivo publicado" border="0" align="absmiddle" style="background-color:#FF9"/>
            <?php } ?>
			<?php if($row_arquivos['bbh_arq_compartilhado']=='1'){ ?>
            <img src="/corporativo/servicos/bbhive/images/compartilhado.gif" alt="Arquivo compartilhado" border="0" align="absmiddle"/>
             <?php } ?>
             <?php echo '<img src="'.$CaminhoIconesMime."/".$oMime.'" alt="" border="0" align="absmiddle"  />'?>
            &nbsp;<?php echo $t = $row_arquivos['titulo']; ?></a>
            
      
            </td>
            <td height="25" align="left" bgcolor="#FFFFFF" class="verdana_11"><a href="/corporativo/servicos/bbhive/arquivos/download/index.php?file=<?php echo $row_arquivos['bbh_arq_codigo']; ?>" title="Download de <?php echo $row_arquivos['titulo']; ?>" target="_blank"><?php echo $d=substr($row_arquivos['publicado'],0,16); ?></a></td>
            
            <td height="25" align="left" bgcolor="#FFFFFF" class="verdana_11"><a href="/corporativo/servicos/bbhive/arquivos/download/index.php?file=<?php echo $row_arquivos['bbh_arq_codigo']; ?>" title="Download de <?php echo $row_arquivos['titulo']; ?>" target="_blank"><div style="height:22px; line-height:22px; margin-left:8px; color:#393"><?php echo $a = $row_arquivos['bbh_usu_apelido']; ?></div></a></td>
            <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_11"><a href="/corporativo/servicos/bbhive/arquivos/download/index.php?file=<?php echo $row_arquivos['bbh_arq_codigo']; ?>" title="Download de <?php echo $row_arquivos['titulo']; ?>" target="_blank">
            <?
echo TamanhoArquivo($caminhoFile);
?>
            </a></td>
            <td width="25" height="25" align="center" bgcolor="#FFFFFF">
            <?php if($row_arquivos['bbh_flu_finalizado']!='1'){ ?>
            <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;arquivos=1|arquivos/editar.php?bbh_arq_codigo=<?php echo $row_arquivos['bbh_arq_codigo']; ?>&<?php if(isset($bbh_flu_codigo)){ echo "bbh_flu_codigo=$bbh_flu_codigo"; } if(isset($bbh_ati_codigo)){echo "&bbh_ati_codigo=".$bbh_ati_codigo;}?>|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;equipeArquivos=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/editar.gif" title="Editar informa&ccedil;&otilde;es do arquivo" alt="Editar informa&ccedil;&otilde;es do arquivo" width="17" height="17" border="0" align="absmiddle" /></a>
            <?php } else { ?>
            <img src="/corporativo/servicos/bbhive/images/editar-negado.gif" title="Não é possível editar informações deste arquivo" alt="Não é possível editar informações deste arquivo" width="17" height="17" border="0" align="absmiddle" />
            <?php } ?>
            </td>
            <td width="25" height="25" align="center" bgcolor="#FFFFFF">
            <?php if($row_arquivos['bbh_flu_finalizado']!='1'){ ?>
            <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;arquivos=1|arquivos/excluir.php?bbh_arq_codigo=<?php echo $row_arquivos['bbh_arq_codigo']; ?>&<?php if(isset($bbh_flu_codigo)){ echo "bbh_flu_codigo=$bbh_flu_codigo"; } if(isset($bbh_ati_codigo)){echo "&bbh_ati_codigo=".$bbh_ati_codigo;}?>|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;equipeArquivos=1','menuEsquerda|colCentro|colDireita');" title="Excluir arquivo"><img src="/corporativo/servicos/bbhive/images/excluir.gif" title="Excluir arquivo" alt="Excluir arquivo" width="17" height="17" border="0" align="absmiddle" /></a>
            <?php } else { ?>
            <img src="/corporativo/servicos/bbhive/images/excluir-negado.gif" title="Não é possível excluir este arquivo" alt="Não é possível excluir este arquivo" width="17" height="17" border="0" align="absmiddle" />
            <?php } 
			?>
            </td>
          </tr>
          
          <tr>
            <td height="1" colspan="6" align="center" valign="middle" bgcolor="#FFFFFF" background="/corporativo/servicos/bbhive/images/separador.gif">
            </td>
          </tr>
      <?php $codFlu = $row_arquivos['bbh_flu_codigo'];
	  } 
	  ?>
        <tr>
            <td height="25" colspan="6" align="center" valign="middle" bgcolor="#FFFFFF" class="verdana_11 color">
		<?php 
	  
	if(!isset($_GET['bbh_flu_codigo'])){	
		require_once('../includes/paginacao/paginacao.php');
		?></td>
          </tr>
       <?php } 
	   if($totalRows_arquivos == 0) { ?>
        
          <tr>
            <td height="25" colspan="6" align="center" valign="middle" bgcolor="#FFFFFF" class="verdana_11 color">N&atilde;o h&aacute; registros cadastrados</td>
          </tr>
           <?php } ?>

	</table>
      <?php if(isset($bbh_flu_codigo)){ ?>
    <input name="bbh_flu_codigo_sel" id="bbh_flu_codigo_sel" type="hidden" value="<?php echo $bbh_flu_codigo; ?>">
    <?php }
    	if(isset($bbh_ati_codigo)){
	?>
    	<input name="bbh_ati_codigo" id="bbh_ati_codigo" type="hidden" value="<?php echo $bbh_ati_codigo; ?>">
    <?php } ?>
</form>