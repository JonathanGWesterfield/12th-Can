@inject('dashboardCont', 'App\Http\Controllers\DashboardController')
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
    $inventoryDates[] = $activeItems[$i]->updated_at;
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

    <body>
      <h1>Database History</h1>
      <!--
      <form id="viewSelect">
        <input type="submit" value="Submit"><br>
        <input type="checkbox" name="totalInventory">Total Inventory<br>
        @for ($i = 0; $i < count($inventoryNames); ++$i)
          <input type="checkbox" name="{{$inventoryNames[$i]}}">{{$inventoryNames[$i]}}<br>
        @endfor
      </form>
      <br>
    -->
      <table>
        <tr>
          <th>Transaction Date</th>
          <th>Item</th>
          <th>Quantity</th>
          <th>Change Comments</th>
        </tr>
        @for ($i = 0; $i < count($inventoryQuantities); ++$i)
          <tr>
            <td>{{$inventoryDates[$i]}}</td>
            <td>{{$inventoryNames[$i]}}</td>
            <td>{{$inventoryQuantities[$i]}}</td>
            <td>No comment database?</td>
          </tr>
        @endfor
      </table>

      <br>
      <form id="sortSelect">
        <input type="submit" name="Submit"><br>
        <select name="sort">
          <option value="alph">Alphabetical</option>
          <option value="date">Date</option>
          <option value="quant">Quantity</option>
        </select>
      </form>
    </body>
@endsection
