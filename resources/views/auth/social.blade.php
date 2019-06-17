<a href="{{ route('social.login', ['provider' => 'naver']) }}"
   class="btn btn-sm btn-floating btn-naver m-0 mx-1 hvr-icon-pulse-grow"
   data-toggle="tooltip" title="@lang('auth.social.with_naver')">
    <img class="img-fluid hvr-icon" src="{{ asset('images/icons/naver.png') }}" alt="" style="width: 14px; margin-top: -5px;">
</a>

<a href="{{ route('social.login', ['provider' => 'kakao']) }}"
   class="btn btn-sm btn-floating btn-kakao m-0 mx-1 hvr-icon-pulse-grow" style="color: #f5e14b;"
   data-toggle="tooltip" title="@lang('auth.social.with_kakao')">
    <i class="fas fa-comment hvr-icon"></i>
</a>

<a href="{{ route('social.login', ['provider' => 'github']) }}"
   class="btn btn-sm btn-floating bg-dark text-white m-0 mx-1 hvr-icon-pulse-grow"
   data-toggle="tooltip" title="@lang('auth.social.with_github')">
    <i class="fab fa-github-alt hvr-icon"></i>
</a>

<a href="{{ route('social.login', ['provider' => 'google']) }}"
   class="btn btn-sm btn-floating btn-google m-0 mx-1 hvr-icon-pulse-grow"
   data-toggle="tooltip" title="@lang('auth.social.with_google')">
    <i class="fab fa-google hvr-icon"></i>
</a>

<a href="{{ route('social.login', ['provider' => 'facebook']) }}"
   class="btn btn-sm btn-floating btn-facebook m-0 mx-1 hvr-icon-pulse-grow"
   data-toggle="tooltip" title="@lang('auth.social.with_facebook')">
    <i class="fab fa-facebook-f hvr-icon"></i>
</a>
