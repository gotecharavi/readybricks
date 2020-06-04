<script src="static/appScript/RequestsCtrl.js?ffmkjfkkljdmmkf4"></script>
<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<div ng-controller="RequestsCtrl">
<div class="element-wrapper" ng-show="fgShowHide">
    <h6 class="element-header">Manage Requests</h6>
        <div class="element-box">
            <div class="os-tabs-w mx-4">
                <div class="os-tabs-controls">
                  <ul class="nav nav-tabs upper">
                        <li class="nav-item">
                        <a class="nav-link active" id="manufacturer-tab" data-toggle="tab" href="#manufacturer" aria-selected="true">Manufacturer</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="transporter-tab" data-toggle="tab" href="#transporter"  aria-selected="false">Transporter</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="truck-tab" data-toggle="tab" href="#truck" aria-selected="false">Vehicle</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="driver-tab" data-toggle="tab" href="#driver" aria-selected="false">Driver</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="product-tab" data-toggle="tab" href="#product" aria-selected="false">Product</a>
                      </li>
                  </ul>
            </div></div>
        <div class="tab-content" id="myTabContent">
  <div class="tab-pane  fade" ng-class="showTab==''? 'show active':''" id="manufacturer" role="tabpanel" aria-labelledby="manufacturer-tab">
   <?php  include('Requests_Manufacturer.php'); ?>      

  </div>
  <div class="tab-pane fade" id="transporter" role="tabpanel" aria-labelledby="transporter-tab">
   <?php  include('Requests_Transporter.php'); ?>      
      
  </div>
  <div class="tab-pane fade" id="truck" role="tabpanel" aria-labelledby="truck-tab">
   <?php include('Requests_Truck.php'); ?>      

  </div>
  <div class="tab-pane fade" id="driver" role="tabpanel" aria-labelledby="driver-tab">
   <?php  include('Requests_Driver.php'); ?>      


  </div>
  <div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="product-tab">
   <?php  include('Requests_Product.php'); ?>      


  </div>
</div></div></div>



  <div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Confirm
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for=""> Reason</label><input class="form-control" placeholder="Enter Reason" type="text">
              </div>
            </form>
          </div>
          <div class="modal-footer text-left">
            <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="button"> Confirm</button>
          </div>
        </div>
      </div>
    </div>
 





<div ng-show="!fgShowHide && !viewProfileDetail" style="display:none">
    <div class="element-wrapper">
                <h6 class="element-header">{{datatype}} Customer</h6>
                <div class="element-box"><div class="form-desc"><button type="button"  ng-click="showForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Back </b></button></div>
    <!-- END Form Elements Title -->
    <form action="#"  name="myForm" method="post" enctype="multipart/form-data"  onsubmit="return false;">

        <div class="form-group" ng-class="nameError ? 'has-error':''">
            <label>Name</label>
            <input type="text" name="name" id="name" ng-model="item.Name"  class="form-control" placeholder="Name" ng-focus="hideErrorMsg('nameError')">
            <span ng-show="nameError" ng-bind="errors.nameMsg" class="help-block"></span>
        </div>
        <div class="form-group" ng-class="companynameError ? 'has-error':''">
            <label>Company Name</label>
            <input type="text" name="companyname" id="companyname" ng-model="item.CompanyName"  class="form-control" placeholder="Company Name" ng-focus="hideErrorMsg('companynameError')">
            <span ng-show="companynameError" ng-bind="errors.companynameMsg" class="help-block"></span>
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
            <select name="country" id="country" ng-model="item.Country"  class="form-control" ng-focus="hideErrorMsg('countryError')">
                <option selected>Select Country</option>
            </select>
            <span ng-show="countryError" ng-bind="errors.countryMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="stateError ? 'has-error':''">
            <label>Select State</label>
            <select name="state" id="state" ng-model="item.State"  class="form-control" ng-focus="hideErrorMsg('stateError')">
                <option selected>Select State</option>
            </select>
            <span ng-show="stateError" ng-bind="errors.stateMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>
        <div class="form-group" ng-class="cityError ? 'has-error':''">
            <label>Select City</label>
            <select name="city" id="city" ng-model="item.City"  class="form-control" ng-focus="hideErrorMsg('cityError')">
                <option selected>Select City</option>
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

<div ng-show="viewProfileDetail == 'Manufacture' || viewProfileDetail == 'Transporter' " style="display:none">
    <div class="element-wrapper">

      <div class="row m-b">

         <div class="" ng-class="viewtype=='Edited' ? 'col-md-12' : 'col-md-8 offset-md-2'">
           <h6 class="element-header"><a href="<?php echo base_url(); ?>index.php/#/Requests" class="btn btn-sm btn-success"   >Back </a> {{viewProfileDetail}} Detail</h6>
          </div>
      </div>

    	<div class="row m-b">
        	 <div class="" ng-class="viewtype=='Edited' ? 'col-md-6' : 'col-md-8 offset-md-2'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-avatar" style="background-image: url(<?php echo base_url(); ?>/static/img/avatar1.jpg)"></div>
              <div class="ecc-name">
              {{MCompanyName}}
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Email </div>
                <div class="sub-info-value"><a href="#">{{MEmail}}</a><strong class="badge badge-danger" style="float: right;"><i class="os-icon os-icon-close " style="font-weight: bold;"></i></strong></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Phone Number</div>
                <div class="sub-info-value"><a href="#">839.938.3944</a> <strong class="badge badge-success" style="float: right;"><i class="os-icon os-icon-checkmark " ></i></strong></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Address</div>
                <div class="sub-info-value">1726 Praduman Park, Block 104<br/>New Delhi, IN 10001</div>
              </div>

               <div class="ecc-sub-info-row">
                <div class="sub-info-label">GSTIN / UIN Number</div>
                <div class="sub-info-value">255588778781</div>
              </div>
               <div class="ecc-sub-info-row">
                <div class="sub-info-label">Vat Number</div>
                <div class="sub-info-value">5487878878</div>
              </div>


            </div>   
            <div ng-if="viewtype=='New'">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div>
      </div>
        
        </div> 

        <div class="col-md-6 " ng-if="viewtype=='Edited'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-avatar" style="background-image: url(<?php echo base_url(); ?>/static/img/avatar1.jpg)"></div>
              <div class="ecc-name">
              {{CompanyName}}
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Email </div>
                <div class="sub-info-value"><a href="#">{{Email}}</a><!-- <strong class="badge badge-danger" style="float: right;"><i class="os-icon os-icon-close " style="font-weight: bold;"></i></strong> -->
                </div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Phone Number</div>
                <div class="sub-info-value"><a href="#">886.447.2103</a> <!-- <strong class="badge badge-success" style="float: right;"><i class="os-icon os-icon-checkmark " ></i></strong> -->
                </div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Address</div>
                <div class="sub-info-value">18 Shiv Shakti Colony,<br/>Kolkta, IN 20001</div>
              </div>

               <div class="ecc-sub-info-row">
                <div class="sub-info-label">GSTIN / UIN Number</div>
                <div class="sub-info-value">89898998998</div>
              </div>
               <div class="ecc-sub-info-row">
                <div class="sub-info-label">Vat Number</div>
                <div class="sub-info-value">32932898932</div>
              </div>


            </div>
      </div>
        
        </div>

      
		</div>
      <div class="row m-b" ng-if="viewtype=='Edited'">
          <div class="text-center col-md-12">
           <div class="ecommerce-customer-info">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div></div>
    </div>


    </div>              
</div>

<div ng-show="viewProfileDetail == 'Vehicle'" style="display:none">
    <div class="element-wrapper">

      <div class="row m-b">

         <div class="" ng-class="viewtype=='Edited' ? 'col-md-12' : 'col-md-8 offset-md-2'">
           <h6 class="element-header"><a href="<?php echo base_url(); ?>index.php/#/Requests" class="btn btn-sm btn-success"   >Back </a> {{viewProfileDetail}} Detail</h6>
          </div>
      </div>

      <div class="row m-b">
           <div class="" ng-class="viewtype=='Edited' ? 'col-md-6' : 'col-md-8 offset-md-2'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-name">
               HARESHBHAI ADIYECHA
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">RC NO. </div>
                <div class="sub-info-value"><a href="#">Abc123</a><strong class="badge badge-danger" style="float: right;" ng-if="viewtype=='Edited'"><i class="os-icon os-icon-close " style="font-weight: bold;"></i></strong></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">VEHICLE NUMBER</div>
                <div class="sub-info-value"><a href="#">DEL-01-2011</a> <strong class="badge badge-success" style="float: right;" ng-if="viewtype=='Edited'"><i class="os-icon os-icon-checkmark " ></i></strong></div>
              </div>


            </div>   
            <div ng-if="viewtype=='New'">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div>
      </div>
        
        </div> 

        <div class="col-md-6 " ng-if="viewtype=='Edited'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-name">
               HARESHBHAI ADIYECHA
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">RC NO. </div>
                <div class="sub-info-value"><a href="#">Cde123</a></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">VEHICLE NUMBER</div>
                <div class="sub-info-value"><a href="#">DEL-01-1555</a> </div>
              </div>


            </div>
      </div>
        
        </div>

      
    </div>
      <div class="row m-b" ng-if="viewtype=='Edited'">
          <div class="text-center col-md-12">
           <div class="ecommerce-customer-info">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div></div>
    </div>


    </div>              
                                  
</div>




<div ng-show="viewProfileDetail == 'Driver'" style="display:none">
    <div class="element-wrapper">

      <div class="row m-b">

         <div class="" ng-class="viewtype=='Edited' ? 'col-md-12' : 'col-md-8 offset-md-2'">
           <h6 class="element-header"><a href="<?php echo base_url(); ?>index.php/#/Requests" class="btn btn-sm btn-success"   >Back </a> {{viewProfileDetail}} Detail</h6>
          </div>
      </div>

      <div class="row m-b">
           <div class="" ng-class="viewtype=='Edited' ? 'col-md-6' : 'col-md-8 offset-md-2'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-name">
               HARESHBHAI ADIYECHA
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Driver Name</div>
                <div class="sub-info-value">HARESHBHAI ADIYECHA</div>
              </div>
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Phone No. </div>
                <div class="sub-info-value"><a href="#">9824453899</a><strong class="badge badge-danger" style="float: right;" ng-if="viewtype=='Edited'"><i class="os-icon os-icon-close " style="font-weight: bold;"></i></strong></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">LICENSE NO</div>
                <div class="sub-info-value"><a href="#">gj0310202020</a> <strong class="badge badge-success" style="float: right;" ng-if="viewtype=='Edited'"><i class="os-icon os-icon-checkmark " ></i></strong></div>
              </div>


            </div>   
            <div ng-if="viewtype=='New'">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div>
      </div>
        
        </div> 

        <div class="col-md-6 " ng-if="viewtype=='Edited'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-name">
               HARESHBHAI ADIYECHA
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Driver Name</div>
                <div class="sub-info-value">SITARAM FAUNDRI</div>
              </div>
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Phone No. </div>
                <div class="sub-info-value"><a href="#">8787878788</a></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">LICENSE NO</div>
                <div class="sub-info-value"><a href="#">gj0310201020</a> </div>
              </div>


            </div>
      </div>
        
        </div>

      
    </div>
      <div class="row m-b" ng-if="viewtype=='Edited'">
          <div class="text-center col-md-12">
           <div class="ecommerce-customer-info">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div></div>
    </div>


    </div>              
                                  
</div>



<div ng-show="viewProfileDetail == 'Product'" style="display:none">
    <div class="element-wrapper">

      <div class="row m-b">

         <div class="" ng-class="viewtype=='Edited' ? 'col-md-12' : 'col-md-8 offset-md-2'">
           <h6 class="element-header"><a href="<?php echo base_url(); ?>index.php/#/Requests" class="btn btn-sm btn-success"   >Back </a> {{viewProfileDetail}} Detail</h6>
          </div>
      </div>

      <div class="row m-b">
           <div class="" ng-class="viewtype=='Edited' ? 'col-md-6' : 'col-md-8 offset-md-2'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-name">
               Abc Company
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Product Name</div>
                <div class="sub-info-value">Bricks001</div>
              </div>
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">MIN DELIVERY DAYS </div>
                <div class="sub-info-value"><a href="#">20</a></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">PRICE</div>
                <div class="sub-info-value"><a href="#">299</a> </div>
              </div>
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Description</div>
                <div class="sub-info-value">This is new product diplay of data</div>
              </div>
              

            </div>   
            <div ng-if="viewtype=='New'">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div>
      </div>
        
        </div> 

        <div class="col-md-6 " ng-if="viewtype=='Edited'">
            <div class="ecommerce-customer-info">
            <div class="ecommerce-customer-main-info">
              <div class="ecc-name">
               Abc Company
              </div>
            </div>
            <div class="ecommerce-customer-sub-info">
              
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Product Name</div>
                <div class="sub-info-value">Bricks0332</div>
              </div>
              
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">MIN DELIVERY DAYS </div>
                <div class="sub-info-value"><a href="#">10</a></div>
              </div>

              <div class="ecc-sub-info-row">
                <div class="sub-info-label">PRICE</div>
                <div class="sub-info-value"><a href="#">309</a> </div>
              </div>
              <div class="ecc-sub-info-row">
                <div class="sub-info-label">Description</div>
                <div class="sub-info-value">This is changed product diplay of data</div>
              </div>


            </div>
      </div>
        
        </div>

      
    </div>
      <div class="row m-b" ng-if="viewtype=='Edited'">
          <div class="text-center col-md-12">
           <div class="ecommerce-customer-info">
              <button   ng-click="saveItem()"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Approve</button>
              <button class="btn btn-warning cancel" data-target=".bd-example-modal-sm" data-toggle="modal"><i class="icon-close icon-white"></i>Reject</button>
            </div></div>
    </div>


    </div>              
                                  
</div>


</div>
<?php else: ?>
<p> Not permitted</p>
<?php endif; ?>
