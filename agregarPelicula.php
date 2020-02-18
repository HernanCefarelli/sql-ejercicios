<?php
    include("pdo.php");
    $generos = '';
    $titulo = '';
    $rating = '';
    $premios = '';
    $lanzamiento= '';
    $duracion= '';
    $genero = '';

    try
    {
        $bd->beginTransaction();
        $consulta = $bd->prepare("select * from genres");
        $consulta ->execute();
        $generos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        $bd->commit();
    } catch(PDOEXCEPTION $e)
    {
        echo $e->getMessage();
        $bd->rollback();
        exit;
    }

    if($_POST)
    {
        $titulo = $_POST["titulo"];
        $rating = $_POST["rating"];
        $premios = $_POST["premios"];
        $lanzamiento = $_POST["lanzamiento"];
        $duracion = $_POST["duracion"];
        $genero = $_POST["genero"];
 if(strlen($titulo)!=0 && is_float($rating) && is_int($premios)!=0 && strlen($lanzamiento)!=0 && is_int($duracion)!=0)
 {
    try
    {
        $bd->beginTransaction();
        $consulta = $bd -> prepare("insert into movies(title,rating,awards,release_date,length,genre_id) values(?,?,?,?,?,?)");
        $consulta -> bindValue("1",$titulo);
        $consulta -> bindValue("2",$rating);
        $consulta -> bindValue("3",$premios);
        $consulta -> bindValue("4",$lanzamiento);
        $consulta -> bindValue("5",$duracion);
        $consulta -> bindValue("6",$genero);
        $consulta -> execute();
        $bd->commit();

    } catch(PDOEXCEPTION $e)
    {
        echo "Error al insert una nueva pelicula $e->getMessage()";
        $bd->rollback();
        exit;
    }
}
 }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <form action="agregarPelicula.php" method = "POST">
        <input type="text" name = "titulo" placeholder = "Titulo" value="<?=$titulo ?>">
        <br>
        <input type="text" name = "rating" placeholder = "Rating" value="<?=$rating ?>">
        <br>
        <input type="text" name = "premios" placeholder = "Premios" value="<?=$premios ?>">
        <br>
        <input type="text" name = "lanzamiento" placeholder = "Fecha de lanzamiento" value="<?=$lanzamiento ?>">
        <br>
        <input type="text" name = "duracion" placeholder = "Duracion" value="<?=$duracion ?>">
        <br>
        <select name="genero" id="genero">
         <?php foreach($generos as $genero) : ?>
            <option value="<?=$genero['id'] ?>">
                <?= $genero["name"] ?>
            </option>
         <?php endforeach;?>
        </select>
        <br>
        <button type="submit">Agregar</button>
     </form>
</body>
</html>