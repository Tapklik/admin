<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <h1 class="title pull-left">Reports</h1>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-3">
                <h4>Nodes</h4>
                <span v-for="n in nodes">
                    <input type="checkbox" :value="n" v-model="selectedNodes"> {{n}}<br>
                </span>
            </div>
            <div class="col-md-3">
                <h4>Selections</h4>
                Cmp: <span v-for="c in selectedCampaigns">{{c}}, </span> <br>
                Status: <span>{{check}}</span>
            </div>
            <div class="col-md-6">
                <div class="col-md-12 panel panel-default">
                    <h4>Total </h4>
                    <div id="chartdiv" style="height: 160px;"></div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <h4>Campaigns</h4>
                <button class="btn btn-default btn-sm" style="float:right;" @click="drawCharts()">Generate</button>
                <span v-for="c in campaigns">
                    <input type="checkbox" :value="c" v-model="selectedCampaigns"> {{c}}<br>
                </span>
            </div>
            <div class="col-md-9">
                <div class="col-md-6" v-for="(n, index) in something">  
                    <div class="col-md-12 panel panel-default">
                        <h4>{{n.cmp}} </h4>
                        <div :id="n.name" style="height: 160px;"></div>
                    </div>
                </div>
            </div>
        </div>
       
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
            this.createChartStats('chartdiv', this.emptyData(), 'all'); 

        },
        data() {
            return {
                allCampaigns: [],
                token: this.token,
                stats: [],     
                bids: [],
                loading: false,
                noresult: false,
                nodes: [],
                campaigns: [],
                selectedCampaigns: [],
                selectedNodes: [],
                check: true,
                numberOfGraphs: [],
                something: [],
            }
        },
        methods: {
            fetchAllCampaigns() {
                            
                axios.get(this.$root.api + 'campaigns', this.$root.config).then(response => {
                    this.allCampaigns = response.data;
                }, error => {
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
                var campaigns = this.selectedCampaigns;
                var nodes = this.selectedNodes;
                var self = this;
                var time = new Date()
                axios.get(this.$root.erlang_api + 'api/stats', this.$root.config).then( response => {
                    if(campaigns=='' || nodes == ''){
                        self.stats = response.data
                    }
                    else {
                        var count = 0;
                        var stats = response.data;
                        var realStats = [];
                        for(var s in stats) {
                            for(var c in campaigns) {
                                for(var n in nodes) {
                                    if(stats[s].node == nodes[n] && stats[s].cmp == campaigns[c]){
                                        count++;
                                    }
                                }
                            }
                            if (count > 0) {
                                realStats.push(stats[s])
                                count = 0;
                            }
                            else {
                                count = 0;
                            }
                        }
                        self.stats = realStats;
                    }
                
                }, 
                error => {
                    console.log(error);
                });
            },
            
            createChartStats(target, dataset, cmp) {
                console.log(target)
                var self = this; 
                var chart = [];
                chart[cmp] = AmCharts.makeChart( target, {
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
                    chart[cmp].dataProvider.shift();
                    var time = new Date();
                    var data = self.getTotals(cmp);
                    chart[cmp].dataProvider.push({
                        "date": time,
                        "bid_requests": data.bid_requests,
                        "bids": data.bids,
                        "imps": data.imps,
                        "clicks": data.clicks
                    });
                    chart[cmp].validateData();
                }, 5000 );
            },
            
            drawCharts() {
                var numbers = this.something;
                for(var n in numbers) {
                    this.createChartStats('chartdiv' + n, this.emptyData, n);
                }
            },

            getTotals(cmp) {
                var something = this.something;
                if(cmp == 'all') {
                    var totalBR = 0;
                    var totalBids = 0;
                    var totalImps = 0;
                    var totalClicks = 0;
                    for (var n in this.stats) {
                        totalBR += this.stats[n].stats.bid_requests;
                        totalBids += this.stats[n].stats.bids; 
                        totalImps += this.stats[n].stats.imps; 
                        totalClicks += this.stats[n].stats.clicks;
                    }

                    return {
                        "bid_requests" : totalBR,
                        "bids" : totalBids,
                        "imps" : totalImps,
                        "clicks" : totalClicks
                    }
                } else {
                    return something[cmp].stats
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
                axios.get(this.$root.erlang_api + 'api/bids', this.$root.config).then( response => {
                    self.bids = response.data;
                }, error => {
                    console.log(error);
                });
            },

            fetchNodes() {
                var nodesPackage = this.stats;
                var nodes = [];
                var duplicate = 0;
                var realNodes = [];
                for (var n in nodesPackage) {
                    nodes.push(nodesPackage[n].node);
                }
                realNodes.push(nodes[0]);
                for(var a in nodes) {
                    for(var b in nodes) {
                        if(nodes[a] == nodes[b]){
                            duplicate++;
                        }
                    }    
                    if(duplicate < 2 && a != 0){
                        realNodes.push(nodes[a]);
                        duplicate = 0;
                    }
                    else {
                        duplicate = 0;
                    }
                } 
                this.nodes = realNodes;
            },        

            fetchCampaigns() {
                var campaignsPackage = this.stats;
                var campaigns = [];
                var duplicate = 0;
                var realCampaigns = [];
                for (var n in campaignsPackage) {
                    campaigns.push(campaignsPackage[n].cmp);
                }
                realCampaigns.push(campaigns[0]);
                for(var a in campaigns) {
                    for(var b in campaigns) {
                        if(campaigns[a] == campaigns[b]){
                            duplicate++;
                        }
                    }    
                    if(duplicate < 2 && a != 0){
                        realCampaigns.push(campaigns[a]);
                        duplicate = 0;
                    }
                    else {
                        duplicate = 0;
                    }
                } 
                this.campaigns = realCampaigns;
            },

            largestArray() {
                var campaigns = this.selectedCampaigns; 
                var numbers = [];
                for(var c in campaigns) {
                    numbers.push('chartdiv'+c);
                }
                this.numberOfGraphs = numbers;
                
            },

            checkCombination() {
                var a = 0;
                var campaigns = this.selectedCampaigns;
                var nodes = this.selectedNodes;
                var object = this.stats; 
                for (var p in object) {
                    for(var n in nodes) {
                        for(var c in campaigns) {
                            if(object[p].node == nodes[n] && object[p].cmp == campaigns[c]){
                                a++;
                            }
                        }
                    }
                }

                if(a > 0) {
                    this.check = true;
                }
                
                else {
                    this.check = false;
                }
            },
            createObject() {
                var campaigns = this.selectedCampaigns;
                var stats = this.stats;
                var result = [];
                var a = [];
                for (var c in campaigns) {
                    for(var s in stats) {
                        if(stats[s].cmp == campaigns[c]) {
                            a = stats[s].stats
                        }
                    }
                    result.push({cmp: campaigns[c], stats: a, name: 'chartdiv'+c})
                }
                this.something = result;
            },


        },
        computed: {
            
        },
        watch: {
            token(value) {
                this.fetchBids();
            },

            
            stats(value) {
                this.fetchNodes();
                this.fetchCampaigns();
                this.fetchAllCampaigns();
                this.checkCombination();
                this.largestArray();
                this.createObject();

            },
        }
    }
</script>