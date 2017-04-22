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
            padding: 5%;}
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
        </style>
    </head>
    <body>
        <a href="logout.php" class="logout">Logout</a>
        <div class="container">
            <h4>Select the type of Packet</h4>
            <form method="post" action="" class="card z-depth-1">
                <input type="radio" name="packet" value="TCP" onclick="change">TCP<br>
                <input type="radio" name="packet" value="UDP" onclick="change">UDP<br>
                <input type="radio" name="packet" value="ARP" onclick="change" checked>ARP<br>
                <br>
                <select name="dropdown">
                   <option value="timestamp">Timestamp</option>
                   <option value="sourceaddress">Source Address</option>
                   <option value="destinationaddress">Destination Address</option>
                   <option value="sourceport">Source Port</option>
                   <option value="destinationport">Destination Port</option>
                   <option value="sourcemac">Source MAC</option>
                   <option value="destinationmac">Destination MAC</option>
                   <option value="length">Length</option>
                   <option value="all">All</option>
               </select><br>
               <button class="waves-effect waves-light btn" type="submit" name="submit">Submit</button>
           </form>

           <?php
           if(isset($_POST["submit"]))
           {
                $value=$_POST["packet"];
                $selected=$_POST["dropdown"];
                echo "<hr>";
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
                        echo "<table class='striped'><thead><tr><th>Timestamp</th><th>Source Address</th><th>Destination Address</th><th>Source Port</th><th>Destination Port</th><th>Length</th></tr></thead>";
                        while(!feof($time))
                        {
                            echo "<tr><td>".fgets($time)."</td><td>".fgets($srcadd)."</td><td>".fgets($dstadd)."</td><td>".fgets($srcport)."</td><td>".fgets($dstport)."</td><td>".fgets($length)."</td></tr>";
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
                        echo "<table class='striped'><thead><tr><th>Timestamp</th><th>Source Address</th><th>Destination Address</th><th>Source Port</th><th>Destination Port</th><th>Length</th></tr></thead>";
                        while(!feof($time))
                        {
                            echo "<tr><td>".fgets($time)."</td><td>".fgets($srcadd)."</td><td>".fgets($dstadd)."</td><td>".fgets($srcport)."</td><td>".fgets($dstport)."</td><td>".fgets($length)."</td></tr>";

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
                        echo "<table class='striped'><thead><tr><th>Timestamp</th><th>Source Address</th><th>Destination Address</th><th>Length</th></tr></thead>";
                        while(!feof($time))
                        {
                            echo "<tr><td>".fgets($time)."</td><td>".fgets($srcadd)."</td><td>".fgets($dstadd)."</td><td>".fgets($length)."</td></tr>";
                        }
                        echo "</table>";
                        fclose($time);
                        fclose($srcadd);
                        fclose($dstadd);
                        fclose($length);
                    }
                }
            }?>
        </div>
    </body>
</html>
