/**
 * Conjunto de rotinas relacionadas para utilização de inclusão e remoção de elementos em select multiplo.
 *
 * @package Plugins
 * @subpackage Formulários
 * @version 1.0 - 2007-01-24 10:38:58
 * @author Diego Botelho <dibmartins@yahoo.com.br>
 * @link http://www.rgweb.com.br
 * @copyright © 2006 RG Consultoria - Todos os diretos reservados.
 */



/**
 * Variável global para ordenar os itens na lista (1 ou 0).
 * @access public
 */ 
	sortitems = 0;  

/**
 * Rotina para mover o conteúdo de um texto para um select.
 *
 * @param string fbox : textbox origem
 * @param string tbox : select destino
 * @return void
 * @access public
 */ 
	function MoveTL(fbox,tbox) 
	{
		if(fbox.value!="") 
		{
			var no=new Option();
			no.value=fbox.value;
			no.text=fbox.value;
			tbox.options[tbox.options.length]=no;
			fbox.value="";
			if (sortitems) SortD(tbox);
		}
		else 
		{
			alert("Item não preenchido.")
		}
	}


/**
 * Rotina para mover o conteúdo de um texto para um select.
 *
 * @param string fbox : textbox origem
 * @param string tbox : select destino
 * @return void
 * @access public
 */ 
	function MoveLT(fbox,tbox) 
	{
		var Moveu=false;
	
		for(var i=0;i<fbox.options.length;i++) 
		{
			if(fbox.options[i].selected && fbox.options[i].value!="") 
			{
				 tbox.value=fbox.options[i].text;
				 fbox.options[i].value="";
				 fbox.options[i].text="";
				 Moveu = true;
			}
		}
		
		if(Moveu) 
		{
			BumpUp(fbox);
		}
		else 
		{
			alert("Nenhum item foi selecionado.")
		}
	}


/**
 * Rotina para mover o conteúdo entre selects.
 *
 * @param string fbox : select origem
 * @param string tbox : select destino
 * @return void
 * @access public
 */ 
	function MoveLL(fbox, tbox, boxSelected) 
	{
		var Moveu = false;
		var pos   = 0;
	
		var dadosDe 	= document.getElementById(fbox);
		var dadosPara 	= document.getElementById(tbox);    
		
		for(var i = 0; i < dadosDe.options.length; i++) 
		{
			if((dadosDe.options[i].selected) && (dadosDe.options[i].value!="")  && (dadosDe.options[i].value!=0))
			{
				pos = getEmptyPosition(dadosPara);
				
				dadosPara.options[pos].value = dadosDe.options[i].value;
				dadosPara.options[pos].text  = dadosDe.options[i].text;
				
				dadosDe.options[i].value = "";
				dadosDe.options[i].text  = "";
				
				Moveu = true;			
			}
		}
		
		SelectAll(document.getElementById(boxSelected)); 
		
		if(Moveu) 
		{
			if(sortitems){SortD(dadosPara)};
		}
		else 
		{
			alert("Nenhum item foi selecionado.")
		}
	}

/**
 * Rotina para retornar a primeira posição vazia de um select.
 *
 * @param string box : 
 * @return void
 * @access public
 */ 
	function getEmptyPosition(box) 
	{
		 for(var i = 0; i < box.options.length; i++) 
		 { 
			 if((box.options[i].value == "" || box.options[i].value == 0) && box.options[i].text == "")
			 {
				  return i;			  
			 }
		 }
	}


/**
 * Rotina utilizada pelas demais.
 *
 * @param string box : 
 * @return void
 * @access private
 */ 
	function BumpUp(box) 
	{
	  for(var i = 0; i < box.options.length; i++) 
	  {
		if(box.options[i].value=="") 
		{
			  for(var j=i;j<box.options.length-1;j++) 
			  {
				box.options[j].value=box.options[j+1].value;
				box.options[j].text=box.options[j+1].text;
			  }
			  var ln=i;
			  break;
		} 
	  }
	
	  if(ln < box.options.length) 
	  {
			box.options.length -= 1;
			BumpUp(box);
	  }
	  
	}


/**
 * Rotina utilizada pelas demais.
 *
 * @param string box : 
 * @return void
 * @access private
 */ 
	function SortD(box)  
	{
		var temp_opts=new Array();
		var temp=new Object();
		
		for(var i=0;i < vbox.options.length;i++) 
		{
			temp_opts[i] = box.options[i];
		}
		
		for(var x = 0; x < temp_opts.length - 1; x++) 
		{
			for(var y = (x + 1); y < temp_opts.length; y++) 
			{
				  if(temp_opts[x].text > temp_opts[y].text) 
				  {
						temp = temp_opts[x].text;
						temp_opts[x].text = temp_opts[y].text;
						temp_opts[y].text = temp;
						temp = temp_opts[x].value;
						temp_opts[x].value = temp_opts[y].value;
						temp_opts[y].value = temp;
				  }
			}
		}
		
		for(var i=0;i<box.options.length;i++) 
		{
			box.options[i].value = temp_opts[i].value;
			box.options[i].text = temp_opts[i].text;
		}
	}


/**
 * Rotina para selecionar todas as opções.
 *
 * @param string fbox : 
 * @return void
 * @access public
 */ 
	function SelectAll(fbox) 
	{
		for(var i = 0;i < fbox.options.length;i++) 
		{
			if(fbox.options[i].value!="")
			{
				  fbox.options[i].selected = true;
			}
		}
	}