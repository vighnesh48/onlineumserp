<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_topic_title')) {
    function get_topic_title($topic_id, $subject_id, $campus_id) {
		//echo 111;exit;
        $CI =& get_instance();
        $DB3 = $CI->load->database('obe', TRUE);

        $topic = $DB3->where('topic_id', $topic_id)
                     ->where('subject_id', $subject_id)
                     ->where('campus_id', $campus_id)
                     ->get('syllabus_topics')
                     ->row();

        return $topic ? $topic->topic_title : '';
    }
}

if (!function_exists('get_subtopic_title')) {
    function get_subtopic_title($subtopic_id, $topic_id, $subject_id, $campus_id) {
        $CI =& get_instance();
        $DB3 = $CI->load->database('obe', TRUE);

        $sub = $DB3->where('subtopic_id', $subtopic_id)
                   ->where('topic_id', $topic_id)
                   ->where('subject_id', $subject_id)
                   ->where('campus_id', $campus_id)
                   ->get('syllabus_subtopics')
                   ->row();
			//echo $DB3->last_query();exit;
        return $sub ? $sub->subtopic_title : '';
    }
}
