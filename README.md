# kubernetes-keda

🐕 Kubernetes KEDA related utilities for [Mammatus](https://github.com/MammatusPHP/app).

Provides PHP data structures for configuring [KEDA](https://keda.sh/) (Kubernetes Event-driven Autoscaling)
ScaledObjects as Mammatus add-ons.

## Install

```bash
composer require mammatus/kubernetes-keda
```

## Usage

Apply a `ScaledObject` as an add-on on a queue consumer class:

```php
use Mammatus\Kubernetes\Keda\ScaledObject;
use Mammatus\Kubernetes\Keda\Trigger;
use Mammatus\Queue\Attributes\Consumer;

#[Consumer(
    friendlyName: 'Order Processor',
    queue: 'orders',
    dtoClass: OrderDto::class,
    concurrency: 1,
    new ScaledObject(
        idleReplicaCount: 0,
        minReplicaCount: 1,
        maxReplicaCount: 10,
        cooldownPeriod: 30,
        advanced: [],
        triggers: [
            new Trigger(
                type: 'rabbitmq',
                metadata: [
                    'queueName' => 'orders',
                    'mode' => 'Absolute',
                    'value' => '5',
                ],
            ),
        ],
    ),
)]
final class OrderProcessor
{
}
```

See the [mammatus/queue](https://github.com/MammatusPHP/queue) package for more information on consumers.

## API

- **`ScaledObject`**: Readonly data class implementing `AddOn` and `Deployment`.
  Configures replica bounds, cooldown, and a list of triggers.
- **`Trigger`**: Readonly data class representing a KEDA scaling trigger
  (e.g., RabbitMQ, PostgreSQL, Kafka) with its metadata and optional authentication reference.

## License

The MIT License (MIT)

Copyright (c) 2026 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
