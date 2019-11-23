@extends('layouts.sidebar')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js">
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="app/Item.php" type="php"></script>
<!-- Modal -->

@section('content')
@inject('Item', 'App\Item')
@inject('UserController','App\Http\Controllers\UsersController')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div ng-app="admin" ng-controller="adminPanel">
<div class="modal fade" id="modifyAccModal" tabindex="-1" role="dialog" aria-labelledby="modifyAccModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyAccModalLabel">Modify Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <div class="modal-body">
                <form ng-submit = "modifyAcc()">
                    <div class="form-row">
                        <label for="accName">Name</label>
                        <input type="text" class="form-control" id="accName" required>
                    </div>
                    <div class="form-row">
                        <label for="accEmail">Email</label>
                        <input type="email" class="form-control" id="accEmail" required>
                    </div>
                    <div class="form-row">
                        <label for="accPhone">Phone Number</label>
                        <input type="text" class="form-control" id="accPhone" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input ng-modal = "accArcVal" ng-checked = "accArcVal" type="checkbox" class="form-check-input" id="accArchive">
                            <label class="form-check-label" for="accArchive">Archive Account?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <select ng-model="accPosVal">
                                <option ng-repeat="x in currentPos" value = "<%x.position%>"><%x.position%></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row" style="float:right">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modifyPosModal" tabindex="-1" role="dialog" aria-labelledby="modifyPosModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyPosModalLabel">Modify Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <div class="modal-body">
                <form ng-submit = "modifyPosSub()">
                    <div class="form-row">
                        <label for="posName">Position</label>
                        <input type="text" class="form-control" id="posName" required>
                    </div>
                    <div class="form-row">
                        <label for="posEmail">Email</label>
                        <input type="email" class="form-control" id="posEmail" required>
                    </div>
                    <div class="form-row">
                        <label for="posDesc">Description</label>
                        <input class="form-control" id="posDesc" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="posLowNotify">
                            <label class="form-check-label" for="posLowNotify">Send Low Notification?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                        <label for = "posPriviledge">Position Privilege</label>
                            <select ng-model="posPriviledgeVal" id = "posPriviledge" required>
                                <option ng-repeat="x in posPriviledges" value = "<%x.id%>"><%x.value%></option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="form-row" style="float:right">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="acceptAccModal" tabindex="-1" role="dialog" aria-labelledby="acceptAccLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptAccLabel">Accept Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <div class="modal-body">
                <form ng-submit = "acceptAccSub()">
                    <div class="form-row">
                        Are you sure you wanna accept ma man <span id = "acceptName"></span>
                    </div>
                    <div class="form-row" style="float:right">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rejectAccModal" tabindex="-1" role="dialog" aria-labelledby="rejectAccLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectAccLabel">Reject Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
            </div>
            <div class="modal-body">
                <form ng-submit = "rejectAccSub()">
                    <div class="form-row">
                        Are you sure you wanna reject ma man <span id = "rejectName"></span>
                    </div>
                    <div class="form-row" style="float:right">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-primary" role="alert" id ="alert" hidden>
</div>

<div class="alert alert-primary" role="alert" id ="alert2" hidden>
</div>
    <div class="row">
        <div class="col" style="text-align: center">
            <h2>Admin Panel</h2>
        </div>
    </div>
    <div class="row">
        <div class="col mx-md-5">
                <h5 class="text-center">Current Accounts</h5>
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Modify?</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="acct in allAcounts | filter :{current_member : 1}">
                        <tr>
                            <td><%acct.name%></td>
                            <td><%acct.phone%></td>
                            <td><%acct.email%></td>
                            <td><button class="btn btn-primary" ng-click="modifyCurrent(acct)">Modify</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mx-md-5">
                <h5 class="text-center">Past Accounts</h5>
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Modify?</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="acct in allAcounts | filter :{current_member : 0}">
                        <tr>
                            <td><%acct.name%></td>
                            <td><%acct.phone%></td>
                            <td><%acct.email%></td>
                            <td><button class="btn btn-primary" ng-click="modifyPast(acct)">Modify</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mx-md-5">
                <h5 class="text-center">Pending Accounts</h5>
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Accept?</th>
                            <th scope="col">Reject?</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="acct in allAcounts | filter :{current_member : null}">
                        <tr>
                            <td><%acct.name%></td>
                            <td><%acct.email%></td>
                            <td><button class="btn btn-primary" ng-click="acceptAcc(acct)">Accept</button></td>
                            <td><button class="btn btn-primary" ng-click="rejectAcc(acct)">Reject</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mx-md-5">
        <div class="row">
        <div class="col-9">
        <h5 class="text-center">Current Positions</h5>

        </div>
        <div class="col-3 my-2">
        <button class="text-right btn btn-primary" ng-click="addPos()">Add Position</button>

        </div>
        </div>
                
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Position</th>
                            <th scope = "col">Email</th>
                            <th scope="col">Privilege</th>
                            <th scope="col">Notify on Low?</th>
                            <th scope="col">Modify?</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="pos in currentPos">
                        <tr>
                            <td><%pos.position%></td>
                            <td><%pos.email%></td>
                            <td><%pos.privilege%></td>
                            <td><%pos.low_notify%></td>
                            <td><button class="btn btn-primary" ng-click="modifyPos(pos)">Modify</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var app = angular.module('admin',[], function($interpolateProvider){
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });
    app.controller('adminPanel', function($scope){

        jQuery(function() {
            $scope.allAcounts = [];
            $scope.currentPos = [];
            $scope.accNameVal = "";
            $scope.accPhoneVal = "";
            $scope.accEmailVal = "";
            $scope.accArcVal = false;
            $scope.currentMod = false;
            $scope.index = -1;
            $scope.posIdVal = -1;
            $scope.posNameVal = "";
            $scope.posEmailVal = "";
            $scope.posPriviledgeVal = "";
            $scope.posLowNotifyVal = "";
            $scope.posDescVal = "";
            $scope.posPriviledges =[
                {
                    id: 0,
                    value: "Only Dashboard"
                },
                {
                    id: 1,
                    value: "Make changes to Inventory"
                },
                {
                    id: 2,
                    value: "Admin Priviledges"
                },
                {
                    id: 3,
                    value: "Biggg Boi"
                }
            ];
            //Over here do get calls to get evrything from the admin pane
            $scope.getAccounts();
            $scope.getMemberPos();
        })

        $scope.getAccounts = function(){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText)
                    $scope.allAcounts = JSON.parse(this.responseText)
                    /*for (var i = 0; i<$scope.items.length; ++i){
                        if($scope.items[i].removed == true){
                            $scope.items.splice(i,1);
                            i-=1;
                        }
                    }
                    $scope.addItems = []*/
                    $scope.$apply()
                }
            };
            xhttp.open("GET", "users", true);
            xhttp.send();
        }

        $scope.getMemberPos = function(){
            var xhttp2 = new XMLHttpRequest();
            xhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText)
                    $scope.currentPos = JSON.parse(this.responseText)
                    /*for (var i = 0; i<$scope.items.length; ++i){
                        if($scope.items[i].removed == true){
                            $scope.items.splice(i,1);
                            i-=1;
                        }
                    }
                    $scope.addItems = []*/
                    $scope.$apply()
                }
            };
            xhttp2.open("GET", "member_position", true);
            xhttp2.send();
        }
        $scope.modifyCurrent = function(account){
            $scope.index = account.id;
            document.getElementById("accName").value = account.name;
            document.getElementById("accPhone").value = account.phone;
            document.getElementById("accEmail").value = account.email;
            $scope.accPosVal = account.position;
            $scope.accArcVal = false;
            $('#modifyAccModal').modal('show');
        }

        $scope.modifyPast = function(account){
            $scope.index = account.id;
            $scope.accNameVal = account.name;
            $scope.accPhoneVal = account.phone;
            $scope.accEmailVal = account.email;
            $scope.accPosVal = "";
            $scope.accArcVal = true;
            $('#modifyAccModal').modal('show');
        }

        $scope.modifyAcc = function(){
            $('#modifyAccModal').modal('hide');
            account = {id:$scope.index, name:document.getElementById("accName").value, phone: document.getElementById("accPhone").value, email: document.getElementById("accEmail").value, current_member:true,position_id: 1};
            console.log(account);
            url = 'users/' + account.id.toString();
            jQuery.ajax({
                url: url,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(account),
                //data: JSON.stringify($scope.modifyItems),
                success: function(data) {
                    // handle success
                    console.log(data);
                    $scope.getAccounts();
                },
                error: function(request,msg,error) {
                    // handle failure
                    console.log(request);
                    console.log(msg);
                    console.log(error);
                }
            });
        }

        $scope.acceptAcc = function(account){
            $scope.index = account.id;
            document.getElementById("acceptName").innerHTML =  ":\t" + account.name;
            $('#acceptAccModal').modal('show');
        }

        $scope.acceptAccSub = function(){
            $('#acceptAccModal').modal('hide');
            var currAcct = $scope.allAcounts[0];
            for(var i = 0; i<$scope.allAcounts.length; ++i){
                currAcct = $scope.allAcounts[i];
                if(currAcct.id == $scope.index) break;
            }
            currAcct.current_member = 1;
            currAcct.position_id = 1;
            url = 'users/' + currAcct.id.toString();
            //account = {id:$scope.index, name:document.getElementById("accName").value, phone: document.getElementById("accPhone").value, email: document.getElementById("accEmail").value, current_member:true,position_id: 1};
            console.log(currAcct);
            jQuery.ajax({
                url: url,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(currAcct),
                //data: JSON.stringify($scope.modifyItems),
                success: function(data) {
                    // handle success
                    console.log(data);
                    $scope.getAccounts();
                    document.getElementById("alert").innerHTML =  currAcct.name + " was successfully accepted. ";
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

        $scope.rejectAcc = function(account){
            $scope.index = account.id;
            document.getElementById("rejectName").innerHTML =  ":\t" + account.name;
            $('#rejectAccModal').modal('show');
        }

        $scope.rejectAccSub = function(){
            $('#rejectAccModal').modal('hide');
            var currAcct = $scope.allAcounts[0];
            for(var i = 0; i<$scope.allAcounts.length; ++i){
                currAcct = $scope.allAcounts[i];
                if(currAcct.id == $scope.index) break;
            }
            currAcct.current_member = 1;
            currAcct.position_id = 1;
            url = 'users/' + currAcct.id.toString();
            //account = {id:$scope.index, name:document.getElementById("accName").value, phone: document.getElementById("accPhone").value, email: document.getElementById("accEmail").value, current_member:true,position_id: 1};
            console.log(currAcct);
            jQuery.ajax({
                url: url,
                method: 'DELETE',
                contentType: 'application/json',
                data: JSON.stringify(currAcct),
                //data: JSON.stringify($scope.modifyItems),
                success: function(data) {
                    // handle success
                    console.log(data);
                    $scope.getAccounts();
                    document.getElementById("alert").innerHTML =  currAcct.name + " was successfully rejected. ";
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

        $scope.addPos = function(){
            document.getElementById("posName").value = "";
            $scope.posIdVal = -1;
            //$scope.posNameVal = pos.position;
            document.getElementById("posEmail").value = "";
            document.getElementById("posLowNotify").checked = false;
            $scope.posPriviledgeVal = '0';
            
            document.getElementById("posDesc").value = "";
            $('#modifyPosModal').modal('show');
        }

        $scope.modifyPos = function(pos){
            document.getElementById("posName").value = pos.position;
            $scope.posIdVal = pos.id;
            document.getElementById("posEmail").value = pos.email;
            $scope.posPriviledgeVal = pos.privilege;
            document.getElementById("posLowNotify").checked = true;
            if(pos.low_notify == '0' || pos.low_notify == 0 || pos.low_notify == false){
                document.getElementById("posLowNotify").checked = false;
            }
            document.getElementById("posDesc").value = pos.description;
            $('#modifyPosModal').modal('show');
        }

        $scope.addPosSub = function(){
            position = {position: document.getElementById("posName").value, email: document.getElementById("posEmail").value, description: document.getElementById("posDesc").value, privilege: $scope.posPriviledgeVal, low_notify: document.getElementById("posLowNotify").checked}
            console.log(position)
            url = 
            jQuery.ajax({
                url: url,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(position),
                success: function(data) {
                    // handle success
                    console.log(data);
                    $scope.getMemberPos();
                },
                error: function(request,msg,error) {
                    // handle failure
                    console.log(request);
                    console.log(msg);
                    console.log(error);
                }
            });
        }
        
        $scope.modifyPosSub = function(){
            $('#modifyPosModal').modal('hide');
            if($scope.posIdVal == -1){
                $scope.addPosSub();
                return;
            }
            position = {id:$scope.posIdVal, position: document.getElementById("posName").value, email: document.getElementById("posEmail").value, description: document.getElementById("posDesc").value, privilege: $scope.posPriviledgeVal, low_notify: document.getElementById("posLowNotify").checked}
            
            console.log(position)
            url = 'member_position/' + position.id.toString();
            jQuery.ajax({
                url: url,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(position),
                success: function(data) {
                    // handle success
                    console.log(data);
                    $scope.getMemberPos();
                },
                error: function(request,msg,error) {
                    // handle failure
                    console.log(request);
                    console.log(msg);
                    console.log(error);
                }
            });
        }
    })
</script>
@endsection
