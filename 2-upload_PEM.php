<?php
session_start();
error_reporting (E_ALL);
ini_set("display_error","on");
include("includes1/config.php");

$qry=mysqli_query($connect,"select credits_pem from txnpartner where userid = '".$_SESSION['user']."'") or die(mysqli_error());
$sql_data=mysqli_fetch_array($qry);
$available_credits = $sql_data['credits_pem'];
if(isset($_POST["Import"]))
{
   $linecount = count(file($_FILES["file"]["tmp_name"])) - 1;
   echo 'Total Lines: $linecount';
if ($sql_data['credits_pem'] >= $linecount/78)
{
    $fl=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($fl, "r");
        $count = 0;
        while (($emapData = fgetcsv($file, $linecount, ",")) !== FALSE)
        {
              $count++;
              if($count>1){
                 $sql = "INSERT into txnassessmentanswer_batch(groupname,userid,gender,name,elementid,score,template) values ('$emapData[0]',$emapData[1],'$emapData[2]','$emapData[3]','$emapData[4]',$emapData[5],'PEM')";
                 mysqli_query($connect,$sql);
                 }
        }
        if ($count > 0){
                   $available_credits = $sql_data['credits_pem'] - $linecount/78;
                   $uqry=mysqli_query($connect,"update txnpartner set credits_pem = $available_credits;");
                   fclose($file);
                   echo 'CSV File has been successfully Imported';
                } else {
                       echo 'Invalid File:Please Upload CSV File with right format';
        }

    }
    else
        echo 'Invalid File:Please Upload CSV File';
} else {
       echo 'You do not have sufficeint credits..please buy more';
       }
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta name="description" content="">
<meta name="keywords" content="">
<link href="/css/main.css" rel="stylesheet" type="text/css">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="grey" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.nivo.slider.js"></script>
<script src="/js/jquery.prettyPhoto.js" type="text/javascript"></script>
<!-- <script src="js/twitter.js"></script> -->
<script src="/js/custom.js"></script>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto();
  });
</script>
</head>
<body>
<div id="main">
    <div id="main-wrap">

        <div class="boxes-third boxes-last" style="width:95%">
       	     <div class="latestthree">
       	        Your available credits: <?php echo $available_credits;?>
           	<div class="title">
                     Upload - Employability Profile Responses
                     <span class="titlearrow"></span>
                </div>
                <div>
                      <form enctype="multipart/form-data" method="post" role="form">
                            <div class="form-group">
                                    <input type="file" name="file" id="file" size="150">
                                 <p class="help-block">Only CSV File Import.</p>
                            </div>
                            <button type="submit" class="btn btn-default" id="import" name="Import" value="Import">Upload</button>
                            <?php if ($sql_data['credits_pem'] <=0){
                                  echo '<script>';
                                  echo 'document.getElementById("file").disabled = true;';
                                  echo 'document.getElementById("import").disabled = true;';
                                  echo '</script>';
                            }?>
                      </form>
                </div>
             </div>
        </div>


    </div>
</div>
</body>
</html>