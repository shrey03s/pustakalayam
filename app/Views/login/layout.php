<html>
    <head>
        <meta charset="UTF-8">
        <title>Mining Website</title>
        <meta name="description" content="The small framework with powerful features">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= link_tag(base_url("/favicon.ico"), 'shortcut icon', 'image/ico'); ?>
        <?= link_tag(base_url("/assets/css/bulma.min.css")) ?>
        <?= link_tag(base_url("/assets/css/login/style.css")) ?>
    </head>
    <body>
        <?= view('login/_message_block') ?>
        <div class="centerall has-background-black"
        style="background: url('<?= base_url('/assets/img/background.webp') ?>') no-repeat center center; background-size: cover;">
            <div class="px-6 py-6 box">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <script src="/assets/js/jquery.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    </body>
</html>
