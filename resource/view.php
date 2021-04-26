<?php include_once 'include/common.header.php'; ?>
<div id="contents">
    <input type="hidden" id="GrSeq" value="<?=$list['common']['gr_seq']?>" />
	<div class="con-view-wrap">
		<div class="list">
			<div>
				<div>이름</div>
				<div><?=$list['common']['name']?></div>
			</div>
			<div>
				<div>생년월일</div>
				<div><?=$list['common']['birth']?></div>
			</div>
			<div>
				<div>도착예정시간</div>
				<div>
					<div><?=$list['common']['view_arrival_time']?></div>
                    <?php
                    if (!empty($list['common']['changeTimer'])) {
                    ?>
					<span class="state-change">
                        변경전 <?=$list['common']['changeTimer']?>
                    </span>
                    <?php } ?>
				</div>
			</div>
			<div>
				<div>도착확정시간</div>
				<div>
					<div id="arriveTime">
                        <?php
                        if (!empty($list['common']['decide_time'])) {
                            $decideTimeView = $list['common']['decide_time'];
                            $decideTime = explode(':', $list['common']['decide_time']);
                            if (empty($decideTime[1])) {
                                $decideTimeView = $decideTime[0].':00';
                            }
                        ?>
                        <span><?=$decideTimeView?></span>
                        <?php } else { ?>
                        <span class="no-data">미정</span>
                        <?php } ?>
                    </div>
					
					<?php
					if (!empty($list['common']['decide_time'])) {
                        if (!empty($list['common']['decideHistory'])) {
                            $decideHistoryView = $list['common']['decideHistory'];
                            $decide = explode(':', $list['common']['decideHistory']);
                            if (empty($decide[1])) {
                                $decideHistoryView = $decide[0].':00';
                            }
                            ?>
                            <span class="state-change">변경전 <?= $decideHistoryView ?></span>
                    <?php
                        }
					} else {
                    ?>
					<button type="button" class="arrive-ok-bt <?=$list['common']['isNew'] === false ? 'on' : ''?>" id="arriveTimePopOpen">입력</button>
					<?php } ?>
				</div>
			</div>
		</div>

		<!-- STR 도착확정시간 팝업-->
		<div class="mi-common-pop info-box1" id="arriveTimePop" tabindex="0" >
			<div>
				<div class="box-wrap">
					<button type="button" class="close-x close-pop"></button>
					<div class="copy-wrap t-a-c">
						<h2 class="title type1">확정시간 입력</h2>
						<div class="copy-box">
							전화를 통해 확정된 수령시간을 입력해주세요<br>
							시간이 등록되면 <b class="color-point1">배송중</b>으로 상태가 변경됩니다
							<div class="pop-list2">
								<div><input type="tel" class="pop-input" id="arriveHour" pattern="\d*" maxlength="2"><span class="placeholder">시</span></div>
								<div><input type="tel" class="pop-input" id="arriveMinute" pattern="\d*" maxlength="2"><span class="placeholder">분</span></div>
							</div>
						</div>
					</div>
					<div class="bt-wrap">
						<ul>
							<li class="w-2"><button type="button" class="no-bt no-bt-ac">취소</button></li>
							<li class="w-2"><button type="button" class="yes-bt yes-bt-ac">확인</button></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- STR 도착확정시간 팝업-->

		<div class="strange-box">
			<div class="title">특이사항</div>
			<div class="info">
                <?php
                if (!empty($list['common']['memo'])) {
                ?>
                <span><?=$list['common']['memo']?></span>
                <?php } else { ?>
				<span class="no-data">없음</span>
                <?php } ?>
			</div>

            <?php if ($list['common']['state'] !== 'E') { ?>
			<div class="bt-wrap">
				<a href="/modify/<?=$list['common']['gr_seq']?>" class="modify-bt-ok">수정하기</a>
			</div>
            <?php } ?>
		</div>

        <?php
        $i = 1;
        if (count($list['childGroup']) === 1) {
            $i = 0;
        }
        foreach ($list['childGroup'] as $child) {
            // 환불 class
            $refundClass = '';
            if ($child['state'] === 'G' || $child['state'] === 'GU') {
                $refundClass = 'refund';
            }

            // 권종선택
            switch ($child['is_currency']) {
                case 'X':
                    $is_currency = '상관없음';
                    break;
                case 'Y':
                    $is_currency = '고액권만';
                    break;
                case 'Z':
                    $is_currency = '고액권 위주';
                    break;
                default:
                    $is_currency = '-';
                    break;
            }

            // 제휴
            switch ($child['route_code']) {
                case 'AY-BCpaybooc':
                    $route_code = 'BC(할인)';
                    break;
                case 'AN-BCpaybooc':
                    $route_code = 'BC(일반)';
                    break;
                case 'iall':
                    $route_code = '아이올';
                    break;
                case 'triple':
                    $route_code = $child['route_code'];
                    break;
                default:
                    $route_code = '-';
                    break;
            }
        ?>
            <div class="list <?=$refundClass?>">
                <div>
                    <div>외화<?=$i === 0 ? '' : $i?></div>
                    <div><?=$child['cu_nation'].' '.$child['cu_unit1']?></div>
                </div>
                <div>
                    <div>금액</div>
                    <div><?=number_format($child['price_other'])?></div>
                </div>
                <div>
                    <div>권종선택</div>
                    <div><?=$is_currency?></div>
                </div>
                <div>
                    <div>제휴</div>
                    <div><?=$route_code?></div>
                </div>
            </div>
        <?php
            $i++;
        }
        ?>
		<div class="list">
			<div>
				<div>환전이력</div>
				<div><?=$list['common']['exchangeCount']?>회</div>
			</div>
		</div>

        <?php if($list['common']['state'] !== 'E') { ?>
		<div class="call-list">
			<div>
				<div class="title">연락처</div>
				<div class="bt-wrap">
					<button type="button" class="phone-call" onclick="window.location.href='tel:<?=$list['common']['tel']?>'"><?=$list['common']['tel']?></button>
					<button type="button" class="phone-icon ok <?=$list['common']['callHistory'][2] === 'Y' ? 'active' : ''?>" data-call="call-action" data-value="<?=$list['common']['gr_seq']?>"><i class="mi-text-hidden">통화완료</i></button>
					<button type="button" class="phone-icon no <?=$list['common']['callHistory'][2] === 'N' ? 'active' : ''?>" data-call="call-action" data-value="<?=$list['common']['gr_seq']?>"><i class="mi-text-hidden">통화실패</i></button>
				</div>
			</div>
			<div class="info" id="callInfo" <?=$list['common']['callHistory'] !== 'C' ? 'style="display: block"' : '' ?>>
                <?php
                if ($list['common']['callHistory'] !== 'C') {
                    echo '통화연결: '.$list['common']['callHistory'][0].' ('.$list['common']['callHistory'][1].')';
                }
                ?>
            </div>
		</div>
        <?php } ?>

		<div class="sign-wrap">
			<div class="title">수령인 서명</div>
			<div class="con">
                <?php
                if ($list['common']['state'] === 'D') {
                    if ($list['common']['isNew'] === false) {
                        $isSignClass = 'on';
                    } else {
                        $isSignClass = '';
                    }
                } else {
                    $isSignClass = '';
                }
                ?>

                <?php if ($list['common']['state'] !== 'E') { ?>
				<button type="button" class="sign-pop-open <?=$isSignClass?>" id="signPopOpenBt">서명 받기</button>
                <?php
                } else {
                    $findSign = false;
                    $imgBaseEncoding = '';
                    if (!empty($list['common']['signImage'])) {
                        $findSign = true;
                        $imgBaseEncoding = base64_encode(file_get_contents('/data/upload/signImg'.$list['common']['signImage']));
                    }
                ?>
                <div class="img-box">
                    <img src="<?=$findSign === true ? 'data:image/png;base64, '.$imgBaseEncoding : ''?>" alt="<?=$list['common']['name']?>의 서명" />
                </div>
                <?php } ?>
			</div>
		</div>
		<!-- STR 서명받기 팝업-->
		<div class="sign-pop" id="signPop">
			<div>
				<div class="title">
					<div class="logo">수령인 서명</div>
					<button type="button" class="close"><i class="mi-text-hidden">닫기</i></button>
				</div>
				<div class="con">
					<div class="con-box" id="signaturePad"><canvas></canvas></div>
					<button type="button" class="reset"><i class="mi-text-hidden">리셋</i></button>
					<button type="button" class="ok">확인</button>
				</div>
			</div>
		</div>
		<!-- END 서명받기 팝업-->

        <?php if ($list['common']['showTravelInput'] === true) { ?>
		<div class="list type2" style="display:<?=empty($list['common']['viewTravelInput']) ? 'none' : 'block'?>">
			<div>
				<div>목적지</div>
				<div><input type="text" name="travelInput" class="mi-input" value="<?=$list['common']['viewTravelInput']?>"></div>
			</div>
		</div>
        <?php } ?>

        <?php
        $showBox = false;
        if($list['common']['state'] === 'E') $showBox = true;
        ?>
		<div class="receipt-end-box" <?=$showBox === true ? 'style="display:block"' : ''?>>
			<b><?=date('H:i', strtotime($list['common']['receive_time']))?></b>분 수령완료
		</div>
        <?php if ($list['common']['state'] !== 'E') { ?>
		<div class="receipt-bt-wrap">
			<div><button type="button" class="receipt-bt-no <?=$list['common']['isNew'] === false ? 'on' : ''?> <?=$list['common']['state'] === 'H' ? 'active' : ''?>">미수령</button></div>
			<div><button type="button" class="receipt-bt-ok">수령완료</button></div>
		</div>
        <?php } ?>

        <?php if (!empty($list['common']['actionHistory'])) { ?>
		<div class="info-log">
			<button type="button" class="info-log-pop" id="infoLogPopBt">수정로그 보기</button>
		</div>
        <?php } ?>

		<!-- STR 수정로그 팝업 -->
		<div class="mi-common-pop info-box1" id="infoLogPop" tabindex="0">
			<div>
				<div class="box-wrap full">
					<button type="button" class="close-x close-pop"></button> 
					<div class="copy-wrap">
						<h2 class="title type1 psfixed"><?=$list['common']['name']?>님 수령시간 수정로그</h2>
						<div class="copy-box">
							<div class="pop-list3-wrap">
								<div class="pop-list3">
									<div class="thead">
										<div></div>
										<div>시간</div>
										<div>수정내용</div>
										<div>수정인</div>
										<div>수정일시</div>
									</div>
									<div class="tbody">
                                        <?php
                                        $board_no = count($list['common']['logHistory']);
                                        if (is_array($list['common']['logHistory'])) {
                                            krsort($list['common']['logHistory']);
                                            foreach ($list['common']['logHistory'] as $actionLog) {
                                                $actionItem = explode('|', $actionLog);

                                                $actionUserName = $actionItem[0];
                                                if ($list['common']['tel'] === $actionItem[0]) {
                                                    $actionUserName = '사용자';
                                                }

                                                $actionName = empty($actionItem[4]) ? '관리자' : $actionItem[4];

                                                $changeActionView = $actionItem[1];
                                                $changeAction = explode(':', $actionItem[1]);
                                                if (empty($changeAction[1])) {
                                                    $changeAction[1] = ':00';
                                                    $changeActionView = $changeAction[0].$changeAction[1];
                                                }
                                                ?>
                                                <div>
                                                    <div><?= $board_no ?></div>
                                                    <div><?= $actionName ?></div>
                                                    <div><?= $changeActionView ?></div>
                                                    <div><?= $actionUserName ?></div>
                                                    <div><?= date('m-d H:i:s', strtotime($actionItem[3])) ?></div>
                                                </div>
                                                <?php
                                                $board_no--;
                                            }
                                        }
                                        ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END 수정로그 팝업 -->

	</div>
</div>
<?php include_once 'include/common.footer.php'; ?>