<script>
    import Form from '../core/Form';

    export default {
        props: {
            title: {
                type: String,
                default: ''
            },
            body: {
                type: String,
                default: ''
            }
        },

        data() {
            return {
                uploadedImagesPath: [],
                form: new Form({
                    title: this.title,
                    body: this.body
                })
            };
        },

        methods: {
            /**
             * 주어진 경로를 추가 합니다.
             *
             * @param {string} path
             */
            addPath(path) {
                this.uploadedImagesPath.push(path);
            },

            /**
             * 현재 뷰에 존재하는 폼을 전송합니다.
             */
            submit() {
                $(this.$el).find('form').submit();
            }
        }
    }
</script>
