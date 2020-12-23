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
        <h1 class="title"><?= $page->tabletitle ?></h1>
        <hr>
        <?= $this->include('dashboard/layout/_sec_bar') ?>
        <progress id="progress-top" class="progress is-small is-primary top-progress" max="100"></progress>
        <div style=" overflow-x: auto;">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead class="table-head">
                    <tr>
                    <?php foreach ($page->tablefields as $k => $v): ?> 
                        <th><?= $k ?></th>
                    <?php endforeach; ?>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tfoot id="main-tfoot">
                    
                </tfoot>
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

<?php foreach ($page->modals as $key => $value) {
//    if ($key == 'filter') {
//        continue;
//    }
    if (isset($value['import'])) {
        ?>
        <?= $this->include($value['import']); ?>
        <?php
    } else {
        modal_producer($value, $action, $value['title'], $key,
        isset($value['action_button'])?$value['action_button']:null,
                isset($value['close_button'])?$value['close_button']:null, $page->model,$value['elms']);
    }
}
?>

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
<script>
    var canDelete = <?= has_permission('app.delete.entry')? 'true': 'false' ?>;
    
    var tableattrs = {
        fields: JSON.parse('<?= json_encode(array_values($page->tablefields)) ?>'),
        orderby: '<?= getOrderBy($page) ?>',
        order: '<?= $page->order ?>',
        searchfields: JSON.parse('<?= json_encode(array_values($page->searchfields)) ?>'),
        model: '<?= $page->model ?>',
        getentries: '<?= $page->getentries ?>',
        entrycount: '<?= $page->entrycount ?>',
        putentry: '<?= $page->putentry ?>',
        deleteentry: '<?= $page->deleteentry ?>'
    };
    
    enable_item_sidenav('#sidenav-<?= $page->pageclass ?>', '#sidenav-sub-<?= $page->pagesection ?>');
</script>
<?= script_tag(base_url("/assets/js/dashboard/recordslib.js")) ?>
<?= script_tag(base_url("/assets/js/dashboard/common_modals.js")) ?>
<?= script_tag(base_url("/assets/js/dashboard/tableloader.js")) ?>
<?= $this->endSection() ?>