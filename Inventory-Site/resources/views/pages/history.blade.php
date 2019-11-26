@inject('dashboardCont', 'App\Http\Controllers\DashboardController')
@extends('layouts.app')
@php
$inventoryNames = array();
$inventoryQuantities = array();
$inventoryCapacities = array();
$inventoryThresholds = array();
$inventoryIDs = array();

for ($i = 0; $i < count($activeItems); ++$i) {
    $inventoryNames[] = $activeItems[$i]->name;
    $inventoryQuantities[] = $activeItems[$i]->quantity;
    $inventoryCapacities[] = $activeItems[$i]->capacity;
    $inventoryThresholds[] = $activeItems[$i]->low_threshold;
    $inventoryDates[] = $activeItems[$i]->updated_at;
    $inventoryIDs[] = $activeItems[$i]->id;
}

$transactionChanges = array();
$transactionDates = array();
$transactionIDs = array();
$transactionComments = array();
$recentChanges = array();

for ($i = 0; $i < count($activeTransactions); ++$i) {
  $transactionChanges[] = $activeTransactions[$i]->item_quantity_change;
  $transactionDates[] = $activeTransactions[$i]->transaction_date;
  $transactionIDs[] = $activeTransactions[$i]->item_id;
  $transactionComments[] = $activeTransactions[$i]->comment;
}
for ($i = count($activeTransactions); $i > count($activeTransactions)-3; --$i) {
  if ($i > 0) {
    $recentChanges[] = $activeTransactions[$i-1];
  }
}

$transactionNames = array();
for ($i = 0; $i < count($transactionIDs); ++$i) {
  if (in_array($transactionIDs[$i], $inventoryIDs)) {
    $transactionNames[] = $inventoryNames[array_search($transactionIDs[$i], $inventoryIDs)];
  }
}
@endphp

@section('content')
    <head>
      <style>
        .table-scroll {
          height: 90%;
          overflow-y: auto;
        }
        table th{
          padding-right: 20px;
          border: 1px solid black;
          background-color: #e0e0e0;
        }
        table td{
          border: 1px solid black;
          padding-right: 8px;
        }
        table tr:nth-child(even){
          background-color: #e0e0e0;
        }
      </style>
    </head>

    <script>
      function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
      }
      function sortTable() {
        var sortOrder = getUrlVars();
        var table = document.getElementById("transTable");

        var switching = true;
        var i = 0;
        if (sortOrder.sort == 'date'){
          while (switching){
            var rows = table.rows;
            var date1 = Date.parse(rows[i].cells[0].innerHTML);
            var date2 = Date.parse(rows[i+1].cells[0].innerHTML);
            if (sortOrder.order == 'dec' && date1 < date2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 0;
            }
            else if (sortOrder.order == 'inc' && date1 > date2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 0;
            }
            if (i == rows.length - 1){
              switching = false;
              i = 0;
            }
            i++;
          }
        }
        else if (sortOrder.sort == 'alph'){
          i = 1;
          while (switching){
            var rows = table.rows;
            var item1 = rows[i].cells[1].innerHTML;
            var item2 = rows[i+1].cells[1].innerHTML;
            if (sortOrder.order == 'dec' && item1 < item2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 1;
            }
            else if (sortOrder.order == 'inc' && item1 > item2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 1;
            }
            if (i == rows.length - 1){
              switching = false;
              i = 1;
            }
            i++;
          }
        }

        if (sortOrder.addrmv == 'add'){
          for (var i = 1; i < table.rows.length; i++){
            var change = table.rows[i].cells[2].innerHTML;
            if (change < 0){
              table.deleteRow(i);
              i--;
            }
          }
        }
        else if (sortOrder.addrmv == 'rmv'){
          for (var i = 1; i < table.rows.length; i++){
            var change = table.rows[i].cells[2].innerHTML;
            if (change > 0){
              table.deleteRow(i);
              i--;
            }
          }
        }

        if (sortOrder.start != '' || sortOrder.end != ''){
          var startDate = Date.parse(sortOrder.start);
          var endDate = Date.parse(sortOrder.end);
          for (var i = 1; i < table.rows.length; i++){
            var transDate = Date.parse(table.rows[i].cells[0].innerHTML);
            if (startDate > transDate){
              table.deleteRow(i);
              i--;
            }
            if (endDate < transDate){
              table.deleteRow(i);
              i--;
            }
          }
        }
        if (sortOrder.end != ''){

        }
      }
    </script>

    <body onload="sortTable()">
      <div class="row">
        <div class="col text-center" style="...">
          <h1>Database History</h1>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <form id="sortSelect">
              <div class="form-group">
                <select class="form-control" name="sort" id="sort">
                  <!--<option value="date">Date</option>-->
                  <option value="alph">Alphabetical</option>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="order" id="order">
                  <option value="dec">Descending</option>
                  <option value="inc">Ascending</option>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="addrmv" id="addrmv">
                  <option value="addrmv">Add/Remove</option>
                  <option value="add">Add</option>
                  <option value="rmv">Remove</option>
                </select>
              </div>
              <div class="form-group">
                Start Date: <input class="form-control" name="start" type="date"><br>
                End Date: <input class="form-control" name="end" type="date">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <div class="col-md-8">
            <div class="table-scroll">
              <table id="transTable" class="table table-striped table-bordered">
                <thead>
                  <th scope="col">Transaction Date</th>
                  <th scope="col">Item</th>
                  <th scope="col">Change</th>
                  <th scope="col">Comment</th>
                </thead>
                <tbody>
                  @for ($i = count($activeTransactions) - 1; $i > 0; --$i)
                  <tr>
                    <td>{{$transactionDates[$i]}}</td>
                    <td>{{$transactionIDs[$i]}}</td>
                    <td>{{$transactionChanges[$i]}}</td>
                    <td>{{$transactionComments[$i]}}</td>
                  </tr>
                  @endfor
                </tbody>
              </div>
          </div>


            <br>

    </body>
@endsection
