<head>
    <title>Speedometer</title>
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Play:700,400' type='text/css'>
    
    <script type="text/javascript" src="http://iop.io/js/vendor/d3.v3.min.js"></script>
    <script type="text/javascript" src="http://iop.io/js/vendor/polymer/PointerEvents/pointerevents.js"></script>
    <script type="text/javascript" src="http://iop.io/js/vendor/polymer/PointerGestures/pointergestures.js"></script>
    <script type="text/javascript" src="http://iop.io/js/iopctrl.js"></script>
    
    <style>
        body {
            font: 16px arial;
            background-color: #515151;
        }

        .unselectable {
            -moz-user-select: -moz-none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* css formats for the gauge */
        .gauge .domain {
            stroke-width: 2px;
            stroke: #fff;
        }

        .gauge .tick line {
            stroke: #fff;
            stroke-width: 2px;
        }
        
        .gauge line {
            stroke: #fff;
        }

        .gauge .arc, .gauge .cursor {
            opacity: 0;
        }

        .gauge .major {
            fill: #fff;
            font-size: 20px;
            font-family: 'Play', verdana, sans-serif;
            font-weight: normal;
        }
        
        .gauge .indicator {
            stroke: #EE3311;
            fill: #000;
            stroke-width: 4px;
        }

        /* css formats for the segment display */
        .segdisplay .on {
            fill: #00FFFF;

        }

        .segdisplay .off {
            fill: #00FFFF;
            opacity: 0.15;
        }
    </style>
</head>
<body>
    <div>
        <span id="speedometer"></span>
    </div>
    
    <script>
        var svg = d3.select("#speedometer")
                .append("svg:svg")
                .attr("width", 400)
                .attr("height", 400);


        var gauge = iopctrl.arcslider()
                .radius(120)
                .events(false)
                .indicator(iopctrl.defaultGaugeIndicator);
        gauge.axis().orient("in")
                .normalize(true)
                .ticks(12)
                .tickSubdivide(3)
                .tickSize(10, 8, 10)
                .tickPadding(5)
                .scale(d3.scale.linear()
                        .domain([0, 160])
                        .range([-3*Math.PI/4, 3*Math.PI/4]));

        var segDisplay = iopctrl.segdisplay()
                .width(80)
                .digitCount(6)
                .negative(false)
                .decimals(0);

        svg.append("g")
                .attr("class", "segdisplay")
                .attr("transform", "translate(130, 200)")
                .call(segDisplay);

        svg.append("g")
                .attr("class", "gauge")
                .call(gauge);

        segDisplay.value(56749);
        gauge.value(92);
    
    </script>
</body>