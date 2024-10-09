<?php
$ciudades=array("MD"=>"Madrid","BC"=>"Barcelona", 
"LD"=>"Londres","NY"=>"New York",
"LA"=>"Los Ángeles","CH"=>"Chicago");
foreach ($ciudades as $raza => $nombre) {
    echo "  $raza => $nombre\n";
    echo "<br>";
}
?>