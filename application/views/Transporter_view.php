<script src="static/appScript/TransporterCtrl.js"></script>
<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<div ng-controller="TransporterCtrl">
<div class="element-wrapper" ng-show="fgShowHide">
                <h6 class="element-header">
                  Manage Transporter
                </h6>
                <div class="element-box">
<!--                   <div class="form-desc">
                        <button type="button" ng-show="auth.insert" ng-click="showForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Add </b></button>

                  </div> -->
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
                                <th>Name</th><th>Phone No</th><th>Email</th><th>Address</th><th>Status</th> 
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th><th>Phone No</th><th>Email</th><th>Address</th><th>Status</th> 
                                <th colspan="2">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr ng-repeat="item in list">
                                <td>{{item.FirstName}} {{item.LastName}}</td>
                                <td>{{item.MobileNumber}}</td>
                                <td>{{item.Email}}</td>
                                <td>{{item.Address}}</td>
                                <td>
                                  <lable ng-show="item.Status == '1'" class="badge badge-success">Active</lable>
                                  <lable ng-show="item.Status == '0'" class="badge badge-danger">Deactive</lable>
                                </td>
                                <td class="text-center">

                                  <button type="button" class="ml-3 mb-2 btn  btn-xs btn-success" ng-show="item.Status == '0'" ng-click="changeItemStatus(item,1)">Active</button>
                                  <button type="button" class="ml-3 mb-2 btn  btn-xs btn-danger" ng-show="item.Status == '1'" ng-click="changeItemStatus(item,0)">Deactive</button>
                                </td>
                                <td>

                                    <button class="ml-3 mb-2 btn btn-outline-info " ng-click="viewItem(item)" type="button">  <i class="os-icon os-icon-eye" style="margin-top: -3px;"></i></button>
                                    <button class="mb-2 btn btn-outline-info " ng-click="editItem(item)" type="button">  <i class="os-icon os-icon-ui-49" style="margin-top: -3px;"></i></button>
                                    <button class=" mb-2 btn btn-outline-danger " ng-click="deleteItem(item)" type="button"> <i class="os-icon os-icon-ui-15" style="margin-top: -3px;"></i></button>
                                </td>
                            </tr>
                            <tr ng-show="list.length ==0"><td colspan="10" class="text-center">Customer Not found</td></tr>

                            </tbody></table>
                  </div>

                            <div class="row"><div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="dataTable1_info" role="status" aria-live="polite">Showing {{pagingOptions.currentPage}} to {{totalpaging}} of {{totalItems}} entries</div></div>
                                    <div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers float-right"><ul class="pagination"><li class="paginate_button page-item previous" ng-class="{'disabled': pagingOptions.currentPage == 1}"><a href="javascript:void(0)" ng-click="setPage(pagingOptions.currentPage - 1)" class="page-link">Previous</a></li><li ng-repeat="pages in arrayTwo(pagingOptions.currentPage,totalpaging) track by $index" ng-class="{'active': pages == pagingOptions.currentPage}"  class="paginate_button page-item "><a href="javascript:void(0)" ng-click="setPage(pages)" class="page-link" ng-if="pages !='...'">{{pages}}</a><span href="javascript:void(0)"  data-paging-options="pages" ng-if="pages =='...'" class="page-link">{{pages}}</span></li><li class="paginate_button page-item next" ng-class="{disabled: pagingOptions.currentPage == totalpaging || totalItems == 0}"><a href="javascript:void(0);" ng-click="setPage(pagingOptions.currentPage + 1)" class="page-link">Next</a></li></ul></div></div>
                                </div>

                </div>

              </div>












<div ng-show="!fgShowHide && !viewProfileDetail" style="display:none">
    <div class="element-wrapper">
                <h6 class="element-header">{{datatype}} Transporter</h6>
                <div class="element-box"><div class="form-desc"><button type="button"  ng-click="hideForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Back </b></button></div>
    <!-- END Form Elements Title -->
    <form action="#"  name="myForm" method="post" enctype="multipart/form-data"  onsubmit="return false;">

        <div class="form-group" ng-class="nameError ? 'has-error':''">
            <label>Name</label>
            <input type="text" name="name" id="name" ng-model="item.Name"  class="form-control" placeholder="Name" ng-focus="hideErrorMsg('nameError')">
            <span ng-show="nameError" ng-bind="errors.nameMsg" class="help-block"></span>
        </div>
        <div class="form-group" ng-class="emailError ? 'has-error':''">
            <label>Email Address</label>
            <input type="text" name="email" id="email" ng-model="item.Email"  class="form-control" placeholder="Email Address" ng-focus="hideErrorMsg('emailError')">
            <span ng-show="nameError" ng-bind="errors.emailMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="passwordError ? 'has-error':''">
            <label>Password</label>
            <input type="text" name="password" id="password" ng-model="item.Password"  class="form-control" placeholder="Password" ng-focus="hideErrorMsg('passwordError')">
            <span ng-show="passwordError" ng-bind="errors.passwordMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="phonenoError ? 'has-error':''">
            <label>Phone No.</label>
            <input type="text" name="phoneno" id="phoneno" ng-model="item.PhoneNo"  class="form-control" placeholder="Email Address" ng-focus="hideErrorMsg('phonenoError')">
            <span ng-show="phonenoError" ng-bind="errors.phonenoMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="addressError ? 'has-error':''">
            <label>Address</label>
            <textarea name="address" id="address" ng-model="item.Address"  class="form-control" placeholder="Address" ng-focus="hideErrorMsg('addressError')" rows="5"></textarea>
            <span ng-show="addressError" ng-bind="errors.addressMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="countryError ? 'has-error':''">
            <label>Select Country</label>
            <select name="country" id="country" ng-model="item.Country"  class="form-control" ng-focus="hideErrorMsg('countryError')"  class="form-control" ng-change="getStateList()" >
                <option value="null">Select Country</option>
                <option  ng-repeat="country in CountryList" value="{{country.CId}}" ng-selected="item.CountryId == country.CId">{{country.CName}}</option>

            </select>
            <span ng-show="countryError" ng-bind="errors.countryMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="stateError ? 'has-error':''">
            <label>Select State</label>
            <select name="state" id="state" ng-model="item.State"  class="form-control" ng-focus="hideErrorMsg('stateError')"  class="form-control" ng-change="getCityList()">
                <option value="null"  >Select State</option>
                <option  ng-repeat="state in StateList" value="{{state.StateId}}" ng-selected="item.StateId == state.StateId">{{state.SName}}</option>
            </select>
            <span ng-show="stateError" ng-bind="errors.0stateMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="cityError ? 'has-error':''">
            <label>Select City</label>
            <select name="city" id="city" ng-model="item.City"  class="form-control" ng-focus="hideErrorMsg('cityError')">
                <option value="null" selected>Select City</option>
                <option  ng-repeat="city in CityList" value="{{city.CityId}}" ng-selected="item.CityId == city.CityId">{{city.CName}}</option>
            </select>
            <span ng-show="cityError" ng-bind="errors.cityMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="gstnoError ? 'has-error':''">
            <label>GST No.</label>
            <input type="text" name="gstno" id="gstno" ng-model="item.GstNo"  class="form-control" placeholder="GST No." ng-focus="hideErrorMsg('gstnoError')">
            <span ng-show="gstnoError" ng-bind="errors.gstnoMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="vatnoError ? 'has-error':''">
            <label>VAT No.</label>
            <input type="text" name="vatno" id="vatno" ng-model="item.VatNo"  class="form-control" placeholder="VAT No." ng-focus="hideErrorMsg('vatnoError')">
            <span ng-show="vatnoError" ng-bind="errors.vatnoMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        
        <div class="form-group form-actions">
            <div class="col-md-9 col-md-offset-3">
                <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                <button class="btn btn-warning cancel" ng-click="hideForm()"><i class="icon-close icon-white"></i>Cancel</button>
            </div>
        </div>
    </form>
                                  
</div>


</div>
</div>

<style type="text/css">
.ecc-sub-info-row .sub-info-label{
    display: block;
    color: #adb5bd;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.8rem;
    margin-bottom: 4px; 
} .pt-avatar-w {
    display: block;
    border-radius: 50px;
    overflow: hidden;
    margin-bottom: 20px;
    text-align: center;
}.pt-avatar-w img {
    width: 100px;
    height: auto;
    border-radius: 100px;
}
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

<div ng-show="viewProfileDetail" style="display:none">
    <div class="element-wrapper">
      <div class="row m-b">
          <div class="col-md-4 ">
               <h6 class="element-header"><a href="" class="btn btn-sm btn-success"   ng-click="hideForm()">Back </a> Transporter Detail</h6>
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-avatar" style="background-image: url(<?php echo base_url(); ?>/static/img/avatar1.jpg)"></div>
              <div class="ecc-name">
               {{Name}}
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Email </div>
                <div class="sub-info-value"><a href="#">{{Email}}</a><strong class="badge badge-danger" style="float: right;"><i class="os-icon os-icon-close " style="font-weight: bold;"></i></strong></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Phone Number</div>
                <div class="sub-info-value"><a href="#">{{MobileNumber}}</a> 
                  <strong class="badge badge-success" style="float: right;"  ng-If="IsMobileNumberVerify"><i class="os-icon os-icon-checkmark " ></i></strong>
                  <strong class="badge badge-danger" style="float: right;" ng-If="!IsMobileNumberVerify"><i class="os-icon os-icon-close " style="font-weight: bold;"></i></strong>

                </div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Address</div>
                <div class="sub-info-value">{{Address}} <br/>{{Landmark}}<br/>{{CityName}},{{State}}, {{Country}}</div>
              </div>

               <div class="ecc-sub-info-row">
                <div class="sub-info-label">GSTIN / UIN Number</div>
                <div class="sub-info-value">{{GSTIN}}</div>
              </div>
               <div class="ecc-sub-info-row">
                <div class="sub-info-label">Vat Number</div>
                <div class="sub-info-value">{{VatNumber}}</div>
              </div>


            </div>
      </div>
        
        </div>
        <div class="col-md-8">
           <h6 class="element-header">Transporter Statistics</h6>
           <div class="element-content">
                      <div class="row">
                        <div class="col-sm-6 col-xxxl-3">
                          <a class="element-box el-tablo centered trend-in-corner padded bold-label" href="">
                              <div class="value">224</div>
                              <div class="label">Total Driver</div>
                          </a>
                        </div>
                          <div class="col-sm-6 col-xxxl-3">
                          <a class="element-box el-tablo centered trend-in-corner padded bold-label" href="">
                            <div class="value">780</div>
                            <div class="label">Total Vehicle</div>
                          </a>
                        </div>
                        <div class="col-sm-6 col-xxxl-3">
                          <a class="element-box el-tablo centered trend-in-corner padded bold-label" href="">
                            <div class="value">180</div>
                            <div class="label">Total Pending Orders</div>
                          </a>
                        </div>
                       
                        <div class="col-sm-6 col-xxxl-3">
                          <a class="element-box el-tablo centered trend-in-corner padded bold-label" href="">
                            <div class="value">180</div>
                            <div class="label">Total Completed Orders</div>
                          </a>
                        </div>
                       
                        
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
