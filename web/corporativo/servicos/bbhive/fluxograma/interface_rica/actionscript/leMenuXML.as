menu_padrao = new XML();
menu_padrao.load("includes/menu_padrao.xml");
menu_padrao.ignoreWhite = true;
	menu_padrao.onLoad = function(true) {
		var totMenus = menu_padrao.firstChild.childNodes.length;
			for($a=0; $a<totMenus; $a++){
				$Padrao 	= menu_padrao.firstChild.childNodes[$a].attributes.padrao;
				$acaoMenu 	= menu_padrao.firstChild.childNodes[$a].attributes.acaoMenu;

				if($Padrao=="1"){
					if($acaoMenu=="loadPeopleRank()"){
						loadPeopleRank();
						
					}else if($acaoMenu=="loadBBHive()"){
						loadBBHive();
						
					}else if($acaoMenu=="loadBi()"){
						loadBi();
					}else if($acaoMenu=="loadCroqui()"){
						loadCroqui();
					}
				}
			}

	}