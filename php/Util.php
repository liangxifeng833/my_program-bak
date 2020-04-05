<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 通用的函数
 *
 * 函数列表: 
 * 1. 格式化货币数字
 * 2. 得到钱的中文大写
 * 3. 处理打折计算出的小数点
 * 4. 返回BLL报错信息
 *
 * @author: zg
 * @date: 2013-11-30
 */

class Util
{
    //全部定义的是static方法，所以不会调用构造方法
    function __construct() { }
    
    /**
     * 格式化货币数字
     *
     * @param float - a double float number
     * @return mixed - string/false
     */
    public static function formatMoney($money)
    {
        if( !is_numeric($money) )
        {
            return false;
        }
        return number_format($money, 2);
    }

    /**
     * 得到钱的中文大写
     *
     * @param float - a double float number
     * @return mixed - string/false
     */
    public static function cnMoney($num)
    {
        $c1 = '零壹贰叁肆伍陆柒捌玖';
        $c2 = '分角元拾佰仟万拾佰仟亿';
        $num = round($num, 2);
        $num = $num * 100;
        if (strlen($num) > 10) {
            return 'in the func cnMoney : the number is too long!';
        } 
        $i = 0;
        $c = '';
        while (1) {
            if ($i == 0) {
                $n = substr($num, strlen($num)-1, 1);
            } else {
                $n = $num % 10;
            } 

            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);

            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            } 

            $i = $i + 1;
            $num = $num / 10;
            $num = (int)$num;
            if ($num == 0) {
                break;
            } 
        } //end of while| here, we got a chinese string with some useless character
        $j = 0;

        $slen = strlen($c);
        while ($j < $slen) {
            $m = substr($c, $j, 6);
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j-3;
                $slen = $slen-3;
            } 

            $j = $j + 3;
        } 

        if (substr($c, strlen($c)-3, 3) == '零') {
            $c = substr($c, 0, strlen($c)-3);
        } // if there is a '0' on the end , chop it out
        return $c . "整";
    }

    /**
     * 处理打折计算出的小数点,小数点后四舍五入
     *
     * @param float - a double float number
     * @return mixed - string/false
     */
    public static function dealDecimal($number)
    {
        return round(floatval($number));
    }

    /**
     * 返回错误提示
     *
     * @param string - $msg error message
     * @param intval - $status 错误状态：0：错误 1:成功 2：无数据 3：字段重复
     *        intval - $state  单元测试错误标识 1 : 操作成功  
     * @return json - response string
     */
    public static function errorMsg($msg, $status=0, $state=0)
    {
        $errorMsg = $msg;
        get_instance()->response(array('status'=>$status, 'error'=>$errorMsg,'state'=>$state), 200);
    }

    /**
     * 处理打折计算出的小数点,小数点后两位四舍五入
     *
     * @Liangxifeng 2014-06-19
     * @param float - a double float number
     * @return mixed - float
     */
    public static function dealDecimalPoint($number)
    {
        return (round($number*100))/100;
        //return sprintf('%.2f',$num);
    }
    /**
     * 因为REST会对整形长数字做科学计数法，所以在这里提出共用方法，同一数字签名加*，使用的使用在统一去*，
     * 对字符加*，去*
     *
     * @param   [string] - $idcord 数字参数
     * @param   [string] - $num 标识符，0：去* 
     *									1：加*
     * @return string/false
     */
    public static function handleNumForRest($idcord,$num)
    {   
        if(empty($idcord))
        {
            return false;
        }
        if($num == 1)
        {
            return '*'.$idcord;
        }
        if($num == 0)
        {
            return substr($idcord,1);
        }
        return false;
    }

    /*
     * 会员积分规则100：1
     */
    public static function setIntegral($price)
    {
        return  floor(intval($price)*0.01);
    }
	/**
	 * 添加错误日志
	 * @author renguangzheng
	 */
	public static function addLog($message)
	{
		return log_message(LOG_LEVEL,$message);
	}
}

