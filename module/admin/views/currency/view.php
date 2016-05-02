<div class="admin-default-index">
<?php 
$this->registerJsFile('/js/angular.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

Yii::$app->getAssetManager()->publish('@app/module/admin/assets');

?>
<?php use yii\helpers\Url;?>
<a href="<?php echo Url::toRoute('default/index');?>">Список</a><br/>
<a href="<?php echo Url::toRoute('currency/index');?>">Список валют</a><br/>
<?php 
use yii\grid\GridView;
use yii\widgets\DetailView;
echo "<h1>Валюта</h1>";

echo DetailView::widget([
    'model' => $currency,
    'attributes' => [
        'id',
        'cbr_id',
        'cbr_numcode',
        'cbr_charcode',
        'name'
    ],
]);

echo "<h1>История валюты</h1>";

// echo GridView::widget([
//         'dataProvider' => $dataProvider,
//         'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],
 
//             'currency_nominal',
//             'currency_value',
//             [
//                 'attribute' => 'update',
//                 'format' =>  ['date', 'php:d-m-Y'],
//                 'options' => ['width' => '200']
//             ],
            
//         ],
//     ]); 

?>
</div>

<script type="text/javascript" src="/js/angular.min.js"></script>
<script type="text/javascript" src="js/ng-table.min.js"></script>
<script type="text/javascript">
(function(){
    var app = angular.module('graphApp',['ngTable']);
    app.controller('graphController', function($scope, $http)
    {
        $scope.width = 600;
        $scope.height = 400;
        $scope.yAxis = "Курс";
        $scope.xAxis = "Дата";
        $scope.max = 0;
        $scope.startDate = '2015/02/01';
        $scope.endDate = '2016/06/01';
        $http(
          {
            method: 'GET', 
           url: "<?php  echo Url::to(
                [
                    'currency/graphic', 
                    'id' => $currency->id, 
           ]);?>",
            params:{start : $scope.startDate, end : $scope.endDate}
        }
        ).success(function(data)
        {
            var result = new Array;
            $.each(data, function(index, value){
                var item = {label: value.update, value: value.currency_value};
                result.push(item);
            });
            $scope.max = 100;
            $scope.data = result;

        });

         $scope.changedDates = function() {
             $http(
                     {
                       method: 'GET', 
                      url: "<?php  echo Url::to(
                           [
                               'currency/graphic', 
                               'id' => $currency->id, 
                      ]);?>",
                       params:{start : $scope.startDate, end : $scope.endDate}
                   }
                   ).success(function(data)
                   {
                       var result = new Array;
                       $.each(data, function(index, value){
                           var item = {label: value.update, value: value.currency_value};
                           result.push(item);
                       });
                       $scope.max = 100;
                       $scope.data = result;

                   });
         }
      });


      app.controller("historyCtrl", function($scope, $http, $filter, ngTableParams) {

         $scope.history = [];


         $scope.historyTable = new ngTableParams({
             page: 1,
             count: 10
         }, {
             total: $scope.history.length, 
             getData: function ($defer, params) {

            	 $http(
              	          {
              	            method: 'GET', 
              	           url: "<?php  echo Url::to(
              	                [
              	                    'currency/history', 
              	                    'id' => $currency->id, 
              	           ]);?>",
              	            params:{page : params.page(), countperpage : params.count()}
              	        }
              	        ).success(function(data)
              	        {
              	            var result = new Array;
              	            $.each(data.history, function(index, value){
              	                var item = {update: value.update, value: value.currency_value};
              	                result.push(item);
              	            });
              	              $scope.history = result;
                	          params.total(data.total);
                	          $scope.data = $scope.history;
                              $defer.resolve($scope.data);
              	        });
	        
         
             }
         });
         

    	 
    	
     

      $scope.$watch("filter.$", function () {
          $scope.tableParams.reload();
      });

      
    	});
})();
</script>
<style>
.chart {
  border-left: 1px solid black;
  border-bottom: 1px solid black;
  margin: 60px auto;
  position: relative;
}

.y {
  position: absolute;
  transform: rotate(-90deg);
  transform-origin: bottom left;
  bottom: 0;
  padding: 5px;
}

.x {
  position: absolute;
  top: 100%;
  width: 100%;
  padding: 5px;
}
.bar {
  background: blue;
  position: absolute;
  bottom: 0;
}

svg {
  position: absolute;
  transform: rotateX(180deg);
  left: 0;    
}

line  {
  stroke:red;
  stroke-width:3px;
}
.dot {
  background: blue;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  position: absolute;
}


</style>
<style>
table, th , td {
  border: 1px solid grey;
  border-collapse: collapse;
  padding: 5px;
}
table tr:nth-child(odd) {
  background-color: #f1f1f1;
}
table tr:nth-child(even) {
  background-color: #ffffff;
}
</style>



<div ng-app="graphApp">
  <div ng-controller="graphController as graph">
     <input type="text" ng-model="startDate" class="startDate" ng-change="changedDates()" "\>
     <input type="text" ng-model="endDate" class="endDate" ng-change="changedDates()" "\>
     <div class="chart" style="width:{{width}}px; height:{{height}}px;">
        <!-- Метки -->
        <div class="y" style="width:{{height}}px;">{{yAxis}}</div>
        <div class="x">{{xAxis}}</div>
        <!-- Данные -->
       <div ng-repeat="dot in data" class="dot" style="bottom:{{dot.value / max * height}}px; left:{{($index + 0.5) / data.length * width}}px;">
       </div>
    </div>
  </div>
  <div  ng-controller="historyCtrl"> 
      <table ng-table="historyTable" class="table table-striped">
        <tr ng-repeat="item in history">
            <td data-title="'Дата'" >
                {{item.update}}
            </td>
            <td data-title="'Значение'" >
                {{item.value}}
            </td>
        </tr>
      </table>
   </div>
  </div>

    