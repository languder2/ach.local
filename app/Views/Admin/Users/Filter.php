<form method="POST" action="<?=base_url("admin/users/set-filter")?>">
    <div class="box bg-white px-3 py-3">
        <div class="input-group my-2">
            <input
                    type="text"
                    name="filter[search]"
                    class="form-control"
                    placeholder="поиск"
                    aria-label="search"
                    value="<?=$filter->current->search??""?>"
            >

            <button class="btn btn-outline-secondary" type="submit">
                Найти
            </button>
        </div>

        <div class="container-fluid my-2">
            <div class="row">

                <div class="col-4 ps-0">
                    <label class="w-100">
                        <select name="filter[role]" class="form-select">
                            <option value="">роль</option>
                            <?php foreach ($filter->references->roles??[] as $code=>$value):?>
                                <option
                                    <?=(isset($filter->current->role) && $filter->current->role === $code)?"selected":""?>
                                    value="<?=$code?>"
                                >
                                    <?=$value?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </label>
                </div>

                <div class="col-4 ps-0">
                    <label class="w-100">
                        <select name="filter[verification]" class="form-select">
                            <option value="">верификация</option>
                            <?php foreach ($filter->references->verification??[] as $code=>$value):?>
                                <option
                                    <?=(isset($filter->current->verification) && $filter->current->verification === $code)?"selected":""?>
                                    value="<?=$code?>"
                                >
                                    <?=$value?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </label>
                </div>

                <div class="col-4 ps-0">
                    <label class="w-100">
                        <select name="filter[sdo]" class="form-select">
                            <option value="">аккаунт СДО</option>
                            <?php foreach ($filter->references->sdo??[] as $code=>$role):?>
                                <option
                                    <?=(isset($filter->current->sdo) && $filter->current->sdo === $code)?"selected":""?>
                                    value="<?=$code?>"
                                >
                                    <?=$role?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </label>
                </div>

            </div>
        </div>
    </div>
</form>

