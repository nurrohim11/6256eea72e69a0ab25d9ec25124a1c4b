<style type="text/css">
	.show{
		display: block;
	}
	.hide {
		display: none;
	}
</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Data User
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
                                <a class="btn green btn-outline btn-circle" id="add_user" href="javascript:void(0);">
                                    <i class="fa fa-plus"></i>
                                    <span class="hidden-xs"> Tambah Data </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                    	<div class="table-container">
	                        <table class="table table-striped table-bordered table-hover" id="tbl_user">
	                            <thead>
	                                <tr>
	                                    <th> # </th>
	                                    <th> NIK </th>
	                                    <th> Nama </th>
	                                    <th> Username </th>
	                                    <th> Alamat </th>
	                                    <th> Kontak </th>
	                                    <!-- <th> Email </th> -->
	                                    <th> Level </th>
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
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
</div>

<!-- Modal User -->
<div class="modal fade bs-modal-lg" id="modal_user" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<form id="form_user">
        		<input type="hidden" name="id" id="id">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Form User</h4>
	            </div>
	            <div class="modal-body">
	                <div class="form-group">
	                    <label class="">NIk
	                        <span class="required"> * </span>
	                    </label>
	                    <input type="text" name="nik" required="required" id="nik" class="form-control" />
	                </div>
	                <div class="form-group">
	                    <label class="">Nama
	                        <span class="required"> * </span>
	                    </label>
	                    <input type="text" name="nama" required="required" id="nama" class="form-control" />
	                </div>
	                <div class="row">
	                	<div class="col-md-6">
			                <div class="form-group">
			                    <label class="">Alamat
			                        <span class="required"> * </span>
			                    </label>
			                    <textarea class="form-control" id="alamat" name="alamat"></textarea>
			                </div>
	                	</div>
	                	<div class="col-md-6">
			                <div class="form-group">
			                    <label class="">Kontak
			                        <span class="required"> * </span>
			                    </label>
			                    <input type="number" name="kontak" required="required" id="kontak" class="form-control" />
			                </div>
	                	</div>
	                </div>
	                <div class="form-group">
	                    <label class="">Email
	                    </label>
	                    <input type="email" name="email" id="email" class="form-control" />
	                </div>
	                <div class="form-group">
	                    <label class="">Username
	                        <span class="required"> * </span>
	                    </label>
	                    <input type="text" name="username" required="required" id="username" class="form-control" />
	                </div>
	                <div class="form-group">
	                    <label class="">Password
	                        <span class="required" id="bintang"> * </span>
	                    </label>
	                    <input type="password" name="password" required="required" id="password" class="form-control" />
	                    <span id="label_pass"></span>
	                </div>
                    <div class="form-group">
                        <label class="">Level
                            <span class="required"> * </span>
                        </label>
	                    <select class="form-control" id="level" required="required" name="level">
	                    	<option></option>
	                    	<?php foreach($level as $row){ ?>
	                    		<option value="<?php echo $row->id ?>"><?php echo $row->level ?></option>
	                    	<?php } ?>
	                    </select>
                    </div>
                    <div class="form-group hide" id="div_assosiasi">
                    	<label>Assosiasi
                    		<span class="required">*</span>
                    	</label>
                    	<select class="form-control" id="assosiasi" name="assosiasi">
                    		<option></option>
                    		<?php foreach($assosiasi as $row){ ?>
                    			<option value="<?php echo $row->kode ?>"><?php echo $row->kode ?> : <?php echo $row->nama ?></option>
                    		<?php } ?>
                    	</select>
                    </div>
                    <div class="form-group hide" id="div_jabatan">
                    	<label>Jabatan
                    		<span class="required">*</span>
                    	</label>
                    	<select class="form-control" id="jabatan" name="jabatan">
                    		<option></option>
                    		<?php foreach($jabatan as $row){ ?>
                    			<option value="<?php echo $row->id ?>"><?php echo $row->jabatan ?></option>
                    		<?php } ?>
                    	</select>
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
<!-- Modal User -->
<div class="modal fade bs-modal-lg" id="modal_menu" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        	<form id="form_menu">
        		<input type="hidden" name="id_user" id="id_user">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                <h4 class="modal-title">Form Menu</h4>
	            </div>
	            <div class="modal-body">
	                <div class="form-group">
	                    <label class="">Nama
	                        <span class="required"> * </span>
	                    </label>
	                    <input type="text" name="nama_user" readonly="readonly" required="required" id="nama_user" class="form-control" />
	                </div>
	                <div class="form-group">
	                	<div id="tree_menu"></div>
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