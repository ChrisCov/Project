<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php if (isset($title)) echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Demo app" />

        <?php
        foreach ($script as $key => $value)
        {
            echo HTML::script($value);
            echo "\r\n";
        }

        foreach ($style as $key => $value)
        {
            echo HTML::style($value);
            echo "\r\n";
        }
        ?>

        <!--[if lt IE 9]>
        <script src="/assets/js/html5.js"></script>
        <script src="/assets/js/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript">

            jQuery(document).ready(function() {
                jQuery.fn.cookiesFN();
            });

        </script>

    </head>
    <body>
        <div id="container">
            <div id="content">
                <?php if (isset($content)) echo $content ?>
            </div>
            <div id="stats">
                <?php if (isset($stats)) echo $stats ?>
            </div>
        </div>
    </body>
</html>