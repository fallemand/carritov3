<?php
session_start();
 if($_SESSION["usuario"]!="admin") {
   header("location:/index.php?show=admin");
   exit();
 }
include_once($_SESSION["www"]."/sources/Funciones.php");
if(isset($_GET["idproducto"]))
    $idproducto=$_GET["idproducto"];
elseif(isset($_POST["idproducto"]))
    $idproducto=$_POST["idproducto"];
echo'
<form action="index.php?show=admin&m=ver-prod" method="post" onsubmit=\'contenido("admin/ver-productos.php?idproducto="+document.getElementById("idproducto").value,"contenido-admin"); return false;\'>
    <select id="idproducto" name="idproducto">
        '.reemplazarCaracteres(comboProd($idproducto)).'
    </select>
    <input type="submit" value="Ver">
</form>';
$imagenes=glob($_SESSION["www"]."/images/productos/".$idproducto."_*-C.*");
for($i=0;$i<count($imagenes);$i++)
  $imagenes[$i]=str_replace($_SESSION["www"],"",$imagenes[$i]);
$resultado=datosProdyCat($idproducto,0);
$r=mysql_fetch_array($resultado);

echo '
<div id="big-bold">
    <h1 class="big-bold">'.reemplazarCaracteres($r["nombre"]).'</h1>
    <p>En la siguiente tabla se detalla la descripci&oacute;n del producto</p>
</div> <br />
<div id="formulario" style="text-align:left; padding-left:15px; width:70%;">
    <b>ID Producto: </b> ' .$r["idproducto"].'<br /><br />
    <b>Nombre Producto: </b>' .reemplazarCaracteres($r["nombre"]).'<br /><br />
    <b>Stock: </b>' .$r["stock"].' <br /><br />
    <b>Precio: $</b>' .$r["precio"].'<br /><br />
    <b>Categoria: </b>' .$r["categoria"].'<br /><br />
    <b>Descripcion: </b>'.reemplazarCaracteres($r["descripcion"]).'<br /><br />
    <b>Imagenes: </b><br /><br />';
    for($i=0;$i<count($imagenes);$i++)
        echo '<img src="'.$imagenes[$i].'" alt="Imagen Producto" />&nbsp;&nbsp;&nbsp;&nbsp;';
echo "
</div>";
?>