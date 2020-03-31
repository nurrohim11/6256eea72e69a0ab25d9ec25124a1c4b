<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-03-31 01:12:01 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-03-31 06:35:27 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): No connection could be made because the target machine actively refused it.
 D:\program\htdocs\project\pengajuan\system\database\drivers\mysqli\mysqli_driver.php 203
ERROR - 2020-03-31 06:35:27 --> Unable to connect to the database
ERROR - 2020-03-31 01:52:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-03-31 01:52:56 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-03-31 01:58:42 --> Severity: Parsing Error --> syntax error, unexpected 'list' (T_LIST), expecting identifier (T_STRING) D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 707
ERROR - 2020-03-31 01:59:02 --> Severity: Parsing Error --> syntax error, unexpected 'list' (T_LIST), expecting identifier (T_STRING) D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 707
ERROR - 2020-03-31 06:59:08 --> 404 Page Not Found: Master/favicon.ico
ERROR - 2020-03-31 01:59:11 --> Severity: Parsing Error --> syntax error, unexpected 'list' (T_LIST), expecting identifier (T_STRING) D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 707
ERROR - 2020-03-31 06:59:38 --> 404 Page Not Found: Permohonan/list
ERROR - 2020-03-31 06:59:44 --> 404 Page Not Found: 
ERROR - 2020-03-31 07:00:16 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-31 07:00:23 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:00:23 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:00:32 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:00:32 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 02:00:40 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-31 07:00:47 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:00:47 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 02:01:52 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-31 07:02:09 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:02:09 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:02:12 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:02:12 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:02:18 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 07:02:18 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\models\Permohonan_model.php 572
ERROR - 2020-03-31 02:03:32 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-31 07:03:32 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'b.token_klasifikasi
                            from tb_biaya_pengembangan b
   ' at line 11 - Invalid query: 
    			SELECT SUM(m.total_biaya) as jml from(
	    			SELECT ifnull(detail.total_kontruksi,0) + ifnull(p.total_pengembangan,0) as total_biaya,a.token_permohonan
						from tb_personal a
						left join (
							SELECT ifnull(SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn),0) as total_kontruksi,b.token_klasifikasi
							from detail_klasifikasi b
							GROUP by b.token_klasifikasi
						) as detail
						on a.token_klasifikasi = detail.token_klasifikasi
                        left join (
                            SELECT ifnull(SUM(b.lpjkp+b.lpjkn),0)) as total_pengembangan,b.token_klasifikasi
                            from tb_biaya_pengembangan b
                            GROUP by b.token_klasifikasi
                        ) as p
                        on a.token_klasifikasi = p.token_klasifikasi
			            where a.status=1
			        ) as m 
			        where m.token_permohonan = '0.8937913741960337'
    			
ERROR - 2020-03-31 07:04:05 --> Severity: Notice --> Undefined variable: dt D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 862
ERROR - 2020-03-31 07:04:05 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 862
ERROR - 2020-03-31 07:04:51 --> Severity: 4096 --> Object of class stdClass could not be converted to string D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 862
ERROR - 2020-03-31 07:04:51 --> Severity: Notice --> Object of class stdClass to string conversion D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 862
ERROR - 2020-03-31 07:04:51 --> Severity: Notice --> Undefined variable: Object D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 862
ERROR - 2020-03-31 07:04:51 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 862
ERROR - 2020-03-31 07:05:08 --> Severity: 4096 --> Object of class stdClass could not be converted to string D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 863
ERROR - 2020-03-31 07:05:08 --> Severity: Notice --> Object of class stdClass to string conversion D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 863
ERROR - 2020-03-31 07:05:08 --> Severity: Notice --> Undefined variable: Object D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 863
ERROR - 2020-03-31 07:05:08 --> Severity: Notice --> Trying to get property of non-object D:\program\htdocs\project\pengajuan\application\controllers\Permohonan.php 863
ERROR - 2020-03-31 08:08:05 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-31 03:32:33 --> 404 Page Not Found: Assets/apps
ERROR - 2020-03-31 08:32:33 --> Severity: error --> Exception: ERROR n°6 : Impossible to load the image http://localhost/project/pengajuan/assets/apps/logo_lpjk.png D:\program\htdocs\project\pengajuan\assets\html2pdf\html2pdf.class.php 1319
ERROR - 2020-03-31 03:32:45 --> 404 Page Not Found: Assets/apps
ERROR - 2020-03-31 08:37:35 --> 404 Page Not Found: Permohonan/favicon.ico
ERROR - 2020-03-31 03:42:10 --> 404 Page Not Found: Main/favicon.ico
ERROR - 2020-03-31 08:42:22 --> 404 Page Not Found: Master/favicon.ico
ERROR - 2020-03-31 03:43:31 --> 404 Page Not Found: Assets/global
ERROR - 2020-03-31 03:46:37 --> 404 Page Not Found: Main/favicon.ico
