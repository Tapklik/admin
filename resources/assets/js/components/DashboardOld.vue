<template>
	<div>

        <!-- HEADER START -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="title">Dashboard</h1>
            </div>
        </div>
        <!-- HEADER END -->

        <hr />

        <div class="row">
            <div class="col-xs-12">
                NEW CHARTS
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div id="new-chart" style="height: 300px;"></div>
            </div>
            <div class="col-xs-12">
                <div id="new-chart-2" style="height: 300px;"></div>
            </div>
        </div>
        <div class="row" style="display: flex; flex-direction: row;">
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Imps</h4>
                <span>{{new_chart_summary[0].imps}}</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Clicks</h4>
                <span>{{new_chart_summary[0].clicks}}</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Spend</h4>
                <span>{{new_chart_summary[0].spend}} $</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Wins</h4>
                <span>{{new_chart_summary[0].wins}}</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Win Price</h4>
                <span>{{new_chart_summary[0].win_price}} $</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Ctr</h4>
                <span>{{new_chart_summary[0].ctr}}%</span>
            </div>
        </div>
        <div class="row" style="display: flex; flex-direction: row; margin-top: 48px;">
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Win Percentage</h4>
                <span>{{new_chart_summary[0].win_perc}}%</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>Profit</h4>
                <span>{{new_chart_summary[0].profit}} $</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>eCpc</h4>
                <span>{{new_chart_summary[0].ecpc}} $</span>
            </div>
            <div class="col-xs-2" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <h4>eCpm</h4>
                <span>{{new_chart_summary[0].ecpm}} $</span>
            </div>
        </div>

        <hr />

        <!-- CHARTS START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Charts</h2>
            </div>
        </div>
        <div class="row">
            <h3 class="col-md-12">Last 10 days</h3>
            <div class="col-md-12">
                <div id="ten-chart" style="height: 300px"></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="ten-spend-chart" style="height: 300px"></div>
                </div>
                <div class="col-md-6">
                    <div id="ten-spend-stats">
                        <ul>
                            <li v-for="stat in ten_summary">
                                {{stat}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">    
            <h3 class="col-md-12">Yesterday</h3>
            <div class="col-md-12">
                <div id="yesterday-chart" style="height: 300px"></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="yes-spend-chart" style="height: 300px"></div>
                </div>
                <div class="col-md-6">
                    <div id="yes-spend-stats">
                        <ul>
                            <li v-for="stat in yes_summary">
                                {{stat}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- CHARTS END -->

        <hr />

        <!-- ACCOUNTS START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Accounts</h2>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Acc. Name</th>
                    <th>Acc. Id</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="vcenter">
                
                <!-- TABLE LOADER START -->
                <tr v-if="accounts_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->
                
                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-else-if="accounts_table_empty">
                    <td colspan="11">
                        Sorry but I can't find anything relating to <strong>{{ search_accounts }}</strong>
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->
                
                <tr v-else v-for="account in accounts">
                    <td>
                        <a :href="'/accounts/' + account.id">
                            {{ account.name }}
                        </a>
                    </td>
                    <td>{{ account.id }}</td>
                    <td>
                        <button 
                        id="toggle"
                        :ref="account.id"
                        class="btn" 
                        :class="account.status ? 'btn-success' : 'btn-danger'" 
                        @click="toggleAccountStatus(account.status, account.id)" 
                        >
                            <i class="fa fa-check-circle-o"></i>
                        </button>
                    </td>
                    <td>
                        <button class="btn">
                            <i class="fa fa-cog"></i>
                        </button>
                        <button 
                        id="delete" 
                        :ref="account.id" 
                        class="btn btn-danger" 
                        @click="deleteAccount(account.id)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>                    
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- ACCOUNTS END -->

        <hr />

		<!-- CAMPAIGNS START -->
        <div class="row">
            <div class="col-xs-12">
                <h2>Campaigns</h2>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Adomain</th>
                    <th>CTR URL</th>
                    <th>Budget</th>
                    <th>Daily</th>
                    <th>Creatives</th>
                    <th>JSON</th>
                    <th>Status</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody class="vcenter">

                <!-- TABLE LOADER START -->
                <tr v-show="campaigns_table_loading">
                    <td colspan="11" class="loader text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    </td>
                </tr>
                <!-- TABLE LOADER END -->
                
                <!-- EMPTY TABLE MESSAGE START -->
                <tr v-show="campaigns_table_empty">
                    <td colspan="11">
                        Sorry but theres nothing here... yet :)
                    </td>
                </tr>
                <!-- EMPTY TABLE MESSAGE END -->

                <tr v-for="campaign in campaigns">
                    <td>{{ campaign.id }}</td>
                    <td>
                        <a :href="'/accounts/' + campaign.account.data.id + '/campaigns/' + campaign.id">
                            {{ campaign.name }}
                        </a>
                    </td>
                    <td>{{ campaign.start_time }}</td>
                    <td>{{ campaign.end_time }}</td>
                    <td>
                        <a :href="'http://' + campaign.adomain" target="_blank">
                            {{ campaign.adomain }}
                        </a>
                    </td>
                    <td>
                        <a :href="campaign.ctrurl" target="_blank">
                            {{ campaign.ctrurl }}
                        </a>
                    </td>
                    <td>${{ $root.fromMicroDollars(campaign.budget.data.amount) }}</td>
                    <td>${{ $root.fromMicroDollars(campaign.bid) }}</td>
                    <td>
                        <a 
                        :href="'/accounts/' + account_id + '/campaigns/' + campaign.id + '/creatives'" 
                        class="btn btn-primary"
                        >
                            View
                        </a>
                    </td>
                    <td>
                        <a 
                        @click="openModal('#_modal-show-json', campaign)" 
                        class="btn btn-primary" 
                        target="_blank"
                        >
                            View
                        </a>
                    </td>
                    <td>
                        <select  
                        @change="toggleCampaignStatus(campaign.id, campaign.status)" 
                        v-model="campaign.status">
                            <option v-for="status in statuses" :value="status">{{ status }}</option>
                        </select>
                    </td>
                    <td>
                        <button 
                        id="delete"
                        :ref="campaign.id"
                        :disabled="campaign.status != 'draft'"  
                        class="btn btn-danger" 
                        @click="deleteCampaign(campaign.id)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- CAMPAIGNS END -->

        <!-- MODALS START -->
        <!-- CAMPAIGN JSON MODAL START-->
        <div class="modal fade" id="_modal-show-json" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">JSON</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{opened_json}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                        type="button" 
                        class="btn btn-default" 
                        data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="createNewUser()"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- CAMPAIGN JSON MODAL END--> 
        <!-- MODALS END -->

	</div>
</template>

<script>
	export default {
        data() {
            return {
                //ESSENTIALS
                token: '',

                //CHARTS
                ten_summary: [],
                yes: [],
                line: 'imps',
                column: 'clicks',

                //CAMPAIGNS
                campaigns: [],
                opened_json: {},
                campaigns_table_loading: true,
                campaigns_table_empty: false,
                statuses: ['active', 'paused', 'archived', 'draft', 'not started', 'expired'],

                //ACCOUNTS
                accounts: [],
                accounts_table_loading: true,
                accounts_table_empty: false,
                new_chart_data: [],
                new_chart_summary: []
            }
        },

        methods: {

            //OVERALL        
            buttonLoading(action, condition, id) {
                for(var button in this.$refs[id]) {
                    var targetted_button = this.$refs[id][button].id == action ? button : targetted_button;
                }
                condition ? this.$refs[id][targetted_button].children[0].className = 'fa fa-circle-o-notch fa-spin' : 
                            this.$refs[id][targetted_button].children[0].className = 'fa fa-check-circle-o';
            },

            openModal(identifier, json) {
                this.opened_json = json ? json : '';
                $(identifier).modal();
            },

            filterDataSize(number_of_items, dataset) {
            	var excess = dataset.length - number_of_items; //look for number of items that are more than required
            	if(excess > 0) dataset.splice(number_of_items, excess); //delete those items
            	return dataset;
            },

            //CHARTS
            newCharts() {
                axios.get(
                    this.$root.api + 'reports/overall?acc=' + this.accounts.map(acc => acc.id).join(',') + '&from=' + this.getDate(-10) + '%2000:00:00&to=' + this.getDate(0) + '%2023:59:59&fields=imps,clicks,spend,wins,win_price&op=sum&scale=dd', 
                    this.$root.config
                ).then(response => {
                    this.new_chart_data = response.data;
                    for(var i = 0; i < this.new_chart_data.length; i++) {
                        var data = this.new_chart_data[i];
                        data.spend = this.$root.fromMicroDollars(data.spend).toFixed(2);
                        data.win_price = this.$root.fromMicroDollars(data.win_price).toFixed(2);
                    }
                    this.createFirstNewChart('new-chart', this.new_chart_data);
                    this.createSecondNewChart('new-chart-2', this.new_chart_data);
                    }, error => {

                    }
                );
            },

            newChartsSummary() {
                axios.get(
                    this.$root.api + 'reports/overall?acc=' + this.accounts.map(acc => acc.id).join(',') + '&from=' + this.getDate(-10) + '%2000:00:00&to=' + this.getDate(0) + '%2023:59:59&fields=imps,clicks,spend,wins,win_price&op=summary&scale=dd', 
                    this.$root.config
                ).then(response => {
                    this.new_chart_summary = response.data;
                    for(var i = 0; i < this.new_chart_summary.length; i++) {
                        var data = this.new_chart_summary[i];
                        data.spend = this.$root.fromMicroDollars(data.spend).toFixed(2);
                        data.win_price = this.$root.fromMicroDollars(data.win_price).toFixed(2);
                        data.ctr = (data.clicks / data.imps).toFixed(2);
                        data.ecpc = (data.spend / data.clicks).toFixed(2);
                        data.ecpm = (data.spend / data.imps * 1000).toFixed(2);
                        data.win_perc = (data.wins / data.imps).toFixed(2);
                        data.profit = (data.spend / data.win_price).toFixed(2);
                    }
                    }, error => {

                    }
                );
            },

            createFirstNewChart(target, dataset) {
                var obj = this;
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 40,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "line",
                        "lineColor":"#ff0000",
                        "fillColors":"#ff0000",
                        "balloonText": "[[time]] <br> <br> Imps :[[imps]]<br> Clicks: [[clicks]]<br> Wins: [[wins]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": "Imps",
                        "valueField": "imps"
                    },
                    {
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "line",
                        "lineColor":"#000000",
                        "fillColors":"#000000",
                        "fillAlphas": 0,
                        "balloonText": "[[time]] <br> <br> Imps :[[imps]]<br> Clicks: [[clicks]]<br> Wins: [[wins]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": "Clicks",
                        "valueField": "clicks"
                        
                    },
                    {
                        "valueAxis": "v3",
                        "id": "g3",
                        "type" : "line",
                        "lineColor":"#0000ff",
                        "fillColors":"#0000ff",
                        "fillAlphas": 0,
                        "balloonText": "[[time]] <br> <br> Imps :[[imps]]<br> Clicks: [[clicks]]<br> Wins: [[wins]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": "Wins",
                        "valueField": "wins"
                    }],
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

            createSecondNewChart(target, dataset) {
                var obj = this;
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 40,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "valueAxes": [{
                        "id": "v1",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "title": "Spend"
                    },
                    {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "title": "Win Price"
                    }
                    ],
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "line",
                        "lineColor":"#ff0000",
                        "fillColors":"#ff0000",
                        "balloonText": "[[time]] <br> <br> Spend :[[spend]]<br> Win Price: [[win_price]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": "Spend",
                        "valueField": "spend"
                    },
                    {
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "line",
                        "lineColor":"#000000",
                        "fillColors":"#000000",
                        "fillAlphas": 0,
                        "balloonText": "[[time]] <br> <br> Spend :[[spend]]<br> Win Price: [[win_price]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": "Win Price",
                        "valueField": "win_price"
                        
                    }],
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

            createChart(target, dataset, column, line) {
                var obj = this;
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 40,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "valueAxes": [{
                        "id": "v1",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "title": column.charAt(0).toUpperCase() + column.slice(1)
                    },
                    {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "title": line.charAt(0).toUpperCase() + line.slice(1)
                    }
                    ],
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "column",
                        "fixedColumnWidth": 40,
                        "fillAlphas": 1,
                        "fillColors":"#78909c",
                        "lineThickness": 0,
                        "balloonText": "[[time]] <br> <br>"+column+" :[["+column+"]]<br>"+line+": [["+line+"]]",
                        "title": column.charAt(0).toUpperCase() + column.slice(1),
                        "valueField": column
                    },
                    {
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "line",
                        "lineColor":"#f76c06",
                        "fillColors":"#f76c06",
                        "fillAlphas": 0,
                        "balloonText": "[[time]] <br> <br>" + column + " :[["+column+"]]<br>"+line+": [["+line+"]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": line.charAt(0).toUpperCase() + line.slice(1),
                        "valueField": line
                        
                    }],
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

            createSpendChart(target, dataset, line) {
                var obj = this;
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 40,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "valueAxes": [
                    {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "title": line.charAt(0).toUpperCase() + line.slice(1)
                    }
                    ],
                    "graphs": [
                    {   
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "line",
                        "lineColor":"#f76c06",
                        "fillColors":"#f76c06",
                        "fillAlphas": 0,
                        "balloonText": "[[date]] <br> <br> "+line+": [["+line+"]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": line.charAt(0).toUpperCase() + line.slice(1),
                        "valueField": line
                        
                    }],
                    "categoryField": "date",
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
            
            stringifyAllAccounts() {
                return this.accounts.map(account => account.id);
            },

            getChartData(canvas, spend_canvas, days) {
                axios.get(
                    this.$root.reportApi + '?table=wins&acc=' + this.stringifyAllAccounts() + 'd&field=clicks,imps,spend&op=sum&from=' + this.getDate(days) + '%2000:00:00&to=' + this.getDate(0) + '%2023:59:59'
                ).then(response => {
                        var chart_data = response.data.data;
                        this.createChart(canvas, chart_data, this.column, this.line);
                        this.createSpendChart(spend_canvas, chart_data, 'spend');
                    }, error => {

                    }
                );
            },

            getTenChartSummary() {
                axios.get(
                    this.$root.reportApi + '?table=wins&acc=' + this.stringifyAllAccounts() + 'd&field=clicks,imps,spend&op=summary&from=' + this.getDate(-10) + '%2000:00:00&to=' + this.getDate(0) + '%2023:59:59'
                ).then(response => {
                        console.log(response.data.data);
                        var summary = response.data.data;
                        var keys = Object.keys(summary);
                        var result = keys.map(key => key + ': ' + summary[key]);
                        this.ten_summary = result;
                    }, error => {

                    }
                );
            },

            getYesChartSummary() {
                axios.get(
                    this.$root.reportApi + '?table=wins&acc=' + this.stringifyAllAccounts() + 'd&field=clicks,imps,spend&op=summary&from=' + this.getDate(-1) + '%2000:00:00&to=' + this.getDate(0) + '%2023:59:59'
                ).then(response => {
                        console.log(response.data.data);
                        var summary = response.data.data;
                        var keys = Object.keys(summary);
                        var result = keys.map(key => key + ': ' + summary[key]);
                        this.yes_summary = result;
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

            //ACCOUNTS
            getAccounts(id) {
                axios.get(
                    this.$root.api + 'accounts',
                    this.$root.config
                ).then(response => {
                        this.accounts_table_empty = response.data.data == '' ? true : false;
                        this.accounts = this.filterDataSize(10, response.data.data);
                        this.accounts_table_loading = false;
                        if(id) this.buttonLoading("delete", false, id);
                    }, error => {
                        this.accounts_table_loading = false;
                    }
                );
            },

            toggleAccountStatus(status ,id) {
                var status = status ? 0 : 1;
                this.buttonLoading('toggle', true, id);

                axios.put(
                    this.$root.api + 'accounts/' + id,
                    { status: status },
                    this.$root.config
                ).then(reponse => {
                        this.getAccounts(id);
                    }, error => {
                        this.getAccounts(id);
                    }
                );
            },

            deleteAccount(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'accounts/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getAccounts(id);
                    }, error => {
                        this.getAccounts(id);
                    }
                );
            },

            //CAMPAIGNS
            getCampaigns(id) {
                axios.get(
                    this.$root.api + 'campaigns?include=account', 
                    this.$root.config
                ).then(response => {
                        this.campaigns_table_empty = response.data.data == '' ? true : false;
                        this.campaigns = this.filterDataSize(10, response.data.data);
                        this.campaigns_table_loading = false;
                        if(id) this.buttonLoading('delete', false, id);
                    }, error => {
                        this.campaigns_table_loading = false;
                    }
                );
            },

            deleteCampaign(id) {
                this.buttonLoading('delete', true, id);

                axios.delete(
                    this.$root.api + 'campaigns/' + id, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns(id);        
                    }, error => {
                        this.getCampaigns(id);
                    }
                );
            },

            toggleCampaignStatus(id, status) {
                axios.put(
                    this.$root.api + 'campaigns/' + id, 
                    {status: status}, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns();
                    }, error => {
                        this.getCampaigns();
                    }
                );
            }
        },

        watch: {
            token(value) {
        		this.getCampaigns();
        		this.getAccounts();
            },
            accounts(value) {
                this.getChartData('ten-chart', 'ten-spend-chart',-10);
                this.getChartData('yesterday-chart', 'yes-spend-chart',-1);
                this.newCharts();
                this.newChartsSummary();
                this.getTenChartSummary();
                this.getYesChartSummary();
            }
        }
    }
</script>