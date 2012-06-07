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
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">My Stocks</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-cog"></i> Options
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#"><i class="icon-plus"></i> Add New Symbol</a></li>
              <!--
              <li class="divider"></li>
              <li><a href="#">Sign Out</a></li>
              -->
            </ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">

        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Sidebar</li>
              <li class="active"><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span9">
          <div class="row-fluid" id="charts">

          </div><!--/row-->
        </div><!--/span-->

      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Christopher Mason 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

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

    <script src="./assets/js/highstock/highstock.js"></script>
    <script src="./assets/js/highstock/modules/exporting.js"></script>

    <script>
        $(function() {

            var symbols = ['NFLX','DDD','JNPR','COHU','CAJ'];

            for (sym in symbols) {
                buildAndLoadChart(symbols[sym]);
            }

            function buildAndLoadChart(sym) {

                console.log(sym);

                var id = 'chart_' + sym;
                var div = $('<div/>')
                                .attr('id', id)
                                .addClass('chart')
                                .appendTo("#charts");

                //div.width('100%').height('300px');

                $.getJSON('./data/' + sym, function(data) {

                    new Highcharts.StockChart({
                        chart : {
                            animation: true,
                            renderTo : id
                        },
                        rangeSelector : {
                            selected : 5
                        },
                        title : {
                            text : sym + ' Stock History'
                        },
                        scrollbar: {
                            enabled: false
                        },
                        exporting: {
                            enabled: false
                        },
                        series : [{
                            name : sym,
                            data : data,
                            tooltip: {
                                valueDecimals: 2
                            }
                        }]
                    });
                });

            }

        });
    </script>

  </body>
</html>
