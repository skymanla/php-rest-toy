<?php include_once 'include/common.header.php'; ?>
<div id="contents">
    <input type="hidden" id="GrSeq" value="<?=$list['common']['gr_seq']?>" />
	<div class="con-view-wrap">
		<div class="list">
			<div class="dim">
				<div>이름</div>
                <div><?=$list['common']['name']?></div>
			</div>
			<div class="dim">
				<div>생년월일</div>
                <div><?=$list['common']['birth']?></div>
			</div>
            <?php
            $arrival_checker = true;
//            if ($list['common']['departure_check'] === 'arrival2') $arrival_checker = true; // 공항 도착전입니다라면 true
            if (!empty($list['common']['decide_time'])) $arrival_checker = false; // 배송확정시간이 기입되면 false
            if ($list['common']['state'] === 'H') $arrival_checker = true; // 미수령이라면 변경이 가능해야 함.
            ?>
			<div <?=$arrival_checker === true ? '' : 'class="dim"' ?>>
				<div>도착예정시간</div>
				<div>
                    <?php
                    if ($arrival_checker === true) {
                    ?>
					<select name="" id="timer">
						<?php foreach($list['common']['timerGroup'] as $timer) { ?>
                        <option value="<?=$timer['value']?>" <?=$list['common']['arrival_time'] === $timer['value'] ? 'selected' : ''?>><?=$timer['view']?></option>
                        <?php } ?>
					</select>
                    <?php
                    } else {
                        echo $list['common']['view_arrival_time'];
                    }
                    ?>
				</div>
			</div>
			<div class="<?=!empty($list['common']['decide_time']) ? '' : 'dim'?>">
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
					<button type="button" class="arrive-ok-bt <?=!empty($list['common']['decide_time']) ? 'on' : ''?>" id="arriveTimePopOpen">변경</button>
				</div>
			</div>
		</div>

        <?php
        if (!empty($list['common']['decide_time'])) {
            $decideArray = explode(':', $list['common']['decide_time']);
        ?>
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
                                <div><input type="tel" class="pop-input" id="arriveHour" pattern="\d*" maxlength="2" value="<?=$decideArray[0]?>" /><span class="placeholder">시</span></div>
                                <div><input type="tel" class="pop-input" id="arriveMinute" pattern="\d*" maxlength="2" value="<?=$decideArray[1]?>" /><span class="placeholder">분</span></div>
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
        <?php } ?>

		<div class="strange-box">
			<div class="title">특이사항</div>
			<div class="textarea-box">
				<textarea name="memo" id="memo" placeholder="내용을 입력하세요"><?=$list['common']['memo']?></textarea>
			</div>
			<div class="bt-wrap">
				<a href="javascript:goCancel();" class="modify-bt-cancel">취소</a>
				<a href="javascript:goModify();" class="modify-bt-ok">수정완료</a>
			</div>
		</div>

        <?php
        $i = 1;
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
                    $is_currency = '소액원 포함';
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
                default:
                    $route_code = '-';
                    break;
            }
            ?>
            <div class="list dim <?=$refundClass?>">
                <div>
                    <div>외화<?=$i?></div>
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
	</div>
</div>
<?php include_once 'include/common.footer.php'; ?>