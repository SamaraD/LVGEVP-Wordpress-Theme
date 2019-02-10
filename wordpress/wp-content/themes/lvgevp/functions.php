<?php
    function addCustomImageSizes()
    {
        add_image_size('optimized-thumbnail', 256, 144);
    }

    function createCustomPostType()
    {
        $uppercasePlural = 'Objetos';
        $uppercaseSingular = 'Objeto';
        $lowercasePlural = 'objetos';
        $lowercaseSingular = 'objeto';

        $postTypeLabels = array(
            'name' => $uppercasePlural,
            'singular_name' => $uppercaseSingular,
            'add_new' => 'Registrar novo',
            'add_new_item' => 'Registrar novo ' . $lowercaseSingular,
            'edit_item' => 'Editar ' . $lowercaseSingular,
            'new_item' => 'Novo ' . $lowercaseSingular,
            'view_item' => 'Visualizar ' . $lowercaseSingular,
            'view_items' => 'Visualizar ' . $lowercasePlural,
            'search_items' => 'Pesquisar ' . $lowercasePlural,
            'not_found' => 'Nenhum ' . $lowercaseSingular . ' encontrado',
            'not_found_in_trash' => 'Nenhum ' . $lowercaseSingular . ' encontrado na lixeira',
            'parent_item_colon' => $uppercaseSingular . ' ao qual está relacionado',
            'all_items' => 'Todos os ' . $lowercasePlural,
            'archives' => 'Arquivos de ' . $lowercasePlural,
            'attributes' => 'Atributos do ' . $lowercaseSingular,
            'insert_into_item' => 'Inserir no ' . $lowercaseSingular,
            'uploaded_to_this_item' => 'Carregado para esse ' . $lowercaseSingular,
            'featured_image' => 'Imagem relacionada',
            'set_featured_image' => 'Definir imagem relacionada',
            'remove_featured_image' => 'Remover imagem relacionada',
            'use_featured_image' => 'Usar como imagem relacionada',
            'menu_name' => 'Achados e Perdidos',
            'filter_items_list' => 'Filtrar lista de ' . $lowercasePlural,
            'items_list_navigation' => 'Lista de ' . $lowercasePlural,
            'items_list' => 'Lista de ' . $lowercasePlural,
            'item_published' => $uppercaseSingular . ' publicado',
            'item_published_privately' => $uppercaseSingular . ' publicado (privado)',
            'item_reverted_to_draft' => $uppercaseSingular . ' marcado como rascunho',
            'item_scheduled' => 'Publicação de ' . $lowercaseSingular . ' agendada',
            'item_updated' => $uppercaseSingular . ' atualizado'
        );

        $postTypeFeatures = array(
            'author',
            'editor'
        );

        $postTypeCreationArgs = array(
            'label' => 'Objetos',
            'description' => 'Objetos no achados e perdidos',
            'labels' => $postTypeLabels,
            'supports' => $postTypeFeatures,
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-tag',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'taxonomies' => array('post_tag')
        );

        register_post_type(
            'objects',
            $postTypeCreationArgs
        );
    }

    function addSufixToPageTitles(string $title)
    {
        $newTitle = $title . ' - GEVP';

        if (empty($title)) {
            $newTitle = 'GEVP';
        }

        if (is_home() || is_front_page()) {
            $newTitle = 'Início - GEVP';
        }

        return $newTitle;
    }

    add_action('init', 'addCustomImageSizes');
    add_action('init', 'createCustomPostType');

    add_filter('wp_title', 'addSufixToPageTitles');
