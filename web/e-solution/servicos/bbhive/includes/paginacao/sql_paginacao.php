<?php
    //===============================================STRING SQL DE PAGINAÇÃO==========================================
	if($sql == true){
		$currentPage = $_SERVER["PHP_SELF"];
		
		$maxRows_sql = $maximoLinhas;
		$pageNum_sql = 0;
		if (isset($_GET['pageNum_sql'])) {
		  settype($_GET['pageNum_sql'],"integer");
		  $pageNum_sql = $_GET['pageNum_sql'];
		}
		$startRow_sql = $pageNum_sql * $maxRows_sql;

		$query_sql = $StringSQL;
		$query_limit_sql = sprintf("%s LIMIT %d, %d", $query_sql, $startRow_sql, $maxRows_sql);
        list($sql, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_limit_sql, $initResult = false);
		//$row_sql = mysqli_fetch_assoc($sql);
		
		if (isset($_GET['totalRows_sql'])) {
		  settype($_GET['totalRows_sql'],"integer");
		  $totalRows_sql = $_GET['totalRows_sql'];
		} else {
            list($all_sql, $rows, $totalRows_sql) = executeQuery($bbhive, $database_bbhive, $query_sql, $initResult = false);
		}
		$totalPages_sql = ceil($totalRows_sql/$maxRows_sql)-1;
		
		$queryString_sql = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (stristr($param, "pageNum_sql") == false && 
				stristr($param, "totalRows_sql") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString_sql = "&" . htmlentities(implode("&", $newParams));
		  }
		}
		$queryString_sql = sprintf("&totalRows_sql=%d%s", $totalRows_sql, $queryString_sql);
	}
    //===============================================FIM STRING SQL DE PAGINAÇÃO======================================
	
	//===============================================PAGINAÇÃO========================================================
	if($paginacao == true){ ?>
    <?php if ($totalRows_sql > 0) { // Show if recordset not empty ?>
                <table width="230" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="69" align="center"><?php if ($pageNum_sql > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, 0, $queryString_sql); ?>"><img src="/servicos/bbhive/imagens/paginacao/First.gif" border=0 title="Primeira"></a>
                          <?php } // Show if not first page ?>
                      &nbsp; </td>
                    <td width="55" align="center"><?php if ($pageNum_sql > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, max(0, $pageNum_sql - 1), $queryString_sql); ?>"><img src="/servicos/bbhive/imagens/paginacao/Previous.gif" border=0 title="Anterior"></a>
                          <?php } // Show if not first page ?>
                      &nbsp; </td>
                    <td width="56" align="center"><?php if ($pageNum_sql < $totalPages_sql) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, min($totalPages_sql, $pageNum_sql + 1), $queryString_sql); ?>"><img src="/servicos/bbhive/imagens/paginacao/Next.gif" border=0 title="Próxima"></a>
                          <?php } // Show if not last page ?>
                      &nbsp; </td>
                    <td width="70" align="center"><?php if ($pageNum_sql < $totalPages_sql) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_sql=%d%s", $currentPage, $totalPages_sql, $queryString_sql); ?>"><img src="/servicos/bbhive/imagens/paginacao/Last.gif" border=0 title="Última"></a>
                          <?php } // Show if not last page ?></td>
                  </tr>
                </table>
                <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_sql > 0) { // Show if recordset > 1 ?>
                  <table width="250" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
                    <tr>
                      <td width="250" align="center">&nbsp;Exibindo <?php echo ($startRow_sql + 1) ?> - <?php echo min($startRow_sql + $maxRows_sql, $totalRows_sql) ?> do total de <?php echo $totalRows_sql ?> registros </td>
                    </tr>
                 </table>
       <?php } // Show if recordset not empty ?>
	<?php }
	//===============================================PAGINAÇÃO========================================================
?>