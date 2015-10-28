<?php
	include ("class_lib.php");
	session_start();
	if (!isset($_SESSION['myContent'])) {
		$_SESSION['myContent'] = new pgContent;
		$_SESSION['myContent']->load_menu();
	}
	if (isset($_REQUEST['p'])) {
		$_SESSION['myContent']->PageProcess($_REQUEST['p']);
	}
	
?>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>David Vernon</title>
<link href='style.css' rel='stylesheet' type='text/css' />
<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//   -->
</script>
</head>
<body bgcolor='<?php echo $_SESSION['myContent']->bgColor; ?>'>
    <div id='container'>
        <div id='header'><?php include("header.php"); ?></div>
        <div id='navigation' class='menu-<?php echo $_SESSION['myContent']->mStyle; ?>'>
        	<?php include("menu.php"); ?>
        </div>
        <div id='content' align='left'>
			<?php include($_SESSION['myContent']->pURL); ?>
        </div>
        <div id='footer'>
            <?php include("footer.php"); ?>
        </div>
    </div>
</body>
</html>
