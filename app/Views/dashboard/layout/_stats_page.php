<?php helper(['html', 'auth', 'cookie']) ?>

<?= $this->include('dashboard/layout/_stats') ?>
<?= $this->extend('dashboard/layout/layout') ?>

<?= $this->section('header') ?>
<?= $this->include('dashboard/layout/_navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('sidenav') ?>
<?= $this->include('dashboard/layout/_sidenav') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section is-fullwidth" id="main-section">
    <div class="container is-fullwidth">
        <h1 class="title"><?= $page->statstitle ?></h1>
        <hr>
        <?php foreach ($page->stats as $value) {
            stat_producer($value);
        } ?>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('dashboard/layout/_footer') ?>
<?= $this->endSection() ?>

<?= $this->section('preload') ?>
<?= script_tag(base_url("/assets/js/Chart.bundle.min.js")) ?>
<?= script_tag(base_url("/assets/js/dashboard/statstools.js")) ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    enable_item_sidenav('#sidenav-<?= $page->pageclass ?>-stats', '#sidenav-sub-<?= $page->pagesection ?>');
</script>
<?= $this->endSection() ?>