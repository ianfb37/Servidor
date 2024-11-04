

<?php
if(isset($_POST['boton'])){
    $validar=$_POST['boton'];
 switch($validar){
    case 'sum':
        $resul=$_POST['a']+$_POST['b'];
        echo $resul;
        echo "<br>";
    break;
    case 'rest':
        $resul=$_POST['a']-$_POST['b'];
        echo $resul;
        echo "<br>";
    break;
    case 'mult':
        $resul=$_POST['a']*$_POST['b'];
        echo $resul;
        echo "<br>";
    break;
    case 'divi':
        $resul=$_POST['a']/$_POST['b'];
        echo $resul;
        echo "<br>";
    break;
    default:
        echo"ha pasao algo";
 }
}
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="#" method="post">
            <label>
                <input type="number" name="a">
                A:
            </label><br>
            <label>
                <input type="number" name="b">
                B:
            </label><br>
        <button type="submit" name="boton" value="sum">Suma</button>
        <button type="submit" name="boton" value="rest">Resta</button>
        <button type="submit" name="boton" value="mult">Multiplicacion</button>
        <button type="submit" name="boton" value="divi">Division</button>
</form>
<?php
}
?>
</body>
</html>