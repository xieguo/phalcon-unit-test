<?php
// +----------------------------------------------------------------------
// | BuilderTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\Models;

use App\Models\User;
use App\Utils\Redis;
use Tests\UnitTestCase;
use App\Models\Book;
use App\Models\Repository\User as UserRepository;

/**
 * Class UnitTest
 */
class CacheTest extends UnitTestCase
{
    public function testModelCache()
    {
        $repository = UserRepository::getInstance();
        $userId = $repository->add('test', 1);

        $user = $repository->first($userId);

        $key = '_PHCR:cache:' . $repository->getCacheKey($userId);

        $this->assertTrue(count(Redis::keys($key)) > 0);

        $user->delete();

        $user2 = $repository->first($userId);

        $this->assertEquals($user->id, $user2->id);

        Redis::del($key);

        $user3 = $repository->first($userId);

        $this->assertEmpty($user3);

        $user4 = User::findFirst($userId);

        $this->assertEmpty($user4);
    }

    public function testModelCacheDelete()
    {
        $repository = UserRepository::getInstance();
        $userId = $repository->add('test', 1);

        $user = $repository->first($userId);

        /** @var \Phalcon\Cache\BackendInterface $cache */
        $cache = di('cache');
        $key = '_PHCR:cache:' . $repository->getCacheKey($userId);

        $this->assertTrue(count(Redis::keys($key)) > 0);
        $this->assertTrue($cache->exists($repository->getCacheKey($userId)));

        $repository->delete($user);

        $this->assertFalse(count(Redis::keys($key)) > 0);
        $this->assertFalse($cache->exists($repository->getCacheKey($userId)));
    }

    public function testModelCacheSave()
    {
        $repository = UserRepository::getInstance();
        $userId = $repository->add('test', 1);

        $user = $repository->first($userId);

        /** @var \Phalcon\Cache\BackendInterface $cache */
        $cache = di('cache');
        $this->assertTrue($cache->exists($repository->getCacheKey($userId)));

        $user->name = 'test2';
        $repository->save($user);

        $user2 = $repository->first($userId);

        $this->assertTrue($cache->exists($repository->getCacheKey($userId)));
        $this->assertEquals($user->name, $user2->name);
    }
}
