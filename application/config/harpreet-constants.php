<?php
define('CANCEL_LABEL', 'Cancel');
if (!function_exists('changeDateFormat')) {

    function changeDateFormat($originalDate, $format = NULL)
    {
        if (!empty($originalDate)) {
            $originalDate = str_replace('/', '-', $originalDate);
            $originalDate = (!empty($format)) ? date($format, strtotime($originalDate)) : date('d-m-Y', strtotime($originalDate));
            if ($originalDate == '0000-00-00' || $originalDate == '00-00-0000' || $originalDate == '1970-01-01' || $originalDate == '01-01-1970') {
                return NULL;
            } else {
                return $originalDate;
            }
        } else {
            return NULL;
        }
    }
}