<template>
    <ais-instant-search :search-client="searchClient" :index-name="index">
        <slot></slot>
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
                )
            };
        }
    }
</script>
