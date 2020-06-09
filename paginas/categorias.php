<?php
session_start();
include_once($_SESSION["www"]."/sources/class.Bd.php");
$bd=new Bd();
$sql="SELECT c.idcategoria, c.descripcion, COUNT(p.idcategoria) AS cant FROM categorias c INNER JOIN productos p ON p.idcategoria=c.idcategoria GROUP BY(c.idcategoria)";
$resultados=$bd->ejecutar($sql);
while($r=$bd->retornarFila($resultados))
  echo '
    <a href="index.php?idcategoria='.$r["idcategoria"].'" onclick=\'contenido("../sources/productos.php?idcategoria='.$r["idcategoria"].'","contenido"); return false;\'" title="Ver productos de la categoria '.$r["descripcion"].'">
    <div id="categorias">
	    <div id="img2"><img src="/images/categorias/'.$r["idcategoria"].'.jpg" border=0 alt="img-cat" /></div>
        <span>'.$r["descripcion"].'</span><br /><br />
        <b>'.$r["cant"].' productos</b><br />dentro de esta categoria
    </div>
    </a>';
?>
