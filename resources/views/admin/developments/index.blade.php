@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            @component('admin.layouts.components.card')
                <div class="d-flex flex-column py-3 px-4 h-100">
                    <h4 class="text-muted font-weight-bold">
                        @lang('admin.developments.total')
                    </h4>

                    <h1 class="display-4 mb-auto">{{ number_format($developmentsCount) }}</h1>

                    <h2 class="text-muted mb-0">
                        <i class="fas fa-level-up-alt mr-3 text-success"></i>
                        @lang('admin.developments.increase', ['percentage' => $incremental])
                    </h2>
                </div>
            @endcomponent

            @component('admin.layouts.components.card')
                <div class="py-3 px-4">
                    <h4 class="text-muted font-weight-bold">
                        @lang('admin.developments.month_of_new')
                    </h4>

                    <h1 class="display-4">{{ $monthliesCount }}</h1>
                </div>

                <chart-line label="@lang('admin.dashboard.unit', ['unit' => '일/개'])"
                            :labels="{{ json_encode($countsByDays->pluck('day')->values()) }}"
                            :data="{{ json_encode($countsByDays->pluck('count')->values()) }}"></chart-line>
            @endcomponent

            @if ($mostVisited)
                @component('admin.layouts.components.card')
                    <div class="d-flex flex-column py-3 px-4 h-100">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.developments.most_visited')
                        </h4>

                        <h1 class="display-4 mb-auto">{{ number_format($mostVisited->visits) }}</h1>

                        <h2 class="text-muted mb-0">
                            <a href="{{ route('developments.show', $mostVisited->id) }}">{{ $mostVisited->title }}</a>
                        </h2>
                    </div>
                @endcomponent
            @endif
        </div>

        <search-view class="row mt-5 align-items-end" index="developments" v-cloak>
            <div class="col-12" slot-scope="{ onSelect, query, indicesToSuggestions, getSuggestion }">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <h2 class="mb-3">@lang('developments.title')</h2>

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
                                            placeholder: '@lang('developments.search_placeholder')'
                                        }"
                                >
                                    <li slot="before-section-default" class="placeholder">@lang('developments.autocomplete_placeholder')</li>

                                    <template slot-scope="{ suggestion }">
                                        <div class="py-3">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-2 font-weight-bold">@{{ suggestion.item.title | strLimit(31) }}</h6>

                                                <small class="mb-0 text-black-50" v-text="suggestion.item.user.name"></small>
                                            </div>
                                        </div>
                                    </template>
                                </vue-autosuggest>
                            </template>
                        </ais-autocomplete>
                    </div>

                    <div class="col-auto ml-auto">
                        <a href="{{ route('admin.developments.create') }}" class="btn btn-primary btn-lg">
                            @lang('developments.create')
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
                                        <col style="width: 10%;">
                                        <col>
                                        <col style="width: 10%;">
                                        <col style="width: 10%;">
                                        <col style="width: 12%;">
                                        <col style="width: 12%;">
                                    </colgroup>

                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">@lang('admin.developments.writer')</th>
                                            <th class="text-left" scope="col">@lang('validation.attributes.title')</th>
                                            <th scope="col">@lang('admin.developments.comments_count')</th>
                                            <th scope="col">@lang('admin.developments.visits_count')</th>
                                            <th scope="col">@lang('admin.developments.created_at')</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="development in items" :key="development.id">
                                            <td v-text="development.id"></td>
                                            <td>
                                                <a :href="`/admin/users/${development.user_id}`">
                                                    <ais-highlight attribute="user.name" :hit="development" highlighted-tag-name="em" />
                                                </a>
                                            </td>
                                            <td class="text-left">
                                                <ais-highlight attribute="title" :hit="development" highlighted-tag-name="em" />
                                            </td>
                                            <td v-text="development.comments_count"></td>
                                            <td v-text="development.visits"></td>
                                            <td>
                                                @{{ development.created_at | dateFormat('Y. M. D') }}
                                            </td>
                                            <td>
                                                <a :href="`/admin/developments/${development.id}`" class="text-black-50 h4 mb-0">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a :href="`/admin/developments/${development.id}/edit`" class="text-black-50 h4 ml-2 mb-0">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                                <form class="d-inline ml-2" method="POST" :action="`/admin/developments/${development.id}`">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-link p-0" @click="destroy">
                                                        <i class="far fa-trash-alt text-black-50 h4 mb-0"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <tr v-if="! items.length">
                                            <td colspan="8">
                                                @lang('developments.empty')
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
