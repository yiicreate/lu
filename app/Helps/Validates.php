<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/11/11
 * Time: 9:37
 */

namespace App\Helps;


/**
 * 验证身份证号
 * @param $value
 * @return bool
 */
function checkIdCode($value)
{
    $vCity = array(
        '11', '12', '13', '14', '15', '21', '22',
        '23', '31', '32', '33', '34', '35', '36',
        '37', '41', '42', '43', '44', '45', '46',
        '50', '51', '52', '53', '54', '61', '62',
        '63', '64', '65', '71', '81', '82', '91'
    );
    if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $value)) return false;
    if (!in_array(substr($value, 0, 2), $vCity)) return false;
    $value   = preg_replace('/[xX]$/i', 'a', $value);
    $vLength = strlen($value);
    if ($vLength == 18) {
        $vBirthday = substr($value, 6, 4) . '-' . substr($value, 10, 2) . '-' . substr($value, 12, 2);
    } else {
        $vBirthday = '19' . substr($value, 6, 2) . '-' . substr($value, 8, 2) . '-' . substr($value, 10, 2);
    }
    if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
    if ($vLength == 18) {
        $vSum = 0;
        for ($i = 17; $i >= 0; $i--) {
            $vSubStr = substr($value, 17 - $i, 1);
            $vSum    += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
        }
        if ($vSum % 11 != 1) return false;
    }
    return true;
}

/**
 * 验证是否是中文名字
 * @param $val
 * @return bool
 *
 */
function isRealname($val){
    if(preg_match('/^[\x{4e00}-\x{9fa5}]{2,}$/u',$val)){
        return true;
    }
    return false;
}

/**
 * 验证手机号码
 * @param $value
 * @return bool
 */
function checkMobilePhone($value)
{
    return 1 === preg_match("/^(1[0-9])\\d{9}$/", $value);
}