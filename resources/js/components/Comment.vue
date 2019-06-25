<script>
    import Form from '../core/Form';

    export default {
        props: {
            data: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                form: new Form({ body: this.data.body }),
                editing: false
            };
        },

        mounted() {
            this.$el.addEventListener('animationend', () => this.$el.remove());
        },

        methods: {
            edit() {
                this.editing = true;
            },

            submit() {
                this.form.put(`/comments/${this.data.id}`)
                    .then(() => this.editing = false);
            },

            cancel() {
                this.editing = false;
                this.form.revert();
            },

            destroy() {
                if (! confirm(this.trans('developments.confirm_destroy'))) {
                    return;
                }

                this.form.delete(`/comments/${this.data.id}`)
                    .then(() => this.$el.classList.add('animated', 'fadeOut'));
            }
        }
    }
</script>