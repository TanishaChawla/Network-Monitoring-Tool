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
                <div class="container"><h4>Realtime Analysis</h4></div>
                <form action="" method="POST"><input type="number" hidden name="isStarted" value="1"><button type="" class="waves-effect waves-light btn" name="submit-start" id="startButton" onclick="startExecution()">Start</button></form>
                <p id="elementsDisplayedHere"></p>
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
            document.getElementById("rtSelector").style.background="#26a69a";
            function startExecution(){
                
            }
        </script>

</body>
</html>