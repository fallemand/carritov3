<?php
session_start();
if($_SESSION["usuario"]!="admin") {
   header("location:".$url."/index.php?show=admin");
   exit();
 }
//include_once($_SESSION["www"]."\sources\class.Bd.php");
include_once($_SESSION["www"]."/sources/Funciones.php");
$bd=new Bd();
switch($_GET["t"]) {
  case "prod":
    include($_SESSION["www"]."/sources/class.Producto.php");
    $p=new Producto();
    $p->setNombre(addslashes($_POST["nombre"]));
    $p->setPrecio($_POST["precio"]);
    $p->setStock($_POST["stock"]);
    $p->setIdCategoria($_POST["idcategoria"]);
    $p->setDescripcion(addslashes($_POST["descripcion"]));

    if($_GET["idproducto"]==0 && $_POST["idproducto"]==0) {
       $p->guardar();
       for($i=0;$i<count($_FILES["img-prod"]);$i++) {
            $extension=pathinfo($_FILES["img-prod"]["name"][$i]);
            $move=move_uploaded_file($_FILES["img-prod"]["tmp_name"][$i],"../images/productos/temp/".$p->getIdProducto()."-".$i.".".$extension["extension"]);
       }
       crearImagenes($p->getIdProducto());
    }
    elseif($_SERVER["REQUEST_METHOD"]=="POST") {
      $p->setIdProducto($_POST["idproducto"]);
      for($i=0;$i<count($_FILES["img-prod"]);$i++) {
        $extension=pathinfo($_FILES["img-prod"]["name"][$i]);
        $move=move_uploaded_file($_FILES["img-prod"]["tmp_name"][$i],"../images/productos/temp/".$p->getIdProducto()."-".$i.".".$extension["extension"]);
      }
      crearImagenes($p->getIdProducto());
      $p->guardar();
    }
    elseif($_SERVER["REQUEST_METHOD"]=="GET") {
      $p->setIdProducto($_GET["idproducto"]);
      $p->eliminar();
      $imagenes=glob("../images/productos/".$p->getIdProducto()."*.*");
      for($i=0;$i<count($imagenes);$i++)
        @unlink($imagenes[$i]);
      header("location:../index.php?show=admin&m=listado-prod");
    }
    header("location:../index.php?show=admin&m=listado-prod&idcategoria={$p->getIdCategoria()}");
    break;

  case "cat":
    include($_SESSION["www"]."/sources/class.Categoria.php");
    $c=new Categoria();
    if($_GET["idcategoria"]==0 && $_POST["idcategoria"]==0) {
      $c->setDescripcion($_POST["descripcion"]);
      $c->guardar();
      $id=$c->getId();
      $extension=pathinfo($_FILES["img-cat"]["name"]);
      $move=move_uploaded_file($_FILES["img-cat"]["tmp_name"],"../images/categorias/temp/{$id}.{$extension["extension"]}");
      crearImagenCat($c->getId());
    }
    elseif($_SERVER["REQUEST_METHOD"]=="POST") {
      $c->setDescripcion($_POST["descripcion"]);
      $c->setId($_POST["idcategoria"]);
      $extension=pathinfo($_FILES["img-cat"]["name"]);
      $move=move_uploaded_file($_FILES["img-cat"]["tmp_name"],"../images/categorias/temp/{$c->getId()}.{$extension["extension"]}");
      crearImagenCat($c->getId());
      $c->guardar();
    }
    elseif($_SERVER["REQUEST_METHOD"]=="GET") {
      $c->setId($_GET["idcategoria"]);
      $c->eliminar();
      @unlink("../images/categorias/".$c->getId().".jpg");
    }
    header("location:../index.php?show=admin&m=cargar-cat");
    break;
}
$bd->__destruct();
?>