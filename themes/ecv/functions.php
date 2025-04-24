<?php

function ecv_setup_theme_features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menu('header', 'En-tête du menu');
}

function montheme_register_assets()
{
    wp_register_style('style', get_stylesheet_directory_uri() . '/assets/css/style.css');
    wp_register_script('main', get_stylesheet_directory_uri() . '/assets/js/main.js');
    wp_enqueue_script('main');
    wp_enqueue_style('style');
    if( is_front_page() ) { 
        wp_enqueue_script('main');
        wp_enqueue_style('style');
    }
}

function montheme_title_separator()
{
    return '|';
}

function montheme_document_title_parts($title)
{
    unset($title['tagline']);
    return $title;
}


function montheme_types()
{
    register_post_type('magasins', [
        'label' => 'Magasins',
        'public' => true,
        'supports' => ['title', 'thumbnail'],
        'show_in_rest' => true,
        'has_archive' => true,
    ]);
}


add_action('init', 'ecv_setup_theme_features');

add_action('init', 'montheme_types');

add_action('wp_enqueue_scripts', 'montheme_register_assets');

add_action('after_setup_theme', 'ecv_setup_theme_features');

add_filter('document_title_separator', 'montheme_title_separator');

add_filter('document_title_parts', 'montheme_document_title_parts');
;




function montheme_register_rubrique() {
    register_taxonomy('rubrique', array('apparel', 'sneakers'), [
        'labels' => [
            'name' => 'rubrique',
            'singular_name'     => 'rubrique',
            'plural_name'       => 'rubriques',
            'search_items'      => 'Rechercher des rubriques',
            'all_items'         => 'Tous les rubriques',
            'edit_item'         => 'Editer la rubrique',
            'update_item'       => 'Mettre à jour la rubrique',
            'add_new_item'      => 'Ajouter une nouvelle rubrique',
            'new_item_name'     => 'Ajouter une nouvelle rubrique',
            'menu_name'         => 'rubrique',
        ],
        'show_in_rest' => true,
        'hierarchical' => true,
        'show_admin_column' => true,
    ]);
}
add_action('init', 'montheme_register_rubrique');

function search_sneakers($template)
{
    global $wp_query;
    $post_type = get_query_var('post_type');
    if ($wp_query->is_search && $post_type == 'sneakers') {
        return locate_template('index.php');
    }
    return $template;
}
add_filter('template_include', 'search_sneakers');




