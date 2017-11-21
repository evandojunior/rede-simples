 <?php
	if ($handle = opendir("upload_tmp_dir/.")) {
		$cont  = 0;
		$dif	= 0;
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if(strtolower($file)!="thumbs.db"){	
				
				 if(!isset($_GET['apagar'])){
					echo '<img src="upload_tmp_dir/'.$file.'" width="320" height="240">';					
				 } else {
					 unlink('upload_tmp_dir/'.$file);
				 }
					
			$cont++; 
			$dif = $dif + 1;
			//se chegar a 100 ele para
			if ($cont == 250) { die;}	
				}
			}
		}
		closedir($handle);
	}
	
	if(isset($_GET['apagar'])){
		echo "Arquivos removidos!";
	}
  ?>