<template>
    <div>
        <modal name="markdownHelperModal" ref="modal" full-height="right"
               modal-styles="width: 800px; left: unset; right: 0;" dialog-styles="width: 800px; max-width: 800px;"
               content-classes="border-0 rounded-0 position-absolute h-100" content-styles="width: 400px; right: 0;"
               header-classes="rounded-0 border-left" body-classes="border-left bg-white">
            <h5 class="mb-0" slot="header" v-text="trans('markdown.header')"></h5>

            <div slot="body">
                <div class="accordion" id="markdownHelperAccordion">
                    <markdown-headings></markdown-headings>

                    <markdown-horizontal-rules></markdown-horizontal-rules>

                    <markdown-typographic-replacements></markdown-typographic-replacements>

                    <markdown-styling-text></markdown-styling-text>

                    <markdown-quoting-text></markdown-quoting-text>

                    <markdown-quoting-code></markdown-quoting-code>

                    <markdown-links></markdown-links>

                    <markdown-lists></markdown-lists>

                    <markdown-code></markdown-code>

                    <markdown-table></markdown-table>

                    <markdown-image></markdown-image>

                    <markdown-abbreviations></markdown-abbreviations>

                    <markdown-emojies></markdown-emojies>

                    <markdown-subscript-superscript></markdown-subscript-superscript>

                    <markdown-task-lists></markdown-task-lists>
                </div>
            </div>
        </modal>

        <button type="button" class="btn btn-primary btn-sm btn-floating position-fixed" data-toggle="modal"
                data-target="#markdownHelperModal" data-backdrop="false" data-keyboard="false" data-focus="false"
                style="right: 30px; bottom: 30px;">
            <i class="fas fa-question"></i>
        </button>
    </div>
</template>

<script>
    import 'webpack-jquery-ui/resizable';

    export default {
        mounted() {
            $(this.$refs.modal.$el).find('.modal-content').resizable({
                handles: 'w',
                minWidth: 400,
                maxWidth: 800
            });
        }
    }
</script>

<style scoped lang="scss">
    a {
        cursor: pointer;
    }
</style>
