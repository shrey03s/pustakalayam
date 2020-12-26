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
            <div class="flow-child">
                <div class="card mx-3">
                    <div class="card-image my-1" >
                      <figure class="image">
                          <img src="/assets/img/ml.jpg" alt="Placeholder image" style="width:100%;height: 256px">
                      </figure>
                    </div>
                    <div class="card-content">
                      <div class="media">
                        <div class="media-content">
                          <p class="title is-4">O'reilley</p>
                          <p class="subtitle is-6">@orielly</p>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="flow-child">
                <div class="card mx-3">
                    <div class="card-image my-1">
                      <figure class="image">
                          <img src="/assets/img/arthashastra.png" alt="Placeholder image" style="width:100%;height: 256px">
                      </figure>
                    </div>
                    <div class="card-content">
                      <div class="media"> 
                        <div class="media-content">
                          <p class="title is-4">R Samastry</p>
                          <p class="subtitle is-6">@rsamstry</p>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="flow-child">
                <div class="card mx-3">
                    <div class="card-image my-1">
                      <figure class="image">
                          <img src="/assets/img/arthashastra.png" alt="Placeholder image" style="width:100%;height: 256px">
                      </figure>
                    </div>
                    <div class="card-content">
                      <div class="media"> 
                        <div class="media-content">
                          <p class="title is-4">R Samastry</p>
                          <p class="subtitle is-6">@rsamstry</p>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('welcome_page/_footer') ?>
<?= $this->endSection() ?>