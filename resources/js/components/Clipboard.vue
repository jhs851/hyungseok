<template>
    <a v-clipboard:copy="data" v-clipboard:success="copied">
        <slot></slot>
    </a>
</template>

<script>
    export default {
        props: {
            data: {
                required: true
            }
        },

        methods: {
            copied() {
                toastr.success(this.trans('developments.copied'));
            }
        }
    }
</script>

<style scoped lang="scss">
    a {
        cursor: pointer;
    }
</style>
