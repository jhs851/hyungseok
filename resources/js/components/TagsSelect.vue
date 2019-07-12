<template>
    <div>
        <multiselect name="tags[]" v-model="value" :options="tags" label="name" track-by="id"
                     :placeholder="trans('developments.tags_placeholder')" :multiple="true" :close-on-select="false"
                     :select-label="trans('developments.multi_select.select_label')"
                     :group-label="trans('developments.multi_select.group_label')"
                     :selected-label="trans('developments.multi_select.selected_label')"
                     :deselect-label="trans('developments.multi_select.deselect_label')"
                     :deselect-group-label="trans('developments.multi_select.deselect_group_label')"
        >
            <div slot="maxElements" slot-scope="{ max }" v-text="trans('developments.multi_select.max_elements', { max: max })"></div>
            <div slot="noResult" v-text="trans('developments.multi_select.no_result')"></div>
            <div slot="noOptions" v-text="trans('developments.multi_select.no_options')"></div>
        </multiselect>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        components: { Multiselect },

        data() {
            return {
                value: [],
                tags: []
            };
        },

        created() {
            axios.get('/api/tags').then(({data}) => this.tags = data);
        }
    }
</script>