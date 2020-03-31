function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}

var tbl_penilaian = $("#tbl_penilaian").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Permohonan/data_penilaian_permohonan", 
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

const view_permohonan_bu=(idx)=>{
	$.ajax({
		url:base_url+"penilaian/view_permohonan_bu",
		data:{
			id:idx
		},
		method:"get",
		dataType:"json",
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_rekomendasi_permohonan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_rekomendasi_permohonan');
        },
		success:function(res){
			if(res.status == true){
				$("#tbl_bidang_usaha > tbody").html("");
				$('#modal_badan_usaha').modal('show');
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
					var disabled ="";
					if(bu[i].status_penilaian == 1){
						disabled ="disabled";
					}else{
						disabled ="";
					}
					var no = parseInt(i)+parseInt(1);
					tbl_bidang_usaha.append(
						"<tr>\
							<td>"+no+"</td>\
							<td>"+bu[i].npwp+"</td>\
							<td>"+bu[i].nama+"</td>\
							<td>"+bu[i].kota+"</td>\
							<td>"+bu[i].alamat+"</td>\
							<td>"+bu[i].kbli+"</td>\
							<td><a target='_blank' href='"+base_url+"penilaian/penilaian_usbu?id="+bu[i].id+"&token="+bu[i].token+"' class='btn btn-info btn-xs btn-sm btn-no-margin "+disabled+"'>Nilai</a></td>\
						</tr>\
						"
					);
				});
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
		url:base_url+"penilaian/view_permohonan_personal",
		data:{
			id:idx
		},
		method:"get",
		dataType:"json",
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_rekomendasi_permohonan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_rekomendasi_permohonan');
        },
        success:(res)=>{
			if(res.status == true){
				$("#tbl_personal > tbody").html("");
				$('#modal_personal').modal('show');
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
					var disabled ="";
					if(person[i].status_penilaian == 1){
						disabled ="disabled";
					}else{
						disabled ="";
					}
					tbl_personal.append(
						"<tr>\
							<td>"+no+"</td>\
							<td>"+person[i].nik+"</td>\
							<td>"+person[i].nama+"</td>\
							<td>"+person[i].alamat+"</td>\
							<td>"+person[i].tgl_lahir+"</td>\
							<td>"+person[i].jenis_kelamin+"</td>\
							<td><a target='_blank'href='"+base_url+"penilaian/penilaian_uskt?id="+person[i].id+"&token="+person[i].token+"' class='btn btn-info btn-xs btn-sm btn-no-margin "+disabled+"'>Nilai</a></td>\
						</tr>\
						"
					);
				});
			}else{
				toastr.warning(e.message);
			}

        },
        error:(err)=>{
        	console.log(err);
        }

	})
}

$('.hasil').select2({
	placeholder:"Pilih",
	width:"100%"
})
$('.ketua_ass').select2({
	placeholder:"Pilih",
	width:"100%"
})
$('.assesor_1').select2({
	placeholder:"Pilih",
	width:"100%"
})
$('.assesor_2').select2({
	placeholder:"Pilih",
	width:"100%"
})

$('#form_uskt').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
		url:base_url+"penilaian/process_penilaian_uskt",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        beforeSend : function(){
            App.blockUI({
                target: '#form_uskt',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#form_uskt');
        },
        success:function(res){
        	if(res.status == true){
        		toastr.success(res.message);
        		setTimeout(function(){window.close() }, 3000);
        	}else{
        		toastr.error(res.message);
        	}
        },
        error:function(err){
        	console.log(err)
        }
    })
    return false;
})

$('#form_usbu').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
		url:base_url+"penilaian/process_penilaian_usbu",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        beforeSend : function(){
            App.blockUI({
                target: '#form_usbu',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#form_usbu');
        },
        success:function(res){
        	if(res.status == true){
        		toastr.success(res.message);
        		setTimeout(function(){window.close() }, 3000);
        	}else{
        		toastr.error(res.message);
        	}
        },
        error:function(err){
        	console.log(err)
        }
    })
    return false;
})

$('.ketua_ass').change(function(){
	var selected = $(this).children("option:selected").val();
	 // $('[name=ketua_assesor]').val(selected);//To select Blue
	 $('.ketua_ass').val(selected).change();
})