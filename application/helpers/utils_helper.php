<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Utils helper
 * @author HighGo Info solutions
 */

/**
 * Alert success
 */
function alert_success($msg)
{
    return '<div class="alert alert-success"><strong>Success!</strong><br>' . $msg . '</div>';
}

/**
 * Alert error or danger
 */
function alert_danger($msg)
{
    return '<div class="alert alert-danger"><strong>Error!</strong><br>' . $msg . '</div>';
}

/**
 * Alert information
 */
function alert_info($msg)
{
    return '<div class="alert alert-info"><strong>Error!</strong><br>' . $msg . '</div>';
}

/**
 * Date format
 */
function displayDate($date, $time_flag = 0) {
    if($time_flag) {
        return date('d-m-Y H:i', strtotime($date));
    }
    else {
        return date('d-m-Y', strtotime($date));
    }
}

/**
 * Number format
 */
function displayNumber($number, $decimals = 0) {
    return number_format($number, $decimals);
}

/**
 * Display Money
 */
function displayMoney($number, $decimals = 0) {
    return ' &#8377; ' . number_format($number, $decimals);
}

/**
 * Convert any number to words with Ruppes and Paise
 */
function moneyInWords($number)
{
    $number_array = explode('.', $number);
    $rupees = num2Word($number_array[0]);
    $paise_str = '';
    if(isset($number_array[1])) {
        $paise_number = (strlen($number_array[1]) == 1) ? $number_array[1].'0' : $number_array[1];
        $paise = num2Word($paise_number);
        $paise_str = 'And ' . $paise . ' Paise';
    }
    return $rupees . "Rupees  " . $paise_str;
}
/**
 * Number to word
 */
function num2Word($number)
{
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '',
        '1' => 'one',
        '2' => 'two',
        '3' => 'three',
        '4' => 'four',
        '5' => 'five',
        '6' => 'six',
        '7' => 'seven',
        '8' => 'eight',
        '9' => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' =>'nineteen',
        '20' => 'twenty',
        '30' => 'thirty',
        '40' => 'forty',
        '50' => 'fifty',
        '60' => 'sixty',
        '70' => 'seventy',
        '80' => 'eighty',
        '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural  . " " . $hundred;
        }
        else {
            $str[] = null;
        }
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    return $result;
}
//
/*
* Convert SCM To MMBTU
*/
function convertToMmbtu($scm,$gcv)
{
    if(isset($gcv) && !empty($gcv)){
        $gcv = $gcv;
    }
    else {
        $gcv = '9294.11';
    }
    return $mmbtu = $scm*($gcv/252000);
}
/*
* Convert SCM To MMBTU
*/
function convertToScm($mmbtu,$gcv)
{
    if(isset($gcv) && !empty($gcv)){
        $gcv = $gcv;
    }
    else {
        $gcv = '9294.11';
    }
    return $scm = $mmbtu*(252000/$gcv);
}
?>