<?php

/**
 *
 */
class Simple_List_Posts
{
    function __construct()
    {
        add_action('init', array($this, 'imovel_post_type'), 11);
        add_action('admin_menu', array($this, 'simple_list_posts_menu'), 10);
        add_action('admin_enqueue_scripts', array($this, 'register_plugin_styles'), 10);
        add_action('add_meta_boxes', array($this, 'add_custom_meta_box'), 10);
        add_action('save_post', array($this, 'save_imoveis_meta'));
    }

    public function simple_list_posts_menu()
    {
        add_options_page('Listagem de posts', 'Simple List Posts', 'manage_options', 'simple-list-posts', array($this, 'my_plugin_options'));
    }

    public function register_plugin_styles()
    {
        $screen = get_current_screen();
        if ($screen->base == "settings_page_simple-list-posts") {
            wp_register_style('bootstrap', plugins_url() . '/simple-list-posts/static/css/bootstrap.min.css');
            wp_enqueue_style('bootstrap');
            wp_register_style('simple-list-posts-css', plugins_url() . '/simple-list-posts/static/css/simple-list-post.css');
            wp_enqueue_style('simple-list-posts-css');
        }
    }

    public function my_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('Sem permissões para acessar esta página.'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['procurar']) && $_POST['procurar'] != null) {
                $args = $_POST['procurar'];
            }
        }

        $args = array('post_type' => 'post', 's' => $args);

        $the_query = new WP_Query($args);
        require_once(dirname(__FILE__) . "/../View/simple-list-post-config-page.php");

    }

    public function imovel_post_type()
    {

        $labels = array(
            'name' => _x('Imóveis', 'Post Type General Name', 'text_domain'),
            'singular_name' => _x('Imóvel', 'Post Type Singular Name', 'text_domain'),
            'menu_name' => __('Imóveis', 'text_domain'),
            'name_admin_bar' => __('Imóveis', 'text_domain'),
            'archives' => __('Item Archives', 'text_domain'),
            'attributes' => __('Item Attributes', 'text_domain'),
            'parent_item_colon' => __('Parent Item:', 'text_domain'),
            'all_items' => __('Todos imóveis', 'text_domain'),
            'add_new_item' => __('Adicionar novo imóvel', 'text_domain'),
            'add_new' => __('Adicionar Imóvel', 'text_domain'),
            'new_item' => __('Novo Item', 'text_domain'),
            'edit_item' => __('Editar Item', 'text_domain'),
            'update_item' => __('Atualizar Item', 'text_domain'),
            'view_item' => __('Visualizar Item', 'text_domain'),
            'view_items' => __('Ver Itens', 'text_domain'),
            'search_items' => __('Procurar Item', 'text_domain'),
            'not_found' => __('Não encontrado', 'text_domain'),
            'not_found_in_trash' => __('Não encontrado na lixeira', 'text_domain'),
            'featured_image' => __('Imagem destacada', 'text_domain'),
            'set_featured_image' => __('Definir imagem destacada', 'text_domain'),
            'remove_featured_image' => __('Remover imagem destacada', 'text_domain'),
            'use_featured_image' => __('Usar como imagem destacada', 'text_domain'),
            'insert_into_item' => __('Inserir item', 'text_domain'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
            'items_list' => __('Items list', 'text_domain'),
            'items_list_navigation' => __('Items list navigation', 'text_domain'),
            'filter_items_list' => __('Filter items list', 'text_domain'),
        );
        $args = array(
            'label' => __('Imóvel', 'text_domain'),
            'description' => __('Todos imóveis', 'text_domain'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'post-formats',),
            'taxonomies' => array('category'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-admin-home',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'show_in_rest' => true,
        );
        register_post_type('imovel', $args);

    }

    public function add_custom_meta_box()
    {
        add_meta_box("description", "Dados do imóvel", array($this, 'imoveis_metabox_callback'), "imovel", null, 'high');
    }

    public function imoveis_metabox_callback($post)
    {
        wp_nonce_field('imoveis_metabox_nonce', 'imoveis_nonce');

        $cep = get_post_meta($post->ID, 'cep', true);
        $valor = get_post_meta($post->ID, 'valor', true);
        ?>


        <label for="cep">CEP:</label>
        <input type="text" name="cep" id="cep">
        <br>
        <label for="valor">Valor:</label>
        <input type="number" name="valor" id="valor">

        <?php
    }

    public function save_imoveis_meta($post_id)
    {

        if (!isset($_POST['imoveis_nonce']) || !wp_verify_nonce($_POST['imoveis_nonce'], 'imoveis_metabox_nonce'))
            return;

        if (!current_user_can('edit_post', $post_id))
            return;

        if (isset($_POST['cep'])) {
            update_post_meta($post_id, 'keycep', sanitize_text_field($_POST['cep']));
        }

        if (isset($_POST['valor'])) {
            update_post_meta($post_id, 'keyvalor', sanitize_text_field($_POST['valor']));
        }
    }
}