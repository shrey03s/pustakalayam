<?php helper('html') ?>
<?= $this->extend('welcome_page/layout') ?>

<?= $this->section('header') ?>
<?= $this->include('welcome_page/_navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('welcome_page/_hero') ?>
<section class="section">
    <div class="columns has-text-centered">
        <div id="books-display" class='flow-layout'>
            
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('welcome_page/_footer') ?>
<?= $this->endSection() ?>