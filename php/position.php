<?php
/*
 * 获取指定经纬度,半径范围值
 * @param float $lat 纬度
 * @param float $lon 经度
 * @param float $radius 半径(单位:米)
 */
 function getAround($lat,$lon,$raidus){
    $PI = 3.14159265;
    $latitude = $lat;
    $longitude = $lon;
    $degree = (24901*1609)/360.0;
    $raidusMile = $raidus;
    $dpmLat = 1/$degree;
    $radiusLat = $dpmLat*$raidusMile;
    $minLat = format($latitude - $radiusLat);
    $maxLat = format($latitude + $radiusLat);
    $mpdLng = $degree*cos($latitude * ($PI/180));
    $dpmLng = 1 / $mpdLng;
    $radiusLng = $dpmLng*$raidusMile;
    $minLng = format($longitude - $radiusLng);
    $maxLng = format($longitude + $radiusLng);
    echo $minLat."#".$maxLat."@".$minLng."#".$maxLng."\n";

}
function format($num)
{
    return sprintf("%.6f",$num);
}
//计算纬度为39.971003,经度为:116.340516,半径为110米,经纬度范围值
getAround('39.971003','116.340516',110);
//输出: 39.970015#39.971991@116.339226#116.341806
//输出: 最小纬度#最大纬@最小经度#最大经度
