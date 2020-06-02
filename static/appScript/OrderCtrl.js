
function OrderCtrl($scope, $http,$location){	
	$scope.auth=getAuth();
	this.init($scope);	
	var url = window.location.href; 

	loadData('get_all_user',{}).success(function(data){$scope.UserList=data;});

	loadGridData($scope.pagingOptions.pageSize,1);

	//CRUD operation
	$scope.saveItem=function(){	
		var record={};
		$scope.errors = {};
		$scope.categoryError =false;
		$scope.nameError =false;
		$scope.infoError =false;
		$scope.priceError =false;
		if($scope.item==null || $scope.item=="" ){
            $scope.categoryError = true;
            $scope.errors.categoryMsg = 'Please select category.';
            return false;
        }
		if($scope.item.ParentCatId==null || $scope.item.ParentCatId=="" ){
            $scope.categoryError = true;
            $scope.errors.categoryMsg = 'Please select category.';
            return false;
        }
		if($scope.item.Name==null || $scope.item.Name=="" ){
            $scope.nameError = true;
            $scope.errors.nameMsg = 'Please enter name.';
            return false;
        }
		if($scope.item.Price==null || $scope.item.Price=="" ){
            $scope.priceError = true;
            $scope.errors.priceMsg = 'Please enter price.';
            return false;
        }
		angular.extend(record,$scope.item);

		loadData('save',record).success(function(data){
	            $.bootstrapGrowl('<h4>Success!</h4> <p>'+data.msg+'</p>', {
	                type: 'info',
	                delay: 2500,
	                allow_dismiss: true
	            });
			if(data.success){
				loadGridData($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);
			}			
			$scope.fgShowHide=true;
			$("#baseimagename").attr('src','');
		});
	};			
	$scope.editItem=function(row){	
		$scope.item=row;
		$scope.itemtitle = "Edit";
		$scope.fgShowHide=false;				
		$("#baseimagename").attr('src','uploads/menu/'+row.Image);
	};
//	$("#main-menu").addClass('menu-layout-mini');
	$scope.viewItem=function(row){	
		console.log(row);
		$scope.item = row;
		$scope.order_id=row.OId;
		$scope.order_date=row.Created_At;
		$scope.product_array=row.product_array;
		$scope.total=row.OTotal;
		$scope.subtotal=row.OTotal;
		$scope.MName=row.product_array[0].merchant.CompanyName;
		$scope.MEmail=row.product_array[0].merchant.Email;
		$scope.MMobileNumber=row.product_array[0].merchant.MMobileNumber;
		// $scope.=row.;
		// $scope.=row.;
		// $scope.=row.;
		// $scope.=row.;
		// $scope.=row.;

		$scope
		$scope.fgShowHide = false;
		$scope.viewOrderDetail = true;
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

	$scope.getOrderByName=function(userid){

		for($i=0;$i<$scope.UserList.length;$i++){
				if($scope.UserList[$i].UserId == userid){
					return $scope.UserList[$i].FirstName +' '+$scope.UserList[$i].LastName;
				}

		}

	}
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

		$scope.pagingOptions.currentPage=parseInt(page) + 1;
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
console.log(window.location.href.indexOf('orderid'));
		if(window.location.href.indexOf('orderid') > -1){
			$scope.search = url.split('=').pop();
		}
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
			  url: BASE_URL+'Order_ctrl/'+action,
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
 OrderCtrl.prototype.init=function($scope){
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
OrderCtrl.prototype.configureGrid=function($scope){
	$scope.totalItems = 0;
    $scope.pagingOptions = {
        pageSizes: [10, 20, 30, 50, 100, 500, 1000],
        pageSize: 30,
        currentPage: 1
    };	

};
OrderCtrl.prototype.searchPopup=function($scope){
	$scope.showForm=function(){$scope.fgShowHide=false; $scope.item=null;}; 
	$scope.hideForm=function(){$scope.fgShowHide=true; $scope.viewOrderDetail = false;};
	$scope.openSearchDialog=function(){		
		$scope.searchDialog=true;
	};
	$scope.closeSearchDialog=function(){		
		$scope.searchDialog=false;
	};	
	$scope.refreshSearch=function(){$scope.search=null;};
	
};