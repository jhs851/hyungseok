<div class="d-flex justify-content-center align-items-center flex-column text-center doorkeeper doorkeeper-{{ $theme ?? 'light' }} {{ $mb ?? 'mb-9' }}">
    @isset ($title)
        <h1 class="font-weight-bold display-3 mb-4 wow fadeInUp" style="letter-spacing: 10px;">{!! $title !!}</h1>
    @endisset

    <h3 class="mb-4 pb-2 wow fadeInUp" {!! isset($title) ? 'data-wow-delay=".6s"' : '' !!}>{!! $description  !!}</h3>

    @line([
        'classes' => 'wow fadeInUp mb-7' . (isset($theme) && $theme == 'dark' ? ' bg-white' : ''),
        'attributes' => isset($title) ? 'data-wow-delay="1.2s"' : 'data-wow-delay=".6s"'
    ]) @endline
</div>
