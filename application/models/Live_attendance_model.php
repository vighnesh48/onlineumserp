<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_attendance_model extends CI_Model
{
    protected $umsdb;
    protected $table = 'live_attendance';

    public function __construct()
    {
        parent::__construct();
        // use the umsdb connection for all attendance queries
        $this->umsdb = $this->load->database('umsdb', TRUE);
    }

    /**
     * Mark join: create attendance row or return existing active row.
     * Returns attendance_id (int).
     *
     * @param int $session_id
     * @param int $student_id
     * @return int|false
     */
    public function mark_join($session_id, $student_id)
    {
        if (empty($session_id) || empty($student_id)) {
            return false;
        }

        // Try to find an active attendance row (no left_at)
        $row = $this->umsdb
            ->where('session_id', $session_id)
            ->where('student_id', $student_id)
            ->where('left_at IS NULL', null, false)
            ->get($this->table)
            ->row();

        $now = date('Y-m-d H:i:s');

        if ($row) {
            // Update last_ping_at and return existing id
            $this->umsdb->where('id', $row->id)->update($this->table, [
                'last_ping_at' => $now
            ]);
            return (int)$row->id;
        }

        // Insert new attendance row
        $payload = [
            'session_id'   => $session_id,
            'student_id'   => $student_id,
            'joined_at'    => $now,
            'last_ping_at' => $now,
            'ip_address'   => $this->input->ip_address(),
            'user_agent'   => $this->input->user_agent(),
            'created_at'   => $now
        ];

        $this->umsdb->insert($this->table, $payload);
        return (int)$this->umsdb->insert_id();
    }

    /**
     * Update heartbeat / ping for an attendance row.
     *
     * @param int $attendance_id
     * @return bool
     */
    public function update_ping($attendance_id)
    {
        if (empty($attendance_id)) return false;

        $now = date('Y-m-d H:i:s');
        $this->umsdb->where('id', $attendance_id)->where('left_at IS NULL', null, false)
            ->update($this->table, ['last_ping_at' => $now]);

        return ($this->umsdb->affected_rows() >= 0);
    }

    /**
     * Mark leave for an attendance row: set left_at and compute duration_seconds.
     *
     * @param int $attendance_id
     * @return bool
     */
    public function mark_leave($attendance_id)
	{
		if (empty($attendance_id)) return false;

		// Use umsdb connection already set in constructor
		$row = $this->umsdb->get_where($this->table, ['id' => $attendance_id])->row();

		if (!$row) {
			log_message('warning', "mark_leave: attendance row not found id={$attendance_id}");
			return false;
		}

		if (!empty($row->left_at)) {
			log_message('info', "mark_leave: already left id={$attendance_id} left_at={$row->left_at}");
			return false;
		}

		$left = date('Y-m-d H:i:s');
		$joined_ts = strtotime($row->joined_at) ?: time();
		$duration = max(0, strtotime($left) - $joined_ts);

		// Use transaction to avoid race (update attendance then check active count)
		$this->umsdb->trans_start();

		$this->umsdb->where('id', $attendance_id)->update($this->table, [
			'left_at' => $left,
			'duration_seconds' => $duration,
			'last_ping_at' => $left
		]);

		// Count active (not-left) attendances for same session
		$activeCount = $this->umsdb
			->from($this->table)
			->where('session_id', $row->session_id)
			->where('left_at IS NULL', null, false)
			->count_all_results();

		// If none remain, mark session completed
		if ($activeCount === 0) {
			// Defensive: check live_sessions table exists
			if ($this->umsdb->table_exists('live_sessions')) {
				$this->umsdb->where('id', $row->session_id)->update('live_sessions', ['status' => 'completed']);
				log_message('info', "mark_leave: no active attendees for session {$row->session_id}, marked session completed.");
			} else {
				log_message('warning', "mark_leave: live_sessions table not found; can't mark session completed.");
			}
		} else {
			log_message('info', "mark_leave: active attendees remain for session {$row->session_id}: {$activeCount}");
		}

		$this->umsdb->trans_complete();

		$affected = $this->umsdb->affected_rows();

		if ($this->umsdb->trans_status() === FALSE) {
			log_message('error', "mark_leave: DB transaction failed for attendance_id={$attendance_id}");
			return false;
		}

		return true;
	}

    /**
     * Finalize expired attendances where last_ping_at is older than threshold_seconds.
     * Uses last_ping_at as left_at, computes duration_seconds.
     *
     * @param int $threshold_seconds
     * @return int  Count of rows finalized
     */
    public function finalize_expired($threshold_seconds = 60)
    {
        $threshold_seconds = (int)$threshold_seconds;
        if ($threshold_seconds <= 0) $threshold_seconds = 60;

        $cutoff = date('Y-m-d H:i:s', time() - $threshold_seconds);

        // Select rows to finalize
        $rows = $this->umsdb->select('*')
            ->from($this->table)
            ->where('left_at IS NULL', null, false)
            ->where('last_ping_at <=', $cutoff)
            ->get()
            ->result();

        $count = 0;
        foreach ($rows as $r) {
            $left = $r->last_ping_at ?: date('Y-m-d H:i:s');
            $duration = max(0, strtotime($left) - strtotime($r->joined_at));
            $this->umsdb->where('id', $r->id)->update($this->table, [
                'left_at' => $left,
                'duration_seconds' => $duration
            ]);
            $count++;
        }

        return $count;
    }

    /**
     * Return active attendance row for given session+student (left_at IS NULL).
     *
     * @param int $session_id
     * @param int $student_id
     * @return object|null
     */
    public function get_active($session_id, $student_id)
    {
        if (empty($session_id) || empty($student_id)) return null;

        return $this->umsdb
            ->get_where($this->table, [
                'session_id' => $session_id,
                'student_id' => $student_id,
                'left_at'    => null
            ])->row();
    }
}
