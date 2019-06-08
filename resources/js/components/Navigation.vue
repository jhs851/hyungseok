<script>
    export default {
        props: {
            isWrite: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                writing: this.isWrite,
                editing: false
            };
        },

        methods: {
            edit() {
                this.editing = true;
            },

            submit() {
                this.$root.$refs.form.submit();
            },

            cancel() {
                if (! confirm(this.trans('developments.confirm_cancel'))) {
                    return;
                }

                this.editing = false;
                this.$root.$refs.form.cancel();
            }
        }
    }
</script>
