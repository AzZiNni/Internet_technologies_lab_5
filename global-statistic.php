<?php

    require "ui-components.php";
    require "database/config.php";
    require "utils.php";

    require "parts/head.html";
?>

<main role="main">
    <div class="container">
        <?php print_header();?>
        <div class="row">
            <div class="col-md-8">
                <form action="global-statistic.php" method="POST">

            <p>
                <label for="date">Дата 1: </label>
                <input type="date" id="date1" name="date_1" />
            </p>
           
            <p>
                <label for="date">Дата 2: </label>
                <input type="date" id="date2" name="date_2" />
            </p>
            <p>
                <button type="submit">Отправить</button>
            </p>
                </form>
                <?php 
                if(isset($_POST['date_1']) and isset($_POST['date_2']) ){ 
                    if($_POST['date_1'] != "" and $_POST['date_2'] != "")
                    {
                        
                        echo "<table class='table table-success table-bordered border-primary'>
                        <tr>
                            <td> Stop_time </td> 
                            <td> Start_time </td>
                            <td> In_traffic </td>
                            <td> Out_traffic </td>
                            <td> Client_name </td>
                            <td> IP </td>
                        </tr>
                        ";
                        try{
                            $stmt = $pdo->prepare("SELECT `start`, `stop`, `in_traffic`, `out_traffic`, `name`, `IP` FROM SEANSE AS a INNER JOIN `client` AS b ON a.client_id = b.id WHERE date(a.start) >? and date(a.stop)<?");
                            $l_values = [
                                $_POST['date_1'],
                                $_POST['date_2']
                            ];
                            
                            $result = $stmt->execute($l_values);
                            $statistic = $stmt ->fetchAll(PDO::FETCH_ASSOC);
                        }catch (PDOException $e){
                            echo "<p class='text-danger text-center'><b>Error!: " . $e->getMessage() . "</b></p><br/>"; die();
                        }
                        foreach ($statistic as $stat){
                            echo " <tr>
                            <td>  {$stat['start']}  </td> 
                            <td>  {$stat['stop']}  </td> 
                            <td>  {$stat['in_traffic']}  </td> 
                            <td>  {$stat['out_traffic']}  </td> 
                            <td>  {$stat['name']}  </td> 
                            <td>  {$stat['IP']}  </td> 
                            </tr>";
                            
                        }
                    }
                    else{
                        echo "<p class='text-warning '> Введите дату наконец-то </p>";
                    }
                }
               
               
                ?>
                </table>
            </div>
        </div>
        
    </div>
</main>

<?php require "parts/tail.html";
/* SELECT a.start, a.stop, a.in_traffic, a.out_traffic, b.name, b.IP FROM SEANSE AS a INNER JOIN client AS b ON a.client_id = b.id WHERE date(a.start) >"2022-03-06 10:00:00" and date(a.stop)<"2022-03-20 10:00:00" */