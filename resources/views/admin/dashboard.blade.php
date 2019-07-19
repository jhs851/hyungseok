@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="charts row">
            <div class="col-md-4">
                <div class="rounded bg-white" style="height: 300px;">
                    <div class="py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.dashboard.traffic_this_month')
                        </h4>

                        <h1 class="display-4">1.3GB</h1>
                    </div>

                    <chart-line label="@lang('admin.dashboard.unit', ['unit' => 'GB'])"
                                :labels="['1일', '2일', '3일', '5일', '6일', '14일']"
                                :data="[0.8, 0.1, 0.15, 0.15, 0.05, 0.05]"
                                point-background-color="rgba(227, 52, 47, .8)"
                                point-border-color="rgba(227, 52, 47, .8)"
                                border-color="#e3342f" background-color="#e0bebd"
                                :height="91"></chart-line>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded bg-white" style="height: 300px;">
                    <div class="py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.dashboard.last_1_hour_cpu_usage')
                        </h4>

                        <h1 class="display-4">평균 52.36%</h1>
                    </div>

                    <chart-line label="@lang('admin.dashboard.unit', ['unit' => '%'])"
                                :labels="['04:40', '04:45', '04:50', '04:55', '05:00', '05:05', '05:10', '05:15', '05:20', '05:25', '05:30']"
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

        <div class="charts row mt-5">
            <div class="col-md-4">
                <div class="rounded bg-white" style="height: 300px;">
                    <div class="py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.dashboard.last_1_hour_cpu_usage')
                        </h4>

                        <h1 class="display-4">평균 52.36%</h1>
                    </div>

                    <chart-line label="@lang('admin.dashboard.unit', ['unit' => '%'])"
                                :labels="['04:40', '04:45', '04:50', '04:55', '05:00', '05:05', '05:10', '05:15', '05:20', '05:25', '05:30']"
                                :data="[46, 60, 56, 50, 53, 56, 50, 56, 53, 46, 50]"
                                point-background-color="rgba(56, 193, 114, .8)"
                                point-border-color="rgba(56, 193, 114, .8)"
                                border-color="#38c172" background-color="#a5b8ad"></chart-line>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded bg-white" style="height: 300px;">
                    <div class="py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.dashboard.database_useage')
                        </h4>

                        <div class="d-flex">
                            <h1 class="display-4">1965MB</h1>

                            <chart-pie label="@lang('admin.dashboard.unit', ['unit' => 'MB'])"
                                       :labels="['activities', 'comments', 'development_tag', 'developments', 'favorites', 'migrations', 'notifications', 'password_resets', 'tags', 'users']"
                                       :data="[552, 501, 151, 51, 0, 9, 0, 0, 150, 551]"
                                       :height="130"
                                       :border-color="['#3490dc', '#6574cd', '#9561e2', '#f66d9b', '#4dc0b5', '#6cb2eb', '#e3342f', '#f6993f', '#ffed4a', '#38c172']"
                                       :background-color="['#3490dc', '#6574cd', '#9561e2', '#f66d9b', '#4dc0b5', '#6cb2eb', '#e3342f', '#f6993f', '#ffed4a', '#38c172']"></chart-pie>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop