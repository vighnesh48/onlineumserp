<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpdesk_model extends CI_Model
{
    private $DB;

    public function __construct()
    {
        parent::__construct();
        // adjust if you use umsdb / default db
        $this->DB = $this->load->database('umsdb', TRUE);
    }

    /* --------- Categories --------- */

    public function get_active_categories()
    {
        return $this->DB->where('is_active', 1)
                        ->order_by('category_name', 'ASC')
                        ->get('helpdesk_categories')
                        ->result();
    }

    public function get_category($category_id)
    {
        return $this->DB->get_where('helpdesk_categories', [
            'category_id' => $category_id,
            'is_active'   => 1
        ])->row();
    }

    /* --------- Ticket ops --------- */

    public function generate_ticket_no()
    {
        $year = date('Y');
        $this->DB->select('COUNT(*) AS cnt');
        $this->DB->from('helpdesk_tickets');
        $this->DB->where('YEAR(created_on) =', $year, FALSE);
        $row = $this->DB->get()->row();
        $seq = $row ? $row->cnt + 1 : 1;
        return 'HD'.$year.'-'.str_pad($seq, 5, '0', STR_PAD_LEFT);
    }

    public function create_ticket($data, $first_message = null)
    {
        $this->DB->trans_start();

        $this->DB->insert('helpdesk_tickets', $data);
        $ticket_id = $this->DB->insert_id();

        if ($first_message) {
            $first_message['ticket_id'] = $ticket_id;
            $this->DB->insert('helpdesk_messages', $first_message);
        }

        $this->DB->trans_complete();

        return $this->DB->trans_status() ? $ticket_id : false;
    }

    public function get_ticket_for_student($ticket_id, $student_id)
    {
        $this->DB->select('t.*, c.category_name');
        $this->DB->from('helpdesk_tickets t');
        $this->DB->join('helpdesk_categories c', 'c.category_id = t.category_id', 'left');
        $this->DB->where('t.ticket_id', $ticket_id);
        $this->DB->where('t.student_id', $student_id);
        $this->DB->where('t.is_active', 1);
        return $this->DB->get()->row();
    }

    public function get_ticket_for_admin($ticket_id)
    {
        $this->DB->select('t.*, c.category_name');
        $this->DB->from('helpdesk_tickets t');
        $this->DB->join('helpdesk_categories c', 'c.category_id = t.category_id', 'left');
        $this->DB->where('t.ticket_id', $ticket_id);
        $this->DB->where('t.is_active', 1);
        return $this->DB->get()->row();
    }

    public function get_student_tickets($student_id)
    {
        $this->DB->select('t.*, c.category_name');
        $this->DB->from('helpdesk_tickets t');
        $this->DB->join('helpdesk_categories c', 'c.category_id = t.category_id', 'left');
        $this->DB->where('t.student_id', $student_id);
        $this->DB->where('t.is_active', 1);
        $this->DB->order_by("(t.status='OPEN')", "DESC", FALSE);
        $this->DB->order_by('t.created_on', 'DESC');
        return $this->DB->get()->result();
    }

    public function get_admin_tickets($filters = [])
    {
        $this->DB->select('t.*, c.category_name');
        $this->DB->from('helpdesk_tickets t');
        $this->DB->join('helpdesk_categories c', 'c.category_id = t.category_id', 'left');
        $this->DB->where('t.is_active', 1);

        if (!empty($filters['status'])) {
            $this->DB->where('t.status', $filters['status']);
        }
        if (!empty($filters['category_id'])) {
            $this->DB->where('t.category_id', $filters['category_id']);
        }
        if (!empty($filters['priority'])) {
            $this->DB->where('t.priority', $filters['priority']);
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $this->DB->where("DATE(t.created_on) BETWEEN '{$filters['from_date']}' AND '{$filters['to_date']}'", NULL, FALSE);
        }

        $this->DB->order_by("(t.status='OPEN')", "DESC", FALSE);
        $this->DB->order_by("t.created_on", "DESC");

        return $this->DB->get()->result();
    }

    public function update_ticket($ticket_id, $data)
    {
        return $this->DB->where('ticket_id', $ticket_id)
                        ->update('helpdesk_tickets', $data);
    }

    /* --------- Messages --------- */

    public function get_messages($ticket_id, $for_admin = false)
    {
        $this->DB->from('helpdesk_messages');
        $this->DB->where('ticket_id', $ticket_id);
        if (!$for_admin) {
            $this->DB->where('is_internal', 0);
        }
        $this->DB->order_by('created_on', 'ASC');
        return $this->DB->get()->result();
    }

    public function add_message($data)
    {
        $this->DB->insert('helpdesk_messages', $data);
        return $this->DB->insert_id();
    }

    /* --------- Feedback --------- */

    public function get_feedback($ticket_id)
    {
        return $this->DB->get_where('helpdesk_feedback', ['ticket_id' => $ticket_id])->row();
    }

    public function save_feedback($data)
    {
        $existing = $this->get_feedback($data['ticket_id']);
        if ($existing) {
            $this->DB->where('feedback_id', $existing->feedback_id)
                     ->update('helpdesk_feedback', $data);
            return $existing->feedback_id;
        } else {
            $this->DB->insert('helpdesk_feedback', $data);
            return $this->DB->insert_id();
        }
    }
}
