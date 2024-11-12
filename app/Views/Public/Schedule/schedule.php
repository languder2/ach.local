<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание</title>
</head>
<body>
<div class="MainRasp">
<h1>Расписание</h1>
<div class="filters">
    <!--<label for="faculty">Факультет:</label>-->
    <div class="select-wrapper">
    <select id="faculty" name="faculty">
        <option value="">Все факультеты</option>
        <?php foreach ($faculties as $faculty): ?>
            <option value="<?=$faculty ?>"><?= $faculty ?></option>
        <?php endforeach; ?>
    </select>
       <!-- <span class="select-label fac">Все факультеты</span>-->
    </div>
    <div class="select-wrapper">
        <select id="form_edu" name="form_edu">
            <option value="">Все формы обучения</option>
            <?php foreach ($forms_edu as $form): ?>
                <option value="<?=$form ?>"><?= $form ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <!--<label for="course">Курс:</label>-->
    <div class="cur-and-grp">
    <div class="select-wrapper">
        <select id="course" name="course">
            <option value="">Все Курсы</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?=$form ?>">
                    <?php
                    if($course == 6) { echo "М1";}
                    else{echo $course;}
                    ?></option>
            <?php endforeach; ?>
        </select>
       <!-- <span class="select-label cur">Все курсы</span>-->
    </div>

    <!--<label for="group">Группа:</label>-->
    <div class="select-wrapper">
    <input list="group" type="text" id="groupSearch" placeholder="Введите группу...">
    <datalist id="group" name="group">
        <option value="">-</option>
    </datalist>
        <!--<span class="select-label grp">Группа</span>-->
    </div>
    </div>
    <button onclick="applyFilters()">Применить</button>
</div>
<div id="scheduleTable">
    <?php foreach ($schedule as $gk => $group):?>
        <?php
        $daysOfWeek = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница'];
        $TimeLessons = ['08.00-09.20', '09.30-10.50', '11.00-12.20', '12:40-14:00', '14:10-15:30','15:40-17:00','17:10-18:30','18:40-20:00'];
        $todayIndex = date('N');
        $currentHour = date('H');
        $currentMinute = date('i');
        ?>
    <h3>Группа: <?=$gk?></h3>
    <table>
        <thead style="background-color: #820000; color: #ffffff;">
        <tr>
            <td style="width: 3%" rowspan="2">№</td>
            <td style="width: 3%"  rowspan="2">Время</td>
            <?php foreach ($daysOfWeek as $i => $day):?>
            <td style="width: 20%;" colspan="2" class="<?=($i + 1 == $todayIndex) ? 'today' : '' ?>"><?=$daysOfWeek[$i]?></td>
            <?php endforeach;?>
        </tr>
        <tr>
            <td style="width: 17%;">Дисциплина, вид занятия,
                преподаватель</td>
            <td style="width: 3%;">Ауд.</td>
            <td style="width: 17%;">Дисциплина, вид занятия,
                преподаватель</td>
            <td style="width: 3%;">Ауд.</td>
            <td style="width: 17%;">Дисциплина, вид занятия,
                преподаватель</td>
            <td style="width: 3%;">Ауд.</td>
            <td style="width: 17%;">Дисциплина, вид занятия,
                преподаватель</td>
            <td style="width: 3%;">Ауд.</td>
            <td style="width: 17%;">Дисциплина, вид занятия,
                преподаватель</td>
            <td style="width: 3%;">Ауд.</td>
        </tr>
        </thead>
        <tbody >
        <?php foreach ($group as $kt => $time):?>
        <?php if (empty($TimeLessons[$kt-1])) continue; ?>
              <tr>
                  <td><?=$kt?></td>
                    <td><?=$TimeLessons[(int)$kt-1]??''?></td>
            <?php for($i=1;$i <= 5;$i++):?>
            <?php
                list($lessonStartHour, $lessonStartMinute) = explode(':', str_replace('-', ':', $TimeLessons[$kt-1]));
                $lessonsEndHour = [];
                $lessonsEndMinute = [];
                $CurrentLesson = null;
                foreach ($TimeLessons as $key => $lessonTime) {
                    $lessonTime = str_replace('.', ':', $lessonTime);

                    list($lessonEndHour[$key], $lessonEndMinute[$key]) = explode(':', substr($lessonTime, strrpos($lessonTime, '-') + 1));
                }
                $currentTime = date('H:i');

                foreach ($TimeLessons as $key => $lessonTime) {
                    $lessonTime = str_replace('.', ':', $lessonTime);

                    list($lessonStartTime, $lessonEndTime) = explode('-', $lessonTime);

                    $lessonStartTimeSeconds = strtotime($lessonStartTime);
                    $lessonEndTimeSeconds = strtotime($lessonEndTime);
                    $currentTimeSeconds = strtotime($currentTime);
                    if ($currentTimeSeconds >= $lessonStartTimeSeconds && $currentTimeSeconds <= $lessonEndTimeSeconds) {
                      $CurrentLesson = $key;
                        break;
                    }
                }
                ?>
                 <td class="<?=($kt-1 == $CurrentLesson) && ($i == $todayIndex) && (!empty($time[$i]->subject)) ?'current-lessons' : '' ?>">
                     <?php if(!empty($time[$i]->subject)): ?>
                     <?=$time[$i]->subject.' ,'?> <?=$time[$i]->type??""?> <br> <?=$time[$i]->teacher_name??""?>
                     <?php endif;?>
                 </td>
                 <td>
                     <?=$time[$i]->auditory_name??""?>

                 </td>
            <?php endfor;?>

             </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php endforeach;?>
</div>
    <div class="list-box">
        <?php foreach ($schedule as $gk => $group):?>
            <div>
                <h3>Группа: <?=$gk?></h3>
            </div>
        <div class="list-group">
            <?php for ($day = 0; $day < 5; $day++): ?>
                <div>
                    <div class="day-week <?=($day + 1 == $todayIndex) ? 'today' : '' ?>">
                    <h4><?=$daysOfWeek[$day]?></h4>
                    </div>
                        <?php foreach ($group as $kt => $time): ?>
                            <?php if (isset($time[$day + 1]) && !empty($time[$day + 1]->subject)): ?>
                                <div class="rasp-box">
                                    <div class="item-box <?=($kt-1 == $CurrentLesson) && ($day + 1 == $todayIndex) && (!empty($time[$CurrentLesson]->subject)) ?'current-lessons mr' : '' ?>">
                                        <div>
                                            <span style="font-weight: bold">Пара: № <?=$kt ?></span>
                                        </div>
                                        <div class="discip-rasp">
                                <span style="font-weight: bold">Дисциплина: <?=$time[$day + 1]->subject.' ,'?> <?=$time[$day + 1]->type??""?></span>
                                        </div>
                                        <div class="time-lesson">
                                            <span>Время: <?=$TimeLessons[$kt-1]?></span>
                                        </div>
                                        <div class="room-lesson">
                                            <span>
                                                Ауд. <?=$time[$day+1]->auditory_name??""?>
                                            </span>
                                        </div>
                                        <div class="teacher">
                                            <span>Преподаватель: <?=$time[$day + 1]->teacher_name??""?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
        <?php endforeach;?>
    </div>
<script>
    document.getElementById('faculty').addEventListener('change', updateGroups);
    document.getElementById('course').addEventListener('change', updateGroups);
    document.getElementById('form_edu').addEventListener('change', updateGroups);

    function updateGroups() {
        var selectedFaculty = document.getElementById('faculty').value;
        var selectedCourse = document.getElementById('course').value;
        var selectedEdu = document.getElementById('form_edu').value;

        if (selectedFaculty === '' && selectedCourse === '' && selectedEdu === '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= base_url('Rasp/get_all_groups') ?>', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('group').innerHTML = this.responseText;
                }
            };
            xhr.send();
        } else if (selectedFaculty !== '' && selectedCourse === '' && selectedEdu === '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= base_url('Rasp/get_groups_by_faculty') ?>?faculty=' + selectedFaculty, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('group').innerHTML = this.responseText;
                }
            };
            xhr.send();
        } else if (selectedEdu !== ''&& selectedFaculty === '' && selectedCourse === '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= base_url('Rasp/get_groups_by_edu') ?>?form_edu=' + selectedEdu, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('group').innerHTML = this.responseText;
                }
            };
            xhr.send();
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= base_url('Rasp/get_groups') ?>?faculty=' + selectedFaculty + '&form_edu=' + selectedEdu + '&course=' + selectedCourse, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('group').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }
    }

    updateGroups();

    function applyFilters() {
        var selectedFaculty = document.getElementById('faculty').value;
        var selectedCourse = document.getElementById('course').value;
        var selectedGroup = document.getElementById('groupSearch').value;
        var selectedEdu = document.getElementById('form_edu').value;

        var url = '<?= base_url('Rasp/get_schedule') ?>?faculty=' + selectedFaculty + '&form_edu='+ selectedEdu +'&course=' + selectedCourse + '&group=' + selectedGroup + '&faculties=<?php echo urlencode(json_encode($faculties)); ?>';

        window.location.href = url;
    }

    /*Select*/
   /* const facSelect = document.getElementById('faculty');
    const selectLabelFac = document.querySelector('.select-label.fac');

    facSelect.addEventListener('change', () => {
        if (facSelect.value !== "") {
            selectLabelFac.style.top = '-10px';
        } else {
            selectLabelFac.style.top = '10px';
        }
    });

    const courseSelect = document.getElementById('course');
    const selectLabelCur = document.querySelector('.select-label.cur');

    courseSelect.addEventListener('change', () => {
        if (courseSelect.value !== "") {
            selectLabelCur.style.top = '-10px';
        } else {
            selectLabelCur.style.top = '10px';
        }
    });

    const groupSearch = document.getElementById('groupSearch');
    const groupLabel = document.querySelector('.select-label.grp');

    groupSearch.addEventListener('focus', () => {
        groupLabel.style.top = '-10px';
    });

    groupSearch.addEventListener('blur', () => {
        if(groupSearch.value == ""){
            groupLabel.style.top = '10px';
        }
    });
    groupSearch.addEventListener('input', () => {
        if (groupSearch.value === "") {
            groupLabel.style.top = '10px';
        }
    });*/
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    select option:hover{
        background-color: #820000 !important;
    }
    datalist{
        height: 250px !important;
    }
    *{
        font-family: Montserrat;
    }
    #scheduleTable{
        display: block;
    }
    .filters{
        display: flex;
        gap: 5px;
        border: 2px solid #820000;
        padding: 24px;
        font-size: 20px;
        color: black;
        font-weight: bold;
    }
    .filters select{
        padding: 5px;
    }
    .filters input{
        padding: 10px;
        border-radius: 4px;
        box-sizing: border-box;;
        border: 1px solid #820000 !important;
        border: none;
    }
    .filters button{
        outline: none;
        background-color: #FFFFFF;
        padding: 9px;
        color: #820000;
        min-height: 38px;
        border: 1px solid #820000;
        border-radius: 4px;
        transition: .3s linear;
    }
    .filters button:hover{
        color: #FFFFFF;
        border: 1px solid #FFFFFF;
        background-color: #820000;
    }
    thead td{
        text-align: center;
        font-weight: bold;
    }
    td{
        padding: 10px;
    }
    table{
        min-width: 100%;
        background-color: lightgray;
        border-spacing: 2px !important;
    }
    tbody td{
        background-color: #FFFFFF;
    }
    .list-box{
        display: none;
    }
    .list-group{
        background-color: lightgray;
    }
    .day-week{
        background-color: #820000;
        color: #FFFFFF;
        padding: 10px;
    }
    .day-week h4{
        margin: 0;
    }
    .rasp-box .item-box{
        padding: 10px 20px;
        background-color: #FFFFFF;
        border-top: 1px solid lightgray;
        border-bottom: 1px solid lightgray;
    }
    .time-lesson,.room-lesson,.teacher,.discip-rasp{
        margin-top: 10px;
    }
    .today{
        text-decoration: underline;
    }
    .today:before{
        content: 'Сегодня: ';
        color: lime;
        font-weight: bold;
    }
    .current-lessons:before{
        content: 'Текущая пара: ';
        display: block;
        color: #820000;
        font-weight: bold;
    }
    .current-lessons.mr:before{
        margin-bottom: 10px;
    }
    /*Стили select*/
    .select-wrapper {
        position: relative;
        display: inline-block;
        width: 200px;
    }

    .select-wrapper label {
        position: absolute;
        top: 10px;
        left: 10px;
        pointer-events: none;
        transition: top 0.2s ease;
    }

    .select-wrapper select {
        width: 100%;
        padding: 10px;
        border: 1px solid #820000;
        border-radius: 4px;
        appearance: none;
        background-color: #fff;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .select-wrapper select::-ms-expand, .select-wrapper input::-ms-expand {
        display: none;
    }

    .select-wrapper select:focus {
        outline: none;
    }
    .select-wrapper input:focus{
        outline: 1px solid #820000;
    }
    .select-wrapper select:focus + .select-label, .select-wrapper input:focus + .select-label {
        top: -10px;
        border-radius: 15px;
    }

    .select-label {
        position: absolute;
        color: black;
        background-color: #FFFFFF;
        border-radius: 15px;
        font-weight: normal;
        padding-right: 2px;
        padding-left: 2px;
        font-size: 14px;
        top: 10px;
        left: 10px;
        pointer-events: none;
        transition: top 0.2s ease;
    }
    /*Datalist*/

    @media screen and (max-width: 1279px){
        .list-box{
            display: block;
        }
        #scheduleTable{
            display: none;
        }
        .today{
            display: flex;
            text-decoration: none !important;
        }
        .today:before{
            padding-right: 5px;
        }
    }
    @media screen and (max-width: 1055px){
        .filters{
            display: flex;
            flex-direction: column;
        }
        .cur-and-grp{
            display: flex;
            align-content: flex-end;
            box-sizing: border-box;
            gap: 5px;
        }
        .filters select#course{
            max-height: 37px;
        }
        .filters input{

            max-height: 37px;
        }
        .filters select, .filters input, .select-wrapper{
            box-sizing: border-box;
            width: 100%;
        }
        .cur-and-grp{
            display: flex;
        }
        .filters button{
            margin-top: 20px;
        }
    }
</style>
</div>
</body>
</html>