<script src="static/appScript/OrderCtrl.js"></script>
<style type="text/css">
 #mapNew {
    height: 400px;
    width: 100%;
  }
</style>

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
                        <th class="text-center">Invoice Id</th>
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
                        <th class="text-center">Invoice Id</th>
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
                        <td class="text-capitalize">{{item.TotalProduct }}</td>
                        <td class="text-capitalize">{{item.TotalQty}}</td>
                        <td class="text-capitalize">{{item.OTotal}}</td>
                        <td>
                            <a ng-show="item.OStatus == '1'" class="badge badge-danger" href="">Queue</a>
                            <a ng-show="item.OStatus == '2'" class="badge badge-success" href="">Pending</a>
                            <a ng-show="item.OStatus == '4'" class="badge badge-primary" href="">Completed</a>
                        </td>

                        <td>
                         <a href="<?php echo site_url(); ?>/#/viewItemOrder?&type=OrderItem&id={{item.OId}}" class="ml-3 mb-2 btn  btn-xs btn-warning"> <i class="os-icon os-icon-eye" ></i></a>

                         <a href="javascript:void(0)" ng-click="deleteItem(item.OrderId)" class=" btn  btn-xs btn-danger"> <i class="os-icon os-icon-ui-15"></i></a>

                        </td>


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

<div class="element-wrapper" ng-show="viewOrderItem">
     <!-- Datatables Content -->
    <div class="element-wrapper">



                <h6 class="element-header">
                    <a href="<?php echo base_url(); ?>index.php/#/Order" class="btn btn-sm btn-success"   >Back </a>
                  Manage Order Item
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
                        <th class="text-center">Invoice Id</th>
                        <th class="text-center">Order Id</th>
                        <th class="text-center" style="width: 200px !important">Order&nbsp;Date</th>
                        <th class="text-center">Products Name</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                        <th class="text-center">Invoice Id</th>
                        <th class="text-center">Order Id</th>
                        <th class="text-center" style="width: 200px !important">Order&nbsp;Date</th>
                        <th class="text-center">Products Name</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                    <tr ng-repeat="item in list">
                        <td class="text-capitalize">{{item.OId}}</td>
                        <td class="text-capitalize">{{item.OdId}}</td>
                        <td class="text-capitalize" style="width: 200px !important">{{item.Created_At}}</td>
                        <td class="text-capitalize ">{{item.PName}}</td>
                        <td class="text-capitalize text-center">{{item.OdQty}}</td>
                        <td class="text-capitalize text-center">{{item.OdPrice * item.OdQty}}</td>
                        <td>
                            <a ng-show="item.OdStatus == '0'" class="badge badge-danger" href="">Queue</a>
                            <a ng-show="item.OdStatus == '1'" class="badge badge-success" href="">Approved</a>
                            <a ng-show="item.OdStatus == '2'" class="badge badge-success" href="">Transporter Assigned</a>
                            <a ng-show="item.OdStatus == '3'" class="badge badge-primary" href="">Driver Assigned</a>
                            <a ng-show="item.OdStatus == '4'" class="badge badge-primary" href="">Completed</a>
                            <a ng-show="item.OdStatus == '5'" class="badge badge-primary" href="">Rejected</a>
                        </td>

                        <td>
                       <a href="<?php echo site_url(); ?>/#/viewOrderDetail?&type=OrderDetail&id={{item.OdId}}" class="btn  btn-xs btn-warning"> <i class="os-icon os-icon-eye" style="margin-top: -3px;"></i></a>
                        <button type="button" class="btn  btn-xs btn-danger" ng-click="deleteItem(item.OrderId)"><i class="os-icon os-icon-ui-15" style="margin-top: -3px;"></i></button> </td>


                    </tr>
                    <tr ng-show="list.length ==0"><td colspan="10" class="text-center">Item Not found</td></tr>

                            </tbody></table>
                  </div>

                            <div class="row"><div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="dataTable1_info" role="status" aria-live="polite">Showing {{pagingOptions.currentPage}} to {{totalpaging}} of {{totalItems}} entries</div></div>
                                    <div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers float-right"><ul class="pagination"><li class="paginate_button page-item previous" ng-class="{'disabled': pagingOptions.currentPage == 1}"><a href="javascript:void(0)" ng-click="setPage(pagingOptions.currentPage - 1)" class="page-link">Previous</a></li><li ng-repeat="pages in arrayTwo(pagingOptions.currentPage,totalpaging) track by $index" ng-class="{'active': pages == pagingOptions.currentPage}"  class="paginate_button page-item "><a href="javascript:void(0)" ng-click="setPage(pages)" class="page-link" ng-if="pages !='...'">{{pages}}</a><span href="javascript:void(0)"  data-paging-options="pages" ng-if="pages =='...'" class="page-link">{{pages}}</span></li><li class="paginate_button page-item next" ng-class="{disabled: pagingOptions.currentPage == totalpaging || totalItems == 0}"><a href="javascript:void(0);" ng-click="setPage(pagingOptions.currentPage + 1)" class="page-link">Next</a></li></ul></div></div>
                                </div>

                </div>

              </div>
</div>
<div ng-show="viewOrderDetail" style="display:none">

    <div class="element-wrapper" ng-if="isLoadingBar">
          <div class="loading-customizer-btn">
              <div class="icon-w ">
                  <i class="os-icon os-icon-loader os-icon-spin"></i>
                </div>
              </div>
    </div>

<div class="row">
  <div class="col-md-8 "  ng-if="!isLoadingBar">
    <div class="element-wrapper">
    <div class="order-box ">
                    <a href="<?php echo base_url(); ?>index.php/#/Order" class="btn btn-sm btn-success"   >Back </a>
        <button type="button"   class="btn btn-warning" style="float: right" ><i class="os-icon os-icon-download"></i><b> Download Invoice </b></button>
        <br/><br/>
      <div class="order-details-box">
        <div class="order-main-info">
          <span>Order #</span><strong>{{OrderDetail.OdId}}</strong>
        </div>
        <div class="order-sub-info">
          <span>Placed On</span><strong>{{OrderDetail.Created_At}}</strong>
        </div>
      </div>
      <div class="order-controls" ng-if="OrderDetail.OdStatus !=5 && OrderDetail.OdStatus !=4 && OrderDetail.OdStatus !=3">
        <form class="form-inline">
          <div class="form-group col-md-3">
            <label for="">Order Status</label>
            <select class="form-control form-control-sm" ng-model="item.Status" id="order_status">
              <option value="null" selected> Select </option>
              <option value="1" ng-if="OrderDetail.OdStatus !=1"> Accept </option>
              <option value="2" ng-if="OrderDetail.OdStatus !=2"> Assign </option>
              <option value="5" ng-if="OrderDetail.OdStatus !=5"> Reject </option>
<!--               <option value="2"> Reject </option>
              <option value="3"> Process</option>
              <option value="4"> Shipped</option>
              <option value="5"> Completed</option>
 -->            </select>
            <span ng-show="StatusError" ng-bind="StatusMsg" class="help-block"></span>

          </div>
          <div class="form-group col-md-6">
            <label for="" ng-if="OrderDetail.OdTransId ==0 && item.Status==2">Assign Transporter</label>
            <!-- <select class="form-control form-control-sm text-capitalize">
              <option> Select Transporter </option>
              <option> Hareshbhai Hindocha </option>
              <option> Sitram Faundri</option>
            </select> -->
            <select name="transporter" id="transporter" ng-model="item.Transporter"  class="form-control" ng-focus="hideErrorMsg('transporterError')" ng-if="OrderDetail.OdTransId ==0 && item.Status==2"  class="form-control">
                <option value="null">Select Transporter</option>
                <option  ng-repeat="transporter in TransporterList" value="{{transporter.UserId}}" ng-selected="item.TransId == transporter.TransId">{{transporter.CompanyName}}</option>

            </select>
            <span ng-show="TransporterError" ng-bind="TransporterMsg" class="help-block"></span>

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
            <button class="btn btn-primary" ng-click="updateOrderStatus()">Save Changes</button>
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
              <tr>
                <td>
                  <div class="product-name">
                  {{OrderDetail.PName}}
                  </div>
                </td>
                <td>
                   <div class="quantity-selector" align="center">
                    {{OrderDetail.OdQty}}
                   </div>
                </td>
                <td class="text-md-right">
                  <div class="product-price">
                    ₹{{OrderDetail.OdPrice}}
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
<!--             <h5>
              Notes
            </h5>
            <div class="form-group">
              <textarea class="form-control" placeholder="Enter your notes here..."></textarea>
            </div>
            <button class="btn btn-primary">Save Notes</button> -->
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
                ₹{{OrderDetail.OdPrice * OrderDetail.OdQty}}
              </div>
            </div>
           
            <div class="order-summary-row as-total">
              <div class="order-summary-label">
                <span>Total</span>
              </div>
              <div class="order-summary-value">
                ₹{{OrderDetail.OdPrice * OrderDetail.OdQty}}
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
<div class="col-md-4" ng-if="!isLoadingBar">
    <div class="element-wrapper">
        <h6 class="element-header"> Time Line</h6>
            <div class="element-box-tp">
                  <div class="activity-boxes-w" >
                    <div class="activity-box-w" ng-if="OrderDetail.OdStatus ==5">
                      <div class="activity-time"> {{OrderDetail.RejectedAt}} </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order RejectedAt</strong>
                        </div>
                      </div>
                    </div>

                    <div class="activity-box-w" ng-if="OrderDetail.OdStatus >=4 && OrderDetail.OdStatus !=5">
                      <div class="activity-time"> {{OrderDetail.CompletedAt}} </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Completed</strong>
                        </div>
                      </div>
                    </div>
<!--                     <div class="activity-box-w" ng-if="OrderDetail.OdStatus >=4">
                      <div class="activity-time"> {{OrderDetail.CompletedAt}} </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Dispatch</strong>
                        </div>
                      </div>
                    </div>
 -->
                    <div class="activity-box-w" ng-if="OrderDetail.OdStatus >=3 && OrderDetail.OdStatus !=5">
                      <div class="activity-time"> {{OrderDetail.ProcessedAt}} </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Vehicle and Driver Assigned</strong>
                        </div>
                      </div>
                    </div>

                    <div class="activity-box-w" ng-if="OrderDetail.OdStatus >=2 && OrderDetail.OdStatus !=5">
                      <div class="activity-time"> {{OrderDetail.AssignedAt}} </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Transporter Assigned</strong>
                        </div>
                      </div>
                    </div>

                    <div class="activity-box-w" ng-if="OrderDetail.OdStatus >=1 && OrderDetail.OdStatus !=5">
                      <div class="activity-time"> {{OrderDetail.AcceptedAt}} </div>
                      <div class="activity-box"> 
                        <div class="activity-info">
                            <strong class="activity-title">Order Accepted</strong>
                        </div>
                      </div>
                    </div>
                    <div class="activity-box-w" ng-if="OrderDetail.OdStatus >=0">
                      <div class="activity-time"> {{OrderDetail.CreatedAt}}</div>
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
<div class="row" style="width:100%"  ng-if="!isLoadingBar">
  <div class="col-md-4">
    <div class="element-wrapper">
        <h6 class="element-header"> Customer Detail</h6>


    <div class="ecommerce-customer-info">
      <div class="ecommerce-customer-main-info">
        <div class="ecc-name">
          {{CustomerDetail.FirstName}} {{CustomerDetail.LastName}}
        </div>
       
      </div>
      <div class="ecommerce-customer-sub-info">
        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Email
          </div>
          <div class="sub-info-value">
            <a href="#">{{CustomerDetail.Email}}</a>
          </div>
        </div>
        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Phone
          </div>
          <div class="sub-info-value">
            {{CustomerDetail.MobileNumber}}
          </div>
        </div>

        <div class="ecc-sub-info-row">
          <div class="sub-info-label">
            Delivery Address
          </div>
          <div class="sub-info-value" ng-if="OrderDetail.IsSameAddress == 1">
           {{CustomerDetail.Address.split('|')[0]}} <br/>
           {{CustomerDetail.Landmark}} <br/>
           {{CustomerDetail.CityName}} ,{{CustomerDetail.DName}},{{CustomerDetail.CName}}
          </div>
          <div class="sub-info-value" ng-if="OrderDetail.IsSameAddress == 0">
           {{OrderDetail.OAddress.split('|')[0]}} <br/>
           {{OrderDetail.OAddress.split('|')[1]}} <br/>
           {{OrderDetail.OLandMark}} <br/>
           {{OrderDetail.CityName}},{{OrderDetail.DName}},{{OrderDetail.SName}},{{OrderDetail.CName}}
          </div>
        </div>
<!--         <div class="ecc-sub-info-row">
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
 -->
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
          {{ManufactuerDetail.CompanyName}}
        </div>
       
      </div>
      <div class="ecommerce-customer-sub-info">
     <div class="ecc-sub-info-row">
        <div class="sub-info-label">Email </div>
        <div class="sub-info-value"><a href="#">{{ManufactuerDetail.Email}}</a></div>
      </div>

      <div class="ecc-sub-info-row">
        <div class="sub-info-label">Phone Number</div>
        <div class="sub-info-value"><a href="#">{{ManufactuerDetail.MobileNumber}}</a> </div>
      </div>

    </div>
  </div>


</div>
</div>
<div class="col-md-4">

<div class="element-wrapper" ng-if="OrderDetail.OdTransId !=0">
    <h6 class="element-header"> Transporter Detail</h6>
    <div class="ecommerce-customer-info">
      <div class="ecommerce-customer-main-info">
        <div class="ecc-name">
          {{TransporterDetail.CompanyName}}
        </div>
       
      </div>
      <div class="ecommerce-customer-sub-info">
     <div class="ecc-sub-info-row">
        <div class="sub-info-label">Transporter email </div>
        <div class="sub-info-value"><a href="#">{{TransporterDetail.Email}}</a></div>
      </div>
     <div class="ecc-sub-info-row">
        <div class="sub-info-label">Transporter Phone </div>
        <div class="sub-info-value"><a href="#">{{TransporterDetail.MobileNumber}}</a></div>
      </div>

     <div class="ecc-sub-info-row" ng-if="OrderDetail.VNo!=null">
        <div class="sub-info-label">Assigned Vehicle No.</div>
        <div class="sub-info-value"><a href="#">{{OrderDetail.VNo}}</a></div>
      </div>

      <div class="ecc-sub-info-row" ng-if="OrderDetail.DFirstName!=null">
        <div class="sub-info-label">Assigned Driver Name</div>
        <div class="sub-info-value">{{OrderDetail.DFirstName}} {{OrderDetail.DLastName}}</div>
      </div>
      <div class="ecc-sub-info-row" ng-if="OrderDetail.DMobileNumber!=null">
        <div class="sub-info-label">Assigned Driver Phone No.</div>
        <div class="sub-info-value"><a href="#">{{OrderDetail.DMobileNumber}}</a> </div>
      </div>

    </div>
  </div>


</div>


</div>
</div>
<div class="row" style="width:100%;">
<div class="col-md-8" ng-show="!isLoadingBar">

    <div class="element-wrapper" >
    &nbsp;
        <h6 class="element-header"> Order Tracking</h6>
        <div class="element-box">
            <div id="mapNew"></div>

        </div>
    </div>

</div>
<div class="col-md-4" ng-if="OrderDetail.IsReview ==0">

<div class="element-wrapper">
    &nbsp;
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
<div class="element-wrapper">
    &nbsp;
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
