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
            <div class="card z-depth-1" style="color:white;background-color:#2C323C">
                <h4>Blocked Sources</h4><br>
                <div class="container">
                        <?php
                            if(isset($_POST["submit-unblock"])){
                                $unblock = $_POST["unblock-request"];
                                echo "UNBLOCKED THE SOURCE - ".$unblock;
                                $DELETE = $unblock;
                                $data = file("blocked.txt");
                                $out = array();
                                foreach($data as $line) {
                                    if(trim($line)!=$DELETE) {
                                        $out[] = $line;
                                    }
                                }
                                $fp = fopen("blocked.txt", "w+");
                                flock($fp, LOCK_EX);
                                foreach($out as $line) {
                                    fwrite($fp, $line);
                                }
                                flock($fp, LOCK_UN);
                                fclose($fp);
                                echo 'sudo ufw allow from '.$unblock;
                                $script=shell_exec('sudo ufw allow from '.$unblock);

                                echo '<br>'.$script;
                            }
                            echo '<table class="striped" style="text-align:center;" >
                                <thead style="background-color:#e26161"><tr><th style="text-align:center;">Source Address</th><th style="text-align:center;">Unblock</th></tr></thead>';
                            $file="blocked.txt";
                            $handle = fopen($file, "r");
                            while(!feof($handle)){
                                $sourceAddress = fgets($handle);
                                if($sourceAddress!="")
                                    echo "<td style='text-align:center;'>".$sourceAddress."</td><td style='text-align:center;'><form action = './status.php' method='POST'><input hidden type='text' value=".$sourceAddress." name='unblock-request'><button type='submit' class='waves-effect waves-light btn' name='submit-unblock'>Unblock</button></form></td></tr>";
                            }
                            fclose($handle);

                        ?>
                    </table>
                </div>
            </div>
        </div>

        <footer style="background-color:#3a4556;box-shadow: 20px 20px 20px 20px rgba(0, 0, 0, 0.3);">
            <div class="container" style="color:white;">
                <div class="row">
                    <a href="display.php" style="display:block;color:white;"><div id="homeSelector" class="col s3 m1 l1 center" style="padding:14px;">Home</div></a>
                    <a href="status.php" style="display:block;color:white;"><div id="statusSelector" class="col s3 m1 l1 center" style="padding:14px;">Status</div></a>
                    <a href="source-comparison.php" style="display:block;color:white;"><div id="scSelector" class="col s3 m1 l3" style="padding:14px;">Source Comparison</div></a>
                    <div class="right" style="padding:14px;color:"><a href="logout.php">Logout</a></div>
                </div>
            </div>
        </footer>

        <script>
            document.getElementById("statusSelector").style.background="#26a69a";
        </script>

</body>
</html>