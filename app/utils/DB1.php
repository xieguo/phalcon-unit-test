<?php
// +----------------------------------------------------------------------
// | DB 工具类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
// | Desc: 这里默认使用 limx\phalcon\DB工具类，如果需要请自行修改。
// +----------------------------------------------------------------------
namespace App\Utils;

class DB1 extends DB
{
    /**
     * @var string 定义DB服务名
     */
    protected static $dbServiceName = 'db1';
}