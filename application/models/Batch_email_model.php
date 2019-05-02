<?php

class Batch_email_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get batchemail by uid
     */
    function get_batchemail($uid)
    {
        return $this->db->get_where('emails',array('uid'=>$uid))->row_array();
    }

    /*
     * Get all batchemails
     */
    function get_all_batchemails()
    {
        $this->db->order_by('day', 'desc');
        return $this->db->get('emails')->result_array();
    }

    /*
     * function to add new batchemail
     */
    function add_batchemail($params)
    {
        $this->db->insert('emails',$params);
        return $this->db->insert_id();
    }

    /*
     * function to update batchemail
     */
    function update_batchemail($uid,$params)
    {
        $this->db->where('uid',$uid);
        return $this->db->update('emails',$params);
    }

    /*
     * function to delete batchemail
     */
    function delete_batchemail($uid)
    {
        return $this->db->delete('emails',array('uid'=>$uid));
    }

    /*
     * Searches for a cadet's daily email.
     *
     * @param rin - the user's rin number (uid)
     */
    function email_exists($rin)
    {
        $this->db->where('cadet', $rin);
        return $this->db->get('emails', 1)->row_array();
    }
}

