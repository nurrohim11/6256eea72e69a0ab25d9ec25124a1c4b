<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-02-28 08:35:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-02-28 08:35:13 --> Severity: error --> Exception: syntax error, unexpected '=>' (T_DOUBLE_ARROW) /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 42
ERROR - 2020-02-28 08:35:19 --> Severity: error --> Exception: syntax error, unexpected '".pdf"' (T_CONSTANT_ENCAPSED_STRING), expecting ',' or ')' /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 56
ERROR - 2020-02-28 14:35:26 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 56
ERROR - 2020-02-28 14:37:07 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 80
ERROR - 2020-02-28 14:37:28 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 80
ERROR - 2020-02-28 14:41:04 --> Severity: Notice --> Undefined property: Cetak::$pdf2ß /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 75
ERROR - 2020-02-28 14:41:04 --> Severity: error --> Exception: Call to a member function load_view() on null /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 75
ERROR - 2020-02-28 13:55:32 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-02-28 13:55:35 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-02-28 13:55:39 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-02-28 20:04:45 --> Severity: error --> Exception: Call to undefined function terbilang() /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 45
ERROR - 2020-02-28 14:04:45 --> 404 Page Not Found: Cetak/fonts
ERROR - 2020-02-28 20:17:05 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-02-28 20:19:09 --> Severity: Notice --> Undefined variable: p /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 59
ERROR - 2020-02-28 20:19:09 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 59
ERROR - 2020-02-28 20:31:33 --> Query error: Unknown column 'f.nama' in 'field list' - Invalid query: 
				SELECT a.*,b.kota as ket_kota, c.kbli as ket_kbli, f.nama from tb_bidang_usaha a
				join tb_permohonan g
					on g.token_permohonan = a.token_permohonan
				join ms_kota b
					on b.id = a.kota
				join ms_kbli c
					on c.id = a.id_kbli
				join (
					SELECT d.id, f.nama from tb_user d
					join ms_assosiasi f
						on f.kode = d.kode
				) as ass
					on ass.id = g.id_assosiasi
				where a.id = 24
			
ERROR - 2020-02-28 20:31:52 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 59
ERROR - 2020-02-28 20:31:52 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 81
ERROR - 2020-02-28 20:31:52 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 92
ERROR - 2020-02-28 20:31:52 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 122
ERROR - 2020-02-28 20:48:12 --> Severity: Notice --> Undefined property: stdClass::$image /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_sbu.php 163
ERROR - 2020-02-28 14:50:02 --> Severity: error --> Exception: syntax error, unexpected '$this' (T_VARIABLE) /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 87
ERROR - 2020-02-28 21:02:38 --> Severity: error --> Exception: Too few arguments to function Dompdf\Dompdf::set_option(), 1 passed in /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php on line 85 and exactly 2 expected /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/vendor/dompdf/dompdf/src/Dompdf.php 1011
ERROR - 2020-02-28 15:03:20 --> Severity: error --> Exception: syntax error, unexpected '=>' (T_DOUBLE_ARROW), expecting ',' or ')' /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 85
ERROR - 2020-02-28 21:19:57 --> Severity: error --> Exception: Class 'Options' not found /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 85
