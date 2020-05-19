<?php

declare(strict_types=1);

namespace Tests\Unit\Bootstrapping\Registrations;

use PHPStartup\Bootstrapping\Registrations\MainRegistrar;
use PHPUnit\Framework\TestCase;
use Slim\App;

/**
 * @internal
 * @coversNothing
 */
class MainRegistrarTest extends TestCase
{
    /*
     * Routes are a part of the Interface of an API, so we will test for them.
     * We don't care how they are handled, as integration tests can test for specific outputs/input
     * combinations, but the removal of an existing route is a breaking change and should cause concern
     * and discussion. So these tests, while not strictly respecting the public API, are considered mandatory.
     *
     * We test the amount of routes registered of given types, to ensure new routes have tests added, and we test
     * which routes are registered without checking what they are registered with. The registrar isn't concerned
     * with how the routes are implemented, just that they are. Other unit tests, for controllers, and integration
     * tests, for the api as a whole, are way better fits for implementaion testing of controllers.
    */

    //Routes
    public function getRoutePaths()
    {
        return [
            ['/'],
            ['/test/'],
        ];
    }

    public function testRegisterHandlersRegistersAllRoutesWithTrailingSlash()
    {
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $checkForTrailingSlash = function (string $route) {
            return mb_substr($route, -1) === '/';
        };

        $registrar = new MainRegistrar();
        $appStub->expects($this->any())
            ->method('post')
            ->with($this->callback($checkForTrailingSlash), $this->anything())
        ;
        $appStub->expects($this->any())
            ->method('put')
            ->with($this->callback($checkForTrailingSlash), $this->anything())
        ;
        $appStub->expects($this->any())
            ->method('delete')
            ->with($this->callback($checkForTrailingSlash), $this->anything())
        ;
        $appStub->expects($this->any())
            ->method('patch')
            ->with($this->callback($checkForTrailingSlash), $this->anything())
        ;
        $appStub->expects($this->any())
            ->method('options')
            ->with($this->callback($checkForTrailingSlash), $this->anything())
        ;
        $appStub->expects($this->any())
            ->method('get')
            ->with($this->callback($checkForTrailingSlash), $this->anything())
        ;

        $registrar->registerHandlers($appStub);
    }

    public function testRegisterHandlersRegistersExpectedAmountOfPostRoutes()
    {
        $expected = 0;
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $registrar = new MainRegistrar();
        $appStub->expects($this->exactly($expected))->method('post');

        $registrar->registerHandlers($appStub);
    }

    public function testRegisterHandlersRegistersExpectedAmountOfPutRoutes()
    {
        $expected = 0;
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $registrar = new MainRegistrar();
        $appStub->expects($this->exactly($expected))->method('put');

        $registrar->registerHandlers($appStub);
    }

    public function testRegisterHandlersRegistersExpectedAmountOfDeleteRoutes()
    {
        $expected = 0;
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $registrar = new MainRegistrar();
        $appStub->expects($this->exactly($expected))->method('delete');

        $registrar->registerHandlers($appStub);
    }

    public function testRegisterHandlersRegistersExpectedAmountOfPatchRoutes()
    {
        $expected = 0;
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $registrar = new MainRegistrar();
        $appStub->expects($this->exactly($expected))->method('patch');

        $registrar->registerHandlers($appStub);
    }

    public function testRegisterHandlersRegistersExpectedAmountOfOptionsRoutes()
    {
        $expected = 0;
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $registrar = new MainRegistrar();
        $appStub->expects($this->exactly($expected))->method('options');

        $registrar->registerHandlers($appStub);
    }

    public function testRegisterHandlersRegistersExpectedAmountOfGetRoutes()
    {
        $expected = 2;
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $registrar = new MainRegistrar();
        $appStub->expects($this->exactly($expected))->method('get');

        $registrar->registerHandlers($appStub);
    }

    /**
     * @dataProvider getRoutePaths
     * */
    public function testRegisterHandlersRegistersExpectedGetRoutes(string $expected)
    {
        /** @var \Slim\App&\PHPUnit\Framework\MockObject\MockObject $appStub */
        $appStub = $this->getMockBuilder(App::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $matched = false; //a bit hacky but it's a limitation of PHPUnit by the looks

        $registrar = new MainRegistrar();
        $appStub->expects($this->any())
            ->method('get')
            ->with($this->callback(function ($route) use ($expected, &$matched) {
                if ($route === $expected) {
                    $matched = true;
                }

                return true;
            }), $this->anything())
        ;

        $registrar->registerHandlers($appStub);
        $this->assertSame(true, $matched, 'route not registered.');
    }
}
