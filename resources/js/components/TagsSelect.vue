<template>
    <div>
        <multiselect v-model="value" :options="tags" label="name" track-by="id" @input="change"
                     :placeholder="trans('developments.tags_placeholder')" :multiple="true" :close-on-select="false"
                     :select-label="trans('developments.multi_select.select_label')"
                     :selected-label="trans('developments.multi_select.selected_label')"
                     :deselect-label="trans('developments.multi_select.deselect_label')"
        >
            <div slot="maxElements" slot-scope="{ max }" v-text="trans('developments.multi_select.max_elements', { max: max })"></div>
            <div slot="noResult" v-text="trans('developments.multi_select.no_result')"></div>
            <div slot="noOptions" v-text="trans('developments.multi_select.no_options')"></div>
        </multiselect>

        <input v-for="v in value" type="hidden" name="tags[]" :value="v.id">
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        props: {
            old: {
                type: Array,
                default: () => []
            }
        },

        components: { Multiselect },

        data() {
            return {
                value: [],
                tags: []
            };
        },

        created() {
            axios.get('/api/tags').then(({data}) => {
                this.tags = data;

                if (this.old.length) {
                    this.old.forEach(id => {
                        this.value.push(this.tags.find(tag => tag.id == id));
                    });
                }
            });
        },

        methods: {
            change() {
                this.$emit('change', this.value.map(v => v.id));
            }
        }
    }
</script>
