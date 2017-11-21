<?php 
		header("Content-type: application/octet-stream");
		// este cabeçalho abaixo, indica que o arquivo deverá ser gerado para download (parâmetro attachment) e o nome dele será o contido dentro do parâmetro filename. 
		header("Content-Disposition: attachment; filename=livro_protocolo.xls");
		// No cache, ou seja, não guarda cache, pois é gerado dinamicamente 
		header("Pragma: no-cache");
		// Não expira 
		header("Expires: 0");
		// E aqui geramos o arquivo com os dados mencionados acima! 


$bbh_mod_flu_codigo = $_POST['bbh_mod_flu_codigo'];
$bbh_tip_flu_codigo	= $_POST['bbh_tip_flu_codigo'];

$nomeDetalhado		= "bbh_modelo_fluxo_".$bbh_mod_flu_codigo."_detalhado";
$tabelaDetalhamento = "inner join $nomeDetalhado as cd on f.bbh_flu_codigo = cd.bbh_flu_codigo";
$nomeCampos			= "";

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='$nomeDetalhado'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

if($tabelaCriada==1){
	//------------------------------------------------------------------------------------
	foreach($_POST as $indice=>$valor){
		//verifica se foi checado algum item
		$check = strpos($indice,"chk_");
	
		if(strlen($check) > 0){
			//Prepara variáveis dinâmicas para montar o select
			$id 		= str_replace("chk_","",$indice);
			$nomeCampos.= ", cd.".$_POST['nm_campo_'.$id]." as _$id";
		}
	}
	//------------------------------------------------------------------------------------

	$sql = "select 
		  f.bbh_flu_anonumeracao, f.bbh_flu_autonumeracao,
		  f.bbh_flu_titulo as titulo, f.bbh_flu_observacao as descricao,
		  p.bbh_pro_dt_recebido as data_recebimento_dpto, 
		  p.bbh_pro_titulo as numero_oficio,
		  p.bbh_pro_data as data_oficio,
		  p.bbh_pro_codigo as numero_protocolo,
		  p.bbh_pro_momento as dt_hr_protocolo
		  $nomeCampos
		  ,p.bbh_pro_identificacao as solicitante,
		  p.bbh_pro_descricao as descricao_solicitacao,
		  u.bbh_usu_nome as nome_perito,
		  ati.bbh_ati_final_real as data_conclusao,
		  p.bbh_pro_obs
		 from bbh_fluxo as f
		  left join bbh_protocolos as p on p.bbh_flu_codigo = f.bbh_flu_codigo
	#	  inner join bbh_fluxo as f on p.bbh_flu_codigo = f.bbh_flu_codigo
		  inner join bbh_modelo_fluxo as mf on f.bbh_mod_flu_codigo = mf.bbh_mod_flu_codigo
		  inner join bbh_tipo_fluxo as tpf on mf.bbh_tip_flu_codigo = tpf.bbh_tip_flu_codigo
		  inner join bbh_atividade as ati on f.bbh_flu_codigo = ati.bbh_flu_codigo
		  inner join bbh_usuario as u on ati.bbh_usu_codigo = u.bbh_usu_codigo
		  $tabelaDetalhamento
		 where tpf.bbh_tip_flu_codigo = $bbh_tip_flu_codigo
		#group by ati.bbh_flu_codigo
		order by f.bbh_flu_anonumeracao, f.bbh_flu_autonumeracao asc";
    list($Consulta, $rows, $totalRows_Consulta) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
	//$row_Consulta = mysqli_fetch_assoc($Consulta);
	//Gera planilha Excel
	
	function formataCaso($ano, $caso){
		$qt = strlen($caso);
			switch($qt){
				case 1 : $caso = "000000".$caso; break;
				case 2 : $caso = "00000".$caso; break;
				case 3 : $caso = "0000".$caso; break;
				case 4 : $caso = "000".$caso; break;
				case 5 : $caso = "00".$caso; break;
				case 6 : $caso = "0".$caso; break;
			}
		return $caso."/".$ano;	
	}
	$xml = new XML();//inicia xml
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	   <?php if(isset($_POST['phk_caso'])){?>
		<td><strong>Número do caso</strong></td>
	   <?php } ?> 
	   <?php if(isset($_POST['phk_dtrecebido'])){?>
		<td><strong>Data recebimento no departamento</strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_noficio'])){?>
		<td><strong>Número do ofício</strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_dtoficio'])){?>
		<td><strong><?php echo($_SESSION['ProtDtOfiNome']);?></strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_nprot'])){?>
		<td><strong>Número - <?php echo($_SESSION['ProtNome']); ?></strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_dthrprot'])){?>
		<td><strong>Data e hora <?php echo($_SESSION['ProtNome']); ?></strong></td>
	   <?php } ?>
	   
	   <?php if(isset($_POST['phk_nproc'])){?>
		<td><strong>Título do processo</strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_descproc'])){?>
		<td><strong>Descrição do processo</strong></td>
	   <?php } ?>   
	   
			<?php 
			foreach($_POST as $indice=>$valor){
				//verifica se foi checado algum item
				$check = strpos($indice,"chk_");
			
				if(strlen($check) > 0){
					$id 		= str_replace("chk_","",$indice);
				?>
				<td><strong><?php echo 	$_POST['apelido_'.$id]; ?></strong></td>
			<?php }
			}
			?>
	   <?php if(isset($_POST['phk_solicitante'])){?>
		<td><strong>Solicitante</strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_descricao'])){?>
		<td><strong>Descrição da solicitação</strong></td>
	   <?php } ?> 
	   <?php if(isset($_POST['phk_despachos'])){?>
		<td><strong>Despachos <?php echo($_SESSION['ProtNome']); ?></strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_nmperito'])){?>
		<td><strong>Nome do profissional</strong></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_dtconclusao'])){?>
		<td><strong>Data da conclusão</strong></td>
	   <?php } ?>
	  </tr>
	<?php while($row_Consulta = mysqli_fetch_assoc($Consulta)){
		if(isset($_POST['phk_despachos'])){
			
			if(!empty($row_Consulta['bbh_pro_obs'])){
				$pos = strpos($row_Consulta['bbh_pro_obs'],"<?xml version");
				 if($pos === false){ $naoExibe = true;}
			}
			$despachos_protocolo = "";
		}
		
			if(isset($naoExibe)){
				//varre XML detalhando os despachos
				$doc 	= @$xml->leXML($row_Consulta['bbh_pro_obs']);
				$totNo 	= 0;
				 
				if($doc->getElementsByTagName("despacho")){
					$totNo = @$doc->getElementsByTagName("despacho")->item(0)->childNodes->length;
				}
				$elemento = $doc->getElementsByTagName("despacho")->item(0);
				 for($a = ($totNo-1); $a>=0; $a--){
					 $despachos_protocolo .= $elemento->childNodes->item($a)->getAttribute('momento')." - ";
					 $despachos_protocolo .= mysqli_fetch_assoc($elemento->childNodes->item($a)->getAttribute('profissional'))." - ";
					 $despachos_protocolo .= mysqli_fetch_assoc($elemento->childNodes->item($a)->getAttribute('mensagem'))."<br>";
				  }/**/
				//--
			} else {
				$despachos_protocolo = $row_Consulta['bbh_pro_obs'];
			}
		?>  
	  <tr>
	   <?php if(isset($_POST['phk_caso'])){?>
	  <td><?php echo formataCaso($row_Consulta['bbh_flu_anonumeracao'], $row_Consulta['bbh_flu_autonumeracao']); ?></td>
	   <?php } ?> 
	   <?php if(isset($_POST['phk_dtrecebido'])){?>
		<td><?php echo arrumadata(substr($row_Consulta['data_recebimento_dpto'],0,10)) ." ".substr($row_Consulta['data_recebimento_dpto'],11,5); ?></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_noficio'])){?>
		<td><?php echo $row_Consulta['numero_oficio']; ?></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_dtoficio'])){?>
		<td><?php echo arrumadata($row_Consulta['data_oficio']); ?></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_nprot'])){?>
		<td><?php echo $row_Consulta['numero_protocolo']; ?></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_dthrprot'])){?>
		<td><?php echo arrumadata(substr($row_Consulta['dt_hr_protocolo'],0,10)) ." ". substr($row_Consulta['dt_hr_protocolo'],11,5); ?></td>
	   <?php } ?>
	   
	   <?php if(isset($_POST['phk_nproc'])){?>
		<td><?php echo $row_Consulta['titulo']; ?></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_descproc'])){?>
		<td><?php echo $row_Consulta['descricao']; ?></td>
	   <?php } ?> 
	   
			<?php 
			foreach($_POST as $indice=>$valor){
				//verifica se foi checado algum item
				$check = strpos($indice,"chk_");
			
				if(strlen($check) > 0){
					$id 		= str_replace("chk_","",$indice);
					$tipoCampo	= $_POST['tp_campo_'.$id];
				?>
				<td><?php 
					if($tipoCampo=="time_stamp" || $tipoCampo=="horario_editavel"){
						echo arrumadata(substr($row_Consulta['_'.$id],0,10)) ." ". substr($row_Consulta['_'.$id],11,5);
					} else {
						echo $row_Consulta['_'.$id];
					}
				 ?></td>
			<?php }
			}
			?>
	   <?php /*for($a=0; $a<$cadaCampo; $a++){ ?>
		<td><?php echo '_'.$cadaCampo[$a];//$row_Consulta['_'.$cadaCampo[$a]]; ?></td>
	   <?php }*/ ?> 
	   <?php if(isset($_POST['phk_solicitante'])){?>
		<td><?php echo $row_Consulta['solicitante']; ?></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_descricao'])){?>
		<td><?php echo nl2br($row_Consulta['descricao_solicitacao']); ?></td>
	   <?php } ?> 
	   
	   <?php if(isset($_POST['phk_despachos'])){?>
		<td><?php echo $despachos_protocolo; ?></td>
	   <?php } ?>
	 
	   <?php if(isset($_POST['phk_nmperito'])){?>
		<td><?php echo $row_Consulta['nome_perito']; ?></td>
	   <?php } ?>
	   <?php if(isset($_POST['phk_dtconclusao'])){?>
		<td><?php echo arrumadata($row_Consulta['data_conclusao']); ?></td>
	   <?php } ?>
	  </tr>
	<?php $despachos_protocolo = ""; } ?>
	</table>
<?php } else { ?>
	Tabela inexistente!
<?php } ?>