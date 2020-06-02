<script src="static/appScript/ProductCtrl.js?3kdefd"></script>
<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<div ng-controller="ProductCtrl">
<div class="element-wrapper" ng-show="fgShowHide">
                <h6 class="element-header">
                  Manage Product
                </h6>
                <div class="element-box">
                  <div class="form-desc">
                        <button type="button" ng-show="auth.insert" ng-click="showForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Add </b></button>

                  </div>
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
                                <th>Manufacturer Name</th><th>Product Name</th><th>Min Delivery Days</th><th>Price</th><th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Manufacturer Name</th><th>Product Name</th><th>Min Delivery Days</th><th>Price</th><th>Description</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            
                        <tr ng-repeat="item in list">
                                <td>{{item.CompanyName}}</td>
                                <td>{{item.PName}}</td>
                                <td>{{item.PMinDeliveryDays}}</td>
                                <td>{{item.PPrice}}</td>
                                <td>{{item.PDescription}}</td>
                                <td class="text-center">
                                    <button class="mb-2 btn btn-outline-info " ng-click="editItem(item)" type="button">  <i class="os-icon os-icon-ui-49" style="margin-top: -3px;"></i></button>
                                    <button class="ml-0 mb-2 btn btn-outline-danger " ng-click="deleteItem(item.PManuId)" type="button"> <i class="os-icon os-icon-ui-15" style="margin-top: -3px;"></i></button>
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












<div ng-show="!fgShowHide" style="display:none">
    <div class="element-wrapper">
                <h6 class="element-header">{{datatype}} Product</h6>
                <div class="element-box"><div class="form-desc"><button type="button"  ng-click="hideForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Back </b></button></div>
    <!-- END Form Elements Title -->
    <form action="#"  name="myForm" method="post" enctype="multipart/form-data"  onsubmit="return false;">


        <div class="form-group" ng-class="countryError ? 'has-error':''">
            <label>Select Manufacture</label>
            
            <select name="manufacture" id="manufacture" ng-model="item.Manufacture"  class="form-control" ng-focus="hideErrorMsg('manufactureError')"  class="form-control">
                <option value="null">Select Manufacture</option>
                <option  ng-repeat="manufacture in ManufactureList" value="{{manufacture.UserId}}" ng-selected="item.ManufactureId == manufacture.CId">{{manufacture.CompanyName}}</option>

            </select>
            <span ng-show="manufactureError" ng-bind="errors.manufactureMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>

        <div class="form-group" ng-class="nameError ? 'has-error':''">
            <label>Product Name</label>
            <input type="text" name="name" id="name" ng-model="item.Name"  class="form-control" placeholder="City Name" ng-focus="hideErrorMsg('nameError')">
            <span ng-show="nameError" ng-bind="errors.nameMsg" class="help-block"></span>
        </div>

        <div class="form-group" ng-class="mindayError ? 'has-error':''">
            <label>Min Delivery Days</label>
            <input type="text" name="minday" id="minday" ng-model="item.MinDay"  class="form-control" placeholder="Min Delivery Days" ng-focus="hideErrorMsg('mindayError')">
            <span ng-show="mindayError" ng-bind="errors.mindayMsg" class="help-block"></span>
        </div>
        <div class="form-group" ng-class="priceError ? 'has-error':''">
            <label>Price</label>
            <input type="text" name="price" id="price" ng-model="item.Price"  class="form-control" placeholder="Price" ng-focus="hideErrorMsg('priceError')">
            <span ng-show="priceError" ng-bind="errors.priceMsg" class="help-block"></span>
        </div>
        <div class="form-group" ng-class="descriptionError ? 'has-error':''">
            <label>Description</label>
            <textarea name="description" id="description" ng-model="item.Description"  class="form-control" placeholder="Address" ng-focus="hideErrorMsg('descriptionError')" rows="5"></textarea>
            <span ng-show="descriptionError" ng-bind="errors.descriptionMsg" class="help-block form-text text-muted form-control-feedback"></span>
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
<?php else: ?>
<p> Not permitted</p>
<?php endif; ?>
