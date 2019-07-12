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
            /**
             * 변경 모드를 시작합니다.
             */
            edit() {
                this.editing = true;
                this.$root.$refs.navigation.edit();
            },

            /**
             * 변경 모드를 취소합니다.
             */
            cancel() {
                this.editing = false;
                this.form.revert();
            },

            /**
             * 변경합니다.
             */
            submit() {
                this.form.put(location.pathname)
                    .then(this.success)
                    .catch(errors => _.forEachRight(errors, field => field.forEach(message => toastr.error(message))));
            },

            /**
             * 변경을 완료한 후에 응답입니다.
             *
             * @param {object} data
             */
            success(data) {
                this.editing = false;
                this.$root.$refs.navigation.editing = false;
            }
        }
    }
</script>
