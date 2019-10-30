@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js">
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

<!-- Modal -->

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div ng-app="add" ng-controller="addItems">

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                            <th scope="col">Current Quantity</th>
                            <th scope="col">Quantity Removed</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="item in addItems">
                        <tr>
                            <td><%item.name%></td>
                            <td><%item.quantity%></td>
                            <td><%item.remQuantity%></td>
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
<div class="alert alert-primary" role="alert" id ="alert" hidden>
</div>
<div class="alert alert-danger" role="alert" id ="requiredAlert" hidden>
Please fill out all the feilds in the table
</div>
<div class="row">
    <div class="col" style="text-align: center">
        <h2>Remove Inventory Page</h2>
    </div>
</div>
<div class="row">
    <div class="col-2 mx-md-5 my-md-5 py-md-2 border">
        <label>Search: <input ng-model="searchText"></label>
        <table id="searchTextResults">
            <tr>
                <th>Available Items</th>
            </tr>
            <tr ng-repeat="item in items | filter:searchText">
                <td class="btn btn-link" ng-click="addToTable(item)"><%item.name%></td>
            </tr>
        </table>
    </div>
    <div class="col mx-md-5">
        <div class="row">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Current Quantity</th>
                            <th scope="col">Quantity Removed</th>
                            <th scope="col">Cancel</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="item in addItems">
                        <tr>
                            <td><%item.name%></td>
                            <td><%item.quantity%></td>
                            <td><input ng-model = "item.remQuantity" type = "number" only-num></td>
                            <td><button class="btn btn-primary" ng-click="remove($index)">Cancel</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row pt-md-2">
            <div class="col" style="text-align: right">
                <button type="button" class="btn btn-primary" data-toggle="modal" ng-click="preview()">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var app = angular.module('add', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

    app.controller('addItems', function($scope) {
        console.log("Hello")
        jQuery(function() {

            //document.getElementById("alert").slideUp(500);
            $scope.addItems = []
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText)
                    $scope.items = JSON.parse(this.responseText)
                    $scope.completeItems = JSON.parse(this.responseText)
                    console.log($scope.completeItems)
                    $scope.addItems = []
                    $scope.$apply()
                }
            };
            xhttp.open("GET", "items", true);
            xhttp.send()
        })
        $scope.addToTable = function(e){
            for(var i = 0; i<$scope.addItems.length; ++i){
                if($scope.addItems[i].id == e.id){
                    return;
                }
            }
            $scope.addItems.push(JSON.parse(JSON.stringify(e)));
            console.log(e.removed)
            var currItem = $scope.addItems[$scope.addItems.length - 1];
            currItem.remQuantity = 0;
        }
        $scope.preview = function(){
            jQuery('#confirmationModal').modal('show')
        }
        $scope.remove = function(index){
            $scope.addItems.splice(index, 1);
        }
        $scope.submit = function() {
            console.log("Time to submit")
            console.log($scope.addItems.length)
            //if($scope.addItems.length == 0) return;
            jQuery.ajax({
                url: 'transactions',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify($scope.addItems),
                //data: JSON.stringify($scope.modifyItems),
                success: function(data) {
                    // handle success
                    console.log(data);
                    data = JSON.parse(data);
                    $scope.modifyItems = [];
                    $scope.addItems = []
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText)
                            $scope.items = JSON.parse(this.responseText)
                            $scope.completeItems = JSON.parse(this.responseText)
                            console.log($scope.completeItems)
                            $scope.addItems = []
                            $scope.$apply()
                        }
                    };
                    xhttp.open("GET", "items", true);
                    xhttp.send()
                    document.getElementById("alert").innerHTML = "";
                console.log(data.item_count);
                if(data.status == 'item(s) modified'){
                    document.getElementById("alert").innerHTML = data.items_modified + " item was successfully modified. ";
                }
                document.getElementById("alert").hidden = false;
                jQuery("#alert").slideDown(200, function() {
                    //jQuery(this).alert('close');
                });
                jQuery("#alert").delay(5000).slideUp(200, function() {
                    //jQuery(this).alert('close');
                    //document.getElementById("alert").hidden = true;
                });
                },
                error: function(request,msg,error) {
                    // handle failure
                    console.log(request);
                    console.log(msg);
                    console.log(error);
                }
            });
        }
    });
    app.directive('onlyNum', function() {
    return function(scope, element, attrs) {

        var keyCode = [8, 9, 37, 39, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 110];
        element.bind("keydown", function(event) {
            //console.log($.inArray(event.which,keyCode));
            if ($.inArray(event.which, keyCode) === -1) {
                scope.$apply(function() {
                    scope.$eval(attrs.onlyNum);
                    event.preventDefault();
                });
                event.preventDefault();
            }

        });
    };
});
</script>

</div>
@endsection
