<div class="alert alert-danger" ng-show="show">
    <div ng-show="messages.length <= 1">
        {{messages[0]}}
    </div>
    <div ng-show="messages.length > 1">
        <ul>
            <li ng-repeat="message in messages">{{message}}</li>
        </ul>
    </div>
</div>