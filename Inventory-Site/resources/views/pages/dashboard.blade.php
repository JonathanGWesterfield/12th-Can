@extends('layouts.app')

@section('content')
<head>
  <style>
  .vertical-menu a {
    background-color: #eee;
    display: block;
    padding: 8px;
    color: black;
  }
  .vertical-menu a:hover{
    background-color: #ccc;
  }

  .container {
    display: block;
    background-color: #eee;
  }
  .container:hover {
    background-color: #ccc;
    cursor: pointer;
  }
  .container input {
    cursor: pointer;
    top: 0;
    left: 0;
  }
  </style>
</head>
<body>
    <h1>Inventory Dashboard Page</h1>

    <table style="width:100%">
      <tr>
        <td>
          <div id="currentHisto" style="width:400px;height:360px;">
            <script>
              var trace1 = {
                //Histogram
                type: 'bar',
                x: ['Corn', 'Potato', 'Rice'],
                //Hard coded dummy values
                y: [13, 28, 54],
                marker: {
                  line: {
                    width: 1.5
                  }
                }
              };

              var data = [ trace1 ];

              var layout = {
                title: 'Current Inventory',
                font: {size: 15}
              };

              Plotly.newPlot('currentHisto', data, layout, {responsive: true});
            </script>
          </div>
        </td>
        <td>
          <h2>Low Inventory</h2>
          <div class="vertical-menu">
            <a>Corn</a>
            <a>Potatoes</a>
            <a>Rice</a>
          </div>
        </td>
        <td>
          <div id="recentHisto" style="width:400px;height:360px;">
            <script>
              var trace1 = {
                //Histogram
                type: 'bar',
                x: ['Corn', 'Potato', 'Rice'],
                //Hard coded dummy values
                y: [4, 2, 5],
                marker: {
                  line: {
                    width: 1.5
                  }
                }
              };

              var data = [ trace1 ];

              var layout = {
                title: 'Recent Inventory',
                font: {size: 15}
              };

              Plotly.newPlot('recentHisto', data, layout, {responsive: true});
            </script>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <label class="container">Total Inventory
            <input type="checkbox">
            <span class="checkmark"></span>
          </label>
          <label class="container">Corn
            <input type="checkbox">
            <span class="checkmark"></span>
          </label>
          <label class="container">Potatoes
            <input type="checkbox">
            <span class="checkmark"></span>
          </label>
          <label class="container">Rice
            <input type="checkbox">
            <span class="checkmark"></span>
          </label>
        </td>
        <td>
          <div id="inventoryLine" style="width:400px;height:360px;">
            <script>
              var trace1 = {
                x: ['Jan', 'Feb', 'Mar', 'Apr'],
                y: [10, 15, 13, 17],
                mode: 'lines',
                name: 'Corn'
              };

              var trace2 = {
                x: ['Jan', 'Feb', 'Mar', 'Apr'],
                y: [16, 5, 11, 9],
                mode: 'lines',
                name: 'Potatoes'
              };

              var trace3 = {
                x: ['Jan', 'Feb', 'Mar', 'Apr'],
                y: [12, 9, 15, 12],
                mode: 'lines',
                name: 'Rice'
              };

              var data = [ trace1, trace2, trace3 ];

              var layout = {
                title:'Monthly Inventory'
              };

              Plotly.newPlot('inventoryLine', data, layout);
            </script>
          </div>
        </td>
        <td>
          <div id="stockCapacity" style="width:400px;height:360px;">
            <script>
              var trace1 = {
                x: ['Corn', 'Potato', 'Rice'],
                y: [13, 28, 54],
                name: 'Inventory',
                type: 'bar',
                marker: {
                  line: {
                    width: 1
                  }
                }
              };

              var trace2 = {
                x: ['Corn', 'Potato', 'Rice'],
                y: [45, 30, 75],
                name: 'Capacity',
                type: 'bar',
                marker: {
                  line: {
                    width: 1
                  }
                }
              }

              var data = [trace1, trace2];
              var layout = {
                barmode: 'group',
                title: 'Inventory vs. Capacity'
              };
              Plotly.newPlot('stockCapacity', data, layout);
            </script>
          </div>
        </td>
      </tr>

    </table>
</body>





@endsection
