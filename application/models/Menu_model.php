<?php 
class Menu_model extends CI_Model{

	function __construct(){
		parent::__construct();	
	}

	function parent($class='', $method=''){
		return $this->db->where('fungsi', $class)
				->where('method', $method)
				->get('tb_menu')
				->row();
	}

	function view_menu($parent=0){

		$username = $this->session->userdata('username');

		return $this->db->query("
			SELECT a.*, c.sess, IFNULL(jumlah_menu.jumlah, 0) AS hitung
			FROM tb_menu a
			INNER JOIN tb_user_menu b ON b.id_menu = a.id
			inner join tb_user c on c.username = b.usr_name
			LEFT JOIN (
				SELECT parent, COUNT(*) AS jumlah
				FROM tb_menu
				INNER JOIN tb_user_menu ON tb_menu.id = tb_user_menu.id_menu
				WHERE tb_user_menu.usr_name = '$username'
				AND tb_menu.status = 1
				GROUP BY parent
			) AS jumlah_menu ON a.id = jumlah_menu.parent
			WHERE a.parent = '$parent'
			AND b.usr_name = '$username'
			AND a.status = 1
			ORDER BY a.urutan ASC")->result();
	}

	function create_menu($parent=0, $level=0)
	{
		$menu = $this->view_menu($parent);
		$class = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        $this_menu = $this->parent($class, $method);
        $this_parent = isset($this_menu->parent) ? $this_menu->parent : '';

		$return = '';
		if (! empty($menu)) {
			foreach ($menu as $row) {
				$active = '';
				$expanded = '';
				if ($class == $row->fungsi && $method == $row->method) {
					$active = 'active';
				}

				$url = 'javascript:;';
				if ($row->url != '') {
				    $sess ='';
				    if($row->sess != ''){
				        $sess ='?sess='.$row->sess;
				    }else{
				        $sess ='';
				    }
					$url = base_url().$row->url.$sess;
				}else{
				    $url ='';
				}

				if ($level == 0) {
					if ($row->hitung > 0) {
						if ($row->id == $this_parent) {
							$expanded = 'active open ';
						}

						$return .= '<li class="nav-item '.$expanded.'">';
						$return .= '<a href="'.$url.'" class="nav-link nav-toggle">
                                		<i class="'.$row->icon.'"></i>
		                                <span class="title">'.$row->label.'</span>
                                		<span class="arrow"></span>
									</a>';
						$return .= '<ul class="sub-menu">';
						$return .= $this->create_menu($row->id, ($level + 1));
						$return .= '</ul>';
					} else {
						$return .= '<li class="nav-item '.$active.'">
										<a href="'.$url.'" class="nav-link">
	                                		<i class="'.$row->icon.'"></i>
			                                <span class="title">'.$row->label.'</span>
	                                    </a>';
					}
					$return .= '</li>';
				} else {
					$return .= '<li class="nav-item '.$active.'" aria-haspopup="true">
									<a href="'.$url.'" class="nav-link">
	                            		<i class="'.$row->icon.'"></i>
		                                <span class="title">'.$row->label.'</span>
	                                </a>
	                            </li>';
				}
			}
		}

		return $return;;
	}
}