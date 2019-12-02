<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Wiki_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get wiki by name.
     *
     * @param int $id - wiki id
     * @return int - index of wiki in wiki table
     */
    function get_wiki($id)
    {
        return $this->db->get_where('wiki',array('id'=>$id))->row_array();
    }
        
    /**
     * Get all wikis.
     *
     * @return array - all existing wikis
     */
    function get_all_wikis()
    {
        $this->db->order_by('name', 'asc');
        return $this->db->get('wiki')->result_array();
    }
        
    /**
     * Add wiki.
     *
     * @param wiki $params - parameters for new wiki
     * @return int - id of created wiki
     */
    function add_wiki($params)
    {
        $this->db->insert('wiki',$params);
        return $this->db->insert_id();
    }
    
    /**
     * Update wiki.
     *
     * @param int $id - wiki id
     * @param wiki $params - updated wiki paramters
     * @return wiki - updated wiki
     */
    function update_wiki($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('wiki',$params);
    }
    
    /**
     * Delete wiki.
     *
     * @params int $id - wiki id
     * @return int - deleted wiki id
     */
    function delete_wiki($id)
    {
        return $this->db->delete('wiki',array('id'=>$id));
    }
}
