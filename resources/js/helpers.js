import Translator from './core/Translator';

Vue.mixin({
    data() {
        return {
            translator: new Translator
        };
    },

    created() {
        axios.get('/js/languages.js')
             .then(({data}) => this.translator = new Translator(data));
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
        }
    }
});
