<?php
// +----------------------------------------------------------------------
// | Service.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Common;

use App\Models\User;
use swoole_server;
use Xin\Swoole\Rpc\Server as RpcServer;
use swoole_process;

class Server extends RpcServer
{
    public function beforeServerStart(swoole_server $server)
    {
        $process = new swoole_process(function () {
            declare(ticks=1);
            pcntl_signal(SIGCHLD, function ($signo) {
                switch ($signo) {
                    case SIGCHLD:
                        while (swoole_process::wait(false)) {
                        }
                }
            });

            while (true) {
                $proc = new swoole_process(function (swoole_process $p) {
                    /** @var BackendInterface $cache */
                    $cache = di('cache');
                    $cache->save('another:task:save:cache', 'Hi, limx');

                    // $task = ROOT_PATH . '/run test:test@addCache';
                    // exec('php ' . $task);
                });
                $proc->start();
                sleep(1);
                sleep(1);
            }
        });
        $server->addProcess($process);
        parent::beforeServerStart($server); // TODO: Change the autogenerated stub
    }
}