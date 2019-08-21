<footer>
    <div class="container py-md-4 py-3">
        <div class="row">
            <div class="col-12 col-sm-6">
                <p>
                    @lang('home.footer.contact')
                </p>
                <div>
                    <span class="mr-4">
                        <a class="text-dark" href="tel:@lang('home.footer.tel')">
                            Tel. @lang('home.footer.tel')
                        </a>
                    </span>

                    <br class="d-sm-block">

                    <span class="footer-email">
                        <a class="text-dark" href="mailto:@lang('home.footer.email')">
                            @lang('home.footer.email')
                        </a>
                    </span>
                </div>
            </div>

            <div class="col-12 col-md-6 pt-4 pt-md-1 text-md-right">
                <a href="https://blog.naver.com/jhs851" class="btn btn-sm btn-floating btn-naver hvr-icon-pulse-grow" target="_blank">
                    <svg class="hvr-icon" viewBox="0 0 18 17" style="width: 14px; margin-top: -5px;">
                        <g>
                            <polygon style="fill:#FFFFFF;" points="11.86,0 11.86,8.58 6.16,0 0,0 0,17 6.14,17 6.14,8.42 11.84,17 18,17 18,0"></polygon>
                        </g>
                    </svg>
                </a>

                <a href="https://www.facebook.com/hyungseok.jeong.7" class="btn btn-sm btn-floating btn-facebook hvr-icon-pulse-grow" target="_blank">
                    <i class="fab fa-facebook-f hvr-icon"></i>
                </a>

                <a href="https://github.com/jhs851" class="btn btn-sm btn-floating bg-dark hvr-icon-pulse-grow" target="_blank">
                    <i class="fab fa-github-alt text-white hvr-icon"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white text-black-50 py-4 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="dropdown policy-link policy-locales">
                        <button class="dropdown-toggle" id="localeDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            한국어
                        </button>

                        <div class="dropdown-menu" role="menu" aria-labelledby="localeDropdownMenuLink">
                            <a href="#" class="dropdown-item active">
                                한국어
                            </a>
                        </div>
                    </div>

                    <a class="policy-link" href="/terms" target="_blank">
                        @lang('home.footer.terms')
                    </a>

                    <a class="policy-link" href="/privacy" target="_blank">
                        @lang('home.footer.privacy')
                    </a>
                </div>

                <div class="col-md-9 text-md-right mt-4 mt-md-0 small" style="line-height: 1.8;">
                    <div>
                        Tel : @lang('home.footer.tel')
                    </div>

                    <div>
                        @lang('home.footer.street_name_address')
                    </div>

                    <div>
                        &copy; {{ date('Y') }} {{ config('app.name') }} all rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
