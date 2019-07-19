<script>
    import ChartMixin from './ChartMixin';

    export default {
        mixins: [ChartMixin],

        mounted() {
            new Chart(this.$el, {
                type: 'line',
                data: this.myData,
                options: this.myOptions
            });
        }
    }
</script>