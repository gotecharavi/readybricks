
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
				loadGridData($scope.pagingOptions.pageSize,1);
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
		$scope.isLoadingBar = true;
		$scope.fgShowHide=false;				
		$scope.viewProfileDetail =name;
		$scope.viewtype = type;

		// call API


			loadData('getUserById',{'UserId' : getParam( 'id' )}).success(function(row){
				console.log(row);
				var row1,row2;
				row1=row.trans1;
				row2=row.trans2;
				console.log(row2);
				$scope.item=row1;
				$scope.MEmail=row1.Email;
				$scope.MImage=row1.Image;
				$scope.MCompanyName=row1.CompanyName;
				$scope.MobileNumber=row1.MobileNumber;
				$scope.IsMobileNumberVerify=row1.IsMobileNumberVerify;
				$scope.Address=row1.Address;
				$scope.Landmark=row1.Landmark;
				$scope.GSTIN=row1.GSTIN;
				$scope.State=row1.SName;
				$scope.Reason=row1.Reason;
				$scope.Country=row1.CName;
				$scope.CityName=row1.CityName;
				$scope.VatNumber=row1.VatNumber;
				$scope.UserId=row1.UserId;

				$scope.MImage2=row2.Image;
				$scope.MEmail2=row2.Email;
				$scope.MCompanyName2=row2.CompanyName;
				$scope.MobileNumber2=row2.MobileNumber;
				$scope.IsMobileNumberVerify2=row2.IsMobileNumberVerify;
				$scope.Address2=row2.Address;
				$scope.Landmark2=row2.Landmark;
				$scope.GSTIN2=row2.GSTIN;
				$scope.State2=row2.SName;
				$scope.CityName2=row2.CityName;
				$scope.Reason2=row2.Reason;
				$scope.Country2=row2.CName;
				$scope.VatNumber2=row2.VatNumber;
				$scope.UserId2=row2.UserId;

				$scope.IsAccount=row1.IsAccount;
				$scope.fgShowHide = false;
				$scope.isLoadingBar = false;

			});
		}
		if(name !="" && name=='Transporter'){
			$scope.isLoadingBar = true;
			$scope.fgShowHide=false;				
			$scope.viewProfileDetail =name;
			$scope.viewtype = type;

			// call API


				loadData('getUserById',{'UserId' : getParam( 'id' ),'type':name}).success(function(row){
					console.log(row);
					row1=row.trans1;
					row2=row.trans2;
					$scope.item=row1;
					$scope.MEmail=row1.Email;
					$scope.MCompanyName=row1.CompanyName;
					$scope.MobileNumber=row1.MobileNumber;
					$scope.Address=row1.Address;
					$scope.CityName=row1.CityName;
					$scope.Landmark=row1.Landmark;
					$scope.GSTIN=row1.GSTIN;
					$scope.IsMobileNumberVerify=row1.IsMobileNumberVerify;

					$scope.State=row1.SName;
					$scope.Country=row1.CName;
					$scope.VatNumber=row1.VatNumber;
					$scope.UserId=row1.UserId;
					$scope.Reason=row1.Reason;

					$scope.MEmail2=row2.Email;
					$scope.MCompanyName2=row2.CompanyName;
					$scope.MobileNumber2=row2.MobileNumber;
					$scope.Address2=row2.Address;
					$scope.Landmark2=row2.Landmark;
					$scope.GSTIN2=row2.GSTIN;
					$scope.IsMobileNumberVerify2=row2.IsMobileNumberVerify;
					$scope.State2=row2.SName;
					$scope.Country2=row2.CName;
					$scope.CityName2=row2.CityName;
					$scope.VatNumber2=row2.VatNumber;
					$scope.UserId2=row2.UserId;
					$scope.Reason2=row2.Reason;


					$scope.isAccount=row1.isAccount;
					$scope.isLoadingBar = false;
					$scope.fgShowHide = false;

				});
			}
			if(name !="" && name=='Product'){
				$scope.isLoadingBar = true;
				$scope.fgShowHide=false;				
				$scope.viewProfileDetail =name;
				$scope.viewtype = type;
		
				// call API
		
		
					loadData('getProductById',{'PId' : getParam( 'id' )}).success(function(row){
						// console.log(row);
						row1=row.product_by_id;
						prow=row.product_by_pid;
						$scope.item=row1;
						$scope.PName=row1.PName;
						$scope.PImage=row1.PImage;
						$scope.PMinDeliveryDays=row1.PMinDeliveryDays;
						$scope.PPrice=row1.PPrice;
						$scope.CompanyName=row1.CompanyName;
						$scope.Reason=row1.Reason;
						$scope.IsAccount=row1.IsAccount;
						$scope.PDescription=row1.PDescription;
						
						$scope.PName2=prow.PName;
						$scope.PImage2=prow.PImage;
						$scope.PMinDeliveryDays2=prow.PMinDeliveryDays;
						$scope.PPrice2=prow.PPrice;
						$scope.CompanyName2=prow.CompanyName;
						$scope.Reason2=prow.Reason;
						$scope.IsAccount2=prow.IsAccount;
						$scope.PDescription2=prow.PDescription;
						$scope.isLoadingBar = false;
		
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
		// $scope.viewProfileDetail(getParam( 'user' ),getParam( 'type' ));
		$scope.item = $scope.item;
	}
	$scope.rejectSaveProduct=function(row){

			var id = {'data':row};
			loadData('rejectSaveProduct',id).success(function(data){
				console.log(data);
				loadGridData($scope.pagingOptions.pageSize,1);
		            $.bootstrapGrowl('<h4>Success!</h4> <p>Data rejected successfully</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
					});
					$scope.isAccount=2;
					$('.reject_product_cancel').hide();
					// $scope.viewProfileDetail=false;
					// $scope.fgShowHide=true;
					// $scope.fgShowHide = false;
					// $window.open('localhost/readybricks5/index.php/#/Requests');
					// $scope.viewProfileDetail(getParam( 'user' ),getParam( 'type' ));
					document.getElementById("openModalButton").click();
					// window.location.href="/#/Requests";
					
			});
			
	}
	
	$scope.deleteItem=function(row){

		if(confirm('Delete sure!')){
			var id = {'id':row};
			loadData('delete',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,1);
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
			var id = {'id':$scope.item.UserId,'role':$scope.item.Role,'viewtype': $scope.viewtype};
			loadData('approve',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,1);
				window.location=BASE_URL+"#/Requests";
				$scope.viewProfileDetail=false;
				$scope.fgShowHide=true;
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
			var id = {'id':$scope.item.ProductId,'viewtype': $scope.viewtype};
			loadData('approve_product',id).success(function(data){
				loadGridData($scope.pagingOptions.pageSize,1);
				window.location=BASE_URL+"#/Requests";
				$scope.viewProfileDetail=false;
					$scope.fgShowHide=true;
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
	// 			loadGridData($scope.pagingOptions.pageSize,1);
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
				loadGridData($scope.pagingOptions.pageSize,1);
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
				loadGridData($scope.pagingOptions.pageSize,1);
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
		loadGridData($scope.pagingOptions.pageSize,1);
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