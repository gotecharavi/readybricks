<script src="static/appScript/NotificationCtrl.js"></script>
<script>function getAuth(){ <?php echo $fx ?>;}</script>
<?php if ($read): ?>
<div ng-controller="NotificationCtrl">
<div class="element-wrapper" ng-show="fgShowHide">
                <h6 class="element-header">
                  Manage Notification
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
                            </div>
                        </div>
                        <table  width="100%" class="table table-lightborder">
                        <thead>
                            <tr>
                                <th>Title</th><th>Description</th><th>Image</th><th>Send To</th>

                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Country Name</th><th>State Name</th><th>District Name</th><th>City Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr ng-repeat="item in list">
                                <td>{{item.NTitle}}</td>
                                <td>{{item.NDescription}}</td>
                                <td><img src="<?php echo base_url(); ?>uploads/{{item.NImage}}" width="120px" ng-if="item.NImage !=''"></td>
                                <td>{{item.NRoleId}}</td>
                                <td class="text-center">
                                    <button class="mb-2 btn btn-outline-info " ng-click="editItem(item)" type="button">  <i class="os-icon os-icon-ui-49" style="margin-top: -3px;"></i></button>
                                    <button class="ml-0 mb-2 btn btn-outline-danger " ng-click="deleteItem(item)" type="button"> <i class="os-icon os-icon-ui-15" style="margin-top: -3px;"></i></button>
                                </td>
                            </tr>
                            <tr ng-show="list.length ==0"><td colspan="10" class="text-center">Notification Not found</td></tr>

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
                <h6 class="element-header">{{datatype}} Notification</h6>
                <div class="element-box"><div class="form-desc"><button type="button"  ng-click="hideForm()" class="btn btn-success" ><i class="icon-plus icon-white"></i><b> Back </b></button></div>
    <!-- END Form Elements Title -->
    <form action="#"  name="myForm" method="post" enctype="multipart/form-data"  onsubmit="return false;">
        <div class="form-group" ng-class="sendtoError ? 'has-error':''">
            <label>Select Send To</label>
            <select name="sendto" id="sendto" ng-model="item.SendTo"  class="form-control" ng-focus="hideErrorMsg('countryError')" ng-change="getUsersList()">
                <option selected value="">Select Send To</option>
                <option  value="All">All</option>
                <option  value="2">Customer</option>
                <option  value="3">Manufacture</option>
                <option  value="4">Transporter</option>
                <option  value="6">Driver</option>
            </select>
            <span ng-show="sendtoError" ng-bind="errors.sendtoMsg" class="help-block form-text text-muted form-control-feedback"></span>
        </div>

        <div class="form-group" ng-class="titleError ? 'has-error':''">
            <label>Title</label>
            <input type="text" name="title" id="title" ng-model="item.Title"  class="form-control" placeholder="Title" ng-focus="hideErrorMsg('titleError')">
            <span ng-show="titleError" ng-bind="errors.titleMsg" class="help-block"></span>
        </div>
        <div class="form-group" ng-class="descriptionError ? 'has-error':''">
            <label>Description</label>
            <textarea  name="description" id="description" ng-model="item.Description"  class="form-control"ng-focus="hideErrorMsg('descriptionError')"></textarea>
            <span ng-show="descriptionError" ng-bind="errors.descriptionMsg" class="help-block"></span>
        </div>

        <div class="form-group" ng-class="imageError ? 'has-error':''">
            <label>Select Image</label>
            <br/>
            <input type="file"  name="image" id="image" ng-model="item.image" class="form-control" placeholder="image" onchange="angular.element(this).scope().getfilename(this)">
            <img  id="baseimagename"  width="100px" height="80px">
            <span ng-show="imageError" ng-bind="errors.imageMsg" class="help-block form-text text-muted form-control-feedback"></span>
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
