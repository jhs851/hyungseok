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
                editing: false,
                form: new Form(this.data)
            };
        },

        methods: {
            edit() {
                this.editing = true;
                this.$root.$refs.navigation.edit();
            },

            cancel() {
                this.editing = false;
                this.form = new Form(this.form.original);
            },

            submit() {
                this.form.put(location.pathname)
                    .then(this.success)
                    .catch(errors => _.forEachRight(errors, field => field.forEach(message => toastr.error(message))));
            },

            success() {
                this.editing = false;
                this.$root.$refs.navigation.editing = false;
            },

            destroy(e) {
                if (! confirm(this.trans('developments.confirm_destroy'))) {
                    e.preventDefault();
                }
            }
        }
    }
</script>
