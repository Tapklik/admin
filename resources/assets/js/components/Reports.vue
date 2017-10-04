<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Reports</h1>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-4">
                <h4>Nodes</h4>
            </div>
            <div class="col-md-6">
                <div class="col-md-12 panel panel-default">
                    <h4>Total </h4>
                    <div id="chartdiv" style="height: 300px;"></div>
                </div>
            </div>
        </div>
       
        <div>{{ getNodes() }}</div>
       
        <hr/>
       
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Table</h1>
            </div>
        </div>

        <hr/>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody class="vcenter">
                <tr v-show="loading == true">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <tr v-show="noresult">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <tr v-for="b in bids">
                    <td>
                        <a :href="'reports/' + b.id">
                            {{ b.id }}
                        </a>
                    </td>
                    <td>
                        {{ b.time }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
   export default {
        mounted() {
            this.getData();
            this.createChartStats('chartdiv', this.emptyData())
        },
        data() {
            return {
                campaigns: [],
                token: this.token,
                stats: [],     
                bids: [],
                loading: false,
                noresult: false
            }
        },
        methods: {
            fetchCampaigns() {
                            
                axios.get(this.$root.api + 'campaigns', this.$root.config).then(response => {
                    this.campaigns = response.data;
                }, error => {
                    console.log("heeey")
                    swal('Error', error, 'error');
                })
            },
             getData() {
                var self = this
                setInterval(function(){
                    self.getStatsData();
                }, 2000); 
            },
            getStatsData(){
                var self = this;
                var time = new Date()
                axios.get('http://45.76.95.115:2301/api/stats', this.$root.config).then( response => {
                    self.stats = response
                }, error => {
                    console.log(error);
                });
            },
            createChartStats(target, dataset) {
                var self = this; 
                var chart = AmCharts.makeChart( target, {
                  "type": "serial",
                  "theme": "light",
                  "zoomOutButton": {
                    "backgroundColor": '#000000',
                    "backgroundAlpha": 0.15
                    },
                    "dataProvider": self.emptyData(),
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": true,
                        "minPeriod": "ss",
                        "dashLength": 1,
                        "gridAlpha": 0.15,
                        "axisColor": "#DADADA"
                    },
                    "graphs": [ {
                        "id": "bid_requests",
                        "valueField": "bid_requests",
                        "lineThickness": 2,
                        "lineColor": "red",
                        "hideBulletsCount": 50
                    }, {
                        "id": "bids",
                        "valueField": "bids",
                        "lineThickness": 2,
                        "lineColor": "orange",
                        "hideBulletsCount": 50
                    }, {
                        "id": "imps",
                        "valueField": "imps",
                        "lineThickness": 2,
                        "lineColor": "yellow",
                        "hideBulletsCount": 50
                    }, {
                        "id": "clicks",
                        "valueField": "clicks",
                        "lineThickness": 2,
                        "lineColor": "green",
                        "hideBulletsCount": 50
                    } ]
                } )
                setInterval( function() {
     
                  chart.dataProvider.shift();
                  var time = new Date();
                  var data = self.getTotals();
                  chart.dataProvider.push( {
                    "date": time,
                    "bid_requests": data.bid_requests,
                    "bids": data.bids,
                    "imps": data.imps,
                    "clicks": data.clicks
                  } );
                  chart.validateData();
                }, 5000 );
            },
            getNodes() {
                var listOfNodes = [];
                for (var n in this.stats.data) {
                    var x = this.stats.data[n].node;
                    if( listOfNodes.indexOf(x) < 0 ) listOfNodes += x  
                }
                return listOfNodes
            },
            getTotals() {
                var totalBR = 0;
                var totalBids = 0;
                var totalImps = 0;
                var totalClicks = 0;
                for (var n in this.stats.data) {
                    totalBR += this.stats.data[n].stats.bid_requests;
                    totalBids += this.stats.data[n].stats.bids; 
                    totalImps += this.stats.data[n].stats.imps; 
                    totalClicks += this.stats.data[n].stats.clicks; 
                }
                return {
                    "bid_requests" : totalBR,
                    "bids" : totalBids,
                    "imps" : totalImps,
                    "clicks" : totalClicks
                }
            },
            emptyData() {
                var emptyData = []
                var time = new Date();
                var data = 0;
                for (var i = 40; i >= 0; i--) {
                    var d = {
                        "date" : time - (i * 5000),
                        "bids": data
                    }
                    emptyData.push(d)
                }
                return emptyData
            },

            fetchBids() {
                var self = this;
                axios.get('http://45.76.95.115:2301/api/bids', this.$root.config).then( response => {
                    self.bids = response.data;
                }, error => {
                    console.log(error);
                });
            }
        },
        computed: {
            
        },
        watch: {
            token(value) {
                this.fetchCampaigns();
                this.fetchBids();
            }
        }
    }
</script>