<template>
    <div>
        <hr />
        <div class="row">
            <div class="col-xs-12">
                CHARTS
            </div>
        </div>
        <hr />
        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">Real-Time Graph</div>
                <div class="panel-body">
                    <div id="real-time-chart" style="height: 240px;"></div>
                </div>
            </div>
        </div>
        
        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">Last 10 days</div>
                <div class="panel-body">
                    <div id="first-chart" class="col-xs-6" style="height: 240px"></div>
                    <div id="second-chart" class="col-xs-6" style="height: 240px"></div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">Summary</div>
                <div class="panel-body">
                    <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column; margin-bottom: 24px;" v-for="data in list.data_names">
                        <h4>{{data}}</h4>
                        <span>{{chart_summary[data]}}</span>
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="col-xs-12">
                TABLES
            </div>
        </div>        
        <hr />
        <div class="row">
            
            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Accounts</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Acc. Name</th>
                                    <th>Acc. Id</th>
                                </tr>
                            </thead>
                            <tbody class="vcenter">
                                
                                <!-- TABLE LOADER START -->
                                <tr v-if="accounts.loading">
                                    <td colspan="11" class="loader text-center">
                                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                    </td>
                                </tr>
                                <!-- TABLE LOADER END -->
                                
                                <!-- EMPTY TABLE MESSAGE START -->
                                <tr v-else-if="accounts.empty">
                                    <td colspan="11">
                                        There are no accounts
                                    </td>
                                </tr>
                                <!-- EMPTY TABLE MESSAGE END -->
                                
                                <tr v-else v-for="account in list.accounts" @click="onButtonClickListener(account ,$event)">
                                    <td>
                                        <a :href="'/accounts/' + account.id">
                                            {{ account.name }}
                                        </a>
                                    </td>
                                    <td>{{ account.id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Campaigns</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Camp. Name</th>
                                    <th>Camp. Id</th>
                                </tr>
                            </thead>
                            <tbody class="vcenter">
                                
                                <!-- TABLE LOADER START -->
                                <tr v-if="campaigns.loading">
                                    <td colspan="11" class="loader text-center">
                                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                                    </td>
                                </tr>
                                <!-- TABLE LOADER END -->
                                
                                <!-- EMPTY TABLE MESSAGE START -->
                                <tr v-else-if="campaigns.empty">
                                    <td colspan="11">
                                        There are no campaigns
                                    </td>
                                </tr>
                                <!-- EMPTY TABLE MESSAGE END -->
                                
                                <tr v-else v-for="campaign in list.campaigns">
                                    <td>
                                        <a :href="'/accounts/' + campaign.account.data.id + '/campaigns/' + campaign.id">
                                            {{ campaign.name }}
                                        </a>
                                    </td>
                                    <td>{{ campaign.id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                token: '',
                list: {
                    accounts: [],
                    campaigns: [],
                    statuses: ['active', 'paused', 'archived', 'draft', 'not started', 'expired'],
                    data_names: ['clicks', 'imps', 'spend', 'ctr', 'ecpc', 'ecpm', 'wins', 'win_price', 'profit', 'win_perc'] 
                },
                accounts: {
                    loading: true,
                    empty: false
                },
                campaigns: {
                    loading: true,
                    empty: false
                },
                chart_data: [],
                chart_summary: {}
            }
        },

        computed: {
            chartQuery() {
                return '/reports/overall?acc=' + this.list.accounts.map(acc => acc.id).join(',') + '&from=' + this.getDate(-10) + '%2000:00:00&to=' + this.getDate(0) + '%2023:59:59&fields=imps,clicks,spend,wins,win_price&scale=dd'
            }
        },

        methods: {
            getLists() {
                this.getAccounts();
                this.getCampaigns();
            },

            getAccounts() {
                axios.get(
                    this.$root.api + '/accounts',
                    this.$root.config
                ).then(response => {
                        this.list.accounts = response.data.data;
                        this.accounts.empty = this.list.accounts.length > 0 ? false : true;
                        this.accounts.loading = false;
                    }, error => {

                    }
                );
            },
            
            getCampaigns() {
                axios.get(
                    this.$root.api + '/campaigns?include=account', 
                    this.$root.config
                ).then(response => {
                        this.list.campaigns = response.data.data;
                        this.campaigns.empty = this.list.campaigns.length > 0 ? false : true;
                        this.campaigns.loading = false; 
                    }, error => {

                    }
                );
            },

            getDate(days) {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                let today =  new Date();
                let date = new Date();
                date.setDate(today.getDate() + days);
                let year = date.getFullYear();
                let month = toTwoDigits(date.getMonth() + 1);
                let day = toTwoDigits(date.getDate()); 
                return `${year}-${month}-${day}`;
            },

            addFields(dataset) {
                for(var i = 0; i < dataset.length; i++) {
                    var data = dataset[i];
                    data.spend = this.$root.fromMicroDollars(data.spend).toFixed(2);
                    data.win_price = this.$root.fromMicroDollars(data.win_price).toFixed(2);
                    data.ctr = data.imps != 0 ? (data.clicks / data.imps).toFixed(2) : "0";
                    data.ecpc = data.clicks != 0 ? (data.spend / data.clicks).toFixed(2) : "0";
                    data.ecpm = data.imps != 0 ? (data.spend / data.imps * 1000).toFixed(2) : "0";
                    data.win_perc = data.imps != 0 ? (data.wins / data.imps).toFixed(2) : "0";
                    data.profit = data.win_price != 0 ? (data.spend / data.win_price).toFixed(2) : "0";
                }
                return dataset;
            },

            getChartData() {
                axios.get(
                    this.$root.api + this.chartQuery + '&op=sum', 
                    this.$root.config
                ).then(response => {
                        this.chart_data = this.addFields(response.data);
                        this.createLinesChart('first-chart', this.chart_data, ['imps', 'clicks', 'wins']);
                        this.createLinesChart('second-chart', this.chart_data, ['spend', 'win_price']);
                    }, error => {

                    }
                );
            },

            getChartSummary() {
                axios.get(
                    this.$root.api + this.chartQuery + '&op=summary', 
                    this.$root.config
                ).then(response => {
                        this.chart_summary = this.addFields(response.data)[0];
                    }, error => {

                    }
                );
            },

            createLinesChart(target, dataset, lines) {
                var obj = this;
                var colors = ["#ff0000", "#000000", "#0000ff"];
                var graphs = [];
                var balloonText = "[[time]] <br> " + lines.reduce((html, current) => html + "<br>" + current.charAt(0).toUpperCase() + current.slice(1) + " : [[" + current + "]]", "");
                for(var i = 0; i < lines.length; i++) {
                    var line = lines[i];
                    var payload = {
                        "valueAxis": "v" + (i + 1),
                        "id": "g" + (i + 1),
                        "type" : "line",
                        "lineColor": colors[i],
                        "fillColors": colors[i],
                        "balloonText": balloonText,
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": line.charAt(0).toUpperCase() + line.slice(1),
                        "valueField": line
                    }
                    graphs.push(payload);
                }
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 40,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "graphs": graphs,
                    "categoryField": "time",
                    "categoryAxis": {
                        "parseDates": true,
                        "dashLength": 0,
                        "axisAlpha": 0.1,
                        "gridAlpha": 0,
                        "minPeriod": "hh",
                        "minorGridEnabled": false
                    },
                    "balloon": {
                        "borderColor": "#222",
                        "borderAlpha": 0,
                        "borderThickness": 0,
                        "shadowAlpha": 0,
                        "color": "#ffffff",
                        "drop": false,
                        "cornerRadius": 5,
                        "fillColor": "#222",
                        "fillAlpha": 1,
                    },
                    "chartCursor": {
                        "categoryBalloonDateFormat": "DD MM",
                        "cursorAlpha": 0.1,
                        "cursorColor":"#000000",
                        "fullWidth":true,
                        "valueBalloonsEnabled": false,
                        "zoomable": false
                    },
                    "legend": {
                        "useGraphSettings": true
                    },
                    "export": {
                        "enabled": true
                    },
                    "dataProvider": dataset, // Here you need to add the dataset
                });

                chart.addListener("rendered", removeLogo);

                function removeLogo() {
                    $('.amcharts-chart-div').find('a').each(function(index, item) {
                        $(item).hide();
                    });
                }
            },
        },

        watch: {
            token(value) {
                this.getLists();
            },
            chartQuery(value) {
                this.getChartData();
                this.getChartSummary();
            }
        }
    }
</script>