<form method="POST" action="<?=base_url("admin/users/set-filter")?>">
    <div class="box bg-white px-3 py-3">
        <div class="input-group">
            <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="поиск"
                    aria-label="search"
                    value="<?=$filter->search??""?>"
            >

            <button class="btn btn-outline-secondary" type="submit">
                Найти
            </button>
        </div>
    </div>
</form>