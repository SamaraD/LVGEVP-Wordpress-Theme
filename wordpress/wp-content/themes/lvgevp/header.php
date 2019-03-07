<!DOCTYPE html>
<html lang="pt-br" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= wp_title(''); ?></title>
    <?php
        wp_head();
        $themeURL = get_template_directory_uri();
        $cssFolderURL = $themeURL . '/css';
        $jsFolderURL = $themeURL . '/js';
    ?>
    <link rel="stylesheet" href="<?= $cssFolderURL; ?>/reset.css">
    <link rel="stylesheet" href="<?= $cssFolderURL; ?>/components/links.css">
</head>
<body>
