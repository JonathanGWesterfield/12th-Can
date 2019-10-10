@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

<!-- Modal -->

@section('content')


<div ng-app="add" ng-controller="addItems">
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input required type="text" class="form-control" id="itemName" placeholder="Enter item name">
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input required type="number" class="form-control" id="capacity" placeholder="Capacity">
                    </div>
                    <div class="form-group">
                        <label for="threshold">Threshold</label>
                        <input required type="number" class="form-control" id="threshold" placeholder="Threshold">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="foodItem">
                        <label class="form-check-label" for="exampleCheck1">Food Item?</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="refrigeration">
                        <label class="form-check-label" for="refrigeration">Needs to be refrigerated</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" ng-click="addItem()" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationTitle">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Low Inventory Threshold</th>
                            <th scope="col">Food Item</th>
                            <th scope="col">Needs to be refrigerated</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="item in addItems">
                        <tr>
                            <td><%item.name%></td>
                            <td><%item.capacity%></td>
                            <td><%item.Threshold%></td>
                            <td><%item.foodItem%></td>
                            <td><%item.Refrigeration%></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" ng-click="submit()" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" style="text-align: center">
        <h2>Add Item Page</h2>
    </div>
</div>
<div class="row py-md-2">
    <div class="col" style="text-align: right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add Item
        </button>
    </div>
</div>
<div class="row">
    <div class="col-2 mx-md-5 border">
        <label>Search: <input ng-model="searchText"></label>
        <table id="searchTextResults">
            <tr>
                <th>Available Items</th>
            </tr>
            <tr ng-repeat="item in items | filter:searchText">
                <td><%item.name%></td>
            </tr>
        </table>

    </div>
    <div class="col mx-md-5">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Capacity</th>
                    <th scope="col">Low Inventory Threshold</th>
                    <th scope="col">Food Item</th>
                    <th scope="col">Needs to be refrigerated</th>
                </tr>
            </thead>
            <tbody ng-repeat="item in addItems">
                <tr>
                    <td><%item.name%></td>
                    <td><%item.capacity%></td>
                    <td><%item.Threshold%></td>
                    <td><%item.foodItem%></td>
                    <td><%item.Refrigeration%></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row py-md-2">
    <div class="col" style="text-align: right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal">
            Submit
        </button>
    </div>
</div>
<!--
$scope.reset is the definition of what the reset function does
Placeholder for a login function on line 13
Instead of resetting, it should:
Send username and password to backend for verification
Wait for response
When OK received, redirect to mainpage
-->
<script>
    var app = angular.module('add', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });
    app.controller('addItems', function($scope) {
        console.log("Hello")
        jQuery(function() {
            $scope.addItems = []
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText)
                    $scope.items = msthis.responseTextg
                    $scope.completeItems = JSON.parse(JSON.stringify(this.responseText))
                    $scope.addItems = []
                    $scope.$apply()
                }
            };
            xhttp.open("GET", "items", true);
            xhttp.send()
        })
        $scope.addItem = function() {
            console.log("Hello101")
            var name = document.getElementById('itemName');
            var capacity = document.getElementById('capacity');
            var threshold = document.getElementById('threshold');
            $scope.addItems.push({
                "name": name.value,
                "capacity": capacity.value,
                "Threshold": threshold.value,
                "foodItem": "Yes",
                "Refrigeration": "Yes"
            })
            $scope.completeItems.push({
                "name": name.value,
                "capacity": capacity.value,
                "Threshold": threshold.value,
                "foodItem": "Yes",
                "Refrigeration": "Yes"
            })
        }
        $scope.submit = function() {
            console.log($scope.items)
            $scope.addItems = []
            console.log($scope.items)
            jQuery.ajax({
                    method: "POST",
                    url: "/addItem",
                    data: {
                        "data": $scope.completeItems
                    }
                })
                .done(function(msg) {

                    $scope.$apply()
                });
        }
    });
</script>

</div>
@endsection
