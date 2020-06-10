angular.module('project', ['ui.bootstrap', 'ngGrid', 'jQuery-ui','ui.utils']).
  config(function($routeProvider) {
    $routeProvider.
      when('/', { templateUrl:BASE_URL+'home_ctrl'}).
      		
		when('/Navigations', { templateUrl:BASE_URL+'Navigations_ctrl'}).
		when('/NavigViewRight', { templateUrl:BASE_URL+'NavigViewRight_ctrl'}).
		when('/Roles', { templateUrl:BASE_URL+'Roles_ctrl'}).		
    when('/Users', { templateUrl:BASE_URL+'Users_ctrl'}).
    when('/Staff', { templateUrl:BASE_URL+'Staff_ctrl'}).
    when('/Category', { templateUrl:BASE_URL+'Category_ctrl'}).   
    when('/Store', { templateUrl:BASE_URL+'Store_ctrl'}).   
    when('/Menu', { templateUrl:BASE_URL+'Menu_ctrl'}).   
    when('/Order', { templateUrl:BASE_URL+'Order_ctrl'}).   
    when('/Maintenance', { templateUrl:BASE_URL+'Maintenance_ctrl'}).   
    when('/Models', { templateUrl:BASE_URL+'Models_ctrl'}).   
    when('/Pump', { templateUrl:BASE_URL+'Pump_ctrl'}).   
    when('/Customer', { templateUrl:BASE_URL+'Customer_ctrl'}).   
    when('/Manufacture', { templateUrl:BASE_URL+'Manufacture_ctrl'}).   
    when('/Transporter', { templateUrl:BASE_URL+'Transporter_ctrl'}).   
    when('/Vehicle', { templateUrl:BASE_URL+'Vehicle_ctrl'}).   
    when('/Driver', { templateUrl:BASE_URL+'Driver_ctrl'}).   
    when('/Country', { templateUrl:BASE_URL+'Country_ctrl'}). 
    when('/State', { templateUrl:BASE_URL+'State_ctrl'}).   
    when('/City', { templateUrl:BASE_URL+'City_ctrl'}).   
    when('/Products', { templateUrl:BASE_URL+'Product_ctrl'}).   
    when('/Stock', { templateUrl:BASE_URL+'Stock_ctrl'}).   
    when('/Requests', { templateUrl:BASE_URL+'Requests_ctrl'}).   
    when('/editprofile', { templateUrl:BASE_URL+'EditProfile_ctrl'}).
    when('/viewRequestProfile', { templateUrl:BASE_URL+'Requests_ctrl'}).   
    when('/viewItemOrder', { templateUrl:BASE_URL+'Order_ctrl'}).   
    when('/viewOrderDetail', { templateUrl:BASE_URL+'Order_ctrl'}).   

    when('/api', { templateUrl:BASE_URL+'Api'}).   

      otherwise({redirectTo:'/'});
  }).directive('fileReader', function() {
      console.log('122222222222');
          return {
            scope: {
              fileReader:"="
            },
            link: function(scope, element) {
              $(element).on('change', function(changeEvent) {
                var files = changeEvent.target.files;
                if (files.length) {
                  var r = new FileReader();
                  r.onload = function(e) {
                      var contents = e.target.result;
                      scope.$apply(function () {
                        scope.fileReader = contents;
                        scope.testing = contents;
                      });
                  };
                  
                  r.readAsText(files[0]);
                }
              });
            }
          };
      });