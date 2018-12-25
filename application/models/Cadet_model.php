<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Cadet_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get cadet by rin
     */
    function get_cadet($rin)
    {
        return $this->db->get_where('cadet',array('rin'=>$rin))->row_array();
    }
        
    /*
     * Get all cadet
     */
    function get_all_cadets()
    {
        $this->db->order_by('lastName', 'asc');
        return $this->db->get('cadet')->result_array();
    }
    
    /*
     * Selects all the majors from the database.
     */
    function get_major($major)
    {
        $this->db->from('cadet');
        $this->db->where("major", $major);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /*
     * Selects all the majors from the database.
     */
    function get_all_majors()
    {
        $this->db->from('cadet');
        $this->db->group_by("major");
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /*
     * Looks for cadet based of given RFID input.
     */
    function find_cadet($rfid)
    {
        return $this->db->get_where('cadet',array('rfid'=>$rfid))->row_array();
    }
        
    /*
     * function to add new cadet
     */
    function add_cadet($params)
    {
        $this->db->insert('cadet',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update cadet
     */
    function update_cadet($rin,$params)
    {
        $this->db->where('rin',$rin);
        return $this->db->update('cadet',$params);
    }
    
    /*
     * function to delete cadet
     */
    function delete_cadet($rin)
    {
        return $this->db->delete('cadet',array('rin'=>$rin));
    }
}
