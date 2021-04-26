<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,,height=device-height,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>마이뱅크 - 공항환전 배송기사</title>

	<!-- STR favicon -->
	<link rel="shortcut icon" href="/images/favicon/favicon.png" />
	<!-- END favicon -->

	<!-- STR css link -->
	<link rel="stylesheet" href="/css/reset.css?v=<?php echo time(); ?>" />
	<link rel="stylesheet" href="/css/layout.css?v=<?php echo time(); ?>" />
	<link rel="stylesheet" href="/css/contents.css?v=<?php echo time(); ?>" />
	<link rel="stylesheet" href="/js/mi.plugin/popup/v1.1/css/mi.design.pop.css?v=<?php echo time(); ?>" />
	<!-- END css link -->

	<!-- STR script link -->
	<script src="/js/plugin/jquery/jquery-3.4.1.min.js"></script>
	<!-- END script link -->

</head>
<body>
	<div id="wrap">
		<?php
        if($parentPath){
            $pushClass = '';
            if (count($notification['tabT1']) > 0 || count($notification['tabT2']) > 0) {
                $pushClass = 'push';
            }

            $tabT1Push = '';
            if (count($notification['tabT1']) > 0) {
                $tabT1Push = 'push';
            }

            $tabT2Push = '';
            if (count($notification['tabT2']) > 0) {
                $tabT2Push = 'push';
            }
        ?>
		<header <?php if($parentPath !== 'list' && $parentPath !== 'w-list'){ ?>class="bg1"<?php } ?>>
			<h1><a href="/list/1"><i class="mi-text-hidden">마이뱅크 공항환전</i></a></h1>
			<button type="button" class="push-bt-open <?=$pushClass?>"><span class="name"><?=$_SESSION['USER_NAME']?></span> <i class="mi-text-hidden">알림</i></button>
			<div class="push-list-wrap">
				<div>
					<h2>알림함</h2>
					<button type="button" class="push-bt-close"><i class="mi-text-hidden">알림함 닫기</i></button>
					<div class="tab">
						<ul>
							<li class="active"><button type="button"><span>전체</span></button></li>
							<li><button type="button"><span class="<?=$tabT1Push?>">인천T1</span></button></li>
							<li><button type="button"><span class="<?=$tabT2Push?>">인천T2</span></button></li>
						</ul>
					</div>
					<div class="list">
						<ul class="active">
                            <?php
                            // All
                            if (count($notification['tabAll']) < 1) {
                                echo <<<END
                                <li>
                                    <div class="no-list">신청 내역이 없습니다</div>
                                </li>
                                END;
                            } else {
                                foreach ($notification['tabAll'] as $tabAll) {
                            ?>
                            <li class="time"><div><?=date('H:i', strtotime($tabAll['timezone']))?></div></li>
                                        <?php
                                        foreach($tabAll['timedata'][0] as $item) {
                                            ?>
                                            <li>
                                                <div class="code"><?= $item['airport_code'] ?></div>
                                                <div class="time"><?= $item['arrival_time'] ?></div>
                                                <div class="name"><?= $item['name'] ?></div>
                                                <div class="birth"><?= $item['birth'] ?></div>
                                            </li>
                                            <?php

                                    }
                                }
                            }
                            ?>
						</ul>
						<ul>
                            <?php
                            // T1
                            if (count($notification['tabT1']) < 1) {
                                echo <<<END
                                <li>
                                    <div class="no-list">신청 내역이 없습니다</div>
                                </li>
                                END;
                            } else {
                                foreach ($notification['tabT1'] as $item) {
                            ?>
                            <li>
								<div class="code"><?= $item['airport_code'] ?></div>
                                <div class="time"><?= $item['arrival_time'] ?></div>
                                <div class="name"><?= $item['name']?></div>
                                <div class="birth"><?= $item['birth'] ?></div>
                            </li>
                            <?php
                                }
                            }
                            ?>
						</ul>
						<ul>
                            <?php
                            // T1
                            if (count($notification['tabT2']) < 1) {
                                echo <<<END
                                <li>
                                    <div class="no-list">신청 내역이 없습니다</div>
                                </li>
                                END;
                            } else {
                                foreach ($notification['tabT2'] as $item) {
                            ?>
                            <li>
								<div class="code"><?= $item['airport_code'] ?></div>
                                <div class="time"><?= $item['arrival_time'] ?></div>
                                <div class="name"><?= $item['name']?></div>
                                <div class="birth"><?= $item['birth'] ?></div>
                            </li>
                            <?php
                                }
                            }
                            ?>
						</ul>
					</div>
				</div>
			</div>
		</header>
		<?php } ?>