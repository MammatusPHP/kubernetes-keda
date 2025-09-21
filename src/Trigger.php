<?php

declare(strict_types=1);

namespace Mammatus\Kubernetes\Keda;

use JsonSerializable;

final readonly class Trigger implements JsonSerializable
{
    /**
     * @param array{queueName:string,mode:string,value:string}|array{serverAddress:string,query:string,threshold:string} $metadata
     * @param array<mixed>|null                                                                                          $authenticationRef
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(
        public string $type,
        public array $metadata,
        public array|null $authenticationRef = null,
    ) {
    }

    /** @return array{type: string, metadata:array{queueName:string,mode:string,value:string}|array{serverAddress:string,query:string,threshold:string}, authenticationRef: array<mixed>|null} */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'metadata' => $this->metadata,
            'authenticationRef' => $this->authenticationRef,
        ];
    }
}
