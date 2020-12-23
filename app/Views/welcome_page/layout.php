<html>
    <head>
        <meta charset="UTF-8">
        <title>Pustakalayam Website</title>
        <meta name="description" content="The small framework with powerful features">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= link_tag(base_url("/favicon.ico"), 'shortcut icon', 'image/ico') ?>
        <?= link_tag(base_url("/assets/css/bulma.min.css")) ?>
        <?= link_tag(base_url("/assets/css/welcome_page/style.css")) ?>
    </head>
    <body>
        <header>
            <?= $this->renderSection('header') ?>
        </header>
        <?= $this->renderSection('content') ?>
        <footer>
            <?= $this->renderSection('footer') ?>
        </footer>        
        <?= script_tag(base_url("/assets/js/jquery.min.js")) ?>
        <?= script_tag(base_url("/assets/js/welcome_page/main.js")) ?>
        <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    </body>
</html>
