@inject('dashboardCont', 'App\Http\Controllers\DashboardController')
@extends('layouts.sidebar')
@php
$inventoryNames = array();
$inventoryDisplayNames = array();
$inventoryQuantities = array();
$inventoryCapacities = array();
$inventoryThresholds = array();
$inventoryIDs = array();

for ($i = 0; $i < count($activeItems); ++$i) {
    $inventoryNames[] = str_replace(' ', '*', $activeItems[$i]->name);
    $inventoryDisplayNames[] = $activeItems[$i]->name;
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
$transactionUsers = array();
$recentChanges = array();

for ($i = 0; $i < count($activeTransactions); ++$i) {
  $transactionChanges[] = $activeTransactions[$i]->item_quantity_change;
  $transactionDates[] = $activeTransactions[$i]->transaction_date;
  $transactionIDs[] = $activeTransactions[$i]->item_id;
  $transactionComments[] = $activeTransactions[$i]->comment;
  $transactionUserIDs[] = $activeTransactions[$i]->member_id;
}
for ($i = count($activeTransactions); $i > count($activeTransactions)-3; --$i) {
  if ($i > 0) {
    $recentChanges[] = $activeTransactions[$i-1];
  }
}

$transactionNames = array();
for ($i = 0; $i < count($transactionIDs); ++$i) {
  if (in_array($transactionIDs[$i], $inventoryIDs)) {
    $transactionNames[] = $inventoryDisplayNames[array_search($transactionIDs[$i], $inventoryIDs)];
  }
}

$userNames = array();
$userIDs = array();
for ($i = 0; $i < count($activeUsers); ++$i) {
  $userNames[] = $activeUsers[$i]->name;
  $userIDs[] = $activeUsers[$i]->id;
}

$transactionUserNames = array();
for ($i = 0; $i < count($transactionUserIDs); ++$i) {
  if (in_array($transactionUserIDs[$i], $userIDs)) {
    $transactionUserNames[] = $userNames[array_search($transactionUserIDs[$i], $userIDs)];
  }
}

$sortedNames = $inventoryNames;
usort($sortedNames, 'strnatcasecmp');
$sortedDisplayNames = $inventoryDisplayNames;
usort($sortedDisplayNames, 'strnatcasecmp');
@endphp

@section('content')
    <head>
      <style>
        .table-scroll {
          height: 470px;
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

        if (sortOrder.sort != null){
        //For filtering by item name
        var sort = sortOrder.sort.replace("*", " ");
        if (sort != "" && sort != 'all') {
          for (var i = 1; i < table.rows.length; i++){
            if (sort != table.rows[i].cells[1].innerHTML){
              table.deleteRow(i);
              i--;
            }
          }
        }

        //Chronological sorting
        if (sortOrder.order == 'dec'){
          var i = 0;
          while (i < table.rows.length-1){
            var date1 = Date.parse(table.rows[i].cells[0].innerHTML);
            var date2 = Date.parse(table.rows[i+1].cells[0].innerHTML);
            if (date1 < date2){
              table.rows[i].parentNode.insertBefore(table.rows[i+1], table.rows[i]);
              i = 0;
            }
            i++;
          }
        }
        else if (sortOrder.order == 'inc'){
          var i = 0;
          while (i < table.rows.length-1){
            var date1 = Date.parse(table.rows[i].cells[0].innerHTML);
            var date2 = Date.parse(table.rows[i+1].cells[0].innerHTML);
            if (date1 > date2){
              table.rows[i].parentNode.insertBefore(table.rows[i+1], table.rows[i]);
              i = 0;
            }
            i++;
          }
        }

        //Filter by add or removing quantities
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

        //Filter by calendar date range
        //Prevent user from making Start Date > End Date
        if (sortOrder.start != '' &&  sortOrder.end != ''){
          var startDate = Date.parse(sortOrder.start);
          var endDate = Date.parse(sortOrder.end);
          if (startDate <= endDate){
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
          //This is just a temporary notification, try to make it a modal
          else if (startDate > endDate){
            table.rows[0].cells[0].innerHTML = "Dates Invalid";
            table.rows[0].cells[1].innerHTML = "";
            table.rows[0].cells[2].innerHTML = "";
            table.rows[0].cells[3].innerHTML = "";
            table.rows[0].cells[4].innerHTML = "";
            for (var i = 1; i < table.rows.length; i++){
              table.deleteRow(i);
              i--;
            }
          }
        }
        //Handle all other cases
        else if (sortOrder.start != '' || sortOrder.end != ''){
          var startDate = Date.parse(sortOrder.start);
          var endDate = Date.parse(sortOrder.end);
          for (var i = 1; i < table.rows.length; i++){
            var transDate = Date.parse(table.rows[i].cells[0].innerHTML);
            if (startDate+86400000 >= transDate){
              table.deleteRow(i);
              i--;
            }
            if (endDate <= transDate-86400000-86400000){
              table.deleteRow(i);
              i--;
            }
          }
        }
      }
    }

      function formatTable() {
        //Remember selectbox values
        var selectBoxes = document.getElementById("sortSelect").elements;
        var urlVars = getUrlVars();
        if (urlVars.sort != null){
          selectBoxes[0].value = urlVars.sort;
        }
        if (urlVars.order != null){
          selectBoxes[1].value = urlVars.order;
        }
        if (urlVars.addrmv != null){
          selectBoxes[2].value = urlVars.addrmv;
        }
        if (urlVars.start != null){
          selectBoxes[3].value = urlVars.start;
        }
        if (urlVars.end != null){
          selectBoxes[4].value = urlVars.end;
        }

        var rows = document.getElementById("transTable").rows;
        for (var i = 1; i < rows.length; i++){
          var tableDate = new Date(rows[i].cells[0].innerHTML);
          var hours = tableDate.getHours();
          var amPM = "AM";
          var minutes = tableDate.getMinutes();
          var day = tableDate.getDate();
          var month = tableDate.getMonth()+1;
          var year = tableDate.getFullYear();

          if (hours >= 12){
            hours = hours-12;
            amPM = "PM";
            if (hours == 0){
              hours = 12;
            }
          }
          rows[i].cells[0].innerHTML = month + "/" + day + "/" + year + " " + hours + ":" + minutes + " " + amPM;
        }
      }
    </script>

    <body onload="sortTable(); formatTable();">
      <div class="row">
        <div class="col text-center" style="...">
          <h1>Inventory History</h1>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <form id="sortSelect">
              <div class="form-group">
                <select class="form-control" name="sort" id="sort">
                  <option value="all">All Inventory</option>
                  @for ($i = 0; $i < count($sortedNames); ++$i)
                    <option value="{{$sortedNames[$i]}}" name="{{$sortedNames[$i]}}">{{$sortedDisplayNames[$i]}}</option>
                  @endfor
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
                  <th scope="col">User</th>
                  <th scope="col">Comment</th>
                </thead>
                <tbody>
                  @for ($i = count($activeTransactions) - 1; $i > 0; --$i)
                  <tr>
                    <td>{{$transactionDates[$i]}}</td>
                    <td>{{$transactionNames[$i]}}</td>
                    <td>{{$transactionChanges[$i]}}</td>
                    <td>{{$transactionUserNames[$i]}}</td>
                    <td>{{$transactionComments[$i]}}</td>
                  </tr>
                  @endfor
                </tbody>
              </div>
          </div>
          <br>
    </body>


@endsection
