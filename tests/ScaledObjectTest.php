<?php

declare(strict_types=1);


namespace Mammatus\Tests\Kubernetes\Keda;

use Mammatus\Kubernetes\Attributes\Resources;
use Mammatus\Kubernetes\Keda\ScaledObject;
use Mammatus\Kubernetes\Keda\Trigger;
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

        self::assertSame('{"type":"deployment","helper":"mammatus.keda.deployment","arguments":{"idleReplicaCount":0,"minReplicaCount":1,"maxReplicaCount":13,"cooldownPeriod":666,"advanced":[],"triggers":[]}}', json_encode($scaledObject));
    }
    /**
     * @test
     */
    public function trigger(): void
    {
        $scaledObject = new ScaledObject(
            0,
            1,
            13,
            666,
            [],
            [
                new Trigger(
                    'prometheus',
                    [
                        'serverAddress' => 'http://prometheus-operated.prometheus-system.svc.cluster.local:9090',
                        'query' => 'max(rabbitmq_queue_messages{vhost="development-wyrimaps-net-maptile-uploader", queue="upload"}) / min(home_assistant_kubernetes_workloads_are_allowed_to_scale)',
                        'threshold' => '128',
                    ],
                ),
            ],
        );

        self::assertSame('{"type":"deployment","helper":"mammatus.keda.deployment","arguments":{"idleReplicaCount":0,"minReplicaCount":1,"maxReplicaCount":13,"cooldownPeriod":666,"advanced":[],"triggers":[{"type":"prometheus","metadata":{"serverAddress":"http:\/\/prometheus-operated.prometheus-system.svc.cluster.local:9090","query":"max(rabbitmq_queue_messages{vhost=\"development-wyrimaps-net-maptile-uploader\", queue=\"upload\"}) \/ min(home_assistant_kubernetes_workloads_are_allowed_to_scale)","threshold":"128"},"authenticationRef":null}]}}', json_encode($scaledObject));
    }
}
