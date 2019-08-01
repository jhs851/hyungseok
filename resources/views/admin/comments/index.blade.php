@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-md-4">
                <div class="rounded bg-white z-depth-1 hvr-float w-100" style="height: 300px;">
                    <div class="d-flex flex-column py-3 px-4 h-100">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.comments.total')
                        </h4>

                        <h1 class="display-4 mb-auto">{{ number_format($commentsCount) }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded bg-white z-depth-1 hvr-float w-100" style="height: 300px;">
                    <div class="d-flex flex-column h-100 py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.comments.most_commentable')
                        </h4>

                        <h1>
                            <a href="{{ route('admin.developments.show', $mostCommentable->id) }}">
                                {{ $mostCommentable->title }}
                            </a>
                        </h1>

                        <h3 class="text-right mt-auto">
                            {{ $mostCommentable->comments_count }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <search-view class="row mt-5 align-items-end" index="comments" reference="body" v-cloak>
            <div class="col-12" slot-scope="{ onSelect, query, indicesToSuggestions, getSuggestion }">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <h2 class="mb-3">@lang('admin.comments.title')</h2>

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
                                                <h6 class="mb-2 font-weight-bold">@{{ suggestion.item.body | strLimit(31) }}</h6>

                                                <small class="mb-0 text-black-50" v-text="suggestion.item.user.name"></small>
                                            </div>
                                        </div>
                                    </template>
                                </vue-autosuggest>
                            </template>
                        </ais-autocomplete>
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
                                        <col>
                                        <col style="width: 12%;">
                                        <col style="width: 8%;">
                                    </colgroup>

                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">@lang('admin.developments.writer')</th>
                                            <th class="text-left" scope="col">@lang('validation.attributes.body')</th>
                                            <th scope="col">@lang('admin.developments.created_at')</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="comment in items" :key="comment.id">
                                            <td v-text="comment.id"></td>
                                            <td>
                                                <a :href="`/admin/users/${comment.user_id}`">
                                                    <ais-highlight attribute="user.name" :hit="comment" highlighted-tag-name="em" />
                                                </a>
                                            </td>
                                            <td class="text-left">
                                                <a :href="`/admin/developments/${comment.development.id}`">
                                                    <ais-highlight attribute="body" :hit="comment" highlighted-tag-name="em" />
                                                </a>
                                            </td>
                                            <td>
                                                @{{ comment.created_at | dateFormat('Y. M. D') }}
                                            </td>
                                            <td>
                                                <a :href="`/admin/developments/${comment.development.id}`" class="text-black-50 h4 mb-0">
                                                    <i class="far fa-eye"></i>
                                                </a>

                                                <form class="d-inline ml-2" method="POST" :action="`/admin/comments/${comment.id}`">
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
                                                @lang('admin.comments.empty')
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

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
