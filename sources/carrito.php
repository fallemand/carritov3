<?php
    session_start();
    include_once($_SESSION["www"]."/sources/class.Bd.php");
    include_once($_SESSION["www"]."/sources/class.Producto.php");
    for($i=0;$i<count($_SESSION["carrito"]);$i++){
      if($_SESSION["carrito"][$i]["idproducto"]==$_GET["idproducto"]) {
        $_SESSION["carrito"][$i]["cantidad"]++;
        $encontrado=true;
        break;
      }
    }
    if(!$encontrado) {
      $p= new Producto($_GET["idproducto"]);
      $_SESSION["carrito"][]=array(
                                    "idproducto"=>$p->getIdProducto(),
                                    "cantidad"=>1,
                                    "precio"=>$p->getPrecio(),
                                    "nombre"=>$p->getNombre()
                                    );
      }
      $_SESSION["unidades"]++;
      echo $_SESSION["unidades"];            
?>