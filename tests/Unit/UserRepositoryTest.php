<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testGetByIdsData()
    {
        \Cache::setDefaultDriver('nullstore');
        $usersToTest = factory(\App\User::class, 2)->create()
            ->all();

        $usersFromRepository = app('UserRepository')
            ->getByIds(array_column($usersToTest, 'id'))
            ->getDictionary();

        $this->assertEquals(count($usersToTest), count($usersFromRepository));

        foreach ($usersToTest as $user) {
            $this->assertEquals($user->name, $usersFromRepository[$user->id]->name);
        }
    }

    public function testGetByIdsWithNoCache()
    {
        \Cache::setDefaultDriver('nullstore');
        $usersToTest = factory(\App\User::class, 10)->create()
            ->all();

        $userIds = array_column($usersToTest, 'id');

        $userModel = new User();

        $queryMock = \Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
        $queryMock
            ->shouldReceive('whereIn')
            ->once()
            ->andReturn(
                $userModel->newQuery()->whereIn('id', $userIds)
            );

        app('UserRepository')
            ->getByIds($userIds, $queryMock)
            ->all();
    }

    public function testGetByIdsWithCache()
    {
        $usersToTest = factory(\App\User::class, 10)->create()
            ->all();

        $userIds = array_column($usersToTest, 'id');

        $queryMock = \Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
        $queryMock
            ->shouldReceive('whereIn')
            ->never();

        \Cache::shouldReceive('get')
            ->times(10)
            ->andReturn(end($usersToTest));

        app('UserRepository')->getByIds($userIds, $queryMock)->all();
    }

    public function testGetByIntersectedIdsWithCache()
    {
        $usersToTestBatch1 = factory(\App\User::class, 4)->create()->all();
        $usersToTestBatch2 = factory(\App\User::class, 4)->create()->all();

        \Cache::clear();

        $userIdsBatch1 = array_column($usersToTestBatch1, 'id');
        $userIdsBatch2 = array_column($usersToTestBatch2, 'id');

        $userIdsBatchMixed = array_slice(array_merge($userIdsBatch1,  $userIdsBatch2), 2, 4);

        app('UserRepository')->getByIds($userIdsBatch1)->all();

        // expect query will only for non-cached ids
        $queryMock = \Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
        $queryMock
            ->shouldReceive('whereIn')
            ->once()
            ->with('id', array_values(array_diff($userIdsBatchMixed, $userIdsBatch1)))
            ->andReturn(
                (new User())->newQuery()->whereIn('id', $userIdsBatchMixed)
            );

        app('UserRepository')->getByIds($userIdsBatchMixed, $queryMock)->all();
    }

}
