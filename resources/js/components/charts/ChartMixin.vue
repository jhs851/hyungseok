<template>
    <canvas :width="width" :height="height"></canvas>
</template>

<script>
    export default {
        props: {
            width: {
                type: Number,
                default: 400
            },
            height: {
                type: Number,
                default: 91
            },
            label: {
                type: String,
                default: ''
            },
            labels: {
                type: Array,
                required: true
            },
            data: {
                type: Array,
                required: true
            },
            fill: {
                type: Boolean,
                default: true
            },
            backgroundColor: {
                type: Array | String,
                default: '#f6fafd'
            },
            borderColor: {
                type: Array | String,
                default: '#8ab6e4'
            },
            pointBackgroundColor: {
                type: Array | String,
                default: 'rgba(104, 161, 220, .8)'
            },
            pointBorderColor: {
                type: Array | String,
                default: 'rgba(104, 161, 220, .8)'
            }
        },

        data() {
            return {
                myData: {
                    labels: this.labels,
                    datasets: [{
                        label: this.label,
                        data: this.data,
                        pointBackgroundColor: this.pointBackgroundColor,
                        pointBorderColor: this.pointBorderColor,
                        pointBorderWidth: 2,
                        fill: this.fill,
                        backgroundColor: this.backgroundColor,
                        borderColor: this.borderColor,
                        borderWidth: 2,
                        steppedLine: false
                    }]
                },

                myOptions: {
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            display: false
                        }],
                        yAxes: [{
                            display: false
                        }]
                    }
                }
            };
        }
    }
</script>