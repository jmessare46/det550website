<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Attendance_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get attendance by rin
     */
    function get_attendance( $rin )
    {
        $this->db->select('cadetEvent.pt, cadetEvent.llab, cadet.lastName, cadetEvent.name, attendance.excused_absence, attendance.time');
        $this->db->from('attendance');
        $this->db->join('cadet', 'cadet.rin = attendance.rin');
        $this->db->join('cadetEvent', 'cadetEvent.eventID = attendance.eventid');
        $this->db->where('attendance.rin', $rin);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Get attendance status.
     */
    function get_attendance_status($rin, $id)
    {
        $this->db->where('rin',$rin);
        $this->db->where('eventid',$id);

        return $this->db->get('attendance')->row_array();
    }

    /*
     * Returns the master attendance.
     */
    function get_attendance_records()
    {
        $this->db->select('pt, llab, lastName, firstName, excused_absence, attendance.eventid, cadetEvent.eventID, cadet.rin');
        $this->db->from('cadet');
        $this->db->join('attendance', 'cadet.rin = attendance.rin');
        $this->db->join('cadetEvent', 'cadetEvent.eventID = attendance.eventid');
        $this->db->where('YEAR(cadetEvent.date) = YEAR(CURDATE())');

        if(date("m") >= 1 && date("m") < 6)
        {
            $this->db->where('MONTH(date) > 0');
            $this->db->where('MONTH(date) < 6');
        }
        else
        {
            $this->db->where('MONTH(date) > 5');
            $this->db->where('MONTH(date) < 13');
        }

        $query = $this->db->get();
        return $query->result_array();
    }
      
    /*
     * Get attendance by event
     */
    function get_event_attendance( $id )
    {
        $this->db->select('cadetEvent.pt, cadetEvent.llab, cadet.lastName, cadetEvent.name, attendance.excused_absence, attendance.time');
        $this->db->from('attendance');
        $this->db->join('cadet', 'cadet.rin = attendance.rin');
        $this->db->join('cadetEvent', 'cadetEvent.eventID = attendance.eventid');
        $this->db->where('attendance.eventid', $id);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Get attendance by event
     */
    function export_event_attendance( $id )
    {
        $this->db->select('cadet.lastName as Last Name, cadetEvent.name as Event, attendance.excused_absence as Excused, attendance.time as Time');
        $this->db->from('attendance');
        $this->db->join('cadet', 'cadet.rin = attendance.rin');
        $this->db->join('cadetEvent', 'cadetEvent.eventID = attendance.eventid');
        $this->db->where('attendance.eventid', $id);

        $query = $this->db->get();
        $this->load->dbutil();
        $file = $this->dbutil->csv_from_result( $query );
        return $file;
    }

    /*
     * Gets total of pt or llab in the current year
     */
    function get_event_total($event, $rin)
    {
        $this->db->from('attendance');
        $this->db->where($event, 1);
        $this->db->where('rin', $rin);
        $this->db->join('cadetEvent', 'cadetEvent.eventID = attendance.eventid');
        $this->db->where('YEAR(date) = YEAR(CURDATE())');
        if(date("m") >= 1 && date("m") < 6)
        {
            $this->db->where('MONTH(date) > 0');
            $query = $this->db->where('MONTH(date) < 6');
        }
        else
        {
            $this->db->where('MONTH(date) > 5');
            $query = $this->db->where('MONTH(date) < 13');
        }

        return $query->count_all_results();
    }

    /*
     * Get all attendance
     */
    function get_all_attendance()
    {
        $this->db->order_by('rin', 'desc');
        return $this->db->get('attendance')->result_array();
    }
        
    /*
     * function to add new attendance
     */
    function add_attendance($params)
    {
        $this->db->insert('attendance',$params);
        return $this->db->insert_id();
    }

    /*
     * function to update attendance
     */
    function attendance_exists($rin,$id)
    {
        $this->db->from('attendance');
        $this->db->where('rin',$rin);
        $this->db->where('eventid',$id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /*
     * function to update attendance
     */
    function update_attendance($rin,$id,$params)
    {
        $this->db->where('rin',$rin);
        $this->db->where('eventid',$id);
        return $this->db->update('attendance',$params);
    }
    
    /*
     * function to delete attendance
     */
    function delete_attendance($rin,$event)
    {
        return $this->db->delete('attendance',array('rin'=>$rin,'eventid'=>$event));
    }
}
