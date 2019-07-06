@extends('layouts.app')

@section('content')
    <search-view class="container py-3" index="developments" v-cloak>
        <div class="row" slot-scope="{ onSelect, query, indicesToSuggestions, getSuggestion }">
            <div class="col-md-4">
                <div class="card rounded-0 my-2">
                    <div class="card-header">
                        @lang('developments.search')
                    </div>

                    <ais-configure :query="query" />

                    <ais-autocomplete>
                        <template slot-scope="{ currentRefinement, indices, refine }">
                            <div class="card-body">
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
                                        class: 'form-control pr-5',
                                        style: 'background: url({{ asset('images/icons/algolia-blue-mark.png') }}) right center / auto 100% no-repeat;',
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
                            </div>
                        </template>
                    </ais-autocomplete>
                </div>

                @if ($trending)
                    <div class="card rounded-0 my-2">
                        <div class="card-header">
                            @lang('developments.trending')
                        </div>

                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($trending as $development)
                                    <li class="list-group-item">
                                        <a href="{{ $development->path }}">
                                            {{ $development->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <ais-hits>
                    <div slot-scope="{ items }">
                        <div v-for="development in items" :key="development.id" class="card rounded-0 my-2">
                            <div class="card-header text-muted d-flex justify-content-between">
                                <a :href="`/users/${development.user_id}`">
                                    <ais-highlight attribute="user.name" :hit="development" highlighted-tag-name="em" />
                                </a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <a :href="`/developments/${development.id}`">
                                        <ais-highlight attribute="title" :hit="development" highlighted-tag-name="em" />
                                    </a>
                                </h5>

                                <p class="card-text text-black-50">
                                    <ais-highlight attribute="body" :hit="development" highlighted-tag-name="em" />
                                </p>
                            </div>

                            <div class="card-footer d-flex justify-content-between">
                                <small>
                                    <i class="far fa-clock mr-1"></i>
                                    @{{ development.created_at | dateFormat('Y. M. D') }}
                                </small>

                                <div>
                                    <small class="mr-3">
                                        <i class="far fa-eye mr-1"></i>
                                        @{{ development.visits }}
                                    </small>

                                    <small class="mr-3">
                                        <i class="far fa-comment mr-1"></i>
                                        @{{ development.comments_count }}
                                    </small>

                                    <small>
                                        <i class="far fa-heart mr-1"></i>
                                        @{{ development.favoritesCount }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <p v-if="! items.length" class="text-center py-9 my-5">
                            @lang('developments.empty')
                        </p>
                    </div>
                </ais-hits>

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
    </search-view>
@stop
