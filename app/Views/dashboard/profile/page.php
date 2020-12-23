<?php helper(['html','auth']) ?>
<?= $this->extend('dashboard/layout/layout') ?>

<?= $this->section('header') ?>
<?= $this->include('dashboard/layout/_navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('sidenav') ?>
<?= $this->include('dashboard/layout/_sidenav') ?>
<?= $this->endSection() ?>

<?php 
function getUserGroup() {
    foreach (['owner', 'manager', 'worker'] as $value) {
        if (in_groups($value)) {
            return $value;
        }
    }
}
?>

<?= $this->section('content') ?>
<form>
    <section class="section">
        <div class="container">
            <div class="field">
                <h1 class="title">
                    <i class="fas fa-user-circle"></i><span class="px-2"><?= user()->username ?></span>
                </h1>
                <label class="label">User ID: <?= user_id() ?></label>
                <hr>
            </div>
            
            <div class="field">
                <label class="label">Email:</label>
                <label><?= user()->email ?></label>
            </div>
            
            <div class="field">
                <label class="label">Account type:</label>
                <div class="control">
                    <label><?= getUserGroup() ?></label>
                </div>
            </div>
            
            <div class="field">
                <a class="button is-success" id="change_password_btn" >Change Password</a>
            </div>
        </div>
    </section>
</form>
<?= $this->include('dashboard/profile/parts/_change_pass_modal') ?>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('dashboard/layout/_footer') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script> enable_item_sidenav('#sidenav-profile', ''); </script>
<?= script_tag(base_url("/assets/js/dashboard/profile.js")) ?>
<?= $this->endSection() ?>