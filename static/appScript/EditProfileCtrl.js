
function EditProfileCtrl($scope, $http){	
	$scope.auth=getAuth();
	console.log($scope.auth.cview);
	this.init($scope);	
	if($scope.auth.cview =='editprofileview'){
	//Grid,dropdown data loading
		loadGridData($scope.pagingOptions.pageSize,1);
	}
	if($scope.auth.cview=='editprofile' || $scope.auth.cview=='editprofiledetailview'){
		$scope.item=$scope.auth.editdata;
		console.log($scope.item);
		$scope.item.MobileNo=parseInt($scope.auth.editdata.MobileNo);
		$scope.item.CPassword=$scope.auth.editdata.Password;
		$scope.item.TelNo=parseInt($scope.auth.editdata.TelNo);
		console.log($scope.item);
		$scope.fgShowHide=false;				
	}
	//CRUD operation
	$scope.saveItem=function(){	
		var record={};
		$scope.errors = {};
		$scope.FirstNameError =false;
		$scope.addressError =false;

		$scope.emailError =false;
		$scope.passwordError =false;
		$scope.cpasswordError =false;
		$scope.cpersonError =false;
		$scope.cregnoError =false;
		$scope.mobilenoError =false;
		$scope.paccountError =false;
		console.log('223332');
		console.log($scope.item);
		if($scope.item==null || $scope.item=="" ){
			console.log('212121');
            $scope.FirstNameError = true;
            $scope.errors.FirstNameMsg = 'Please enter first name.';
            return false;
        }
		if($scope.item.FirstName==null || $scope.item.FirstName=="" ){
            $scope.FirstNameError = true;
            $scope.errors.FirstNameMsg = 'Please enter first name.';
            return false;
        }
		if($scope.item.Email==null || $scope.item.Email=="" ){
            $scope.emailError = true;
            $scope.errors.emailMsg = 'Please enter email address.';
            return false;
        }
		if($scope.item.Password==null || $scope.item.Password=="" ){
            $scope.passwordError = true;
            $scope.errors.passwordMsg = 'Please enter password.';
            return false;
        }
		if($scope.item.CPassword==null || $scope.item.CPassword=="" ){
            $scope.cpasswordError = true;
            $scope.errors.cpasswordMsg = 'Please enter confirm password.';
            return false;
        }
		if($scope.item.CPassword != $scope.item.Password ){
            $scope.cpasswordError = true;
            $scope.errors.cpasswordMsg = 'Password not match.';
            return false;
        }

		angular.extend(record,$scope.item);

		loadData('save',record).success(function(data){
			if($scope.auth.cview == 'editprofile'){
				$scope.item=data.editdata;
				$scope.item.CPassword=data.editdata.Password;
			}else{
				$scope.item={};

			}
			if(data.success == true){
	            $.bootstrapGrowl('<h4>Success!</h4> <p>'+data.msg+'</p>', {
	                type: 'info',
	                delay: 2500,
	                allow_dismiss: true
	            });

			}			
			else{
	            $.bootstrapGrowl('<h4>Success!</h4> <p>'+data.msg+'</p>', {
	                type: 'warning ',
	                delay: 2500,
	                allow_dismiss: true
	            });

			
			}			
		});
	};			
	$scope.editItem=function(row){	
		$scope.item=row;
		$scope.itemtitle = "Edit";
		$scope.fgShowHide=false;				
	};
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
	$scope.getfilename=function(file){

 		var reader = new FileReader();
		reader.readAsDataURL(file.files[0]);
		reader.onload = function (e) {
			var data = e.target.result.replace(/^data:image\/\w+;base64,/, "");
			$scope.item.baseimage =  e.target.result;//data;
			$("#baseimagename").attr('src',e.target.result);
		}

	}
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
	$scope.setPage = function(page){

		$scope.pagingOptions.currentPage=page + 1;
	 	loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
	}
	//pager events
	// $scope.$watch('pagingOptions', function (newVal, oldVal) {
	// 	if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {		  
	// 	  loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
	// 	}
	// 	else if (newVal !== oldVal && newVal.pageSize !== oldVal.pageSize) {		  
	// 	  loadGridData($scope.pagingOptions.pageSize, 1);
	// 	}
	// }, true);
	
	//search
	$scope.doSearch=function(){
		loadGridData($scope.pagingOptions.pageSize, 1);
	};
	
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
			console.log($scope.totalpaging);
			$scope.totalItems=res.total
		});
	}
	function loadData(action,data){
		return $http({
			  method: 'POST',
			  url: BASE_URL+'EditProfile_ctrl/'+action,
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
 EditProfileCtrl.prototype.init=function($scope){
	$scope.search=null;
	$scope.item=null;
	$scope.list = null;
	$scope.itemtitle = "Add";
	$scope.fgShowHide=true;
	$scope.searchDialog=false;
	$scope.DepartmentList=null;	

	this.configureGrid($scope);	
	this.searchPopup($scope);
 };
EditProfileCtrl.prototype.configureGrid=function($scope){
	$scope.totalItems = 0;
    $scope.pagingOptions = {
        pageSizes: [10, 20, 30, 50, 100, 500, 1000],
        pageSize: 5,
        currentPage: 1
    };	

};
EditProfileCtrl.prototype.searchPopup=function($scope){
	$scope.showForm=function(){$scope.fgShowHide=false; $scope.item=null;}; 
	$scope.hideForm=function(){$scope.fgShowHide=true;};
	$scope.openSearchDialog=function(){		
		$scope.searchDialog=true;
	};
	$scope.closeSearchDialog=function(){		
		$scope.searchDialog=false;
	};	
	$scope.refreshSearch=function(){$scope.search=null;};
	
};