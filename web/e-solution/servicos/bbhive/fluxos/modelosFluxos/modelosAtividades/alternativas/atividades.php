<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	$query_modAtividade = "select bbh_mod_ati_codigo, bbh_mod_ati_nome, bbh_mod_ati_ordem from bbh_modelo_atividade Where bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']." order by bbh_mod_ati_ordem asc";
    list($modAtividade, $row_modAtividade, $totalRows_modAtividade) = executeQuery($bbhive, $database_bbhive, $query_modAtividade);
	
 if($totalRows_modAtividade>0){?>
 <?php do{ 
    $CodigoPai 	= $row_modAtividade['bbh_mod_ati_codigo'];
	$ordem		= $row_modAtividade['bbh_mod_ati_ordem'];
    ?> 
    
            <div style="margin-left:15px">
                <div style="display:inline">
                    <img src="/e-solution/servicos/bbhive/images/marcador-duplo.gif" alt="Fechar" border="0" align="absmiddle">
                </div>
                <div style="display:inline;margin-left:3px;" class="verdana_9">
			<a href="#@" onClick="javascript: document.getElementById('bbh_mod_ati_ordem').value=<?php echo $ordem; ?>; document.getElementById('modAlt').innerHTML='&nbsp;<?php echo $row_modAtividade['bbh_mod_ati_nome']; ?>'; document.getElementById('modFlu').innerHTML='&nbsp;<?php echo $_GET['mod_ati_nome']; ?>'; document.getElementById('bbh_mod_flu_codigo').value=<?php echo $_GET['bbh_mod_flu_codigo']; ?>; document.getElementById('escolhe').className='hide'; document.getElementById('adicionado').className='show'; document.getElementById('bbh_atividade_predileta').className='show';document.getElementById('carregaModelo').innerHTML='';">
                <?php echo $row_modAtividade['bbh_mod_ati_nome']; ?>
			</a>
                </div>
            </div>

 <?php } while ($row_modAtividade = mysqli_fetch_assoc($modAtividade));  ?>
<?php } ?>
