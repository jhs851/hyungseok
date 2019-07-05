<template>
    <div>
        <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="div">
            <comment v-for="(comment, index) in items" :key="comment.id" :data="comment" @delete="remove(index)"></comment>
        </transition-group>

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
            },

            /**
             * 아이템을 삭제합니다.
             *
             * @param {int} index
             */
            remove(index) {
                this.$delete(this.items, index);
            }
        }
    }
</script>