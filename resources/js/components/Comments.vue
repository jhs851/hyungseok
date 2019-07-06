<template>
    <div>
        <transition-group enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown" tag="div">
            <comment v-for="(comment, index) in items" :key="comment.id" :data="comment" @delete="remove(index)"></comment>
        </transition-group>

        <new-comment @store="add"></new-comment>
    </div>
</template>

<script>
    import VueTribute from 'vue-tribute';

    export default {
        props: {
            data: {
                type: Array,
                required: true
            }
        },

        components: { VueTribute },

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
        },

        computed: {
            /**
             * Vue Tribute 옵션을 반환합니다.
             *
             * @return {object}
             */
            tributeOptions() {
                return {
                    lookup: 'name',
                    fillAttr: 'name',
                    values: function (text, cb) {
                        $.getJSON('/users', { name: text }, username => cb(username));
                    }
                };
            }
        }
    }
</script>
