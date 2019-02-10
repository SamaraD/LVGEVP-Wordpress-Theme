<?php /* Template Name: Página de Achados e Perdidos */ ?>
<?php
    get_header();
    $themeURL = get_template_directory_uri();
    $imgFolderURL = $themeURL . '/img';
    $iconsSpriteURL = $imgFolderURL . '/open-iconic/sprite/sprite.svg';
    $cssFolderURL = $themeURL . '/css';
    $jsFolderURL = $themeURL . '/js';
?>
    <link rel="stylesheet" href="<?php echo $cssFolderURL; ?>/components/widgets-theme.css">
    <link rel="stylesheet" href="<?php echo $cssFolderURL; ?>/layout/achados.css">
<!-- main-content -->
    <main>
        <section class="search-container">
            <div class="content">
                <form method="get" class="search-form">
                    <div class="form-row">
                        <input type="text" name="search" class="full-width">
                    </div>
                    <div class="form-row">
                        <label>
                            <input type="checkbox" name="show-delivered" value="true">
                            <span>
                                Mostrar itens indisponíveis
                            </span>
                        </label>
                    </div>
                    <div class="form-row submit-row">
                        <input type="submit" value="Pesquisar" class="submit-btn">
                    </div>
                </form>
            </div>
        </section>
        <div class="main-container root-container">
            <?php
                $postSearchQueryArgs = array(
                    'post_type' => 'objects'
                );
                $postSearchQuery = new WP_Query($postSearchQueryArgs);
                if ($postSearchQuery->have_posts()):
            ?>
                <?php
                    while ($postSearchQuery->have_posts()):
                        $postSearchQuery->the_post();
                ?>
                    <article class="item">
                        <header>
                            <span class="item-id">
                                <span class="container">
                                    <?php
                                        $postId = get_the_ID();
                                        echo $postId;
                                    ?>
                                </span>
                            </span>
                        </header>
                        <section class="item-content">
                            <section class="gallery-container">
                                <div class="content-display">
                                    <button class="left-gallery-btn">
                                        <svg class="icon">
                                            <use
                                                href="<?php echo $iconsSpriteURL; ?>#chevron-left"
                                            >
                                            </use>
                                        </svg>
                                    </button>
                                    <div class="photo-view">
                                        <div class="photo-view-container">
                                            <?php
                                                $attachedMedia = get_attached_media('image');
                                                foreach ($attachedMedia as $mediaObject):
                                                    $mediaID = $mediaObject->ID;
                                                    // wp_get_attachment_image_src() returns an
                                                    // array: [url, width, height, is_intermediate]
                                                    $thumbnailURL = wp_get_attachment_image_src(
                                                        $mediaID,
                                                        'optimized-thumbnail'
                                                    )[0];

                                                    $mediaURL = wp_get_attachment_image_src(
                                                        $mediaID,
                                                        'full'
                                                    )[0];
                                            ?>
                                                <div class="photo-container">
                                                    <img
                                                        alt="Foto do item <?php echo $postId; ?>"
                                                        src="<?php echo $thumbnailURL; ?>"
                                                        data-full-image-url="<?php echo $mediaURL; ?>"
                                                    >
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <button class="right-gallery-btn">
                                        <svg class="icon">
                                            <use
                                                href="<?php echo $iconsSpriteURL; ?>#chevron-right"
                                            >
                                            </use>
                                        </svg>
                                    </button>
                                </div>
                                <div class="display-information">
                                    <svg class="icon">
                                        <use
                                            href="<?php echo $iconsSpriteURL; ?>#camera-slr"
                                        >
                                        </use>
                                    </svg>
                                    <div class="content">
                                    </div>
                                </div>
                            </section>
                            <section class="item-info">
                                <time pubdate="pubdate">
                                    <?php
                                        $postDate = get_the_date('c');
                                        echo $postDate;
                                    ?>
                                </time>
                            </section>
                        </section>
                    </article>
                <?php endwhile;?>
            <?php endif;?>
        </div>
    </main>
<!-- main-content -->
<div id="full-image-show-container">
    <button>
        <svg class="icon">
            <use
                href="<?php echo $iconsSpriteURL; ?>#zoom-out"
            >
            </use>
        </svg>
    </button>
    <div class="content">
    </div>
</div>
<?php
    get_footer();
?>