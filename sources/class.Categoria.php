<?php
class Categoria extends Bd {
  private $id=0;
  private $descripcion="";
      function __construct($id=0) {
        parent::__construct();
        if($id>0) {
          $sql="SELECT * FROM categorias WHERE idcategoria=%d";
          $sql=sprintf($sql,$id);
          $resultados=parent::ejecutar($sql);
          $r=parent::retornarFila($resultados);
          $this->id=$r["idcategoria"];
          $this->descripcion=$r["descripcion"];
        }
      }
      function setId($id) {
        $this->id=$id;
      }
      function setDescripcion($descripcion) {
        $this->descripcion=$descripcion;
      }
      function getId() {
        return $this->id;
      }
      function getDescripcion() {
        return $this->descripcion;
      }
      function eliminar() {
        $sql="DELETE FROM categorias WHERE idcategoria=%d";
        $sql=sprintf($sql,$this->id);
        parent::ejecutar($sql);
      }
      function guardar() {
        if($this->id==0) {
          $sql="INSERT INTO categorias(descripcion) VALUE(\"%s\")";
          $sql=sprintf($sql, $this->descripcion);
        }
        else {
          $sql="UPDATE categorias SET descripcion=\"%s\" WHERE idcategoria=%d";
          $sql = sprintf($sql, $this->descripcion, $this->id);
        }
        $this->id=parent::ejecutar($sql);
      }
}
?>