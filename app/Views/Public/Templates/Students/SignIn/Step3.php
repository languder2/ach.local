<form method="POST" action="<?=route_to("Users::ssiProcessingS3")?>">
    <input type="hidden" name="email" value="<?=$user->email??0?>">
    <h4 class="
                text-center border-bottom border-1 pb-3
    ">
        Регистрация в системе дистанционного обучения
    </h4>
    <?php if(isset($message)):?>
        <div class="callout-wrapper">
            <div class="callout callout-error mx-.75">
                <?=$message?>
            </div>
        </div>

    <?php endif;?>


    <?php if(isset($faculties)):?>
        <label class="s-select-box">
            <select name="form[faculty]" data-ds="faculty" class="form-select" required>
                <option selected disabled value=''>Факультет</option>
                <?php foreach ($faculties as $item):?>
                    <option
                        value               ="<?=$item->id?>"
                    >
                        <?=$item->name?>
                    </option>
                <?php endforeach;?>
            </select>
        </label>
    <?php endif;?>

    <?php if(isset($departments)):?>
    <label class="s-select-box">
        <select name="form[department]" data-ds="department" class="form-select" required>
            <option selected disabled value=''>Кафедра</option>
            <?php foreach ($departments as $item):?>
                <option
                        data-faculty        ="<?=$item->faculty?>"
                        value               ="<?=$item->id?>"
                >
                    <?=$item->name?>
                </option>
            <?php endforeach;?>
        </select>
    </label>
    <?php endif;?>

    <?php if(isset($levels)):?>
    <label class="s-select-box">
        <select name="form[level]" data-ds="level" class="form-select" required>
            <option selected disabled value=''>Уровень</option>
            <?php foreach ($levels as $item):?>
                <option
                        value               ="<?=$item->id?>"
                >
                    <?=$item->name?>
                </option>
            <?php endforeach;?>
        </select>
    </label>
    <?php endif;?>

    <?php if(isset($specialities)):?>
    <label class="s-select-box">
        <select name="form[speciality]" data-ds="speciality" class="form-select" required>
            <option selected disabled value=''>Специальность</option>
            <?php foreach ($specialities as $item):?>
                <option
                        data-faculty        ="<?=$item->faculty?>"
                        data-level          ="<?=$item->level?>"
                        value               ="<?=$item->id?>"
                >
                    <?=$item->code?>
                    <?=$item->name?>
                </option>
            <?php endforeach;?>
        </select>
    </label>
    <?php endif;?>



    <div class="s-input-box">
        <input
                type="number"
                name="form[course]"
                min="1"
                max="5"
                id="ssiCourse"
                class="form-control"
                placeholder=""
                value="<?=$form->course??""?>"
                required
        >
        <label for="ssiCourse">
            Курс
        </label>
    </div>
    <div class="s-input-box">
        <input
                type="text"
                name="form[grp]"
                id="ssiGrp"
                class="form-control"
                placeholder=""
                value="<?=$form->grp??""?>"
                required
        >
        <label for="ssiGrp">
            Группа
        </label>
    </div>

    <div class="s-input-box text-center">
        <button class="d-inline-block btn-main w-50">
            далее
        </button>
    </div>
</form>
