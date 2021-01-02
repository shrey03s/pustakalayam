<div class="field has-addons">
    <div class="my-1 control is-expanded">
        <input class="input  is-small-mobile" type="search" placeholder="Search" id="searchbox" autofocus="autofocus">
    </div>
    <div class="my-1 control">
        <button class="button is-small-mobile is-link search-button-icon" id="searchbtn">Search</button>
    </div>
</div>
<div class="level my-1">
    <div class="level-left">
        <div id="orderby" class="select is-small-mobile mr-3 mb-2">
            <select>
                <option disabled>Order by:</option>
            <?php foreach ($page->orderfields as $key => $value): ?>
                <option val="<?= $value['field'] ?>" <?= in_array('selected', $value)?'selected':'' ?>><?= $key ?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div id="order" class="select is-small-mobile mr-3 mb-2">
            <select>
                <option disabled>Order:</option>
                <option val="ASC" <?= isset($page->order) && ($page->order === 'ASC' || $page->order !== 'DESC')?'selected':'' ?> >Ascending</option>
                <option val="DESC" <?= isset($page->order) && $page->order === 'DESC'?'selected':'' ?> >Descending</option>
            </select>
        </div>

        <div id="perpage" class="select is-small-mobile mr-3 mb-2">
            <select>
                <option disabled>Count:</option>
                <option val="10" <?= (get_cookie('item_per_page') == 10) ? 'selected' : '' ?>>10</option>
                <option val="15" <?= (get_cookie('item_per_page') == 15) ? 'selected' : '' ?>>15</option>
                <option val="20" <?= (get_cookie('item_per_page') == 20) ? 'selected' : '' ?>>20</option>
                <option val="25" <?= (get_cookie('item_per_page') == 25) ? 'selected' : '' ?>>25</option>
                <option val="50" <?= (get_cookie('item_per_page') == 50) ? 'selected' : '' ?>>50</option>
            </select>
        </div>

        <?php if(isset($page->modals['filter'])) { ?>
        <div class="field has-addons  mr-3 mb-2">
            <p class="control">
                <button class="button is-small-mobile is-info" onclick="showFilterModal()">
                <span>Filter</span>
              </button>
            </p>
            <p class="control">
                <button id="filter_clean" class="button is-small-mobile is-light" onclick="cleanFilter()">
                    <span class="icon is-small">
                      <a class="delete"></a>
                    </span>
                </button>
            </p>
        </div>
        <?php }?>
    </div>
    
    <div class="level-right">
        <?php if(!isset($page->showexportcsv) || $page->showexportcsv == true) { ?>
        <!--<a class="button is-small-mobile is-fullwidth is-info mb-2 ml-3-non-mobile" onclick="exportCSV()">Export CSV</a>-->
        <?php }?>
        <?php if(isset($page->modals['create'])) { ?>
        <a class="button is-small-mobile is-fullwidth is-success mb-2 ml-3-non-mobile" onclick="showCreateModal()">Add books &plus;</a>
        <?php }?>
    </div>
</div>
<details open>
    <summary class="no-select summary">Search Filters</summary>
    
<?php foreach ($page->searchfields as $key => $value): ?>
    <button class="button is-togglable is-small mb-1" val="<?= $value ?>" name="filter"><?= $key ?></button>
<?php endforeach; ?>
    
    <br class="my-4">
    <?php if (isDateFilterNeeded($page)): ?>
        <div class="field has-addons">
            <p class="control">
                <input type="date" id="fromdate" class="input is-small">
            </p>
            <p class="control">
                <label class="label mx-3">To</label>
            </p>
            <p class="control">
                <input type="date" id="todate" class="input is-small">
            </p>
        </div>
    <?php endif; ?>
</details>
<div class="py-2">
    <label class="subtitle" id="result_count"></label>
</div>
