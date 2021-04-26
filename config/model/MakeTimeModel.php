<?php

namespace App\Model;

class MakeTimeModel
{
    // 터미널 및 현재 시간 기준 선택 가능한 시간 만들기
    public function makeTime($startHour = '', $endHour = '')
    {
        $date_arr = []; // return 할 배열
        $dateH = !empty($startHour) ? $startHour.':00' : date('H').':00'; // 시작 시간이 있으면 쓰고 없으면 현재 시간
        $dateM = date('i'); // 현재 분(단위 00)
        if (empty($endHour)) {
            $endHour = strtotime('21:00'); // 터미널 영업 종료 시간
        } else {
            $endHour = strtotime($endHour);
        }
        $startHour = strtotime($dateH); // timestamp 로 변경

        if ($dateM >= '00' && $dateM < '30') { // 0분 ~ 29분 사이면 현재 시 + 30분
            $startHour = strtotime('+30 minutes', $startHour);
        } elseif ($dateM >= '30' && $dateM <= '59') { // 30분 ~ 59분 사이면 다음 시
            // +1 hour 노출
            $startHour = strtotime('+1 hours', $startHour);
        }


        while ($startHour <= $endHour) { // 시간을 만들어 봅시다.
            $item = ['value' => '', 'view' => '', 'class' => '']; // 넘겨줄 object class (type json)
            $newTime = ''; // 가공될 시간(->view)
            $items = date('H:i', $startHour); // timestamp 로 된 시간을 다시 date 형식으로
            $item['value'] = $items; // option value 로 들어갈 녀석
            $item['view'] = $items.'경'; // 새로 만들어진 시간은 view 로
            // preg_match 로 class binding
            // 오전 > color-blue, 낮 > color-red, 오후 > ''
            if (preg_match('/오전/', $item['view'])) {
                $item['class'] = 'color-blue';
            } elseif (preg_match('/낮/', $item['view'])) {
                $item['class'] = 'color-red';
            }
            array_push($date_arr, $item); // 배열에 처담처담
            $startHour = strtotime('+30 minutes', $startHour); // 시작시간을 30분 증가(선택 단위가 30분 단위)
        }

        return $date_arr;
    }

    // 시분 쪼개서 12시간제로 만들기 -> 관리 포인트인 사이트는 24시간제로
    public static function makeOneTime($time)
    {
        $timeArray = explode(':', $time);
        $hours = sprintf('%d', $timeArray[0]);
        if (!isset($timeArray[1]) || empty($timeArray[1])) {
            $time = '00';
        } else {
            $time = $timeArray[1];
        }
        $viewHours = '';
        $viewTime = '';
        if ($hours >= 12) {
            if ($hours == 12 && $time !== '00') {
                $viewHours = '오후 12시';
            } elseif ($hours == 12 && $time === '00') {
                $viewHours = '낮 12시';
            } else {
                $viewHours = '오후 '.($hours - 12).'시';
            }

        } else {
            $viewHours = '오전 '.$hours.'시';
        }

        if ($time === '00') {
            // pass
        } else {
            $viewTime = ' '.$time.'분';
        }

        return $viewHours.$viewTime.'경';
    }

    // 요일 계산기
    public static function weekend($type, $date, $lang = 'kor', $wek = 'st')
    {
        switch ($type) {
            case "ymd":
                $return = date('w', strtotime($date.'0000'));
                break;
            case "y-m-d":
                $return = date('w', strtotime($date));
                break;
            case "timestamp":
                $return = date('w', $date);
                break;
            default:
                return;

        }
        $week_arr = [];
        if ($lang == 'kor') {
            if ($wek == 'st') {
                $week_arr = ['일', '월', '화', '수', '목', '금', '토'];
            } elseif ($wek == 'lt') {
                $week_arr = ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'];
            }
        } else {
            if ($wek == 'st') {
                $week_arr = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            } elseif ($wek == 'lt') {
                $week_arr = ['SunDay', 'MonDay', 'TuesDay', 'WednesDay', 'ThursDay', 'FriDay', 'SaturDay'];
            }
        }

        return $week_arr[$return];
    }
}