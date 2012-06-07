<!DOCTYPE html>
<html lang="en">
  <head>
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
          <a class="brand" href="#">My Stock Charts</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-cog"></i> Options
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#"><i class="icon-plus"></i> Add New Symbol</a></li>
            </ul>
          </div>

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
          <div class="row-fluid" id="charts">
          </div><!--/row-->
        </div><!--/span-->

      </div><!--/row-->

      <footer>
        <p>&copy; Christopher Mason 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
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

    <script id="tmpl-chart" type="text/x-handlebars-template">
        <h2>{{symbol}}: {{title}}</h2>
        <p>{{desc}}</p>
        {{#each sites}}
            <a href='{{url}}' class='btn btn-mini btn-info' target="_blank">{{type}} <i class="icon-share-alt icon-white"></i></a>
        {{/each}}
            <a href='https://www.google.com/finance?q={{symbol}}' class='btn btn-mini btn-info' target="_blank">financial <i class="icon-share-alt icon-white"></i></a>
            <a href='#' class='btn btn-mini btn-success'>buy</a>
            <a href='#' class='btn btn-mini btn-danger'>sell</a>
        <div class='chart' id='chart_{{symbol}}'></div>
        <hr>
    </script>

    <script>
        $(function() {

            var TRADE_TYPE_BUY  = 'buy';
            var TRADE_TYPE_SELL = 'sell';

            var symbols = [
                {
                    symbol: 'NFLX',
                    title: 'Netflix',
                    desc: 'Netflix is an American provider of on-demand Internet streaming media.',
                    sites: [
                        {type: 'company',   url: 'http://www.netflix.com/'},
                        {type: 'wiki',      url: 'http://en.wikipedia.org/wiki/Netflix'}
                    ],
                    trades: [{
                        type: TRADE_TYPE_BUY,
                        shares: 10,
                        date: moment("May 31, 2012").valueOf(),
                        price: 64.28
                    }]
                },
                {
                    symbol: 'JNPR',
                    title: 'Juniper Networks',
                    desc: 'Juniper Networks designs and manufacturers high-performance Internet Protocol network products and services out of Sunnyvale California.',
                    sites: [
                        {type: 'company',   url: 'http://www.juniper.net/'},
                        {type: 'wiki',      url: 'http://en.wikipedia.org/wiki/Juniper_Networks'}
                    ],
                    trades: []
                },
                {
                    symbol: 'CAJ',
                    title: 'Canon Inc',
                    desc: 'Canon is a Japanese corporation that specialises in the manufacture of cameras, camcorders, photocopiers, and computer printers.',
                    sites: [
                        {type: 'company',   url: 'http://www.canon.com/'},
                        {type: 'wiki',      url: 'http://en.wikipedia.org/wiki/Canon_(company)'}
                    ],
                    trades: []
                },
                {
                    symbol: 'DDD',
                    title: '3D Systems Corporation',
                    desc: '3D Systems is a leading, global provider of 3D content-to-print solutions including personal, professional and production 3D printers.',
                    sites: [
                        {type: 'company',   url: 'http://www.3dsystems.com/'},
                        {type: 'news',      url: 'http://www.3dsystems.com/news/'}
                    ],
                    trades: []
                },
                {
                    symbol: 'COHU',
                    title: 'Cohu Inc',
                    desc: 'Cohu is a leading supplier of thermal solutions used by the global semiconductor industry.',
                    sites: [
                        {type: 'company',   url: 'http://www.cohu.com/'},
                        {type: 'investor',  url: 'http://ir.cohu.com/phoenix.zhtml?c=97857&p=irol-IRHome'}
                    ],
                    trades: []
                }
            ];

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
                        title : {
                            // text : sym + ' Stock History'
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

                    if (symdata.trades.length > 0) {

                        for (i in symdata.trades) {

                            var trade = symdata.trades[i];
                            console.log('trade', trade);

                            switch (trade.type) {

                                case TRADE_TYPE_BUY:

                                    options.yAxis = {
                                        plotLines: [{
                                            value: trade.price,
                                            width: 1,
                                            color: '#00CC00',
                                            dashStyle : 'shortdash',
                                            label: {
                                                //text: 'Purchase of 10 Shares'
                                            }
                                        }]
                                    };

                                    options.series.push({
                                        name : 'BUY',
                                        data : [
                                            [trade.date, trade.price ],
                                            [moment().sod().valueOf(), trade.price]
                                        ],
                                        id: 'buy',
                                        tooltip: {
                                            valueDecimals: 2
                                        }
                                    });

                                    options.series.push({
                                        type: 'flags',
                                        data: [{
                                            x : trade.date,
                                            title: 'B',
                                            text: trade.shares + ' shares at $' + trade.price
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
