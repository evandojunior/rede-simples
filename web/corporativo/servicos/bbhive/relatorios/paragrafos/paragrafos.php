<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");



$cont=0;
foreach($_GET as $indice=>$valor){
		if($cont==0){ $bbh_tip_flu_codigo = $valor; } 
		if($cont==1){ $bbh_mod_flu_codigo = $valor; } 
	$cont=$cont+1;
}

$query_modparagrafo = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_flu_codigo = $bbh_mod_flu_codigo ORDER BY bbh_mod_par_codigo ASC";
list($modparagrafo, $row_modparagrafo, $totalRows_modparagrafo) = executeQuery($bbhive, $database_bbhive, $query_modparagrafo);

	//trata ordenação
	if($totalRows_modparagrafo>0){
		$primeiro = $row_modparagrafo["bbh_mod_par_codigo"];
		mysqli_data_seek($modparagrafo,$totalRows_modparagrafo-1);
			
		$row_ultimo = mysqli_fetch_assoc($modparagrafo);
		$ultimo = $row_ultimo["bbh_mod_par_codigo"];
		mysqli_data_seek($modparagrafo,0);
	}
$homeDestino = "/corporativo/servicos/bbhive/relatorios/paragrafos/ordenacao.php";

	unset($_SESSION['textoEdito']);
	unset($_SESSION['textoParNome']);
	unset($_SESSION['textoParTitulo']);
	unset($_SESSION['textoParmomento']);
	unset($_SESSION['textoMonGrava']);
	unset($_SESSION['textoParAutor']);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
      <tr class="legandaLabel11">
        <td width="595" height="26" colspan="7" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="3%" height="26">&nbsp;</td>
            <td width="39%"><strong>Nome do par&aacute;grafos</strong></td>
            <td width="33%"><strong>T&iacute;tulo do par&aacute;grafo</strong></td>
            <td width="25%"><a href="#@" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/novo.php?bbh_tip_flu_codigo=<?php echo $bbh_tip_flu_codigo; ?>&bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>','menuEsquerda|colPrincipal');"><img src="/corporativo/servicos/bbhive/images/novo.gif" border="0" align="absmiddle" /> modelo de par&aacute;grafos</a></td>
          </tr>
        </table></td>
      </tr>
      
  <?php 
  $tem=0;
  if ($totalRows_modparagrafo > 0) { $cont=0;// Show if recordset not empty ?>
    <?php while ($row_modparagrafo = mysqli_fetch_assoc($modparagrafo)){ $cont = $cont+1; ?>
      <?php if(($row_modparagrafo['bbh_usu_autor']==$_SESSION['usuCod'])||($row_modparagrafo['bbh_usu_autor']==NULL)) { 
	  	$tem=1;
	  ?> 
          <tr class="legandaLabel11">
            <td height="26" colspan="7"><table width="595" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="18" height="26"><span class="color"><strong><?php echo $cont; ?></strong></span></td>
                <td width="233">
    <a href="#@filho_<?php echo $row_modparagrafo['bbh_mod_par_codigo']; ?>" onclick="javascript: if(document.getElementById('filho_<?php echo $row_modparagrafo['bbh_mod_par_codigo']; ?>').className=='hide') { document.getElementById('filho_<?php echo $row_modparagrafo['bbh_mod_par_codigo']; ?>').className='show' }else{document.getElementById('filho_<?php echo $row_modparagrafo['bbh_mod_par_codigo']; ?>').className='hide' }">
            <?php
            if(strlen($row_modparagrafo['bbh_mod_par_nome'])>28){
                echo substr($row_modparagrafo['bbh_mod_par_nome'],0,25)."...";
            }else{
                echo $row_modparagrafo['bbh_mod_par_nome'];
            }
            ?>
            </a>            </td>
                <td width="229">
    <?php
            if(strlen($row_modparagrafo['bbh_mod_par_titulo'])>54){
                echo substr($row_modparagrafo['bbh_mod_par_titulo'],0,51)."...";
            }else{
                echo $row_modparagrafo['bbh_mod_par_titulo'];
            }
    
            ?>            </td>
                <td width="29">
            <?php
            $codParagrafo = $row_modparagrafo['bbh_mod_par_codigo'];
            //tem mais de um parágrafo
            if($totalRows_modparagrafo>1){
                //exibo as opções conforme validação
                //se parágrafo não for o último e nem o primeiro exibo ícone
                $onClick="return OpenAjaxPostCmd('".$homeDestino."?bbh_tip_flu_codigo=".$bbh_tip_flu_codigo."&bbh_mod_par_codigo=".$codParagrafo."&acao=descer&bbh_mod_flu_codigo=".$bbh_mod_flu_codigo."&','loadOrdena','&1=1','Atualizando dados...','loadOrdena','2','2');";
                
                $Icone = '<img src="/corporativo/servicos/bbhive/images/baixo.gif" border="0" align="absmiddle" />';
                $aHref = '<a href="#@'.$codParagrafo.'" onClick="'.$onClick.'">'.$Icone.'</a>';
                
                if($codParagrafo==$primeiro){
                    echo $aHref;
                } elseif(($codParagrafo!=$primeiro) && ($codParagrafo!=$ultimo)) {
                    echo $aHref;
                }
            }
            ?>
    </td>
                <td width="29">
            <?php
            $codParagrafo = $row_modparagrafo['bbh_mod_par_codigo'];
            //tem mais de um parágrafo
            if($totalRows_modparagrafo>1){
                //exibo as opções conforme validação
                //se parágrafo não for o último e nem o primeiro exibo ícone
                $onClick="return OpenAjaxPostCmd('".$homeDestino."?bbh_tip_flu_codigo=".$bbh_tip_flu_codigo."&bbh_mod_par_codigo=".$codParagrafo."&acao=subir&bbh_mod_flu_codigo=".$bbh_mod_flu_codigo."&','loadOrdena','&1=1','Atualizando dados...','loadOrdena','2','2');";
                
                $Icone = '<img src="/corporativo/servicos/bbhive/images/cimaII.gif" border="0" align="absmiddle" />';
                $aHref = '<a href="#@'.$codParagrafo.'" onClick="'.$onClick.'">'.$Icone.'</a>';
                
                if($codParagrafo==$ultimo){
                    echo $aHref;
                }elseif(($codParagrafo!=$primeiro) && ($codParagrafo!=$ultimo)){
                    echo $aHref;
                }
            }
            ?>      
    </td>
                <td width="29"><?php if($row_modparagrafo['bbh_mod_par_privado']=='1') { ?>
                  <a href="#@"  onclick="return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/editar.php?bbh_tip_flu_codigo=<?php echo $bbh_tip_flu_codigo; ?>&bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>&bbh_mod_par_codigo=<?php echo $row_modparagrafo['bbh_mod_par_codigo']; ?>','menuEsquerda|colPrincipal');"><img src="/corporativo/servicos/bbhive/images/editar.gif" border="0" align="absmiddle" /></a>
                  <?php } else { ?>
                  <img src="/corporativo/servicos/bbhive/images/editar-negado.gif" border="0" align="absmiddle" />
                  <?php } ?></td>
                <td width="28"><?php if($row_modparagrafo['bbh_mod_par_privado']=='1') { ?>
                  <a href="#@"  onclick="return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/excluir.php?bbh_tip_flu_codigo=<?php echo $bbh_tip_flu_codigo; ?>&bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>&bbh_mod_par_codigo=<?php echo $row_modparagrafo['bbh_mod_par_codigo']; ?>','menuEsquerda|colPrincipal');"><img src="/corporativo/servicos/bbhive/images/excluir.gif" border="0" align="absmiddle" /></a>
                  <?php } else { ?>
                  <img src="/corporativo/servicos/bbhive/images/excluir-negado.gif" border="0" align="absmiddle" />
                  <?php } ?></td>
              </tr>
            </table></td>
          </tr>
          
          <tr class="legandaLabel11">
            <td height="22" colspan="7" align="left">
            <label style="margin-left:25px;">
                Autor:<?php
                    //verifico se é publico ou privado
                    if($row_modparagrafo['bbh_mod_par_privado']=='0'){
                        $SQL = "SELECT bbh_adm_nome FROM bbh_administrativo WHERE bbh_adm_codigo = ".$row_modparagrafo['bbh_adm_codigo'];
                        $campo = "bbh_adm_nome";
                    }else {
                        $SQL = "SELECT bbh_usu_nome FROM bbh_usuario WHERE bbh_usu_codigo = ".$row_modparagrafo['bbh_usu_autor'];
                        $campo = "bbh_usu_nome";
                    }

                        list($Autor, $row_Autor, $totalRows_Autor) = executeQuery($bbhive, $database_bbhive, $SQL);
                        
                        echo "<strong>".$row_Autor[$campo]."</strong>";
                ?>
            </label>
                <label style="float:right; margin-right:10px; margin-top:-13px;" class="color">
                    Criado em : <?php echo arrumadata(substr($row_modparagrafo['bbh_mod_par_momento'],0,10)); ?>
                </label>
            </td>
          </tr>
          <tr id="filho_<?php echo $row_modparagrafo['bbh_mod_par_codigo']; ?>" class="hide">
            <td height="1" colspan="7" class="legandaLabel11">
                <div style="margin-left:5px; margin-right:5px;">
                    <?php echo nl2br($row_modparagrafo['bbh_mod_par_paragrafo']); ?></div><br />		</td>
          </tr>
          <tr>
            <td height="1" colspan="7" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
          </tr>
         <?php } ?> 
      <?php } ?>
<?php } ?>
<?php if($tem==0) { ?>
      <tr class="legandaLabel11">
        <td height="22" colspan="7" align="center">N&atilde;o h&aacute; registros cadastrados</td>
      </tr>
<?php } ?>
      <tr class="legandaLabel11">
        <td height="22" colspan="7" align="center">&nbsp;</td>
      </tr>
      <tr class="legandaLabel11">
        <td height="5" colspan="7" align="center"></td>
      </tr>
</table>