<template>
    <div>
        <div id="toc" v-html="tocHtml"></div>

        <vue-markdown class="markdown-body" :task-lists="false" :toc="true" :toc-anchor-link="false" @rendered="enablePrism" @toc-rendered="tocAllRight">
            <slot></slot>
        </vue-markdown>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tocHtml: ''
            };
        },

        methods: {
            /**
             * toc-id 설정해도 최초 toc 렌더링이 안됩니다.
             * 그래서 toc을 렌더링한 뒤에 string을 받아오고 받아온 string을 출력하는 형식 입니다.
             *
             * @param {string} tocHtmlStr
             */
            tocAllRight(tocHtmlStr) {
                this.tocHtml = tocHtmlStr;
            }
        }
    }
</script>
