<?php
/*
 * 加密
 * 电子券使用码规则：
 * １，有手机号：　strrev(券主表ticket_main主键)+'Y'+strrev(券使用范围＋(手机号-过期时间戳))
 * ２，无手机号：　strrev(券主表ticket_main主键)+'N'+strrev(券使用范围＋过期时间戳)
 *
 */
function encrypt($ticketId=5,$phone='00000000000',$endDate='20151125', $useRange=2)
{
    if(0<(int)$phone)
    {
        $prefix = strrev($ticketId).'Y';
        $suffix = (int)$phone;
        $suffix = $suffix-strtotime($endDate);
        return $prefix.strrev($useRange.$suffix);
    }else
    {
        $prefix = strrev($ticketId).'N';
        $suffix = strtotime($endDate);
        return $prefix.strrev($useRange.$suffix);
    }
}
/*
 * 解密电子券使用码：
 *
 * @param  [string] $str 需要机密的字符串
 * @param  [string] $endDate 券有效期截止日期
 * @return [array] key值说明：ticketId为券主表主键 ticket_main主键
 * @return [array] key值说明：useRange为使用范围
 * @return [array] key值说明：phone　如果绑定用户的话为用户手机号，否则为０
 */
function decrypt($str,$endDate)
{
    //绑定手机号情况
    $pos = strpos($str,'Y');
    if($pos)
    {
        $arr['ticketId'] = strrev(substr($str,0,$pos));
        $suffix = strrev(substr($str,$pos+1));
        $arr['useRange'] = substr($suffix,0,1);
        $phone = substr($suffix,1);
        $arr['phone'] = $phone+strtotime($endDate);
        return $arr;
    }
    //不绑定手机号情况
    $pos = strpos($str,'N');
    if($pos)
    {
        $arr['ticketId'] = strrev(substr($str,0,$pos));
        $suffix = strrev(substr($str,$pos+1));
        $arr['useRange'] = substr($suffix,0,1);
        $arr['phone'] = 0;
        return $arr;
    }
}

/*
 * 调用举例
 */
$str = encrypt(6,'13301223034');
$str = encrypt(6);
$str2 = decrypt($str,'2015-11-31');
echo $str."\n";
print_r($str2);

