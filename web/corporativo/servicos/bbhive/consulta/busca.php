<?php
if(!isset($_SESSION)){ session_start(); }
$SQL	= "";
$compl 	= "";
$strAud	= "";

//-- Consulta informações do usuário
$infor = permissoes_nivel();

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
				} elseif($i=="busca_avancada" && isset($_SESSION['consultaAvancada'])){
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

//anexar fluxo
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_flu_codigo_p")||($indice=="bbh_flu_codigo_p")){ $bbh_flu_codigo_p=$valor; }
	if(($indice=="amp;bbh_pro_codigo_p")||($indice=="bbh_pro_codigo_p")){ $bbh_pro_codigo_p=$valor; }
}
 if(isset($bbh_flu_codigo_p)){ $compl = "&bbh_flu_codigo_p=".$bbh_flu_codigo_p; }

foreach($_POST as $indice => $valor){
	if(($indice=="amp;bbh_flu_codigo_p")||($indice=="bbh_flu_codigo_p")){ $bbh_flu_codigo_p=$valor; }
	if(($indice=="amp;bbh_pro_codigo_p")||($indice=="bbh_pro_codigo_p")){ $bbh_pro_codigo_p=$valor; }
}
 if(isset($bbh_flu_codigo_p)){ $compl = "&bbh_flu_codigo_p=".$bbh_flu_codigo_p; }
 if(isset($bbh_pro_codigo_p)){ $compl = "&bbh_pro_codigo=".$bbh_pro_codigo_p; }
//===================================================================================================


//-----------------------------------------------------------------------------------------------------	
	//select para descobrir o total de registros na base
	$query_Fluxos = "select bbh_fluxo.bbh_flu_codigo, bbh_flu_oculto, bbh_fluxo.bbh_mod_flu_codigo, bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_flu_observacao,bbh_flu_tarefa_pai, 
					ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome, count(bbh_arquivo.bbh_flu_codigo) as arquivos,

					##	
					IF( 
					
					## SER Chefe
					(bbh_usuario.bbh_usu_codigo = ".$infor['codigo'].") 
					OR 
					
					## Participar da Tarefa
					(SELECT COUNT(*) 
					FROM bbh_atividade 
					WHERE bbh_atividade.bbh_usu_codigo = ".$infor['codigo']." and bbh_atividade.bbh_flu_codigo = bbh_flu_codigo) > 0 
					OR
					
					## Ter Permissão Maior
					(	(SELECT MAX(bbh_ind_sigilo)
						FROM bbh_indicio
						WHERE bbh_indicio.bbh_pro_codigo = bbh_pro_codigo) <= ".$infor['per_unidade']."
						AND 
						(SELECT bbh_dep_codigo
						FROM bbh_usuario
						WHERE bbh_usuario.bbh_usu_codigo = ".$infor['codigo'].") = bbh_departamento.bbh_dep_codigo
					)
					OR
					
					(SELECT MAX(bbh_ind_sigilo)
					FROM bbh_indicio
					WHERE bbh_indicio.bbh_pro_codigo = bbh_pro_codigo) <= ".$infor['per_matriz']."
					
					, '1','0' ) 'permissao'
					 
					
					from bbh_fluxo 
					left join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
					left join bbh_arquivo on bbh_fluxo.bbh_flu_codigo = bbh_arquivo.bbh_flu_codigo
					
					##### Data 02/02/2012
					left join bbh_indicio on bbh_protocolos.bbh_pro_codigo = bbh_indicio.bbh_pro_codigo
					
					Where 1=1 $SQL 
						
					group by bbh_fluxo.bbh_flu_codigo";

    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
//-----------------------------------------------------------------------------------------------------	
	$page 		= "1";
	$nElements 	= "40";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= 'consulta/index.php?Ts='.$_SERVER['REQUEST_TIME'];
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($totalRows_Fluxos/$nElements);
//-----------------------------------------------------------------------------------------------------

	$query_Fluxos = "select bbh_fluxo.bbh_flu_codigo, bbh_flu_oculto, bbh_fluxo.bbh_mod_flu_codigo, bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_flu_observacao,bbh_flu_tarefa_pai, 
					ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome, count(bbh_arquivo.bbh_flu_codigo) as arquivos,

					##	
					IF( 
					
					## SER Chefe
					(bbh_usuario.bbh_usu_codigo = ".$infor['codigo'].") 
					OR 
					
					## Participar da Tarefa
					(SELECT COUNT(*) 
					FROM bbh_atividade 
					WHERE bbh_atividade.bbh_usu_codigo = ".$infor['codigo']." and bbh_atividade.bbh_flu_codigo = bbh_flu_codigo) > 0 
					OR
					
					## Ter Permissão Maior
					(	(SELECT MAX(bbh_ind_sigilo)
						FROM bbh_indicio
						WHERE bbh_indicio.bbh_pro_codigo = bbh_pro_codigo) <= ".$infor['per_unidade']."
						AND 
						(SELECT bbh_dep_codigo
						FROM bbh_usuario
						WHERE bbh_usuario.bbh_usu_codigo = ".$infor['codigo'].") = bbh_departamento.bbh_dep_codigo
					)
					OR
					
					(SELECT MAX(bbh_ind_sigilo)
					FROM bbh_indicio
					WHERE bbh_indicio.bbh_pro_codigo = bbh_pro_codigo) <= ".$infor['per_matriz']."
					
					, '1','0' ) 'permissao'
					 
					
					from bbh_fluxo 
					left join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
					left join bbh_arquivo on bbh_fluxo.bbh_flu_codigo = bbh_arquivo.bbh_flu_codigo
					
					##### Data 02/02/2012
					left join bbh_indicio on bbh_protocolos.bbh_pro_codigo = bbh_indicio.bbh_pro_codigo
					
					Where 1=1 $SQL 
							
					group by bbh_fluxo.bbh_flu_codigo
					order by bbh_fluxo.bbh_flu_codigo desc LIMIT $Inicio,$nElements";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
//-----------------------------------------------------------------------------------------------------	
	$onLink = "onClick=\"return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/regra.php?bbh_flu_codigo=x".$compl."','menuEsquerda|conteudoGeral');\"";
?>
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderAlljanela">
      <tr class="legandaLabel11">
        <td width="3%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
        <td width="7%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>C&oacute;d. </strong></td>
        <td width="42%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>T&iacute;tulo do <?php echo $_SESSION['FluxoNome']; ?></strong></td>
        <td width="19%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Iniciado em</strong></td>
        <td width="13%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong> Origem</strong></td>
        <td width="6%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong> Status</strong></td>
        <td width="10%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
      </tr>
<?php if($totalRows_Fluxos>0) { ?> 
	  <?php do{ ?>    
      <tr class="legandaLabel11">
        <td height="25" align="center">
        <?php if($row_Fluxos['arquivos'] > 0){ ?>
<a href="#@" title="Visualizar arquivos" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?bbh_flu_codigo=<?php echo $row_Fluxos['bbh_flu_codigo']; ?>&|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');">
<img src="/corporativo/servicos/bbhive/images/clipes.gif" border="0" title="Tem anexo" /></a>
        <?php } else { ?>
<img src="/corporativo/servicos/bbhive/images/setaII.gif" border="0" />
        <?php } ?>
        </td>
        <td>&nbsp;<strong><?php echo $c=$row_Fluxos['bbh_flu_codigo'];  ?></strong></td>
        <td><?php echo $row_Fluxos['bbh_flu_titulo']; ?></td>
        <td>&nbsp;<?php echo $dt=arrumadata($row_Fluxos['bbh_flu_data_iniciado']); ?></td>
        <td>&nbsp;<?php echo $o=$row_Fluxos['bbh_dep_nome']; ?></td>
        <td>&nbsp;<?php echo $p=$row_Fluxos['concluido']; ?>%</td>
        <td align="center">
        <?php if($row_Fluxos['bbh_flu_oculto']=='0' && $row_Fluxos['permissao'] == "1"){ /*?>
        <img src="/corporativo/servicos/bbhive/images/fluxograma.gif" border="0" title="Interface rica" onclick="return OpenAjaxPostCmd('/corporativo/servicos/bbhive/consulta/regra.php?bbh_interface_codigo=<?php echo $row_Fluxos['bbh_flu_codigo']; ?>&','loadFluxo','','Aguarde','loadFluxo','2','2')" style="cursor:pointer" /><?php*/
		
		/*OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/atividades.php','flu_<?php echo $row_Fluxos['bbh_flu_codigo']?>','?bbh_flu_codigo=<?php echo $row_Fluxos['bbh_flu_codigo']?>&resumo=true','Aguarde...','flu_<?php echo $row_Fluxos['bbh_flu_codigo']?>','2','2');*/
		$acaoFrame  = true;
		$nome		= "";
		$link = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/atividades.php','flu_".$row_Fluxos['bbh_flu_codigo']."','?bbh_flu_codigo=".$row_Fluxos['bbh_flu_codigo']."&resumo=true','Aguarde...','flu_".$row_Fluxos['bbh_flu_codigo']."','2','2');";
			if($acaoFrame){
				$link = "document.getElementById('flu_".$row_Fluxos['bbh_flu_codigo']."').style.display=''; parent.frames['flu_".$row_Fluxos['bbh_flu_codigo']."'].location ='/corporativo/servicos/bbhive/fluxo/atividades.php?bbh_flu_codigo=".$row_Fluxos['bbh_flu_codigo']."&resumo=true&exibeFrame=true';";
				$nome		= "flu_".$row_Fluxos['bbh_flu_codigo'];
			}
		?>
        <img src="/corporativo/servicos/bbhive/images/listaIVI.gif" title="Clique para visualizar a lista de atividades" border="0" onclick="<?php echo $link;?>" style="cursor:pointer" />
        <a href="#@" <?php echo str_replace("bbh_flu_codigo=x","bbh_flu_codigo=".$row_Fluxos['bbh_flu_codigo'],$onLink); ?>><img src="/corporativo/servicos/bbhive/images/busca.gif" border="0" title="Resumo" /></a>
        <?php } else { ?>
        	<img src="/corporativo/servicos/bbhive/images/cadeado_off.gif" border="0" title="Este fluxo está oculto" />
        <?php } ?>
        </td>
      </tr>
      <tr>
      <td height="1" colspan="7"  align="right" <?php if(!isset($acaoFrame) || !$acaoFrame){ ?>id="flu_<?php echo $row_Fluxos['bbh_flu_codigo']?>"<?php } ?>><?php if(!isset($acaoFrame) || !$acaoFrame){ ?><iframe name="flu_<?php echo $row_Fluxos['bbh_flu_codigo']?>" id="flu_<?php echo $row_Fluxos['bbh_flu_codigo']?>" frameborder="0" width="100%" height="" allowtransparency="true" style="display:none"></iframe><?php } ?></td>
      </tr>
      <tr>
        <td height="1" colspan="7" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
      <?php } while ($row_Fluxos = mysqli_fetch_assoc($Fluxos)); ?>
<?php } else { ?>  
      <tr class="legandaLabel11">
        <td height="22" colspan="7" align="center">N&atilde;o h&aacute; registros cadastrados</td>
      </tr>
<?php } ini_set('display_erros', true); ?>
    </table>
    <label id="loadFluxo" class="legandaLabel12">&nbsp;</label>
	<?php require_once('../includes/paginacao/paginacao.php');?>