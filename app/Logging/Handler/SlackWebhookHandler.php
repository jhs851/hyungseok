<?php

namespace App\Logging\Handler;

use App\Logging\Handler\Slack\SlackRecord;
use Monolog\{Handler\Curl\Util, Handler\SlackWebhookHandler as BaseSlackWebhookHandler, Logger};

class SlackWebhookHandler extends BaseSlackWebhookHandler
{
    /**
     * Instance of the SlackRecord util class preparing data for Slack API.
     *
     * @var SlackRecord
     */
    private $slackRecord;

    /**
     * @param  string  $webhookUrl  Slack Webhook URL
     * @param  string|null  $channel  Slack channel (encoded ID or name)
     * @param  string|null  $username  Name of a bot
     * @param  bool  $useAttachment  Whether the message should be added to Slack as attachment (plain text otherwise)
     * @param  string|null  $iconEmoji  The emoji name to use (or null)
     * @param  bool  $useShortAttachment  Whether the the context/extra messages added to Slack as attachments are in a short style
     * @param  bool  $includeContextAndExtra  Whether the attachment should include context and extra data
     * @param  int  $level  The minimum logging level at which this handler will be triggered
     * @param  bool  $bubble  Whether the messages that are handled can bubble up the stack or not
     * @param  array  $excludeFields  Dot separated list of fields to exclude from slack message. E.g. ['context.field1', 'extra.field2']
     */
    public function __construct(string $webhookUrl, string $channel = null, string $username = null, bool $useAttachment = true, string $iconEmoji = null, bool $useShortAttachment = false, bool $includeContextAndExtra = false, $level = Logger::CRITICAL, bool $bubble = true, array $excludeFields = []) {
        parent::__construct($webhookUrl, $channel, $username, $useAttachment, $iconEmoji, $useShortAttachment, $includeContextAndExtra, $level, $bubble, $excludeFields);

        $this->slackRecord = new SlackRecord($channel, $username, $useAttachment, $iconEmoji, $useShortAttachment, $includeContextAndExtra, $excludeFields, $this->formatter);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    protected function write(array $record) : void
    {
        if (! app()->environment('production')) {
            return;
        }

        $ch = curl_init();
        $options = [
            CURLOPT_URL => $this->getWebhookUrl(),
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($this->slackRecord->getSlackData($record))
        ];

        if (defined('CURLOPT_SAFE_UPLOAD')) {
            $options[CURLOPT_SAFE_UPLOAD] = true;
        }

        curl_setopt_array($ch, $options);

        Util::execute($ch);
    }
}
