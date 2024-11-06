<?php

namespace App\Controllers;

use App\Models\ScheduleModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class ScheduleController extends BaseController
{
    protected ScheduleModel $schedule;
    public function __construct()
    {
        $this->schedule        = model(ScheduleModel::class);
    }

    public function index(): string
    {
        $this->schedule->getJsonFile();

        $schedule = $this->db->table('schedule')->orderBy('time')->get()->getResult();
        $results =[];
        foreach ($schedule as $item) {
            $results[$item->group_name][$item->time][$item->weekday] = $item;
        }

        $faculties = $this->db->table('schedule')->distinct()->select('faculty')->get()->getResultArray();
        $faculties = array_column($faculties, 'faculty');
        $courses = $this->db->table('schedule')->distinct()->select('course')->get()->getResultArray();
        $courses = array_column($courses, 'course');
        $groups = $this->db->table('schedule')->distinct()->select('group_name')->get()->getResultArray();
        $groups = array_column($groups, 'group_name');
        $forms_edu = $this->db->table('schedule')->distinct()->select('form_edu')->get()->getResultArray();
        $forms_edu = array_column($forms_edu, 'form_edu');

        $data = [
            'schedule' => $results,
            'faculties' => $faculties,
            'courses' => $courses,
            'groups' => $groups,
            'forms_edu' => $forms_edu
        ];

        return view('Public/Schedule/schedule',$data);
    }

    public function getSchedule(): string
    {
        $faculty = $this->request->getGet('faculty');
        $course = $this->request->getGet('course');
        $group = $this->request->getGet('group');
        $form_edu = $this->request->getGet('form_edu');

        $faculties = $this->db->table('schedule')->distinct()->select('faculty')->get()->getResultArray();
        $faculties = array_column($faculties, 'faculty');
        $courses = $this->db->table('schedule')->distinct()->select('course')->get()->getResultArray();
        $courses = array_column($courses, 'course');
        $groups = $this->db->table('schedule')->distinct()->select('group_name')->get()->getResultArray();
        $groups = array_column($groups, 'group_name');
        $forms_edu = $this->db->table('schedule')->distinct()->select('form_edu')->get()->getResultArray();
        $forms_edu = array_column($forms_edu, 'form_edu');

        $builder = $this->db->table('schedule')->orderBy('time');

        if (!empty($faculty)) {
            $builder->where('faculty', $faculty);
        }
        if (!empty($course)) {
            $builder->where('course', $course);
        }
        if (!empty($group)) {
            $builder->where('group_name', $group);
        }
        if (!empty($form_edu)) {
            $builder->where('form_edu', $group);
        }

        $schedule = $builder->get()->getResult();

        $results = [];
        foreach ($schedule as $item) {
            $results[$item->group_name][$item->time][$item->weekday] = $item;
        }

        $groups = $this->db->table('schedule')
            ->where('faculty', $faculty)
            ->where('course', $course)
            ->distinct()
            ->select('group_name')
            ->get()
            ->getResultArray();
        $groups = array_column($groups, 'group_name');

        $data = [
            'schedule' => $results,
            'faculties' => $faculties,
            'courses' => $courses,
            'groups' => $groups,
            'forms_edu' => $forms_edu,
        ];
        return view('Public/Schedule/schedule', $data);
    }

    public function getGroups(): string
    {
        $faculty = $this->request->getGet('faculty');
        $course = $this->request->getGet('course');
        $form_edu = $this->request->getGet('form_edu');

        $groups = $this->db->table('schedule')
            ->where('faculty', $faculty)
            ->where('form_edu', $form_edu)
            ->where('course', $course)
            ->distinct()
            ->select('group_name')
            ->get()
            ->getResultArray();

        $html = '<option value="">-</option>';
        foreach ($groups as $group) {
            $html .= '<option value="' . $group['group_name'] . '">' . $group['group_name'] . '</option>';
        }

        return $html;
    }

    public function getAllGroups(): string
    {
        $groups = $this->db->table('schedule')
            ->distinct()
            ->select('group_name')
            ->get()
            ->getResultArray();

        $html = '<option value="">-</option>';
        foreach ($groups as $group) {
            $html .= '<option value="' . $group['group_name'] . '">' . $group['group_name'] . '</option>';
        }

        return $html;
    }

    public function getGroupsByFaculty(): string
    {
        $faculty = $this->request->getGet('faculty');

        $groups = $this->db->table('schedule')
            ->where('faculty', $faculty)
            ->distinct()
            ->select('group_name')
            ->get()
            ->getResultArray();

        $html = '<option value="">-</option>';
        foreach ($groups as $group) {
            $html .= '<option value="' . $group['group_name'] . '">' . $group['group_name'] . '</option>';
        }

        return $html;
    }
    public function getGroupsByEdu(): string
    {
        $form_edu = $this->request->getGet('form_edu');

        $groups = $this->db->table('schedule')
            ->where('from_edu', $form_edu)
            ->distinct()
            ->select('group_name')
            ->get()
            ->getResultArray();

        $html = '<option value="">-</option>';
        foreach ($groups as $group) {
            $html .= '<option value="' . $group['group_name'] . '">' . $group['group_name'] . '</option>';
        }

        return $html;
    }

}
