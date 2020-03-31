var tbl_jabatan = $("#tbl_jabatan").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "master/data_jabatan", 
	order: [
		[0, 'desc']
	],
	columns: [{
				"orderable"	:false
			},
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

const clear_form=()=>{
	$('#form_jabatan').trigger("reset");
	$('#id').val("");
	$('#jabatan').val("");
}

$('#add_jabatan').click(()=>{
	clear_form();
	$('#modal_jabatan').modal('show');
})

$('#form_jabatan').submit(function(event){
	event.preventDefault();
	formData = new FormData($(this)[0]);
    $.ajax({
		url:base_url+"master/process_jabatan",
    	data:formData,
    	type:"post",
        async : false,
        cache : false,
        dataType : "json",
        contentType : false,
        processData : false,
        beforeSend : function(){
            App.blockUI({
                target: '#form_jabatan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#form_jabatan');
        },
        success:function(res){
        	if(res.status == true){
        		toastr.success(res.message);
        		$('#modal_jabatan').modal('hide');
        		$('#tbl_jabatan').DataTable().ajax.reload();
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

const edit_jabatan =(idx)=>{
	$.ajax({
		url:base_url+"master/edit_jabatan",
		data:{id:idx},
		type:"get",
        dataType : "json",
        beforeSend : function(){
            App.blockUI({
                target: '#tbl_jabatan',
                overlayColor: 'none',
                cenrerY: true,
                animate: true
            });
        },
        complete : function(){
            App.unblockUI('#tbl_jabatan');
        },
        success:function(res){
        	if(res.status == true){
        		$('#modal_jabatan').modal('show');
        		$('#id').val(res['response'].id);
        		$('#jabatan').val(res['response'].jabatan);
        	}else{
        		toastr.error(res.message);
        	}
        },
        error:function(err){
        	console.log(err)
        }
	})
}

const delete_jabatan=(idx)=>{
	bootbox.confirm("Apakah anda yakin ingin menghapus data jabatan ?", function (event) {
		if(event == true){
		    $.ajax({
				url:base_url+"master/delete_jabatan",
		    	data:{id:idx},
		    	type:"get",
		        async : false,
		        cache : false,
		        dataType : "json",
		        beforeSend : function(){
		            App.blockUI({
		                target: '#tbl_jabatan',
		                overlayColor: 'none',
		                cenrerY: true,
		                animate: true
		            });
		        },
		        complete : function(){
		            App.unblockUI('#tbl_jabatan');
		        },
		        success:function(res){
		        	if(res.status == true){
		        		toastr.success(res.message);
		        		$('#tbl_jabatan').DataTable().ajax.reload();
		        	}else{
		        		toastr.error(res.message);
		        	}
		        },
		        error:function(err){
		        	console.log(err)
		        }
		    })
		}
	})
}