<?php

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\MultiSortPaginatorHelper;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class MultiSortPaginatorHelperTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @test
     */
    public function sort(): void
    {
        $request = new ServerRequest(
            [
                'params' => [
                    'controller' => 'users',
                    'action' => 'index',
                    'plugin' => null,
                    '_ext' => null,
                    'pass' => [],
                ],
                'url' => '/users/',
                'query' => ['sort' => 'test2_id', 'direction' => 'desc']
            ]
        );
        $View = new View($request);
        Router::pushRequest($request);

        $mock = $this->getMockBuilder(MultiSortPaginatorHelper::class)
            ->setMethods(['sortKey', 'defaultModel', 'sortDir'])
            ->setConstructorArgs([$View])
            ->getMock();

        $mock->method('sortKey')->willReturn('test2_id');
        $mock->method('defaultModel')->willReturn('Test');
        $mock->method('sortDir')->willReturn('asc');

        self::assertContains('order[test_id]=asc', urldecode($mock->sort('test_id', null, [])));
        self::assertContains(
            'order[test_id]=asc',
            urldecode($mock->sort('test2_id', null, ['order' => ['test_id' => 'asc']]))
        );        self::assertContains(
            'order[test2_id]=desc',
            urldecode($mock->sort('test2_id', null, ['order' => ['test_id' => 'asc']]))
        );
    }
}
