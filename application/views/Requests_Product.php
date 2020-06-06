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
                                <th>Manufacturer Name</th><th>Product Name</th><th>Min Delivery Days</th><th>Price</th><th>Description</th><th style="width:10%">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Manufacturer Name</th><th>Product Name</th><th>Min Delivery Days</th><th>Price</th><th>Description</th><th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <tr  ng-repeat="item in list.products">
                                <td>{{item.CompanyName}}</td>
                                <td>{{item.PName}}</td>
                                <td>{{item.PDescription}}</td>
                                <td>{{item.PMinDeliveryDays}}</td>
                                <td>{{item.PPrice}}</td>
                                <td>
                                    <a class="badge badge-danger" href="" ng-if="((item.PStatus % 2) == 0 && (item.isAccount=='2'))">Rejected</a>
                                    <a class="badge badge-danger" href="" ng-if="((item.PStatus % 2 == 0 && item.isAccount!=='2'))">New</a>
                                    <a class="badge badge-success" href="" ng-if="item.PStatus % 2 != 0">Edited</a>
                                </td>

                                <td class="text-center" style="width:10%">
                                   <a href="<?php echo site_url(); ?>/#/viewRequestProfile?user=Product&type=New&id={{item.ProductId}}" ng-if="item.PStatus % 2 != 0" class="btn btn-outline-info" style="margin-top: -3px;"> <i class="os-icon os-icon-eye" ></i></a>
                                   <a href="<?php echo site_url(); ?>/#/viewRequestProfile?user=Product&type=Edited&id={{item.ProductId}}" ng-if="item.PStatus % 2 == 0" class="btn btn-outline-info" style="margin-top: -3px;"> <i class="os-icon os-icon-eye" ></i></a>

                                </td>
                            </tr>
                            
                            <tr ng-show="list.length ==0"><td colspan="10" class="text-center">Customer Not found</td></tr>

                            </tbody></table>
                  </div>

                            <div class="row"><div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="dataTable1_info" role="status" aria-live="polite">Showing {{pagingOptions.currentPage}} to 3 of 3 entries</div></div>
                                    <div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers float-right"><ul class="pagination"><li class="paginate_button page-item previous" ng-class="{'disabled': pagingOptions.currentPage == 1}"><a href="javascript:void(0)" ng-click="setPage(pagingOptions.currentPage - 1)" class="page-link">Previous</a></li><li   class="paginate_button page-item "><a href="javascript:void(0)"  class="page-link" ng-if="pages !='...'">1</a><span href="javascript:void(0)"  data-paging-options="pages" ng-if="pages =='...'" class="page-link">{{pages}}</span></li><li class="paginate_button page-item next" ng-class="{disabled: pagingOptions.currentPage == totalpaging || totalItems == 0}"><a href="javascript:void(0);" ng-click="setPage(pagingOptions.currentPage + 1)" class="page-link">Next</a></li></ul></div></div>
                                </div>
