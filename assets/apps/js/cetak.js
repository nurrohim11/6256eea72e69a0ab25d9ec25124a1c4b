
var tbl_cetak_sbu = $("#tbl_cetak_sbu").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "cetak/data_cetak_sbu", 
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
		// null,
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

function download_dokumen_sbu(id)
{
     url = base_url+"cetak/cetak_dokumen_sbu?id="+id;
     window.location.href = url;
}

const no_download=()=>{
	toastr.error("Maaf, Anda belum dapat mendowload file ini");
}

var tbl_cetak_ska = $("#tbl_cetak_ska").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "cetak/data_cetak_ska", 
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
		// null,
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

function download_dokumen_ska(id)
{
     url = base_url+"cetak/cetak_dokumen_ska?id="+id;
     window.location.href = url;
}

var tbl_cetak_skt = $("#tbl_cetak_skt").DataTable({
	processing: true,
	serverSide: true,
	responsive: true,
	ajax: base_url + "cetak/data_cetak_skt", 
	order: [
		[0, 'desc']
	],
	columns: [{
				"orderable"	:false
			},
		null,
		null,
		null,
		// null,
		null,
		null,
		null,
		// null,
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

function download_dokumen_skt(id)
{
     url = base_url+"cetak/cetak_dokumen_skt?id="+id;
     window.location.href = url;
}
