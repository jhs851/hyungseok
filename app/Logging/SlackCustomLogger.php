<?php

namespace App\Logging;

use App\Logging\Handler\SlackWebhookHandler;
use Monolog\Logger;

class SlackCustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return Logger
     */
    public function __invoke(array $config) : Logger
    {
        return new Logger('custom', [
            new SlackWebhookHandler(
                $config['url'],
                $config['channel'] ?? null,
                $config['username'] ?? 'Laravel',
                $config['attachment'] ?? true,
                $config['emoji'] ?? ':boom:',
                $config['short'] ?? false,
                $config['context'] ?? true,
                $config['level'] ?? 'debug',
                $config['bubble'] ?? true,
                $config['exclude_fields'] ?? []
            ),
        ]);
    }
}
