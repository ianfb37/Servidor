<?php
$pares = [];

for ($i = 1; $i <= 9; $i++) {
    for ($j = 1; $j <= 9; $j++) {
        if ($i != $j) {
            $pares[] = [$i, $j];
        }
    }
}

// Imprimir los pares
foreach ($pares as $par) {
    echo "(" . $par[0] . ", " . $par[1] . ")\n";
}
?>