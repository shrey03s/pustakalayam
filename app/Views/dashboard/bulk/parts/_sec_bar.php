<div class="columns is-fullwidth">
    <div class="column">
        <div class="field has-addons">
            <div class="my-1 control is-expanded">
                <input class="input  is-small-mobile" type="search" placeholder="Search" id="searchbox" autofocus="autofocus">
            </div>
            <div class="my-1 control">
                <button class="button is-small-mobile is-link search-button-icon" id="searchbtn">Search</button>
            </div>
        </div>
    </div>
    <div class="column">
        <div class="level">
            <div class="level-left">
                <div id="perpage" class="mx-1 my-1 select is-small-mobile">
                    <select>
                        <option disabled>Item Per Page:</option>
                        <option val="10" <?= (get_cookie('item_per_page') == 10) ? 'selected' : '' ?>>10</option>
                        <option val="15" <?= (get_cookie('item_per_page') == 15) ? 'selected' : '' ?>>15</option>
                        <option val="20" <?= (get_cookie('item_per_page') == 20) ? 'selected' : '' ?>>20</option>
                        <option val="25" <?= (get_cookie('item_per_page') == 25) ? 'selected' : '' ?>>25</option>
                        <option val="50" <?= (get_cookie('item_per_page') == 50) ? 'selected' : '' ?>>50</option>
                    </select>
                </div>

                <div id="orderby" class="mx-1 my-1 select is-small-mobile">
                    <select>
                        <option disabled>Order by:</option>
                        <option val="id" selected>Id</option>
                        <option val="name">Name</option>
                    </select>
                </div>

                <div id="order" class="mx-1 my-1 select is-small-mobile">
                    <select>
                        <option disabled>Order:</option>
                        <option val="ASC" selected>Ascending</option>
                        <option val="DESC">Descending</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<details>
    <summary class="no-select summary">Search Filters</summary>   
    
    <button class="button is-togglable is-small mb-1 is-active" val="id" name="filter">Id</button>
    <button class="button is-togglable is-small mb-1 is-active" val="name" name="filter">Name</button>
    
</details>
<input id="main-date" class="input" type="date" onchange="dateChanged()">
<script>document.getElementById('main-date').valueAsDate = new Date();</script>
<div class="py-2">
    <label class="subtitle" id="result_count"></label>
</div>
