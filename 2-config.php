<?php
ini_set("display_errors", 1);
$db='sgfals';
$connect = mysqli_connect('enduserweb12.znetindia.net', 'skillgap', 'HjF)@gDzG567Gcs', 'sgfals', 3309);
if (!$connect)
  {
  die('Could not connect: ' . mysqli_error());
  }
$slectdb=mysqli_select_db($connect,$db );
if(!$slectdb){
printf("Can't connect to MySQL Server. Errorcode: %s\n", mysqli_connect_error());
exit;
}
// ***** SITE TITLE, KEYWORDS, DESCRIPTION *****

$SITE_TITLE		= "SkillGapfinder - Career Testing, Assessment";
$SITE_KEYWORDS		= "Aptitude Test, Assessment, Career Ladder";
$SITE_DESCRIPTION	= "Online Skill Assessment and testing";


// ***** Administration user/password *****

// Authentication Method:
// 0 - no authentication
// 1 - http
// 2 - session
$AUTH_TYPE = "2";

// ***** Email configuration (used for signup and newsletter sections) *****

$MAIL_ACTIVATE_URL = "http://als.skillgapfinder.com/verify.php?id=";

$MAIL_HOST = "mail.skillgapfinder.com";	// SMTP servers
$MAIL_SMTPAUTH = true;			// turn on SMTP authentication
$MAIL_USERNAME = "info@ca.skillgapfinder.com";		// SMTP username
$MAIL_PASSWD = "Sksaxena61@IPR123";		// SMTP password
$MAIL_FROM = "SkillGapfinder <info@ca.skillgapfinder.com>";


$MAIL_REGISTERUSER_SUBJECT = "Welcome to SkillGapfinder";

$MAIL_REGISTERUSER_BODY = "<p>Thank you for signing up with SkillGapfinder.com.&nbsp;</p><p>To activate your account just follow this link:</p><p><a href=\"".$MAIL_ACTIVATE_URL."USER_ID&activate=ACTIVATION_CODE\">".$MAIL_ACTIVATE_URL."USER_ID&activate=ACTIVATION_CODE</a></p><p>If you have received this mail in error, please ignore.</p>";

$MAIL_REGISTERUSER_ALTBODY = "/n/nThank you for signing up with SkillGapfinder.com.&nbsp;/n/nTo activate your account just follow this link:/n/n".$MAIL_ACTIVATE_URL."USER_ID/n/nIf you have received this mail in error, please ignore.";

$MAIL_FORGOTPASSWD_SUBJECT = "SkillGapfinder Account Info";
$MAIL_FORGOTPASSWD_BODY = "<p>Your password for SkillGapfinder account is:</p>";
$MAIL_FORGOTPASSWD_ALTBODY = "/n/nYour password for SkillGapfinder account is:/n/n";

$MAIL_CONTACT_SUBJECT = "SkillGapfinder: New contact message.";

// *** Logging ***

$RECORD_LOG = true;
$LOG_FILE = "website.log";

// MUST BE "FALSE" TO DENY GUESTS DOWNLOADS
$DOWNLOAD_GUESTS_ALLOWED = true;

// true - referrer protection activated, false - disabled
$REFERRER_PROTECTION = true;
// this is the list of referrers you want to allow
// use the following format within the parentheses:
//   'http://domain1.com', 'http://domain2.com', ...
$DOWNLOAD_ALLOW_LIST = array( 'http://localhost', 'http://als.skillgapfinder.com', 'http://www.regsoft.com' );

$DOWNLOAD_MESSAGE = "<p align=\"center\"><b><font face=\"Arial\">The page is loading...</font></b></p><p align=\"center\">Please wait...</td>";
$DOWNLOAD_ERROR = "<p align=\"center\"><b><font face=\"Arial\">404 Not Found.<br><a href=\"http://als.skillgapfinder.com\">Click Here</a></font></b></p>";
?>