var tbl_berita_sbu = $("#tbl_berita_sbu").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Berita_acara/data_berita_acara_sbu", 
	order: [
		[0, 'desc']
	],
	columns: [{
				"orderable"	:false
			},
		null,
		null,
		// null,
		null,
		// null,
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

var arr_sbu=[];
const cek_bu=(id,token)=>{
	$('#modal_cek_bu').modal('show');
	$('#id_bu').val(id);
	var tbl_detail_klasifikasi_sbu = $("#tbl_detail_klasifikasi_sbu").DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		destroy:true,
		ajax: base_url + "Berita_acara/data_klasifikasi?token"+token, 
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
	$(document).on('click', '#pilih', function(){
		var self = $(this);
		var isChecked = self.is(':checked');
		if(isChecked){
			arr_sbu.push({id:$(this).val()});
		}else{
	        var index=arr_sbu.indexOf(name);
	        if(index > -1){
				arr_sbu.splice(index, 1);
	        }
			for(var i = 0; i < arr_sbu.length; i++) {
				if(arr_sbu[i].id == $(this).val()) {
					arr_sbu.splice(i, 1);
					break;
				}
			}
		}
	})
}

$('#btn_cek').click(()=>{
	$.ajax({
		url:base_url+"Berita_acara/process_ba_sbu",
		data:{
			detail:arr_sbu,
			id_bu:$('#id_bu').val()
		},
		method:"post",
		dataType:"json",
		async:true,
		success:(res)=>{
			if(res.status== true){
				toastr.success(res.message);
				$('#modal_cek_bu').modal('hide');
				$('#tbl_berita_sbu').DataTable().ajax.reload();
			}else{
				toastr.error(res.message);
			}
		},
		error:(err)=>{
			console.log(err);
		}
	})
})

const clear_arr_sbu=()=>{
	arr_sbu=[];
	$('#modal_cek_bu').modal('hide');
}

var tbl_berita_ska = $("#tbl_berita_ska").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Berita_acara/data_berita_acara_ska", 
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

var arr_ska=[];
const cek_personal_ska=(id,token)=>{
	$('#modal_cek_ska').modal('show');
	$('#id_personal').val(id);
	var tbl_detail_klasifikasi_ska = $("#tbl_detail_klasifikasi_ska").DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		destroy:true,
		ajax: base_url + "Berita_acara/data_klasifikasi?token"+token, 
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
	$(document).on('click', '#pilih', function(){
		var self = $(this);
		var isChecked = self.is(':checked');
		if(isChecked){
			arr_ska.push({id:$(this).val()});
		}else{
	        var index=arr_ska.indexOf(name);
	        if(index > -1){
				arr_ska.splice(index, 1);
	        }
			for(var i = 0; i < arr_ska.length; i++) {
				if(arr_ska[i].id == $(this).val()) {
					arr_ska.splice(i, 1);
					break;
				}
			}
		}
	})
}


$('#btn_cek_ska').click(()=>{
	$.ajax({
		url:base_url+"Berita_acara/process_ba_ska",
		data:{
			detail:arr_ska,
			id_personal:$('#id_personal').val()
		},
		method:"post",
		dataType:"json",
		async:true,
		success:(res)=>{
			if(res.status== true){
				toastr.success(res.message);
				$('#modal_cek_ska').modal('hide');
				$('#tbl_berita_ska').DataTable().ajax.reload();
			}else{
				toastr.error(res.message);
			}
		},
		error:(err)=>{
			console.log(err);
		}
	})
})

const clear_arr_ska=()=>{
	arr_ska=[];
	$('#modal_cek_ska').modal('hide');
}

var tbl_berita_skt = $("#tbl_berita_skt").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Berita_acara/data_berita_acara_skt", 
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

var arr_skt=[];
const cek_personal_skt=(id,token)=>{
	$('#modal_cek_skt').modal('show');
	$('#id_personal').val(id);
	var tbl_detail_klasifikasi_skt = $("#tbl_detail_klasifikasi_skt").DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		destroy:true,
		ajax: base_url + "Berita_acara/data_klasifikasi?token"+token, 
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
	$(document).on('click', '#pilih', function(){
		var self = $(this);
		var isChecked = self.is(':checked');
		if(isChecked){
			arr_skt.push({id:$(this).val()});
		}else{
	        var index=arr_skt.indexOf(name);
	        if(index > -1){
				arr_skt.splice(index, 1);
	        }
			for(var i = 0; i < arr_skt.length; i++) {
				if(arr_skt[i].id == $(this).val()) {
					arr_skt.splice(i, 1);
					break;
				}
			}
		}
	})
}


$('#btn_cek_skt').click(()=>{
	$.ajax({
		url:base_url+"Berita_acara/process_ba_skt",
		data:{
			detail:arr_skt,
			id_personal:$('#id_personal').val()
		},
		method:"post",
		dataType:"json",
		async:true,
		success:(res)=>{
			if(res.status== true){
				toastr.success(res.message);
				$('#modal_cek_skt').modal('hide');
				$('#tbl_berita_skt').DataTable().ajax.reload();
			}else{
				toastr.error(res.message);
			}
		},
		error:(err)=>{
			console.log(err);
		}
	})
})

const clear_arr_skt=()=>{
	arr_skt=[];
	$('#modal_cek_skt').modal('hide');
}

