<?php

class Batchemail extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Batch_email_model');
        $this->load->library('email');
    }

    /*
     * Sends all scheduled emails for the day
     */
    function schedule()
    {
        // Sets the timezone to our time zone
        date_default_timezone_set( "America/New_York" );

        foreach( $this->Batch_email_model->get_all_batchemails() as $email )
        {
            if( $email['day'] === date("Y-m-d") )
            {
                $this->email->to($email['to']);
                $this->email->from($email['from'],$email['title']);
                $this->email->subject($email['subject']);
                $this->email->message($email['message']);
                $this->email->send();

                // Removes scheduled email from DB after sending it
                $this->Batch_email_model->delete_batchemail( $email['uid'] );
            }
            else
            {
                show_error( date("Y-m-d") . " is not " . $email['day']);
            }
        }
    }
}
