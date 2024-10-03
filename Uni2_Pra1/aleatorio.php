
<?php
$x = rand(1, 100);
$y = rand(1, 100);
$mayor=0;

if($x>$mayor){
    $x=$mayor;

}
else{
    if($y>$mayor){
        $y=$mayor;
    }
}
if($mayor%2==0){
    echo "El numero $mayor es par "
}
else
echo "El numero $mayor es impar "
?>