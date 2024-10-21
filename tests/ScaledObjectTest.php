<?php

declare(strict_types=1);


namespace Mammatus\Tests\Kubernetes\Keda;

use Mammatus\Kubernetes\Attributes\Resources;
use Mammatus\Kubernetes\Keda\ScaledObject;
use WyriHaximus\TestUtilities\TestCase;

final class ScaledObjectTest extends TestCase
{
    /**
     * @test
     */
    public function json(): void
    {
        $scaledObject = new ScaledObject(
            0,
            1,
            13,
            666,
            [],
            [],
        );

        self::assertSame('{"type":"deployment","helper":"mammatus.keda.deployment","arguments":{"idleReplicaCount":0,"minReplicaCount":1,"maxReplicaCount":13,"cooldownPeriod":666,"advanced":[],"triggers":[]}}', \Safe\json_encode($scaledObject));
    }
}
