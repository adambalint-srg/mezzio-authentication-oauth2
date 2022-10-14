<?php

declare(strict_types=1);

namespace MezzioTest\Authentication\OAuth2;

use League\OAuth2\Server\AuthorizationServer;
use Mezzio\Authentication\OAuth2\TokenEndpointHandlerFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use TypeError;

/**
 * @covers \Mezzio\Authentication\OAuth2\TokenEndpointHandlerFactory
 */
class TokenEndpointHandlerFactoryTest extends TestCase
{
    use ProphecyTrait;

    private TokenEndpointHandlerFactory $subject;

    protected function setUp(): void
    {
        $this->subject = new TokenEndpointHandlerFactory();
        parent::setUp();
    }

    public function testEmptyContainerThrowsTypeError(): void
    {
        $container = $this->prophesize(ContainerInterface::class);

        $this->expectException(TypeError::class);
        ($this->subject)($container);
    }

    public function testCreatesTokenEndpointHandler(): void
    {
        $server          = $this->prophesize(AuthorizationServer::class);
        $responseFactory = static function (): void {
        };
        $container       = $this->prophesize(ContainerInterface::class);

        $container
            ->has(ResponseFactoryInterface::class)
            ->willReturn(false)
            ->shouldBeCalledOnce();
        $container
            ->get(AuthorizationServer::class)
            ->willReturn($server->reveal())
            ->shouldBeCalledOnce();
        $container
            ->get(ResponseInterface::class)
            ->willReturn($responseFactory)
            ->shouldBeCalledOnce();

        ($this->subject)($container->reveal());
    }

    public function testDirectResponseInstanceFromContainerThrowsTypeError(): void
    {
        $server    = $this->prophesize(AuthorizationServer::class);
        $container = $this->prophesize(ContainerInterface::class);

        $container
            ->has(ResponseFactoryInterface::class)
            ->willReturn(false);
        $container
            ->get(AuthorizationServer::class)
            ->willReturn($server->reveal());
        $container
            ->get(ResponseInterface::class)
            ->willReturn($this->prophesize(ResponseInterface::class)->reveal());

        $this->expectException(TypeError::class);
        ($this->subject)($container->reveal());
    }
}
