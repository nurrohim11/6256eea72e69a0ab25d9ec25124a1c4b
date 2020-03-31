$(document).ready(function(){
	$('.tgl').datepicker({
		format:"yyyy-mm-dd",
		autoclose:true,	
	})
})

var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();
date_now = yyyy+'-'+mm+'-'+dd;

const approval_permohonan=(idx)=>{
	bootbox.confirm("Apakah anda yakin ingin mengapproval permohonan ini ?", function (event) {
		if(event == true){
			$.ajax({
				url:base_url+"permohonan/prosess_approval_permohonan",
				data:{
					id:idx
				},
				method:"get",
				dataType:"json",
				async:true,
		        beforeSend : function(){
		            App.blockUI({
		                target: '#tbl_approval_permohonan',
		                overlayColor: 'none',
		                cenrerY: true,
		                animate: true
		            });
		        },
		        complete : function(){
		            App.unblockUI('#tbl_approval_permohonan');
		        },
		        success:(res)=>{
		        	if(res.status== true){
		        		$('#tbl_approval_permohonan').DataTable().ajax.reload();
		        		toastr.success(res.message);
		        	}else{
		        		toastr.error(res.message);
		        	}
		        },
		        error:(err)=>{
		        	console.log(err);
		        }
			})
		}
	})
}

function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}

const view_permohonan_bu=(idx)=>{
	$.ajax({
		url:base_url+"permohonan/view_permohonan_bu",
		data:{
			id:idx
		},
		method:"get",
		dataType:"json",
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_approval_permohonan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_approval_permohonan');
        },
		success:function(res){
			if(res.status == true){
				$("#tbl_bidang_usaha > tbody").html("");
				$('#modal_badan_usaha').modal('show');
				// if(res['response'].level_user == 1 || res['response'].level_user == 3){
				// 	$('#btn_approval_bu').removeClass('hide');
				// 	$('#btn_cancel_approval_bu').removeClass('hide');
				// }else{
				// 	$('#btn_cancel_approval_bu').addClass('hide');
				// 	$('#btn_approval_bu').addClass('hide');
				// }
				$('#img_bu').attr('src',res['response'].bukti_setoran);
				$('#img_bu').attr('data-img',res['response'].bukti_setoran);

				$('#img_bu').click(()=>{
					$('#modal_image').modal('show');
					$('#_img').attr('src',res['response'].bukti_setoran);
				})
				
				$("#no_invoice_bu").html(res['response'].invoice);
				$("#tgl_masuk_bu").html(res['response'].tgl_masuk);
				$("#tgl_bayar_bu").html(res['response'].tgl_pembayaran);
				$("#status_approval_bu").html(res['response'].status_keuangan);
				$("#status_rekomendasi_bu").html(res['response'].status_rekomendasi);
				$('#bu_assosiasi').html(res['response'].nama_user+' | '+res['response'].assosiasi);
				var tbl_bidang_usaha = $('#tbl_bidang_usaha');
				var bu = res['response']['badan_usaha'];
				var total_biaya=0;
				$.each(bu, function(i, order){
					var no = parseInt(i)+parseInt(1);
					tbl_bidang_usaha.append(
						"<tr>\
							<td>"+no+"</td>\
							<td>"+bu[i].npwp+"</td>\
							<td>"+bu[i].nama+"</td>\
							<td>"+bu[i].kota+"</td>\
							<td>"+bu[i].alamat+"</td>\
							<td>"+bu[i].kbli+"</td>\
						</tr>\
						"
					);
					tbl_bidang_usaha.append(
						"<tr>\
							<td></td>\
							<td style='background: #f3f3f3'>Klasifikasi</td>\
							<td style='background: #f3f3f3'>Sub Klasifikasi</td>\
							<td style='background: #f3f3f3'>Kualifikasi</td>\
							<td style='background: #f3f3f3'>Permohonan</td>\
							<td style='background: #f3f3f3'>Total Biaya</td>\
						</tr>"
					);
					var detail = res['response']['badan_usaha'][i]['detail'];
					$.each(detail, function(j, order){
						total_biaya += detail[j].total_biaya;
						tbl_bidang_usaha.append(
							"<tr>\
								<td></td>\
								<td>"+detail[j].klasifikasi+"</td>\
								<td>"+detail[j].sub_klasifikasi+"</td>\
								<td>"+detail[j].kualifikasi+"</td>\
								<td>"+detail[j].permohonan+"</td>\
								<td>"+convertToRupiah(detail[j].total_biaya)+"</td>\
							</tr>\
							"
						);
					})
					tbl_bidang_usaha.append(
						"<tr>\
							<td></td>\
							<td style='background: #f3f3f3' colspan='4'>Biaya Pengembangan Jasa Kontruksi</td>\
							<td style='background: #f3f3f3'>Total Biaya</td>\
						</tr>"
					);
					var pengembangan = res['response']['badan_usaha'][i]['pengembangan'];
					$.each(pengembangan, function(j, order){
						total_biaya += parseInt(pengembangan[j].biaya_lpjkp)+parseInt(pengembangan[j].biaya_lpjkn);
						tbl_bidang_usaha.append(
							"<tr>\
								<td></td>\
								<td colspan ='4'>"+pengembangan[j].kode+"</td>\
								<td>"+convertToRupiah(parseInt(pengembangan[j].biaya_lpjkp)+parseInt(pengembangan[j].biaya_lpjkn))+"</td>\
							</tr>\
							"
						);
					})
				});
				$('#total_biaya_bu').html(convertToRupiah(total_biaya));

			}else{
				toastr.warning(e.message);
			}
		},
		error:function(err){
			console.log(err);
		}
	})
}

const view_permohonan_personal=(idx)=>{
	$.ajax({
		url:base_url+"permohonan/view_permohonan_personal",
		data:{
			id:idx
		},
		method:"get",
		dataType:"json",
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_approval_permohonan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_approval_permohonan');
        },
        success:(res)=>{
			if(res.status == true){
				$("#tbl_personal > tbody").html("");
				$('#modal_personal').modal('show');
				// if(res['response'].level_user == 1 || res['response'].level_user == 3){
				// 	$('#btn_approval_personal').removeClass('hide');
				// 	$('#btn_cancel_approval_personal').removeClass('hide');
				// }else{
				// 	$('#btn_cancel_approval_personal').addClass('hide');
				// 	$('#btn_approval_personal').addClass('hide');
				// }
				$('#img_personal').attr('src',res['response'].bukti_setoran);
				$('#img_personal').attr('data-img',res['response'].bukti_setoran);

				$('#img_personal').click(()=>{
					$('#modal_image').modal('show');
					$('#_img').attr('src',res['response'].bukti_setoran);
				})

				$("#no_invoice_personal").html(res['response'].invoice);
				$("#tgl_masuk_personal").html(res['response'].tgl_masuk);
				$("#tgl_bayar_personal").html(res['response'].tgl_pembayaran);
				$("#status_approval_personal").html(res['response'].status_keuangan);
				$("#status_rekomendasi_personal").html(res['response'].status_rekomendasi);
				$('#personal_assosiasi').html(res['response'].nama_user+' | '+res['response'].assosiasi);
				var tbl_personal = $('#tbl_personal');
				var person = res['response']['personal'];
				var total_biaya_personal= 0;
				$.each(person, function(i, order){
					var no = parseInt(i)+parseInt(1);
					tbl_personal.append(
						"<tr>\
							<td>"+no+"</td>\
							<td>"+person[i].nik+"</td>\
							<td>"+person[i].nama+"</td>\
							<td>"+person[i].alamat+"</td>\
							<td>"+person[i].tgl_lahir+"</td>\
							<td>"+person[i].jenis_kelamin+"</td>\
						</tr>\
						"
					);
					tbl_personal.append(
						"<tr>\
							<td></td>\
							<td style='background: #f3f3f3'>Klasifikasi</td>\
							<td style='background: #f3f3f3'>Sub Klasifikasi</td>\
							<td style='background: #f3f3f3'>Kualifikasi</td>\
							<td style='background: #f3f3f3'>Permohonan</td>\
							<td style='background: #f3f3f3'>Total Biaya</td>\
						</tr>"
					);
					var detail = res['response']['personal'][i]['detail'];
					$.each(detail, function(j, order){
						total_biaya_personal += detail[j].total_biaya;
						tbl_personal.append(
							"<tr>\
								<td></td>\
								<td>"+detail[j].klasifikasi+"</td>\
								<td>"+detail[j].sub_klasifikasi+"</td>\
								<td>"+detail[j].kualifikasi+"</td>\
								<td>"+detail[j].permohonan+"</td>\
								<td>"+convertToRupiah(detail[j].total_biaya)+"</td>\
							</tr>\
							"
						);
					})
					tbl_personal.append(
						"<tr>\
							<td></td>\
							<td style='background: #f3f3f3' colspan='4'>Biaya Pengembangan Jasa Kontruksi</td>\
							<td style='background: #f3f3f3'>Total Biaya</td>\
						</tr>"
					);
					var pengembangan = res['response']['personal'][i]['pengembangan'];
					$.each(pengembangan, function(j, order){
						total_biaya_personal += parseInt(pengembangan[j].biaya_lpjkp)+parseInt(pengembangan[j].biaya_lpjkn);
						tbl_personal.append(
							"<tr>\
								<td></td>\
								<td colspan ='4'>"+pengembangan[j].kode+"</td>\
								<td>"+convertToRupiah(parseInt(pengembangan[j].biaya_lpjkp)+parseInt(pengembangan[j].biaya_lpjkn))+"</td>\
							</tr>\
							"
						);
					})
				});
				$('#total_biaya_personal').html(convertToRupiah(total_biaya_personal));
			}else{
				toastr.warning(e.message);
			}

        },
        error:(err)=>{
        	console.log(err);
        }

	})
}
// Get the modal
// var modal = document.getElementById("modal_image");

// // Get the image and insert it inside the modal - use its "alt" text as a caption
// var img = document.getElementsByClassName("img-setoran");
// var modalImg = document.getElementById("img01");
// img.onclick = function(){
// 	modal.style.display = "block";
// 	modalImg.src = this.src;
// }

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() { 
// 	modal.style.display = "none";
// }

var tbl_approval_permohonan = $("#tbl_approval_permohonan").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Permohonan/data_permohonan_approval", 
	order: [
		[0, 'desc']
	],
	columns: [{
				"orderable"	:false
			},
		null,
		null,
		null,
		null,
		null,
		{
			"orderable"	:false
		},
		{
			"orderable"	:false
		},
	],
	language: {
		aria: {
			sortAscending: ": activate to sort column ascending",
			sortDescending: ": activate to sort column descending"
		},
		emptyTable: "No data available in table",
		info: "Showing _START_ to _END_ of _TOTAL_ entries",
		infoEmpty: "No entries found",
		infoFiltered: "(filtered1 from _MAX_ total entries)",
		lengthMenu: "_MENU_ entries",
		search: "Search:",
		zeroRecords: "No matching records found"
	},
	buttons: [],
	lengthMenu: [
		[5, 10, 15, 20, -1],
		[5, 10, 15, 20, "All"]
	],
	pageLength: 10,
	dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
});

var tbl_history_approval = $("#tbl_history_approval").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Permohonan/data_history_approval", 
	order: [
		[0, 'desc']
	],
	columns: [{
				"orderable"	:false
			},
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		{
			"orderable"	:false
		},
	],
	language: {
		aria: {
			sortAscending: ": activate to sort column ascending",
			sortDescending: ": activate to sort column descending"
		},
		emptyTable: "No data available in table",
		info: "Showing _START_ to _END_ of _TOTAL_ entries",
		infoEmpty: "No entries found",
		infoFiltered: "(filtered1 from _MAX_ total entries)",
		lengthMenu: "_MENU_ entries",
		search: "Search:",
		zeroRecords: "No matching records found"
	},
	buttons: [],
	lengthMenu: [
		[5, 10, 15, 20, -1],
		[5, 10, 15, 20, "All"]
	],
	pageLength: 10,
	dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
});

$('#btn_filter').click(()=>{
	tbl_history_approval.ajax.url(base_url+"Permohonan/data_history_approval?start_date="+$('#start_date').val()+"&end_date="+$('#end_date').val()).load();
})

$('#btn_reset').click(()=>{
	$('#start_date').val('');
	$('#end_date').val('');
	tbl_history_approval.ajax.url(base_url+"Permohonan/data_history_approval").load();
})
