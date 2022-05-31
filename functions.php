<?php
include_once get_template_directory() . '/functions/inc/admin-interface.php';
include_once get_template_directory() . '/functions/inc/theme-options.php';
include_once get_template_directory() . '/functions/inc/widget.php';
register_sidebar( array(
		'name'          => '侧边栏',
		'id'            => 'sidebar',
		'description'   => '在此添加小工具',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="boxTitle">',
		'after_title'   => '</h3>',
) );	
// 友情链接
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
//侧边栏
function unregister_default_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Block');
    unregister_widget('WP_Widget_Media_Image');
    unregister_widget('WP_Widget_Media_Gallery');
    unregister_widget('WP_Widget_Media_Video');
    unregister_widget('WP_Widget_Media_Audio');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Nav_Menu_Widget');
}
add_action('widgets_init', 'unregister_default_widgets', 11);

//隐藏前台顶部工具条
add_filter('show_admin_bar', '__return_false');
register_nav_menus ( array (
'menu' => '导航菜单',
) );
function inkthemes_nav() {
if (function_exists('wp_nav_menu'))
wp_nav_menu(array('theme_location' => 'menu','container' =>'','menu_id'=>'menu-main-menu','menu_class' => 'menu', 'fallback_cb' => 'inkthemes_nav_fallback'));
else
inkthemes_nav_fallback();
}
function inkthemes_nav_fallback() {
?>
<ul>
<?php
wp_list_cats('title_li=&show_home=1&sort_column=menu_order');
?>
</ul>
<?php
}
//禁用古登堡编辑器
//add_filter('use_block_editor_for_post', '__return_false');
//remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');
// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

//删除wp_head()中的title标签
remove_action( 'wp_head', '_wp_render_title_tag', 1 );

//头像加载加速
function get_cravatar_url($url){
          $sources = array(
             'www.gravatar.com',
             '0.gravatar.com',
             '1.gravatar.com',
             '2.gravatar.com',
             'secure.gravatar.com',
             'cn.gravatar.com'
             );

   return str_replace($sources, 'cravatar.cn', $url);
}
add_filter('get_avatar_url', 'get_cravatar_url', 1);

//修复4.2表情bug
function disable_emoji9s_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

function remove_emoji9s() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emoji9s_tinymce' );
}

add_action( 'init', 'remove_emoji9s' );

//WordPress 移除头部 global-styles-inline-css
add_action('wp_enqueue_scripts', 'fanly_remove_styles_inline');
function fanly_remove_styles_inline(){
	wp_deregister_style( 'global-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
}

//彻底关闭 pingback
add_filter('xmlrpc_methods',function($methods){
	$methods['pingback.ping'] = '__return_false';
	$methods['pingback.extensions.getPingbacks'] = '__return_false';
	return $methods;
});

//禁用 pingbacks, enclosures, trackbacks
remove_action( 'do_pings', 'do_all_pings', 10 );

//去掉 _encloseme 和 do_ping 操作。
remove_action( 'publish_post','_publish_post_hook',5 );

//屏蔽字符转码
add_filter('run_wptexturize', '__return_false');

//移除后台隐私相关的页面
add_action('admin_menu', function (){
	global $menu, $submenu;
	// 移除设置菜单下的隐私子菜单。
	unset($submenu['options-general.php'][45]);
	// 移除工具彩带下的相关页面
	remove_action( 'admin_menu', '_wp_privacy_hook_requests_page' );
	remove_filter( 'wp_privacy_personal_data_erasure_page', 'wp_privacy_process_personal_data_erasure_page', 10, 5 );
	remove_filter( 'wp_privacy_personal_data_export_page', 'wp_privacy_process_personal_data_export_page', 10, 7 );
	remove_filter( 'wp_privacy_personal_data_export_file', 'wp_privacy_generate_personal_data_export_file', 10 );
	remove_filter( 'wp_privacy_personal_data_erased', '_wp_privacy_send_erasure_fulfillment_notification', 10 );
	// Privacy policy text changes check.
	remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'text_change_check' ), 100 );
	// Show a "postbox" with the text suggestions for a privacy policy.
	remove_action( 'edit_form_after_title', array( 'WP_Privacy_Policy_Content', 'notice' ) );
	// Add the suggested policy text from WordPress.
	remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'add_suggested_content' ), 1 );
	// Update the cached policy info when the policy page is updated.
	remove_action( 'post_updated', array( 'WP_Privacy_Policy_Content', '_policy_page_updated' ) );
},9);

//禁用 Google Fonts
add_filter( 'gettext_with_context', 'wpjam_disable_google_fonts', 888, 4);
function wpjam_disable_google_fonts($translations, $text, $context, $domain ) {
	$google_fonts_contexts = array('Open Sans font: on or off','Lato font: on or off','Source Sans Pro font: on or off','Bitter font: on or off');
	if( $text == 'on' && in_array($context, $google_fonts_contexts ) ){
		$translations = 'off';
	}

	return $translations;
}

//删除 wp_head 中无关紧要的代码
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');

// 禁用WP Editor Google字体css
function hi_remove_gutenberg_styles($translation, $text, $context, $domain)
{
    if($context != 'Google Font Name and Variants' || $text != 'Noto Serif:400,400i,700,700i') {
        return $translation;
    }
    return 'off';
}
add_filter( 'gettext_with_context', 'hi_remove_gutenberg_styles',10, 4);


//去除后台顶部工具条 wordpress 官方 logo
function nologo_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo'); //移除Logo
}
add_action( 'wp_before_admin_bar_render', 'nologo_admin_bar' );

/// 函数作用：取得文章的阅读次数
function record_visitors()
{
	if (is_singular()) 
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID) 
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'record_visitors');  
/// 函数名称：post_views 
/// 函数作用：取得文章的阅读次数
function post_views($before = '', $after = '', $echo = 1)
{
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if ($echo) echo $before, number_format($views), $after;
  else return $views;
}

//分页
function pagination($query_string){
global $posts_per_page, $paged;
$my_query = new WP_Query($query_string ."&posts_per_page=-1");
$total_posts = $my_query->post_count;
if(empty($paged))$paged = 1;
$prev = $paged - 1;							
$next = $paged + 1;	
$range = 4; // 分页数设置
$showitems = ($range * 2)+1;
$pages = ceil($total_posts/$posts_per_page);
if(1 != $pages){
	echo "<div class='box' id='pagenavi'>";
	echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."' class='fir_las'>最前</a>":"";
	echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."' class='page_previous'>« 上一页</a>":"";		
	for ($i=1; $i <= $pages; $i++){
	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
	echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>"; 
	}
	}
	echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."' class='page_next'>下一页 »</a>" :"";
	echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."' class='fir_las'>最后</a>":"";
	echo "</div>\n";
	}
}

//面包屑导航
function dimox_breadcrumbs() {
  $delimiter = '<i>&gt;</i>';
  $homeLink = get_bloginfo('url');
  $home = '首页';
  $name = '<a href="' . $homeLink . '" class="home">' . $home . '</a>'; //text for the 'Home' link
  $currentBefore = '<span>';
  $currentAfter = '</span>';
  if ( !is_home() && !is_front_page() || is_paged() ) {
    echo '<div class="breadcrumb"><div class="inner">';
    global $post;
    echo '' . $name . ' ' . $delimiter . ' ';
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;
    } elseif ( is_day() ) {
      echo '' . get_the_time('Y') . ' ' . $delimiter . ' ';
      echo '' . get_the_time('F') . ' ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
    } elseif ( is_month() ) {
      echo '' . get_the_time('Y') . ' ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '' . get_the_title($page->ID) . '';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_search() ) {
      echo $currentBefore . '搜索 &#39;' . get_search_query() . '&#39;的结果' . $currentAfter;
    } elseif ( is_tag() ) {
      echo $currentBefore . '';
      single_tag_title();
      echo '' . $currentAfter;
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div></div>';
  }
}

// 只搜索文章，排除页面
function search_filter($query) {
    if ($query->is_search) {$query->set('post_type', 'post');}
    return $query;}
add_filter('pre_get_posts','search_filter');
/**
 * 让 WordPress 只搜索文章的标题
 */
function wpse_11826_search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;
        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';
        $search = array();
        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";
        $search = ' AND ' . implode( ' AND ', $search );
    }
    return $search;
}
add_filter( 'posts_search', 'wpse_11826_search_by_title', 10, 2 );
/**
 * [clean_theme_meta 清除wordpress自带的meta标签]
 */
function clean_theme_meta()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7, 1);
    remove_action('wp_print_styles', 'print_emoji_styles', 10, 1);
    remove_action('wp_head', 'rsd_link', 10, 1);
    remove_action('wp_head', 'wp_generator', 10, 1);
    remove_action('wp_head', 'feed_links', 2, 1);
    remove_action('wp_head', 'feed_links_extra', 3, 1);
    remove_action('wp_head', 'index_rel_link', 10, 1);
    remove_action('wp_head', 'wlwmanifest_link', 10, 1);
    remove_action('wp_head', 'start_post_rel_link', 10, 1);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10, 1);
    remove_action('wp_head', 'rel_canonical', 10, 0);
}
add_action('after_setup_theme', 'clean_theme_meta'); //清除wp_head带入的meta标签

/*总浏览数*/
function lo_all_view(){global $wpdb;$count=0;$views= $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='views'");foreach($views as $key=>$value){$meta_value=$value->meta_value;if($meta_value!=' '){$count+=(int)$meta_value;}}return $count;}

// 评论代码
function custom_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   	global $commentcount;
	if(!$commentcount) {
		$commentcount = 0;
	}
?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
         <div class="comment-author">
                     <?php
					$author_class = '';
					if (function_exists('get_avatar') && get_option('show_avatars')) {
						$author_class = 'with_avatar';
						echo get_avatar( $comment, 36,'',$comment->comment_author);
					}
				?>
                <div class="author_info">
               <span class="lou">
				<a href="#comment-<?php comment_ID() ?>"><?php
					if(!$parent_id = $comment->comment_parent){
						switch ($commentcount){
							case 0 :echo "1<span class='dot'>楼</span>";++$commentcount;break;
							case 1 :echo "2<span class='dot'>楼</span>";++$commentcount;break;
							case 2 :echo "3<span class='dot'>楼</span>";++$commentcount;break;
							default:printf('%1$s<span class="dot">楼</span>', ++$commentcount);
						}
					}
				?>
				<?php if( $depth > 1){printf('地下%1$s层', $depth-1);} ?></a>
</span><?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?><div id="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => '回复该留言','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div></div>
                    <div id="empost">Post:<?php printf(__('%1$s at %2$s'), get_comment_date('Y/m/d '),  get_comment_time(' H:i:s')) ?></div>
          </div>
		  <?php if ($comment->comment_approved == '0') : ?>
             <em><?php _e('您的评论正在等待审核！') ?></em>
             <br />
          <?php endif; ?>
      		<?php comment_text() ?>
     </div>
	<?php
}


function deel_comment_list($comment, $args, $depth) {
    echo '<li ';
    comment_class();
    echo ' id="comment-' . get_comment_ID() . '">';
    //头像
    echo '<div class="c-avatar">';
					$author_class = '';
					if (function_exists('get_avatar') && get_option('show_avatars')) {
						$author_class = 'with_avatar';
						echo get_avatar( $comment, 56,'',$comment->comment_author);
					}
    echo '<div class="c-main" id="div-comment-' . get_comment_ID() . '">';
    //信息
    echo '<div class="c-meta">';
    echo '<span class="c-author">' . get_comment_author_link() . '</span>';
  if ($comment->user_id == '1') {
        echo '<a title="博主认证" class="vip"></a>';
	}else{
		echo get_author_class($comment->comment_author_email,$comment->user_id);
	}
	echo get_useragent($comment->comment_agent);
    if ($comment->comment_approved !== '0') {
		echo '<div class="comment-reply">';
        echo comment_reply_link(array_merge($args, array(
            'add_below' => 'div-comment',
            'depth' => $depth,
            'max_depth' => $args['max_depth']
        )));
		echo '</div>';
	echo '<div class="comment-time">';
    echo get_comment_time('Y-m-d H:i ');
        echo edit_comment_link(__('(编辑)') , '', '');
	echo '</div>';
    }
    echo '</div>';
    //内容
	comment_text();
    if ($comment->comment_approved == '0') {
        echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
    }

    echo '</div></div>';
}
//新窗口打开评论里的链接
function remove_comment_links() {
global $comment;
$url = get_comment_author_url();
$author = get_comment_author();
if ( empty( $url ) || 'http://' == $url )
$return = $author;
else
if (get_option('pagehtml_b') == 'true') {
$return="<a href='$url' rel='external nofollow' target='_blank'>$author</a>";
}else{
$return = "<a href='$url' rel='external nofollow' target='_blank'>$author</a>";
}
return $return;
}
add_filter('get_comment_author_link', 'remove_comment_links');
remove_filter('comment_text', 'make_clickable', 9);

/*UA信息*/
function get_browsers($ua){
    $title = '未知';
    $icon = 'unknow';
    if (preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'Internet Explorer '. $matches[1];
        if ( strpos($matches[1], '7') !== false || strpos($matches[1], '8') !== false)
            $icon = 'ie8';
        elseif ( strpos($matches[1], '9') !== false)
            $icon = 'ie9';
        elseif ( strpos($matches[1], '10') !== false)
            $icon = 'ie10';
        else
            $icon = 'ie';
    }elseif (preg_match('#Trident#i', $ua, $matches)){
        $title = 'IE都11了，我操';
        $icon = 'ie10';
    }elseif (preg_match('#Firefox/([a-zA-Z0-9.]+)#i', $ua, $matches)){
        $title = 'Firefox '. $matches[1];
        $icon = 'firefox';
    }elseif (preg_match('#CriOS/([a-zA-Z0-9.]+)#i', $ua, $matches)){
        $title = 'Chrome for iOS '. $matches[1];
        $icon = 'crios';
    }elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'Google Chrome '. $matches[1];
        $icon = 'chrome';
        if (preg_match('#OPR/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $title = '被过度神话的Opera';
            $icon = 'opera15';
            if (preg_match('#opera mini#i', $ua)) $title = 'Opera Mini'. $matches[1];
        }
    }elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'Safari '. $matches[1];
        $icon = 'safari';
    }elseif (preg_match('#Opera.(.*)Version[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = '被过度神话的Opera';
        $icon = 'opera';
        if (preg_match('#opera mini#i', $ua)) $title = 'Opera Mini'. $matches[2];
    }elseif (preg_match('#Maxthon( |\/)([a-zA-Z0-9.]+)#i', $ua,$matches)) {
        $title = 'Maxthon '. $matches[2];
        $icon = 'maxthon';
    }elseif (preg_match('#360([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = '360 Browser '. $matches[1];
        $icon = '360se';
    }elseif (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'SouGou Browser 2'.$matches[1];
        $icon = 'sogou';
    }elseif (preg_match('#UCWEB([a-zA-Z0-9.]+)#i', $ua, $matches)) {
        $title = 'UCWEB '. $matches[1];
        $icon = 'ucweb';
    }
    elseif(preg_match('#wp-android([a-zA-Z0-9.]+)#i', $ua, $matches))
    {
        $title = 'wordpress客户端'. $matches[1];
        $icon = 'wordpress';
    }
    elseif(preg_match('/wp-blackberry/i', $useragent))
    {
        $title = 'wordpress客户端'. $matches[1];
        $icon = 'wordpress';
    }
    elseif(preg_match('#wp-iphone/([a-zA-Z0-9.]+)#i', $ua, $matches))
    {
        $title = 'wordpress客户端'. $matches[1];
        $icon = 'wordpress';
    }
    elseif(preg_match('/wp-nokia/i', $useragent))
    {
        $title = 'wordpress客户端'. $matches[1];
        $icon = 'wordpress';
    }
    elseif(preg_match('/wp-webos/i', $useragent))
    {
        $title = 'wordpress客户端'. $matches[1];
        $icon = 'wordpress';
    }
    elseif(preg_match('/wp-windowsphone/i', $useragent))
    {
        $title = 'wordpress客户端'. $matches[1];
        $icon = 'wordpress';
    }
    return array(
        $title,
        $icon
    );
}

function get_os($ua){
    $title = '未知';
    $icon = 'unknow';
    if (preg_match('/win/i', $ua)) {
        if (preg_match('/Windows NT 6.1/i', $ua)) {
            $title = "Windows 7";
            $icon = "windows_win7";
        }elseif (preg_match('/Windows NT 5.1/i', $ua)) {
            $title = "Windows XP";
            $icon = "windows";
        }elseif (preg_match('/Windows NT 6.2/i', $ua)) {
            $title = "Windows 8";
            $icon = "windows_win8";
        }elseif (preg_match('/Windows NT 6.3/i', $ua)) {
            $title = "Windows 8";
            $icon = "windows_win8";
        }elseif (preg_match('/Windows NT 6.0/i', $ua)) {
            $title = "Windows Vista";
            $icon = "windows_vista";
        }elseif (preg_match('/Windows NT 5.2/i', $ua)) {
            if (preg_match('/Win64/i', $ua)) {
                $title = "Windows XP 64 bit";
            } else {
                $title = "Windows Server 2003";
            }
            $icon = 'windows';
        }elseif (preg_match('/Windows Phone/i', $ua)) {
            $matches = explode(';',$ua);
            $title = $matches[2];
            $icon = "windows_phone";
        }
    }elseif (preg_match('#iPod.*.CPU.([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
        $title = "iPod".$matches[1];
        $icon = "iphone";
    } elseif (preg_match('#iPhone OS([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
        $title = '土豪专用';
        $icon = "iphone";
    } elseif (preg_match('#iPad.*.CPU.([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
        $title = "iPad".$matches[1];
        $icon = "ipad";
    } elseif (preg_match('/Mac OS X.([0-9. _]+)/i', $ua, $matches)) {
        if(count(explode(7,$matches[1]))>1) $matches[1] = 'Lion '.$matches[1];
        elseif(count(explode(8,$matches[1]))>1) $matches[1] = 'Mountain Lion '.$matches[1];
        $title = "Mac OSX ".$matches[1];
        $icon = "macos";
    } elseif (preg_match('/Macintosh/i', $ua)) {
        $title = "Mac OS";
        $icon = "macos";
    } elseif (preg_match('/Macintosh/i', $ua)) {
        $title = "Mac OS";
        $icon = "macos";
    } elseif (preg_match('/HTC/i', $ua)){
        $title = "HTC";
        $icon = "htc";
    }elseif (preg_match('/Linux/i', $ua)) {
        $title = 'Linux';
        $icon = 'linux';
        if (preg_match('/Android.([0-9. _]+)/i',$ua, $matches)) {
            $title= $matches[0];
            $icon = "android";
        }elseif (preg_match('#Ubuntu#i', $ua)) {
            $title = "Ubuntu Linux";
            $icon = "ubuntu";
        }elseif(preg_match('#Debian#i', $ua)) {
            $title = "Debian GNU/Linux";
            $icon = "debian";
        }elseif (preg_match('#Fedora#i', $ua)) {
            $title = "Fedora Linux";
            $icon = "fedora";
        }

    }
    return array(
        $title,
        $icon
    );
}

function get_useragent($ua){
    $url = get_bloginfo('template_directory') . '/images/browsers/';
    $browser = get_browsers($ua);
    $os = get_os($ua);
    echo '&nbsp;&nbsp;&nbsp;<img src="'.$url.$browser[1].'.png" width="16px" height="16px" title="'.$browser[0].'" style="border:0px;vertical-align:middle;" alt="'.$browser[0].'">&nbsp;&nbsp;&nbsp;<img width="16px" height="16px" src="'.$url.$os[1].'.png" title="'.$os[0].'" style="border:0px;vertical-align:middle;" alt="'.$os[0].'">';
}


/** WordPress 添加评论之星**/

function get_author_class($comment_author_email, $user_id){
	global $wpdb;
	$author_count = count($wpdb->get_results(
	"SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
	if($author_count>=1 && $author_count< 10)
		echo '<a class="vip1" title="评论达人 LV.1"></a>';
	else if($author_count>=10 && $author_count< 30)
		echo '<a class="vip2" title="评论达人 LV.2"></a>';
	else if($author_count>=30 && $author_count< 60)
		echo '<a class="vip3" title="评论达人 LV.3"></a>';
	else if($author_count>=60 && $author_count< 120)
		echo '<a class="vip4" title="评论达人 LV.4"></a>';
	else if($author_count>=120 && $author_count< 240)
		echo '<a class="vip5" title="评论达人 LV.5"></a>';
	else if($author_count>=240 && $author_count< 480)
		echo '<a class="vip6" title="评论达人 LV.6"></a>';
	else if($author_count>=480)
		echo '<a class="vip7" title="评论达人 LV.7"></a>';
}


// 评论添加@，by Ludou
function ludou_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a style="color:#2970A6;"  href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);

//评论分页的seo处理
function canonical_for_git() {
        global $post;
        if ( get_query_var('paged') > 1 ) :
                echo "\n";
                echo "<link rel='canonical' href='";
                echo get_permalink( $post->ID );
                echo "' />\n";
                echo "<meta name=\"robots\" content=\"noindex,follow\">";
         endif;
}
add_action( 'wp_head', 'canonical_for_git' );

// 禁止无中文留言
function refused_spam_comments($comment_data) {
    $pattern = '/[一-龥]/u';
    $jpattern = '/[ぁ-ん]+|[ァ-ヴ]+/u';
    if (!preg_match($pattern, $comment_data['comment_content'])) {
        err(__('来一波汉字吧，苦逼的庭主只认识汉字！You should type some Chinese word!'));
    }
    if (preg_match($jpattern, $comment_data['comment_content'])) {
        err(__('原谅庭主吧，这货只听得懂岛国神片的一两句雅蠛蝶 Japanese Get out！日本语出て行け！ You should type some Chinese word！'));
    }
    return ($comment_data);
}
add_filter('preprocess_comment', 'refused_spam_comments');

// 屏蔽带链接评论
function Shield_link($comment_data) {
    $links = '/http:\/\/|https:\/\/|www\./u';
    if (preg_match($links, $comment_data['comment_author']) || preg_match($links, $comment_data['comment_content'])) {
        err(__('别啊，昵称和评论里面添加链接会怀孕的哟！！'));
    }
    return ($comment_data);
}
add_filter('preprocess_comment', 'Shield_link');

//禁止加载WP自带的jquery.js
if ( !is_admin() ) { // 后台不禁止
function my_init_method() {
wp_deregister_script( 'jquery' );  // 取消原有的 jquery 定义
}
add_action('init', 'my_init_method');
}
wp_deregister_script( 'l10n' );

// 去除library CSS
function remove_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'remove_block_library_css', 100 );

//侧边栏
function theme_scripts() {
	wp_enqueue_script( 'theme', get_template_directory_uri() . '/js/theme.js', array(), '', true ); 
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/sidebar.js', array(), '20220429', true );

    // CSS styles       
    wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '20220429' );   
	
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }    
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );
if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );   
}
add_filter( 'wp_lazy_loading_enabled', '__return_false' );
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

//禁止图片自动生成
function shapeSpace_disable_image_sizes($sizes) {
unset($sizes['thumbnail']); // disable thumbnail size
unset($sizes['medium']); // disable medium size
unset($sizes['large']); // disable large size
unset($sizes['medium_large']); // disable medium-large size
unset($sizes['1536×1536']); // disable 2x medium-large size
unset($sizes['2048×2048']); // disable 2x large size
return $sizes;
}
add_action('intermediate_image_sizes_advanced','shapeSpace_disable_image_sizes');
// 禁用缩放尺寸
add_filter('big_image_size_threshold', '__return_false');
// 禁用其他图片尺寸
function shapeSpace_disable_other_image_sizes() {
remove_image_size('post-thumbnail'); // disable images added via set_post_thumbnail_size()
remove_image_size('another-size'); // disable any other added image sizes
}
add_action('init', 'shapeSpace_disable_other_image_sizes');
//去除文章图片的serset属性
add_filter( 'max_srcset_image_width', create_function('', 'return 1;'));
//自动用文章标题为图片添加alt
function image_alttitle( $imgalttitle ){
        global $post;
        $imgtitle = $post->post_title;
        $imgUrl = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*>";
        if(preg_match_all("/$imgUrl/siU",$imgalttitle,$matches,PREG_SET_ORDER)){
                if( !empty($matches) ){
                        for ($i=0; $i < count($matches); $i++){
                                $tag = $url = $matches[$i][0];
                                $j=$i+1;
                                $judge = '/title=/';
                                preg_match($judge,$tag,$match,PREG_OFFSET_CAPTURE);
                                if( count($match) < 1 ) $altURL = 'alt="'.$imgtitle.' 第'.$j.'张" title="'.$imgtitle.' 第'.$j.'张" '; $url = rtrim($url,'>');
                                $url .= $altURL.'>';
                                $imgalttitle = str_replace($tag,$url,$imgalttitle);
                        }
                }
        }
        return $imgalttitle;
}
add_filter( 'the_content','image_alttitle');

//图片默认无连接
update_option('image_default_link_type', 'none');

//输出缩略图地址
function post_thumbnail_src(){
	global $post;
	if( $values = get_post_custom_values("thumb") ) {	//输出自定义域图片地址
		$values = get_post_custom_values("thumb");
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
	} else {
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(!empty($matches[1][0])){
			$post_thumbnail_src = $matches[1][0];   //获取该图片 src
		}else{	//如果日志中没有图片，则显示随机图片
			$random = mt_rand(1, 1);
			$post_thumbnail_src = get_template_directory_uri().'/images/thumbnail.png';
			//如果日志中没有图片，则显示默认图片
			//$post_thumbnail_src = get_template_directory_uri().'/images/thumbnail.png';
		}
	};
	echo $post_thumbnail_src;
}