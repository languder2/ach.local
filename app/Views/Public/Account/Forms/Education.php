<div class="mw-md-50rem mx-auto bg-white py-3 rounded-4 mb-4 shadow-box-st">
    <h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
        Учебные данные
    </h5>
    <form
            method="POST"
            action="<?= base_url("account/save-education")?>"
            class="px-4 pt-2"
    >
        <input type="hidden" name="sid"  value="<?=$student->id??null?>">

        <?php if(isset($faculties)):?>
            <label class="s-select-box">
                <select name="form[faculty]" data-ds="faculty" class="form-select" required>
                    <option selected disabled value=''>Факультет</option>
                    <?php foreach ($faculties as $item):?>
                        <option
                                value               ="<?=$item->id?>"
                            <?=(!empty($student) && $student->faculty === $item->id)?"selected":""?>
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
                                data-faculty        = "<?=$item->faculty?>"
                                value               = "<?=$item->id?>"
                                <?php if(
                                        !empty($student)
                                        && $item->faculty !== $student->faculty
                                        && !is_null($student->faculty)):
                                ?>
                                    class           = "ds-hidden-faculty"
                                    disabled
                                <?php endif;?>
                                <?=(!empty($student) && $student->department === $item->id)?"selected":""?>
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
                                <?=(!empty($student) && $student->level === $item->id)?"selected":""?>
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
                                <?=(!empty($student) && $student->speciality === $item->id)?"selected":""?>
                                class="
                                    <?php if(
                                            !empty($student)
                                            && $item->faculty !== $student->faculty
                                            && !is_null($student->faculty)):
                                    ?>
                                        ds-hidden-faculty
                                    <?php endif;?>
                                    <?php if(
                                            !empty($student)
                                            && $item->level !== $student->level
                                            && !is_null($student->level)):
                                    ?>
                                        ds-hidden-level
                                    <?php endif;?>
                                "

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
                    value="<?=$student->course??""?>"
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
                    value="<?=$student->grp??""?>"
                    required
            >
            <label for="ssiGrp">
                Группа
            </label>
        </div>

        <div class="s-input-box">
            <input
                    type="number"
                    name="form[grp]"
                    id="ssiGrp"
                    class="form-control"
                    min="1900"
                    max="2099"
                    step="1"
                    placeholder=""
                    value="<?=$student->grp??""?>"
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
</div>