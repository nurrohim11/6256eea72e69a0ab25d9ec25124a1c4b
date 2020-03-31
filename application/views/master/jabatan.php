<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Data Jabatan
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit portlet-form bordered">
                	<div class="portlet-title">
                        <div class="actions">
                            <div class="btn-group open">
                                <a class="btn green btn-outline btn-circle" id="add_jabatan" href="javascript:void(0);">
                                    <i class="fa fa-plus"></i>
                                    <span class="hidden-xs"> Tambah Data </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                    	<div class="table-container">
	                        <table class="table table-striped table-bordered table-hover" id="tbl_jabatan">
	                            <thead>
	                                <tr>
	                                    <th> # </th>
	                                    <th> Jabatan </th>
	                                    <th style="width: 70px"> # </th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            </tbody>
	                        </table>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
</div>

<!-- Modal User -->
<div class="modal fade bs-modal-lg" id="modal_jabatan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<form id="form_jabatan">
        		<input type="hidden" name="id" id="id">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Form Jabatan</h4>
	            </div>
	            <div class="modal-body">
	                <div class="form-group">
	                    <label class="">Jabatan
	                        <span class="required"> * </span>
	                    </label>
	                    <input type="text" name="jabatan" required="required" id="jabatan" class="form-control" />
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
	                <button type="submit" class="btn green">Save</button>
	            </div>
	        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END Modal User -->
