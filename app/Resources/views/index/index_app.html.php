<!doctype html>
<html ng-app="shortenerApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URL Shortener</title>
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
    <!-- placed at end of the body behave unexpectedly, sometimes ignores one of the files -->
    <script src="app/shortenerApp.module.js"></script>
    <script src="app/Controller/IndexController.js"></script>
</head>
<body ng-controller="IndexController as base">
<div class="container">
    <h1>URL Shortener</h1>
    <form name="mainForm" ng-submit="base.submit()" novalidate>
        <div class="input-group">
            <input id="url-field" type="text" ng-model="base.full_url" class="txtfield input" name="full_url">
            <button class="btn btn-submit" type="submit">SHORTEN</button>
        </div>
        <h2>Want to choose short url by yourself?</h2>
        <div class="input-group">
            <input id="encoded-field" ng-model="base.encoded" type="text" class="txtfield-short input" name="encoded">
        </div>
        <div id="link">
            <a ng-if="base.link" href="{{base.link}}">{{base.link}}</a>
            <div ng-repeat="error in base.errors">
                <p>{{error}}</p>
            </div>
        </div>
    </form>
</div>
</body>
</html>