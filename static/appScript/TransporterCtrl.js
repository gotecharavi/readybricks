
function TransporterCtrl($scope, $http){	
	$scope.auth=getAuth();
	this.init($scope);	
	
	//Grid,dropdown data loading
	loadGridData($scope.pagingOptions.pageSize,1);
	loadData('get_Country_list',{}).success(function(data){$scope.CountryList=data; $scope.item.Country=null;});
	
	//CRUD operation
	$scope.saveItem=function(){	
		var record={};
		$scope.errors = {};
		$scope.nameError =false;
		console.log($scope.item);
		if($scope.item==null || $scope.item=="" ){
            $scope.nameError = true;
            $scope.errors.nameMsg = 'Please enter type name.';
            return false;
        }
		if($scope.item.Name==null || $scope.item.Name=="" ){
            $scope.nameError = true;
            $scope.errors.nameMsg = 'Please enter type name.';
            return false;
        }
		angular.extend(record,$scope.item);
				//record.name=undefined;

		loadData('save',record).success(function(data){

            $.bootstrapGrowl('<h4>Success!</h4> <p>'+data.msg+'</p>', {
                type: 'success',
                delay: 2500,
                allow_dismiss: true
            });
			//toastr.success(data.msg);
			if(data.success){
				loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
				$scope.fgShowHide=true;			
				$scope.item=null;
			}
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

	$scope.getCityList=function(){
		console.log($scope.item.State);
		$scope.errors = {};
		if($scope.item.Country ==null || $scope.item.Country ==""){
            $scope.countryError = true;
            $scope.errors.countryMsg = 'Please select Country.';
            return false;
        }
		if($scope.item.State==null && $scope.item.State !=""){
            $scope.stateError = true;
            $scope.errors.stateMsg = 'Please select State.';
            return false;
        }
		loadData('get_City_list',{'cId': $scope.item.Country,'sId':$scope.item.State}).success(function(data){$scope.CityList=data; $scope.item.City=null});
	};		
	$scope.editItem=function(row){	
		console.log(row.entity);
		$scope.item=row;
		$scope.datatype='Edit';
		console.log($scope.item);
		$scope.item.Name=row.CompanyName;
		$scope.item.PhoneNo=row.MobileNumber;
		$scope.item.Country =row.CountryId;
		$scope.item.State = null;
		$scope.item.City = null;
		$scope.item.GstNo = row.GSTIN; 
		$scope.item.VatNo = row.VatNumber; 
		console.log($scope.item);
		loadData('get_State_list',{'id': row.CountryId}).success(function(data){$scope.StateList=data; $scope.item.State =row.StateId});
		loadData('get_City_list',{'cId': row.CountryId,'sId':row.StateId}).success(function(data){$scope.CityList=data; $scope.item.City=row.CityId});

		
		$scope.fgShowHide=false;				
	};
	$scope.viewItem=function(row){	
		$scope.item = row;
		$scope.fgShowHide = false;
		$scope.viewProfileDetail = true;
	}
	$scope.deleteItem=function(row){
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
	
	//pager events
	
	$scope.setPage = function(page){
		$scope.pagingOptions.currentPage=page;
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
			  url: BASE_URL+'Transporter_ctrl/'+action,
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
 TransporterCtrl.prototype.init=function($scope){
	$scope.search=null;
	$scope.item=null;
	$scope.list = null;
	$scope.fgShowHide=true;
	
	$scope.searchDialog=false;
	$scope.DepartmentList=null;	
	
	this.configureGrid($scope);	
	this.searchPopup($scope);

 };
TransporterCtrl.prototype.configureGrid=function($scope){
	$scope.totalItems = 0;
    $scope.pagingOptions = {
        pageSizes: [10, 20, 30, 50, 100, 500, 1000],
        pageSize: 30,
        currentPage: 1
    };	


	

};
TransporterCtrl.prototype.searchPopup=function($scope){
	$scope.showForm=function(){$scope.fgShowHide=false; $scope.item=null;};
	
	$scope.hideForm=function(){$scope.fgShowHide=true; $scope.viewProfileDetail = false; $scope.datatype='Add';};
	$scope.openSearchDialog=function(){		
		$scope.searchDialog=true;
	};
	$scope.closeSearchDialog=function(){		
		$scope.searchDialog=false;
	};	
	$scope.refreshSearch=function(){$scope.search=null;};
	
};