$(document).ready(function(){
	$('#assosiasi').select2({
		placeholder:"Pilih assosiasi",
		width:"100%"
	})
	$('#jabatan').select2({
		placeholder:"Pilih jabatan",
		width:"100%"
	})
})

$('#level').change(function(){
	var level = $(this).val();
	if(level == 2){
		$('#div_assosiasi').removeClass('hide').addClass('show');
	}else if(level == 12){
		$('#div_jabatan').removeClass('hide').addClass('show');
	}else{
		$('#div_jabatan').removeClass('show').addClass('hide');
		$('#div_assosiasi').removeClass('show').addClass('hide');
	}
})

var tbl_user = $("#tbl_user").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Main/data_user", 
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
		// null,
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

const delete_user=(idx)=>{
	bootbox.confirm("Apakah anda yakin ingin menghapus data user ?", function (event) {
		if(event == true){
			$.ajax({
				url:base_url+"main/delete_user",
				data:{
					id:idx
				},
				method:"get",
				async:true,
				dataType:"json",
				success:(res)=>{
					if(res.status== true){
						$('#tbl_user').DataTable().ajax.reload();
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
const clear_form=()=>{
	$('#form_user').trigger("reset");
	$("#id").val("");
	$("#nama").val("");
	$("#username").val("");
	$("#password").val("");
	$("#email").val("");
	$("#kontak").val("");
	$("#nik").val("");
	// $("#assosiasi").val("");
    $("#level").val("").trigger("change");
	$('#password').attr('required','');
		    $('#bintang').css('display','');
}
$('#level').select2({
	placeholder:"Pilih level",
	width:"100%"
})
$('#username').keypress(function( e ) {
	var keyCode = e.which; 
	if ( !( (keyCode >= 48 && keyCode <= 57) 
	||(keyCode >= 65 && keyCode <= 90) 
	|| (keyCode >= 97 && keyCode <= 122) ) 
	&& keyCode != 8 && keyCode != 32) {
		e.preventDefault();
	}
    if(e.which === 32) 
        return false;
});

$('#add_user').click(()=>{
	$('#modal_user').modal('show');
	clear_form();
    $('#label_pass').html("");
	$('#username').removeAttr('readonly','readonly');
})
$('#form_user').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
    	url:base_url+"Main/prosess_user",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        success:(res)=>{
            if(res.status == 1) {
                toastr.success(res.message);
                $('#modal_user').modal('hide');
                $('#tbl_user').DataTable().ajax.reload();
                clear_form();
            } else {
                toastr.error(res.message);
            }
        },
        error:(err)=>{
        	console.log(err)
        }
    })
    return false;
})

const edit_user=(idx)=>{
	$.ajax({
		url:base_url+"main/edit_user",
		data:{
			id:idx
		},
		method:"get",
		dataType:"json",
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_user',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_user');
        },
		success:(res)=>{
			if(res.status== true){
				$('#modal_user').modal('show');
				$('#id').val(res['response'].id);
				$('#nik').val(res['response'].nik);
				$('#nama').val(res['response'].nama);
				$('#username').val(res['response'].username);
				$('#alamat').val(res['response'].alamat);
				$('#kontak').val(res['response'].kontak);
				$('#email').val(res['response'].email);
				$('#level').val(res['response'].level).trigger("change");
				$('#assosiasi').val(res['response'].kode).trigger("change");
			    $('#label_pass').html("* kosongi jika tidak ingin di ganti");
	            $('#password').removeAttr('required','');
			    $('#username').attr('readonly','readonly');
			    $('#bintang').css('display','none');
			}else{
				toastr.error(res.message);
			}
		},
		error:(err)=>{
			console.log(err);
		}
	})
}

const edit_menu=(idx)=>{
	$('#tree_menu').html("");
	$.ajax({
		url:base_url+"main/id_user_menu",
		data:{
			id:idx
		},
		method:"get",
		dataType:"json",
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_user',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_user');
        },
		success:(res)=>{
			$('#modal_menu').modal('show');
			$('#id_user').val(res.id);
			$('#nama_user').val(res.nama);
            menu = res.menu;
            $('#tree_menu').jstree("destroy");
			$('#tree_menu').jstree({
		        'plugins': ["wholerow", "checkbox", "types"],
		        'core': {
		            "themes" : {
		                "responsive": false
		            },    
		            'data': menu
		        },
		        "types" : {
		            "default" : {
		                "icon" : "fa fa-folder icon-state-warning icon-lg"
		            },
		            "file" : {
		                "icon" : "fa fa-file icon-state-warning icon-lg"
		            }
		        }
		    });
		},
		error:(err)=>{
			console.log(err);
		}
	})
}

$('#form_menu').submit(function(event){

    var arr = $("#tree_menu").jstree('get_checked');
    $("#tree_menu").find(".jstree-undetermined").each(
        function(i, element) {
            arr.push( $(element).closest('.jstree-node').attr("id") );
        }
    );
	event.preventDefault();
	formData = new FormData($(this)[0]);
    formData.append('checked', arr);
    $.ajax({
    	url:base_url+"Main/update_menu",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        success:(res)=>{
            if(res.status == true) {
                toastr.success(res.message);
                $('#modal_menu').modal('hide');
                $('#tbl_user').DataTable().ajax.reload();
                location.reload();
            } else {
                toastr.error(res.message);
            }
        },
        error:(err)=>{
        	console.log(err)
        }
    })
    return false;
})

$('#add_assesor').click(()=>{
	$('#modal_assesor').modal('show');
	clear_form_assesor();
})

$('#ket').select2({
	placeholder:"Pilih",
	width:"100%"
})

$('#tgl_lahir').datepicker({
	format:"yyyy-mm-dd",
	autoclose:true
})

const clear_form_assesor=()=>{
	$('#form_assesor').trigger("reset");
	$('#nama').val("");
	$('#alamat').val("");
	$('#tgl_lahir').val("");
	$('#ket').val("").trigger("change");
}


var tbl_assesor = $("#tbl_assesor").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "Main/data_assesor", 
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
$('#form_assesor').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
    	url:base_url+"Main/process_assesor",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        success:(res)=>{
            if(res.status == 1) {
                toastr.success(res.message);
                $('#modal_assesor').modal('hide');
                $('#tbl_assesor').DataTable().ajax.reload();
                clear_form_assesor();
            } else {
                toastr.error(res.message);
            }
        },
        error:(err)=>{
        	console.log(err)
        }
    })
    return false;
})

const delete_assesor=(idx)=>{
	bootbox.confirm("Apakah anda yakin ingin menghapus data assesor ?", function (event) {
		if(event == true){
			$.ajax({
				url:base_url+"main/delete_assesor",
				data:{
					id:idx
				},
				method:"get",
				async:true,
				dataType:"json",
				success:(res)=>{
					if(res.status== true){
						$('#tbl_assesor').DataTable().ajax.reload();
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

const edit_assesor=(idx)=>{
	$.ajax({
		url:base_url+"main/edit_assesor",
		data:{
			id:idx
		},
		method:"get",
		dataType:"json",
		async:true,
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_assesor',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_assesor');
        },
		success:(res)=>{
			if(res.status== true){
				$('#modal_assesor').modal('show');
				$('#id').val(res['response'].id);
				$('#alamat').val(res['response'].alamat);
				$('#nama').val(res['response'].nama);
				$('#tgl_lahir').val(res['response'].tgl_lahir);
				$('#ket').val(res['response'].ket).trigger("change");
			}else{
				toastr.error(res.message);
			}
		},
		error:(err)=>{
			console.log(err);
		}
	})
}
