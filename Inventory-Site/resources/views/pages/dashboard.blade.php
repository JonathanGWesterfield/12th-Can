@inject('dashboardCont', 'App\Http\Controllers\DashboardController')
@extends('layouts.sidebar')
@php
$inventoryNames = array();
$inventoryQuantities = array();
$inventoryCapacities = array();
$inventoryThresholds = array();

for ($i = 0; $i < count($activeItems); ++$i) {
    $inventoryNames[] = str_replace(' ', '', $activeItems[$i]->name);
    $inventoryDisplayNames[] = $activeItems[$i]->name;
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
<span class="text-bold">
{{ $dashboardCont::test() }}
</span>

    <table>
      <tr>
        <td>
          <div>
            <canvas id="inventoryChart"></canvas>
          </div>
          <script>
            var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
            var inventoryDisplayNames = <?php echo json_encode($inventoryDisplayNames); ?>;
            var inventoryQuantities = <?php echo json_encode($inventoryQuantities); ?>;

            var checkedNames = getUrlVars();
            var activeNames = [];
            var activeQuantities = [];
            var activeDisplayNames = [];
            if (checkedNames["totalInventory"] == "on"){
              activeNames = inventoryNames;
              activeDisplayNames = inventoryDisplayNames;
              activeQuantities = inventoryQuantities;
            }
            else {
              for (var i = 0; i < inventoryNames.length; i++){
                  if (checkedNames[inventoryNames[i]] == "on"){
                  activeNames.push(inventoryNames[i]);
                  activeDisplayNames.push(inventoryDisplayNames[i]);
                  activeQuantities.push(inventoryQuantities[i]);
                }
              }
            }

            var inventoryChart = document.getElementById('inventoryChart').getContext('2d');
            var inventoryChart = new Chart(inventoryChart, {
              type:'bar',
              data:{
                labels:activeDisplayNames,
                datasets:[{
                  label:'Current Inventory',
                  data:activeQuantities,
                }]
              },
              options:{
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero:true
                    }
                  }]
                }
              }
            });
          </script>
        </td>
        <td>
          <h2>Low Inventory</h2>
            <div class="vertical-menu">
                @for ($i = 0; $i < count($inventoryQuantities); ++$i)
                    @if ($inventoryQuantities[$i] < $inventoryThresholds[$i])
                        <a>{{$inventoryDisplayNames[$i]}}</a>
                    @endif
                @endfor
          </div>
        </td>
        <td>
          <div>
            <canvas id="recentChart"></canvas>
          </div>
          <script>
            var recentChart = document.getElementById('recentChart').getContext('2d');
            var recentChart = new Chart(recentChart, {
              type:'bar',
              data:{
                labels:activeDisplayNames,
                datasets:[{
                  label:'Recent Inventory',
                  data:activeQuantities,
                }]
              },
              options:{
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero:true
                    }
                  }]
                }
              }
            });
          </script>
      </tr>
      <tr>
        <td>
          <form id="viewSelect">
            <input type="submit" value="Submit"><br>
            <input type="checkbox" name="totalInventory">Total Inventory<br>
            @for ($i = 0; $i < count($inventoryNames); ++$i)
              <input type="checkbox" name="{{$inventoryNames[$i]}}">{{$inventoryDisplayNames[$i]}}<br>
            @endfor
            </form>
          </form>
        </td>
        <td>
          <div>
            <canvas id="monthlyChart"></canvas>
          </div>
          <script>
            var monthlyChart = document.getElementById('monthlyChart').getContext('2d');
            var monthlyChart = new Chart(monthlyChart, {
              type:'line',
              data:{
                labels:['Jan', 'Feb', 'Mar'],
                datasets:[
                {
                  label:'Corn',
                  data:[50, 40, 30],
                  fill:false,
                  backgroundColor:'red',
                  borderColor:'red'
                },
                {
                  label:'Potatoes',
                  data:[10, 60, 40],
                  fill:false,
                  backgroundColor:'blue',
                  borderColor:'blue'
                },
                {
                  label:'Rice',
                  data:[70, 60, 40],
                  fill:false,
                  backgroundColor:'green',
                  borderColor:'green'
                }]
              },
              options:{
                title:{
                  display:true,
                  text:'Monthly Inventory'
                },
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero:true
                    }
                  }]
                }
              }
            });
          </script>
        </td>
        <td>
          <div>
            <canvas id="capacityChart"></canvas>
          </div>
          <script>
            var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
            var inventoryQuantities = <?php echo json_encode($inventoryQuantities); ?>;
            var inventoryDisplayNames = <?php echo json_encode($inventoryDisplayNames); ?>;
            var inventoryCapacities = <?php echo json_encode($inventoryCapacities); ?>;

            var checkedNames = getUrlVars();
            var activeNames = [];
            var activeDisplayNames = [];
            var activeQuantities = [];
            var activeCapacities = [];
            if (checkedNames["totalInventory"] == "on"){
              activeNames = inventoryNames;
              activeDisplayNames = inventoryDisplayNames;
              activeQuantities = inventoryQuantities;
              activeCapacities = inventoryCapacities;
            }
            else {
              for (var i = 0; i < inventoryNames.length; i++){
                if (checkedNames[inventoryNames[i]] == "on"){
                  activeNames.push(inventoryNames[i]);
                  activeDisplayNames.push(inventoryDisplayNames[i]);
                  activeQuantities.push(inventoryQuantities[i]);
                  activeCapacities.push(inventoryCapacities[i]);
                }
              }
            }

            var capacityChart = document.getElementById('capacityChart').getContext('2d');
            var capacityChart = new Chart(capacityChart, {
              type:'bar',
              data:{
                labels:activeDisplayNames,
                datasets:[
                {
                  label:'Inventory',
                  data:activeQuantities
                },
                {
                  label:'Capacity',
                  data:activeCapacities
                }
              ]
              },
              options:{
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero:true
                    }
                  }]
                }
              }
            });

          </script>
        </td>
      </tr>

    </table>
</body>





@endsection
