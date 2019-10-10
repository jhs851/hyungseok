<script>
    import DevelopmentsControlMixin from '../mixins/DevelopmentsControlMixin';

    export default {
        mixins: [DevelopmentsControlMixin],

        data() {
            return {
                temporaryDevelopment: null
            };
        },

        created() {
            axios.get('/temporary-developments').then(this.receive);
        },

        mounted() {
            setInterval(this.autosave, 180000);
        },

        methods: {
            receive({ data: { temporaryDevelopment } }) {
                if (temporaryDevelopment) {
                    this.temporaryDevelopment = temporaryDevelopment;

                    if (confirm(this.trans('developments.temporary.exists'))) {
                        return this.confirm();
                    }

                    this.cancel();
                }
            },

            confirm() {
                this.form.title = this.temporaryDevelopment.title;
                this.form.body = this.temporaryDevelopment.body;

                toastr.success(this.trans('developments.temporary.loaded'));
            },

            cancel() {
                axios.delete(`/temporary-developments/${this.temporaryDevelopment.id}`)
                    .then(() => this.temporaryDevelopment = null);
            },

            autosave() {
                if (this.temporaryDevelopment) {
                    return this.update();
                }

                this.store();
            },

            update() {
                this.form.put(`/temporary-developments/${this.temporaryDevelopment.id}`)
                    .catch(this.invalid);
            },

            store() {
                this.form.post('/temporary-developments')
                    .then(({ temporaryDevelopment }) => this.temporaryDevelopment = temporaryDevelopment)
                    .catch(this.invalid);
            },

            invalid() {
                console.warn('Validation of title and body value failed.');
            }
        }
    }
</script>
