<?php
class Bd {
  private $servidor="localhost";
  private $usuario="admin_carritov3";
  private $clave="secreto369258";
  private $base="admin_carritov3";
  private $link;

  function __construct() {
    $this->link=mysql_connect($this->servidor,$this->usuario,$this->clave);
    mysql_select_db($this->base,$this->link);
  }
  function ejecutar($sql) {
    $resultado=mysql_query($sql);
    if(strpos(strtoupper($sql),"INSERT INTO")!==false)
      $resultado=mysql_insert_id();
    elseif(strpos(strtoupper($sql),"DELETE")!==false or strpos(strtoupper($sql),"UPDATE")!==false)
      $resultado=mysql_affected_rows();
    return $resultado;
  }
  function retornarFila($resultado) {
    return mysql_fetch_array($resultado);
  }
  function __destruct() {
    @mysql_close($this->link);
  }
}
?>