<?php
include("../Includes1/Config.php");
session_start();
if (isset($_SESSION['user'])){
$user=$_SESSION['user'];
}
if (isset($_SESSION['userrpt'])){
   $user = $_SESSION['userrpt'];
}
if (isset($_REQUEST['u'])){
     $user=$_REQUEST['u'];
}

$strSQL = "Call dashboard_col_pem('$user');";
$result = mysqli_query($connect, $strSQL);
while($ors = mysqli_fetch_array($result)) {
                                                       $Score[] = $ors[2];
                                     }
$strScore = implode(',',$Score);

$json = '{
"graphset":[

    {
        "alpha":1,
        "background-color-1":"#cccccc",
        "background-color-2":"#d8d6d8",

            "tooltip":{
                    "visible":true,
                    "shadow":true,
                    "shadow-alpha":0.3,
                    "shadow-color":"#000000",
                    "shadow-distance":0,
                    "shadow-blur-x":5,
                    "shadow-blur-y":5
                },
                "title":{
                    "text":"My Compentencies Level"
                },
                "type":"hbar",
                "guide":{
                    "visible":true,
                    "alpha":0.3,
                    "tooltip-text":"%v",
                    "text-align":"center",
                    "shadow":true,
                    "shadow-alpha":0.3,
                    "shadow-color":"#000000",
                    "shadow-distance":0,
                    "shadow-blur-x":5,
                    "shadow-blur-y":5,
                    "line-color":"#000000",
                    "line-width":1,
                    "line-gap-size":0
                },
                "plot":{
                    "highlight":true,
                    "tooltip-text":"%v",
                    "value-box":{
                        "type":"all",
                        "text":"%v",
                        "font-size":11,
                        "color":"#666666",
                        "text-align":"right"
                    },
                    "preview":false
                },
                "chart":{
                    "width":"205px",
                    "position":"70% 0%",
                    "alpha":0.3,
                    "background-color":"#cccccc",
                    "background-color-2":"#eeeeee",
                    "margin-top":50,
                    "margin-right":10,
                    "margin-left":20,
                    "margin-bottom":25,
                    "border-color":"#cccccc",
                    "border-width":0
                },
                "scale-x":{
                    "values":["Business","Structured","Entrepreneur","Learnable","Social"],
                    "line-color":"#b2b2b2",
                    "line-width":1,
                    "line-gap-size":0,
                    "guide":{
                        "line-color":"#000000",
                        "line-width":1,
                        "line-gap-size":0
                    }
                },
                "scale-y":{
                    "line-color":"#b2b2b2",
                    "line-width":1,
                    "line-gap-size":0,
                    "guide":{
                        "line-color":"#000000",
                        "line-width":1,
                        "line-gap-size":0
                    }
                },
                "series":[
                    {
	          "values":[' . $strScore . '],
                        "background-color-1":"#ff0000",
                        "background-color-2":"#940101",
                        "text":"Item 0"
                    }]
                }]
            }';
$json = str_replace(array("\r","\n"), "", $json);
echo $json;
?>