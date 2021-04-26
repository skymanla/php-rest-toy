<?php include_once 'include/common.header.php'; ?>
    <div id="contents">
        <div class="con-list-wrap">
            <div class="search-box-wrap">
                <form action="" method="get" name="searchForm">
                    <div class="search-box">
                        <div>
                            <select name="stx" id="stx">
                                <option value="name" <?=$list['stx'] === 'name' ? 'selected' : '' ?>>이름</option>
                                <option value="birth" <?=$list['stx'] === 'birth' ? 'selected' : '' ?>>생년월일</option>
                                <option value="tel" <?=$list['stx'] === 'tel' ? 'selected' : '' ?>>전화번호</option>
                            </select>
                        </div>
                        <div><input type="text" name="keyword" id="keyword" value="<?=$list['keyword']?>"></div>
                        <div><button type="button" onclick="document.searchForm.submit()">검색</button></div>
                    </div>
                </form>
            </div>
            <div class="con-tab">
                <ul>
                    <li <?=($list['airport'] !== 'T1' && $list['airport'] !== 'T2' && $list['airport'] !== 'wait') ? 'class="active"' : '' ?>><button type="button" onclick="goTab('All')">전체보기</button></li>
                    <li <?=$list['airport'] === 'T1' ? 'class="active"' : ''?>><button type="button" onclick="goTab('T1')">T1</button></li>
                    <li <?=$list['airport'] === 'T2' ? 'class="active"' : ''?>><button type="button" onclick="goTab('T2')">T2</button></li>
                    <li <?=$list['airport'] === 'wait' ? 'class="active"' : ''?>><button type="button" onclick="goTab('wait')">입금대기</button></li>
                </ul>
                <button type="button" class="reset" onclick="location.reload()"><i class="mi-text-hidden">새로고침</i></button>
            </div>
            <div class="con-list">
                <div class="list" id="js-slide-list">
                    <div class="tr thead">
                        <div class="terminal">장소</div>
                        <div class="time">도착시간</div>
                        <div class="name">이름</div>
                        <div class="currency">외화</div>
                        <div class="price">금액</div>
                    </div>
                    <?php if ($list['count'] < 1) { ?>
                        <div class="no-list">신청 내역이 없습니다</div>
                        <?php
                    } else {
                        foreach ($list['data'] as $item) {
                            ?>
                            <div class="tr">
                                <div class="terminal"><?= $item['view_airport_code'] ?></div>
                                <div class="time <?=$item['departure_check'] === 'arrival1' ? 'now' : '' ?>"><?= $item['view_arrival_time'] ?></div>
                                <div class="name">
                                    <?= $item['name'] ?><br>
                                    <?= $item['birth'] ?>
                                </div>
                                <div class="currency">
                                    <?=$item['cu_code']?>
                                </div>
                                <div class="price">
                                    <?=$item['view_price_other']?>
                                </div>
                            </div>
                            <div class="row-info js-slide-info">
                                <div class="bt-wrap">
                                    <button type="button" class="phone-call"
                                            onclick="window.location.href='tel:<?= $item['tel'] ?>'"><?= $item['tel'] ?></button>
                                    <button type="button"
                                            class="phone-icon ok <?= $item['is_call'] === 'Y' ? 'active' : '' ?>"
                                            data-call="call-action" data-value="<?= $item['gr_seq'] ?>"><i
                                            class="mi-text-hidden">통화완료</i></button>
                                    <button type="button"
                                            class="phone-icon no <?= $item['is_call'] === 'N' ? 'active' : '' ?>"
                                            data-call="call-action" data-value="<?= $item['gr_seq'] ?>"><i
                                            class="mi-text-hidden">통화실패</i></button>
                                    <a href="/view/<?= $item['gr_seq'] ?>" class="more-info">상세보기</a>
                                </div>
                                <?php if (!empty($item['memo'])) { ?>
                                    <div class="info">
                                        <div>특이사항</div>
                                        <div><?= $item['memo'] ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php echo $list['navigator']; ?>
            </div>
        </div>
    </div>
<?php include_once 'include/common.footer.php'; ?>