<?php helper(['html', 'auth', 'cookie']) ?>

<?= $this->include('dashboard/layout/_modals') ?>
<?= $this->include('dashboard/libraries/_recordutils') ?>
<?= $this->extend('dashboard/layout/layout') ?>

<?= $this->section('header') ?>
<?= $this->include('dashboard/layout/_navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('sidenav') ?>
<?= $this->include('dashboard/layout/_sidenav') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="container">
        <h1 class="title">Bulk Attendance</h1>
        <hr>
        <?= $this->include('dashboard/bulk/parts/_sec_bar') ?>
        <progress id="progress-top" class="progress is-small is-primary top-progress" max="100"></progress>
        <div style=" overflow-x: auto;">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead class="table-head">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Reason</th>
                        <th>Present</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody id="main-tbody">
                    
                </tbody>
            </table>
        </div>
        <br>
        <div class="pagination" role="navigation" aria-label="pagination">
            <a class="pagination-previous" onclick="previousPage()">Previous</a>
            <a class="pagination-next" onclick="nextPage()">Next page</a>
            <ul id="main-paginate" class="pagination-list">

            </ul>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('dashboard/layout/_footer') ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('preload') ?>
<?php if (isset($page->reqdata) && $page->reqdata): ?>
<?= script_tag(base_url("/assets/data/country-states.js")) ?>
<?php endif; ?>
<?= script_tag(base_url("/assets/js/dashboard/preload.js")) ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php 

?>
<script>
    var canDelete = <?= has_permission('app.delete.entry')? 'true': 'false' ?>;
    var canEdit = <?= has_permission('app.edit.entry')? 'true': 'false' ?>;
    
    var tableattrs = {
        orderby: 'id',
        order: 'ASC',
        searchfields: ['id', 'name'],
        model: '',
        getentries: '/api/bulkattendance',
        entrycount: '/api/bulkattendancecount'
    };
    
    enable_item_sidenav('#sidenav-attendancebulk', '#sidenav-sub-attendance');
</script>
<?= script_tag(base_url("/assets/js/dashboard/bulk.js")) ?>
<?= script_tag(base_url("/assets/js/dashboard/tableloader.js")) ?>
<?= $this->endSection() ?>