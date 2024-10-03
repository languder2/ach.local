<?php if(isset($user)):?>
    <h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
        Учебные данные
    </h5>
        <?php foreach ($user->students as $key=>$student):?>
            <div class="px-4 px-md-5 border-bottom border-1">
                <div class="row">
                    <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                        Факультет:
                    </div>
                    <div class="col-12 col-sm-8 mb-3">
                        <?php echo $student->faculty?>
                    </div>

                    <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                        Кафедра:
                    </div>
                    <div class="col-12 col-sm-8 mb-3">
                        <?php echo $student->department?>
                    </div>

                    <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                        Уровень:
                    </div>
                    <div class="col-12 col-sm-8 mb-3">
                        <?php echo $student->level?>
                    </div>

                    <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                        Специальность:
                    </div>
                    <div class="col-12 col-sm-8 mb-3">
                        <?php echo $student->speciality?>
                    </div>

                    <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                        Курс:
                    </div>
                    <div class="col-12 col-sm-8 mb-3">
                        <?php echo $student->course?>
                    </div>

                    <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                        Группа:
                    </div>
                    <div class="col-12 col-sm-8 mb-3">
                        <?php echo $student->grp?>
                    </div>


                    <?php if(!empty($student->years_from) || !empty($student->years_to) ):?>
                        <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                            Годы обучения:
                        </div>
                        <div class="col-12 col-sm-8 mb-3">
                            <?php if(!empty($student->years_from)):?>
                                с <?=$student->years_from?>
                            <?php endif;?>
                            <?php if(!empty($student->years_to)):?>
                                до <?=$student->years_to?>
                            <?php endif;?>
                        </div>
                    <?php endif;?>


                    <p class="text-center text-md-end mb-3">
                        <a href="<?=base_url("account/change-education/$student->id")?>" class="link text-decoration-underline d-inline-block">
                            Изменить учебные данные
                        </a>
                    </p>
                </div>
            </div>

        <?php endforeach;?>

        <p class="
                text-center
                mt-4
            ">
            <a
                    href="<?=base_url("account/add-education")?>"
                    class="btn-main d-inline-block"
            >
                Добавить учебные данные
            </a>
        </p>
<?php endif;?>