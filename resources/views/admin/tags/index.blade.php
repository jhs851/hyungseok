@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-md-4">
                <div class="rounded bg-white z-depth-1 hvr-float w-100" style="height: 300px;">
                    <div class="d-flex flex-column py-3 px-4 h-100">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.tags.total')
                        </h4>

                        <h1 class="display-4 mb-auto">{{ number_format($tags->count()) }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded bg-white z-depth-1 hvr-float w-100" style="height: 300px;">
                    <div class="d-flex flex-column h-100 py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.tags.most_mentioned')
                        </h4>

                        <h1>
                            {{ $tags->orderBy('mentions', 'desc')->first()->name }}
                        </h1>

                        <h3 class="text-right mt-auto">
                            {{ $tags->orderBy('mentions', 'desc')->first()->mentions }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded bg-white z-depth-1 hvr-float w-100" style="height: 300px;">
                    <div class="d-flex flex-column h-100 py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.tags.unmentioned_tags')
                        </h4>

                        <div>
                            @foreach ($tags->where('mentions', 0)->get() as $tag)
                                <span class="badge badge-warning font-weight-normal px-2 py-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <search-view class="row mt-5 align-items-end" index="tags" v-cloak reference="name">
            <div class="col-12" slot-scope="{ onSelect, query, indicesToSuggestions, getSuggestion }">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <h2 class="mb-3">@lang('validation.attributes.tags')</h2>

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
                                                <h6 class="mb-2 font-weight-bold">@{{ suggestion.item.name | strLimit(31) }}</h6>
                                            </div>
                                        </div>
                                    </template>
                                </vue-autosuggest>
                            </template>
                        </ais-autocomplete>
                    </div>

                    <div class="col-auto ml-auto">
                        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-lg">
                            @lang('admin.tags.create')
                        </a>
                    </div>
                </div>

                <ais-hits>
                    <div class="row mt-3" slot-scope="{ items }">
                        <div class="col-12">
                            <div class="table-responsive bg-white z-depth-1 rounded-lg pb-3">
                                <tags :tags="items"></tags>

                                <ais-pagination class="mt-3">
                                    <ul slot-scope="{ currentRefinement, nbPages, pages, isFirstPage, isLastPage, refine, createURL }"
                                        class="pagination justify-content-center" role="navigation">

                                        <template v-if="isFirstPage">
                                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
                                                <span class="page-link" aria-hidden="true">&laquo;</span>
                                            </li>

                                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                                <span class="page-link" aria-hidden="true">&lsaquo;</span>
                                            </li>
                                        </template>

                                        <template v-else>
                                            <li class="page-item">
                                                <a class="page-link" :href="createURL(0)" @click.prevent="refine(0)" rel="first" aria-label="@lang('pagination.first')">&laquo;</a>
                                            </li>

                                            <li class="page-item">
                                                <a class="page-link" :href="createURL(currentRefinement - 1)" @click.prevent="refine(currentRefinement - 1)" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                            </li>
                                        </template>

                                        <li v-for="page in pages" :key="page" class="page-item" :class="{ active: page === currentRefinement }">
                                            <span v-if="page === currentRefinement" class="page-link">@{{ page + 1 }}</span>

                                            <a v-else class="page-link" :href="createURL(page)" @click.prevent="refine(page)">@{{ page + 1 }}</a>
                                        </li>

                                        <template v-if="isLastPage">
                                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                                <span class="page-link" aria-hidden="true">&rsaquo;</span>
                                            </li>

                                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
                                                <span class="page-link" aria-hidden="true">&raquo;</span>
                                            </li>
                                        </template>

                                        <template v-else>
                                            <li class="page-item">
                                                <a class="page-link" :href="createURL(currentRefinement + 1)"  @click.prevent="refine(currentRefinement + 1)" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                                            </li>

                                            <li class="page-item">
                                                <a class="page-link" :href="createURL(nbPages)" @click.prevent="refine(nbPages)" rel="last" aria-label="@lang('pagination.last')">&raquo;</a>
                                            </li>
                                        </template>
                                    </ul>
                                </ais-pagination>
                            </div>
                        </div>
                    </div>
                </ais-hits>
            </div>
        </search-view>
    </div>
@stop
