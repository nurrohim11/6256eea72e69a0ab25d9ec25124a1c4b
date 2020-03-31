<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Berita Acara SBU
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
                        <table class="table table-bordered table-striped table-condensed flip-content" id="tbl_berita_sbu">
                            <thead class="flip-content">
                                <tr>
                                    <th> # </th>
                                    <th> Tanggal Masuk </th>
                                    <th> Assosiasi </th>
                                    <th> NPWP </th>
                                    <th> Nama </th>
                                    <!-- <th> Total </th> -->
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
<div class="modal fade bs-modal-lg" id="modal_cek_bu" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<form id="form_sbu">
	            <div class="modal-header">
	                <button type="button" class="close" onclick="clear_arr_sbu();" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Cek Badan Usaha</h4>
	            </div>
	            <div class="modal-body">
	            	<input type="hidden" name="id_bu" id="id_bu">
	                <div class="form-group" id="bidang_usaha">
	                	<table class='table table-bordered table-stripped' id="tbl_detail_klasifikasi_sbu">
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
                        <button type="button" id="btn_cek" class="btn green">Cek</button>
                        <button type="button" onclick="clear_arr_sbu()" id="btn_cancel" class="btn default">Cancel</button>
	            	</div>
	            </div>
	        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END Modal Badan Usaha -->
