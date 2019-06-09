<?php

$url = '';
$db = '';
$login = '';
$password = '';

try{
    $bdd = new PDO('mysql:host='.$url.';dbname='.$db.';charset=utf8', $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}

?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>

<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,500" rel="stylesheet"/>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

<link href="css.css" rel="stylesheet"/>;

<div class="row">
<div class="container">

  <table class="table responsive" id="sort">
        <thead>
                <tr>
                        <th scope="col">Pseudo</th>
                        <th scope="col">Kills</th>
                        <th scope="col">Deaths</th>
                        <th scope="col">Assists</th>
                        <th scope="col">Headshot</th>
                        <th scope="col">KDR</th>
                        <th scope="col">% HS</th>
                </tr>
        </thead>
        <tbody>
        <?php
        $getallstats = $bdd->query('SELECT steam_id, sum(kills) as kills, sum(deaths) as deaths, sum(assists) as assists, sum(headshot_kills) as headshot_kills FROM `player_stats` group by `steam_id` ');
        while($stats = $getallstats->fetch(PDO::FETCH_OBJ))
        {
            $getname = $bdd->prepare('SELECT name FROM `player_stats` WHERE `steam_id` = ? ');
            $getname->execute(array($stats->steam_id));
            $name = $getname->fetch(PDO::FETCH_OBJ);
            $KDR = $stats->kills/$stats->deaths;
            $hs = $stats->headshot_kills*100/$stats->kills;
            $KDR = number_format($KDR,2);
            $hs = number_format($hs,0)
        ?>
                <tr>
                        <td data-table-header="Pseudo"><?=$name->name;?> (<a href="http://steamcommunity.com/profiles/<?=$stats->steam_id;?>">Steam</a>)</td>
                        <td data-table-header="Kills"><?=$stats->kills;?></td>
                        <td data-table-header="Deaths"><?=$stats->deaths;?></td>
                        <td data-table-header="Assists"><?=$stats->assists;?></td>
                        <td data-table-header="Headshot"><?=$stats->headshot_kills;?></td>
                        <td data-table-header="KDR"><?=$KDR;?></td>
                        <td data-table-header="% HS"><?=$hs;?> %</td>
                </tr>
        <?php } ?>
         </tbody>
</table>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/stringMonthYear.js"></script>
<script src="js.js"></script>
