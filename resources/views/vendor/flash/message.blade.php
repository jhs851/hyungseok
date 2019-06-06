<script>
    @foreach (session('flash_notification', collect())->toArray() as $message)
        @unless ($message['overlay'])
            toastr['{{ $message['level'] === 'danger' ? 'error' : $message['level'] }}']('{{ $message['message'] }}');
        @endif
    @endforeach
</script>

{{ session()->forget('flash_notification') }}
