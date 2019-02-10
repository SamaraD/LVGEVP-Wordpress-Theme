<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo wp_title(''); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        wp_head();
        $themeURL = get_template_directory_uri();
        $cssFolderURL = $themeURL . '/css';
        $jsFolderURL = $themeURL . '/js';
    ?>
    <link rel="stylesheet" href="<?php echo $cssFolderURL; ?>/reset.css">
    <script src="<?php echo $jsFolderURL; ?>/external/imagesloaded.js" defer></script>
    <script src="<?php echo $jsFolderURL; ?>/photo-gallery.js" defer></script>
</head>
<body>
