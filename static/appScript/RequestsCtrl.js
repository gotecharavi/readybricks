
function RequestsCtrl($scope, $http){	
	$scope.auth=getAuth();
	this.init($scope);	
function getParam( name )
{
 name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
 var regexS = "[\\?&]"+name+"=([^&#]*)";
 var regex = new RegExp( regexS );
 var results = regex.exec( window.location.href );
 if( results == null )
  return "";
else
 return results[1];
}


	//Grid,dropdown data loading
	loadGridData($scope.pagingOptions.pageSize,1);
	
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
	$scope.editItem=function(row){	
		console.log(row.entity);
		$scope.item=row;
		$scope.datatype='Edit';
		console.log($scope.item);
		$scope.fgShowHide=false;				
	};
	$scope.viewProfileDetail=function(name,type){	
		console.log(name,type);
		if(name !="" && name=='Manufacture'){
		$scope.fgShowHide=false;				
		$scope.viewProfileDetail =name;
		$scope.viewtype = type;

		// call API


			loadData('getUserById',{'UserId' : getParam( 'id' )}).success(function(row){
				console.log(row);
				$scope.item=row;
				$scope.MEmail=row.Email;
				$scope.MCompanyName=row.CompanyName;
				$scope.MobileNumber=row.MobileNumber;
				$scope.Address=row.Address;
				$scope.Landmark=row.Landmark;
				$scope.GSTIN=row.GSTIN;
				$scope.State=row.SName;
				$scope.Country=row.CName;
				$scope.VatNumber=row.VatNumber;
				$scope.UserId=row.UserId;
				$scope.fgShowHide = false;

			});
		}
		if(name !="" && name=='Transporter'){
			$scope.fgShowHide=false;				
			$scope.viewProfileDetail =name;
			$scope.viewtype = type;

			// call API


				loadData('getUserById',{'UserId' : getParam( 'id' ),'type':name}).success(function(row){
					console.log(row);
					$scope.item=row;
					$scope.MEmail=row.Email;
					$scope.MCompanyName=row.CompanyName;
					$scope.MobileNumber=row.MobileNumber;
					$scope.Address=row.Address;
					$scope.Landmark=row.Landmark;
					$scope.GSTIN=row.GSTIN;
					$scope.State=row.SName;
					$scope.Country=row.CName;
					$scope.VatNumber=row.VatNumber;
					$scope.UserId=row.UserId;
					$scope.fgShowHide = false;

				});
			}
			if(name !="" && name=='Product'){
				$scope.fgShowHide=false;				
				$scope.viewProfileDetail =name;
				$scope.viewtype = type;
		
				// call API
		
		
					loadData('getProductById',{'PId' : getParam( 'id' )}).success(function(row){
						console.log(row);
						$scope.item=row;
						$scope.PName=row.PName;
						$scope.PMinDeliveryDays=row.PMinDeliveryDays;
						$scope.PPrice=row.PPrice;
						$scope.CompanyName=row.CompanyName;
						$scope.PDescription=row.PDescription;
		
					});
				}
	}
	$scope.viewManufacturerItem=function(row){	
                       
		console.log(row);
		$scope.item = row;
		$scope.MEmail='djjkl';
		$scope.MCompanyName=row.CompanyName;
		// $scope.MobileNumber=row.MobileNumber;
		// $scope.Address=row.Address;
		// $scope.Landmark=row.Landmark;
		// $scope.GSTIN=row.GSTIN;
		// $scope.State=row.SName;
		// $scope.Country=row.CName;
		// $scope.VatNumber=row.VatNumber;
		// $scope.fgShowHide = false;
		$scope.viewProfileDetail = 'Manufacture';
	}

	$scope.viewProfileDetail(getParam( 'user' ),getParam( 'type' ));

	$scope.viewItem=function(row){	
		$scope.item = row;
		$scope.fgShowHide = false;
		$scope.viewProfileDetail = true;
	}
	$scope.rejectProduct=function(row){
		console.log($scope.item);
		console.log(row);
		$scope.item = $scope.item;
	}
	$scope.rejectSaveProduct=function(row){

			var id = {'data':row};
			loadData('rejectSaveProduct',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
		            $.bootstrapGrowl('<h4>Success!</h4> <p>Data rejected successfully</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
					});
					document.getElementById("openModalButton").click();
					
			});
			
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
	$scope.approve=function(row){
		// console.log($scope.item);
		// console.log(row);
		if(confirm('Sure!')){
			var id = {'id':$scope.item.UserId};
			loadData('approve',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
		            $.bootstrapGrowl('<h4>Success!</h4> <p>Data Approved successfully</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
		            });
			});
		}
	};
	$scope.approveProduct=function(row){
		if(confirm('Sure!')){
			var id = {'id':$scope.item.ProductId};
			loadData('approve_product',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
		            $.bootstrapGrowl('<h4>Success!</h4> <p>Data Approved successfully</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
		            });
			});
		}
	};
	// $scope.reject=function(row){
	// 	if(confirm('Sure!')){
	// 		var id = {'id':$scope.item.UserId};
	// 		loadData('reject',id).success(function(data){
	// 			loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
	// 	            $.bootstrapGrowl('<h4>Success!</h4> <p>Data Rejected successfully</p>', {
	// 	                type: 'info',
	// 	                delay: 2500,
	// 	                allow_dismiss: true
	// 	            });
	// 		});
	// 	}
	// };
	$scope.reject=function(row){
		console.log($scope.item);
		console.log(row);
		$scope.item = $scope.item;
	}
	$scope.rejectSave=function(row){

			var id = {'data':row};
			loadData('rejectSave',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
		            $.bootstrapGrowl('<h4>Success!</h4> <p>Data rejected successfully</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
					});
					
			});
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
			  url: BASE_URL+'Requests_ctrl/'+action,
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
 RequestsCtrl.prototype.init=function($scope){
	$scope.search=null;
	$scope.item=null;
	$scope.list = null;
	$scope.fgShowHide=true;
	$scope.showTab ='';
	
	$scope.searchDialog=false;
	$scope.DepartmentList=null;	
	
	this.configureGrid($scope);	
	this.searchPopup($scope);

 };
RequestsCtrl.prototype.configureGrid=function($scope){
	$scope.totalItems = 0;
    $scope.pagingOptions = {
        pageSizes: [10, 20, 30, 50, 100, 500, 1000],
        pageSize: 30,
        currentPage: 1
    };	


	

};
RequestsCtrl.prototype.searchPopup=function($scope){
	$scope.showForm=function(){$scope.fgShowHide=false; $scope.item=null;};
	
	$scope.hideForm=function(){$scope.fgShowHide=true;  $scope.datatype='Add';};
	$scope.openSearchDialog=function(){		
		$scope.searchDialog=true;
	};
	$scope.closeSearchDialog=function(){		
		$scope.searchDialog=false;
	};	
	$scope.refreshSearch=function(){$scope.search=null;};
	
};