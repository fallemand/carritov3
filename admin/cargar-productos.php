<?php
session_start();
 if($_SESSION["usuario"]!="admin") {
   header("location:/index.php?show=admin");
   exit();
 }
?>
<script type="text/javascript" src="../sources/frameworks/SimpleTextEditor.js"></script>
<link rel="stylesheet" type="text/css" href="../estilo.css"/>
<script type="text/javascript">
        var ste = new SimpleTextEditor("descripcion", "ste");
        ste.init();
</script>
<div id="big-bold">
  <h1 class="big-bold">Cargar/Editar Productos</h1>
  <p>En el siguiente formulario usted podra cargar o editar productos</p>
</div>
<div id="formulario">
    <form action="admin/sql.php?t=prod" enctype="multipart/form-data" method="post" onsubmit="
        var nombre=document.getElementById('nombre');
        var precio=document.getElementById('precio');
        var stock=document.getElementById('stock');
        var descripcion=document.getElementById('descripcion');
        if(nombre.value=='') {
            alert('Por favor ingrese el nombre!')
            nombre.focus();
            return false;
        }
        if(precio.value=='') {
            alert('Por favor ingrese el precio!')
            precio.focus();
            return false;
        }
        if(stock.value=='') {
            alert('Por favor ingrese el stock!')
            stock.focus();
            return false;
        }
        if(idcategoria.options.lenght==0) {
            alert('Por favor seleccione una categoria!')
            idcategoria.focus();
            return false;
        }
        if(descripcion.value=='') {
            alert('Por favor ingrese una descripción!')
            descripcion.focus();
            return false;
        }">
        <?php
        include_once($_SESSION["www"]."/sources/Funciones.php");
        if(isset($_GET["idproducto"])) {
            $idproducto=$_GET["idproducto"];
            $resultados=datosProdyCat($idproducto,0);
            $r=mysql_fetch_array($resultados);
        }
        echo reemplazarCaracteres('
        Nombre: &nbsp;&nbsp;&nbsp;<input id="nombre" name="nombre" type="text" value="'.$r["nombre"].'" /><br /><br />
        Precio:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="precio" name="precio" type="text" value="'.$r["precio"].'" /><br /><br />
        Stock: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="stock" name="stock" type="text" value="'.$r["stock"].'" /><br /><br />
        Categoria: &nbsp;&nbsp;<select id="idcategoria" name="idcategoria">
            '.comboCat($r["idcategoria"]).'
        </select>  <br /><br />
        <div class="upload" style="margin-left:5px;"><input type="file" name="img-prod[]" id="img-prod" /></div>
        <div class="upload" style="margin-left:1px;"><input type="file" name="img-prod[]" id="img-prod" /></div>
        <div class="upload" style="margin-left:1px;"><input type="file" name="img-prod[]" id="img-prod" /></div>
        <div class="upload" style="margin-left:1px;"><input type="file" name="img-prod[]" id="img-prod" /></div>
        <div class="upload" style="margin-left:1px;"><input type="file" name="img-prod[]" id="img-prod" /></div>
        <br /><br />
        Descripcion<br /><textarea name="descripcion" id="descripcion" rows="10" cols="40">'.$r["descripcion"].'</textarea><br /><br />
        <input type="hidden" name="idproducto" id="idproducto" value="'.$idproducto.'"/>
        <input cols=30 rows=6 id="submit" name="submit" type="submit" onclick="ste.submit();">');
         ?>
    </form>
</div>
