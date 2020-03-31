<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-03-01 01:50:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-03-01 01:50:37 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-03-01 07:50:41 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-01 01:50:44 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 01:50:45 --> 404 Page Not Found: Cetak/ska
ERROR - 2020-03-01 02:30:17 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 02:30:41 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 02:31:00 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 08:31:00 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-01 02:31:09 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 02:31:10 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 02:31:31 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 08:32:25 --> 404 Page Not Found: Berita_acara/favicon.ico
ERROR - 2020-03-01 02:33:12 --> 404 Page Not Found: Cetak/ska
ERROR - 2020-03-01 02:33:37 --> Severity: Compile Error --> Cannot redeclare Cetak::data_cetak_sbu() /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Cetak.php 85
ERROR - 2020-03-01 02:51:47 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 02:52:37 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 09:08:07 --> Query error: Table 'project_pengajuan.history_approval_sktu' doesn't exist - Invalid query: 
          SELECT a.id, a.nik,a.nama,alamat, assosiasi.nama as assosiasi, d.tgl_berkas_masuk, d.tgl_pembayaran,
            ifnull(approval.jml,0) as jml, ifnull(total.total,0) as total_biaya
            from tb_personal a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
            on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_personal
                from history_approval_sktu e
                group by e.id_personal
            ) as approval
            on approval.id_personal = a.id
            left join(
                select sum(f.biaya+f.biaya_lpjkn+f.biaya_lpjkp) as total, f.token_klasifikasi
                from detail_klasifikasi f
                group by f.token_klasifikasi
            ) as total
                on total.token_klasifikasi = a.token_klasifikasi
                where d.type = 1 
             ORDER BY a.nama desc 
            LIMIT 0, 10
ERROR - 2020-03-01 03:08:12 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 09:08:16 --> Query error: Table 'project_pengajuan.history_approval_sktu' doesn't exist - Invalid query: 
          SELECT a.id, a.nik,a.nama,alamat, assosiasi.nama as assosiasi, d.tgl_berkas_masuk, d.tgl_pembayaran,
            ifnull(approval.jml,0) as jml, ifnull(total.total,0) as total_biaya
            from tb_personal a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
            on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_personal
                from history_approval_sktu e
                group by e.id_personal
            ) as approval
            on approval.id_personal = a.id
            left join(
                select sum(f.biaya+f.biaya_lpjkn+f.biaya_lpjkp) as total, f.token_klasifikasi
                from detail_klasifikasi f
                group by f.token_klasifikasi
            ) as total
                on total.token_klasifikasi = a.token_klasifikasi
                where d.type = 1 
             ORDER BY a.nama desc 
            LIMIT 0, 10
ERROR - 2020-03-01 03:08:16 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 03:08:34 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 03:12:53 --> 404 Page Not Found: Cetak/skt
ERROR - 2020-03-01 03:12:56 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-03-01 09:12:57 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-01 09:13:05 --> 404 Page Not Found: Berita_acara/favicon.ico
ERROR - 2020-03-01 03:13:11 --> 404 Page Not Found: Cetak/skt
ERROR - 2020-03-01 03:17:09 --> 404 Page Not Found: Cetak/skt
ERROR - 2020-03-01 03:26:36 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 03:27:23 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 03:35:49 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 09:38:20 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-01 03:38:47 --> 404 Page Not Found: Cetak/favicon.ico
ERROR - 2020-03-01 03:39:52 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 03:45:28 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-03-01 09:45:32 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-01 09:45:37 --> 404 Page Not Found: Berita_acara/favicon.ico
ERROR - 2020-03-01 04:44:04 --> 404 Page Not Found: Cetak/cetak_dokumen_ska
ERROR - 2020-03-01 10:44:18 --> Query error: Unknown column 'a.kota' in 'on clause' - Invalid query: 
				SELECT a.*,b.kota as ket_kota, ass.nama as assosiasi from tb_personal a
				join tb_permohonan g
					on g.token_permohonan = a.token_permohonan
				join ms_kota b
					on b.id = a.kota
				left join (
					SELECT d.id, f.nama from tb_user d
					join ms_assosiasi f
						on f.kode = d.kode
				) as ass
					on ass.id = g.id_assosiasi
				where a.id = '11'
			
ERROR - 2020-03-01 10:44:42 --> Severity: Notice --> Undefined property: stdClass::$ket_kota /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 112
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 47
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 66
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 90
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 101
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 112
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 123
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 175
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5132
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5140
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_x /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5250
ERROR - 2020-03-01 10:45:31 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5258
ERROR - 2020-03-01 10:45:54 --> Query error: Unknown column 'b.kota' in 'field list' - Invalid query: 
				SELECT a.*,b.kota as ket_kota, ass.nama as assosiasi from tb_personal a
				join tb_permohonan g
					on g.token_permohonan = a.token_permohonan
				-- join ms_kota b
				-- 	on b.id = a.kota
				left join (
					SELECT d.id, f.nama from tb_user d
					join ms_assosiasi f
						on f.kode = d.kode
				) as ass
					on ass.id = g.id_assosiasi
				where a.id = '11'
			
ERROR - 2020-03-01 10:46:01 --> Severity: Notice --> Undefined property: stdClass::$ket_kota /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 112
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 47
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 66
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 90
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 101
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 112
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 123
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 175
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5132
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5140
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_x /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5250
ERROR - 2020-03-01 10:46:44 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5258
ERROR - 2020-03-01 10:47:01 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 47
ERROR - 2020-03-01 10:47:01 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 66
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 90
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 101
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 112
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 123
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 175
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5132
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5140
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_x /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5445
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5450
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5451
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5452
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5459
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5467
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5468
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5487
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5548
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined offset: 1 /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5250
ERROR - 2020-03-01 10:47:02 --> Severity: Notice --> Undefined index: td_y /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/assets/html2pdf/html2pdf.class.php 5258
ERROR - 2020-03-01 10:47:47 --> Severity: Notice --> Undefined property: stdClass::$ket_kota /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/views/cetak/cetak_skt.php 112
ERROR - 2020-03-01 04:52:59 --> Unable to load the requested class: Pdf
ERROR - 2020-03-01 10:55:57 --> Severity: error --> Exception: Call to undefined method Pdf::setPaper() /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Permohonan.php 870
ERROR - 2020-03-01 10:56:54 --> Severity: Notice --> Undefined property: Permohonan::$pdfdom /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Permohonan.php 870
ERROR - 2020-03-01 10:56:54 --> Severity: error --> Exception: Call to a member function setPaper() on null /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/controllers/Permohonan.php 870
ERROR - 2020-03-01 10:57:10 --> Severity: Compile Error --> Cannot declare class Pdf, because the name is already in use /Applications/XAMPP/xamppfiles/htdocs/project/pengajuan/application/libraries/Pdfdom.php 17
ERROR - 2020-03-01 11:33:57 --> 404 Page Not Found: Master/favicon.ico
ERROR - 2020-03-01 11:40:42 --> Query error: Unknown column 'a.status' in 'where clause' - Invalid query: 
          SELECT COUNT(*) as jumlah
            FROM ms_jabatan a
            where a.status=1 
ERROR - 2020-03-01 05:40:45 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 11:40:49 --> Query error: Unknown column 'a.status' in 'where clause' - Invalid query: 
          SELECT COUNT(*) as jumlah
            FROM ms_jabatan a
            where a.status=1 
ERROR - 2020-03-01 05:40:49 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 11:41:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'from ms_jabatan a
            where a.status=1 
            
             ORDER ' at line 2 - Invalid query: 
          SELECT a.*,
          from ms_jabatan a
            where a.status=1 
            
             ORDER BY a.insert_at desc 
            LIMIT 0, 10
        
ERROR - 2020-03-01 05:41:34 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 05:41:47 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 12:39:25 --> 404 Page Not Found: Master/favicon.ico
ERROR - 2020-03-01 06:43:04 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 06:43:29 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 12:43:29 --> 404 Page Not Found: Master/favicon.ico
ERROR - 2020-03-01 06:45:27 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 12:45:27 --> 404 Page Not Found: Master/favicon.ico
ERROR - 2020-03-01 06:57:38 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 06:58:23 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 06:58:34 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 07:05:57 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 07:06:00 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 07:06:41 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 07:06:57 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-03-01 09:47:11 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-03-01 09:50:53 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-03-01 15:52:02 --> Query error: Unknown column 'jabatan' in 'field list' - Invalid query: UPDATE `tb_user` SET `nik` = '12345678', `nama` = 'pengurus', `alamat` = 'tegalarum', `kontak` = '098765431', `email` = 'nur.rohim@gmedia.co.id', `username` = 'pengurus', `password` = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', `level` = '12', `kode` = 0, `jabatan` = '1', `user_update` = 'admin', `update_at` = '2020-03-01 15:52:02'
WHERE `id` = '9'
ERROR - 2020-03-01 09:52:09 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-01 15:52:16 --> Query error: Unknown column 'jabatan' in 'field list' - Invalid query: UPDATE `tb_user` SET `nik` = '12345678', `nama` = 'pengurus', `alamat` = 'tegalarum', `kontak` = '098765431', `email` = 'nur.rohim@gmedia.co.id', `username` = 'pengurus', `password` = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', `level` = '12', `kode` = 0, `jabatan` = '1', `user_update` = 'admin', `update_at` = '2020-03-01 15:52:16'
WHERE `id` = '9'
ERROR - 2020-03-01 09:55:12 --> 404 Page Not Found: Assets/global
