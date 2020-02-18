<?php
 include("pdo.php");
 $id = '';
 $serie = '';
 $cantEpisodios = '';
 try 
{
  if(isset($_GET["id"]))
  {
    $id = $_GET["id"];
    $bd-> beginTransaction();
    $consulta = $bd->prepare("select s.title, se.number temporada, e.number episodio, se.title nombre_temp,e.title nombre_epi from series s
    inner join seasons se on se.serie_id = s.id 
    inner join episodes e on e.season_id = se.id
    where s.id = ?");
    $consulta-> bindValue("1",$id);
    $consulta -> execute();
    $serie = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    $cantEpisodios = $consulta -> rowCount();
    $bd -> commit();
    $temp[0] = $serie[0]["nombre_temp"];
    $temp_2 = [];
    for($i = 1 ; $i < count($serie);$i++)
    {
        $bandera = false;
        for($j = 0; $j<count($temp);$j++)
        {
            if($temp[$j] == $serie[$i]["nombre_temp"])
            {
                $bandera = true;
            }
        }
        if(!$bandera)
        {
            $temp[count($temp)] = $serie[$i]["nombre_temp"];
        }

    }
    for($i = 0; $i < count($serie);$i++)
    {
       
        for($j = 0; $j<count($temp);$j++)
        {
            if($temp[$j] == $serie[$i]["nombre_temp"])
            {
                $temp_2[$temp[$j]][$serie[$i]["episodio"]] = $serie[$i]["nombre_epi"]; 
            break;
            }
        }
    }
  }
} catch(PDOEXCEPTION $e)
{
    echo $e->getMessage();
    $bd-> rollback();
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
     <div>
          <h1>
            <?= $serie[0]["title"] ?>
          </h1>
           <h2>
            <?= "Cantidad de episodios: $cantEpisodios" ?>
           </h2>
             <ul>
             <?php foreach($temp_2 as $dir=>$cap) : ?>
              <li>

              <?= $dir ?>
               <?php foreach($cap as $dir2=> $cap2) : ?>
                    <ul>
                        <li>
                            <?= $dir2.":".$cap2?>
                        </li>
                    </ul>
                <?php endforeach;?>
              </li>

              <?php endforeach ; ?>
             </ul>
        
     </div> 
</body>
</html>