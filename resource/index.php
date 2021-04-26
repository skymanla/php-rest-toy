<?php
include_once 'include/common.header.php';
$saveID = '';
$checkSave = false;
if (isset($_COOKIE['SAVE_ID'])) {
    $saveID = $_COOKIE['SAVE_ID'];
    $checkSave = true;
}
?>
<div class="login-box">
	<h1>INDEX</h1>
	<p class="copy">MAIN</p>
</div>
<?php include_once 'include/common.footer.php'; ?>
