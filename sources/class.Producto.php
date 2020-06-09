<?php
class Producto extends Bd {
  private $idproducto=0;
  private $idcategoria=0;
  private $nombre="";
  private $stock=0;
  private $precio=0;
  private $descripcion="";

  function __construct($idproducto=0) {
    parent::__construct();
    if($idproducto>0) {
      $sql="SELECT * FROM productos WHERE idproducto=%d";
      $sql=sprintf($sql,$idproducto);
      $resultados=parent::ejecutar($sql);
      $r=parent::retornarFila($resultados);
      $this->idproducto=$r["idproducto"];
      $this->idcategoria=$r["idcategoria"];
      $this->nombre=$r["nombre"];
      $this->stock=$r["stock"];
      $this->precio=$r["precio"];
      $this->descripcion=$r["descripcion"];
    }
  }
  function setIdProducto($idproducto) {
    $this->idproducto=$idproducto;
  }
  function setIdCategoria($idcategoria) {
    $this->idcategoria=$idcategoria;
  }
  function setNombre($nombre) {
    $this->nombre=$nombre;
  }
  function setStock($stock) {
    $this->stock=$stock;
  }
  function setPrecio($precio) {
    $this->precio=$precio;
  }
  function setDescripcion($descripcion) {
    $this->descripcion=$descripcion;
  }
  function getIdProducto() {
    return $this->idproducto;
  }
  function getIdCategoria() {
    return $this->idcategoria;
  }
  function getNombre() {
    return $this->nombre;
  }
  function getStock() {
    return $this->stock;
  }
  function getPrecio() {
    return $this->precio;
  }
  function getDescripcion() {
    return $this->descripcion;
  }
  function guardar() {
    if($this->idproducto==0) {
      $sql="INSERT INTO productos(idcategoria, nombre, stock, precio, descripcion) VALUES(%d,\"%s\",%d,%d,\"%s\")";
      $sql=sprintf($sql,$this->idcategoria,$this->nombre,$this->stock,$this->precio,$this->descripcion);
    }
    else {
      $sql="UPDATE productos SET idcategoria=%d,nombre=\"%s\",stock=%d,precio=%d,descripcion=\"%s\" WHERE idproducto=%d";
      $sql=sprintf($sql,$this->idcategoria,$this->nombre,$this->stock,$this->precio,$this->descripcion,$this->idproducto);
    }
    $this->idproducto=parent::ejecutar($sql);
  }
  function eliminar() {
    $sql="DELETE FROM productos WHERE idproducto=%d";
    $sql=sprintf($sql,$this->idproducto);
    parent::ejecutar($sql);
  }
}
?>