<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-transform"/>
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<meta name="applicable-device" content="pc,mobile"/>
<meta name="renderer" content="webkit"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,user-scalable=no">
<?php if(get_option('favicon')){?><link rel="shortcut icon" href="<?php echo get_option('favicon'); ?>" type="image/x-icon" /><?php }?>
<title><?php if (is_home() ) {?><?php if(get_option('title')){echo get_option('title');}else{?><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?><?php }?><?php if ( $paged < 2 ) {} else { echo (' - 第'); echo ($paged);echo ('页');}?><?php } else {?><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); ?><?php if ( $paged < 2 ) {} else { echo (' - 第'); echo ($paged);echo ('页');}?><?php } 
?></title><?php if (is_home()){
	$description = (get_settings("description"));
	$keywords = (get_settings("keyword"));
} elseif (is_single()){
    if ($post->post_excerpt) {$description = $post->post_excerpt;} 
	 else {$description = substr(strip_tags($post->post_content),0,240);}
    $keywords = "";
    $tags = wp_get_post_tags($post->ID);
    foreach ($tags as $tag ) {
        $keywords = $keywords . $tag->name . ", ";
    }
} elseif (is_category()){
	$description = strip_tags(category_description());
	$categoryname = get_the_category();
	$keywords = $categoryname[0]->cat_name;
} elseif (is_tag()){
	$description = trim(strip_tags(tag_description($tag_ID)));

	$keywords = single_tag_title('', false);
} elseif (is_page()){
	$description = mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 140,"...");
	$keywords = $post->post_title;
}
?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/html5shiv.v3.72.min.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<?php wp_head(); ?>
<?php if(get_option('bg')){?><style>body{background:#fafafa url(<?php echo get_option('bg'); ?>);}</style><?php }?>
</head>
<body>
<header id="header">
	<div class="inner">
			<?php if( !is_home() ) echo '<div id="logo">'; else echo '<h1 id="logo">'; ?><a title="<?php bloginfo('name'); ?>" href="<?php bloginfo('url'); ?>"><img src="<?php if(get_option('logo')){echo get_option('logo');}else{?><?php bloginfo('template_url'); ?>/images/logo.png<?php }?>"></a><?php if( !is_home() ) echo '</div>'; else echo '</h1>'; ?>
				<div id="topBtn">
            <div id="navBtn">
                <i></i>
            </div>
        </div>
		<div id="search">
			<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
				<div class="input">
					<input type="text" name="s" class="text" value="" placeholder="搜索..." x-webkit-speech=""/>
					<input type="submit" name="submit" class="submit" value=""/>
				</div>
			</form>
		</div>
		<nav id="nav" class="menu-menu-container"><?php inkthemes_nav();?></nav>		
        <div class="clear"></div>
	</div>
</header>
<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>