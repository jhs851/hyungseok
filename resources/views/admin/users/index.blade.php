@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            @component('admin.layouts.components.card')
                <div class="d-flex flex-column py-3 px-4 h-100">
                    <h4 class="text-muted font-weight-bold">
                        @lang('admin.users.total')
                    </h4>

                    <h1 class="display-4 mb-auto">{{ number_format($usersCount) }}</h1>

                    <h2 class="text-muted mb-0">
                        <i class="fas fa-level-up-alt mr-3 text-success"></i>
                        @lang('admin.developments.increase', ['percentage' => $incremental])
                    </h2>
                </div>
            @endcomponent

            @component('admin.layouts.components.card')
                <div class="py-3 px-4">
                    <h4 class="text-muted font-weight-bold">
                        @lang('admin.users.month_of_new')
                    </h4>

                    <h1 class="display-4">{{ $monthliesCount }}</h1>
                </div>

                <chart-line label="@lang('admin.dashboard.unit', ['unit' => '일/명'])"
                            :labels="{{ json_encode($countsByDays->pluck('day')->values()) }}"
                            :data="{{ json_encode($countsByDays->pluck('count')->values()) }}"></chart-line>
            @endcomponent

            @component('admin.layouts.components.card')
                <div class="py-3 px-4">
                    <h4 class="text-muted font-weight-bold">
                        @lang('admin.users.active_users')
                    </h4>

                    <h1 class="display-4">{{ $activeUsersCount }}</h1>
                </div>

                <chart-pie label="@lang('admin.dashboard.unit', ['unit' => '명'])"
                           :labels="['@lang('admin.users.active_users')', '@lang('admin.users.unactive_users')']"
                           :data="[{{ $activeUsersCount }}, {{ $unactiveUsersCount }}]"
                           :height="130"
                           :border-color="['#3490dc', '#6574cd']"
                           :background-color="['#3490dc', '#6574cd']"></chart-pie>
            @endcomponent
        </div>

        <search-view class="row mt-5 align-items-end" index="users" v-cloak reference="name">
            <div class="col-12" slot-scope="{ onSelect, query, indicesToSuggestions, getSuggestion }">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <h2 class="mb-3">@lang('admin.users.title')</h2>

                        <ais-configure :query="query" />

                        <ais-autocomplete>
                            <template slot-scope="{ currentRefinement, indices, refine }">
                                <vue-autosuggest
                                    class="form-group mb-0"
                                    :suggestions="indicesToSuggestions(indices)"
                                    @selected="onSelect"
                                    @input="refine"
                                    :limit="5"
                                    :get-suggestion-value="getSuggestion"
                                    component-attr-class-autosuggest-results="ais-autocomplete"
                                    :input-props="{
                                            type: 'search',
                                            class: 'form-control form-control-lg bg-white z-depth-1 pr-5',
                                            style: 'background: url({{ asset('/svg/algolia-blue-mark.svg') }}) right center / auto 100% no-repeat;',
                                            autocapitalize: 'off',
                                            spellcheck: 'false',
                                            maxlength: '512',
                                            placeholder: '@lang('admin.users.search_placeholder')'
                                        }"
                                >
                                    <li slot="before-section-default" class="placeholder">@lang('developments.autocomplete_placeholder')</li>

                                    <template slot-scope="{ suggestion }">
                                        <div class="py-3">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-2 font-weight-bold">@{{ suggestion.item.name | strLimit(31) }}</h6>

                                                <small class="mb-0 text-black-50" v-text="suggestion.item.email"></small>
                                            </div>
                                        </div>
                                    </template>
                                </vue-autosuggest>
                            </template>
                        </ais-autocomplete>
                    </div>

                    <div class="col-auto ml-auto">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg">
                            @lang('admin.users.create')
                        </a>
                    </div>
                </div>

                <ais-hits>
                    <div class="row mt-3" slot-scope="{ items }">
                        <div class="col-12">
                            <div class="table-responsive bg-white z-depth-1 rounded-lg pb-3">
                                <table class="table table-hover text-center h5 font-weight-light">
                                    <colgroup>
                                        <col style="width: 5%;">
                                        <col style="width: 8%;">
                                        <col style="width: 10%;">
                                        <col>
                                        <col style="width: 12%;">
                                    </colgroup>

                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">@lang('admin.users.avatar')</th>
                                            <th scope="col">@lang('validation.attributes.name')</th>
                                            <th class="text-left" scope="col">@lang('validation.attributes.email')</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="user in items" :key="user.id">
                                            <td v-text="user.id"></td>
                                            <td>
                                                <a :href="user.avatar" target="_blank">
                                                    <img class="avatar" :src="user.avatar" alt="" style="width: 50px; height: 50px;">
                                                </a>
                                            </td>
                                            <td>
                                                <ais-highlight attribute="name" :hit="user" highlighted-tag-name="em" />
                                            </td>
                                            <td class="text-left">
                                                <ais-highlight attribute="email" :hit="user" highlighted-tag-name="em" />
                                            </td>
                                            <td>
                                                <a :href="`/admin/users/${user.id}`" class="text-black-50 h4 mb-0">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a :href="`/admin/users/${user.id}/edit`" class="text-black-50 h4 ml-2 mb-0">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                                <form class="d-inline ml-2" method="POST" :action="`/admin/users/${user.id}`">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-link p-0" @click="destroy">
                                                        <i class="far fa-trash-alt text-black-50 h4 mb-0"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                @include('layouts.partials.ais-pagination')
                            </div>
                        </div>
                    </div>
                </ais-hits>
            </div>
        </search-view>
    </div>
@stop
