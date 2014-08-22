<?php
	include("includes1/config.php");

	$group = $_REQUEST['group'];

	$report = isset($_REQUEST['report']) ?$_REQUEST['report']:"true";

	if($report=="false")
	{
                $str ='<br>';
                $str .='&nbsp;&nbsp;&nbsp;Report List';
		$str .= '<table>';
		$sql = "select distinct userid,name,gender from txnassessmentanswer_batch where groupname = '".$group."';";
		$rs=mysqli_query($connect,$sql) or die(mysql_error());
		while($rw=mysqli_fetch_array($rs)){
				$str .= '<tr><td style="width:100px;float:left">'.$rw[0].'.</td><td style="width:400px;" align="left" valign="top">'.$rw[1].'</td><td style="width:50px;"><a href="/upload_employability_report.php?group='."'$group'".'&userid='.$rw[0].'&name='."'$rw[1]'".'&gender='."'$rw[2]'".'" target="_blank" /><img src="/sgf_images/report.gif"</a></td></tr>';
		}
		$str .='</table>';
		echo $str;
	}
?>