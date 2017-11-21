menu_padrao = new XML();
menu_padrao.load("includes/menu_padrao.xml");
menu_padrao.ignoreWhite = true;
	menu_padrao.onLoad = function(true) {
		var totMenus = menu_padrao.firstChild.childNodes.length;
			for($a=0; $a<totMenus; $a++){
				$Id 	= menu_padrao.firstChild.childNodes[$a].attributes.id;
				$Nome 	= menu_padrao.firstChild.childNodes[$a].attributes.nome;
				$Titulo = menu_padrao.firstChild.childNodes[$a].attributes.titulo;
				$Padrao = menu_padrao.firstChild.childNodes[$a].attributes.padrao;
				$acaoMenu= menu_padrao.firstChild.childNodes[$a].attributes.acaoMenu;
				
				_root.attachMovie("btnPadrao","padrao_"+$a,980+$a);
				eval("_root.padrao_"+$a)._x 		= $a==0?22:(($a+1)*74)+14+(66*($a-1));
				eval("_root.padrao_"+$a)._y 		= 32;
				eval("_root.padrao_"+$a)._id 		= $Id;
				eval("_root.padrao_"+$a)._titulo 	= $Titulo;
				eval("_root.padrao_"+$a).mnPadrao 	= $Nome;
				eval("_root.padrao_"+$a)._objeto 	= $a;
				eval("_root.padrao_"+$a)._acaoMenu 	= $acaoMenu;

				
				if($Padrao=="1"){
					eval("_root.padrao_"+$a).robson.gotoAndStop(2);
					_global.itemMenu = $Id;
					_global.qualItem = eval("_root.padrao_"+$a);
				}
				
				eval("_root.padrao_"+$a).onRollOver = function(){
					this.robson.gotoAndStop(2);
				}
				
				eval("_root.padrao_"+$a).onRollOut = function(){
					if(_global.itemMenu != this._id){
						this.robson.gotoAndStop(1);
					}
				}
				
				eval("_root.padrao_"+$a).onRelease = function(){
					_global.itemMenu = this._id;//grava menu na sessão
					
					//posiciona menu anterior para o inicial
					_global.qualItem.robson.gotoAndStop(1);

					this.robson.gotoAndStop(2);//muda status do menu atual
					
					//grava o menu da vez
					_global.qualItem = eval("_root.padrao_"+this._objeto);
					
					//chama área do menu selecionado
						if(this._acaoMenu=="loadPeopleRank()"){
							loadPeopleRank();
							
						}else if(this._acaoMenu=="loadBBHive()"){
							loadBBHive();
							
						}else if(this._acaoMenu=="loadBi()"){
							loadBi();
							
						}else if(this._acaoMenu=="loadCroqui()"){
							loadCroqui();
						}

				}
			}
		
	}