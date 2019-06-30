import Translator from './core/Translator';
import VueClipboard from 'vue-clipboard2';
import VueMarkdown from 'vue-markdown';
import VueSimpleMDE from 'vue-simplemde';
import VueTribute from 'vue-tribute';

Vue.mixin({
    components: { VueMarkdown, VueTribute },

    data() {
        return {
            translator: new Translator,
            user: {}
        };
    },

    created() {
        this.user = this.auth ? JSON.parse(document.head.querySelector('meta[name="user"]').content) : {};
    },

    computed: {
        /**
         * Simple MDE 설정을 반환합니다.
         *
         * @returns {object}
         */
        simpleMDEConfigs() {
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
                toolbar: this.simpleMDEToolbar,
                tabSize: 4
            };
        },

        /**
         * Simeple MDE 툴바 설정을 반환합니다.
         *
         * @returns {array}
         */
        simpleMDEToolbar() {
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
        },

        /**
         * 현재 사용자가 있는지 확인합니다.
         *
         * @returns {boolean}
         */
        auth() {
            return document.head.querySelector('meta[name="auth"]').content;
        },

        /**
         * Vue Tribute 옵션을 반환합니다.
         *
         * @return {object}
         */
        tributeOptions() {
            return {
                lookup: 'name',
                fillAttr: 'name',
                values: function (text, cb) {
                    $.getJSON('/users', { name: text }, username => cb(username));
                }
            };
        }
    },

    methods: {
        /**
         * 주어진 키에 대한 번역을 반환합니다.
         *
         * @param  {string|null} key
         * @return {string|Translator}
         */
        trans(key = null) {
            if (! key) {
                return this.translator;
            }

            return this.translator.trans(key);
        },

        /**
         * Prism.js 를 활성화 합니다.
         */
        enablePrism() {
            this.$nextTick(() => Prism.highlightAll());
        },

        /**
         * 정말 삭제할건지 확인합니다.
         *
         * @param e
         */
        destroy(e) {
            if (! confirm(this.trans('developments.confirm_destroy'))) {
                e.preventDefault();
            }
        },

        /**
         * 현재 사용자에게 권한이 있는지 확인합니다.
         *
         * @param   {object} model
         * @returns {boolean}
         */
        authorize(model) {
            if (! this.auth) {
                return false;
            }

            if (this.user.isAdmin) {
                return true;
            }

            return model.hasOwnProperty('user_id') && this.user.id == model.user_id;
        }
    }
})
    .use(VueClipboard)
    .use(VueSimpleMDE);
