<div class="formBlock bg-white py-3 rounded-4 ">
    <h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
        Запись на фотосессию 21.11.2024
    </h5>
    <form
        method      = "POST"
        action      = "<?= base_url("event/signup")?>"
        class       = "px-4 pt-2"
    >

        <div class="s-input-box">
            <input
                    type="text"
                    name="form[username]"
                    id="ssiName"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->name??""?>"
                    required
            >
            <label for="ssiName">
                Имя
            </label>
        </div>

        <div class="s-input-box">
            <input
                    type="text"
                    name="form[surname]"
                    id="ssiSurname"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->surname??""?>"
                    required
            >
            <label for="ssiSurname">
               Фамилия
            </label>
        </div>

        <div class="s-input-box">
            <input
                    type="tel"
                    name="form[phone]"
                    id="ssiPhone"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->phone??""?>"
                    required
            >
            <label for="ssiPhone">
                Телефон
            </label>
        </div>


        <?php if(isset($faculties)):?>
            <label class="s-select-box">
                <select name="form[faculty]" data-ds="faculty" class="form-select" required>
                    <option selected disabled value=''>
                        Факультет
                    </option>
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

        <?php if(isset($specialities)):?>
            <label class="s-select-box">
                <select name="form[speciality]" data-ds="speciality" class="form-select" required>
                    <option selected disabled value=''>
                        Специальность
                    </option>
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

        <div class="s-input-box text-center">
            <button class="d-inline-block btn-main w-50">
                далее
            </button>
        </div>
    </form>
</div>