<?php
?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="../js/zingchart-html5-min.js"></script>
<script type="text/javascript">
window.onload = function(){
zingchart.render({
			dataurl 		: '../Data/col3dpem.php',
			width			: '320',
			height			: '320',
			container 		: 'zingchart',
 		        output                  : 'canvas',
			wmode			: 'transparent'
	});


}
</script>

</head>
<body topmargin="0" leftmargin="0" bottomMargin="0" rightMargin="0" bgColor="#EEEEEE">
<table width="320" align="center" cellspacing="0" cellpadding="0">
  <tr>
	<td width="340" align="center">
      <div id="zingchart"></div>
	</td>
 
	</tr>
</table>
</body>
</html>



