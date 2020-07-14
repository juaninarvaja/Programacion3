<?php 
	interface IDaoABM{ 
		public static function GetById($id); 
		public static function GetAll(); 
		public static function Insert($elemento);
		public static function Update($elemento);
		public static function Delete($id);
	}
?>