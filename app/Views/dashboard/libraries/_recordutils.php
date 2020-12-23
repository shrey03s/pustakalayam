<?php

function getOrderBy($page) {
    $orderby = 'date';
    foreach ($page->orderfields as $key => $value) {
        if (in_array('selected', $value)) {
            $orderby = $value['field'];
        }
    }
    return $orderby;
}

function isDateFilterNeeded($page) {
    $vs = array_values($page->tablefields);
    foreach ($vs as $v) {
        if(isset($v['date'])) {
            return true;
        }
    }
}
