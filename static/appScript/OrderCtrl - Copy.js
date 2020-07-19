
function OrderCtrl($scope, $http,$location){	
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

	var url = window.location.href; 




	if(getParam('type')=='OrderItem'){
		$scope.fgShowHide = false;
		$scope.viewOrderItem = true;
		$scope.viewOrderDetail = false;
		loadGridData($scope.pagingOptions.pageSize,1);
	}else if(getParam('type')=='OrderDetail'){
		$scope.fgShowHide = false;
		$scope.viewOrderItem = false;
		$scope.viewOrderDetail = true;
		loadData('get_order_detail',{id:getParam('id')}).success(function(data){
			console.log(data);
			$scope.OrderDetail=data.data;
			$scope.CustomerDetail=data.customer;
			$scope.ManufactuerDetail=data.manufactur;
			$scope.TransporterDetail=data.transporter;
			$scope.TransporterList=data.alltransporters;
			$("#order_status").val(data.data.OdStatus);

			if(data.orderLocations[0] !=""){
				// Google Map 

        var map;
        var bounds = new google.maps.LatLngBounds();

 var pos = new google.maps.LatLng(41.218624, -73.748358);
    var myOptions = {
        zoom: 15,
        center: pos,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
            
        // var mapOptions = {
        //     mapTypeId: "roadmap",
        //     center: {
        //       lat: 22.2870379,
        //       lng: 70.7535242
        //     },//new google.maps.LatLng(data.orderLocations[0].lat, data.orderLocations[0].lng), // somewhere in the uk BEWARE center is required
        //     zoom: 13,
        // };
console.log(myOptions);
        // Display a map on the page
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        map.setTilt(45);
return false;
        // Multiple Markers
        // var markers = <?php echo json_encode( $markers ); ?>;
        var markers = [{              lat: 22.2870379,
              lng: 70.7535242
}]//data.orderLocations;
        // Info Window Content
        var infoWindowContent = [
            ['<div class="info_content">' +
            '<h3>London Eye</h3>' +
            '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' + '</div>'],
            ['<div class="info_content">' +
            '<h3>Palace of Westminster</h3>' +
            '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
            '</div>']
        ];

        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow();
        var marker, i;
		var labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var labelIndex = 0;
        // Loop through our array of markers & place each one on the map
        for (i = 0; i < markers.length; i++) {
        	console.log(markers[i]);
            var position = new google.maps.LatLng(markers[i].lat,markers[i].lng);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                label: labels[labelIndex++ % labels.length],
                title: markers[i][0]
            });

//            Allow each marker to have an info window
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }

        //Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
            this.setZoom(13);
            google.maps.event.removeListener(boundsListener);
        });





      }


		});
	}else{
		$scope.fgShowHide = true;
		$scope.viewOrderItem = false;
		$scope.viewOrderDetail = false;
		loadGridData($scope.pagingOptions.pageSize,1);
	//Grid,dropdown data loading
	}

//	loadData('get_all_user',{}).success(function(data){$scope.UserList=data;});


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
		$scope.fgShowHide = false;
		$scope.viewOrderDetail = true;
	}
	$scope.updateOrderStatus=function(){
			var data = {'id':getParam( 'id' ),'transId':$("#transporter").val(),'status':$scope.item.Status};
			console.log($scope.item);
			if($scope.item.Status ==null){
				$scope.StatusError = true;
				$scope.StatusMsg = "Select Status";
			}
			if($scope.item.Transporter ==null || $scope.item.Transporter ==""){
				$scope.TransporterError = true;
				$scope.TransporterMsg = "Select Transporter";
			}
			loadData('changestatus',data).success(function(data){
//				loadGridData($scope.pagingOptions.pageSize,$scope.pagingOptions.currentPage);
		loadData('get_order_detail',{id:getParam('id')}).success(function(data){
			console.log(data);
			$scope.OrderDetail=data.data;
			$scope.CustomerDetail=data.customer;
			$scope.ManufactuerDetail=data.manufactur;
			$scope.TransporterDetail=data.transporter;
			$scope.TransporterList=data.alltransporters;
			$("#order_status").val(data.data.OdStatus);
		});

		            $.bootstrapGrowl('<h4>Success!</h4> <p>Order updated successfully</p>', {
		                type: 'info',
		                delay: 2500,
		                allow_dismiss: true
		            });
			});

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
		params['pageType']=getParam('type');
		params['Id']=getParam('id');
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
        pageSize: 10,
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