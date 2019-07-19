@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-md-4">
                <div class="rounded bg-white" style="height: 300px;">
                    <div class="d-flex flex-column py-3 px-4 h-100">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.developments.total')
                        </h4>

                        <h1 class="display-4 mb-auto">{{ number_format($developments->count()) }}</h1>

                        @if ($isIncrease)
                            <h2 class="text-muted mb-0">
                                <i class="fas fa-level-up-alt mr-3 text-success"></i>
                                @lang('admin.developments.increase', ['percentage' => $percentage])
                            </h2>
                        @else
                            <h2 class="text-muted mb-0">
                                <i class="fas fa-level-down-alt mr-3 text-danger"></i>
                                @lang('admin.developments.decrease', ['percentage' => $percentage])
                            </h2>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded bg-white" style="height: 300px;">
                    <div class="py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.developments.month_of_new')
                        </h4>

                        <h1 class="display-4">{{ $thisMonthDevelopments->count() }}</h1>
                    </div>

                    <chart-line label="@lang('admin.dashboard.unit', ['unit' => '%'])"
                                :labels="[@foreach ($thisMonthDevelopments) @endforeach]"
                                :data="[46, 60, 56, 50, 53, 56, 50, 56, 53, 46, 50]"
                                point-background-color="rgba(246, 153, 63, .8)"
                                point-border-color="rgba(246, 153, 63, .8)"
                                border-color="#f6993f" background-color="#f1ddca"></chart-line>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded bg-white" style="height: 300px;">
                    <div class="py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.dashboard.aws_s3_usage')
                        </h4>

                        <h1 class="display-4">713MB</h1>
                    </div>

                    <chart-bar label="@lang('admin.dashboard.unit', ['unit' => 'MB'])"
                               :labels="['images', 'avatars', 'videos']"
                               :data="[101, 99, 513]"
                               point-background-color="rgba(255, 237, 74, .8)"
                               point-border-color="rgba(255, 237, 74, .8)"
                               border-color="#ffed4a" background-color="#f6f3d6"></chart-bar>
                </div>
            </div>
        </div>
    </div>
@stop