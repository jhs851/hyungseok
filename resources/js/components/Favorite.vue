<template>
    <button type="button" class="btn btn-sm px-0" @click.prevent="toggle">
        <i :class="active ? 'fas' : 'far'" class="fa-heart text-danger"></i>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: {
            data: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                count: this.data.favoritesCount,
                active: this.data.isFavorited
            };
        },

        methods: {
            toggle() {
                this.active ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint).then(() => {
                    this.count++;
                    this.active = true;
                }).catch(this.fail);
            },

            destroy() {
                axios.delete(this.endpoint).then(() => {
                    this.count--;
                    this.active = false;
                }).catch(this.fail);
            },

            fail(error) {
                toastr.error(error.response.data.message);
            }
        },

        computed: {
            endpoint() {
                return `${location.pathname}/favorite`;
            }
        }
    }
</script>