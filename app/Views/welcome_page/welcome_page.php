<?php helper('html') ?>
<?= $this->extend('welcome_page/layout') ?>

<?= $this->section('header') ?>
<?= $this->include('welcome_page/_navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('welcome_page/_hero') ?>
<section class="section">
    <h1 class="has-text-centered title">Services we provide!</h1>
    <div class="columns has-text-centered">
        <div class="column is-one-third">
            <?= img(['src' => base_url('/assets/img/background.webp'), 'class' => 'circle-image']) ?>
            <br>
            <label>Extract of Coal</label>
        </div>
        <div class="column is-one-third">
            <?= img(['src' => base_url('/assets/img/background.webp'), 'class' => 'circle-image']) ?>
            <br>
            <label>Processing of Coal</label>
        </div>
        <div class="column is-one-third">
            <?= img(['src' => base_url('/assets/img/background.webp'), 'class' => 'circle-image']) ?>
            <br>
            <label>Renting of vehicle and tools</label>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('welcome_page/_footer') ?>
<?= $this->endSection() ?>