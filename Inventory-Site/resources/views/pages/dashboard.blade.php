@extends('layouts.app')
@php
$inventoryNames = array();
$inventoryQuantities = array();
$inventoryCapacities = array();
$inventoryThresholds = array();

for ($i = 0; $i < count($activeItems); ++$i) {
    $inventoryNames[] = $activeItems[$i]->name;
    $inventoryQuantities[] = $activeItems[$i]->quantity;
    $inventoryCapacities[] = $activeItems[$i]->capacity;
    $inventoryThresholds[] = $activeItems[$i]->low_threshold;
}
@endphp

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



  </style>

  <script>
    function getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
      });
      return vars;
    }
  </script>

</head>
<body>
    <h1>Inventory Dashboard Page</h1>

    <table style="width:100%">
      <tr>
        <td>
          <div id="currentHisto" style="width:400px;height:360px;">
            <script>

              var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
              var inventoryQuantities = <?php echo json_encode($inventoryQuantities); ?>;

              var checkedNames = getUrlVars();
              var activeNames = [];
              var activeQuantities = [];
              if (checkedNames["totalInventory"] == "on"){
                activeNames = inventoryNames;
                activeQuantities = inventoryQuantities;
              }
              else {
                for (var i = 0; i < inventoryNames.length; i++){
                  if (checkedNames[inventoryNames[i]] == "on"){
                    activeNames.push(inventoryNames[i]);
                    activeQuantities.push(inventoryQuantities[i]);
                  }
                }
              }

              var trace1 = {
                //Histogram
                type: 'bar',
                x: activeNames,
                y: activeQuantities,
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
                @for ($i = 0; $i < count($inventoryQuantities); ++$i)
                    @if ($inventoryQuantities[$i] < $inventoryThresholds[$i])
                        <a>{{$inventoryNames[$i]}}</a>
                    @endif
                @endfor
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
          <form>
            <input type="submit" value="Submit"><br>
            <input type="checkbox" name="totalInventory">Total Inventory<br>
            @for ($i = 0; $i < count($inventoryNames); ++$i)
              <input type="checkbox" name="{{$inventoryNames[$i]}}">{{$inventoryNames[$i]}}<br>
            @endfor
            </form>
          </form>
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

              var data = [ trace1, trace2, trace3];

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
              var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
              var inventoryQuantities = <?php echo json_encode($inventoryQuantities); ?>;
              var inventoryCapacities = <?php echo json_encode($inventoryCapacities); ?>;

              var checkedNames = getUrlVars();
              var activeNames = [];
              var activeQuantities = [];
              var activeCapacities = [];
              if (checkedNames["totalInventory"] == "on"){
                activeNames = inventoryNames;
                activeQuantities = inventoryQuantities;
                activeCapacities = inventoryCapacities;
              }
              else {
                for (var i = 0; i < inventoryNames.length; i++){
                  if (checkedNames[inventoryNames[i]] == "on"){
                    activeNames.push(inventoryNames[i]);
                    activeQuantities.push(inventoryQuantities[i]);
                    activeCapacities.push(inventoryCapacities[i]);
                  }
                }
              }

              var trace1 = {
                x: activeNames,
                y: activeQuantities,
                name: 'Inventory',
                type: 'bar',
                marker: {
                  line: {
                    width: 1
                  }
                }
              };

              var trace2 = {
                x: activeNames,
                y: activeCapacities,
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
