<?php if (session()->has('message')) : ?>
	<div class="navbar is-warning">
            <div class="navbar-brand">
                <span class="navbar-item">
                    <?= session('message') ?>
                </span>
            </div>
	</div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
	<div class="navbar is-danger">
            <div class="navbar-brand">
                <span class="navbar-item">
		<?= session('error') ?>
                </span>
            </div>
	</div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
	<ul class="navbar is-danger">
	<?php foreach (session('errors') as $error) : ?>
            <div class="navbar-brand">
                <span class="navbar-item">
                    <li><?= $error ?></li>
                </span>
            </div>
	<?php endforeach ?>
	</ul>
<?php endif ?>
