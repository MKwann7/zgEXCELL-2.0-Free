<?php



?>
<head>
    <title><?php echo $objCard->card_name; ?></title>

    <meta charset="utf-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="author" content="<?php echo $app->objCustomPlatform->getPublicName(); ?>" />
    <meta name="description" content="Digital Business Card" />
    <meta property="og:title" content="<?php echo $objCard->card_name; ?>" />
    <meta property="og:site_name" content="<?php echo $app->objCustomPlatform->getPublicName(); ?>" />
    <meta property="og:image" content="<?php echo $objCard->favicon; ?>" />
    <meta data-rh="true" property="thumbnail" content="<?php echo $objCard->banner; ?>" />
    <meta data-rh="true" property="og:image" content="<?php echo $objCard->banner; ?>" />
    <meta data-rh="true" property="og:image:height" content="400" />
    <meta data-rh="true" property="og:image:width" content="400" />
    <meta data-rh="true" property="twitter:image" content="<?php echo $objCard->banner; ?>" />
    <link rel="icon" type="image/png" href="<?php echo $objCard->favicon; ?>"/>
    <link rel="apple-touch-icon" href="<?php echo $objCard->favicon; ?>">

    <meta name="google-site-verification" content="" />
    <meta name="Copyright" content="EZ Digital, LLC" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?php echo $objCard->favicon_ico; ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $objCard->favicon_image; ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="/default/css/default.css" />
    <link rel="stylesheet" href="/_ez/templates/3/css/template.min.css?card_id=<?php echo $objCard->card_id; ?>" />
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/_ez/templates/3/js/template.min.js?card_id=<?php echo $objCard->card_id; ?>"></script>
</head>
<body class="theme_shade_light handed-left">
<div class="app-wrapper">
    <div class="app-wrapper-inner">
        <div id="app-vue" class="app-card">
        </div>
    </div>
</div>

<script type="text/javascript">
    let vueApp = new Vue({
        el: '#app',
    });

    document.addEventListener("DOMContentLoaded", function() {
        const widget = new WidgetLoader(
            "122160fe-9981-4d3d-8218-fabdd279713a",
            vueApp,
            document.getElementById("app-vue"),
            null,
            {cardId: '<?php echo $objCard->sys_row_id; ?>', public: true}
        );

        widget.runMain("view");
    });
</script>
</body>
</html>