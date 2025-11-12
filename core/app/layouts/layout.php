<h3>Tienda Principal</h3>

<?php
  $datos = UserData::vercontenido();
  foreach($datos as $dato){
    echo "<p>Negocio: ".$dato->negocio."</p>";
    echo "<hr>";
  }
?>