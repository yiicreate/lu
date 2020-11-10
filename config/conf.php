<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/30
 * Time: 10:25
 */
return [
    'debug' =>env("APP_DEBUG",true),

    //加密秘钥
    'key'=>'',

    'comm' => [
        'user'=>'/static/user/',
        'export'=>'/static/export/',
    ],

    //人脸识别机器
    'databus'=>[
        'server_path'=>'http://192.168.13.89',//地址
        'clientId'=>'hnJ0OSVM', //从商家获取
        'clientSecret'=>'TBb0otSqSrLHUN5y',//从商家获取
        'advance'=>'05132020060900020287162875374358',//进出登记机子号
        'apply'=>'05132019093000014209363548644105',//进行登记机子号
    ],

    //权限
    'permissions'=>[
        'databus_user'=>1,//是否同步到设备
    ],

    //文件路径
    'upload' => [
        'import'=>'',
        'load'=>'',
    ]
];