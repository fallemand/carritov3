<?php
session_start();
include_once($_SESSION["www"]."/sources/Funciones.php");
$resultado=datosProdyCat($_GET["idproducto"],0);
$r=mysql_fetch_array($resultado);
$thumbs=glob($_SESSION["www"]."/images/productos/{$_GET["idproducto"]}_*M.*");
for($i=0;$i<count($thumbs);$i++)
  $thumbs[$i]=str_replace($_SESSION["www"],"",$thumbs[$i]);
$pos=rand(0,count($thumbs)-1);
$imagenes=glob($_SESSION["www"]."/images/productos/{$_GET["idproducto"]}_*G.*");
for($i=0;$i<count($imagenes);$i++)
  $imagenes[$i]=str_replace($_SESSION["www"],"",$imagenes[$i]);

echo '
<div id="producto2">
	<div id="foto"><a href="'.$imagenes[$pos].'" title="'.$r["nombre"].'" rel="lightbox"><img src="'.$thumbs[$pos].'" border=0 /></a><br />
    <div style="position:absolute; bottom:6px; width:190px; height:17px; margin:0 auto; margin-left:5px; background-color:#e3e3e3; border:1px solid #7fb8ee; padding-top:2px;">';
    for($i=0;$i<count($imagenes);$i++)
        echo '<a href="'.$imagenes[$i].'" title="'.$r["nombre"].'" rel="lightbox[galeria]"/>&nbsp;'.($i+1).' </a>';
    echo '
    </div>
    </div>
    <div id="detalles">
		<h1 class="big-bold2">'.reemplazarCaracteres($r["nombre"]).'</h1>
    	<p class="detalles">
    		<img src="/images/stock.png" /> Stock: <span class="precio">'.$r["stock"].'</span><br />
       	  	<img src="/images/precio.png" /> Precio: <span class="precio">$'.$r["precio"].'</span><br />
        	<img src="/images/categoria.png" /> Categoria: <a href="index.php?show=productos&idcategoria='.$r["idcategoria"].'" onclick=\'contenido("../sources/productos.php?idcategoria='.$r["idcategoria"].'","contenido"); return false; \'>'.$r["categoria"].'</a>
 		</p>
        <div id="carrito2"><a href="/index.php?show=carrito&idproducto='.$r["idproducto"].'" title="Agregar al Carrito" onclick=\'carrito("sources/carrito.php?idproducto='.$r["idproducto"].'","carrito");return false;\'><img src="images/carrito.png" border=0 alt="carrito" /></a></div>
	</div>
</div>
<div id="descripcion2">
 	<span class="detalles"><img src="/images/descripcion.png" width="32" height="32" />Descripcion:</span>
 	<p class="texto">'.str_replace("\n","<br />",reemplazarCaracteres($r["descripcion"])).'</p>;
</div>';
?>
