$(document).ready(function(){
	$('#tgl_permohonan').datepicker({
		format:"yyyy-mm-dd",
		autoclose:true,
	});
	$('#tgl_pembayaran').datepicker({
		format:"yyyy-mm-dd",
		autoclose:true,
	});
	$('#kota').select2({
		placeholder:"Pilih kota",
		width:"100%"
	})
	$('.tgl').datepicker({
		format:"yyyy-mm-dd",
		autoclose:true,	
	})
	$('#assosiasi').select2({
		placeholder:"Pilih assosiasi",
		width:"100%"
	})
	$('#kbli').select2({
		placeholder:"Pilih KBLI",
		width:"100%"
	})
})

var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();
date_now = yyyy+'-'+mm+'-'+dd;

// SBU
$('#token').val(Math.random());

var count = 1;
$('#btn_add').click(function(){
	count = count + 1;
	var html_code = "<tr id='row"+count+"'>";
	html_code += "<td><select id='klasifikasi'  data-count='"+count+"' name='klasifikasi[]' class='form-control item_klasifikasi"+count+" klasifikasi'><option></option></select></td>";
	html_code += "<td><select id='sub_klasifikasi' data-count='"+count+"' name='sub_klasifikasi[]' class='form-control item_sub_klasifikasi"+count+"' sub_klasifikasi1><option></option></select></td>";
	html_code += "<td><select id='kualifikasi' name='kualifikasi[]' class='form-control item_kualifikasi"+count+" kualifikasi'><option></option></select></td>";
	html_code += "<td><select id='permohonan' name='permohonan[]' class='form-control item_permohonan"+count+" permohonan'><option></option></select></td>";
	html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'><i class='fa fa-trash'></i></button></td>";   
	html_code += "</tr>";  
	$('#tbl_klasifikasi').append(html_code);
	// $( '.item_biaya'+count ).mask('000.000.000', {reverse: true});
	$('.item_klasifikasi'+count).select2({
		placeholder:"pilih klasifikasi",
		width:"100%"
	})
	$('.item_sub_klasifikasi'+count).select2({
		placeholder:"pilih sub klasifikasi",
		width:"100%"
	})
	$('.item_kualifikasi'+count).select2({
		placeholder:"pilih kualifikasi",
		width:"100%"
	})

	$('.item_permohonan'+count).select2({
		placeholder:"pilih permohonan",
		width:"100%"
	})


	$.ajax({
		url:base_url+"Permohonan/data_permohonan",
		method:"get",
		data:{
			flag:0
		},
		cache:false,
		async:false,
		success:(res)=>{
			$('.item_permohonan'+count).html(res);
		},error:(err)=>{
			console.log(err);
		}
	})

	$.ajax({
		url:base_url+"Permohonan/data_klasifikasi",
		method:"get",
		cache:false,
		async:false,
		success:(res)=>{
			$('.item_klasifikasi'+count).html(res);
		},error:(err)=>{
			console.log(err);
		}
	})

	$.ajax({
		url:base_url+"Permohonan/data_kualifikasi",
		method:"post",
		data:{
			flag : 0
		},
		async:false,
		cache:false,
		success:(res)=>{
			$('.item_kualifikasi'+count).html(res);
		},error:(err)=>{
			console.log(err);
		}
	})
});

$(document).on('change','#klasifikasi',function(){
	var count = $(this).data('count');
	$('.item_sub_klasifikasi'+count).val("").trigger("change");
	$.ajax({
		url:base_url+"Permohonan/data_sub_klasifikasi",
		data:{
			id_klasifikasi:$(this).val()
		},
		method:"get",
		success:(res)=>{	
			$('.item_sub_klasifikasi'+count).html(res);
		},
		error:(err)=>{
			console.log(err);
		}
	})
})

 $(document).on('click', '.remove', function(){
	var delete_row = $(this).data("row");
	$('#' + delete_row).remove();
 });

const add_badan_usaha=token=>{
	$('#modal_badan_usaha').modal('show');
	$('#token_permohonan').val(token);
	$('#token_klasifikasi').val(Math.random());
}

const clear_form=()=>{
	$('#npwp').val("");
	$('#nama_bu').val("");
	$('#penanggung_jawab').val("");
	$('#kota').val("").trigger("change");
	$('#kbli').val("").trigger("change");
	$('#alamat').val("");
	$("#tbl_klasifikasi > tbody").html("");
}

$('#form_bu').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);

    $.ajax({
    	url:base_url+"Permohonan/prosess_badan_usaha",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        success:function(res){
            if(res.status == 1) {
                toastr.success(res.message);
				$('#tbl_sbu').DataTable().ajax.reload();
                $('#modal_badan_usaha').modal('toggle');
                clear_form();
            } else {
                toastr.warning(res.message);
            }
        },
        error:function(err){
        	// console.log(err)
        }
    })
    return false;
})

console.log($('#token').val());

var tbl_sbu = $("#tbl_sbu").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Permohonan/data_permohonan_sbu?token="+$('#token').val(), 
	order: [
		[1, 'asc']
	],
	columns: [{
				"orderable"	:false
			},
		null,
		null,
		null,
		null,
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
const delete_bu=(idx)=>{
	// bootbox.confirm("Apakah anda yakin ingin menghapus data ini ?", function (event) {
	// 	if(event == true){
	$.ajax({
		url:base_url+"Permohonan/delete_bu_sbu",
		dataType:"json",
		type:"get",
		data:{
			id:idx
		},
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_sbu',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_sbu');
        },
		success:function(e){
			if(e.status == 1){
				toastr.success(e.message);
				$('#tbl_sbu').DataTable().ajax.reload();
			}else{
				toastr.warning(e.message);
			}
		},
		error:function(err){
			console.log(err);
		}
	})
}
	// })
// }

const clear_form_permohonan=()=>{
	// $('#token').val(Math.random());
	$('#tgl_permohonan').val(date_now);
	$('#tgl_pembayaran').val(date_now);
	$('#bukti_setoran').val("");
	$('#assosiasi').val("").trigger("change");
}
$('#cancel_sbu').click(()=>{
	clear_form_permohonan();
})

$('#form_sbu').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
    	url:base_url+"Permohonan/proses_permohonan_sbu",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        success:function(res){
            if(res.status == 1) {
                toastr.success(res.message);
                clear_form_permohonan();
                var token = Math.random();
				$('#token').val(token);
				tbl_sbu.ajax.url(base_url+"Permohonan/data_permohonan_sbu?token="+token).load();
            } else {
                toastr.warning(res.message);
            }
        },
        error:function(err){
        	// console.log(err)
        }
    })
    return false;
})

// SKA
const add_personal=(token)=>{
	$('#modal_personal').modal('show');
	$('#token_permohonan').val(token);
	$('#token_klasifikasi').val(Math.random());
	// clear_form_personal_ska();
}
$('#btn_add_ska').click(()=>{
	count = count + 1;
	var html_code = "<tr id='row"+count+"'>";
	html_code += "<td><select id='klasifikasi'  data-count='"+count+"' name='klasifikasi[]' class='form-control item_klasifikasi"+count+" klasifikasi'><option></option></select></td>";
	html_code += "<td><select id='sub_klasifikasi' data-count='"+count+"' name='sub_klasifikasi[]' class='form-control item_sub_klasifikasi"+count+"' sub_klasifikasi1><option></option></select></td>";
	html_code += "<td><select id='kualifikasi' name='kualifikasi[]' class='form-control item_kualifikasi"+count+" kualifikasi'><option></option></select></td>";
	html_code += "<td><select id='permohonan' name='permohonan[]' class='form-control item_permohonan"+count+" permohonan'><option></option></select></td>";
	html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'><i class='fa fa-trash'></i></button></td>";   
	html_code += "</tr>";  
	$('#tbl_klasifikasi_ska').append(html_code);
	// $( '.item_biaya'+count ).mask('000.000.000', {reverse: true});
	$('.item_klasifikasi'+count).select2({
		placeholder:"pilih klasifikasi",
		width:"100%"
	})
	$('.item_sub_klasifikasi'+count).select2({
		placeholder:"pilih sub klasifikasi",
		width:"100%"
	})
	$('.item_kualifikasi'+count).select2({
		placeholder:"pilih kualifikasi",
		width:"100%"
	})

	$('.item_permohonan'+count).select2({
		placeholder:"pilih permohonan",
		width:"100%"
	})

	$.ajax({
		url:base_url+"Permohonan/data_klasifikasi_tenaga_kerja",
		method:"get",
		cache:false,
		async:false,
		success:(res)=>{
			$('.item_klasifikasi'+count).html(res);
		},error:(err)=>{
			console.log(err);
		}
	})

	$.ajax({
		url:base_url+"Permohonan/data_permohonan",
		method:"get",
		data:{
			flag:1
		},
		cache:false,
		async:false,
		success:(res)=>{
			$('.item_permohonan'+count).html(res);
		},error:(err)=>{
			console.log(err);
		}
	})

	$.ajax({
		url:base_url+"Permohonan/data_kualifikasi",
		method:"post",
		data :{
			flag :1
		},
		async:false,
		cache:false,
		success:(res)=>{
			$('.item_kualifikasi'+count).html(res);
		},error:(err)=>{
			console.log(err);
		}
	})
});

const clear_form_permohonan_ska=()=>{
	// $('#token').val(Math.random());
	$('#tgl_permohonan').val(date_now);
	$('#tgl_pembayaran').val(date_now);
	$('#bukti_setoran').val("");
	$('#assosiasi').val("").trigger("change");
}

const clear_form_personal_ska=()=>{
	$('#form_personal_ska').trigger("reset");
	$('#nik').val("");
	$('#nama_personal').val("");
	$('#tgl_lahir').val("");
	$('#nik').val("");
	$('#kota').val("").trigger("change");
	$('input[name="jenis_kelamin"]').prop('checked', false);
	$('#alamat').val("");
	$("#tbl_klasifikasi_ska > tbody").html("");

}

$('#btn_cancel_ska').click(()=>{
	clear_form_permohonan_ska();
})

$('#form_personal_ska').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);

    $.ajax({
    	url:base_url+"Permohonan/prosess_personal",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        success:function(res){
            if(res.status == 1) {
                toastr.success(res.message);
				$('#tbl_ska').DataTable().ajax.reload();
                $('#modal_personal').modal('toggle');
                clear_form_personal_ska();
            } else {
                toastr.warning(res.message);
            }
        },
        error:function(err){
        	// console.log(err)
        }
    })
    return false;
})

var tbl_ska = $("#tbl_ska").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Permohonan/data_permohonan_ska?token="+$('#token').val(), 
	order: [
		[1, 'asc']
	],
	columns: [{
				"orderable"	:false
			},
		null,
		null,
		null,
		null,
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

const delete_personal_ska=(idx)=>{
	$.ajax({
		url:base_url+"Permohonan/delete_personal_ska",
		dataType:"json",
		type:"get",
		data:{
			id:idx
		},
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_ska',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_ska');
        },
		success:function(e){
			if(e.status == 1){
				toastr.success(e.message);
				$('#tbl_ska').DataTable().ajax.reload();
			}else{
				toastr.warning(e.message);
			}
		},
		error:function(err){
			console.log(err);
		}
	})
}

$('#form_ska').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
    	url:base_url+"Permohonan/proses_permohonan_ska",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        success:function(res){
            if(res.status == 1) {
                toastr.success(res.message);
                clear_form_permohonan_ska();
                var token = Math.random();
				$('#token').val(token);
				tbl_ska.ajax.url(base_url+"Permohonan/data_permohonan_ska?token="+token).load();
            } else {
                toastr.warning(res.message);
            }
        },
        error:function(err){
        	// console.log(err)
        }
    })
    return false;
})


var tbl_permohonan = $("#tbl_permohonan").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Permohonan/data_permohonan_all", 
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

const delete_permohonan=(idx)=>{
	bootbox.confirm("Apakah anda yakin ingin menghapus permohonan ini ?", function (event) {
		if(event == true){
			$.ajax({
				url:base_url+"Permohonan/delete_permohonan",
				data:{
					id:idx
				},
				method:"get",
				dataType:"json",
				async:true,
				success:(res)=>{
					if(res.status == true){
						$('#tbl_permohonan').DataTable().ajax.reload();
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
                target: '#tbl_permohonan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_permohonan');
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
                target: '#tbl_permohonan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_permohonan');
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

function download_file(id,type)
{
	if(type == 0){
	     url = base_url+"permohonan/download_file_permohonan_sbu?id="+id;
	     window.location.href = url;	
	}else{
	     url = base_url+"permohonan/download_file_permohonan_skt?id="+id;
	     window.location.href = url;	
	}
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



