<?php
session_start();
 if($_SESSION["usuario"]!="admin") {
   header("location:/index.php?show=admin");
   exit();
 }
 include_once($_SESSION["www"]."/sources/Funciones.php");
 if(isset($_GET["idcategoria"]))
    $cat="idcategoria=".$_GET["idcategoria"];
?>
<div id="big-bold">
  <h1 class="big-bold">Listado Productos</h1>
  <p>En la siguiente tabla se detallan todos los productos cargados en el carrito</p>
</div>
<?php
 echo'
<form style="margin-left:38px; margin-bottom:3px;" action="index.php?show=admin&m=listado-prod" method="post" onsubmit=\'contenido("admin/lista-productos.php?idcategoria="+document.getElementById("idcategoria").value,"contenido-admin"); return false;\'>
    <select id="idcategoria" name="idcategoria">
    <optgroup label="Filtrar Categoria">
        '.comboCat($_GET["idcategoria"]).'
    </select>
    <input type="submit" value="Ver">
</form>';
?>
<table id="tablas">
    <th>ID</th><th>Nombre</th><th>Stock</th><th>$$</th><th>Categoria</th>
<?php
$resultados=datosProdyCat(0,$_GET["idcategoria"]);
$total=mysql_num_rows($resultados);
        while($r=mysql_fetch_array($resultados))
        {
            echo '<tr>
                    <td width=4%>' .$r["idproducto"].'</td>';
                    if($_GET["edit"]==$r["idproducto"])
                    {
                        echo reemplazarCaracteres('
                        <form action="admin/sql.php?t=prod" method="post" >
                            <td width=55%><input style="width:90%" id="nombre" name="nombre" value="'.addslashes($r["nombre"]).'" type="text" /></td>
                            <td width=4%><input style="width:90%" id="stock" name="stock" value="'.$r["stock"].'" type="text" /></td>
                            <td width=6%><input style="width:90%" id="precio" name="precio" value="'.$r["precio"].'" type="text" /></td>
                            <td width=25%>
                                <select style="width:75%" id="idcategoria" name="idcategoria">
                                    '.comboCat($r["idcategoria"]).'
                                </select>
                                <input id="idproducto" name="idproducto" type="hidden" value='.$r["idproducto"].'>
                                <input style="width:20%" id="submit" name="submit" type="submit" value="OK" />
                            </td>
                        </form>');
                    }
                    else
                    {
                        echo reemplazarCaracteres('
                        <td width=55%>' .$r["nombre"].'</td>
                        <td width=4%>' .$r["stock"].'</td>
                        <td width=6%>$' .$r["precio"].'</td>
                        <td width=25%>' .$r["categoria"].'</td>');
                    }
                    echo  '
                    <td width=4%><a href="admin/sql.php?t=prod&idproducto='.$r["idproducto"].'" Title="Eliminar Producto"><img src="/images/delete.png" border=0 alt="Eliminar" /></a></td>
                    <td width=4%><a href="index.php?show=admin&m=listado-prod&'.$cat.'&edit='.$r["idproducto"].'" Title="Edición Rápida"><img src="/images/edit.png" border=0 alt="Editar" /></a></td>
                    <td width=4%><a href="index.php?show=admin&m=cargar-prod&idproducto='.$r["idproducto"].'" Title="Edición Avanzada" onclick=\'contenido("admin/cargar-productos.php?idproducto='.$r["idproducto"].'","contenido-admin");return false;\'><img src="/images/edit2.png" border=0 alt="Editar" /></a></td>
                    <td width=4%><a href="index.php?show=admin&m=ver-prod&idproducto='.$r["idproducto"].'" Title="Ver Producto" onclick=\'contenido("admin/ver-productos.php?idproducto='.$r["idproducto"].'","contenido-admin");return false;\'><img src="/images/detallado.png" border=0 alt="Ver Producto" /></a></td>
            </tr>';
        }
?>
</table>