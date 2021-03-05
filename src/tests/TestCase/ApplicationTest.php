<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase;

use App\Application;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;

/**
 * ApplicationTest class
 */
class ApplicationTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * testBootstrap
     *
     * @return void
     */
    public function testBootstrap(): void
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();

        self::assertCount(4, $plugins);
        self::assertSame('Bake', $plugins->get('Bake')->getName());
        self::assertSame('Migrations', $plugins->get('Migrations')->getName());
        self::assertSame('DebugKit', $plugins->get('DebugKit')->getName());
        self::assertSame('SoftDelete', $plugins->get('SoftDelete')->getName());
    }

    /**
     * testBootstrapPluginWitoutHalt
     *
     * @return void
     */
    public function testBootstrapPluginWithoutHalt(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $app = $this->getMockBuilder(Application::class)
            ->setConstructorArgs([dirname(dirname(__DIR__)) . '/config'])
            ->setMethods(['addPlugin'])
            ->getMock();

        $app->method('addPlugin')
            ->will($this->throwException(new InvalidArgumentException('test exception.')));

        $app->bootstrap();
    }

    /**
     * testMiddleware
     *
     * @return void
     */
    public function testMiddleware(): void
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $middleware = new MiddlewareQueue();

        $middleware = $app->middleware($middleware);

        self::assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->get(0));
        self::assertInstanceOf(AssetMiddleware::class, $middleware->get(1));
        self::assertInstanceOf(RoutingMiddleware::class, $middleware->get(2));
    }
}
