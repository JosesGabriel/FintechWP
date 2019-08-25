<?php

include 'functions-socket.php';
include 'functions-um.php';
include 'functions-arbitrage-api.php';
include 'functions-accounts-api.php';
include 'functions-social-api.php';

function my_theme_enqueue_styles()
{


    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    // wp_enqueue_style('normalize_css', get_template_directory_uri() . '/normalize.css');
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');



add_shortcode('wpshout_frontend_post', 'wpshout_frontend_post');
function wpshout_frontend_post()
{
    wpshout_save_post_if_submitted(); ?>
    	<div class="post-user">
    		<form id="new_post" name="new_post" method="post">
	    		<div class="post-user-inner">
	    			<div class="header-post">
	    				Share your ideas
	    				<input type="hidden" name="title" value="<?php echo get_the_date('l jS \of F Y h:i:s A'); ?>">
	    			</div>
	    			<div class="inner-post">
	    				<textarea id="content" tabindex="3" name="content" cols="50" rows="6"></textarea>
	    			</div>
	    			<div class="footer-post">
	    				<div class="footer-left-upload">
	    					Tags: <input type="text" value="" tabindex="5" size="16" name="post_tags" id="post_tags" />
	    				</div>
	    				<div class="footer-left-post">
	    					<?php wp_nonce_field('wps-frontend-post'); ?>
	    					<input type="submit" value="Post" tabindex="6" id="submit" name="submit" />
	    				</div>
	    				<br class="clear">
	    			</div>
	    		</div>
    		</form>
    	</div>
    <?php
}

function wpshout_save_post_if_submitted()
{
    // Stop running function if form wasn't submitted
    if (!isset($_POST['title'])) {
        return;
    }

    // Check that the nonce was set and valid
    if (!wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post')) {
        echo 'Did not save because your form seemed to be invalid. Sorry';
        return;
    }

    // Do some minor form validation to make sure there is content
    if (strlen($_POST['title']) < 3) {
        echo 'Please enter a title. Titles must be at least three characters long.';
        return;
    }
    if (strlen($_POST['content']) < 5) {
        echo 'Please enter content more than 5 characters in length';
        return;
    }

    // Add the content of the form to $post as an array
    $post = [
        'post_title' => $_POST['title'],
        'post_content' => $_POST['content'],
        'post_status' => 'publish',   // Could be: publish
        'post_type' => 'post' // Could be: `page` or your CPT
    ];
    $postid = wp_insert_post($post);
    wp_set_object_terms($postid, 'user_post', 'category');
    wp_set_post_tags($postid, $_POST['post_tags'], true);

    // echo 'Saved your post successfully! :)';
    wp_redirect($_SERVER['HTTP_REFERER']);
}

include_once ABSPATH . WPINC . '/rss.php';

function readRss($atts)
{
    extract(shortcode_atts([
        'feed' => 'http://',
        'num' => '1',
    ], $atts));

    return wp_rss($feed, $num);
}

add_shortcode('rss', 'readRss');
add_filter('show_admin_bar', '__return_true');
add_filter(
    'flp/redirect_url',
    function ($url) {
        return site_url('/');
    }
);

// include styles of arbitrage team
function custom_enqueue_styles()
{
    // enqueue parent styles
    wp_enqueue_style('parent-theme-rp', get_stylesheet_directory_uri() . '/arphie-style.css');
    wp_enqueue_style('parent-theme-nc', get_stylesheet_directory_uri() . '/nicar-style.css');
    wp_enqueue_style('jquery-toast', get_stylesheet_directory_uri() . '/plugins/toast/jquery.toast.min.css');
}
function custom_enqueue_scripts()
{
    $user_secret = '';
    $user_id = (int) get_current_user_id();

    if ($user_id !== 0) {
        $user_secret = get_user_meta($user_id, 'user_secret', true);
        wp_enqueue_script('child-theme-em', get_stylesheet_directory_uri() . '/js/vyndue-script.js');
    }

    wp_enqueue_script('jquery-toast', get_stylesheet_directory_uri() . '/plugins/toast/jquery.toast.min.js');
    wp_localize_script('child-theme-em', 'scriptVars', ['user_secret' => $user_secret]);
}
add_action('wp_enqueue_scripts', 'custom_enqueue_styles', 20);
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts', 20);

/*include 'ab-functions.php';
include 'arphie-function.php';
include 'nikko-functions.php';*/
// include 'emman-functions.php';

// add_action( 'um_registration_complete', 'vyndue_user_register', 10, 2 );

// function vyndue_user_register( $user_id, $args ) {
//     echo "TESST";
//     var_dump($args);
//     exit();
// }
// add_action( 'um_user_register', 'vyndue_user_register', 10, 2 );

// add_action('register_post', function ($sanitized_user_login, $user_email, $errors) {
//     echo '<pre class="registerr-post">';
//     print_r($sanitized_user_login);
//     print_r($user_email);
//     print_r($errors);
//     echo '</pre>';
//     exit();
// }, 10, 2);

add_action('user_register', 'myplugin_registration_save', 10, 1);
function myplugin_registration_save($user_id)
{
    // $secret = $_POST['nickname-9'] . $user_id . str_pad(rand(0, 9999), 3, '0', STR_PAD_LEFT);
    $secret = $_POST['nickname-9'] . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    add_user_meta($user_id, 'user_secret', $secret);

    //region Set POST data
    $data = http_build_query([
        'first_name' => $_POST['first_name-9'],
        'last_name' => $_POST['last_name-9'],
        'email' => $_POST['user_email-9'],
        'password' => $_POST['user_password-9'],
        'user_secret' => $secret,
    ]);
    //endregion Set POST data

    $api_data = [
        'first_name' => $_POST['first_name-9'],
        'last_name' => $_POST['last_name-9'],
        'username' => $_POST['nickname-9'],
        'email' => $_POST['user_email-9'],
        'password' => $_POST['user_password-9'],
        'password_confirmation' => $_POST['user_password-9'],
        'profile_image' => '',
    ];
    
    $response = arbitrage_api_curl('api/register', $api_data);
    if ($response) {
        add_user_meta($user_id, 'user_uuid', $response['user']['uuid']);
    }

    //region call api
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/create');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    //region call api
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://game.arbitrage.ph/api/createuser');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}

add_action('um_friends_after_user_friend', 'vyndue_add_friend', 10, 2);
function vyndue_add_friend($user_1, $user_2)
{
    //region get users
    $user_email_1 = (get_userdata($user_1))->user_email;
    $user_email_2 = (get_userdata($user_2))->user_email;
    //endregion get users

    //region set post data
    $data = http_build_query([
        'requester' => $user_email_1,
        'responder' => $user_email_2,
    ]);
    //endregion set post data

    //region call api
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/add_friend');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    //endregion call api
}

add_action('um_friends_after_user_unfriend', 'vyndue_remove_friend', 10, 2);
function vyndue_remove_friend($user_1, $user_2)
{
    //region get users
    $user_email_1 = (get_userdata($user_1))->user_email;
    $user_email_2 = (get_userdata($user_2))->user_email;
    //endregion get users

    //region set post data
    $data = http_build_query([
        'requester' => $user_email_1,
        'responder' => $user_email_2,
    ]);
    //endregion set post data

    //region call api
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/remove_friend');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    //endregion call api
}

add_action('profile_update', 'vyndue_user_update', 10, 2);
function vyndue_user_update($user_id, $old_user_data)
{
    //region get users
    $user = get_userdata($user_id);
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    //endregion get users

    //region data validation
    $update = [
        'email_id' => $old_user_data->user_email,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
    ];

    if ($user->user_email !== $old_user_data->user_email) {
        $update['email'] = $user->user_email;
    }
    //endregion data validation

    //region set post data
    $data = http_build_query($update);
    //endregion set post data

    arbitrage_api_curl("api/users/$user_uuid/update", [
        'email' => $user->user_email,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
    ]);
    
    //region call api
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/update');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    //endregion call api
}

// add_action('password_reset', 'vyndue_password_update', 10, 2);
// function vyndue_password_update($user, $new_password) {
add_action('um_change_password_process_hook', 'vyndue_password_update', 10, 2);
function vyndue_password_update($post)
{
    $user_id = get_current_user_id();
    $user = get_userdata($user_id);
    $user_uuid = arbitrage_api_get_user_uuid($user_id);

    $data = http_build_query([
        'email_id' => $user->user_email,
        'password' => $_POST['user_password'],
    ]);

    arbitrage_api_curl("api/users/$user_uuid/update", [
        'password' => $_POST['user_password'],
    ]);

    //region call api
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/update');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    //endregion call api
}

add_filter('um_account_tab_general_fields', 'my_account_tab_general_fields', 10, 2);
function my_account_tab_general_fields($args, $shortcode_args)
{
    // your code here
    return $args . ',nickname';
}

$search_string = esc_attr(trim(get_query_var('s')));
$users = new WP_User_Query([
    'search' => "*{$search_string}*",
    'search_columns' => [
        'user_login',
        'user_nicename',
        'user_email',
        'user_url',
    ],
    'meta_query' => [
        'relation' => 'OR',
        [
            'key' => 'first_name',
            'value' => $search_string,
            'compare' => 'LIKE'
        ],
        [
            'key' => 'last_name',
            'value' => $search_string,
            'compare' => 'LIKE'
        ]
    ]
]);
$users_found = $users->get_results();

function ab_exclusions()
{
    wp_deregister_script('frontend-builder-global-functions');
}
add_action('wp_enqueue_scripts', 'ab_exclusions', 100);

// [bartag foo="foo-value"]


add_action('wp_ajax_data_fetch', 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch', 'data_fetch');

function data_fetch(){

    $query = $_POST['keyword'];

    $author_query = array(
        'posts_per_page' => '-1',
        'post_status' => 'publish',
        'meta_key' => 'data_userid',
        'meta_value' => get_current_user_id(),
    );
    $author_posts = new WP_Query($author_query);

    echo $query;
            $count = 1;
            $dpage = 1;
           // $current = (isset($_GET['pt']) ? $_GET['pt'] : 1);
            $dlisttrade = [];
            if ($author_posts->have_posts()) {
                while ($author_posts->have_posts()) {
                    $author_posts->the_post();
                    $dlisttrade[$dpage][$count]['id'] = get_the_ID();
                    $dlisttrade[$dpage][$count]['data_stock'] = get_post_meta(get_the_ID(), 'data_stock', true);
                    $dlisttrade[$dpage][$count]['data_sellmonth'] = get_post_meta(get_the_ID(), 'data_sellmonth', true);
                    $dlisttrade[$dpage][$count]['data_sellday'] = get_post_meta(get_the_ID(), 'data_sellday', true);
                    $dlisttrade[$dpage][$count]['data_sellyear'] = get_post_meta(get_the_ID(), 'data_sellyear', true);

                    $data_dprice = get_post_meta(get_the_ID(), 'data_dprice', true);
                    $dlisttrade[$dpage][$count]['data_dprice'] = str_replace('₱', '', $data_dprice);

                    $dlisttrade[$dpage][$count]['data_sell_price'] = get_post_meta(get_the_ID(), 'data_sell_price', true);
                    $dlisttrade[$dpage][$count]['data_quantity'] = get_post_meta(get_the_ID(), 'data_quantity', true);

                    $data_trade_info = get_post_meta(get_the_ID(), 'data_trade_info', true);
                    $dlisttrade[$dpage][$count]['data_trade_info'] = json_decode($data_trade_info);
                    $dlisttrade[$dpage][$count]['data_avr_price'] = get_post_meta(get_the_ID(), 'data_avr_price', true);

                    // $dlisttrade[$dpage]
                    
                }
                wp_reset_postdata();
            }
            foreach ($dlisttrade[$current] as $tlkey => $tlvalue):
                    $data_sellmonth = $tlvalue['data_sellmonth'];
                    $data_sellday = $tlvalue['data_sellday'];
                    $data_sellyear = $tlvalue['data_sellyear'];
                    $data_stock = $tlvalue['data_stock'];
                    $data_dprice = $tlvalue['data_dprice'];
                    $data_sell_price = $tlvalue['data_sell_price'];
                    $data_quantity = $tlvalue['data_quantity'];
                    $data_trade_info = $tlvalue['data_trade_info'];
                    $data_avr_price = $tlvalue['data_avr_price'];

                    // get prices
                    $soldplace = $data_quantity * $data_sell_price;
                    $baseprice = $data_quantity * $data_dprice;

                    $sellfee = getjurfees($soldplace, 'sell');

                    //profit or loss
                    $dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

                    // profperc
                    $dtlprofperc = (abs($dprofit) / ($data_quantity * $data_avr_price)) * 100;
                    $totalprofit += $dprofit;

                    if($query == $data_stock){
                        echo $data_stock;

                    }else{
                        echo 'no records found';
                    }

            endforeach; 
}




function getfriendsbyat( $atts ) {
	$a = shortcode_atts( array(
		'userid' => 0
    ), $atts );

    global $wpdb;

    $table = $wpdb->prefix . "um_friends";
    $results = $wpdb->get_results( $wpdb->prepare(
        "SELECT user_id1, user_id2 FROM {$table} WHERE status = 1 AND ( user_id1 = %d OR user_id2 = %d ) ORDER BY time DESC", $a['user_id1'], $a['userid']
    ), ARRAY_A ); 
    //echo $a['userid'];

     $listoffriends = [];
    foreach ( $results as $page )
        {
          $user_info = get_userdata($page['user_id1']);       
          
          $infoars = [];
          $infoars['id'] = $user_info->ID;
          $infoars['firstname'] = $user_info->first_name;
          $infoars['lastname'] = $user_info->last_name;

        array_push($listoffriends,$infoars);
            
        }

        echo json_encode($results);
        die();
        // wp_send_json_success(json_encode($listoffriends));
        
}
add_shortcode( 'mytagfriends', 'getfriendsbyat' );


add_action('wp_ajax_get_friends', 'getfriendsbyat');
add_action('wp_ajax_nopriv_get_friends', 'getfriendsbyat');
/**
* Added by Allan
* 05-07-2019
*/
/* temp-disabled-start require_once get_stylesheet_directory() . '/apyc/init.php'; */

/**
 * Upload to Google Cloud Storage
 * 
 * @see https://developer.wordpress.org/reference/hooks/wp_handle_upload/
 */
add_filter('wp_handle_upload', function ($upload) {
    $file = $upload['file'];
    $type = $upload['type'];
    $info = pathinfo($file);
    $filename = $info['basename'];

    $file_data = new CURLFILE($file, $type, $filename);
    $data = [
        'file' => $file_data,
    ];

    $response = arbitrage_api_curl_multipart('api/storage/upload', $data, 'POST');

    // if the response fails, use wp's upload url
    $upload['gcs_url'] = $upload['url'];

    if ($response !== false) {
        $upload['gcs_url'] = $response['file']['url'];
    }

    return $upload;
}, 90, 1);
