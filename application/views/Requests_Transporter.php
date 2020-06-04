


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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th><th>Phone No</th><th>Email</th><th>Address</th><th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr ng-repeat="item in list.transporter">
                                <td>{{item.CompanyName}}</td>
                                <td>{{item.MobileNumber}}</td>
                                <td>{{item.Email}}</td>
                                <td>{{item.Address}}</td>
                                <td>
                                    <a class="badge badge-danger" href="" ng-if="item.Status % 2 == 0">New</a>
                                    <a class="badge badge-success" href="" ng-if="item.Status % 2 != 0">Edited</a>
                                </td>
                                <td class="text-center">
                                   <a href="<?php echo site_url(); ?>/#/viewRequestProfile?user=Transporter&type=New" ng-if="item.Status % 2 != 0" class="btn btn-outline-info"> <i class="os-icon os-icon-eye" style="margin-top: -3px;"></i></a>
                                   <a href="<?php echo site_url(); ?>/#/viewRequestProfile?user=Transporter&type=Edited" ng-if="item.Status % 2 == 0" class="btn btn-outline-info"> <i class="os-icon os-icon-eye" style="margin-top: -3px;"></i></a>
                                </td>
                            </tr>
                            <tr ng-show="list.length ==0"><td colspan="10" class="text-center">Customer Not found</td></tr>

                            </tbody></table>



                  </div>

                            <div class="row"><div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="dataTable1_info" role="status" aria-live="polite">Showing {{pagingOptions.currentPage}} to {{totalpaging}} of {{totalItems}} entries</div></div>
                                    <div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers float-right"><ul class="pagination"><li class="paginate_button page-item previous" ng-class="{'disabled': pagingOptions.currentPage == 1}"><a href="javascript:void(0)" ng-click="setPage(pagingOptions.currentPage - 1)" class="page-link">Previous</a></li><li ng-repeat="pages in arrayTwo(pagingOptions.currentPage,totalpaging) track by $index" ng-class="{'active': pages == pagingOptions.currentPage}"  class="paginate_button page-item "><a href="javascript:void(0)" ng-click="setPage(pages)" class="page-link" ng-if="pages !='...'">{{pages}}</a><span href="javascript:void(0)"  data-paging-options="pages" ng-if="pages =='...'" class="page-link">{{pages}}</span></li><li class="paginate_button page-item next" ng-class="{disabled: pagingOptions.currentPage == totalpaging || totalItems == 0}"><a href="javascript:void(0);" ng-click="setPage(pagingOptions.currentPage + 1)" class="page-link">Next</a></li></ul></div></div>
                                </div>
