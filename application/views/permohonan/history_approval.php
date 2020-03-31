<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>History Approval
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
                    	<div class="row">
                    		<div class="col-md-2">
                    			<div class="form-group">
	                    			<label>Start date</label>
	                    			<input type="text" name="start_date" id="start_date" readonly="readonly" class="form-control tgl">
	                    		</div>
                    		</div>
                    		<div class="col-md-2">
                    			<div class="form-group">
	                    			<label>End date</label>
	                    			<input type="text" name="end_date" id="end_date" readonly="readonly" class="form-control tgl">
	                    		</div>
                    		</div>
                    		<div class="col-md-4">
                    			<label>&nbsp;</label>
                    			<div class="form-group">
	                    			<button type="button" id="btn_filter" class="btn green">Filter</button>
	                    			<button type="button" id="btn_reset" class="btn btn-default">Reset</button>
	                    		</div>
                    		</div>
                    	</div>
                        <table class="table table-bordered table-striped table-condensed flip-content" id="tbl_history_approval">
                            <thead class="flip-content">
                                <tr>
                                    <th> # </th>
                                    <th> No. Invoice </th>
                                    <th> Assosiasi </th>
                                    <th> Tanggal Masuk </th>
                                    <th> Tanggal Pembayaran </th>
                                    <th> Tanggal Approval </th>
                                    <th> Approved By </th>
                                    <th> Jenis </th>
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
<div class="modal fade bs-modal-lg" id="modal_badan_usaha" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<form id="form_detail_bu">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Detail Badan Usaha</h4>
	            </div>
	            <div class="modal-body">
	            	<table class="table table-striped">
	            		<tr>
	            			<td><b>NO. Invoice</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="no_invoice_bu"></span></td>
	            			<td colspan="2" rowspan="2"><img class="img-thumbnail img-setoran" id="img_bu" style="width: 80px; height: 80px"></td>
	            			<td><b id="status_approval_bu"></b></td>
	            			<!-- <td>
	            				<div id="btn_keuangan_bu">
		            				<button class="btn btn-warning btn-xs btn-sm hide" id="btn_approval_bu">Approval</button><button class="btn btn-danger btn-xs btn-sm hide" id="btn_cancel_approval_bu">Total</button>
	            				</div>
	            			</td> -->
	            		</tr>
	            		<tr>
	            			<td><b>Assosiasi</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="bu_assosiasi"></span></td>
	            			<td><b id="status_rekomendasi_bu"></b></td>
	            		</tr>
	            		<tr>
	            			<td><b>Tanggal Masuk</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="tgl_masuk_bu"></span></td>
	            			<td><b>Tanggal Pembayaran</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="tgl_bayar_bu"></span></td>
	            		</tr>
	            	</table>
	                <div class="form-group">
	                    <label class=""><b>Data Bidang Usaha</b>
	                    </label>
	                </div>
	                <div class="form-group" id="bidang_usaha">
	                	<table class='table table-bordered table-stripped' id="tbl_bidang_usaha">
	                		<thead>
						    	<tr style="background: #f3f3f3">
						    		<td>No.</td>
						    		<td>NPWP</td>
						    		<td>Nama</td>
						    		<td>Kota</td>
						    		<td>Alamat</td>
						    		<td>KBLI</td>
						    	</tr>
						    </thead>
						    <tbody></tbody>
						    <tfoot>
						    	<tr style="background: #f3f3f3">
						    		<td colspan="5" style="text-align: right;"><b>Total Biaya</b></td>
						    		<td><b id="total_biaya_bu">0</b></td>
						    	</tr>
						    </tfoot>
					    </table>
	                </div>
	            </div>
	        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END Modal Badan Usaha -->

<!-- Modal Personal -->
<div class="modal fade bs-modal-lg" id="modal_personal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<form id="form_bu">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Detail Personal</h4>
	            </div>
	            <div class="modal-body">
	            	<table class="table table-striped">
	            		<tr>
	            			<td><b>No. Invoice</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="no_invoice_personal"></span></td>
	            			<td colspan="2" rowspan="2"><img class="img-thumbnail img-setoran" id="img_personal" style="width: 80px; height: 80px"></td>
	            			<td><b id="status_approval_personal"></b></td>
	            			<!-- <td>
	            				<div id="btn_keuangan_personal">
	            					<button class="btn btn-warning hide btn-sm btn-xs" id="btn_approval_personal">Approval</button><button class="btn btn-danger hide btn-sm btn-xs" id="btn_cancel_approval_personal">Tolak</button>
	            				</div>
	            			</td> -->
	            		</tr>
	            		<tr>
	            			<td><b>Assosiasi</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="personal_assosiasi"></span></td>
	            			<td><b id="status_rekomendasi_personal"></b></td>
	            		</tr>
	            		<tr>
	            			<td><b>Tanggal Masuk</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="tgl_masuk_personal"></span></td>
	            			<td><b>Tanggal Pembayaran</b></td>
	            			<td><b>:</b></td>
	            			<td><span id="tgl_bayar_personal"></span></td>
	            		</tr>
	            	</table>
	                <div class="form-group">
	                    <label class=""><b>Data Personal</b>
	                    </label>
	                </div>
	                <div class="form-group" id="personal">
	                	<table class='table table-bordered table-stripped' id="tbl_personal">
	                		<thead>
						    	<tr style="background: #f3f3f3">
						    		<td>No.</td>
						    		<td>NIK</td>
						    		<td>Nama</td>
						    		<td>Alamat</td>
						    		<td>Tgl Lahir</td>
						    		<td>Jenis Kelamin</td>
						    	</tr>
						    </thead>
						    <tbody></tbody>
						    <tfoot>
						    	<tr style="background: #f3f3f3">
						    		<td colspan="5" style="text-align: right;"><b>Total Biaya</b></td>
						    		<td><b id="total_biaya_personal">0</b></td>
						    	</tr>
						    </tfoot>
					    </table>
	                </div>
	            </div>
	        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END Modal Personal -->

<!-- The Modal Image -->
<div class="modal fade" id="modal_image" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	            </div>
	            <div class="modal-body">
	            	<img id="_img" class="img-responsive" style="width: 100%">
	            </div>
	        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
