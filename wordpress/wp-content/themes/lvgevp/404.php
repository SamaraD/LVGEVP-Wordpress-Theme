<?php
get_header();
$themeURL = get_template_directory_uri();
$cssFolderURL = $themeURL . '/css';
$jsFolderURL = $themeURL . '/js';
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
    <link rel="stylesheet" href="<?= $cssFolderURL; ?>/layout/page-achados.css">
    <link rel="stylesheet" href="<?= $cssFolderURL; ?>/components/page-achados.css">
    <script defer src="<?= $jsFolderURL; ?>/tag-customization.min.js"></script>
<!-- main-content -->
    <nav class="navbar has-shadow is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <div class="navbar-item">
                <h1 class="title is-4">A&P</h1>
            </div>
        </div>
    </nav>
    <section class="section has-background-light margin-bottom">
        <div class="container">
            <form action="" method="get">
                <div class="field">
                    <div class="field-label is-normal has-text-centered">
                        <label for="search-query-field" class="label">Pesquisa por itens</label>
                    </div>
                    <div class="field-body">
                        <div class="field has-addons has-centered-content">
                            <div class="control">
                                <input class="input search-query-field" type="text" name="search-query" id="search-query-field" placeholder="O que você procura?">
                            </div>
                            <div class="control">
                                <a class="button is-dark">
                                    Pesquisar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php
    $objectSearchQueryArgs = array(
        'post_type' => 'objects',
        'numberposts' => -1
    );

    if (isset($_GET['search-query'])) {
        $searchQueryTags = $_GET['search-query'];
        $searchQueryTags = mb_ereg_replace('/ /', ',', $searchQueryTags);
        $objectSearchQueryArgs['tag'] = $searchQueryTags;
    }

    $objectSearchQuery = new WP_Query($objectSearchQueryArgs);
    if ($objectSearchQuery->have_posts()) {
        $allObjects = [];
        $currentObjectTrio = [];
        while ($objectSearchQuery->have_posts()) {
            $objectSearchQuery->the_post();
            $objectData = [];
            $objectData['title'] = get_the_title();
            $objectData['ID'] = get_the_ID();
            $objectData['status'] = get_field('object_status');
            $objectData['tags'] = get_the_tags($objectData['ID']);
            $objectData['iso_reception_date'] = get_the_date('c');
            $objectData['reception_date'] = get_the_date();
            $objectData['thumbnail_url'] = get_the_post_thumbnail_url(
                $objectID,
                '16by9-thumb'
            );

            if ($objectData['status']['value'] === 'claimed') {
                $claimDateField = get_field('claim_date');
                $claimDateTime = DateTime::createFromFormat(
                    'd/m/Y',
                    $claimDateField
                );

                $objectData['iso_claim_date'] = $claimDateTime->format('c');

                $claimTimeStamp = $claimDateTime->getTimestamp();
                setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                date_default_timezone_set('America/Sao_Paulo');
                $formattedClaimDate = strftime(
                    '%d de %B de %Y',
                    $claimTimeStamp
                );

                $objectData['claim_date'] = utf8_encode(
                    $formattedClaimDate
                );

                $objectData['claimer_name'] = get_field('claimer_name');
                $objectData['claimer_identification'] = get_field(
                    'claimer_identification'
                );
            }

            if (count($currentObjectTrio) === 3) {
                array_push($allObjects, $currentObjectTrio);
                $currentObjectTrio = [];
            }

            array_push($currentObjectTrio, $objectData);
        }

        if (count($currentObjectTrio) !== 0) {
            array_push($allObjects, $currentObjectTrio);
        }

        unset($currentObjectTrio);
    }
    ?>
    <section class="object-list">
        <?php
        if (!empty($allObjects)):
        ?>
            <?php
            foreach ($allObjects as $objectTrio):
            ?>
                <div class="tile is-ancestor">
                    <?php
                    foreach ($objectTrio as $objectData):
                    ?>
                        <div class="tile is-parent">
                            <article class="tile is-child card object">
                                <div class="card-image">
                                    <figure class="image is-16by9">
                                        <img
                                            src="<?= $objectData['thumbnail_url']; ?>"
                                            alt="Foto do objeto <?= $objectData['ID']; ?>"
                                        >
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <div class="content tags object-info">
                                        <span class="tag is-medium is-white object-id">
                                            <?= $objectData['title']; ?>
                                        </span>
                                        <span
                                            class="tag is-normal object-status <?= $objectData['status']['value']; ?>"
                                        >
                                            <?= $objectData['status']['label']; ?>
                                        </span>
                                    </div>
                                    <?php
                                    if (!empty($objectData['tags'])):
                                    ?>
                                        <div class="field is-grouped is-grouped-multiline object-description">
                                            <?php
                                            foreach ($objectData['tags'] as $tag):
                                            ?>
                                                <div class="control">
                                                    <div class="tags">
                                                        <span
                                                            class="tag is-normal is-dark <?= $tag->slug; ?>"
                                                            title="<?= $tag->name; ?>"
                                                        >
                                                            <?= $tag->name; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="content">
                                        <p>
                                            Recebido na sede em
                                            <strong>
                                                <time datetime="<?= $objectData['iso_reception_date']; ?>">
                                                    <?= $objectData['reception_date']; ?>
                                                </time>
                                            </strong>
                                        </p>
                                        <?php
                                        if ($objectData['status']['value'] === 'claimed'):
                                        ?>
                                            <p>
                                                Reivindicado em
                                                <strong>
                                                    <time datetime="<?= $objectData['iso_claim_date']; ?>">
                                                        <?= $objectData['claim_date']; ?>
                                                    </time>
                                                </strong>
                                            </p>
                                            <p>
                                                Reivindicado por
                                                <strong>
                                                    <span>
                                                        <?= $objectData['claimer_name']; ?>
                                                    </span>
                                                    <span>
                                                        (<?= $objectData['claimer_identification']; ?>)
                                                    </span>
                                                </strong>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
<!-- main-content -->
<?php
get_footer();
?>