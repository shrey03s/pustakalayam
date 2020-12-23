<?php helper('html') ?>
<?= $this->extend('login/layout') ?>
<?= $this->section('content') ?>
<h1 class="title has-text-centered has-text-dark"><?=lang('Auth.loginTitle')?></h1>
<form action="<?= route_to('login') ?>" method="post">
<?= csrf_field() ?>
    <?php if ($config->validFields === ['email']): ?>
        <div class="field">
            <label class="label"><?=lang('Auth.email')?></label>
            <input type="email" class="input <?php if(session('errors.login')) : ?>is-danger<?php endif ?>"
                name="login" placeholder="<?=lang('Auth.email')?>">
            <div class="help is-danger">
                <?= session('errors.login') ?>
            </div>
        </div>
    <?php else: ?>
        <div class="field">
            <label class="label"><?=lang('Auth.emailOrUsername')?></label>
            <input type="text" class="input <?php if(session('errors.login')) : ?>is-danger<?php endif ?>"
                name="login" placeholder="<?=lang('Auth.emailOrUsername')?>">
            <div class="help is-danger">
                <?= session('errors.login') ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="field">
        <label class="label"><?=lang('Auth.password')?></label>
            <input type="password" name="password" class="input  <?php if(session('errors.password')) : ?>is-danger<?php endif ?>" placeholder="<?=lang('Auth.password')?>">
            <div class="help is-danger">
                <?= session('errors.password') ?>
            </div>
    </div>

    <?php if ($config->allowRemembering): ?>
    <div class="field">
        <div class="form-check">
            <label class=" checkbox">
                <input type="checkbox" name="remember" <?php if(old('remember')) : ?> checked <?php endif ?>>
                <?=lang('Auth.rememberMe')?>
            </label>
        </div>
    </div>
    <?php endif; ?>

    <div class=" field">
        <button type="submit" class="button is-primary"><?=lang('Auth.loginAction')?></button>
    </div>
</form>
<?= $this->endSection() ?>