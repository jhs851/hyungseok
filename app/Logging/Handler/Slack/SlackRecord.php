<?php

namespace App\Logging\Handler\Slack;

use Monolog\Formatter\{FormatterInterface, NormalizerFormatter};
use Monolog\Handler\Slack\SlackRecord as BaseSlackRecord;

class SlackRecord extends BaseSlackRecord
{
    /**
     * Slack channel (encoded ID or name)
     *
     * @var string|null
     */
    private $channel;

    /**
     * Name of a bot
     *
     * @var string|null
     */
    private $username;

    /**
     * User icon e.g. 'ghost', 'http://example.com/user.png'
     *
     * @var string
     */
    private $userIcon;

    /**
     * Whether the message should be added to Slack as attachment (plain text otherwise)
     *
     * @var bool
     */
    private $useAttachment;

    /**
     * Whether the the context/extra messages added to Slack as attachments are in a short style
     *
     * @var bool
     */
    private $useShortAttachment;

    /**
     * Whether the attachment should include context and extra data
     *
     * @var bool
     */
    private $includeContextAndExtra;

    /**
     * Dot separated list of fields to exclude from slack message. E.g. ['context.field1', 'extra.field2']
     *
     * @var array
     */
    private $excludeFields;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * @var NormalizerFormatter
     */
    private $normalizerFormatter;

    /**
     * SlackRecord constructor.
     *
     * @param  string|null  $channel
     * @param  string|null  $username
     * @param  bool  $useAttachment
     * @param  string|null  $userIcon
     * @param  bool  $useShortAttachment
     * @param  bool  $includeContextAndExtra
     * @param  array  $excludeFields
     * @param  FormatterInterface|null  $formatter
     */
    public function __construct(string $channel = null, string $username = null, bool $useAttachment = true, string $userIcon = null, bool $useShortAttachment = false, bool $includeContextAndExtra = false, array $excludeFields = [], FormatterInterface $formatter = null)
    {
        parent::__construct($channel, $username, $useAttachment, $userIcon, $useShortAttachment, $includeContextAndExtra, $excludeFields, $formatter);

        $this->channel = $channel;
        $this->username = $username;
        $this->userIcon = trim($userIcon, ':');
        $this->useAttachment = $useAttachment;
        $this->useShortAttachment = $useShortAttachment;
        $this->includeContextAndExtra = $includeContextAndExtra;
        $this->excludeFields = $excludeFields;
        $this->formatter = $formatter;

        if ($this->includeContextAndExtra) {
            $this->normalizerFormatter = new NormalizerFormatter();
        }
    }

    /**
     * @param  array  $record
     * @return array
     */
    public function getSlackData(array $record) : array
    {
        $data = [];
        $record = $this->excludeFields($record);
        $record = $this->getDefaultExtra($record);

        if ($this->username) {
            $data['username'] = $this->username;
        }

        if ($this->channel) {
            $data['channel'] = $this->channel;
        }

        if ($this->formatter && !$this->useAttachment) {
            $message = $this->formatter->format($record);
        } else {
            $message = $record['message'];
        }

        if ($this->useAttachment) {
            $attachment = [
                'pretext'   => $message,
                'color'     => $this->getAttachmentColor($record['level']),
                'fields'    => [],
                'mrkdwn_in' => ['fields'],
                'ts'        => $record['datetime']->getTimestamp()
            ];

            if ($this->useShortAttachment) {
                $attachment['title'] = $record['level_name'];
            }

            if ($this->includeContextAndExtra) {
                foreach (['extra', 'context'] as $key) {
                    if (empty($record[$key])) {
                        continue;
                    }

                    if ($this->useShortAttachment) {
                        $attachment['fields'][] = $this->generateAttachmentField(
                            $key,
                            $record[$key]
                        );
                    } else {
                        $attachment['fields'] = array_merge(
                            $attachment['fields'],
                            $this->generateAttachmentFields($record[$key])
                        );
                    }
                }
            }

            $data['attachments'] = [$attachment];
        } else {
            $data['text'] = $message;
        }

        if ($this->userIcon) {
            if (filter_var($this->userIcon, FILTER_VALIDATE_URL)) {
                $data['icon_url'] = $this->userIcon;
            } else {
                $data['icon_emoji'] = ":{$this->userIcon}:";
            }
        }

        return $data;
    }

    /**
     * Return default extra
     *
     * @param  array  $record
     * @return array
     */
    private function getDefaultExtra(array $record) : array
    {
        $exception = $record['context']['exception'];
        unset($record['context']['exception']);

        $record['extra'] = [
            'status code' => method_exists($exception, 'getStatusCode')
                ? $exception->getStatusCode()
                : 'This is not status code but just code : ' . $exception->getCode(),
            'class' => get_class($exception),
            'url' => url()->current(),
            'file' => $exception->getFile() . ':' . $exception->getLine(),
            'user' => auth()->check() ? auth()->user()->email : 'Guest',
            'trace' => $exception->getTraceAsString(),
        ];

        return $record;
    }

    /**
     * Generates attachment field
     *
     * @param  string  $title
     * @param  string|array  $value
     * @return array
     */
    private function generateAttachmentField($title, $value)
    {
        $value = is_array($value)
            ? sprintf('```%s```', $this->stringify($value))
            : $value;

        return [
            'title' => ucfirst($title),
            'value' => $value,
            'short' => false
        ];
    }

    /**
     * Generates a collection of attachment fields from array
     *
     * @param  array  $data
     * @return array
     */
    private function generateAttachmentFields(array $data)
    {
        $fields = [];
        foreach ($this->normalizerFormatter->format($data) as $key => $value) {
            $fields[] = $this->generateAttachmentField($key, $value);
        }

        return $fields;
    }

    /**
     * Get a copy of record with fields excluded according to $this->excludeFields
     *
     * @param  array  $record
     * @return array
     */
    private function excludeFields(array $record)
    {
        foreach ($this->excludeFields as $field) {
            $keys = explode('.', $field);
            $node = &$record;
            $lastKey = end($keys);
            foreach ($keys as $key) {
                if (!isset($node[$key])) {
                    break;
                }
                if ($lastKey === $key) {
                    unset($node[$key]);
                    break;
                }
                $node = &$node[$key];
            }
        }

        return $record;
    }
}
