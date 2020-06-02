<script src="static/appScript/OrderCtrl.js?fdddddd"></script>

<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<style type="text/css">
    .text-capitalize{
        text-transform: capitalize;
    }
</style>
<div ng-controller="OrderCtrl">
<div class="element-wrapper" ng-show="fgShowHide">
	 <!-- Datatables Content -->
                <h6 class="element-header">
                  Manage Order
                </h6>
                <div class="element-box">
                  <div class="table-responsive">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length"><label>Show <select name="dataTable1_length" class="form-control form-control-sm rounded bright" style="width:75px"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries </label></div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="dataTable1_filter" class="dataTables_filter float-right"><label>Search:
                                        <input type="search" ng-model="search" class="form-control form-control-sm rounded bright" placeholder="" ng-change="doSearch()"></label>
                                </div>
                            </div>
                        </div>
                        <table  width="100%" class="table table-lightborder">
                        <thead>
                            <tr>
                        <th class="text-center">Order Id</th>
                        <th class="text-center" style="width: 200px !important">Order&nbsp;Date</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Mobile No</th>
                        <th class="text-center">Total Products</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                        <th class="text-center">Order Id</th>
                        <th class="text-center" style="width: 200px !important">Order&nbsp;Date</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Mobile No</th>
                        <th class="text-center">Total Products</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                    <tr ng-repeat="item in list">
                        <td class="text-capitalize">{{item.OId}}</td>
                        <td class="text-capitalize" style="width: 200px !important">{{item.Created_At}}</td>
                        <td class="text-capitalize">{{item.FirstName}} {{item.LastName}}</td>
                        <td class="text-capitalize">{{item.MobileNumber}}</td>
                        <td class="text-capitalize"><span ng-if="$index !=0">{{200 * $index }}</span> <span ng-if="$index ==0">200</span></td>
                        <td class="text-capitalize">{{(5 + $index) + 3}}</td>
                        <td class="text-capitalize"><span ng-if="$index !=0">{{200 * 5 * $index}}</span> <span ng-if="$index ==0">200</span></td>
                        <td>
                            <a ng-show="item.OStatus == '1'" class="badge badge-danger" href="">Queue</a>
                            <a ng-show="item.OStatus == '2'" class="badge badge-success" href="">Pending</a>
                            <a ng-show="item.OStatus == '4'" class="badge badge-primary" href="">Completed</a>
                        </td>

                        <td>
                        <button type="button" class="ml-3 btn  btn-xs btn-warning" ng-click="viewItem(item)"><i class="os-icon os-icon-eye" style="margin-top: -3px;"></i></button>
                        <button type="button" class="btn  btn-xs btn-danger" ng-click="deleteItem(item.OrderId)"><i class="os-icon os-icon-ui-15" style="margin-top: -3px;"></i></button> </td>


                    </tr>
                    <tr ng-show="list.length ==0"><td colspan="10" class="text-center">Order Not found</td></tr>

                            </tbody></table>
                  </div>

                            <div class="row"><div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="dataTable1_info" role="status" aria-live="polite">Showing {{pagingOptions.currentPage}} to {{totalpaging}} of {{totalItems}} entries</div></div>
                                    <div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers float-right"><ul class="pagination"><li class="paginate_button page-item previous" ng-class="{'disabled': pagingOptions.currentPage == 1}"><a href="javascript:void(0)" ng-click="setPage(pagingOptions.currentPage - 1)" class="page-link">Previous</a></li><li ng-repeat="pages in arrayTwo(pagingOptions.currentPage,totalpaging) track by $index" ng-class="{'active': pages == pagingOptions.currentPage}"  class="paginate_button page-item "><a href="javascript:void(0)" ng-click="setPage(pages)" class="page-link" ng-if="pages !='...'">{{pages}}</a><span href="javascript:void(0)"  data-paging-options="pages" ng-if="pages =='...'" class="page-link">{{pages}}</span></li><li class="paginate_button page-item next" ng-class="{disabled: pagingOptions.currentPage == totalpaging || totalItems == 0}"><a href="javascript:void(0);" ng-click="setPage(pagingOptions.currentPage + 1)" class="page-link">Next</a></li></ul></div></div>
                                </div>

                </div>

              </div>

<div ng-show="!fgShowHide && !viewOrderDetail" style="display:none">



<div class="block">
    <!-- Basic Form Elements Title -->
    <div class="block-title">
        <h2><strong>{{itemtitle}}</strong> Menu</h2>
    </div>
    <!-- END Form Elements Title -->
    <form action="#"  name="myForm" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
		<div class="row">
            <div class="col-md-6">
                <div class="form-group" ng-class="categoryError ? 'has-error':''">
                    <label class="col-md-3 control-label" for="example-text-input">Category</label>
                    <div class="col-md-9">
                        <select name="ParentCatId" id="ParentCatId" ng-model="item.ParentCatId" required class="form-control" placeholder="Category">
                          
                            <option ng-repeat="cats in CategoryList" value="{{cats.catId}}">{{cats.catName}}</option>
                        </select>
                        <span ng-show="categoryError" ng-bind="errors.categoryMsg" class="help-block"></span>
                    </div>
                </div>
            </div>
    		<div class="col-md-6">
		        <div class="form-group" ng-class="nameError? 'has-error':''">
		            <label class="col-md-3 control-label" for="example-text-input">Name</label>
		            <div class="col-md-9">
		                <input type="text" name="Name" id="Name" ng-model="item.Name"  class="form-control" placeholder="Name">
                        <span ng-show="nameError" ng-bind="errors.nameMsg" class="help-block"></span>

		            </div>
		        </div>
        	</div>
    		
    	</div>
    	<div class="row">
        <div class="col-md-6">
        <div class="form-group" ng-class="infoError ? 'has-error':''">
            <label class="col-md-3 control-label" for="example-text-input">Info</label>
            <div class="col-md-9">
                <textarea name="address" id="Info" ng-model="item.Info"  class="form-control" placeholder="Info"></textarea> 
                <span ng-show="infoError" ng-bind="errors.infoMsg" class="help-block"></span>
            </div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group" ng-class="priceError ? 'has-error':''">
                <label class="col-md-3 control-label" for="example-text-input">Price</label>
                <div class="col-md-9">
                    <input type="text"  name="Price" id="Price" ng-model="item.Price"  class="form-control" placeholder="Price">
                    <span ng-show="priceError" ng-bind="errors.priceMsg" class="help-block"></span>

                </div>
                </div>
        <!-- <div class="form-group" ng-class="myForm.Stock.$invalid ? 'has-error':''">
            <label class="col-md-3 control-label" for="example-text-input">Stock</label>
            <div class="col-md-9">
                <input type="hidden" value="1"  name="Stock" id="Stock" ng-model="item.Stock" required class="form-control" placeholder="Stock">
                <span ng-show="myForm.Stock.$error.required" class="help-block">Required</span>
            </div>
        </div> -->
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
        <div class="form-group" ng-class="myForm.image.$invalid ? 'has-error':''">
            <label class="col-md-3 control-label" for="example-text-input">Image</label>
            <div class="col-md-9">
                <input type="file"  name="image" id="image" ng-model="item.image" class="form-control" placeholder="image" onchange="angular.element(this).scope().getfilename(this)">
             
                <img  id="baseimagename"  width="100px" height="80px">
                <!-- <span ng-show="myForm.Image.$error.required" class="help-block">Required</span> -->
            </div>
        </div>
        </div><div class="col-md-6">
                
            </div>

        <div class="form-group form-actions">
            <div class="col-md-4 col-md-offset-5">
                <button   ng-click="saveItem()"   class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                <button class="btn btn-warning cancel" ng-click="hideForm()"><i class="icon-close icon-white"></i>Cancel</button>
            </div>
        </div>
    </div>
    </form>
                                  
</div>
</div>
<div modal="searchDialog"  options="opts">
        <div class="modal-header">
		 <a class="close" ng-click="closeSearchDialog()" data-dismiss="modal">&times;</a>
            <h3>Users</h3>
        </div>
        <div class="modal-body">
           <form name="myForm" class="form-horizontal">
  			 <div class="control-group" ><label class="control-label" for="UserName">UserName</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="UserName" id="UserName" ng-model="search.UserName" />		  
		</div></div>
<div class="control-group" ><label class="control-label" for="FirstName">FirstName</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="FirstName" id="FirstName" ng-model="search.FirstName" />		  
		</div></div>
<div class="control-group" ><label class="control-label" for="LastName">LastName</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="LastName" id="LastName" ng-model="search.LastName" />		  
		</div></div>
<div class="control-group" >
			<label class="control-label" for="Email">Email</label>
		<div class="controls">
		  <input type="email" name="Email" id="Email" ng-model="item.Email" />
			
		</div></div>
<div class="control-group" ><label class="control-label" for="Role">Role</label>
		<div class="controls">
		  <select ng-options="s.RoleId as s.RoleName for s in RolesList"  name="Role" id="Role" ng-model="search.Role" ></select>		  
		</div></div>
<div class="control-group" ><label class="control-label" for="NavigationId">NavigationId</label>
		<div class="controls">
		  <select ng-options="s.NavigationId as s.NavName for s in NavigationsList"  name="NavigationId" id="NavigationId" ng-model="search.NavigationId" ></select>		  
		</div></div>
<div class="control-group" ><label class="control-label" for="IsActive">IsActive</label>
		<div class="controls">
		  <input  type="checkbox" ng-true-value="1" ng-false-value="0" name="IsActive" id="IsActive" ng-model="search.IsActive" />		  
		</div></div>
	   
			</form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning cancel" ng-click="closeSearchDialog()"><i class="icon-close icon-white"></i>Cancel</button>
			<button class="btn btn-primary cancel" ng-click="refreshSearch()"><i class="icon-refresh icon-white"></i> Refresh</button>
			 <button class="btn btn-primary cancel" ng-click="doSearch()"><i class="icon-search icon-white"></i> Search</button>
        </div>
</div>





<div ng-show="viewOrderDetail" style="display:none">
<div class="row">
  <div class="col-md-8 ">
    <div class="element-wrapper">
    <div class="order-box ">
        <button type="button"  ng-click="hideForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Back </b></button>
        <button type="button"  ng-click="hideForm()" class="btn btn-warning" style="float: right" ><i class="os-icon os-icon-download"></i><b> Download Invoice </b></button>
        <br/><br/>
      <div class="order-details-box">
        <div class="order-main-info">
          <span>Order #</span><strong>{{order_id}}</strong>
        </div>
        <div class="order-sub-info">
          <span>Placed On</span><strong>{{order_date}}</strong>
        </div>
      </div>
      <div class="order-controls">
        <form class="form-inline">
          <div class="form-group col-md-3">
            <label for="">Order Status</label>
            <select class="form-control form-control-sm" id="order_status">
              <option value="Pending"> Pending </option>
              <option value="Accept"> Accept </option>
              <option value="Reject"> Reject </option>
              <option value="Process"> Process</option>
              <option value="Shipped"> Shipped</option>
              <option value="Completed"> Completed</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="">Assign Transporter</label>
            <!-- <select class="form-control form-control-sm text-capitalize">
              <option> Select Transporter </option>
              <option> Hareshbhai Hindocha </option>
              <option> Sitram Faundri</option>
            </select> -->
            <select name="transporter" id="transporter" ng-model="item.Transporter"  class="form-control" ng-focus="hideErrorMsg('transporterError')"  class="form-control">
                <option value="null">Select Transporter</option>
                <option  ng-repeat="transporter in TransporterList" value="{{transporter.UserId}}" ng-selected="item.TransId == transporter.TransId">{{transporter.CompanyName}}</option>

            </select>
          </div>
<!--           <div class="form-group">
            <label for="">Payment Status</label><select class="form-control form-control-sm">
              <option>
                Paid
              </option>
              <option>
                Pending
              </option>
            </select>
          </div> -->
          <div class="form-group">
            <button class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
      <div class="order-items-table">
        <div class="table-responsive">
          <table class="table table-lightborder">
            <thead>
              <tr>
                <th >
                  Product Info
                </th>
                <th width="135px" style="text-align: center;">
                  Quantity
                </th>
                <th colspan="2" style="text-align: right;">
                  Price
                </th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="pitem in product_array">
                <td>
                  <div class="product-name">
                  {{pitem.product.PName}}
                  </div>
<!--                   <div class="product-details">
                    <span>Designed by Nord Architects</span>
                  </div> -->
                </td>
                <td>
                   <div class="quantity-selector" align="center">
                        {{pitem.Qty}}
                   </div>
                </td>
                <td class="text-md-right">
                  <div class="product-price">
                    ₹{{pitem.Price}}
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="order-foot">
        <div class="row">
          <div class="col-md-6 mb-4">
            <h5>
              Notes
            </h5>
            <div class="form-group">
              <textarea class="form-control" placeholder="Enter your notes here..."></textarea>
            </div>
            <button class="btn btn-primary">Save Notes</button>
          </div>
          <div class="col-md-5 offset-md-1">
            <h5 class="order-section-heading">
              Order Summary
            </h5>
            <div class="order-summary-row">
              <div class="order-summary-label">
                <span>Subtotal</span>
              </div>
              <div class="order-summary-value">
                ₹{{subtotal}}
              </div>
            </div>
           
            <!-- <div class="order-summary-row">
              <div class="order-summary-label">
                <span>Taxes</span><strong>VAT 20%</strong>
              </div>
              <div class="order-summary-value">
                ₹3000
              </div>
            </div> -->
            <div class="order-summary-row as-total">
              <div class="order-summary-label">
                <span>Total</span>
              </div>
              <div class="order-summary-value">
                ₹{{total}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


  </div>
  <style type="text/css">
      .ecommerce-customer-info .ecc-sub-info-row {
    margin-bottom: 10px;
}
.ecc-name-letter
{
    border-radius: 100px;
    width: 100px;
    font-size: 35px;
    text-align: center;
    display: block;
    margin: 0px auto;
    width: 100px;
    background-color: #24b314;
    height: 100px;
    line-height: 100px;
    font-weight: bold;
    color: #fff;

}
  </style>
<div class="col-md-4">
    <div class="element-wrapper">
        <h6 class="element-header"> Time Line</h6>
            <div class="element-box-tp">
                  <div class="activity-boxes-w">
                    <div class="activity-box-w">
                      <div class="activity-time"> January 18th,2020 </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Completed</strong>
                        </div>
                      </div>
                    </div>
                    <div class="activity-box-w">
                      <div class="activity-time"> January 18th,2020 </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Dispatch</strong>
                        </div>
                      </div>
                    </div>

                    <div class="activity-box-w">
                      <div class="activity-time"> January 17th,2020 </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Vehicel and Driver Assigned</strong>
                        </div>
                      </div>
                    </div>
                    <div class="activity-box-w">
                      <div class="activity-time"> January 17th,2020 </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Placed</strong>
                        </div>
                      </div>
                    </div>

                    <div class="activity-box-w">
                      <div class="activity-time"> January 16th,2020 </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Transporter Assigned</strong>
                        </div>
                      </div>
                    </div>

                    <div class="activity-box-w">
                      <div class="activity-time"> January 15th,2020 </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Accepted</strong>
                        </div>
                      </div>
                    </div>
                    <div class="activity-box-w">
                      <div class="activity-time"> January 14th,2020 </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Placed</strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

    
</div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="element-wrapper">
        <h6 class="element-header"> Customer Detail</h6>


    <div class="ecommerce-customer-info">
      <div class="ecommerce-customer-main-info">
        <div class="ecc-name">
          {{FirstName}} {{LastName}}
        </div>
       
      </div>
      <div class="ecommerce-customer-sub-info">
        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Email
          </div>
          <div class="sub-info-value">
            <a href="#">{{Email}}</a>
          </div>
        </div>
        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Phone
          </div>
          <div class="sub-info-value">
            {{MobileNumber}}
          </div>
        </div>

        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Delivery Address
          </div>
          <div class="sub-info-value">
           {{OAddress}}
          </div>
        </div>
        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Payment Method
          </div>
          <div class="sub-info-value">
            Paypal
          </div>
        </div>
        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Payment Id
          </div>
          <div class="sub-info-value">
            3982389298389389
          </div>
        </div>
        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Expected Delivery Date
          </div>
          <div class="sub-info-value">
            March 30th, 2020
          </div>
        </div>

      </div>

    </div>
  </div>
</div>
  <div class="col-md-4">
    <div class="element-wrapper">
        <h6 class="element-header"> Manufacturer Detail</h6>
    <div class="ecommerce-customer-info">
      <div class="ecommerce-customer-main-info">
        <div class="ecc-name">
          {{MName}}
        </div>
       
      </div>
      <div class="ecommerce-customer-sub-info">
     <div class="ecc-sub-info-row">
        <div class="sub-info-label">Email </div>
        <div class="sub-info-value"><a href="#">{{MEmail}}</a></div>
      </div>

      <div class="ecc-sub-info-row">
        <div class="sub-info-label">Phone Number</div>
        <div class="sub-info-value"><a href="#">{{MMobileNumber}}</a> </div>
      </div>

    </div>
  </div>


</div>
</div>
<div class="col-md-4">

<div class="element-wrapper">
    <h6 class="element-header"> Transporter Detail</h6>
    <div class="ecommerce-customer-info">
      <div class="ecommerce-customer-main-info">
        <div class="ecc-name">
          Hareshbhai Adiyecha
        </div>
       
      </div>
      <div class="ecommerce-customer-sub-info">
     <div class="ecc-sub-info-row">
        <div class="sub-info-label">Transporter email </div>
        <div class="sub-info-value"><a href="#">abc@gmail.com</a></div>
      </div>
     <div class="ecc-sub-info-row">
        <div class="sub-info-label">Transporter Phone </div>
        <div class="sub-info-value"><a href="#">982453899</a></div>
      </div>

     <div class="ecc-sub-info-row">
        <div class="sub-info-label">Assigned Vehicle No.</div>
        <div class="sub-info-value"><a href="#">DEL-01-2011</a></div>
      </div>

      <div class="ecc-sub-info-row">
        <div class="sub-info-label">Assigned Driver Name</div>
        <div class="sub-info-value">HARESHBHAI ADIYECHA</div>
      </div>
      <div class="ecc-sub-info-row">
        <div class="sub-info-label">Assigned Driver Phone No.</div>
        <div class="sub-info-value"><a href="#">9824453899</a> </div>
      </div>

    </div>
  </div>


</div>


</div>
<div class="col-md-8">

    <div class="element-wrapper">
        <h6 class="element-header"> Order Tracking</h6>
        <div class="element-box">
            <iframe width="100%"
              height="350"
              frameborder="0" style="border:0"
              src="https://www.google.com/maps/embed/v1/place?key=AIzaSyADAWa_qgxsfFsx6s6onnad8VCrVCUjL7E
                &q=Delhi,India" allowfullscreen>
            </iframe>
        </div>
    </div>

</div>
<div class="col-md-4">

<div class="element-wrapper">
    <h6 class="element-header"> Customer Review</h6>
        <div class="element-box">
            <div class="">
            <i class="os-icon os-icon-star-full btn-success btn"></i>
            <i class="os-icon os-icon-star-full btn-success btn"></i>
            <i class="os-icon os-icon-star-full btn-success btn"></i>
            <i class="os-icon os-icon-star-full btn-success btn"></i>
            </div>
            <br/>
            <h5>Very Nice Product </h5>
        </div>
       
</div>

</div>

</div>
</div>

</div>
</div>
<?php else: ?>
<p> Not permitted</p>
<?php endif; ?>
