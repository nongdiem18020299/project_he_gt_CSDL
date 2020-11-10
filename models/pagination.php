<?php
class Pagination{
	
	public $limit = 7; // số record hiển thị trên một trang
	protected $_baseUrl;
	public function __construct(){
//		
            //$site_path = "http://localhost/ShipCom/";
            $this->_baseUrl = __SITE_PATH.'/vieclam';
	}
	/**
	  - Tìm ra vị trí start
	*/
	public function start(){
		if(isset($_GET['start'])){
			$start = $_GET['start'];
		}else{
			$start = 0;
		}
		return $start;
	}
	
	/**
	  - Tìm ra tổng số trang
	*/
	public function totalPages($totalRecord){
		if(isset($_GET['pages'])){
			$totalPages = $_GET['pages'];
		}else{
			$totalPages = ceil($totalRecord/$this->limit);
		}
		return $totalPages;
	}
	
	/**
	  - Gọi ra list phân trang
	*/
	public function listPages($totalPages){
		$start = $this->start();
		$limit = $this->limit;
		$listPage = '';
		
		if($totalPages > 1){ // số trang phải từ 2 trang trở lên
			$current = ($start/$limit) + 1; // trang hiện tại
			if($current != 1){ // Nút prev
				$newstart = $start - $limit;
				$listPage .= "<a href='".$this->_baseUrl."?pages=$totalPages&start=$newstart'>Trang Trước</a>";
			}
			
			for($i=1;$i<=$totalPages;$i++){  // Tất cả các trang tìm được
				$newstart = ($i - 1)*$limit;
				if($i == $current){
					$listPage .= "<span class='current'>".$i."</span>";
				}else{
					$listPage .= "<a href='".$this->_baseUrl."?pages=$totalPages&start=$newstart'>".$i."</a>";
				}
			}
			
			if($current != $totalPages){ // Nút next
				$newstart = $start + $limit;
				$listPage .= "<a href='".$this->_baseUrl."?pages=$totalPages&start=$newstart'>Trang Sau</a>";
			}
		}
		
		return $listPage;
	}
}