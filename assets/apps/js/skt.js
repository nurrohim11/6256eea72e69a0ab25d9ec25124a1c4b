
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();
date_now = yyyy+'-'+mm+'-'+dd;

$('#token').val(Math.random());

const add_personal=token=>{
	$('#modal_personal').modal('show');
	clear_form_personal_skt();
	$('#token_permohonan').val(token);
	$('#token_klasifikasi').val(Math.random());
}

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

	var count = 1;
	$('#btn_add_skt').click(function(){
		count = count + 1;
		var html_code = "<tr id='row"+count+"'>";
		html_code += "<td><select id='klasifikasi'  data-count='"+count+"' name='klasifikasi[]' class='form-control item_klasifikasi"+count+" klasifikasi'><option></option></select></td>";
		html_code += "<td><select id='sub_klasifikasi' data-count='"+count+"' name='sub_klasifikasi[]' class='form-control item_sub_klasifikasi"+count+"' sub_klasifikasi1><option></option></select></td>";
		html_code += "<td><select id='kualifikasi' name='kualifikasi[]' class='form-control item_kualifikasi"+count+" kualifikasi'><option></option></select></td>";
		html_code += "<td><select id='permohonan' name='permohonan[]' class='form-control item_permohonan"+count+" permohonan'><option></option></select></td>";
		html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'><i class='fa fa-trash'></i></button></td>";   
		html_code += "</tr>";  
		$('#tbl_klasifikasi_skt').append(html_code);
		// $( '.item_biaya'+count ).mask('000.000.000', {reverse: true});
		$('.item_klasifikasi'+count).select2({
			placeholder:"pilih klasifikasi",
			width:"100%"
		})

		$('.item_klasifikasi'+count).val("").trigger("change")

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
			url:base_url+"Permohonan/data_klasifikasi_tenaga_kerja_skt",
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
				flag :2
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
})

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

var tbl_skt = $("#tbl_skt").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Permohonan/data_permohonan_skt?token="+$('#token').val(), 
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

const delete_personal_skt=(idx)=>{
	// bootbox.confirm("Apakah anda yakin ingin menghapus data ini ?", function (event) {
	// 	if(event == true){
	$.ajax({
		url:base_url+"Permohonan/delete_personal_skt",
		dataType:"json",
		type:"get",
		data:{
			id:idx
		},
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_skt',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_skt');
        },
		success:function(e){
			if(e.status == 1){
				toastr.success(e.message);
				$('#tbl_skt').DataTable().ajax.reload();
			}else{
				toastr.warning(e.message);
			}
		},
		error:function(err){
			console.log(err);
		}
	})
}


const clear_form_permohonan_skt=()=>{
	// $('#token').val(Math.random());
	$('#tgl_permohonan').val(date_now);
	$('#tgl_pembayaran').val(date_now);
	$('#bukti_setoran').val("");
	$('#assosiasi').val("").trigger("change");
}

const clear_form_personal_skt=()=>{
	$('#form_personal_skt').trigger("reset");
	$('#nik').val("");
	$('#nama_personal').val("");
	$('#tgl_lahir').val("");
	$('#kota').val("").trigger("change");
	$('#nik').val("");
	$('input[name="jenis_kelamin"]').prop('checked', false);
	$('#alamat').val("");
	$("#tbl_klasifikasi_skt > tbody").html("");

}

$('#btn_cancel_skt').click(()=>{
	clear_form_permohonan_skt();
})

$('#form_personal_skt').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);

    $.ajax({
    	url:base_url+"Permohonan/prosess_personal_skt",
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
				$('#tbl_skt').DataTable().ajax.reload();
                $('#modal_personal').modal('toggle');
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

$('#form_skt').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
    	url:base_url+"Permohonan/proses_permohonan_skt",
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
                clear_form_permohonan_skt();
                var token = Math.random();
				$('#token').val(token);
				tbl_skt.ajax.url(base_url+"Permohonan/data_permohonan_skt?token="+token).load();
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
