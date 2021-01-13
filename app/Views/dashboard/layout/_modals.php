<?php 
// Util functions
function addExtAttrs($elm) {
    $str = '';
    if (isset($elm['extattrs'])) {
        foreach ($elm['extattrs'] as $attr => $value) {
            $str .= $attr.'="'.$value.'" ';
        }
    }
    return $str;
}

function addAttr($elm, $attr, $depth=null, $default='') {
    if (isset($elm[$attr])) {
        $val = $elm[$attr];
        if ($depth !== null) {
            foreach (explode('.', $depth) as $d) {
                $val = $val[$d];
            }
        }
        return $attr.'="'. $val .'" ';
    }
    return $default;
}

function isRequired($elm) {
    return isset($elm['required']) && $elm['required']?'<b class="has-text-danger-dark">*</b>':'';
}

function isDisabled($elm) {
    return isset($elm['disabled']) && $elm['disabled']?'disabled ':'';
}

function addFillAttr($elm) {
    return isset($elm['fill'])?(' fill="'. $elm['fill'] .'" filltype="'. $elm['type'] .'" '):'';
}

// Components

function putText($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <input type="text" class="input" <?= addAttr($elm, 'name') ?> <?= addAttr($elm, 'placeholder') ?> 
            <?= addAttr($elm, 'value') ?> <?= addAttr($elm, 'id') ?> <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?>
               <?= addAttr($elm, 'onkeyup') ?> <?= addAttr($elm, 'disabled') ?> <?= addAttr($elm, 'readonly') ?> 
               <?= (isset($elm['required']) && $elm['required'])?'required':'' ?>>
    </div>
<?php
}

function putCalcBox($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <input type="text" class="input" readonly="true" <?= addAttr($elm, 'onchange') ?> 
            <?= addAttr($elm, 'value') ?> <?= addAttr($elm, 'id') ?> <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?>>
    </div>
<?php
}

function putPassword($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <input type="password" class="input" name="<?= $elm['name'] ?>" <?= addAttr($elm, 'id') ?> 
            <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'onkeyup') ?> <?= addAttr($elm, 'disabled') ?>
               <?= (isset($elm['required']) && $elm['required'])?'required':'' ?>>
    </div>
<?php
}

function putLabel($elm) { ?>
    <label class="label" <?= addAttr($elm, 'id') ?> <?= addFillAttr($elm) ?>><?= is_array($elm)? $elm['value']:$elm ?></label>
<?php
}

function putLabelLite($elm) { ?>
    <label <?= addAttr($elm, 'id') ?> <?= addFillAttr($elm) ?>><?= is_array($elm)? $elm['value']:$elm ?></label>
<?php
}

function putButton($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <a class=" button is-primary" onclick="<?= $elm['onclick'] ?>" <?= addExtAttrs($elm) ?>>
            <?= $elm['label'] ?>
        </a>
    </div>
<?php 
}

function putNumber($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <input type="number" step="0.01" class="input" <?= addAttr($elm, 'name') ?> <?= addAttr($elm, 'value') ?> <?= addAttr($elm, 'id') ?> 
                <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'onkeyup') ?> <?= addAttr($elm, 'disabled') ?>
               <?= addAttr($elm, 'onchange') ?> <?= (isset($elm['required']) && $elm['required'])?'required':'' ?> <?= addAttr($elm, 'readonly') ?>>
    </div>
<?php 
}

function putCheckBox($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="checkbox">
            <input type="checkbox" name="<?= $elm['name'] ?>" <?= isset($elm['value'])?$elm['value']:'' ?> onchange="setCheckBoxValue(this);<?= isset($elm['onchange'])?$elm['onchange']:'' ?>"
                   <?= addAttr($elm, 'id') ?> <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'disabled') ?>>
            <?= $elm['label'] ?>
        </label>
    </div>
<?php 
}

function putDate($elm, $modal_action) { ?>
    <div class="field" type="<?= $elm['type'] ?>" id="<?= $modal_action ?>-<?= $elm['name'] ?>-date">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <input type="date" class="input" name="<?= $elm['name'] ?>" <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'disabled') ?>
               <?= addAttr($elm, 'id') ?> <?= (isset($elm['filldate']) && !$elm['filldate'])?'filldate="false"':'' ?> <?= addAttr($elm, 'onchange') ?>
               <?= (isset($elm['required']) && $elm['required'])?'required':'' ?> <?= addAttr($elm, 'readonly') ?>>
     </div>
<?php 
}

function putDateTime($elm, $modal_action) { ?>
    <div class="field" type="<?= $elm['type'] ?>" id="<?= $modal_action ?>-<?= $elm['name'] ?>-date">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <input type="datetime-local" class="input" name="<?= $elm['name'] ?>" <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'disabled') ?>
               <?= addAttr($elm, 'id') ?> <?= (isset($elm['filldate']) && !$elm['filldate'])?'filldate="false"':'' ?> <?= addAttr($elm, 'onchange') ?>
               <?= (isset($elm['required']) && $elm['required'])?'required':'' ?> <?= addAttr($elm, 'readonly') ?>>
     </div>
<?php 
}

function putCoal($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <div class="columns mt-2">
            <div class="column is-6">
                <input type="number" step="0.01" class="input is-fullwidth" onchange="updateCoalValue(this);<?= isset($elm['onchange'])?$elm['onchange']:'' ?>" 
                       <?= addAttr($elm, 'value') ?> <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> <?= isset($elm['id'])?'id="'. $elm['id'] .'-input"':'' ?>
                       <?= addAttr($elm, 'onkeyup') ?> <?= addAttr($elm, 'disabled') ?> <?= (isset($elm['required']) && $elm['required'])?'required':'' ?>>
            </div>
            <div class="column is-3">
                <div class="select is-fullwidth">
                    <select onchange="updateCoalValue($(this).parents('div[class=field]').find('input[type=number]'));<?= isset($elm['onchange'])?$elm['onchange']:'' ?>" 
                            <?= isset($elm['id'])?'id="'. $elm['id'] .'-select"':'' ?> <?= addAttr($elm, 'disabled') ?>>
                        <option selected>Tons</option>
                        <option>Cft</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" class="is-hidden" name="<?= $elm['name'] ?>" <?= addAttr($elm, 'id') ?> <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> 
            <?= addAttr($elm, 'disabled') ?>>
    </div>
<?php 
}

function putSelect($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <div class="select">
            <select name="<?= $elm['name'] ?>" <?= addAttr($elm, 'id') ?> <?= addAttr($elm, 'onchange') ?> <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?>
                    <?= addAttr($elm, 'disabled') ?>>
                <?php if (isset($elm['value'])): ?>
                    <?php foreach ($elm['value'] as $val): ?>
                        <option <?= (isset($elm['selected']) && $elm['selected'] === $val)?'selected':'' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                <?php endif;?>
            </select>
        </div>
    </div>
<?php 
}

function putTextarea($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <textarea class="textarea" name="<?= $elm['name'] ?>" <?= addAttr($elm, 'placeholder') ?> <?= addAttr($elm, 'id') ?>
                  <?= addFillAttr($elm) ?> <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'disabled') ?>></textarea>
    </div>
<?php 
}

function putAddress($elm) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <?php if(isset($elm['address_name'])) {?>
        <label class="label">Address<?= isRequired($elm) ?></label>
        <input type="text" class="input" name="<?= $elm['address_name'] ?>" 
               fill="<?= isset($elm['fill']['address'])?$elm['fill']['address']:'' ?>" <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'disabled') ?>>
        <?php } ?>
        <div class="columns mt-2">
            <div class="column is-6">
                <label class="label">Country<?= isRequired($elm) ?></label>
                <div class="select is-fullwidth">
                    <select name="<?= $elm['country_name'] ?>" onclick="fillCountry(this)" onkeydown="fillCountry(this)" type="country" 
                        fill="<?= isset($elm['fill']['country'])?$elm['fill']['country']:'' ?>" <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'disabled') ?>>
                    </select>
                </div>
            </div>
            <div class="column is-6">
                <label class="label">State<?= isRequired($elm) ?></label>
                <div class="select is-fullwidth">
                    <select name="<?= $elm['state_name'] ?>" type="state" onclick="fillstates(this)" onkeydown="fillstates(this)" 
                            fill="<?= isset($elm['fill']['state'])?$elm['fill']['state']:'' ?>" <?= addExtAttrs($elm) ?> <?= addAttr($elm, 'disabled') ?>>
                    </select>
                </div>
            </div>
        </div>
        <label class="label">City<?= isRequired($elm) ?></label>
        <input type="text" class="input" name="<?= $elm['city_name'] ?>" fill="<?= isset($elm['fill']['city'])?$elm['fill']['city']:'' ?>" <?= addExtAttrs($elm) ?>
               <?= addAttr($elm, 'disabled') ?>>
        <label class="label">Area Pin<?= isRequired($elm) ?></label>
        <input type="text" class="input" name="<?= $elm['pin_name'] ?>" fill="<?= isset($elm['fill']['pin'])?$elm['fill']['pin']:'' ?>" <?= addExtAttrs($elm) ?>
               <?= addAttr($elm, 'disabled') ?>>
    </div>
<?php 
}

function putVariableSelect($elm, $modal_action) { ?>
    <div class="field" type="<?= $elm['type'] ?>">   
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <div class="dropdown" id="select-<?= $modal_action ?>_<?= explode('.', $elm['name'])[0] ?>">
            <div class="dropdown-trigger">
                <input type="text" class="input" aria-haspopup="true" aria-controls="dropdown-menu" tmp="true" model="<?= $elm['model'] ?>" 
                       field="<?= $elm['field'] ?>" posturl="<?= $elm['url'] ?>" onkeyup="showTopResults(this)"
                       <?= addAttr($elm, 'placeholder') ?> fill="<?= isset($elm['fill']['input'])?$elm['fill']['input']:'' ?>" <?= addExtAttrs($elm) ?>
                       <?= isset($elm['id'])?'id="'. $elm['id'] .'-input"':'' ?> <?= addAttr($elm, 'disabled') ?> <?= (isset($elm['required']) && $elm['required'])?'required':'' ?>
                       customevt="<?= isset($elm['customevt']) ? $elm['customevt'].'($(\'#'.$modal_action.'_modal\'))' : '' ?>" <?= addAttr($elm, 'readonly') ?>>
                <input type="hidden" class="is-hidden" <?= (isset($elm['createable']) && $elm['createable'])?'model="'. $elm['model'] .'"':'' ?>  
                       name="<?= $elm['name'] ?>" fill="<?= isset($elm['fill']['hidden'])?$elm['fill']['hidden']:'' ?>" <?= addExtAttrs($elm) ?>
                       <?= addAttr($elm, 'id') ?> <?= addAttr($elm, 'disabled') ?>>
            </div>
            <div class="dropdown-menu" role="menu">
                <div class="dropdown-content">
                </div>
            </div>
            <script> makeDropdownReady('select-<?= $modal_action ?>_<?= explode('.', $elm['name'])[0] ?>', '<?= $elm['model'] ?>'); </script>
        </div>
    </div>
<?php 
}

function putFileUpload($elm,$modal_action) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?><?= isRequired($elm) ?></label>
        <div class="file has-name is-right is-fullwidth">
            <label class="file-label">
                <input class="file-input" type="file" name="<?= $elm['name'] ?>" tourl="<?= $elm['url'] ?>"
                       accept="image/*" onchange="updateFileName(this);">
                <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Choose cover
                    </span>
                </span>
                <span class="file-name">
                    No file selected
                </span>
            </label>
        </div>
    </div>
<?php 
}

function putTable($elm,$modal_action) { ?>
    <div class="field" type="<?= $elm['type'] ?>">
        <label class="label"><?= $elm['label'] ?></label>
        <a class="mb-2 button is-success is-small" 
           onclick="addRowKeyValue('<?= $modal_action ?>_<?= $elm['name'] ?>_table_modal', '<?= 
        isset($elm['keytype'])?$elm['keytype']:'text' ?>', '<?= isset($elm['valuetype'])?$elm['valuetype']:'text' ?>')">
            <i class="mr-2 fas fa-plus"></i> Add</a>
        <table class="table is-bordered is-striped is-fullwidth" onfocusout="updateTableJson(this);<?= isset($elm['onchange'])?$elm['onchange']:'' ?>" 
               fill="<?= isset($elm['fill']['table'])?$elm['fill']['table']:'' ?>" <?= addExtAttrs($elm) ?>>
            <thead>
                <tr>
                <?php foreach ($elm['th'] as $val): ?>
                    <th><?= $val ?></th>
                <?php endforeach; ?>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="<?= $modal_action ?>_<?= $elm['name'] ?>_table_modal" 
                   <?= addAttr($elm, 'keytype', null, 'text') ?> <?= addAttr($elm, 'valuetype', null, 'text') ?>>
            </tbody>
        </table>
        <input type="hidden" class="is-hidden" name="<?= $elm['name'] ?>" valuetype="json" <?= addAttr($elm, 'id') ?> 
               value="{}" fill="<?= isset($elm['fill']['hidden'])?$elm['fill']['hidden']:'' ?>" <?= addExtAttrs($elm) ?>>
    </div>
<?php 
}

function putDetail($label, $value) { ?>
    <div class=" details-key"><?= $label ?></div>
    <?php if ($value['type'] === 'json') { ?>
            <details class="details-full has-background-light" fill="<?= $value['field'] ?>" filltype="<?= $value['type'] ?>">
                <summary class="no-select has-text-weight-bold" style="cursor: pointer;"><?= $label ?></summary>
            </details>
    <?php } else { ?>
            <div class=" details-value" fill="<?= $value['field'] ?>" filltype="<?= $value['type'] ?>"><i>NA</i></div>
    <?php } ?>
<?php 
}

function putSubInfo($head, $conts) { ?>
    <label class="label details-full"><?= $head ?></label>
    <details class="details-full has-background-light">
        <?php
        foreach ($conts as $label => $value) {
            if ($label === 'head') { ?>
            <summary class="no-select has-text-weight-bold" style="cursor: pointer;" 
                 fill="<?= $value['field'] ?>" filltype="<?= $value['type'] ?>"><i>NA</i></summary>
        <div class=" details-layout">
        <?php
            } elseif (isset($value['head'])) {
                putSubInfo($label, $value);
            } else {
                putDetail($label, $value);
            }
        } ?>
        </div>
    </details>
<?php
}

function putInfo($conts) { ?>
    <div class=" details-layout">
    <?php
    foreach ($conts as $label => $value) {
        if(isset($value['head'])) {
            putSubInfo($label, $value);
        } else {
            putDetail($label, $value);
        }
    }
    ?>
    </div>
<?php
}

function modal_producer($modal, $page_action, $modal_title, $modal_action, $modal_action_button, $modal_close_button, $model_name, $modal_elms = []) { ?>
<div id="<?= $modal_action ?>_modal" class="modal">
    <script>
        $(window).on('load', function () {
            if(<?= ($page_action === $modal_action)?'true':'false'?>) {
                emptyCreateModal();
                $('#<?= $modal_action ?>_modal').addClass('is-active');
            }
        });
    </script>
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title"><?= $modal_title ?></p>
            <button class="delete" aria-label="close"></button>
        </header>
        <section class="has-background-danger-light has-text-weight-medium px-2">
            <label name="message" id="<?= $modal_action ?>_message">
                
            </label>
        </section>
        <section class="modal-card-body">
            <form id="<?= $modal_action ?>-form" model="<?= $model_name ?>">
                <?php 
                if ($modal_action === 'details') {
                    putInfo($modal_elms);
                } elseif ($modal_action === 'attendance') {
                    ?><div class="details-layout" id="<?= $modal['putareaid'] ?>"></div><?php
                } else {
                    foreach ($modal_elms as $elm) {
                        switch ($elm['type']) {
                            case 'text':
                                putText($elm);
                                break;
                            case 'number':
                                putNumber($elm);
                                break;
                            case 'calc':
                                putCalcBox($elm);
                                break;
                            case 'label':
                                putLabel($elm);
                                break;
                            case 'pass':
                                putPassword($elm);
                                break;
                            case 'button':
                                putButton($elm);
                                break;
                            case 'check':
                                putCheckBox($elm);
                                break;
                            case 'textarea':
                                putTextarea($elm);
                                break;
                            case 'coal':
                                putCoal($elm);
                                break;
                            case 'sel':
                                putSelect($elm);
                                break;
                            case 'address':
                                putAddress($elm);
                                break;
                            case 'date':
                                putDate($elm, $modal_action);
                                break;
                            case 'datetime':
                                putDateTime($elm, $modal_action);
                                break;
                            case 'varsel':
                                putVariableSelect($elm, $modal_action);
                                break;
                            case 'file':
                                putFileUpload($elm, $modal_action);
                                break;
                            case 'table':
                                putTable($elm, $modal_action);
                        }
                    }
                } ?>
            </form>
        </section>
        <footer class="modal-card-foot">
            <?php if ($modal_action_button !== null):?>
            <button class="button is-success" id="<?= $modal_action ?>_submit_modal" onclick="<?= $modal_action ?>Entry($('#<?= $modal_action ?>_modal'), $('#<?= $modal_action ?>-form'))"><?= $modal_action_button ?></button>
            <?php endif; ?>
            <button class="button" aria-label="close"><?= $modal_close_button !== null?$modal_close_button:'Close'?></button>
        </footer>
    </div>
</div>
<?php } ?>
