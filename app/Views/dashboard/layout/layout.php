<html>
    <head>
        <meta charset="UTF-8">
        <title>Pustakalayam Website</title>
        <meta name="description" content="The small framework with powerful features">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= link_tag(base_url("/favicon.ico"), 'shortcut icon', 'image/ico'); ?>
        <?= link_tag(base_url("/assets/css/bulma.min.css")) ?>
        <?= link_tag(base_url("/assets/css/dashboard/style.css")) ?>
        <?= $this->renderSection('styles') ?>
        <?= script_tag(base_url("/assets/js/jquery.min.js")) ?>
        <?= $this->renderSection('preload') ?>
    </head>
    <body>
        <header>
            <?= $this->renderSection('header') ?>
        </header>  
        <?= $this->renderSection('sidenav') ?>
        <div id="main" class="mainarea">
            <?= $this->renderSection('content') ?>
            <footer>
                <?= $this->renderSection('footer') ?>
            </footer>
        </div>        
        <script> hasDeletePermission = <?= (has_permission('app.delete.entry') ? 'true' : 'false') ?> </script>
        <?= script_tag(base_url("/assets/js/dashboard/main.js")) ?>
        <?= $this->renderSection('scripts') ?>
        <script defer src="/assets/fontawesome/js/all.js"></script>
    </body>
</html>
