<template>
    <ais-instant-search :search-client="searchClient" :index-name="index">
        <slot :onSelect="onSelect" :indicesToSuggestions="indicesToSuggestions" :query="query" :getSuggestion="getSuggestion"></slot>
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        props: {
            index: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                searchClient: algoliasearch(
                    process.env.MIX_ALGOLIA_APP_ID,
                    process.env.MIX_ALGOLIA_APP_KEY
                ),
                query: ''
            };
        },

        methods: {
            onSelect(selected) {
                if (selected) {
                    this.query = selected.item.title;
                }
            },

            indicesToSuggestions(indices) {
                return indices.map(({ hits }) => ({ data: hits }));
            },

            getSuggestion(suggestion) {
                return suggestion.item.title;
            }
        }
    }
</script>
