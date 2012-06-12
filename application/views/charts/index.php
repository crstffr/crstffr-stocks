<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo URL::base()?>/">
    <meta charset="utf-8">
    <title>My Stock Charts : <?php echo ucfirst(URI::segment(2)); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-custom.css" rel="stylesheet">
    <link href="./assets/css/application.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="./assets/css/print.css" rel="stylesheet" media="print">


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="./assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">

    <!-- We let jQuery in at the top -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head>

<body>

<?php echo render('charts.navigation'); ?>

<div class="container-fluid">
    <div class="row-fluid">

        <div class="span12">
            <div class="row-fluid" id="charts"></div>
        </div>

    </div>
    <!--/row-->

    <footer>
        <p>Built with
            <a href="http://www.laravel.com" rel="external">Laravel</a> |
            <a href="http://twitter.github.com/bootstrap/" rel="external">Twitter Bootstrap</a> |
            <a href="https://developers.google.com/finance/" rel="external">Google Finance API</a> |
            <a href="http://www.highcharts.com/products/highstock" rel="external">Highstock</a> |
            <a href="http://handlebarsjs.com/" rel="external">Handlebars.js</a> |
            <a href="http://momentjs.com/" rel="external">Moment.js</a> |
            and <a href="https://github.com/crstffr/crstffr-stocks" rel="external">Available on Github</a>
        </p>
        <p>Created by <a href="http://www.crstffr.com" rel="external">Christopher Mason</a> in June 2012</p>
    </footer>

</div>
<!--/.fluid-container-->

<?php echo render('modals.add_symbol'); ?>
<?php echo render('modals.buy_symbol'); ?>
<?php echo render('modals.delete_symbol'); ?>
<?php echo render('modals.settings', array('zoom' => $zoom)); ?>

<!--
***********************************************************
Javascripts - Look at all of them.
*********************************************************** -->

<script src="./assets/js/handlebars-1.0.0.beta.6.js"></script>
<script src="./assets/js/moment.1.6.2.js"></script>
<script src="./assets/js/bootstrap/bootstrap-transition.js"></script>
<script src="./assets/js/bootstrap/bootstrap-alert.js"></script>
<script src="./assets/js/bootstrap/bootstrap-modal.js"></script>
<script src="./assets/js/bootstrap/bootstrap-dropdown.js"></script>
<script src="./assets/js/bootstrap/bootstrap-scrollspy.js"></script>
<script src="./assets/js/bootstrap/bootstrap-tab.js"></script>
<script src="./assets/js/bootstrap/bootstrap-tooltip.js"></script>
<script src="./assets/js/bootstrap/bootstrap-popover.js"></script>
<script src="./assets/js/bootstrap/bootstrap-button.js"></script>
<script src="./assets/js/bootstrap/bootstrap-collapse.js"></script>
<script src="./assets/js/bootstrap/bootstrap-carousel.js"></script>
<script src="./assets/js/bootstrap/bootstrap-typeahead-ajax.js"></script>
<script src="./assets/js/highstock/highstock.src.js"></script>
<script src="./assets/js/highstock/modules/exporting.js"></script>

<!--
***********************************************************
Javascript Chart Template
*********************************************************** -->

<script id="tmpl-chart" type="text/x-handlebars-template">
    <div class="chart-container">
        <h2>
            <a class="btn btn-icon btn-info no-print" data-toggle="collapse" data-target="#{{symbol}}-desc" href="#"><i class="icon-white icon-info-sign"></i></a> <a class="btn btn-icon btn-success buy-shares no-print" data-symbol="{{symbol}}" data-toggle="modal" href="#buyShares">$$</a> {{symbol}}: {{company}}
        </h2>

        <div id="{{symbol}}-desc" class="collapse chart-description">

            <p>{{description}}</p>

            <div class="btn-toolbar no-print">
                <div class="btn-group pull-left">
                    {{#if sites.company}}<a class="btn btn-mini" href='http://{{sites.company}}' target="_blank">Company Website</a>{{/if}}
                    <a class="btn btn-mini" href='https://www.google.com/finance?q={{symbol}}' target="_blank">Google Finance</a>
                    {{#if sites.wiki}}<a class="btn btn-mini" href='http://{{sites.wiki}}' target="_blank">Wikipedia</a>{{/if}}
                </div>
                <!--
                <div class="btn-group">
                    <a class="btn btn-mini" href='#'>Edit</a>
                </div>
                -->
                <div class="btn-group pull-right">
                    <a class="btn btn-mini btn-danger delete-symbol" data-symbol="{{symbol}}" data-toggle="modal" href='#deleteSymbol'>Delete</a>
                </div>
                <br>
                <br>
            </div>

        </div>

        <div class="row-fluid">

            {{#if trades}}
            <div class="span3 trades-well" id="{{symbol}}-trades">
                <div class="well">
                    <table class="table table-condensed table-no-border">
                        <thead><tr><th colspan="6">Purchases</th></tr></thead>
                        <tbody>
                            {{#each trades.buys}}
                            <tr>
                                <td>Buy</td>
                                <td>{{this.qty}}</td>
                                <td>x</td>
                                <td><strong>{{this.price}}</strong></td>
                                <td>=</td>
                                <td>{{this.total}}</td>
                            </tr>
                            {{/each}}
                            <tr>
                                <td colspan="4">Fees</td>
                                <td>+</td>
                                <td>{{trades.fees}}</td>
                            </tr>
                            <tr class="table-top-border">
                                <td></td>
                                <td>{{trades.shares}}</td>
                                <td colspan="3">shares for</td>
                                <td class="total">{{trades.total}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-condensed table-no-border">
                        <thead><tr><th colspan="6">Return</th></tr></thead>
                        <tbody>
                            <tr>
                                <td>Sell</td>
                                <td>{{trades.shares}}</td>
                                <td>x</td>
                                <td><strong>{{trades.thereturn.price}}</strong></td>
                                <td>=</td>
                                <td>{{trades.thereturn.subtotal}}</td>
                            </tr>
                            <tr>
                                <td>Fee</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>-</td>
                                <td>{{trades.thereturn.fee}}</td>
                            </tr>
                            <tr class="table-top-border">
                                <td class="total" colspan="6">{{trades.thereturn.total}}</td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                            <tr>
                                <td colspan="5">Difference</td>
                                <td class="total profit {{trades.profit_or_loss}}">{{trades.thereturn.diff}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{/if}}

            <div class="{{#if trades}}span9{{else}}span12{{/if}}">
                <div class="btn-group js-zoom-group zoom-group hide" id="zoom_{{symbol}}" data-toggle="buttons-radio">
                    <a class="btn btn-mini btn-zoom" data-unit="w" data-qty="2" href='#'>2w</a>
                    <a class="btn btn-mini btn-zoom" data-unit="M" data-qty="1" href='#'>1m</a>
                    <a class="btn btn-mini btn-zoom" data-unit="M" data-qty="3" href='#'>3m</a>
                    <a class="btn btn-mini btn-zoom" data-unit="M" data-qty="6" href='#'>6m</a>
                    <a class="btn btn-mini btn-zoom" data-unit="y" data-qty="1" href='#'>1y</a>
                    <a class="btn btn-mini btn-zoom" data-unit="y" data-qty="2" href='#'>2y</a>
                    <a class="btn btn-mini btn-zoom" data-unit="y" data-qty="3" href='#'>3y</a>
                    <a class="btn btn-mini btn-zoom" data-unit="y" data-qty="5" href='#'>5y</a>
                </div>
                <div class='chart' id='chart_{{symbol}}'></div>
            </div>
        </div>
    </div>
    <hr>
</script>

<!--
***********************************************************
Javascript Program Kickoff
*********************************************************** -->

<script>

Number.prototype.formatMoney = function(c, d, t){
var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "." : d, t = t == undefined ? "," : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c), 10) + "", j = (j = i.length) > 3 ? j % 3 : 0;
   return s + '$' + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

</script>

<script>

    $(function() {

        function setupAutoComplete() {

            var form = $("#addSymbol");
            var search = $(".autocomplete-symbol-search");
            var symbol = form.find("input[name='symbol']");
            var company = form.find("input[name='company']");
            var group = $(symbol).add(company);

            // Autocomplete search for symbol and company names

            search.typeahead({
                source:function (typeahead, query) {

                    query = $.trim(query);
                    if (query.length === 0) { return ''; }

                    $.ajax({
                        dataType : 'json',
                        url:"./symbol/name",
                        beforeSend: function(){
                            search.addClass('ajax-loading');
                        },
                        complete: function(){
                            search.removeClass('ajax-loading');
                        },
                        data: {query: query},
                        success:function (data) {
                            typeahead.process(data);
                        }
                    });

                },
                onselect: function(object) {
                    symbol.val(object.symbol);
                    company.val(object.company);
                    lookupCompanyInfo(object.company);
                },
                property: "full"
            });

        }

        function lookupCompanyInfo(company) {

            var form = $("#addSymbol");
            var site = form.find("input[name='sites[company]']");
            var wiki = form.find("input[name='sites[wiki]']");
            var desc = form.find("textarea[name='description']");
            var group = $(wiki).add(site).add(desc);

            $.ajax({
                dataType : 'json',
                url:"./symbol/companyinfo",
                data: {query: company},
                beforeSend:function() {
                    group.val('').addClass('ajax-loading');
                },
                complete:function(){
                    group.removeClass('ajax-loading');
                },
                success:function (data) {
                    wiki.val(data.wiki);
                    site.val(data.website);
                    desc.val(data.description);
                }
            });

        }

        setupAutoComplete();

        $("a[rel='external']").live('click', function(e){
            $(this).attr("target", "_blank");
        });

        $("a[href='#']").live('click', function(e){
            e.preventDefault();
        });

        $("a.buy-shares").live('click', function(){
            var symbol = $(this).data('symbol');
            $("#buyShares").find("input[name='symbol']").val(symbol);
        });

        $("a.delete-symbol").live('click', function(){
            var symbol = $(this).data('symbol');
            var modal = $("#deleteSymbol");
            modal.find(".js-symbol-input").val(symbol);
            modal.find(".js-symbol-text").text(symbol);
        });

        var TRADE_TYPE_BUY  = 'buy';
        var TRADE_TYPE_SELL = 'sell';

        var symbols     = <?php echo json_encode($symbols); ?>;
        var zoom        = '<?php echo $zoom; ?>';
        var charts      = [];

        for (i in symbols) {
            buildAndLoadChart(symbols[i]);
        }

        function bindZoomButtons(domElements, chartObj) {

            var btns = domElements.find(".js-zoom-group .btn-zoom");

            btns.click(function(){

                var max = chartObj.xAxis[0].getExtremes().dataMax;
                var unit = $(this).data('unit');
                var qty = $(this).data('qty');
                var min = moment(max).subtract(unit, qty).valueOf();
                chartObj.xAxis[0].setExtremes(min, max, true, false);

            });

            if (zoom.length > 0) {
                btns.filter(":contains(" + zoom + ")").click();
            }

        }

        function buildChartTemplateData(data) {

            var total_shares,
                return_subtotal,
                return_total,
                return_diff,
                return_fee,
                last_price,
                total_price,
                trade_price,
                total_fees,
                buy_price,
                buy_fees,
                last_fee,
                buy_qty,
                trade;

            var out = {
                sites:          data.sites,
                symbol:         data.symbol,
                company:        data.company,
                description:    data.description,
                trades:         false
            };

            var has_trades = typeof(data.trades) != "undefined";
            if (has_trades && data.trades.length > 0) {

                var last_price = data.last_price.price;

                out.trades = {
                    buys:               [],
                    fees:               0,
                    total:              0,
                    shares:             0,
                    profit_or_loss:     '',
                    thereturn: {
                        price:          last_price.formatMoney(2),
                        subtotal:       0,
                        fee:            0,
                        total:          0,
                        diff:           0
                    }
                };

                total_fees = 0;
                total_price = 0;
                total_shares = 0;

                for (i in data.trades) {

                    trade = data.trades[i];

                    if (trade.type === TRADE_TYPE_BUY) {

                        trade.fees = (trade.fees.length > 0) ? trade.fees : 0;

                        buy_qty = parseInt(trade.quantity, 10);
                        buy_fees = parseFloat(trade.fees);
                        buy_price = parseFloat(trade.price);
                        trade_price = (buy_qty * buy_price);

                        total_fees += buy_fees;
                        total_shares += buy_qty;
                        total_price += trade_price;
                        last_fee = buy_fees;

                        out.trades.buys.push({
                            qty:    buy_qty,
                            price:  buy_price.formatMoney(2),
                            total:  trade_price.formatMoney(2)
                        });

                    }

                }

                return_subtotal = total_shares * last_price;
                return_total = return_subtotal - last_fee;
                return_diff = return_total - total_price;

                out.trades.thereturn.subtotal = return_subtotal.formatMoney(2);
                out.trades.thereturn.total = return_total.formatMoney(2);
                out.trades.thereturn.fee = last_fee.formatMoney(2);
                out.trades.thereturn.diff = return_diff.formatMoney(2);

                out.trades.fees = total_fees.formatMoney(2);
                out.trades.total = total_price.formatMoney(2);
                out.trades.shares = total_shares;

                out.trades.profit_or_loss = (return_diff > 0) ? "profit" : "loss";

            }

            return out;

        }


        function buildAndLoadChart(symdata) {

            var sym = symdata.symbol;
            var tmplsrc = $("#tmpl-chart").html();
            var tmplobj = Handlebars.compile(tmplsrc);
            var tmpldata = buildChartTemplateData(symdata);
            var tmplhtml = tmplobj(tmpldata);
            var chart = $(tmplhtml).appendTo("#charts");
            chart.data('symbol-data', symdata);

            $.ajax({
                dataType : 'json',
                url:"./symbol/history",
                data: {query: sym},
                success:function (data) {

                    var id = 'chart_' + sym;
                    var options = {
                        chart : {
                            animation: true,
                            renderTo : id,
                            events: {
                                load: function() {
                                    chart.find(".js-zoom-group").show();
                                    bindZoomButtons(chart, this);
                                }
                            }
                        },
                        zoomSelector: {
                            enabled: false
                        },
                        rangeSelector : {
                            selected : 4 // 0 is 1 month, 5 is ALL
                        },
                        scrollbar: {
                            enabled: true
                        },
                        exporting: {
                            enabled: false
                        },
                        tooltip: {
                            // enabled: false
                        },
                        colors: [
                            '#4572A7',
                            '#00CC00'
                        ],
                        series : [{
                            name : sym,
                            data : data,
                            id: sym,
                            tooltip: {
                                valueDecimals: 2
                            }
                        }]
                    };

                    var has_trades = typeof(symdata.trades) != "undefined";
                    if (has_trades && symdata.trades.length > 0) {

                        for (i in symdata.trades) {

                            var trade = symdata.trades[i];

                            switch (trade.type) {

                                case TRADE_TYPE_BUY:

                                    // Want to create data points that match the historical
                                    // data from the main price series.  Each data point
                                    // has the timestamp for 7:00pm EST.

                                    var buy_price = parseFloat(trade.price);
                                    var buy_start = moment(trade.date).hours(19);
                                    var buy_end = moment(data[data.length-1][0]);
                                    var buy_day = buy_start.clone();
                                    var buy_data = [];

                                    while(buy_day.valueOf() <= buy_end.valueOf()) {
                                        // skip saturday & sunday plot points
                                        if (buy_day.day() != 5 && buy_day.day() != 6) {
                                            buy_data.push([buy_day.valueOf(), buy_price]);
                                        }
                                        buy_day.add('days', 1);
                                    }

                                    options.series.push({
                                        name : 'BUY',
                                        data : buy_data,
                                        id: 'buy_' + i,
                                        tooltip: {
                                            valueDecimals: 2
                                        }
                                    });

                                    options.series.push({
                                        type: 'flags',
                                        data: [{
                                            x : buy_start.valueOf(),
                                            title: 'B',
                                            text: trade.quantity + ' shares at $' + trade.price
                                        }],
                                        color: '#00CC00',
                                        onSeries : 'buy_' + i,
                                        shape : 'circlepin',
                                        width : 16
                                    });

                                    break;

                                case TRADE_TYPE_SELL:

                                    break;
                            }

                        }

                    }

                    charts[sym] = new Highcharts.StockChart(options);

                }
            });

        }

    });
</script>

</body>
</html>
