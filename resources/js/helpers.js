import Translator from './core/Translator';
import VueClipboard from 'vue-clipboard2';
import InstantSearch from 'vue-instantsearch';
import VueAutosuggest from 'vue-autosuggest';

Vue.mixin({
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
         * 현재 사용자가 있는지 확인합니다.
         *
         * @returns {boolean}
         */
        auth() {
            return document.head.querySelector('meta[name="auth"]').content;
        }
    },

    filters: {
        /**
         * 주어진 날짜를 주어진 포팻으로 반환합니다.
         *
         * @param  {string} date
         * @param  {string} format
         * @return {string}
         */
        dateFormat(date, format) {
            return moment(date).format(format);
        },

        /**
         * 주어진 문자열을 주어진 수로 자릅니다.
         *
         * @param {string} value
         * @param {number} limit
         * @param {string} end
         * @return {string}
         */
        strLimit(value, limit = 100, end = '...') {
            if (value.length <= limit) {
                return value;
            }

            return value.substr(0, limit).trim() + end;
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
    .use(InstantSearch)
    .use(VueAutosuggest);
