<template>

</template>

<script>
    export default {
      /* mounted() {
        },

        data() {

            return {
                chartData1: [],
                balanceList: [],
                token: this.token
            }
        },

        methods: {

            generateChartData() {
              var firstDate = new Date();
              firstDate.setDate( firstDate.getDate() - 500 );
              firstDate.setHours( 0, 0, 0, 0 );

              for ( var i = 0; i < 500; i++ ) {
                var newDate = new Date( firstDate );
                newDate.setDate( newDate.getDate() + i );

                var a1 = Math.round( Math.random() * ( 40 + i ) ) + 100 + i;
                var b1 = Math.round( Math.random() * ( 1000 + i ) ) + 500 + i * 2;

                this.chartData1.push( {
                  "date": newDate,
                  "value": a1,
                  "volume": b1
                } );
              }
            },

            createChart(target, dataset) {

                var chart = AmCharts.makeChart( target, {
                  "type": "serial",
                  "theme": "light",
                  "zoomOutButton": {
                    "backgroundColor": '#000000',
                    "backgroundAlpha": 0.15
                  },
                  "dataProvider": dataset,
                  "categoryField": "date",
                  "categoryAxis": {
                    "parseDates": true,
                    "minPeriod": "ss",
                    "dashLength": 1,
                    "gridAlpha": 0.15,
                    "axisColor": "#DADADA"
                  },
                  "graphs": [ {
                    "id": "g1",
                    "valueField": "balance",
                    "bullet": "round",
                    "bulletBorderColor": "#FFFFFF",
                    "bulletBorderThickness": 2,
                    "lineThickness": 2,
                    "lineColor": "#b5030d",
                    "negativeLineColor": "#0352b5",
                    "hideBulletsCount": 50
                  } ],
                  "chartCursor": {
                    "cursorPosition": "mouse"
                  },
                  "chartScrollbar": {
                    "graph": "g1",
                    "scrollbarHeight": 40,
                    "color": "#FFFFFF",
                    "autoGridCount": true
                  }
                } )
                
            },
            getBalance() {
                var self = this
                setInterval(function(){ 
                    var data = 0
                    axios.get('http://api.tapklik.com/v1/accounts/' + id + '/banker/main?query=balance', this.$root.config).then( response => {
                        //this.balanceList.push(response.data.data.balance)
                    var time = new Date(); console.log(time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds()); 
                    if (self.balanceList.length > 30) {
                        self.balanceList.splice(0,1)
                    }
                        self.balanceList.push({
                          "date": time,
                          "balance": response.data.data.balance
                        })
                        self.createChart('chartdiv', self.balanceList)
                    }, error => {
                        console.log(error);
                    });
                    }, 1000); 
            },

            generateOverallChart() {

                this.createChart('chartdiv', this.chartData1);
            },
        },

        computed: {

        },

        watch: {
            token(value) {

            }
        } */
    }

</script>