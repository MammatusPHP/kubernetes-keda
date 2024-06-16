<?php

declare(strict_types=1);

namespace Mammatus\Kubernetes\Keda;

use Mammatus\Kubernetes\Contracts\AddOn\Deployment;

final readonly class ScaledObject implements Deployment
{
    /**
     * @param array<array{type: string, metadata: array{queueName: string, mode: string, value: string}, authenticationRef: array{parameter: string, name: string, key: string}}> $triggers
     */
    public function __construct(
        public int $idleReplicaCount,
        public int $minReplicaCount,
        public int $maxReplicaCount,
        public int $cooldownPeriod,
        public array $advanced,
        public array $triggers,
    )
    {
    }

    public function type(): string
    {
        return 'deployment';
    }

    public function helper(): string
    {
        return 'mammatus.keda.deployment';
    }

    function jsonSerialize(): array
    {
        return [
            'idleReplicaCount' => $this->idleReplicaCount,
            'minReplicaCount' => $this->minReplicaCount,
            'maxReplicaCount' => $this->maxReplicaCount,
            'cooldownPeriod' => $this->cooldownPeriod,
            'advanced' => $this->advanced,
            'triggers' => $this->triggers,
        ];
    }
}