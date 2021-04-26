<?php

namespace  App\Model;

class Pagination
{
    private $curPage;
    private $offset;
    private $limitSet;
    private $showOffset;

    public function __construct($curPage = '')
    {
        $this->curPage = empty($curPage) ? 1 : $curPage;
        $this->limitSet = (int) 15;
    }

    public function getPaginationQuery()
    {
        $this->showOffset = ($this->curPage - 1) * $this->limitSet;

        return " limit {$this->showOffset}, {$this->limitSet}";
    }

    public function getPaginationNavigator($page, $getParam, $countItem)
    {
        $total = floor ( $countItem / $this->limitSet ) + 1; // 총 페이지 수

        $first_page_num = (floor ( ($this->curPage - 1) / 5 )) * 5 + 1; // 1,11,21,31...
        $last_page_num = $first_page_num + 4; // 10,20,30...last
        $next_page_num = $last_page_num + 1;
        $prev_page_num = $first_page_num - 5;

        if (empty($getParam) || $getParam === null) {
            $getParam = '';
        }

        // html value
        $nav = '<nav>';
        if ($total > 5 ) {
            // 맨 첫 페이지 가는 분기
            if ((int)$this->curPage === 1){
                $nav .= '<a href="javascript:void(0);" class="arr prev-end off"><i class="mi-text-hidden">맨처음</i></a>';
            }else {
                $nav .= '<a href="/'.$page.'/1'.$getParam.'" class="arr prev-end"><i class="mi-text-hidden">맨처음</i></a>';
            }

            // 이전 페이지 분기
            if ($this->curPage - 1 === 0) {
                $nav .= '<a href="javascript:void(0);" class="arr prev off"><i class="mi-text-hidden">이전</i></a>';
            } else {
                $nav .= '<a href="/'.$page.'/'.($this->curPage - 1).$getParam.'" class="arr prev"><i class="mi-text-hidden">이전</i></a>';
            }
        }

        // 숫자 버튼 페이지 분기
        for($i = $first_page_num; $i <= $total && $i <= $last_page_num; $i ++) {
            if ($this->curPage == $i) {
                $nav .= '<a href="javascript:void(0);" class="active">'.$i.'</a>';
            } else {
                $nav .= '<a href="/'.$page.'/'.$i.$getParam.'">'.$i.'</a>';
            }
        }

        if ($total > 5 ) {
            // 다음 페이지 분기
            if ($total > $last_page_num) {
                $nav .= '<a href="/'.$page.'/'.($this->curPage + 1).$getParam.'" class="arr next"><i class="mi-text-hidden">다음</i></a>';
                $nav .=	'<a href="/'.$page.'/'.($total).$getParam.'" class="arr next-end"><i class="mi-text-hidden">맨끝</i></a>';
            } else {
                $nav .= '<a href="javascript:void(0);" class="arr next off"><i class="mi-text-hidden">다음</i></a>';
                $nav .=	'<a href="javascript:void(0);" class="arr next-end off"><i class="mi-text-hidden">맨끝</i></a>';
            }
        }
        $nav .= '</nav>';
        return $nav;
    }
}

