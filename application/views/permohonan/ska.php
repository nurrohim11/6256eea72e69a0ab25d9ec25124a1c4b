<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Tambah Permohonan SKA
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="portlet light portlet-fit portlet-form bordered">
                    <div class="portlet-body">
                        <!-- BEGIN FORM-->
                        <form id="form_ska">
                        	<input type="hidden" name="token" id="token" value="0.4103457145135247">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="">Tanggal Permohonan
                                        <span class="required"> * </span>
                                    </label>
                                    <input type="text" readonly="readonly" name="tgl_permohonan" id="tgl_permohonan" value="<?php echo date("Y-m-d") ?>" class="form-control" />
                                </div>

                                <?php
                                $level = level();
                                if($level == 1){ ?>
                                <div class="form-group">
                                    <label class="">Assosiasi
                                        <span class="required"> * </span>
                                    </label>
				                    <select class="form-control" id="assosiasi" required="required" name="assosiasi">
				                    	<option></option>
				                    	<?php foreach($assosiasi as $row){ ?>
				                    		<option value="<?php echo $row->id ?>"><?php echo $row->nama ?> : <?php echo $row->assosiasi ?></option>
				                    	<?php } ?>
				                    </select>
                                </div>
                            	<?php } ?>

                                <div class="form-group">
                                	<label><button type="button" class="btn default" id="add_bu" onclick="add_personal($('#token').val())">Tambah Personal</button></label>
                                </div>
                                <!-- <div class="form-group"> -->
				                    <div class="row">
				                        <div class="col-md-12">
	                                    <table class="table table-striped table-bordered table-hover" id="tbl_ska">
	                                        <thead>
	                                            <tr>
	                                                <th> # </th>
	                                                <th> NIK </th>
	                                                <th> Nama </th>
	                                                <th> Total Biaya </th>
	                                                <th style="width: 3%"> # </th>
	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                        </tbody>
	                                    </table>
	                					<!-- <span class="required" style="color: red"> * Biaya sudah termasuk lpjkn dan lpjkp</span> -->
	                            <!-- END EXAMPLE TABLE PORTLET-->
				                        </div>
				                    </div>
				                <!-- </div> -->
                                <div class="form-group">
                                    <label class="">Tanggal Pembayaran
                                        <span class="required"> * </span>
                                    </label>
                                    <input type="text" value="<?php echo date("Y-m-d") ?>" readonly="readonly" name="tgl_pembayaran" id="tgl_pembayaran" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label class="">Bukti Setoran
                                        <span class="required"> * </span>
                                    </label>
                                    <input type="file" readonly="readonly" value="<?php echo date("Y-m-d") ?>"  name="bukti_setoran" id="bukti_setoran" class="form-control" />
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <button type="button" id="btn_cancel_ska" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                    <!-- END VALIDATION STATES-->
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
</div>

<!-- Modal Badan Usaha -->
<div class="modal fade bs-modal-lg" id="modal_personal" role="dialog" aria-hidden="true"data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<form id="form_personal_ska">
        		<input type="hidden" name="token_permohonan" id="token_permohonan">
        		<input type="hidden" name="token_klasifikasi" id="token_klasifikasi">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Tambah Personal</h4>
	            </div>
	            <div class="modal-body">
	                <div class="form-group">
	                    <label class="">NIK
	                        <span class="required"> * </span>
	                    </label>
	                    <input type="text" name="nik" required="required" id="nik" class="form-control" />
	                </div>
	                <div class="form-group">
	                    <label class="">Nama
	                        <span class="required"> * </span>
	                    </label>
	                    <input type="text" name="nama_personal" required="required" id="nama_personal" class="form-control" />
	                </div>
	                <div class="row">
	                	<div class="col-md-6">
			                <div class="form-group">
			                    <label class="">Jenis Kelamin
			                        <span class="required"> * </span>
			                    </label>
			                    <div class="mt-radio-list" style="display: -webkit-box;">
                                    <label class="mt-radio">
                                        <input type="radio" name="jenis_kelamin" id="optionsRadios22" value="Laki Laki"> Laki Laki
                                        <span></span>
                                    </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="mt-radio">
                                        <input type="radio" name="jenis_kelamin" id="optionsRadios23" value="Perempuan"> Perempuan
                                        <span></span>
                                    </label>
                                </div>
			                </div>
	                	</div>
	                	<div class="col-md-6">
			                <div class="form-group">
			                    <label class="">Tanggal Lahir
			                        <span class="required"> * </span>
			                    </label>
			                    <input type="text" name="tgl_lahir" readonly="readonly" required="required" id="tgl_lahir" class="form-control tgl" />
			                </div>
	                	</div>
	                </div>
	                <div class="form-group">
	                    <label class="">Alamat
	                        <span class="required"> * </span>
	                    </label>
	                    <textarea class="form-control" id="alamat" name="alamat"></textarea>
	                </div>
	                <div class="form-group">
	                    <label class="">Kota
	                        <span class="required"> * </span>
	                    </label>
	                    <select class="form-control" id="kota" required="required" name="kota">
	                    	<option></option>
	                    	<?php foreach($kota as $row){ ?>
	                    		<option value="<?php echo $row->id ?>"><?php echo $row->kota ?></option>
	                    	<?php } ?>
	                    </select>
	                </div>
                	<div class="form-group" style="text-align: right;">
	                	<button type="button" class="btn default" id="btn_add_ska"><i class="fa fa-plus"></i></button>
	                </div>
	                <div class="form-group">
	                	<table id="tbl_klasifikasi_ska" class="table table-bordered table-striped table-responsive">
	                		<thead>
		                		<tr>
		                			<th style="width: 20%">Klasifikasi</th>
		                			<th style="width: 20%">Sub Klasifikasi</th>
		                			<th style="width: 20%">Kualifikasi</th>
		                			<th style="width: 20%">Permohonan</th>
		                			<!-- <th  style="width: 19%">Biaya</th> -->
		                			<th style="width: 1%; text-align: center;" >#</th>
		                		</tr>
		                	</thead>
		                	<tbody></tbody>
	                	</table>
	                </div>
	                <!-- <span class="required" style="color: red"> * Biaya belum termasuk lpjkn dan lpjkp</span> -->
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
<!-- END Modal Badan Usaha -->