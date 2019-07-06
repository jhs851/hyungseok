<template>
    <div class="markdown-editor">
        <textarea :name="name"></textarea>
    </div>
</template>

<script>
    import SimpleMDE from 'simplemde';

    export default {
        props: {
            value: String,
            name: String
        },

        mounted() {
            this.initialize();
        },

        computed: {
            configs() {
                return {
                    hideIcons: ['guide', 'side-by-side', 'fullscreen'],
                    insertTexts: {
                        horizontalRule: ['', "\n\n-----\n\n"],
                        image: ['![](http://', ')'],
                        link: ['[', '](http://)'],
                        table: ['', "\n\n" + this.trans('markdown.table.example1') + "\n\n"],
                    },
                    placeholder: this.trans('developments.body_placeholder'),
                    spellChecker: false,
                    status: ['lines', 'words', 'cursor'],
                    toolbar: this.toolbar,
                    tabSize: 4
                };
            },

            toolbar() {
                return [
                    {
                        name: 'bold',
                        action: SimpleMDE.toggleBold,
                        className: 'fas fa-bold',
                        title: this.trans('markdown.toolbar.bold'),
                    },
                    {
                        name: 'italic',
                        action: SimpleMDE.toggleItalic,
                        className: 'fas fa-italic',
                        title: this.trans('markdown.toolbar.italic'),
                    },
                    {
                        name: 'strikethrough',
                        action: SimpleMDE.toggleStrikethrough,
                        className: 'fas fa-strikethrough',
                        title: this.trans('markdown.toolbar.strikethrough')
                    },
                    {
                        name: 'heading-bigger',
                        action: SimpleMDE.toggleHeadingBigger,
                        className: 'fas fa-lg fa-heading',
                        title: this.trans('markdown.toolbar.heading_bigger')
                    },
                    {
                        name: 'heading-smaller',
                        action: SimpleMDE.toggleHeadingSmaller,
                        className: 'fas fa-heading',
                        title: this.trans('markdown.toolbar.heading_smaller')
                    },
                    '|',
                    {
                        name: 'code',
                        action: SimpleMDE.toggleCodeBlock,
                        className: 'fas fa-code',
                        title: this.trans('markdown.code.title')
                    },
                    {
                        name: 'quote',
                        action: SimpleMDE.toggleBlockquote,
                        className: 'fas fa-quote-left',
                        title: this.trans('markdown.quoting_text.title')
                    },
                    '|',
                    {
                        name: 'unordered-list',
                        action: SimpleMDE.toggleUnorderedList,
                        className: 'fas fa-list-ul',
                        title: this.trans('markdown.toolbar.ul')
                    },
                    {
                        name: 'ordered-list',
                        action: SimpleMDE.toggleOrderedList,
                        className: 'fas fa-list-ol',
                        title: this.trans('markdown.toolbar.ol')
                    },
                    '|',
                    {
                        name: 'link',
                        action: SimpleMDE.drawLink,
                        className: 'fas fa-link',
                        title: this.trans('markdown.links.title')
                    },
                    {
                        name: 'image',
                        action: SimpleMDE.drawImage,
                        className: 'fas fa-picture-o',
                        title: this.trans('markdown.image.title')
                    },
                    {
                        name: 'table',
                        action: SimpleMDE.drawTable,
                        className: 'fas fa-table',
                        title: this.trans('markdown.table.title')
                    },
                    {
                        name: 'horizontal-rule',
                        action: SimpleMDE.drawHorizontalRule,
                        className: 'fas fa-minus',
                        title: this.trans('markdown.horizontal_rules.title')
                    },
                    '|',
                    {
                        name: 'preview',
                        action: SimpleMDE.togglePreview,
                        className: 'far fa-eye no-disable',
                        title: this.trans('markdown.toolbar.preview')
                    }
                ];
            }
        },

        activated() {
            const editor = this.simplemde;

            if (! editor) {
                return;
            }

            const isActive = editor.isSideBySideActive() || editor.isPreviewActive();

            if (isActive) {
                editor.toggleFullScreen();
            }
        },

        methods: {
            initialize() {
                let configs = Object.assign({
                    element: this.$el.firstElementChild,
                    initialValue: this.value,
                    renderingConfig: {},
                }, this.configs);

                if (configs.initialValue) {
                    this.$emit('input', configs.initialValue);
                }

                this.simplemde = new SimpleMDE(configs);

                this.bindingEvents();
            },

            bindingEvents() {
                this.simplemde.codemirror.on('change', () => {
                    this.$emit('input', this.simplemde.value());
                });
            }
        },

        destroyed() {
            this.simplemde = null;
        },

        watch: {
            value(val) {
                if (val === this.simplemde.value()) {
                    return;
                }

                this.simplemde.value(val);
            }
        }
    }
</script>

<style>
    .markdown-editor .markdown-body {
        padding: 0.5em
    }

    .markdown-editor .editor-preview-active, .markdown-editor .editor-preview-active-side {
        display: block;
    }
</style>
