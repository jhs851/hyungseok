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
