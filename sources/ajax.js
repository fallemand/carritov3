function retornarAjax() {
  var oAjax=false;
  if(window.XMLHttpRequest) /*Si da verdadero, no estoy trabajando con microsoft*/
    oAjax=new XMLHttpRequest();
  else if(window.ActiveXObject) /*Estoy trabajando con microsoft (explorer)*/
  {
    try {oAjax=new ActiveXObject("MSXml2.HMLHTTP");} /*Intento con la version nueva*/
    catch(e)
    {
      try{oAjax=new ActiveXObject("Microsoft.XMLHTTP");}/*Intento con la version vieja*/
      catch(e){}
    }
  }
  return oAjax;
}

function contenido(archivo, div) {
    $(div).update("<div style=\"margin:260px 0 0 345px;\"><img src=\"images/loading.gif\" /></div>");
	var ajax=retornarAjax();
    if(ajax){
    	ajax.onreadystatechange=function(){
        	if(ajax.readyState==4){
        		var div2=document.getElementById(div);
            	div2.innerHTML=ajax.responseText;
        	}
        }
        ajax.open("GET",archivo,true);
        ajax.send(null);
    }
}

function carrito(archivo, div) {
    $(div).update("<img src=\"images/loading2.gif\" />");
	var ajax=retornarAjax();
    if(ajax){
    	ajax.onreadystatechange=function(){
        	if(ajax.readyState==4){
        		var div2=document.getElementById(div);
            	div2.innerHTML=ajax.responseText;
                alert('Su producto ha sido agregado');
        	}
        }
        ajax.open("GET",archivo,true);
        ajax.send(null);
    }
}