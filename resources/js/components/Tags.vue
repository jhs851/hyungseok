<template>
    <table class="table table-hover text-center h5 font-weight-light">
        <colgroup>
            <col style="width: 5%;">
            <col>
            <col style="width: 10%;">
            <col style="width: 12%;">
            <col style="width: 8%;">
        </colgroup>

        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th class="text-left" scope="col" v-text="trans('validation.attributes.name')"></th>
                <th scope="col" v-text="trans('admin.tags.mentions_count')"></th>
                <th scope="col" v-text="trans('admin.developments.created_at')"></th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody>
            <tag v-for="tag in tags" :key="tag.id" :data="tag" @delete="deleted"></tag>

            <tr v-if="! tags.length">
                <td colspan="8" v-text="trans('admin.tags.empty')"></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: {
            tags: {
                type: Array,
                required: true
            }
        },

        methods: {
            deleted(id) {
                this.$delete(this.tags, id);
            }
        }
    }
</script>
