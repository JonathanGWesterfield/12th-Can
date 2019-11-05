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
        table tr:hover{
          background-color: #ccc;
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
        else if (sortOrder.sort == 'change'){
          i = 1;
          while (switching){
            var rows = table.rows;
            var change1 = rows[i].cells[2].innerHTML;
            var change2 = rows[i+1].cells[2].innerHTML;
            if (sortOrder.order == 'dec' && change1 < change2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 1;
            }
            else if (sortOrder.order == 'inc' && change1 > change2){
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

      <div class="container">
        <h1>Database History</h1>
        <div class="row">
          <div class="col-md-4">
            <form id="sortSelect">
              <input type="submit"><br>
              <select name="sort">
                <option value="">Sort Type</option>
                <option value="alph">Alphabetical</option>
                <option value="date">Date</option>
                <option value="change">Change Size</option>
              </select>
              <select name="order">Test
                <option value="">Ordering</option>
                <option value="inc">Ascending</option>
                <option value="dec">Descending</option>
              </select>
              <select name="addrmv">
                <option value="">Filter Type</option>
                <option value="addrmv">Add/Remove</option>
                <option value="add">Add</option>
                <option value="rmv">Remove</option>
              </select>
              <br>
              Start Date: <input name="start" type="date"><br>
              End Date: <input name="end" type="date"><br>
            </form>
          </div>
          <div class="col-md-8">
            <div class="table-scroll">
              <table id="transTable" class="table table-sm">
                <thead>
                  <th scope="col">Transaction Date</th>
                  <th scope="col">Item</th>
                  <th scope="col">Change</th>
                  <th scope="col">Comment</th>
                </thead>
                <tbody>
                  @for ($i = 0; $i < count($activeTransactions); ++$i)
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
