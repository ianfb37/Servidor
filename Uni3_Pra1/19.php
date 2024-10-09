<?php
$animal= array("Lagartija","Araña","Perro","Gato","Raton");
$años= array("12","34"."45","52","12");
$nombres=array("Sauce","Pino","Naranjo","Chopo","Perro","34");
$union=array();
array_push($union, $animal,$años,$nombres);
//$reversed da la vuelta a un array
$reversed = array_reverse($union);
$preserved = array_reverse($union, true);

print_r($reversed);

?>