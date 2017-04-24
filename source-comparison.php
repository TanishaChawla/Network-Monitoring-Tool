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
            }
            ?>
            </div>
        </div>

        <footer style="background-color:#3a4556;box-shadow: 20px 20px 20px 20px rgba(0, 0, 0, 0.3);">
            <div class="container" style="color:white;">
                <div class="row">
                    <a href="display.php" style="display:block;color:white;"><div id="homeSelector" class="col s3 m1 l1 center" style="padding:14px;">Home</div></a>
                    <a href="status.php" style="display:block;color:white;"><div id="statusSelector" class="col s3 m1 l1 center" style="padding:14px;">Status</div></a>
                    <a href="source-comparison.php" style="display:block;color:white;"><div id="scSelector" class="col s3 m2 l1" style="padding:14px;">Comparison</div></a>
                    <a href="real-time.php" style="display:block;color:white;"><div id="rtSelector" class="col s3 m2 l2" style="padding:14px;">Realtime Analysis</div></a>
                    <div class="right" style="padding:14px;color:"><a href="logout.php">Logout</a></div>
                </div>
            </div>
        </footer>

        <script>
            document.getElementById("scSelector").style.background="#26a69a";
        </script>

</body>
</html>