
function NotificationCtrl($scope, $http){	
	$scope.auth=getAuth();
	this.init($scope);	
	//Grid,dropdown data loading
	loadGridData($scope.pagingOptions.pageSize,1);
	loadData('get_Users_list',{}).success(function(data){$scope.CountryList=data;});
	
	//CRUD operation
	$scope.saveItem=function(){	
		var record={};
		$scope.errors = {};
		$scope.sendtoError =false;
		$scope.titleError =false;
		$scope.descriptionError =false;
		if($scope.item==null || $scope.item=="" ){
            $scope.sendtoError = true;
            $scope.errors.sendtoMsg = 'Please select send to';
            return false;
        }
		if($scope.item.SendTo==null || $scope.item.SendTo=="" ){
            $scope.sendtoError = true;
            $scope.errors.sendtoMsg = 'Please select send to';
            return false;
		}
		if($scope.item.Title==null || $scope.item.Title=="" ){
            $scope.titleError = true;
            $scope.errors.titleMsg = 'Please enter title';
            return false;
		}
		if($scope.item.Description ==null || $scope.item.Description =="" ){
            $scope.descriptionError = true;
            $scope.errors.descriptionMsg = 'Please enter description';
            return false;
		}
		console.log($scope.item);
		angular.extend(record,$scope.item);
				//record.name=undefined;

		loadData('save',record).success(function(data){
			if(data.success){
				loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
				$.bootstrapGrowl('<h4>Success!</h4> <p>'+data.msg+'</p>', {
					type: 'success',
					delay: 2500,
					allow_dismiss: true
				});
				//toastr.success(data.msg);
				
			}else{
	            $.bootstrapGrowl('<h4>Warning!</h4> <p>'+data.msg+'</p>', {
	                type: 'warning',
	                delay: 2500,
	                allow_dismiss: true
	            });

			}
			$("#baseimagename").attr('src','');
			$scope.fgShowHide=true;			
			$scope.item=null;
		});
	};			
	$scope.editItem=function(row){	
		$scope.item=row;
		console.log(row);
		$scope.item.Country =row.CCountryId;
		$scope.item.State = null;
		$scope.item.Name = row.CName;
		loadData('get_State_list',{'id': row.CCountryId}).success(function(data){$scope.StateList=data; $scope.item.State =row.CStateId});
		loadData('get_District_list',{'cid': row.CCountryId,'sid': row.CStateId}).success(function(data){$scope.DistrictList=data; $scope.item.District =row.DistrictId});
		
		$scope.fgShowHide=false;				
	};
	$scope.getfilename=function(file){

 		var reader = new FileReader();
		reader.readAsDataURL(file.files[0]);
		reader.onload = function (e) {
			var data = e.target.result.replace(/^data:image\/\w+;base64,/, "");
			$scope.item.baseimage =  e.target.result;//data;
			$("#baseimagename").attr('src',e.target.result);
		}

	}
	$scope.deleteItem=function(row){
		console.log(row);
		if(confirm('Delete sure!')){
			var id = {'id':row};
			loadData('delete',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
		            $.bootstrapGrowl('<h4>Success!</h4> <p>Data removed successfully</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
		            });
			});
		}
	};
	$scope.changeItemStatus=function(row,status){
			var data = {'id':row,'status':status};
			loadData('changestatus',data).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
		            $.bootstrapGrowl('<h4>Success!</h4> <p>'+data.msg+'</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
		            });
			});
	};
	$scope.getStateList=function(){
		console.log($scope.item.Country);
			$scope.errors = {};
	
		if($scope.item.Country ==null || $scope.item.Country ==''){
			$scope.countryError = true;
			$scope.errors.countryMsg = 'Please select Country.';
			return false;
		}
	loadData('get_State_list',{'id': $scope.item.Country}).success(function(data){$scope.StateList=data; $scope.item.State =null});
	};
	$scope.getDistrictList=function(){
			$scope.errors = {};
	
		if($scope.item.Country ==null || $scope.item.Country ==''){
			$scope.countryError = true;
			$scope.errors.countryMsg = 'Please select Country.';
			return false;
		}
		if($scope.item.State ==null || $scope.item.State ==''){
			$scope.stateError = true;
			$scope.errors.stateMsg = 'Please select State.';
			return false;
		}
	loadData('get_District_list',{'cid': $scope.item.Country,'sid': $scope.item.State}).success(function(data){$scope.DistrictList=data; $scope.item.District =null});
	};
	
	//pager events
	
	$scope.setPage = function(page){
console.log(page);
		$scope.pagingOptions.currentPage=page + 1;
	 	loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
	}
	//search
	$scope.doSearch=function(){
		loadGridData($scope.pagingOptions.pageSize, 1);
	};
		$scope.arrayTwo = function(c, m){
	  var binary = [];
	  var current = c,
	        last = m,
	        delta = 2,
	        left = current - delta,
	        right = current + delta + 1,
	        range = [],
	        rangeWithDots = [],
	        l;

	    for (let i = 1; i <= last; i++) {
	        if (i == 1 || i == last || i >= left && i < right) {
	            range.push(i);
	        }
	    }

	    for (let i of range) {
	        if (l) {
	            if (i - l === 2) {
	                rangeWithDots.push(l + 1);
	            } else if (i - l !== 1) {
	                rangeWithDots.push('...');
	            }
	        }
	        rangeWithDots.push(i);
	        l = i;
	    }
    return rangeWithDots;
  }

	//Utility functions
	function isSearch(){
		if(!$scope.search) return false;
		for(var prop in $scope.search){
			if($scope.search.hasOwnProperty(prop) && $scope.search[prop]) return true;
		}
		return false;
	}
	function loadGridData(pageSize, currentPage){
		var action=isSearch()?'get_page_where':'get_page', params={size:pageSize, pageno:(currentPage-1)*pageSize};
		
//		angular.extend( params, $scope.search);
		params['search']=$scope.search;
		loadData(action,params).success(function(res){
			$scope.list=res.data;
		    $scope.totalpaging=Math.ceil(res.total/$scope.pagingOptions.pageSize);
//    console.log($scope.totalpaging);

			$scope.totalItems=res.total
		});
	}
	function loadData(action,data){
		return $http({
			  method: 'POST',
			  url: BASE_URL+'Notification_ctrl/'+action,
			  data: data,
			  headers: {'Content-Type': 'application/x-www-form-urlencoded'}			  
			});		
	}
	function getDate(source){		
		if(typeof source ==='string'){;
			var dt=source.split(' ')[0];
			return new Date(dt);
		}
		return source;
	}
	
}
 NotificationCtrl.prototype.init=function($scope){
	$scope.search=null;
	$scope.item={};
	$scope.list = null;
	$scope.fgShowHide=true;
	$scope.datatype = "Add"; 
	$scope.item.SendTo = ''
	
	$scope.searchDialog=false;
	$scope.DepartmentList=null;	
	
	this.configureGrid($scope);	
	this.searchPopup($scope);

 };
NotificationCtrl.prototype.configureGrid=function($scope){
	$scope.totalItems = 0;
    $scope.pagingOptions = {
        pageSizes: [10, 20, 30, 50, 100, 500, 1000],
        pageSize: 30,
        currentPage: 1
    };	
	

};
NotificationCtrl.prototype.searchPopup=function($scope){
	$scope.showForm=function(){$scope.fgShowHide=false; $scope.city=null;};

	$scope.hideForm=function(){$scope.fgShowHide=true; 	$scope.datatype = "Add";};
	$scope.openSearchDialog=function(){		
		$scope.searchDialog=true;
	};
	$scope.closeSearchDialog=function(){		
		$scope.searchDialog=false;
	};	
	$scope.refreshSearch=function(){$scope.search=null;};
	
};
