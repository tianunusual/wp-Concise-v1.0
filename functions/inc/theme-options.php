<?php
add_action('init', 'of_options');
if (!function_exists('of_options')) {
    function of_options() {
        // VARIABLES
        $themename = wp_get_theme();
        $themename = $themename['Name'];
        $shortname = "of";
        // Populate OptionsFramework option in array for use in theme
        global $of_options;
        $of_options = get_option('of_options');
        $file_rename = array("开启" => "开启", "关闭" => "关闭");
        //Stylesheet Reader

        // Test data

        // Multicheck Array

        // Multicheck Defaults

        // Background Defaults

        // Pull all the categories into an array
        $options_categories = array();
        $options_categories_obj = get_categories();
		$options_categories[''] = 'Select a categorie:';
        foreach ($options_categories_obj as $category) {
            $options_categories[$category->cat_ID] = $category->cat_name;
        }
        // Pull all the pages into an array
        $options_pages = array();
        $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
        $options_pages[''] = '';
        foreach ($options_pages_obj as $page) {
            $options_pages[$page->ID] = $page->post_title;
        }
        // If using image radio buttons, define a directory path
        $imagepath = get_bloginfo('stylesheet_directory') . '/images/';
        $options = array();
//****=============================================================================****//
//****-----------This code is used for creating color SEO description--------------****//							
//****=============================================================================****//						
        $options[] = array(
			"name" => "SEO设置",
			"e_name" => "SEOOptions",
            "type" => "heading");
        $options[] = array("name" => "首页标题",
            "desc" => "",
            "id" => "title",
            "std" => "",
            "type" => "text");
        $options[] = array("name" => "关 键 字",
            "desc" => "Meta关键字为搜索引擎提供帮助，快速定位您的网站。这仅适用于您的主页。关键字限制最大80个字符",
            "id" => "keyword",
            "std" => "",
            "type" => "text");
        $options[] = array("name" => "Meta描述",
            "desc" =>"您应该使用meta网站描述，向搜索引擎提供网站的介绍信息。这仅适用于您的首页.Optimal的搜索引擎，搜索引擎最优长度，大约200个字符",
            "id" => "description",
            "std" => "",
            "type" => "textarea");
        $options[] = array("name" => "底部版权",
            "desc" => "在这里输入底部版权信息，支持HTML",
            "id" => "copyright",
            "std" => "",
            "type" => "textarea");
       $options[] = array("name" => "备案号和统计代码",
            "desc" => "粘贴你的谷歌分析(或其他)统计跟踪代码在这里。",
            "id" => "analytics",
            "std" => "",
            "type" => "textarea");

//****=============================================================================****//
//****-----------This code is used for creating 常规选项--------------****//							
//****=============================================================================****//	
        $options[] = array(
			"name" => "常规选项",
			"e_name" => "GeneralSettings",
            "type" => "heading");	
        $options[] = array("name" => "自定义背景图",
            "desc" => "指定一个1600*294像素的图像，作为你的顶部背景图。",
            "id" => "bg",
            "type" => "upload");
        $options[] = array("name" => "ICO 图标",
            "desc" => "指定一个16像素x16像素的图像，将代表您的网站的favicon，图像格式为png。",
            "id" => "favicon",
            "type" => "upload");
			
        $options[] = array("name" => "顶部LOGO",
            "desc" => "指定一个126像素x36像素的图像，将代表您的网站的LOGO，图像格式为png。",
            "id" => "logo",
            "type" => "upload");
        $options[] = array("name" => "底部LOGO",
            "desc" => "指定一个63像素x63像素的图像，将代表您的网站的LOGO，图像格式为png。",
            "id" => "mlogo",
            "type" => "upload");
//****=============================================================================****//
//****=============================================================================****//
//****-----------This code is used for creating color styleshteet options----------****//							
//****=============================================================================****//			
        update_option('of_template', $options);
        update_option('of_themename', $themename);
        update_option('of_shortname', $shortname);
    }

}
?>