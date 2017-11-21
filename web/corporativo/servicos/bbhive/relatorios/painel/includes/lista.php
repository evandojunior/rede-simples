<?php 
 if(!isset($_SESSION)){ session_start(); } 

 if(!isset($finalizado)){$finalizado=0;}

 if(isset($_SESSION['bbh_par_titulo'])){unset($_SESSION['bbh_par_titulo']);}
 if(isset($_SESSION['textoEdito'])){unset($_SESSION['textoEdito']);}
 if(isset($_SESSION['bbh_par_codigo'])){unset($_SESSION['bbh_par_codigo']);}

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
}
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/relatorios/painel/includes/cabecalhoAtividade.php");

	//verifica o código do fluxo
	$query_fluxo = "SELECT bbh_flu_codigo FROM bbh_atividade WHERE bbh_ati_codigo = $bbh_ati_codigo";
    list($fluxo, $row_fluxo, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_fluxo);
	$bbh_flu_codigo = $row_fluxo['bbh_flu_codigo'];

	$query_paragrafo = "SELECT * FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo ORDER BY bbh_par_ordem ASC";
    list($paragrafo, $row_paragrafo, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo);
	
	//trata ordenação
	if($totalRows_paragrafo>0){
		$primeiro = $row_paragrafo["bbh_par_codigo"];
		mysqli_data_seek($paragrafo,$totalRows_paragrafo-1);
			
		$row_ultimo = mysqli_fetch_assoc($paragrafo);
		$ultimo = $row_ultimo["bbh_par_codigo"];
		mysqli_data_seek($paragrafo,0);
	}
	
	$exibe = true;
	$homeDestino = "/corporativo/servicos/bbhive/relatorios/painel/paragrafos/executaParagrafos.php";

	$onEx = "OpenAjaxPostCmd('".$homeDestino."?TS=".time()."','listaParagrafos','excluiRel','Carregando...','listaParagrafos','1','2')";

  $a=0;
  $ordemAnexo = array();
  while($row_paragrafo = mysqli_fetch_assoc($paragrafo)){ ?>
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" id="par_<?php echo $a; ?>">
      <tr>
        <td width="380" height="25" class="semFundoPar" onMouseOver="javascript: document.getElementById('par_<?php echo $a; ?>').className='comFundoPar'" onMouseOut="javascript: document.getElementById('par_<?php echo $a; ?>').className='semFundoPar'" <?php if($row_paragrafo['bbh_par_titulo']=="Bl@ck_quebra_LINHA*~"){ echo 'title="Quebra de linha"'; } ?>>&nbsp;<?php 
		if($row_paragrafo['bbh_par_titulo']=="Bl@ck_quebra_LINHA*~"){
			echo '<img src="/corporativo/servicos/bbhive/images/painel/quebra.gif" border="0" align="absmiddle">';	
		} elseif($row_paragrafo['bbh_par_titulo']=="Bl@ck_arquivo_ANEXO*~") { 

		   array_push($ordemAnexo, $row_paragrafo['bbh_par_codigo']);
		   $anexo = count($ordemAnexo);
		   
		   	echo '<img src="/corporativo/servicos/bbhive/images/clipes.gif" border="0" align="absmiddle" title="Anexo">
                &nbsp;<b>Anexo - '.$anexo.'</b>&nbsp;'.$row_paragrafo['bbh_par_paragrafo'];
		} else {
			//verifica se tem imagem neste parágrafo
			if(!empty($row_paragrafo['bbh_par_arquivo'])){
			  echo '<img src="/corporativo/servicos/bbhive/images/painel/anexo_foto.gif" border="0" align="absmiddle" title="Parágrafo com anexo de imagem">';
			}
			echo "&nbsp;<b>".$row_paragrafo['bbh_par_titulo']."</b>"; 
		}
		?></td>
        <td width="28" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoItem'" onMouseOut="javascript: this.className='semFundoItem'" <?php } ?>>
        <?php  if($row_paragrafo['bbh_par_titulo']!="Bl@ck_quebra_LINHA*~" && $row_paragrafo['bbh_par_titulo']!="Bl@ck_arquivo_ANEXO*~") { ?>
        	<?php if($finalizado == 0){ ?>
        	<img src="/corporativo/servicos/bbhive/images/painel/add_foto.gif" width="16" height="16" align="absmiddle" title="Adicionar fotos neste parágrafo" onclick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_par_codigo=<?php echo $row_paragrafo['bbh_par_codigo']; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&pag=/anexos/foto.php','...','carregaTudo','2','2')" />
            <?php } else { echo '<img src="/corporativo/servicos/bbhive/images/painel/add_fotoOFF.gif" alt="Não é possível adicionar foto neste parágrafo" width="17" height="17" border="0">'; } ?>
            
         <?php } else { echo '<img src="/corporativo/servicos/bbhive/images/painel/add_fotoOFF.gif" alt="Não é possível adicionar foto neste parágrafo" width="17" height="17" border="0">'; }  ?>   
        </td>
        <td width="28" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoItem'" onMouseOut="javascript: this.className='semFundoItem'"<?php } ?>>
			<?php  if($exibe == true && $row_paragrafo['bbh_par_titulo']!="Bl@ck_quebra_LINHA*~" && $row_paragrafo['bbh_par_titulo']!="Bl@ck_arquivo_ANEXO*~") { ?>
            <?php if($finalizado == 0){ ?>
            <a href="#@" onclick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&bbh_par_codigo=<?php echo $row_paragrafo['bbh_par_codigo']; ?>&pag=/editor/regra.php','...','carregaTudo','2','2')">
            <img src="/corporativo/servicos/bbhive/images/editar.gif" alt="Editar parágrafo" width="17" height="17" border="0">        </a>   
            <?php } else { echo '<img src="/corporativo/servicos/bbhive/images/editarOFF.gif" alt="Não é possível editar este parágrafo" width="17" height="17" border="0">'; }  ?>         
            <?php } elseif($row_paragrafo['bbh_par_titulo']=="Bl@ck_arquivo_ANEXO*~"){ ?>
            <a href="#@" onclick="javascript: document.getElementById('file').value='<?php echo $row_paragrafo['bbh_par_codigo']; ?>'; document.abreArquivo.bbh_flu_codigo.value='<?php echo $bbh_flu_codigo; ?>'; document.abreArquivo.submit();"><img src="/corporativo/servicos/bbhive/images/download.gif" alt="Download do arquivo" width="17" height="17" border="0"></a> 
		<?php } else { echo '<img src="/corporativo/servicos/bbhive/images/editarOFF.gif" alt="Não é possível editar este parágrafo" width="17" height="17" border="0">';} ?></td>
        <td width="28" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoItem'" onMouseOut="javascript: this.className='semFundoItem'" onclick="javascript: if(confirm('  Tem certeza que deseja excluir este par&aacute;grafo?\n Ao clicar em OK as informa&ccedil;&otilde;es ser&atilde;o excluidas.')){ document.getElementById('bbh_par_codigo').value='<?php echo $row_paragrafo['bbh_par_codigo']; ?>'; document.getElementById('bbh_par_arquivo').value='<?php echo $row_paragrafo['bbh_par_arquivo']; ?>'; <?php echo $onEx; ?>;}"<?php } ?>><img src="/corporativo/servicos/bbhive/images/<?php echo $finalizado > 0 ? "excluirOFF.gif" : "excluir.gif"; ?>" alt="Excluir par&aacute;grafo" width="17" height="17" border="0"></td>
        <td width="28" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoItem'" onMouseOut="javascript: this.className='semFundoItem'"<?php } ?>><?php 
		if($exibe == true) { 

            $codParagrafo 	= $row_paragrafo['bbh_par_codigo'];
			$ord			= $row_paragrafo['bbh_par_ordem'];
            //tem mais de um parágrafo
            if($totalRows_paragrafo>1){
				 if($finalizado == 0){
						//exibo as opções conforme validação
						//se parágrafo não for o último e nem o primeiro exibo ícone
						$onClick="OpenAjaxPostCmd('".$homeDestino."?bbh_par_codigo=".$codParagrafo."&bbh_rel_codigo=".$bbh_rel_codigo."&acao=descer&bbh_ati_codigo=".$bbh_ati_codigo."&ordem=".$ord."&TS=".time()."','listaParagrafos','&1=1','Atualizando dados...','listaParagrafos','2','2');";
						
						$Icone = '<img src="/corporativo/servicos/bbhive/images/baixo.gif" border="0" align="absmiddle" alt="Descer"/>';
						$aHref = '<a href="#'.$codParagrafo.'" onClick="'.$onClick.'; ">'.$Icone.'</a>';
						
						if($codParagrafo==$primeiro){
							echo $aHref;
						} elseif(($codParagrafo!=$primeiro) && ($codParagrafo!=$ultimo)) {
							echo $aHref;
						} else {
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						}
				
				 }				
				
            } 

		} ?> </td>
        <td width="28" align="center" onMouseOver="javascript: this.className='comFundoItem'" onMouseOut="javascript: this.className='semFundoItem'"><?php 
		if($exibe == true) {
            $codParagrafo 	= $row_paragrafo['bbh_par_codigo'];
			$ord			= $row_paragrafo['bbh_par_ordem'];
            //tem mais de um parágrafo
            if($totalRows_paragrafo>1){
				if($finalizado == 0){
					//exibo as opções conforme validação
					//se parágrafo não for o último e nem o primeiro exibo ícone
					$onClick="OpenAjaxPostCmd('".$homeDestino."?bbh_par_codigo=".$codParagrafo."&bbh_rel_codigo=".$bbh_rel_codigo."&acao=subir&bbh_ati_codigo=".$bbh_ati_codigo."&ordem=".$ord."&TS=".time()."','listaParagrafos','&1=1','Atualizando dados...','listaParagrafos','2','2');";
					
					$Icone = '<img src="/corporativo/servicos/bbhive/images/cima.gif" border="0" align="absmiddle" alt="Subir"/>';
					$aHref = '<a href="#'.$codParagrafo.'" onClick="'.$onClick.'">'.$Icone.'</a>';
					
					if($codParagrafo==$ultimo){
						echo $aHref;
					}elseif(($codParagrafo!=$primeiro) && ($codParagrafo!=$ultimo)){
						echo $aHref;
					} else {
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				}
            }
		 } ?> </td>
      </tr>
    </table>
  <?php $a++;
  } ?>  
  
  <?php if($totalRows_paragrafo==0){ ?>
    <table width="520" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;">
      <tr>
        <td height="25" colspan="5" align="center" class="semFundoPar">N&atilde;o h&aacute; par&aacute;grafos adicionados</td>
      </tr>
	</table>
  <?php } ?>
  <var style="display:none">parent.frames['listaAnexos'].location = "/corporativo/servicos/bbhive/relatorios/painel/includes/anexos.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>";document.getElementById('carregaTudo').innerHTML = '&nbsp;';</var>
<form name="excluiRel" id="excluiRel">
  <input type="hidden" name="exRel" value="1" />
  <input type="hidden" name="bbh_rel_codigo" id="bbh_rel_codigo" value="<?php echo $bbh_rel_codigo; ?>" />
  <input type="hidden" name="bbh_par_codigo" id="bbh_par_codigo" value="" />
  <input type="hidden" name="bbh_ati_codigo" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  <input type="hidden" name="bbh_par_arquivo" id="bbh_par_arquivo" value="" />
  <input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
</form>
<form id="abreArquivo" name="abreArquivo" action="/corporativo/servicos/bbhive/relatorios/painel/download/anexos.php" method="get" style="position:absolute" target="_blank">
<input name="file" id="file" type="hidden" value="0" />
<input name="bbh_flu_codigo" id="bbh_flu_codigo" type="hidden" value="0" />
</form>
<form name="adicionaQuebra" id="adicionaQuebra">
  <input type="hidden" name="bbh_rel_codigo" id="bbh_rel_codigo" value="<?php echo $bbh_rel_codigo; ?>" />
  <input type="hidden" name="bbh_ati_codigo" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  <input type="hidden" name="bbh_par_paragrafo" id="bbh_par_paragrafo" value="---" />
  <input type="hidden" name="bbh_par_momento" id="bbh_par_momento" value="<?php echo date('Y-m-d'); ?>" />
  <input type="hidden" name="bbh_par_titulo" id="bbh_par_titulo" value="Bl@ck_quebra_LINHA*~" />
  <input type="hidden" name="bbh_par_autor" id="bbh_par_autor" value="<?php echo $_SESSION['usuNome']; ?>" />
  <input type="hidden" name="insertParagrafo" id="insertParagrafo" value="true" />
</form>