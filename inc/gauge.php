<!doctype html>
<html>

  <head>
    <meta charset="utf-8" />
    <title>Pointer</title>
    <meta name="viewport" content="width=device-width">
    <style>
    .gauge_wrapper {
      position: relative;
      width: 640px;
      height: 480px;
      margin: 50px auto 0 auto;
      padding-bottom: 30px;
      border: 1px solid #ccc;
      border-radius: 3px;
      clear: both;
    }

    .gauge_box {
      float: left;
      width: 50%;
      height: 50%;
      box-sizing: border-box;
    }

    .gauge_container {
      width: 450px;
      margin: 0 auto;
      text-align: center;
    }

    .gauge {
      width: 120px;
      height: 90px;
    }

    button {
      margin: 30px 5px 0 2px;
      padding: 16px 40px;
      border-radius: 5px;
      font-size: 18px;
      border: none;
      background: #34aadc;
      color: white;
      cursor: pointer;
    }
    </style>
  </head>

  <body>
    <div class="gauge_wrapper">
      <div class="gauge_box">
        <div id="g1" class="gauge"></div>
      </div>
    </div>
    <script src="../assets/js/raphael-2.1.4.min.js"></script>
    <script src="../assets/js/justgage.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function(event) {

      var g1 = new JustGage({
        id: 'g1',
        value: 65,
        min: 0,
        max: 100,
        symbol: '%',
        pointer: true,
        gaugeWidthScale: 0.6,
        customSectors: [{
          color: '#ff0000',
          lo: 80,
          hi: 100
        }, {
          color: '#ff9900',
          lo: 60,
          hi: 80
        },{
          color: '#ffff00',
          lo: 40,
          hi: 60
        }, {
          color: '#00ff00',
          lo: 0,
          hi: 40
        }],
        counter: true
      });

    });
    </script>
  </body>

</html>
