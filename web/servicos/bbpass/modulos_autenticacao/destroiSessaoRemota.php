<?php if(!isset($_SESSION)) { session_start(); } 
	//destrói todas as funções - INICIO
		foreach ($_SESSION as $campo => $valor){ 
			$_SESSION[$campo] = NULL;
			 unset($_SESSION[$campo]);
		}
		//@unlink("../../../datafiles/servicos/bbpass/sessao/".session_id().".xml");
		session_regenerate_id();
	//destrói todas as funções - FIM
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>---</title>
</head>

<body>
<form name="redirecionamento" id="redirecionamento" method="get" action="<?php echo $_GET['urlRetorno']; ?>" target="_top" style="position:absolute"><input name="abandona" type="hidden" value="sim" /></form><script type="text/javascript">document.redirecionamento.submit();</script>
</body>
</html>