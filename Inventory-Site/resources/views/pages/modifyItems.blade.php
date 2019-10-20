@extends('layouts.sidebar')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

<!-- Modal -->

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div ng-app="add" ng-controller="addItems">
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modify Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <div class="modal-body">
                <form ng-submit = "addItem()">
                    <div class="form-row">
                        <label for="itemName">Item name</label>
                        <input type="text" class="form-control" id="itemName" placeholder="Item Name" required>
                    </div>
                    <div class="form-row">
                        <label for="capacity">Capacity</label>
                        <input type="number" class="form-control" id="capacity" placeholder="Capcity" required>
                    </div>
                    <div class="form-row">
                        <label for="threshold">Threshold</label>
                        <input type="number" class="form-control" id="threshold" placeholder="Threshold" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="foodItem">
                            <label class="form-check-label" for="exampleCheck1">Food Item?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="refrigeration">
                            <label class="form-check-label" for="refrigeration">Needs to be refrigerated</label>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit form</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                            <td><%item.threshold%></td>
                            <td><%item.isFood%></td>
                            <td><%item.refrigerated%></td>
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
<div class="row">
    <div class="col" style="text-align: center">
        <h2>Modify Items Page</h2>
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
        <div class="row py-md-2">
            <div class="col" style="text-align: right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add Item
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Low Inventory Threshold</th>
                            <th scope="col">Food Item</th>
                            <th scope="col">Needs to be refrigerated</th>
                            <th scope="col">Remove Row?</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="item in addItems">
                        <tr>
                            <td><input ng-model = "item.name" type = "text"></td>
                            <td><input ng-model = "item.capacity" type = "text"></td>
                            <td><input ng-model = "item.low_threshold" type = "text"></td>
                            <td><input ng-model = "item.is_food" type = "text"></td>
                            <td><input ng-model = "item.refrigerated" type = "text"></td>
                            <td><button class="btn btn-primary" ng-click="remove($index)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row pt-md-2">
            <div class="col" style="text-align: right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal">
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
            console.log("Adding: " + e);
            if($scope.addItems.includes(e)){
                return;
            }
            else{
                $scope.addItems.push(JSON.parse(JSON.stringify(e)));
            }
        }
        $scope.addItem = function() {
            console.log("Hello101")
            var name = document.getElementById('itemName');
            var capacity = document.getElementById('capacity');
            var threshold = document.getElementById('threshold');
            var foodItem = document.getElementById('foodItem');
            var ref = document.getElementById('refrigeration');
            var food = 'No';
            var refr = 'No';
            if(foodItem.checked){
                food = 'Yes';
                foodItem.checked = false;
            }
            if(ref.checked){
                refr = 'Yes';
                ref.checked = false;
            }
            $scope.addItems.push({
                "name": name.value,
                "capacity": capacity.value,
                "threshold": threshold.value,
                "isFood": food,
                "refrigerated": refr
            })
            name.value = ''
            capacity.value = ''
            threshold.value = ''
            jQuery('#exampleModal').modal('hide')
        }
        $scope.remove = function(index){
            $scope.addItems.splice(index, 1);
        }
        $scope.submit = function() {
            /*if (counter===5) {
    		$('.quoteList').empty();
                counter = 0;
            }

            $.ajax({
                /* The whisperingforest.org URL is not longer valid, I found a new one that is similar...
                url:'http://quotes.stormconsultancy.co.uk/random.json',
                async: true,
                dataType: 'jsonp',
                success:function(data){
                    $('.quoteList').append('<li>' + data.quote +'</li>');
                    counter++;
                    if (counter < 5) getData();
                }
            });*/
            console.log("Time to submit")
            console.log($scope.addItems.length)
            $scope.notAdded =[];
            for (var i = 0; i<$scope.addItems.length; ++i){
                for (var j = 0; j<$scope.items.length; ++j){
                    if($scope.addItems[i].name == $scope.items[j].name){
                        $scope.notAdded.push($scope.addItems[i]);
                        $scope.addItems.splice(i,1);
                        --i;
                        break;
                    }
                }
            }
            //if($scope.addItems.length == 0) return;
            jQuery.post('items',JSON.stringify($scope.addItems), function(data){
                console.log(data);
                data = JSON.parse(data);
                //console.log($scope.items);
                for (var i = 0; i<$scope.addItems.length; ++i){
                    $scope.items.push($scope.addItems[i])
                }
                $scope.addItems = [];
                document.getElementById("alert").innerHTML = "";
                console.log(data.item_count);
                if(data.status == 'item created'){
                    document.getElementById("alert").innerHTML = data.item_count + " item was successfully created. ";
                }
                if($scope.notAdded.length > 0){
                    document.getElementById("alert").innerHTML += "The following were not added because they existed previously in the database: ";
                    for (var i = 0; i<$scope.notAdded.length; ++i){
                        document.getElementById("alert").innerHTML += $scope.notAdded[i].name;
                    }
                    
                }
                document.getElementById("alert").hidden = false;
                jQuery("#alert").slideDown(200, function() {
                    //jQuery(this).alert('close');
                });
                jQuery("#alert").delay(5000).slideUp(200, function() {
                    //jQuery(this).alert('close');
                    //document.getElementById("alert").hidden = true;
                });
                //console.log($scope.items);
                $scope.$apply();
            })
        }
    });
</script>

</div>
@endsection
