<?php
function draw_bar($val, $sec) { ?>
    <script>
        prepareBarArea($('#<?= $sec ?>'), '<?= $val['data']['api'] ?>', 
            '<?= $val['title'] ?>', JSON.parse('<?= json_encode($val['data']['show']) ?>'), 
            <?= isset($val['expand']) && $val['expand'] ? 'true' : 'false' ?>);
    </script>
<?php
}

function draw_graph($val) { ?>
    <div class="<?= isset($val['expand']) && $val['expand'] ? 'flow-full' : 'flow-child' ?>">
        <div class="card">
            <div class="card-content" id="<?= $val['id'] ?>">
                <div class="has-text-centered"><label class="subtitle has-text-weight-bold has-text-link-dark"><?= $val['title'] ?></label></div>
                <hr>
                <nav>
                    <div class="select is-small-mobile">
                        <select name="timeperiod">
                            <option>Week</option>
                            <option selected>Month</option>
                            <option>Year</option>
                        </select>
                    </div>
                </nav>
                <canvas name="canvas" class="is-fullwidth"></canvas>
                <script>
                    var elm = $('#<?= $val['id'] ?>');
                    prepareChartArea(elm.find('[name=canvas]'), elm.find('[name=timeperiod]'), JSON.parse('<?= json_encode($val['data']) ?>'));
                </script>
            </div>
        </div>
    </div>
<?php
}

function draw_table($val) { ?>
    <div class="<?= isset($val['expand']) && $val['expand'] ? 'flow-full' : 'flow-child' ?>">
        <div class="card">
            <div class="card-content" id="<?= $val['id'] ?>">
                <div class="has-text-centered"><label class="subtitle has-text-weight-bold has-text-link-dark"><?= $val['title'] ?></label></div>
                <hr>
                <div style=" overflow-x: auto;">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <thead class="table-head" name="thead">
                            <?php foreach ($val['thead'] as $v): ?>
                                <th><?= $v ?></th>
                            <?php endforeach; ?>
                        </thead>
                        <tbody name="tbody">

                        </tbody>
                    </table>
                </div>
                <script>
                    var elm = $('#<?= $val['id'] ?>');
                    prepareTableArea(elm.find('[name=tbody]'), '<?= $val['api'] ?>', '<?= $val['model'] ?>',
                            JSON.parse('<?= json_encode($val['filters']) ?>'),
                            JSON.parse('<?= json_encode($val['fields']) ?>'));
                </script>
            </div>
        </div>
    </div>
<?php
}


function draw_assets($val, $sec) { ?>
    <script>
        prepareAssetsArea($('#<?= $sec ?>'), <?= isset($val['expand']) && $val['expand'] ? 'true' : 'false' ?>);
    </script>
<?php
}

function stat_producer($value) { 
    if(isset($value['title'])) {
    ?>
    <div class="is-fullwidth has-text-centered mt-5"><label class="title has-text-weight-medium"><?= $value['title'] ?></label></div>
    <hr style="width: 70%; margin-left: 15%">
    <?php } ?>
    <div name="section" id="<?= $value['id'] ?>_section" class="flow-layout">
    <?php 
    foreach ($value as $val) {
        if(!is_array($val)) {
            continue;
        }
        
        switch ($val['type']) {
            case "bar":
                draw_bar($val, $value['id']."_section");
                break;
            case "graph":
                draw_graph($val);
                break;
            case "table":
                draw_table($val);
                break;
            case "assets":
                draw_assets($val, $value['id']."_section");
                break;
        }
    }
    ?> </div> <?php
}
