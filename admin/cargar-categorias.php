<?php
session_start();
 if($_SESSION["usuario"]!="admin") {
   header("location:/index.php?show=admin");
   exit();
 }
?>
<div id="big-bold">
  <h1 class="big-bold">Ingresar Categorias</h1>
  <p>En el siguiente formulario usted podra cargar categorias al carrito</p>
</div>
<div id="formulario" style="width:54%;">
    <form action="admin/sql.php?t=cat" enctype="multipart/form-data" method="post" onsubmit="
        var descripcion=document.getElementById('descripcion');
        if(descripcion.value=='') {
            alert('Por favor ingrese una Descripción')
            descripcion.focus();
            return false;
        } " >
         Nombre: <input id="descripcion" name="descripcion" type="text" />&nbsp;&nbsp;
        <div class="upload">
            <input id="img-cat" name="img-cat" type="file" />
        </div>
        <input id="submit" name="submit" type="submit" value="Cargar">
    </form>
<br />
<?php
include_once($_SESSION["www"]."/sources/Funciones.php");
echo'<table id="tablas">
    <th>ID</th><th>Imag</th><th>'.reemplazarCaracteres("Nombre Categoría").'</th><th></th><th></th>';
    $resultados=datosCat();
    while($r=mysql_fetch_array($resultados)) {
        echo '<tr>
                <td width=5%>' .$r["idcategoria"].'</td>';
                if($_GET["edit"]==$r["idcategoria"]) {
                    echo '
                    <td width=14%>
                        <form action="admin/sql.php?t=cat" enctype="multipart/form-data" method="post">
                          <div class="upload" style="width:38px; height:30px; margin-left:0; clip:rect(0px, 50px, 30px, 0px ); background:url(images/upload2.gif) left top no-repeat;">
                            <input id="img-cat" name="img-cat" type="file" />
                          </div>
                    </td>
                    <td>
                        <input id="descripcion" name="descripcion" value="'.$r["descripcion"].'" type="text" />
                        <input id="idcategoria" name="idcategoria" type="hidden" value='.$r["idcategoria"].' />&nbsp;
                        <input cols=30 rows=6 id="submit" name="submit" type="submit" value="OK" />
                    </td></form>';
                }
                else
                    echo '
                    <td width="14%">
                        <a href=index.php?show=admin&m=cargar-cat&edit='.$r["idcategoria"].' Title="Editar Imagen" onclick=\'
                        \'><img src="/images/categorias/'.$r["idcategoria"].'.jpg?random=' . date("YmdHis") . '" width="100%" border=0 alt="Cambiar Imagen" /></a>
                    </td>
                    <td id="cat-'.$r["idcategoria"].'"><a style="color:#111" onclick=\'$("cat-'.$r["idcategoria"].'").update("<td width=\"14%\"><form action=\"admin/sql.php?t=cat\" enctype=\"multipart/form-data\" method=\"post\"><input id=\"descripcion\" name=\"descripcion\" value=\"'.$r["descripcion"].'\" type=\"text\" /><input cols=30 rows=6 id=\"submit\" name=\"submit\" type=\"submit\" value=\"OK\" /><input id=\"idcategoria\" name=\"idcategoria\" type=\"hidden\" value='.$r["idcategoria"].' /></form>");return false;\'>'.$r["descripcion"].'</a></td>';

                echo '
                    <td width=5%><a href=admin/sql.php?t=cat&idcategoria='.$r["idcategoria"].' Title="Eliminar Categoria"><img src="/images/delete.png" border=0 alt="Eliminar" /></a></td>
                    <td width=5%><a href=index.php?show=admin&m=cargar-cat&edit='.$r["idcategoria"].' Title="Editar Categoria"><img src="/images/edit.png" border=0 alt="Editar" /></a></td>
                </tr>';
    }
echo '</table>';
?>
</div>

