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
                <input type="number" name="packet_count" value="10"><br>
                <button class="waves-effect waves-light btn" type="submit" name="submit-before">Submit</button>
                <div class="center" style="padding-top:25px;text-align:center"><div id="loading" class="loader" style="display: inline-block;"></div></div>
           <?php
           function countCalc(){
               echo '<br><h5>Captured Packets</h5>';
               echo '<table style="background-color:#e26161"class="center z-depth-1"><tr>';
               $file="files/tcp";
               $linecount = -1;
               $handle = fopen($file, "r");
               while(!feof($handle)){
                   $line = fgets($handle);
                   $linecount++;
               }
               fclose($handle);
               echo '<td style="text-align:center"><strong>TCP: '.$linecount.'</strong></td>';

               $file="files/udp";
               $linecount = -1;
               $handle = fopen($file, "r");
               while(!feof($handle)){
                   $line = fgets($handle);
                   $linecount++;
               }
               fclose($handle);
               echo '<td style="text-align:center"><strong>UDP: '.$linecount.'</strong></td>';

               $file="files/arp";
               $linecount = -1;
               $handle = fopen($file, "r");
               while(!feof($handle)){
                   $line = fgets($handle);
                   $linecount++;
               }
               fclose($handle);
               echo '<td style="text-align:center"><strong>ADP: '.$linecount.'</strong></td>';
               echo '</tr></table>';
               echo '</form>';
           }
           
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
               $count = $_POST["packet_count"];
               $script=shell_exec('sudo ./script.sh '.$count);
               echo $script;
               countCalc();
               echo '<div id="formPacketType">
                <h4>Select the type of Packet</h4>
                <form method="post" action="" class="card z-depth-1" style="background-color:#2C323C">
                    <div class="row">
                        <div class="col s6 m6 l6">
                            <input type="radio" name="packet" value="TCP" onclick="change" style="margin:30px;"> TCP
                            <input type="radio" name="packet" value="UDP" onclick="change" style="margin:30px;"> UDP
                            <input type="radio" name="packet" value="ARP" onclick="change" style="margin:30px;"> ARP
                        </div>
                    <div>
                    <br>
                    <div class="row">
                        <div class="col s6 m6 l6">
                            <select name="dropdown" style="background-color:#2C323C">
                                <option value="timestamp">Timestamp</option>
                                <option value="sourceaddress">Source Address</option>
                                <option value="destinationaddress">Destination Address</option>
                                <option value="sourceport">Source Port</option>
                                <option value="destinationport">Destination Port</option>
                                <option value="sourcemac">Source MAC</option>
                                <option value="destinationmac">Destination MAC</option>
                                <option value="length">Length</option>
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                    <button class="waves-effect waves-light btn" type="submit" name="submit">Submit</button>
                </form>
                </div>
                </div>
                </div>
                <script>document.getElementById("loading").style.display="none";</script>';
               
           }
           if(isset($_POST["submit"]))
           {
                $value=$_POST["packet"];
                $selected=$_POST["dropdown"];
                echo "<br><br>";
                if($value=="TCP")
                {
                    echo "<h5>TCP</h5><br>";
                    if($selected=="timestamp")
                    {
                        $time=fopen("files/tcp_time","r");
                        while(!feof($time))
                        {
                            echo fgets($time)."<br>";
                        }
                        fclose($time);
                    }
                    if($selected=="sourceaddress")
                    {
                        $srcadd=fopen("files/tcp_srcadd","r");
                        while(!feof($srcadd))
                        {
                            echo fgets($srcadd)."<br>";
                        }
                        fclose($srcadd);
                    }
                    if($selected=="destinationaddress")
                    {
                        $dstadd=fopen("files/tcp_dstadd","r");
                        while(!feof($dstadd))
                        {
                            echo fgets($dstadd)."<br>";
                        }
                        fclose($dstadd);
                    }
                    if($selected=="length")
                    {
                        $length=fopen("files/tcp_length","r");
                        while(!feof($length))
                        {
                            echo fgets($length)."<br>";
                        }
                        fclose($length);
                    }
                    if($selected=="sourceport")
                    {
                        $srcport=fopen("files/tcp_srcport","r");
                        while(!feof($srcport))
                        {
                            echo fgets($srcport)."<br>";
                        }
                        fclose($srcport);
                    }
                    if($selected=="destinationport")
                    {
                        $dstport=fopen("files/tcp_dstport","r");
                        while(!feof($dstport))
                        {
                            echo fgets($dstport)."<br>";
                        }
                        fclose($dstport);
                    }
                    if($selected=="sourcemac")
                    {
                        $srcmac=fopen("files/tcp_srcmac","r");
                        while(!feof($srcmac))
                        {
                            echo fgets($srcmac)."<br>";
                        }
                        fclose($srcmac);
                    }
                    if($selected=="destinationmac")
                    {
                        $dstmac=fopen("files/tcp_dstmac","r");
                        while(!feof($dstmac))
                        {
                            echo fgets($dstmac)."<br>";
                        }
                        fclose($dstmac);
                    }
                    if($selected=="all")
                    {
                        $time=fopen("files/tcp_time","r");
                        $srcadd=fopen("files/tcp_srcadd","r");
                        $dstadd=fopen("files/tcp_dstadd","r");
                        $srcport=fopen("files/tcp_srcport","r");
                        $dstport=fopen("files/tcp_dstport","r");
                        $length=fopen("files/tcp_length","r");
                        echo "<table class='striped'>
                            <thead style='background-color:#e26161'><tr><th>Timestamp</th><th>Source Address</th><th>Destination Address</th><th>Source Port</th><th>Destination Port</th><th>Length</th><th>Block</th></tr></thead>";
                        while(!feof($time))
                        {
                            $srcaddressTCP = fgets($srcadd);
                            if($srcaddressTCP!="")$form = "<td><form action = './display.php' method='POST'><input hidden type='text' value=".$srcaddressTCP." name='block-request'><button type='submit' class='waves-effect waves-light btn' name='submit-block'>X</button></form></td></tr>";
                            else $form="<td></td></tr>";
                            echo "<tr><td>".fgets($time)."</td><td>".$srcaddressTCP."</td><td>".fgets($dstadd)."</td><td>".fgets($srcport)."</td><td>".fgets($dstport)."</td><td>".fgets($length)."</td>".$form;
                        }
                        echo "</table>";
                        fclose($time);
                        fclose($srcadd);
                        fclose($dstadd);
                        fclose($length);
                        fclose($srcport);
                        fclose($dstport);
                    }
                }
                if ($value=="UDP")
                {
                    echo "<h5>UDP</h5><br>";

                    if($selected=="timestamp")
                    {
                        $time=fopen("files/udp_time","r");
                        while(!feof($time))
                        {
                            echo fgets($time)."<br>";
                        }
                        fclose($time);
                    }
                    if($selected=="sourceaddress")
                    {
                        $srcadd=fopen("files/udp_srcadd","r");
                        while(!feof($srcadd))
                        {
                            echo fgets($srcadd)."<br>";
                        }
                        fclose($srcadd);
                    }
                    if($selected=="destinationaddress")
                    {
                        $dstadd=fopen("files/udp_dstadd","r");
                        while(!feof($dstadd))
                        {
                            echo fgets($dstadd)."<br>";
                        }
                        fclose($dstadd);
                    }
                    if($selected=="length")
                    {
                        $length=fopen("files/udp_length","r");
                        while(!feof($length))
                        {
                            echo fgets($length)."<br>";
                        }
                        fclose($length);
                    }
                    if($selected=="sourceport")
                    {
                        $srcport=fopen("files/udp_srcport","r");
                        while(!feof($srcport))
                        {
                            echo fgets($srcport)."<br>";
                        }
                        fclose($srcport);
                    }
                    if($selected=="destinationport")
                    {
                        $dstport=fopen("files/udp_dstport","r");
                        while(!feof($dstport))
                        {
                            echo fgets($dstport)."<br>";
                        }
                        fclose($dstport);
                    }
                    if($selected=="sourcemac")
                    {
                        $srcmac=fopen("files/udp_srcmac","r");
                        while(!feof($srcmac))
                        {
                            echo fgets($srcmac)."<br>";
                        }
                        fclose($srcmac);
                    }
                    if($selected=="destinationmac")
                    {
                        $dstmac=fopen("files/udp_dstmac","r");
                        while(!feof($dstmac))
                        {
                            echo fgets($dstmac)."<br>";
                        }
                        fclose($dstmac);
                    }
                    if($selected=="all")
                    {
                        $time=fopen("files/udp_time","r");
                        $srcadd=fopen("files/udp_srcadd","r");
                        $dstadd=fopen("files/udp_dstadd","r");
                        $srcport=fopen("files/udp_srcport","r");
                        $dstport=fopen("files/udp_dstport","r");
                        $length=fopen("files/udp_length","r");
                        echo "<table class='striped'><thead><tr><th>Timestamp</th><th>Source Address</th><th>Destination Address</th><th>Source Port</th><th>Destination Port</th><th>Length</th><th>Block</th></tr></thead>";
                        while(!feof($time))
                        {
                            $srcaddressARP = fgets($srcadd);
                            if($srcaddressARP!="")$form = "<td><form action = './display.php' method='POST'><input hidden type='text' value=".$srcaddressARP." name='block-request'><button type='submit' class='waves-effect waves-light btn' name='submit-block'>X</button></form></td></tr>";
                            else $form="<td></td></tr>";
                            echo "<tr><td>".fgets($time)."</td><td>".$srcaddressARP."</td><td>".fgets($dstadd)."</td><td>".fgets($srcport)."</td><td>".fgets($dstport)."</td><td>".fgets($length)."</td>".$form;

                        }
                        echo "</table>";
                        fclose($time);
                        fclose($srcadd);
                        fclose($dstadd);
                        fclose($length);
                        fclose($srcport);
                        fclose($dstport);

                    }
                }
                if($value=="ARP")
                {
                    echo "<h5>ARP</h5><br>";

                    if($selected=="timestamp")
                    {
                        $time=fopen("files/arp_time","r");
                        while(!feof($time))
                        {
                            echo fgets($time)."<br>";
                        }
                        fclose($time);
                    }
                    if($selected=="sourceaddress")
                    {
                        $srcadd=fopen("files/arp_srcadd","r");
                        while(!feof($srcadd))
                        {
                            echo fgets($srcadd)."<br>";
                        }
                        fclose($srcadd);
                    }
                    if($selected=="destinationaddress")
                    {
                        $dstadd=fopen("files/arp_dstadd","r");
                        while(!feof($dstadd))
                        {
                            echo fgets($dstadd)."<br>";
                        }
                        fclose($dstadd);
                    }
                    if($selected=="length")
                    {
                        $length=fopen("files/arp_length","r");
                        while(!feof($length))
                        {
                            echo fgets($length)."<br>";
                        }
                        fclose($length);
                    }
                    if($selected=="sourceport")
                    {
                        echo "not available";
                    }
                    if($selected=="destinationport")
                    {
                        echo "not available";
                    }
                    if($selected=="sourcemac")
                    {
                        $srcmac=fopen("files/arp_srcmac","r");
                        while(!feof($srcmac))
                        {
                            echo fgets($srcamc)."<br>";
                        }
                        fclose($srcmac);
                    }
                    if($selected=="destinationmac")
                    {
                        $dstmac=fopen("files/arp_dstmac","r");
                        while(!feof($time))
                        {
                            echo fgets($dstmac)."<br>";
                        }
                        fclose($dstmac);
                    }
                    if($selected=="all")
                    {
                        $time=fopen("files/arp_time","r");
                        $srcadd=fopen("files/arp_srcadd","r");
                        $dstadd=fopen("files/arp_dstadd","r");
                        $length=fopen("files/arp_length","r");
                        echo "<table class='striped'><thead><tr><th>Timestamp</th><th>Source Address</th><th>Destination Address</th><th>Length</th><th>Block</th></tr></thead>";
                        while(!feof($time))
                        {
                            $srcaddressUDP = fgets($srcadd);
                            if($srcaddressUDP!="")$form = "<td><form action = './display.php' method='POST'><input hidden type='text' value=".$srcaddressUDP." name='block-request'><button type='submit' class='waves-effect waves-light btn' name='submit-block'>X</button></form></td></tr>";
                            else $form = "<td></td></tr>";
                            echo "<tr><td>".fgets($time)."</td><td>".$srcaddressUDP."</td><td>".fgets($dstadd)."</td><td>".fgets($length)."</td>.$form";
                        }
                        echo "</table>";
                        fclose($time);
                        fclose($srcadd);
                        fclose($dstadd);
                        fclose($length);
                    }
                }
                echo '<script>document.getElementById("loading").style.display="none";</script>';
            }?>
        </div>

        <br><br><br>

        <footer style="background-color:#3a4556;box-shadow: 20px 20px 20px 20px rgba(0, 0, 0, 0.3);">
            <div class="container" style="color:white;">
                <div class="row">
                    <a href="" style="display:block;color:white;"><div id="homeSelector" class="col s3 m1 l1 center" style="padding:14px;">Home</div></a>
                    <a href="status.php" style="display:block;color:white;"><div id="statusSelector" class="col s3 m1 l1 center" style="padding:14px;">Status</div></a>
                    <a href="source-comparison.php" style="display:block;color:white;"><div id="scSelector" class="col s3 m1 l3" style="padding:14px;">Source Comparison</div></a>
                    <div class="right" style="padding:14px;color:"><a href="logout.php">Logout</a></div>
                </div>
            </div>
        </footer>

        <script>
            document.getElementById("homeSelector").style.background="#26a69a";
        </script>

    </body>
</html>
