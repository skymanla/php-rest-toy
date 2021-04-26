<?php
$currency = 'USD';
$amount = 100;

$amountArray = ['100', '300', '500', '1000', '2000'];

for ($i = 0; count($amountArray) > $i; $i++) {
    $url = 'https://exchange.hanpass.com/exchange/web/v1/estimate/exchange-amount?termCurrencyCode='.$currency.'&termAmount='.$amountArray[$i].'&partnerCode=HANPASS&access_token=eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhZG1pbl9wYXJ0bmVyQ29kZSI6IkhBTlBBU1MiLCJ1c2VyX25hbWUiOiJBZG1pbldlYiIsInNjb3BlIjpbInJlYWQiLCJ3cml0ZSJdLCJhZG1pbl9pZCI6IkFkbWluV2ViIiwiYWRtaW5fbmFtZSI6Iu2ZmOyghOybueqwnOuwnOyekCIsImV4cCI6MTU3ODQ2ODczMSwiYXV0aG9yaXRpZXMiOlsiUk9MRV9VU0VSX1dFQiJdLCJqdGkiOiI1MGNkYjNjNS04MWVkLTQwYzEtOWRkMy0zOTdmMGM5OGYxMzIiLCJjbGllbnRfaWQiOiJhZG1pbl93ZWIifQ.nJt6m5_peT1AgI99Exn5zhxl--2Wy1VpgeyFweH-8WaannP0nS5GArHLDZbnrLn1BE99OhWawVw8R2kusywYumkSruTIeuUXkp5srhUrQD1N0_JZCthX9aF0lovZrxMrlumRDw_ys_zwx5gL6MenqA3O0KlVrUaQ6fTYbaCfuEBdBw7CYGJ8opP0OYtnHRn-jYpjgOCdd4lB2nWgA8ZX89GeDlw-oSTPsKQhqbZZf-zekyPRilnQSH7FrmmssjGZ53SL7zYfu0adZaPgEqJLoYUrjvMAhbiY7Ep8VKQ7vTSLFR28m2uYUiG7vg-K0UcH1A-xJNTWXMvyaTTMjGgRCg&estimateSeq=undefined';

    $ch = curl_init();                                 //curl 초기화
    curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

    $response = curl_exec($ch);
    curl_close($ch);
}
