<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>USBU - Penilaian Assesor
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
                        <form id="form_usbu">
                            <div class="form-body">
                                <div class="row">
                                	<div class="col-md-6">
                                		<div class="form-group">
                                			<input type="hidden" name="id_usaha" name="id_usaha" value="<?php echo $dp->id ?>">
                                			<label for="nama_bu">Nama Bidang Usaha</label>
                                			<input type="text" name="nama_bu" id="nama_bu" readonly="readonly" class="form-control form-tulisan" value="<?php echo $dp->nama_bu ?>">
                                		</div>
                                		<div class="form-group">
                                			<label for="asosiasi">Assosiasi</label>
                                			<input type="text" name="asosiasi" id="asosiasi" readonly="readonly" class="form-control form-tulisan" value="<?php echo $dp->asosiasi ?>">
                                		</div>
                                		<div class="form-group">
                                			<label for="npwp">NPWP</label>
                                			<input type="text" name="npwp" id="npwp" readonly="readonly" class="form-control form-tulisan" value="<?php echo $dp->npwp ?>">
                                		</div>
                                	</div>
                                	<div class="col-md-6">
                                		<div class="form-group">
                                			<label for="tgl_permohonan">Tanggal Permohonan</label>
                                			<input type="text" name="tgl_permohonan" id="tgl_permohonan" readonly="readonly" class="form-control form-tulisan" value="<?php echo $dp->tgl_berkas_masuk ?>">
                                		</div>
                                		<div class="form-group">
                                			<label for="kota">Kota</label>
                                			<input type="text" name="kota" id="kota" readonly="readonly" class="form-control form-tulisan" value="<?php echo ucfirst(strtolower($dp->ket_kota)) ?>">
                                		</div>
                                		<div class="form-group">
                                			<label for="alamat">Alamat</label>
                                			<input type="text" name="alamat" id="alamat" readonly="readonly" class="form-control form-tulisan" value="<?php echo $dp->alamat ?>">
                                		</div>
                                	</div>
                                </div>
                                <div class="row">
                                	<div class="col-md-12">
                                		<label>Detail Klasifikasi</label>
                                	</div>
                                	<div class="col-md-12">
                                		<table class="table table-bordered table-stripped">
                                			<thead>
                                				<tr>
	                                				<th style="width: 1%">No</th>
	                                				<th style="width: 10%">Klasifikasi</th>
	                                				<th style="width: 15%">Sub Klasifikasi</th>
	                                				<th style="width: 10%">Kualifikasi</th>
	                                				<th style="width: 10%">Ketua Asesor</th>
	                                				<th style="width: 10%">Asesor 2</th>
	                                				<th style="width: 10%">Asesor 3</th>
	                                				<th style="width: 10%">Hasil Kompeten</th>
	                                			</tr>
                                			</thead>
                                			<tbody>
                                				<?php $no=0; foreach($dk as $row){ $no++; ?>
                                				<tr>
                                					<td><?php echo $no ?><input type="hidden" name="id[]" id="id" value="<?php echo $row->id ?>"></td>
                                					<td><?php echo $row->deskripsi_klasifikasi ?></td>
                                					<td><?php echo $row->deskripsi_sub_klasifikasi ?></td>
                                					<td><?php echo $row->kode_kualifikasi ?></td>
                                					<td>
                                						<select class="form-control ketua_ass" name="ketua_assesor[]">
                                							<option></option>
                                							<?php foreach($ass as $row) { ?>
                                								<option value="<?php echo $row->id ?>"><?php echo $row->nama ?></option>
                                							<?php } ?>
                                						</select>
                                					</td>
                                					<td>
                                						<select class="form-control assesor_1" name="assesor_1[]">
                                							<option></option>
                                							<?php foreach($ass as $row) { ?>
                                								<option value="<?php echo $row->id ?>"><?php echo $row->nama ?></option>
                                							<?php } ?>
                                						</select>
                                					</td>
                                					<td>
                                						<select class="form-control assesor_2" name="assesor_2[]">
                                							<option></option>
                                							<?php foreach($ass as $row) { ?>
                                								<option value="<?php echo $row->id ?>"><?php echo $row->nama ?></option>
                                							<?php } ?>
                                						</select>
                                					</td>
                                					<td>
                                						<select class="form-control hasil" name="hasil[]">
                                							<option></option>
                                							<?php foreach($h as $row) { ?>
                                								<option value="<?php echo $row->id ?>"><?php echo $row->hasil ?></option>
                                							<?php } ?>
                                						</select>
                                					</td>
                                				</tr>
                                				<?php } ?>
                                			</tbody>
                                		</table>
                                	</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn green">Selesai</button>
                                        <button type="button" id="cancel_sbu" class="btn default">Cancel</button>
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
