<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NMT</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css" media="screen,projection" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
            .card{
                padding: 5%;
            }
            [type="radio"]:not(:checked), [type="radio"]:checked {
                position: relative;
                left: 0px;
                visibility: visible;
            }select {
                display: block;
            }
            .logout{
                position: fixed;
                top: 10px;
                right: 10px;
            }
            h4{
                font-family:'Open Sans',sans-serif;
            }
            .loader {
                border: 2px solid #232830;
                border-top: 2px solid #26a69a;
                border-radius: 100%;
                width: 25px;
                height: 25px;
                animation: spin 2s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            footer{
                margin-bottom: 0;
                bottom: 0;
                position: fixed;
                width: 100%;
                height: 50px;
                z-index: 2;
            }
            table{
                background-color:#2C323C;
                color:white;
            }
            .striped>tbody>tr:nth-child(odd)>td, 
            .striped>tbody>tr:nth-child(odd)>th {
                background-color: #353c48;
            }

        </style>
</head>
<body style="background-color:#232830">
        
        <h2 class="center" style="color:white;">Network Monitoring Tool</h2>
        <div class="container center" style="color:white;">
            <h4>Monitoring Packets</h4><br>
            <form method="post" action="" class="card z-depth-1" style="background-color:#2C323C">
                <label>Number of packets to be captured</label><br>
                <input type="number" name="packet_count" value="1000"><br>
                <button class="waves-effect waves-light btn" type="submit" name="submit-before">Submit</button>
                <div class="center" style="padding-top:25px;text-align:center"><div id="loading" class="loader" style="display: inline-block;"></div></div>
            </form>

            <div class="card z-depth-1" style="background-color:#2C323C">

            <?php
            if(isset($_POST["submit-block"]))
            {
                $block = $_POST["block-request"];
                echo "BLOCKED THE SOURCE - ".$block;
                $blocked=fopen("blocked.txt","a+");
                fwrite($blocked,$block."\n");
                fclose($blocked);
                $script=shell_exec('sudo ufw deny from '.$block);
                echo '<br>'.$script;
                echo '<br>To unblock visit <a href="status.php">This</a> page.';
            }
            if(isset($_POST["submit-before"]))
            {
                echo '<table class="striped"><thead style="background-color:#e26161"><tr><th>Source Address</th><th>Number of Packets</th><th>Block</th></tr></thead>';
               $count = $_POST["packet_count"];
               $script=shell_exec('sudo ./script.sh '.$count);
               $sources=array();
               $noofpackets=array();
               $file="files/tcp_srcadd";
               $handleAddress = fopen($file, "r");
               while(!feof($handleAddress)){
                   $line = fgets($handleAddress);
                   if(in_array($line,$sources)){
                       $pos = array_search($line,$sources);
                       $noofpackets[$pos]++;
                   }
                   else{
                       array_push($sources,$line);
                       array_push($noofpackets,1);
                   }
               }
               fclose($handle);
               $file="files/tcp_srcadd";
               $handleAddress = fopen($file, "r");
               while(!feof($handleAddress)){
                   $line = fgets($handleAddress);
                   if($line=="")break;
                   if(in_array($line,$sources)){
                       $pos = array_search($line,$sources);
                       $noofpackets[$pos]++;
                   }
                   else{
                       array_push($sources,$line);
                       array_push($noofpackets,1);
                   }
               }
               fclose($handle);
               $file="files/udp_srcadd";
               $handleAddress = fopen($file, "r");
               while(!feof($handleAddress)){
                   $line = fgets($handleAddress);
                   if($line=="")break;
                   if(in_array($line,$sources)){
                       $pos = array_search($line,$sources);
                       $noofpackets[$pos]++;
                   }
                   else{
                       array_push($sources,$line);
                       array_push($noofpackets,1);
                   }
               }
               fclose($handle);
               $file="files/arp_srcadd";
               $handleAddress = fopen($file, "r");
               while(!feof($handleAddress)){
                   $line = fgets($handleAddress);
                   if($line=="")break;
                   if(in_array($line,$sources)){
                       $pos = array_search($line,$sources);
                       $noofpackets[$pos]++;
                   }
                   else{
                       array_push($sources,$line);
                       array_push($noofpackets,1);
                   }
               }
               fclose($handle);
               for($i = 0; $i < sizeof($sources); $i++) {
                   for($j=0;$j<sizeof($sources);$j++){
                       if($noofpackets[$i]>$noofpackets[$j]){
                           $tempN= $noofpackets[$i];
                           $noofpackets[$i] = $noofpackets[$j];
                           $noofpackets[$j] = $tempN;
                           $tempA = $sources[$i];
                           $sources[$i] = $sources[$j];
                           $sources[$j] = $tempA; 
                       }
                   }
                }
                for($x=0;$x<sizeof($sources);$x++){
                    $form = "<td><form action = '' method='POST'><input hidden type='text' value=".$sources[$x]." name='block-request'><button type='submit' class='waves-effect waves-light btn' name='submit-block'>X</button></form></td></tr>";
                    if($sources[$x]!=""){echo "<tr><td>".$sources[$x]."</td><td>".$noofpackets[$x]."</td>".$form;}
                }
                echo '</table>';
                echo '<script>document.getElementById("loading").style.display="none";</script>';
                echo '
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load("current", {"packages":["corechart"]});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn("string", "Topping");
        data.addColumn("number", "Slices");
        data.addRows([
          ["'.rtrim($sources[0]).'",'.$noofpackets[0].'],
          ["'.rtrim($sources[1]).'",'.$noofpackets[1].'],
          ["'.rtrim($sources[2]).'",'.$noofpackets[2].'],
          ["'.rtrim($sources[3]).'",'.$noofpackets[3].'],
          ["'.rtrim($sources[4]).'",'.$noofpackets[4].'],
          ["'.rtrim($sources[5]).'",'.$noofpackets[5].'],
          ["'.rtrim($sources[6]).'",'.$noofpackets[6].'],
          ["'.rtrim($sources[7]).'",'.$noofpackets[7].'],
          ["'.rtrim($sources[8]).'",'.$noofpackets[8].'],
          ["'.rtrim($sources[9]).'",'.$noofpackets[9].']
        ]);

        // Set chart options
        var options = {"title":"Source Comparison",
                       "width":800,
                       "height":800,
                       "backgroundColor": "#232830",
                       "is3D":true,
                       "textColor": "#e1e1e1",
                       "color": "#e1e1e1",
                       "titleTextStyle": {
                            "color": "#e1e1e1"
                        },
                        "hAxis": {
                            "textStyle": {
                                "color": "#e1e1e1"
                            },
                            "titleTextStyle": {
                                "color": "#e1e1e1"
                            }
                        },
                        "vAxis": {
                            "textStyle": {
                                "color": "#e1e1e1"
                            },
                            "titleTextStyle": {
                                "color": "#e1e1e1"
                            }
                        },
                        "legend": {
                            "textStyle": {
                                "color": "#e1e1e1"
                            }
                        }
                    };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById("chart_div"));
        chart.draw(data, options);
      } 
    </script>';
            }
            ?>
            </div>
        </div>

        <div class="container"><div id="chart_div" class="offset-s2" style="background-color:#232830;color:white;"></div></div>

        <footer style="background-color:#3a4556;box-shadow: 20px 20px 20px 20px rgba(0, 0, 0, 0.3);">
            <div class="container" style="color:white;">
                <div class="row">
                    <a href="display.php" style="display:block;color:white;"><div id="homeSelector" class="col s3 m1 l1 center" style="padding:14px;">Home</div></a>
                    <a href="status.php" style="display:block;color:white;"><div id="statusSelector" class="col s3 m1 l1 center" style="padding:14px;">Status</div></a>
                    <a href="source-comparison.php" style="display:block;color:white;"><div id="scSelector" class="col s3 m2 l1" style="padding:14px;">Comparison</div></a>
                    <div class="right" style="padding:14px;color:"><a href="logout.php">Logout</a></div>
                </div>
            </div>
        </footer>

        <script>
            document.getElementById("scSelector").style.background="#26a69a";
        </script>

</body>
</html>