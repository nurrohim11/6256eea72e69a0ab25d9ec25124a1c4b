<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Berita Acara SKA
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
            	<div class="portlet box green">
                    <div class="portlet-body flip-scroll">
                        <table class="table table-bordered table-striped table-condensed flip-content" id="tbl_berita_ska">
                            <thead class="flip-content">
                                <tr>
                                    <th> # </th>
                                    <th> NIK </th>
                                    <th> Nama </th>
                                    <th> Alamat </th>
                                    <th> Assosiasi </th>
                                    <th> Tanggal Masuk </th>
                                    <th> Total </th>
                                    <th> # </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
</div>

<!-- Modal Badan Usaha -->
<div class="modal fade bs-modal-lg" id="modal_cek_ska" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<form id="form_sbu">
	            <div class="modal-header">
	                <button type="button" class="close" onclick="clear_arr_ska();" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Cek Personal SKA</h4>
	            </div>
	            <div class="modal-body">
	            	<input type="hidden" name="id_personal" id="id_personal">
	                <div class="form-group" id="bidang_usaha">
	                	<table class='table table-bordered table-stripped' id="tbl_detail_klasifikasi_ska">
	                		<thead>
						    	<tr>
						    		<td>#</td>
						    		<td>Klasifikasi</td>
						    		<td>Sub Klasifikasi</td>
						    		<td>Kualifikasi</td>
						    		<td>Jenis</td>
						    		<td>Biaya</td>
						    	</tr>
						    </thead>
						    <tbody></tbody>
					    </table>
	                </div>
	            </div>
	            <div class="modal-footer">
	            	<div class="form-group">
                        <button type="button" id="btn_cek_ska" class="btn green">Cek</button>
                        <button type="button" onclick="clear_arr_ska()" id="btn_cancel" class="btn default">Cancel</button>
	            	</div>
	            </div>
	        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END Modal Badan Usaha -->
