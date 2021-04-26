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
	<h1>배송관리자</h1>
	<p class="copy">마이뱅크 공항외화배송 서비스</p>
	<form action="" method="post" name="LoginForm">
		<input type="text" class="email" name="userEmail" placeholder="이메일" value="<?=$saveID?>">
		<input type="password" class="password" name="userPwd" placeholder="비밀번호">
		<button type="button" onclick="document.LoginForm.submit()">로그인</button>
		<div class="label-wrap"><input type="checkbox" id="email-save" name="emailSave" <?=$checkSave === true ? 'checked' : ''?>><label for="email-save">이메일 저장</label></div>
	</form>
</div>
<?php include_once 'include/common.footer.php'; ?>