<template>
    <div>
        <comment v-for="comment in items" :data="comment" :key="comment.id"></comment>

        <new-comment @store="add"></new-comment>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                items: this.data
            };
        },

        methods: {
            /**
             * 아이템을 추가합니다.
             *
             * @param {object} item
             */
            add(item) {
                this.items.push(item);
            }
        }
    }
</script>