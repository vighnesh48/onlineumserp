<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_model extends CI_Model {

    /* ===== TICKET CORE ===== */

    public function generate_ticket_no()
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $prefix = 'DF-' . date('Y') . '-';
        // Quick simple generator – you can replace with sequence table
        $DB1->select('ticket_id');
        $DB1->from('discussion_tickets');
        $DB1->order_by('ticket_id', 'DESC');
        $DB1->limit(1);
        $row = $DB1->get()->row();
        $next_id = $row ? $row->ticket_id + 1 : 1;
        return $prefix . str_pad($next_id, 6, '0', STR_PAD_LEFT);
    }

    public function create_ticket($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->insert('discussion_tickets', $data);
        return $DB1->insert_id();
    }

    public function update_ticket($ticket_id, $data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->where('ticket_id', $ticket_id);
        return $DB1->update('discussion_tickets', $data);
    }

    public function update_ticket_status($ticket_id, $status)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $this->update_ticket($ticket_id, array('status' => $status));
    }

    /* ===== SUBJECT & TOPICS BASED ON YOUR TABLES ===== */

    // Fetch subjects allocated to student from student_applied_subject

    public function get_student_subjects($stud_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $ac_yr = ACADEMIC_YEAR;
        $DB1->from('student_applied_subject sas');
        $DB1->join('student_master s','s.stud_id = sas.stud_id','left');
        $DB1->join('subject_master sub','sub.sub_id = sas.subject_id','left');
        $DB1->where('s.enrollment_no', $stud_id);
        $DB1->where('sas.is_active', 1);
        $DB1->where('sas.academic_year', $ac_yr);
        $DB1->group_by('sas.subject_id');
        $DB1->order_by('sas.semester, sub.subject_name', 'ASC');
        $query = $DB1->get();
     //   echo $DB1->last_query();exit;
        return $query->result_array();
    }

    public function get_student_subject_row($stud_id, $subject_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->from('student_applied_subject sas');
        $DB1->join('student_master s','s.stud_id = sas.stud_id','left');
        $DB1->where('s.enrollment_no', $stud_id);
        $DB1->where('sas.subject_id', $subject_id);
        $DB1->where('sas.is_active', 1);
        $query = $DB1->get();
      //  echo $DB1->last_query();exit;
        return $query->row();
    }

    // syllabus_topics table
    public function get_topics_by_subject($subject_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->from('syllabus_topics');
        $DB1->where('subject_id', $subject_id);
        $DB1->order_by('topic_order', 'ASC');
        return $DB1->get()->result();
    }

    public function get_topic_row($topic_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->from('syllabus_topics');
        $DB1->where('topic_id', $topic_id);
        return $DB1->get()->row();
    }

    // lookup faculty from lecture_time_table

    public function get_faculty_for_subject($stream_id, $stream_code, $subject_code, $semester, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select('faculty_code');
        $DB1->from('lecture_time_table');
        $DB1->where('stream_id', $stream_id);
        $DB1->where('subject_code', $subject_code);
        $DB1->where('semester', $semester);
        $DB1->where('academic_year', ACADEMIC_YEAR);
        $DB1->where('is_active', 1);
        $DB1->order_by('tdate', 'DESC');
        $DB1->limit(1);

        $query = $DB1->get();
        //echo $DB1->last_query();exit;
        $row = $query->row();
        return $row ? $row->faculty_code : null;
    }

    /* ===== LISTING ===== */

public function get_tickets_by_student($stud_id)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('discussion_tickets.*, subject_master.subject_name, subject_master.subject_component');
    $DB1->from('discussion_tickets');
    $DB1->join('subject_master', 'subject_master.sub_id = discussion_tickets.subject_code', 'left');
    $DB1->where('discussion_tickets.stud_id', $stud_id);
    $DB1->where('discussion_tickets.is_active', 1);
    $DB1->order_by('discussion_tickets.created_on', 'DESC');

    return $DB1->get()->result();
}

public function get_tickets_by_faculty($faculty_code)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('discussion_tickets.*, subject_master.subject_name, subject_master.subject_component');
    $DB1->from('discussion_tickets');
    $DB1->join('subject_master', 'subject_master.sub_id = discussion_tickets.subject_code', 'left');
    $DB1->where('discussion_tickets.faculty_code', $faculty_code);
    $DB1->where('discussion_tickets.is_active', 1);
    $DB1->order_by("(discussion_tickets.status='OPEN')", "DESC", FALSE);
    $DB1->order_by("discussion_tickets.created_on", "DESC");

    $query = $DB1->get();
    return $query->result();
}

public function get_ticket_for_student($ticket_id, $stud_id)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('discussion_tickets.*, subject_master.subject_name, subject_master.subject_component');
    $DB1->from('discussion_tickets');
    $DB1->join('subject_master', 'subject_master.sub_id = discussion_tickets.subject_code', 'left');
    $DB1->where('discussion_tickets.ticket_id', $ticket_id);
    $DB1->where('discussion_tickets.stud_id', $stud_id);
    $DB1->where('discussion_tickets.is_active', 1);

    return $DB1->get()->row();
}


public function get_ticket_for_faculty($ticket_id, $faculty_code)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('discussion_tickets.*, subject_master.subject_name, subject_master.subject_component');
    $DB1->from('discussion_tickets');
    $DB1->join('subject_master', 'subject_master.sub_id = discussion_tickets.subject_code', 'left');
    $DB1->where('discussion_tickets.ticket_id', $ticket_id);
    $DB1->where('discussion_tickets.faculty_code', $faculty_code);
    $DB1->where('discussion_tickets.is_active', 1);

    return $DB1->get()->row();
}


    /* ===== MESSAGES ===== */

    public function add_message($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->insert('discussion_messages', $data);
        return $DB1->insert_id();
    }

    public function get_messages_by_ticket($ticket_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->from('discussion_messages');
        $DB1->where('ticket_id', $ticket_id);
        $DB1->order_by('created_on', 'ASC');
        return $DB1->get()->result();
    }

    public function filter_tickets($faculty, $filters)
    {
        $DB1 = $this->load->database('umsdb', TRUE);

        $DB1->select("
            discussion_tickets.*, 
            subject_master.subject_name, 
            subject_master.subject_component
        ");

        $DB1->from('discussion_tickets');
        $DB1->join('subject_master', 'subject_master.sub_id = discussion_tickets.subject_code', 'left');

        $DB1->where('discussion_tickets.faculty_code', $faculty);
        $DB1->where('discussion_tickets.is_active', 1);

        // filters
        if (!empty($filters['status'])) {
            $DB1->where('discussion_tickets.status', $filters['status']);
        }

        if (!empty($filters['type'])) {
            $DB1->where('discussion_tickets.discussion_type', $filters['type']);
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $DB1->where("DATE(discussion_tickets.created_on) BETWEEN '{$filters['from_date']}' AND '{$filters['to_date']}'", NULL, FALSE);
        } elseif (!empty($filters['from_date'])) {
            $DB1->where("DATE(discussion_tickets.created_on) >=", $filters['from_date']);
        } elseif (!empty($filters['to_date'])) {
            $DB1->where("DATE(discussion_tickets.created_on) <=", $filters['to_date']);
        }

        // order: open first then latest
        $DB1->order_by("(discussion_tickets.status='OPEN')", "DESC", FALSE);
        $DB1->order_by("discussion_tickets.created_on", "DESC");

        $query = $DB1->get();
        return $query->result_array();
    }


}
