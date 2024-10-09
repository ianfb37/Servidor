<?php
$num= array( 5=>1, 12=>2, 13=>56, "x"=>42);
$cont=0;
foreach ($num as $raza => $nombre) {
    $cont++;

    }
    unset($num[5]);
    foreach ($num as $raza => $nombre) {
        echo "$raza=> $nombre =>";
    
        }
    
?>
