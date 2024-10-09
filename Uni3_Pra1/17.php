<?php
$animal= array("Lagartija","Araña","Perro","Gato","Raton");
$años= array("12","34"."45","52","12");
$nombres=array("Sauce","Pino","Naranjo","Chopo","Perro","34");
$result = array_merge($animal, $años,$nombres);
print_r($result);
?>