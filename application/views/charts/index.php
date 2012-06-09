<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo URL::base()?>/">
    <meta charset="utf-8">
    <title>My Stock Charts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }

        .sidebar-nav {
            padding: 9px 0;
        }

        .chart {
            margin-top: 20px;
            width: 100%;
            height: 350px;
        }

        .highcharts-input-container {
            display: none;
        }
    </style>
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">

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
</head>

<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <!--
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            -->
            <a class="brand" href="./">My Stock Charts</a>

            <!--
            <div class="btn-group pull-right">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-cog"></i> Options
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="icon-plus"></i> Add New Symbol</a></li>
                </ul>
            </div>
            -->

            <a class="btn pull-right" data-toggle="modal" href="#addSymbol">
                <i class="icon-plus"></i> Add New Symbol
            </a>

            <!--
            <div class="nav-collapse">
              <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
            </div>
            -->

        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">

        <!--
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Sidebar</li>
              <li class="active"><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div>
        </div>
        -->

        <div class="span12">
            <div class="row-fluid" id="charts"></div>
        </div>

    </div>
    <!--/row-->

    <footer>
        <p>&copy; Christopher Mason 2012</p>
    </footer>

</div>
<!--/.fluid-container-->

<!--
***********************************************************
Modal Form - Add Symbol
*********************************************************** -->

<div class="modal hide" id="addSymbol">
    <form class="modal-form form-horizontal" action="<?php echo URL::current(); ?>/add" method="POST">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Add a Symbol to Watch</h3>
        </div>
        <div class="modal-body">

            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="input01">Symbol</label>

                    <div class="controls">
                        <input name="symbol" type="text" class="input-small" id="input01">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input02">Company Name</label>

                    <div class="controls">
                        <input name="company" type="text" id="input02">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <textarea name="description" class="input-xlarge" rows="4"></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input04">Website</label>

                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">http://</span><input name="sites[company]" class="input-xlarge" type="text" id="input03">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input04">Wiki Page</label>

                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">http://</span><input name="sites[wiki]" class="input-xlarge" type="text" id="input04">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </form>
</div>

<!--
***********************************************************
Modal Form - Buy Shares
*********************************************************** -->

<div class="modal modal-medium hide" id="buyShares">
    <form class="modal-form form-horizontal" action="<?php echo URL::current(); ?>/buy" method="POST">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Track a Purchase of Shares</h3>
        </div>
        <div class="modal-body">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Symbol</label>
                    <div class="controls">
                        <input name="symbol" type="text" class="span1">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Quantity</label>
                    <div class="controls">
                        <input name="quantity" type="text" class="span1">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Date of Purchase</label>
                    <div class="controls">
                        <input name="date" type="text" class="span2">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Price Paid</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">$</span><input name="price" type="text" class="span1">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Fees</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">$</span><input name="fees" type="text" class="span1">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Notes</label>
                    <div class="controls">
                        <textarea name="notes" rows="3"></textarea>
                    </div>
                </div>

            </fieldset>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </form>
</div>

<!--
***********************************************************
Javascripts - Look at all of them.
*********************************************************** -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
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
<script src="./assets/js/bootstrap/bootstrap-typeahead.js"></script>
<script src="./assets/js/highstock/highstock.src.js"></script>
<script src="./assets/js/highstock/modules/exporting.js"></script>

<!--
***********************************************************
Javascript Chart Template
*********************************************************** -->

<script id="tmpl-chart" type="text/x-handlebars-template">
    <h2>{{symbol}}: {{company}}</h2>
    <p>{{description}}</p>

    {{#if sites.company}}
        <a href='http://{{sites.company}}' class='btn btn-mini btn-info' target="_blank">company <i class="icon-share-alt icon-white"></i></a>
    {{/if}}
    {{#if sites.wiki}}
        <a href='http://{{sites.wiki}}' class='btn btn-mini btn-info' target="_blank">wiki <i class="icon-share-alt icon-white"></i></a>
    {{/if}}

    <a href='https://www.google.com/finance?q={{symbol}}' class='btn btn-mini btn-info' target="_blank">financial <i class="icon-share-alt icon-white"></i></a>

    <div class="pull-right">
        <a data-symbol="{{symbol}}" data-toggle="modal" href="#buyShares" class='btn btn-mini btn-success buy-shares'>buy</a>
        <a href='#' class='btn btn-mini btn-danger'>sell</a>
    </div>
    <div class='chart' id='chart_{{symbol}}'></div>
    <hr>
</script>

<!--
***********************************************************
Javascript Program Kickoff
*********************************************************** -->

<script>
    $(function() {

        $("a[href='#']").live('click', function(e){
            e.preventDefault();
        });

        $("a.buy-shares").live('click', function(){
            var symbol = $(this).data('symbol');
            $("#buyShares").find("input[name='symbol']").val(symbol);
        });

        var TRADE_TYPE_BUY  = 'buy';
        var TRADE_TYPE_SELL = 'sell';
        var symbols = <?php echo json_encode($symbols); ?>;

        for (i in symbols) {
            buildAndLoadChart(symbols[i]);
        }

        function buildAndLoadChart(symdata) {

            var sym = symdata.symbol;
            var tmplsrc = $("#tmpl-chart").html();
            var tmplobj = Handlebars.compile(tmplsrc);
            var tmplhtml = tmplobj(symdata);
            $(tmplhtml).appendTo("#charts");

            $.getJSON('./data/' + sym, function(data) {

                var id = 'chart_' + sym;
                var options = {
                    chart : {
                        animation: true,
                        renderTo : id
                    },
                    rangeSelector : {
                        selected : 4 // 0 is 1 month, 5 is ALL
                    },
                    scrollbar: {
                        enabled: false
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
                                    id: 'buy',
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
                                    onSeries : 'buy',
                                    shape : 'circlepin',
                                    width : 16
                                });

                                break;

                            case TRADE_TYPE_SELL:

                                break;
                        }

                    }

                }

                new Highcharts.StockChart(options);

            });

        }

    });
</script>

</body>
</html>
