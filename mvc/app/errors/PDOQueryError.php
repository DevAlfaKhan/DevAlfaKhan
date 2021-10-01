<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO QUERY ERROR</title>
    <style>
        .box{
            background-color: #4caf50;
            width: 70%;
            height: 500px;
            margin: 70px auto;
            padding-top: 10px;
        }
        .box .top{
            width: 100%;
            background-color: #673ab7;
        }
        .box .top h2{
            padding: 5px 23px;
        }
    </style>
</head>
<body style="background-color: #9c9c9cb3;color:#fff;">
    <div class="box">
        <div class="top">
            <h2><?=$_SESSION['PDO_QUERY_ERROR']['message']?></h2>
        </div>
        <div class="track" style="padding-left: 23px;">
        <h3><span>PDO QUERY : </span> <?=$_SESSION['PDO_QUERY_ERROR']['queryString']?></h3><br>
        <h3><span>FILE NAME : </span> <?=$_SESSION['PDO_QUERY_ERROR']['fileName']?></h3><br>
        <h3><span>FILE LINE NUMBER : </span> File name <span style='color:#b72727;'>  <?=basename($_SESSION['PDO_QUERY_ERROR']['fileName']) . "</span> page number <span style='color:#b72727;'>" .$_SESSION['PDO_QUERY_ERROR']['lineNumber'] . "</span>" ?></h3><br>
        <h3><span>USE OF : </span> <?=$_SESSION['PDO_QUERY_ERROR']['userOf']?> Method</h3>
        </div>
    </div>
</body>
</html>



