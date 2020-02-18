<?php
    include("pdo.php");
    $series = '';
    try
    {
        $bd->beginTransaction();
        $consulta = $bd->prepare("select * from series");
        $consulta ->execute();
        $series = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        $bd->commit();
    } catch(PDOEXCEPTION $e)
    {
        echo $e->getMessage();
        $bd->rollback();
        exit;
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
     <ul>
      <?php foreach($series as $serie) : ?>
      <li>
         <a href="serie.php?id=<?=$serie['id']?>">
         <?= $serie['title'] ?>
         </a>
      </li>
      <?php endforeach ; ?>
     </ul>

</body>
</html>