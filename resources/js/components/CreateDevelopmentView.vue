<script>
    export default {
        data() {
            return {
                uploadedImagesPath: []
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