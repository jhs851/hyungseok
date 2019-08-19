<?php

use Sentry\{Breadcrumb, Event, Options};

return [

    /*
    |--------------------------------------------------------------------------
    | DSN
    |--------------------------------------------------------------------------
    |
    | The DSN tells the SDK where to send the events to.
    | If this value is not provided, the SDK will try to read it from the SENTRY_DSN environment variable.
    | If that variable also does not exist, the SDK will just not send any events.
    | Note: In runtimes without a process environment (such as the browser) that fallback does not apply.
    |
    */
    'dsn' => env('APP_ENV') === 'production' ? env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')) : null,

    /*
    |--------------------------------------------------------------------------
    | Integrations
    |--------------------------------------------------------------------------
    |
    | In some SDKs, the integrations are configured through this parameter on library initialization.
    | For more information, have a look at the specific integration documentation.
    |
    */
    'integrations' => [],

    /*
    |--------------------------------------------------------------------------
    | Default Integrations
    |--------------------------------------------------------------------------
    |
    | This can be used to disable integrations that are added by default.
    | When set to false no default integrations are added.
    |
    */
    'default_integrations' => true,

    /*
    |--------------------------------------------------------------------------
    | Send Attempts
    |--------------------------------------------------------------------------
    */
    'send_attempts' => 3,

    /*
    |--------------------------------------------------------------------------
    | Prefixes
    |--------------------------------------------------------------------------
    */
    'prefixes' => explode(PATH_SEPARATOR, get_include_path()),

    /*
    |--------------------------------------------------------------------------
    | Sample Rate
    |--------------------------------------------------------------------------
    |
    | Configures the sample rate as a percentage of events to be sent in the range of 0.0 to 1.0.
    | The default is 1.0 which means that 100% of events are sent.
    | If set to 0.1 only 10% of events will be sent. Events are picked randomly.
    |
    */
    'sample_rate' => 1,

    /*
    |--------------------------------------------------------------------------
    | Attach Stacktrace
    |--------------------------------------------------------------------------
    |
    | When enabled, stack traces are automatically attached to all messages logged.
    | Note that stack traces are always attached to exceptions but when this is set stack traces are also sent with messages.
    | This, for instance, means that stack traces appear next to all log messages.
    | It’s important to note that grouping in Sentry is different for events with stack traces and without.
    | This means that you will get new groups as you enable or disable this flag for certain events.
    | This feature is off by default.
    |
    */
    'attach_stacktrace' => false,

    /*
    |--------------------------------------------------------------------------
    | Context Lines
    |--------------------------------------------------------------------------
    */
    'context_lines' => 5,

    /*
    |--------------------------------------------------------------------------
    | Enable Compression
    |--------------------------------------------------------------------------
    */
    'enable_compression' => true,

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Sets the environment. This string is freeform and not set by default.
    | A release can be associated with more than one environment to separate them in the UI (think staging vs prod or similar).
    | By default the SDK will try to read this value from the SENTRY_ENVIRONMENT environment variable (except for the browser SDK where this is not applicable).
    |
    */
    'environment' => $_SERVER['SENTRY_ENVIRONMENT'] ?? null,

    /*
    |--------------------------------------------------------------------------
    | Project Root
    |--------------------------------------------------------------------------
    */
    'project_root' => null,

    /*
    |--------------------------------------------------------------------------
    | Logger
    |--------------------------------------------------------------------------
    */
    'logger' => 'php',

    /*
    |--------------------------------------------------------------------------
    | Release
    |--------------------------------------------------------------------------
    |
    | Sets the release. Some SDKs will try to automatically configure a release out of the box but if you have the chance it’s a better idea to manually set it.
    | That way it’s guaranteed to be in sync with your deploy integrations or source map uploads.
    | Release names are just strings but some formats are detected by Sentry and might be rendered differently.
    | For more information have a look at the releases documentation.
    | By default the SDK will try to read this value from the SENTRY_RELEASE environment variable (except for the browser SDK where this is not applicable).
    |
    */
    // 'release' => trim(exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD')),

    /*
    |--------------------------------------------------------------------------
    | Server Name
    |--------------------------------------------------------------------------
    |
    | Can be used to supply a “server name”.
    | When provided, the name of the server is sent along and persisted in the event.
    | Note that for many integrations the server name actually corresponds to the device hostname even in situations where the machine is not actually a server.
    | Most SDKs will attempt to auto-discover this value.
    |
    */
    'server_name' => gethostname(),

    /*
    |--------------------------------------------------------------------------
    | Tags
    |--------------------------------------------------------------------------
    */
    'tags' => [],

    /*
    |--------------------------------------------------------------------------
    | Error Types
    |--------------------------------------------------------------------------
    |
    | Sets which errors are reported.
    | It takes the same values as PHP’s error_reporting configuration parameter.
    | By default all types of errors are be reported (equivalent to E_ALL).
    |
    */
    'error_types' => E_ALL,

    /*
    |--------------------------------------------------------------------------
    | Max Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | This variable controls the total amount of breadcrumbs that should be captured.
    | This defaults to 100.
    |
    */
    'max_breadcrumbs' => Options::DEFAULT_MAX_BREADCRUMBS,

    /*
    |--------------------------------------------------------------------------
    | Excluded Exceptions
    |--------------------------------------------------------------------------
    */
    'excluded_exceptions' => [],

    /*
    |--------------------------------------------------------------------------
    | Send Default PII
    |--------------------------------------------------------------------------
    |
    | If this flag is enabled, certain personally identifiable information is added by active integrations.
    | Without this flag they are never added to the event, to begin with.
    | If possible, it’s recommended to turn on this feature and use the server side PII stripping to remove the values instead.
    |
    */
    'send_default_pii' => true,

    /*
    |--------------------------------------------------------------------------
    | Max Value Length
    |--------------------------------------------------------------------------
    */
    'max_value_length' => 1024,

    /*
    |--------------------------------------------------------------------------
    | Http Proxy
    |--------------------------------------------------------------------------
    |
    | When set a proxy can be configured that should be used for outbound requests.
    | This is also used for HTTPS requests unless a separate https-proxy is configured.
    | Note however that not all SDKs support a separate HTTPS proxy.
    | SDKs will attempt to default to the system-wide configured proxy if possible.
    | For instance, on unix systems, the http_proxy environment variable will be picked up.
    |
    */
    'http_proxy' => null,

    /*
    |--------------------------------------------------------------------------
    | Capture Silenced Errors
    |--------------------------------------------------------------------------
    */
    'capture_silenced_errors' => false,

    /*
    |--------------------------------------------------------------------------
    | Max Request Body Size
    |--------------------------------------------------------------------------
    */
    'max_request_body_size' => 'medium',

    /*
    |--------------------------------------------------------------------------
    | Class Serializers
    |--------------------------------------------------------------------------
    */
    'class_serializers' => [],

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    */
    'breadcrumbs' => [
        // Capture bindings on SQL queries logged in breadcrumbs
        'sql_bindings' => true,
    ],
];
