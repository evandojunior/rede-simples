<?php
 header('Content-type: text/css');
 //--
 //monta caminho para imagens
 $ondeEstou = $_SERVER['PHP_SELF'];
 $pagina 	= end(explode("/", str_replace("\\","/",$_SERVER['PHP_SELF']) ));
 //--
 $caminhoImg= str_replace($pagina,"imgs",$ondeEstou);
 //--
?>
.verdana_11 { 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 11px; 
	text-decoration: none; 
	letter-spacing: -1px;
}
.verdana_11_bold { 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 11px; 
	text-decoration: none; 
	letter-spacing: -1px;
	font-weight:bold;
}
.verdana_13_bold { 
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 13px; 
	text-decoration: none;
	font-weight:bold;
/*	padding-top:15px;*/
    float:left;
}
.botaoCadastro{
	border:#CCCCCC solid 1px; 
	margin-right:5px;
	cursor:pointer;
	padding:3px;
	background-color:#FFF;
	background-image: url(<?php echo $caminhoImg; ?>/application_add.gif);
	background-position:2px 2px;
	background-repeat: no-repeat;	
}
.botaoCancelar{
	border:#CCCCCC solid 1px; 
	margin-right:5px;
	cursor:pointer;
	padding:3px;
	background-color:#FFF;
	background-image: url(<?php echo $caminhoImg; ?>/cancelar.gif);
	background-position:2px 2px;
	background-repeat: no-repeat;	
}