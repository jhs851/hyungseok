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
            }
        }
    }
</script>