<script>
    import ChartMixin from './ChartMixin';

    export default {
        mixins: [ChartMixin],

        mounted() {
            new Chart(this.$el, {
                type: 'bar',
                data: this.myData,
                options: this.myOptions
            });
        }
    }
</script>