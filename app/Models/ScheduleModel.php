<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

class ScheduleModel extends GeneralModel {
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }

    protected $table = 'schedule'; // Замените 'timetable' на имя вашей таблицы
    protected $allowedFields = [
        'week_number',
        'group_name',
        'course',
        'faculty',
        'form_edu',
        'weekday',
        'subject',
        'type',
        'subgroup',
        'time_start',
        'time_end',
        'time',
        'week',
        'date',
        'teacher_name',
        'teacher_id',
        'auditory_name',
        'Lesson_ID_Num'
    ];

    public function importFromJson($json)
    {

        $this->truncate();

        // Перебор массива timetable
        foreach ($json as $timetableItem) {
            foreach ($timetableItem['timetable'] as $week) {
                foreach ($week['groups'] as $group) {
                    foreach ($group['days'] as $day) {
                        $third_symbol = substr($group['group_name'], 2, 1);
                        $fourth_symbol = substr($group['group_name'], 3, 1);

                        if ($third_symbol === "3") {
                            $group['course'] = 6;
                        }
                        if (array_key_exists('lessons', $day)) {
                            foreach ($day['lessons'] as $lesson) {

                                if (empty($lesson['lessons'])) {
                                    $lesson['date'] = '0000-00-00';
                                }
                                else{
                                    $lesson['date'] = date('Y-m-d',strtotime($lesson['date']));
                                }
                                if($group['faculty'] == ""){
                                    $group['faculty'] = 'Факультет не указан';
                                }


                                $audiotry = $lesson['auditories'][0]["auditory_name"]??"";

                                if(strpos($audiotry,"25") === 0)
                                    $audiotry = "DO";


                                $insertData = [
                                    'group_name' => $group['group_name'],
                                    'course' => $group['course'],
                                    'faculty' => $group['faculty'],
                                    'form_edu' => $fourth_symbol,
                                    'weekday' => $day['weekday'],
                                    'subject' => $lesson['subject']??null,
                                    'type' => $lesson['type']??'',
                                    'time' => $lesson['time']??'',
                                    'week' => $lesson['week']??'',
                                    'time_start' => $lesson['time_start']??null,
                                    'time_end' => $lesson['time_end']??null,
                                    'date' => $lesson['date'],
                                    'teacher_name' => $lesson['teachers'][0]['teacher_name']??'',
                                    'auditory_name' => $audiotry,
                                ];

                                $existingRecord = $this->db->table('schedule')
                                    ->where($insertData)
                                    ->countAllResults();

                                d($existingRecord);


                                if (!$existingRecord) {
                                    $this->db->table($this->table)->insert($insertData);
                                    d($insertData['auditory_name']);
                                } else {

                                }
                            }
                        } else {

                        }

                    }
                }
            }
        }
        /**
        $this->db->table($this->table)
            ->update(
            [
                "auditory_name" => "ДО"
            ],
            "auditory_name LIKE '25.%'"
        )
        ;

        ECHO $this->db->lastQuery;
        /**/
    }



    function getJsonFile()
    {
        $jsondata = file_get_contents(base_url('schedule/6week2.json'));

        $jsondata = mb_convert_encoding($jsondata, 'UTF-8', 'windows-1251');

        $jsondata = str_replace('\\', '/', $jsondata);

        $data = json_decode($jsondata,true);

        $this->importFromJson($data);

    }

}
