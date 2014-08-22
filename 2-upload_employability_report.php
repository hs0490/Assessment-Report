<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
ini_set('default_charset', 'UTF-8');
include("includes1/config.php");
$uid = $_REQUEST['userid'];
$sex = str_replace("'","",$_REQUEST['gender']);
$cname = $_REQUEST['name'];
$name = str_replace("'","",$_REQUEST['name']);
$fname = $name;
$sname ='';
$_SESSION['grp'] = $_REQUEST['group'];
$_SESSION['user'] = $uid;
$group = $_REQUEST['group'];
$grp = str_replace("'","",$_REQUEST['group']);
$compsql = "Select CompID, ProfileName, Round(SUM(Score)*100/(Count(1)*4),0)  as Percentage
		from txnAssessmentAnswer_batch a
		JOIN lkpSkill ON a.ElementID=lkpSkill.SkillID
		JOIN lkpProfile ON lkpSkill.CompID = lkpProfile.ProfileID
		where lkpSkill.CompID is NOT NULL and a.userid = $uid and a.groupname = '".$grp."' and a.template='PEM'
		group by CompID, ProfileName
		Order by 3 desc limit 0,3;";

$compres = mysqli_query($connect,$compsql) or die(mysql_error());
while( $compar = mysqli_fetch_array($compres) ){
                        $CompID[] = $compar[0];
                        $Comp[] = $compar[1];
                        $Perc[] =  $compar[2];
}


$csql = "Select LeadID, ProfileName, Round(SUM(Score)*100/(Count(1)*5),0)  as Percentage
		from txnAssessmentAnswer_batch a
		JOIN lkpSkill ON a.ElementID=lkpSkill.SkillID
		JOIN lkpProfile ON lkpSkill.LeadID = lkpProfile.ProfileID
		where lkpSkill.LeadID is NOT NULL and a.userid = $uid and a.groupname = '".$grp."' and a.template='PEM'
		group by LeadID, ProfileName
		Order by 3 desc limit 0,3;";
$cres = mysqli_query($connect,$csql) or die(mysql_error());
while( $cpar = mysqli_fetch_array($cres) ){
                        $LID[] = $cpar[0];
                        $LC[] = $cpar[1];
                        $Pc[] =  $cpar[2];
}
$sql  = "call pem_report_text_batch('".$sex."', ".$CompID[0].", ".$CompID[1].", ".$CompID[2].", ".$Perc[0].", ".$Perc[1].", ".$Perc[2].",$cname);";
$sql .= "call pem_report_text_batch('".$sex."', ".$LID[0].", ".$LID[1].", ".$LID[2].", ".$Pc[0].", ".$Pc[1].", ".$Pc[2].",$cname);";
$sql .= "call pemreport_charbar_batch(".$uid.",'".$grp."');";
$sql .= "call pemreport_profilebar_batch(".$uid.",'".$grp."');";

if (mysqli_multi_query($connect, $sql)) {

	/* store first result set */
	if ($result = mysqli_store_result($connect)) {
		$ors = mysqli_fetch_array($result);
		mysqli_free_result($result);
	}

	/* have to do it twice for some reason */
              mysqli_next_result($connect);
	mysqli_next_result($connect);

	/* store second result set */
	if ($result = mysqli_store_result($connect)) {
		$ors1 = mysqli_fetch_array($result);
		mysqli_free_result($result);
	}

}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title></title>
<meta charset="utf-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<script src="sample-report_10th_files/all.js"></script>
<link rel="stylesheet" type="text/css" href="Sample-Report_12th_files/course-selection-report_12th.css" media="screen">
<script src="js/zingchart-html5-min.js"></script>
<!--[if lt IE 9]>
    <link rel="stylesheet" href="http://www.skillgapfinder.com/sgf_css/ie7.css" type="text/css" media="all">
    <script type="text/javascript" src="http://www.skillgapfinder.com/js/html5.js"></script>
<![endif]-->
<script type="text/javascript">
function listen(evnt, elem, func) {
    if (elem.addEventListener)  // W3C DOM
        elem.addEventListener(evnt,func,false);
    else if (elem.attachEvent) { // IE DOM
         var r = elem.attachEvent("on"+evnt, func);
    return r;
    }
    else window.alert('I\'m sorry, I\'m afraid I can\'t do that.');
}
</script>
</head>
<body>
<input type="image" src="sgf_images/pdf.gif" title="Export to PDF" name="pdf" width="36" height="36" onClick="parent.location='http://pdfcrowd.com/url_to_pdf/?width=210mm&height=297mm'">
<div class="mainBox">
        <div class="HeaderBack_Color">
             <div style="width: 25%; float: left;">
                    <div class="LogoBox">
                        <div class="Logo_Img">
                        </div>
                    </div>
             </div>
             <div style="float: left;margin-left:430px;font-size:20px;color:white;margin-top:87px;">: Employability Profile Report</div>
             <div style="float: right;margin-right:280px;margin-top:-23px;font-size:20px;color:red;"><b><?php echo $fname.' '.$sname; ?></b></div>
        </div>
        <div style="padding-top: 100px;"></div>
        <div style="width: 100%;">
            <div style="width: 45%; float: left;">
                <div class="GradEmp">
                </div>
            </div>
            <div style="width: 50%; float: left; padding-top: 20px;">
                <div class="Top_Box">
                    <div style="padding-top: 2px;"></div>
                    <div class="Top_Box_1">
                        <div style="width: 95%;padding:10px;">
<p><b>Dear <?php echo $fname.' '.$sname; ?></b></p><br>
<p style="text-align:justify;">The information in this report can guide you in knowing your employability on graduation and over the long term that can increase your chances of success in an increasingly dynamic and competitive world. Please note that the questionnaire only checked what your employability skills preferences are. To raise your own awareness of skills and to increase your ability to articulate these skills, such capabilities can be put into practice in personal development planning, work experience opportunities, job searching, and interviews and be of real help when making major career and life changes.</p><br><p>Reliability and validity of your report:</p><br>
<p>
<ul class="TikMark" style="padding-left:20px;">
<li>Developed and structured by world-class psychologists and career counselors</li>
<li>Validated by experts so that it tests what it sets out to test</li>
<li>Courses and career suggestions suitable for geographically mobile students of the 21st Century</li>
</ul>
</p><br>
<p>We sincerely wish you the very best as you explore your path to personal fulfillment.</p><br><br>
<p>Sincerely,</p><br>
<p><b>Accelerated Learning Systems</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-top: 250px;"> </div>
        <div class="ForthPage_Footer">
            <div style="width: 100%;">
                <div style="width: 60%; float: left;">
                    <div class="CopyRight1" style="padding-top: 40px;">
                        Employability Profile Report</div>
                </div>
                <div style="width: 40%; float: left;">
                    <div class="CopyRight" style="padding-top: 45px; padding-right: 10px;">
			 <script type="text/javascript">
                                 document.write('Copyright &copy; ');
                                 var today = new Date();
                                 document.write(+ today.getFullYear());
                                 document.write('  Powered by <a href="http://www.skillgapfinder.com" target="_blank">SkillGapfinder</a>');
                         </script>
			 <noscript>
				Copyright &copy; 2014  Powered by www.skillgapfinder.com
			 </noscript>

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-bottom: 10px;"></div>
        </div>
    </div>
    <!-- First Page End -->
    <div class="page-break"></div>
    <!-- Second Page Start -->
    <div style="padding-top: 5px;"></div>
    <div class="mainBox">
        <div class="HeaderBack_Color">
             <div style="width: 25%; float: left;">
                    <div class="LogoBox">
                        <div class="Logo_Img">
                        </div>
                    </div>
             </div>
             <div style="float: left;margin-left:430px;font-size:20px;color:white;margin-top:87px;">: Employability Profile Report</div>
             <div style="float: right;margin-right:280px;margin-top:-23px;font-size:20px;color:red;"><b><?php echo $fname.' '.$sname; ?></b></div>
        </div>
        <div style="clear: both;"></div>
        <div class="SecondPageText_Header">
            What are Student Employability Profiles?</div>
        <div style="clear: both; padding-top: 120px;">&nbsp;</div>
        <div class="ThirteenthPage_Text" style="text-align:justify">The Accelerated Learning System have the compilation of Student Employability Profiles. Each profile identifies skills that can be developed through the study of a particular discipline based on subject benchmark statements developed by International higher education academic communities. These skills have then been mapped against input from Employer membership regarding the employability skills, competencies and attributes which they valued when recruiting. While acknowledging that no list is definitive, these represent the key competencies that employers observed in individuals who can transform organisations and add value early in their careers and comprise:</div>
        <div style="width: 100%;">
            <div class="Stats_Point">
                <ul class="TikMark" style="text-align:justify;padding:20px;font-size:12px;">
                    <li class="TikMarkHeight"><b>Cognitive Skills/Brainpower:</b> The ability to identify, analyse and solve problems; work with information and handle a mass of diverse data, assess risk and draw conclusions. (Analysis, Attention to detail, Judgement)</li>
                    <li class="TikMarkHeight"><b>Generic Competencies:</b> High-level and transferable key skills such as the ability to work with others in a team, communicate, persuade and have interpersonal sensitivity. (Image, Influencing, Interpersonal Sensitivity, Planning and organising, Questioning, Teamwork/Working with others, Written Communication)</li>
                    <li class="TikMarkHeight"><b>Personal Capabilities:</b> The ability and desire to learn for oneself and improve one's self-awareness and performance - lifelong learning philosophy, emotional intelligence and performance. To be a self starter and to finish the job (Achievement Orientation, Adaptability/Flexibility, Creativity, Decisiveness, Initiative, Leadership and tolerance of stress)</li>
                    <li class="TikMarkHeight"><b>Technical Ability:</b> For example, having the knowledge and experience of working with relevant modern laboratory equipment. The ability to apply and exploit information technology (Technical Application, Technical Knowledge)</li>
                    <li class="TikMarkHeight"><b>Business and / or Organisation Awareness:</b> Having an appreciation of how businesses operate through having had (preferably relevant) work experience. Appreciation of organisational culture, policies, and processes through organisational understanding and sensitivity. Ability to understand basic financial and commercial principles (Commercial Awareness, Financial Awareness, Organisation Understanding)</li>
                    <li class="TikMarkHeight"><b>Practical Elements - Vocational Courses:</b> Critical evaluation of the outcomes of professional practice; reflect and review own practice; participate in and review quality control processes and risk management.</li>
                </ul>
            </div>
        </div>
        <div style="clear: both; padding-top: 200px;">&nbsp;</div>
        <div class="ForthPage_Footer">
            <div style="width: 100%;">
                <div style="width: 60%; float: left;">
                    <div class="CopyRight1" style="padding-top: 40px;">
                        Employability Profile Report</div>
                </div>
                <div style="width: 40%; float: left;">
                    <div class="CopyRight" style="padding-top: 45px; padding-right: 10px;">
			 <script type="text/javascript">
                                 document.write('Copyright &copy; ');
                                 var today = new Date();
                                 document.write(+ today.getFullYear());
                                 document.write('  Powered by <a href="http://www.skillgapfinder.com" target="_blank">SkillGapfinder</a>');
                         </script>
			 <noscript>
				Copyright &copy; 2014  Powered by www.skillgapfinder.com
			 </noscript>

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-bottom: 10px;"></div>
    </div>
    <!-- Second Page End -->
    <div class="page-break"></div>
    <div style="padding-top: 5px;"></div>
    <div class="mainBox">
        <div class="HeaderBack_Color">
             <div style="width: 25%; float: left;">
                    <div class="LogoBox">
                        <div class="Logo_Img">
                        </div>
                    </div>
             </div>
             <div style="float: left;margin-left:430px;font-size:20px;color:white;margin-top:87px;">: Employability Profile Report</div>
             <div style="float: right;margin-right:280px;margin-top:-23px;font-size:20px;color:red;"><b><?php echo $fname.' '.$sname; ?></b></div>
        </div>
        <div style="clear: both; padding-top: 5px;">&nbsp;</div>
        <div class="SecondPageText_Header">My Competencies Profile</div>
        <div style="clear: both; padding-top: 5px;">&nbsp;</div>
        <div style="width: 100%;">
            <div style="width: 45%; float: left;">
                <div class="Top_Box_Small">
                    <div style="padding-top: 2px;">
                    </div>
                    <div class="Top_Box_Small_1">
                        <div class="Top_Box_ContentText_Small" style="width: 95%;padding:10px;">
                           <p style="text-align:justify;"><?php echo $ors['Text']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width: 50%; float: left;">
                <div class="Top_Box_Small" style="width: 480px;">
                    <div style="padding-top: 2px;"></div>
                    <div class="Top_Box_Small_1" style="width: 420px;">
                        <div class="Top_Box_ContentText_Small" style="width: 95%;padding:10px;">
                               <iframe style="border:none;" frameborder="0" height="321" width="400" id="demoframe" src="chart/Col3DPem_batch.php"> </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-top: 5px;">&nbsp;</div>
        <div class="SecondPageText_Header">My Leadership/Cultural Profile</div>
        <div style="clear: both; padding-top: 5px;">&nbsp;</div>
        <div style="width: 100%;">
            <div style="width: 45%; float: left;">
                <div class="Top_Box_Small" style="height: 500px;">
                    <div style="padding-top: 2px;"></div>
                    <div class="Top_Box_Small_1" style="height: 440px;">
                        <div class="Top_Box_ContentText_Small" style="width: 95%;padding:10px;">
                             <iframe style="border:none;" frameborder="0" height="321" width="380" id="demoframe" src="chart/Polar2DPem_batch.php"> </iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width: 50%; float: left;">
                <div class="Top_Box_Small" style="width: 480px;height: 500px;">
                    <div style="padding-top: 2px;">
                    </div>
                    <div class="Top_Box_Small_1" style="width: 420px;height: 440px;">
                        <div class="Top_Box_ContentText_Small" style="width: 95%;padding:10px;">
                           <p style="text-align:justify;"><?php echo $ors1['Text']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-top: 50px;"> </div>
        <div class="ForthPage_Footer">
            <div style="width: 100%;">
                <div style="width: 60%; float: left;">
                    <div class="CopyRight1" style="padding-top: 40px;">
                        Employability Profile Report</div>
                </div>
                <div style="width: 40%; float: left;">
                    <div class="CopyRight" style="padding-top: 45px; padding-right: 10px;">
			 <script type="text/javascript">
                                 document.write('Copyright &copy; ');
                                 var today = new Date();
                                 document.write(+ today.getFullYear());
                                 document.write('  Powered by <a href="http://www.skillgapfinder.com" target="_blank">SkillGapfinder</a>');
                         </script>
			 <noscript>
				Copyright &copy; 2014  Powered by www.skillgapfinder.com
			 </noscript>

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-bottom: 10px;"></div>
        </div>
    </div>
    <!-- Second Page End -->
    <div class="page-break"></div>
    <!-- Third Page Start -->
    <div style="clear: both; padding-top: 5px;"></div>
    <div class="mainBox">
        <div class="HeaderBack_Color">
             <div style="width: 25%; float: left;">
                    <div class="LogoBox">
                        <div class="Logo_Img">
                        </div>
                    </div>
             </div>
             <div style="float: left;margin-left:430px;font-size:20px;color:white;margin-top:87px;">: Employability Profile Report</div>
             <div style="float: right;margin-right:280px;margin-top:-23px;font-size:20px;color:red;"><b><?php echo $fname.' '.$sname; ?></b></div>
        </div>
        <div style="clear: both; padding-top: 5px;">&nbsp;</div>
        <div class="SecondPageText_Header" Style="float:left;margin-left:20px;">Employability Characterstics</div>
        <div class="SecondPageText_Header">Employability Profile</div>
        <div style="clear: both; padding-top: 200px;">&nbsp;</div>
        <div style="width: 100%;">
            <div style="width: 45%; float: left;">
                <div class="Top_Box_Small" style="margin-left:10px;">
                    <div style="padding-top: 2px;">
                    </div>
                    <div class="Top_Box_Small_1">
                        <div class="Top_Box_ContentText_Small" style="width: 95%;padding:10px;">
                           <iframe style="border:none;" frameborder="0" height="321" width="380" id="demoframe" src="chart/Bar2DPem_batch.php"> </iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width: 50%; float: left;">
                <div class="Top_Box_Small" style="width:500px;margin-left:10px;">
                    <div style="padding-top: 2px;"></div>
                    <div class="Top_Box_Small_1" style="width:440px">
                        <div class="Top_Box_ContentText_Small" style="width: 95%;padding:10px;">
                             <iframe style="border:none;" frameborder="0" height="321" width="420" id="demoframe" src="chart/Pie3DPem_batch.php"> </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-top: 400px;">&nbsp;</div>
        <div class="ForthPage_Footer">
            <div style="width: 100%;">
                <div style="width: 60%; float: left;">
                    <div class="CopyRight1" style="padding-top: 40px;">
                        Employability Profile Report</div>
                </div>
                <div style="width: 40%; float: left;">
                    <div class="CopyRight" style="padding-top: 45px; padding-right: 10px;">
			 <script type="text/javascript">
                                 document.write('Copyright &copy; ');
                                 var today = new Date();
                                 document.write(+ today.getFullYear());
                                 document.write('  Powered by <a href="http://www.skillgapfinder.com" target="_blank">SkillGapfinder</a>');
                         </script>
			 <noscript>
				Copyright &copy; 2014  Powered by www.skillgapfinder.com
			 </noscript>

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-bottom: 10px;"></div>
        </div>
    </div>
    <!-- Second Page End -->
    <div class="page-break"></div>
    <!-- Third Page Start -->
    <div style="clear: both; padding-top: 5px;"></div>
    <div class="mainBox">
        <div class="HeaderBack_Color">
             <div style="width: 25%; float: left;">
                    <div class="LogoBox">
                        <div class="Logo_Img">
                        </div>
                    </div>
             </div>
             <div style="float: left;margin-left:430px;font-size:20px;color:white;margin-top:87px;">: Employability Profile Report</div>
             <div style="float: right;margin-right:280px;margin-top:-23px;font-size:20px;color:red;"><b><?php echo $fname.' '.$sname; ?></b></div>
        </div>
        <div style="clear: both;">
        </div>
        <div class="SecondPageText_Header">My Employment Characterstics</div>
        <div style="clear: both; padding-top: 5px;">&nbsp;</div>
        <div style="width: 100%;">
                <div class="Top_Box" style="width: 910px;height:1380px;">
                    <div style="padding-top: 2px;">
                    </div>
                    <div class="Top_Box_1" style="width: 850px;height:1320px;">
                        <div class="Top_Box_ContentText_Small" style="font-size:12px;width: 95%;padding:10px;">
  						<?php
                                                mysqli_next_result($connect);
						mysqli_next_result($connect);
						if ($result = mysqli_store_result($connect)){
                                                    $sr_row = 0;
						while($sr_row=mysqli_fetch_array($result)){
						?>

						<div style="float:left;width:440px;padding-left:10px;text-align:justify;">
							<span style="color:#ff6600"><?php echo $sr_row['SkillGroup'].":  ";?></span>
							<?php echo $sr_row['Description'];?>
						</div>
						<div style="float:right;width:300px;padding:5px;height:70px;">
							<div style="border:1px solid #0e0e0e;padding:5px;height:60px;">
								<div style="float:left;height:40px;border-right:2px solid #0e0e0e;font-size:11px;">
									 <div style="height:3px;"></div>
									Average &nbsp;
									<div style="height:3px;"></div>
									Your Rating &nbsp;
								</div>
								<div style="float:left;height:50px;width:140px;">
									<div style="height:40px;">
										<div style="width:<?php echo $sr_row['Average']*1.30; ?>px;background:#70E000;height:15px;"><span style="float:right;margin-right:-30px;"><?php echo $sr_row['Average']?>%</span></div>
										<div style="height:5px;"></div>
										<div style="width:<?php echo $sr_row['PersonalPerc']*1.30; ?>px;background:#007500;height:15px;"><span style="float:right;margin-right:-30px;"><?php echo $sr_row['PersonalPerc']?>%</span></div>
									</div>
									<div>
										<div style="height:5px;margin-left:-2px;">
											<div style="float:left;width:18px;border-top:2px solid #0e0e0e;">0</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">20</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">40</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">60</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">80<span style="margin-top:-15px;margin-left:10px;">100</span></div>
											<div style="clear:both;"></div>
										</div>
									</div>

								</div>
								<div style="clear: both;"></div>

							</div>
						</div>
						<div style="clear:both"></div>
						<?php }
						mysqli_free_result($result);
						}?>

                        </div>
                    </div>
                </div>
        </div>
        <div style="clear: both; padding-top: 10px;"> </div>
                <div class="ForthPage_Footer">
            <div style="width: 100%;">
                <div style="width: 60%; float: left;">
                    <div class="CopyRight1" style="padding-top: 40px;">
                        Employability Profile Report</div>
                </div>
                <div style="width: 40%; float: left;">
                    <div class="CopyRight" style="padding-top: 45px; padding-right: 10px;">
			 <script type="text/javascript">
                                 document.write('Copyright &copy; ');
                                 var today = new Date();
                                 document.write(+ today.getFullYear());
                                 document.write('  Powered by <a href="http://www.skillgapfinder.com" target="_blank">SkillGapfinder</a>');
                         </script>
			 <noscript>
				Copyright &copy; 2014  Powered by www.skillgapfinder.com
			 </noscript>

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-bottom: 10px;">
        </div>
    </div>
    <!-- Third Page End -->
    <div class="page-break"></div>
    <!-- Fourth Page Start -->
    <div style="clear: both; padding-top: 5px;"></div>
    <div class="mainBox">
        <div class="HeaderBack_Color">
             <div style="width: 25%; float: left;">
                    <div class="LogoBox">
                        <div class="Logo_Img">
                        </div>
                    </div>
             </div>
             <div style="float: left;margin-left:430px;font-size:20px;color:white;margin-top:87px;">: Employability Profile Report</div>
             <div style="float: right;margin-right:280px;margin-top:-23px;font-size:20px;color:red;"><b><?php echo $fname.' '.$sname; ?></b></div>
        </div>
        <div style="clear: both;"></div>
        <div class="SecondPageText_Header">
            My Employability Profile
        </div>
        <div style="clear: both; padding-top: 50px;"></div>
        <div class="Report_Details_BlueColour" style="margin-left:80px;width:80%">
            <div style="clear: both; padding-top: 10px;"></div>
            <div class="Report_Details_WhiteColour" style="width:96%">
                <div style="width: 100%; background-color: rgb(230, 231, 232); margin-top:10px;margin-right: 10px;">
                    <div style="width: 100%;padding:10px">
						<?php
					        mysqli_next_result($connect);
						mysqli_next_result($connect);
						if ($result = mysqli_store_result($connect)){
                                                $sr_row = 0;
						while($sr_row=mysqli_fetch_array($result)){
						?>

						<div style="float:left;width:50%;padding:10px;font-size:22px;">
							<span style="color:#ff6600"><?php echo $sr_row['ProfileName'].":  ";?></span>
						</div>
						<div style="float:left;width:40%;padding:5px;height:70px;">
							<div style="border:1px solid #0e0e0e;padding:5px;height:60px;">
								<div style="float:left;height:40px;border-right:2px solid #0e0e0e;font-size:11px;">

									<div style="height:3px;"></div>
									Your Rating &nbsp;
								</div>
								<div style="float:left;height:50px;width:140px;">
									<div style="height:40px;">

										<div style="height:10px;"></div>
										<div style="width:<?php echo $sr_row['Perc']*1.30; ?>px;background:#007500;height:15px;"><span style="float:right;margin-right:-30px;"><?php echo $sr_row['Perc']?>%</span></div>
									</div>
									<div>
										<div style="height:5px;margin-left:-2px;">
											<div style="float:left;width:18px;border-top:2px solid #0e0e0e;">0</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">20</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">40</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">60</div>
											<div style="float:left;width:28px;border-top:2px solid #0e0e0e;">80<span style="margin-top:-15px;margin-left:10px;">100</span></div>
											<div style="clear:both;"></div>
										</div>
									</div>

								</div>
								<div style="clear: both;"></div>
							</div>
						</div>
                                                <div class="GreyLine_1" style="width:95%"></div>
						<div style="clear:both"></div>
						<?php }
						mysqli_free_result($result);
						}?>

                    </div>
                </div>
            </div>
            <div style="padding-top: 55px;">&nbsp;</div>
        </div>
        <div style="clear: both; padding-top: 210px;">&nbsp;</div>
        <div class="SecondPage_Footer">
            <div style="width: 100%;">
                <div style="width: 60%; float: left;">
                    <div class="CopyRight1" style="padding-top: 40px;">
                        Employability Profile Report</div>
                </div>
                <div style="width: 40%; float: left;">
                    <div class="CopyRight" style="padding-top: 45px; padding-right: 10px;">
			 <script type="text/javascript">
                                 document.write('Copyright &copy; ');
                                 var today = new Date();
                                 document.write(+ today.getFullYear());
                                 document.write('  Powered by <a href="http://www.skillgapfinder.com" target="_blank">SkillGapfinder</a>');
                         </script>
			 <noscript>
				Copyright &copy; 2014  Powered by www.skillgapfinder.com
			 </noscript>

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; padding-bottom: 10px;"></div>
    </div>
     <div class="page-break"></div>
     <!-- Fifth-A Page Start -->
    <div style="clear: both; padding-top: 5px;"></div>
    <div class="mainBox">
        <div class="HeaderBack_Color">
             <div style="width: 25%; float: left;">
                    <div class="LogoBox">
                        <div class="Logo_Img">
                        </div>
                    </div>
             </div>
             <div style="float: left;margin-left:430px;font-size:20px;color:white;margin-top:87px;">: Employability Profile Report</div>
             <div style="float: right;margin-right:280px;margin-top:-23px;font-size:20px;color:red;"><b><?php echo $fname.' '.$sname; ?></b></div>
        </div>
        <div style="clear: both;"></div>
        <div style="clear: both; padding-top: 20px;">
        <div class="SecondPageText_Header">
            Career Tips for
            <?php echo $fname.' '.$sname; ?></div>
            <div style="clear: both;">
        </div>

        <div class="Twenty5th_Text">
           A Career Decision Algorithm has been designed to help you identify a career direction and evaluate your educational plan.
        </div>
        <div style="clear: both; padding-top: 20px;">
        <div class="ThirdPage_StatsText" style="padding-left: 20px;">
            Below is an algorithm to help you in making career decision.</div>
        <div style="clear: both; padding-top: 30px;"></div>
        <div style="width: 100%;">
            <div style="width: 35%; float: left; padding-top: 10px;">
                <div class="chartflow">
                </div>
            </div>
            <div style="width: 65%; float: left; padding-top: 10px;">
                <div class="ThirdPage_StatsTextHeading">
                    <span style="padding-right: 10px;">
                        <img src="Sample-Report_12th_files/tik-mark.png" height="18px" width="20px"></span>Engage: <span class="ThirdPage_StatsText">
                            If you know ahead of time that you need to make a choice, you can:</span></div>
                <div class="ThirdPage_StatsText_2" style="padding-top: 5px;">
                    <span style="padding-right: 5px;">
                        <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span> maximize  the advantages of planning in advance; and</div>
                <div class="ThirdPage_StatsText_2" style="padding-top: 5px;">
                    <span style="padding-right: 5px;">
                        <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span> be confident that the educational plans you established reflect your selected career path
                </div>
                <div style="clear: both; padding-top: 10px;">
                </div>
                <div class="ThirdPage_StatsTextHeading">
                    <span style="padding-right: 10px;">
                        <img src="Sample-Report_12th_files/tik-mark.png" height="18px" width="20px"></span>Recognize:
                    <span class="ThirdPage_StatsText">The second step in selecting a career is to be aware of yourself and your options. Dissatisfaction in your work and lack of interest lead to depression and worthlessness. Take a moment to ask:</span></div>
                <div class="ThirdPage_StatsText_3">
                </div>
                <div>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>What do I adore? What are my likes and dislikes?</p>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>What are my capabilities? What am I good at?</p>
                </div>
                <div style="clear: both; padding-top: 10px;">
                </div>
                <div class="ThirdPage_StatsTextHeading">
                    <span style="padding-right: 10px;">
                        <img src="Sample-Report_12th_files/tik-mark.png" height="18px" width="20px"></span>Explore: <span class="ThirdPage_StatsText">
                            In this stage, you should begin to tally a career with your interests, personality, needs, aptitude and search about their educational demands.</span></div>
                <div style="clear: both; padding-top: 10px;">
                </div>
                <div class="ThirdPage_StatsTextHeading">
                    <span style="padding-right: 10px;">
                        <img src="Sample-Report_12th_files/tik-mark.png" height="18px" width="20px"></span>Plan: <span class="ThirdPage_StatsText">
                            In this step, check the prerequisites for your selected career option.  Find out:</span>
                </div>
                <div>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>Where is it available?</p>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>How much time will it take?</p>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>What assessment/tests/exam will I take?</p>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>What will it cost?</p>

                </div>

            </div>
        </div>
        <div style="clear: both; padding-top: 10px;">
        </div>
        <div class="ThirdPage_StatsTextHeading" style="padding-left: 20px;">
            <span style="padding-right: 10px;">
                <img src="Sample-Report_12th_files/tik-mark.png" height="18px" width="20px">
            </span>
            Evaluate: <span class="ThirdPage_StatsText">Display and classify your preference. Consider how satisfied you are with the selections you've made.</span>
        </div>
        <div>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>Consult career counselors about your career preferences.</p>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>Talk to your family about your choices and supply them with information about the desired education.</p>
                    <p class="ThirdPage_StatsText_4">
                        <span style="padding-right: 10px;">
                            <img src="Sample-Report_12th_files/arrow-icon-1.png" height="13px" width="12px"></span>Go back to thoroughly check if your choice is actually suitable for you. </p>
        </div>

        <div style="clear: both; padding-top: 10px;"></div>
        <div class="ThirdPage_StatsTextHeading" style="padding-left: 20px;">
            <span style="padding-right: 10px;">
                <img src="Sample-Report_12th_files/tik-mark.png" height="18px" width="20px"></span>Act: <span class="ThirdPage_StatsText">
                    Once you have gone through the steps listed above and you are sure of your career decision, be confident to execute the plan and pursue the educational requirements to get trained for the same. </span>
        </div>
        <div style="clear: both; padding-top: 20px;">
        <div class="SecondPageText_Header">
            More tips for
            <?php echo $fname.' '.$sname; ?></div>
            <div style="clear: both;">
        </div>
        <div class="Twenty5th_Text">
          Assessment tests are surely beneficial.  But ultimately it has to be your own choice in selecting a career or course of study.
        </div>
        <div style="clear: both; padding-top: 20px;">
        <div class="ThirdPage_StatsText" style="padding-left: 20px;">
          Below are more tips to understand:
        </div>
        <div style="width: 100%;">
        <div class="Stats_Point">
                <ul class="TikMark">
                    <li class="TikMarkHeight">Do not remain too quiet --- share your concerns and findings. Discuss about the career options with people who are more experienced than you are. Discuss favorable and unfavorable factors of different career opportunities. You may not understand each career in detail, but getting the basic knowledge of career will be helpful.</li>
                    <li class="TikMarkHeight">At an early age you must be aware and able to plan your career. Take up small jobs in fields which you like. It is not compulsory to be a paid job or a work in the real sense of it. You could just give some time to things you are passionate about.  For example, if you like dancing, keep trying different dance steps/styles. This could lead to a career in Choreography.</li>
                    <li class="TikMarkHeight">Always be careful when choosing a career. Something that attracts you from the outside may not be a good choice, so research properly before you make your final choice.</li>
                </ul>
        </div>
        </div>
        <div style="clear: both; padding-top: 5px;">&nbsp;</div>
        <div class="LastPage_Footer">
            <div style="padding-top: 5px;">
            </div>
            <div class="Footer_Box_Inner_3">
                <div class="Twenty5th_Text2">
                    For One-One Career Counseling:</div>
                <div class="Twenty5th_Text6">
                    Phone: +234 1 792 9652</div>
                <div class="Twenty5th_Text6">
                    Email: web@alearningsystems.net</div>
            </div>
            <div class="CopyRight" style="padding-top: 5px; padding-right: 30px;">
                                                                     <script type="text/javascript">
                                                                             document.write('Copyright &copy; ');
                                                                             var today = new Date();
                                                                             document.write(+ today.getFullYear());
                                                                             document.write('  Powered by <a href="http://www.skillgapfinder.com" target="_blank">SkillGapfinder</a>');
                                                                     </script>
			                                             <noscript>
									Copyright &copy; 2014  Powered by www.skillgapfinder.com
				                                     </noscript>
            </div>
        </div>
        <div style="clear: both; padding-bottom: 10px;"></div>
   </div>
</body></html>