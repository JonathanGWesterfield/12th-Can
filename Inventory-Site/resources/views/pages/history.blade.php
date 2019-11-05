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
        }
        table td{
          border: 1px solid black;
          padding-right: 8px;
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
              rows[i].parentNode.insertBefore(rows[i], rows[i+1]);
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
      }
    </script>

    <body onload="sortTable()">
      <h1>Database History</h1>

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

      <br>
      <form id="sortSelect">
        <input type="submit"><br>
        <select name="sort">
          <option value=""></option>
          <option value="alph">Alphabetical</option>
          <option value="date">Date</option>
          <option value="change">Change Size</option>
        </select>
        <select name="order">
          <option value=""></option>
          <option value="inc">Ascending</option>
          <option value="dec">Descending</option>
        </select>
      </form>
    </body>
@endsection
