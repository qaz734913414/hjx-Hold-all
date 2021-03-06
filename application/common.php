<?php

use Endroid\QrCode\QrCode;

/**
 * curl 请求http
 */
function curl_get_contents($url)
{
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
    // curl_setopt($ch,CURLOPT_HEADER,1);               //是否显示头部信息
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
    curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);        //设置 referer
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
    $r=curl_exec($ch);
    curl_close($ch);
    return $r;
}

/**
 * 生成二维码
 * @param string $url 二维码中的内容,加http://这样扫码可以直接跳转url
 * @param string $message 二维码下方注释
 * @param string $logo 二维码中间logo图片
 * @param int $logo_w 图片大小
 * @param int $size 二维码大小
 * @return string 二维码
 * @throws \Endroid\QrCode\Exception\InvalidPathException
 */
function qrcode($url,$message='',$logo='',$logo_w=50,$size = 300)
{
    $qrCode=new QrCode();
    $qrCode->setText($url)
        ->setSize($size) // 大小
        ->setLabelFontPath(VENDOR_PATH.'endroid/qrcode/assets/noto_sans.otf')
        ->setErrorCorrectionLevel('high')
        ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
        ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
        ->setLabel($message) // 二维码下方注释
        ->setLabelFontSize(16); // 注释大小

    if ($logo != ''){
        $qrCode->setLogoPath($logo) // 二维码中间logo图片
            ->setLogoWidth($logo_w); // logo图片大小
    }

    header('Content-Type: '.$qrCode->getContentType());
    return $qrCode->writeString();
}
