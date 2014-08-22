<?php
session_start();
error_reporting (E_ALL);
ini_set("display_error","on");
include("includes1/config.php");
$sql="select distinct groupname from txnassessmentanswer_batch;";
$result = mysqli_query($connect, $sql);

//$qry=mysqli_query($connect,"select credits from txnpartner where userid = '".$_SESSION['user']."'") or die(mysqli_error());
//$sql_data=mysqli_fetch_array($qry);

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
<script type="text/javascript">
function getstudentsreport()
{
	$("#wait_jobfamily").css("display","block");
	var obj = document.getElementById("group");
	$.ajax({type:"GET",url:"getPemReportAjax.php?group=" + obj.value + "&report=false",async:true,
		success:function(response)
		{
			var roleobj = document.getElementById("group_area");
			roleobj.innerHTML = "";
			roleobj.innerHTML = response;
			$("#wait_jobfamily").css("display","none");
		}
	});
}
</script>
</head>
<body>
<div id="main">
    <div id="main-wrap">

        <div class="boxes-third boxes-last" style="width:98%">
       	     <div class="latestthree">
           	<div class="title">
                     Course Selection Report<br>
                     <span class="titlearrow"></span>
                     <Select id="group" name="group" onchange="getstudentsreport();" >
			       	<option value="0">----------------Select Group/School Name--------------</option>
                                  <?php
				        while ($row = mysqli_fetch_array($result)) {?>
				        <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
			          <?php } ?>
		     </Select>
                     <div id="wait_jobfamily" style="display:none;float:left;padding:3px;"><img src="images1/ajax-loading.gif" width="15" height="15" ></div>
                </div>
             </div>
             <div id="group_area"></div>
        </div>
    </div>
</div>
</body>
</html>