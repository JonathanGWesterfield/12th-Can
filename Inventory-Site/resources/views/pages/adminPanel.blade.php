@extends('layouts.sidebar')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js">
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="app/Item.php" type="php"></script>
<!-- Modal -->

@section('content')
@inject('Item', 'App\Item')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div ng-app="admin" ng-controller="adminPanel">
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
                    <tbody ng-repeat="acct in currentAcc">
                        <tr>
                            <td><%acct.name%></td>
                            <td><%acct.phone%></td>
                            <td><%acct.email%></td>
                            <td><button class="btn btn-primary" ng-click="modifyCurrent($index)">Modify</button></td>
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
                    <tbody ng-repeat="acct in pastAcc">
                        <tr>
                            <td><%acct.name%></td>
                            <td><%acct.phone%></td>
                            <td><%acct.email%></td>
                            <td><button class="btn btn-primary" ng-click="modifyPast($index)">Modify</button></td>
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
                    <tbody ng-repeat="acct in pendingAcc">
                        <tr>
                            <td><%acct.name%></td>
                            <td><%acct.email%></td>
                            <td><button class="btn btn-primary" ng-click="acceptAcc($index)">Accept</button></td>
                            <td><button class="btn btn-primary" ng-click="rejectAcc($index)">Reject</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mx-md-5">
                <h5 class="text-center">Current Possitions</h5>
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Possition</th>
                            <th scope="col">Admin Access?</th>
                            <th scope="col">Description</th>
                            <th scope="col">Modify?</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="pos in currentPos">
                        <tr>
                            <td><%pos.position%></td>
                            <td><%pos.access%></td>
                            <td><%pos.description%></td>
                            <td><button class="btn btn-primary" ng-click="modifyPos($index)">Modify</button></td>
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
            $scope.currentAcc = [];
            $scope.pastAcc = [];
            $scope.pendingAcc = [];
            $scope.currentPos = [];

            //Over here do get calls to get evrything from the admin panel
            //Adding random values to showcase evrything rn
            $scope.currentAcc = [
            {
                'name': 'Mike',
                'phone': '(123)-456-7890',
                'email': 'abc@mail.com'
            },
            {
                'name': 'Mike2',
                'phone': '(122)-456-7890',
                'email': 'abcd@mail.com'
            },
            {
                'name': 'Mike3',
                'phone': '(124)-456-7890',
                'email': 'abce@mail.com'
            },
            {
                'name': 'Mike4',
                'phone': '(125)-456-7890',
                'email': 'abcf@mail.com'
            }]

            $scope.pastAcc = [
            {
                'name': 'Mike',
                'phone': '(123)-456-7890',
                'email': 'abc@mail.com'
            },
            {
                'name': 'Mike2',
                'phone': '(122)-456-7890',
                'email': 'abcd@mail.com'
            },
            {
                'name': 'Mike3',
                'phone': '(124)-456-7890',
                'email': 'abce@mail.com'
            },
            {
                'name': 'Mike4',
                'phone': '(125)-456-7890',
                'email': 'abcf@mail.com'
            }]
            $scope.pendingAcc = [
            {
                'name': 'Mike',
                'phone': '(123)-456-7890',
                'email': 'abc@mail.com'
            },
            {
                'name': 'Mike2',
                'phone': '(122)-456-7890',
                'email': 'abcd@mail.com'
            },
            {
                'name': 'Mike3',
                'phone': '(124)-456-7890',
                'email': 'abce@mail.com'
            },
            {
                'name': 'Mike4',
                'phone': '(125)-456-7890',
                'email': 'abcf@mail.com'
            }]
            $scope.currentPos = [
            {
                'position': 'Exec',
                'access': true,
                'description': 'The big boiz'
            },
            {
                'position': 'Assistant',
                'access': true,
                'description': 'The big boiz\'s bitches'
            },
            {
                'position': 'Finance',
                'access': false,
                'description': '$$$$'
            },
            {
                'position': 'PR',
                'access': true,
                'description': 'Market this Can'
            }]
            $scope.$apply();

        })
        $scope.modifyCurrent = function(index){

        }

        $scope.modifyPast = function(index){

        }

        $scope.acceptAcc = function(index){

        }

        $scope.rejectAcc = function(index){

        }

        $scope.modifyPos = function(index){
            
        }
    })
</script>
@endsection
