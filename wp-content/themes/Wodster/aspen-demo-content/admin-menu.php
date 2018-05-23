<?php

add_action( 'admin_menu', 'ags_demo_data_admin_menu', 100 );

function ags_demo_data_admin_menu() {

	add_submenu_page('wodster-options', __( 'Import Demo Data', 'Divi' ), __( 'Import Demo Data', 'Divi' ), 'manage_options', 'ags_demo_installer', 'ags_demo_data_admin_page');

}



function ags_demo_data_admin_page() {

	include(dirname(__FILE__).'/init.php');

	

	$importer = new AGS_Theme_Demo_Data_Importer();

	$importer->demo_installer();

}

?>