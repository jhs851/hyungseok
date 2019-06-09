/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('./helpers');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    methods: {
        /**
         * Waves effect를 .btn과 .btn-floating element에 attach하고 enable합니다.
         */
        initializeWaves() {
            Waves.attach('.btn', ['waves-light']);
            Waves.attach('.btn-floating', ['waves-light', 'waves-ripple']);
            Waves.init();
        },

        /**
         * 모든 textarea element들을 autosize 합니다.
         */
        enableAutosize() {
            autosize(document.querySelectorAll('textarea'));
        },

        /**
         * 주어진 폼을 submit 합니다.
         *
         * @param {string} formName
         */
        submit(formName) {
            if (this.$refs.hasOwnProperty(formName)) {
                this.$refs[formName].submit();
            }
        },

        /**
         * 주어진 event의 target element를 disabled 하고 주어진 message로 변경합니다.
         *
         * @param {Object} event
         * @param {string} message
         */
        disable(event, message) {
            let $target = $(event.target);

            if ($target.hasClass('disabled')) {
                return event.preventDefault();
            }

            $target.addClass('disabled').html(`<i class="fas fa-spinner fa-pulse mr-2"></i> ${message}`);
        },

        /**
         * 모든 tooltip을 활성화 합니다.
         */
        enableTooltips() {
            $('[data-toggle="tooltip"]').tooltip();
        },

        enablePrism() {
            Prism.highlightAll();
        }
    },

    mounted() {
        this.initializeWaves();
        this.enableAutosize();
        this.enableTooltips();
        this.enablePrism();
    }
});
