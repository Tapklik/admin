<template>
    <div>
         <div class="row" style="padding-left: 16px; padding-right: 16px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-md-5">
                            Reporting
                        </div>
                        <div class="col-md-7" style="display: flex; align-items: center;">
                            <div class="dropdown" style="margin-right: 4px;">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Accounts
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <ul style="list-style-type: none; padding: 5px; margin: 0px;">
                                        <li v-for="account in list.accounts" :key="account.id">
                                            <input type="checkbox" :value="account.id" v-model="selected.accounts">
                                            {{account.id}} 
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown" style="margin-right: 4px;">
                                <button :disabled="disableCampaigns" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Campaigns
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <ul style="list-style-type: none; padding: 5px; margin: 0px;">
                                        <li v-for="campaign in filteredCampaigns()" :key="campaign.id">
                                            <input type="checkbox" :value="campaign.id" v-model="selected.campaigns">
                                            {{campaign.name}} 
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown" style="margin-right: 4px;">
                                <button :disabled="disableCreatives" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Creatives
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <ul style="list-style-type: none; padding: 5px; margin: 0px;">
                                        <li v-for="creative in list.creatives" :key="creative.id">
                                            <input type="checkbox" :value="creative.id" v-model="selected.creatives">
                                            {{creative.name}} 
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <select
                            style="margin-right: 4px;"
                            class="form-control"
                            id="label-approved"
                            v-model="selected.line_one"
                            >
                                <option v-for="stat in list.stats" :key="stat" :value="stat">{{stat}}</option>
                            </select>
                            <select
                            style="margin-right: 4px;"
                            class="form-control"
                            id="label-approved"
                            v-model="selected.line_two"
                            >
                                <option v-for="stat in list.stats" :key="stat" :value="stat">{{stat}}</option>
                            </select>
                            <select
                            style="margin-right: 4px;"
                            class="form-control"
                            id="label-approved"
                            v-model="selected.range"
                            >
                                <option v-for="r in list.range" :key="r" :value="r">{{`Last ${r} days`}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
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
                   creatives: [],
                   stats: ['imps', 'clicks', 'ecpc', 'ecpm', 'spend', 'ctr'],
                   range: [0, 1, 7, 15, 30]
               },
               selected: {
                   accounts: [],
                   campaigns: [],
                   creatives: [],
                   range: 0,
                   line_one: 'imps',
                   line_two: 'clicks'
               },
               chart_data: [],
               loading_chart: true
           }
        },

        computed: {
            selected_campaigns() {
                return this.selected.campaigns;
            },

            chartQuery() {
                var accounts = ''; 
                var campaigns = '';
                var creatives = ''; 
                if(this.selected.accounts.length > 0) accounts += 'acc=' + this.selected.accounts.join(',') + '&';
                if(this.selected.campaigns.length > 0) campaigns += 'cmp=' + this.selected.campaigns.join(',') + '&';
                if(this.selected.creatives.length > 0) creatives += 'cr=' + this.selected.creatives.join(',') + '&';
                return '/reports/overall?' + accounts + campaigns + creatives + 'from=' + this.getDate(0 - this.selected.range) + '%2000:00:00&to=' + this.getDate(0) + '%2023:59:59&fields=imps,clicks,spend,wins,win_price&scale=dd';
            },
            
            lines() {
                return [this.selected.line_one, this.selected.line_two];
            },
            
            disableCampaigns() {
                if(this.selected.accounts.length > 0) return false;
                else return true;
            },
            
            disableCreatives() {
                if(this.selected.campaigns.length > 0) return false;
                else return true;
            }
        },
        
        methods: {
            getLists() {
                this.getCampaigns();
                this.getAccounts();
            },

            getAccounts() {
                axios.get(
                    this.$root.api + '/accounts',
                    this.$root.config
                ).then(response => {
                        this.list.accounts = response.data.data;
                        this.selected.accounts = this.list.accounts.map(acc => acc.id);
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

            filteredCampaigns() {
                var result = [];
                var campaigns = this.list.campaigns;
                var selection = this.selected.accounts;
                var campaigns_by_acc_id = campaigns.map(cmp => cmp.account.data.id);
                for(var i = 0; i < selection.length; i++) {
                    var index = campaigns_by_acc_id.indexOf(selection[i]);
                    while (index != -1) {
                        result.push(campaigns[index]);
                        index = campaigns_by_acc_id.indexOf(selection[i], index + 1);
                    }
                }
                return result;
            },

            getCreatives() {
                this.list.creatives = [];
                var campaigns = this.selected.campaigns;
                for(var i = 0; i < campaigns.length; i++) {
                    var campaign_id = campaigns[i];
                    var index = this.list.campaigns.map(cmp => cmp.id).indexOf(campaign_id);
                    var campaign = this.list.campaigns[index];
                    for(var j = 0; j < campaign.creatives.data.length; j++) {
                        var creative = campaign.creatives.data[j];
                        this.list.creatives.push(creative);
                    }
                }
            },

            getChartData() {
                axios.get(
                    this.$root.api + this.chartQuery + '&op=sum', 
                    this.$root.config
                ).then(response => {
                        this.chart_data = response.data;
                        this.createLinesChart('chart', this.chart_data, this.lines);
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
            }
        },
        watch: {
            token(value) {
               this.getLists();
               this.getChartData();
            },
            
            chartQuery(value) {
                this.getChartData();
                if(this.selected.campaigns.length > 0) this.getCreatives();
            },
            
            lines(value) {
                this.createLinesChart('chart', this.chart_data, value)
            }
        }
    }
</script>