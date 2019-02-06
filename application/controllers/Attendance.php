<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Attendance extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session'); 
        
        if( $this->session->userdata('login') === true )
        {
            $this->load->model('Attendance_model');
            $this->load->model('Cadet_model');

        }
        else
        {
            redirect('login/view');
        }
    } 

    /*
     * Listing of attendance
     */
    function index()
    {
        $data['attendance'] = $this->Attendance_model->get_all_attendance();
        
        $data['_view'] = 'attendance/index';
        $this->load->view('layouts/main',$data);
    }
    
    /*
     * Loads a view for the event page.
     */
    function view()
    {
        $data['title'] = 'Cadet Events';
        $this->load->model('cadetevent_model');
        $data['events'] =  $this->cadetevent_model->get_all_cadetevents();

        // Loads the home page 
        $this->load->view('templates/header', $data);
        $this->load->view('pages/attendance.php');
        $this->load->view('templates/footer');   
    }

    /*
     * Adding a new attendance
     */
    function excuse()
    {
        $this->load->model('Cadet_model');
        $this->load->model('Cadetevent_model');
        $this->load->model('Attendance_model');

        if( $this->Attendance_model->attendance_exists( $this->input->post('cadet'), $this->input->post('event')) === 0 )
        {
            $params = array(
                'rin' => $this->input->post('cadet'),
                'eventid' => $this->input->post('event'),
                'excused_absence' => 1
            );

            $this->Attendance_model->add_attendance( $params );
        }

        $data['title'] = 'Set Attendance';
        $data['event'] =  $this->Cadetevent_model->get_cadetevent( $this->input->post('event') );
        $data['cadets'] = $this->Cadet_model->get_all_cadets();

        // Loads the home page
        $this->load->view('templates/header', $data);
        $this->load->view('pages/attend.php');
        $this->load->view('templates/footer');
    }

    /*
     * Adding a new attendance
     */
    function add()
    {
        $this->load->model('cadet_model');
        $this->load->model('Cadetevent_model');

        if( $this->input->post('rfid') !== null )
        {
            $data['cadet'] = $this->cadet_model->find_cadet( $this->input->post('rfid') );
            if(isset($data['cadet']['rin']))
            {
                if(isset($_POST) && count($_POST) > 0)     
                {
                    if( $this->Attendance_model->attendance_exists( $data['cadet']['rin'], $this->input->post('event')) === 0 )
                    {
                        $params = array(
                            'rin' => $data['cadet']['rin'],
                            'eventid' => $this->input->post('event'),
                        );

                        $this->Attendance_model->add_attendance( $params );
                    }

                    $data['title'] = 'Set Attendance';
                    $data['event'] =  $this->Cadetevent_model->get_cadetevent( $this->input->post('event') );
                    $data['cadets'] = $this->Cadet_model->get_all_cadets();

                    // Loads the home page
                    $this->load->view('templates/header', $data);
                    $this->load->view('pages/attend.php');
                    $this->load->view('templates/footer');
                }
                else
                {            
                    show_error("There was no input given.");
                }
            }
            else
            {
                // TODO: Fix this link
                redirect("cadet/changerfid");
            }        
        }
        else if( $this->input->post('rin') !== null )
        {
            $data['cadet'] = $this->cadet_model->get_cadet( $this->input->post('rin') );

            if(isset($data['cadet']['rin']))
            {
                if(isset($_POST) && count($_POST) > 0)     
                {
                    if( $this->Attendance_model->attendance_exists( $data['cadet']['rin'], $this->input->post('event')) === 0 )
                    {
                        $params = array(
                            'rin' => $data['cadet']['rin'],
                            'eventid' => $this->input->post('event'),
                        );

                        $this->Attendance_model->add_attendance( $params );
                    }

                    $data['title'] = 'Set Attendance';
                    $data['event'] =  $this->Cadetevent_model->get_cadetevent( $this->input->post('event') );
                    $data['cadets'] = $this->cadet_model->get_all_cadets();

                    // Loads the home page
                    $this->load->view('templates/header', $data);
                    $this->load->view('pages/attend.php');
                    $this->load->view('templates/footer');
                }
                else
                {            
                    show_error("There was no input given.");
                }
            }
            else
            {
                show_error("This is not a cadet. Please enter a valid RIN or create a cadet with this RIN");
            }        
        }
    }  
    
    /*
     * Gets list of attendees for a given event. 
     */
    function attendees()
    {
        if( $this->input->post('event') !== null )
        {
            $data['title'] = 'Cadet Attendance';
            $this->load->model('attendance_model');
            $this->load->model('cadetevent_model');

            $data['attendees'] =  $this->attendance_model->get_event_attendance( $this->input->post('event') );
            $data['event'] =  $this->cadetevent_model->get_cadetevent( $this->input->post('event') );

            // Loads the home page 
            $this->load->view('templates/header', $data);
            $this->load->view('pages/viewattendees.php');
            $this->load->view('templates/footer'); 
        }
        else
        {
            show_error('You must select an event to view the attendees of that event.');
        }
    }

    /*
     * Editing a attendance
     */
//    function edit($rin)
//    {
//        // check if the attendance exists before trying to edit it
//        $data['attendance'] = $this->Attendance_model->get_attendance($rin);
//
//        if(isset($data['attendance']['rin']))
//        {
//            if(isset($_POST) && count($_POST) > 0)
//            {
//                $params = array(
//					'excused_absence' => $this->input->post('excused_absence'),
//					'time' => $this->input->post('time'),
//                );
//
//                $this->Attendance_model->update_attendance($rin,$params);
//                redirect('attendance/index');
//            }
//            else
//            {
//                $data['_view'] = 'attendance/edit';
//                $this->load->view('layouts/main',$data);
//            }
//        }
//        else
//            show_error('The attendance you are trying to edit does not exist.');
//    }
    

    /*
     * Deleting attendance
     */
//    function remove($rin)
//    {
//        $attendance = $this->Attendance_model->get_attendance($rin);
//
//        // check if the attendance exists before trying to delete it
//        if(isset($attendance['rin']))
//        {
//            $this->Attendance_model->delete_attendance($rin);
//            redirect('attendance/index');
//        }
//        else
//            show_error('The attendance you are trying to delete does not exist.');
//    }

    /*
     * Creates csv of attendance records.
     */
    function export()
    {
        $this->load->model('attendance_model');

        $file = $this->attendance_model->export_event_attendance( $this->input->post('event') );

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('attendance.csv', $file);
    }

    /*
     * Shows master list of attendance.
     */
    function master()
    {
        $this->load->model('Cadet_model');
        $this->load->model('Cadetevent_model');
        $this->load->model('attendance_model');

        $data['title'] = "Master Attendance";


        $table = array();
        $table[0] = array();
        $count = 0;

        $month = date('m');
        $year = date('Y');

        // Figures out how many rows will be in the table
        foreach ($this->Cadetevent_model->get_all_cadetevents() as $event)
        {
            if(($month > 6 && date("m", strtotime($event['date'])) > 6 || $month <= 6 && date("m", strtotime($event['date'])) <= 6) && (date("Y", strtotime($event['date'])) == $year))
            {
                $count += 1;
                $table[0][] = $event['name'];
            }
        }

        // Adds the sum columns for pt and llab totals
        $table[0][] = "PT Total";
        $table[0][] = "LLAB Total";

        $count = 1;

        // Goes through each event and checks to see if it's in the current semester and if the cadet was present, excused, or absent
        foreach ($this->Cadet_model->get_all_cadets() as $cadet)
        {
            // If person is not a cadet attendance is not shown
            if(strpos($cadet['rank'], 'AS') !== false)
            {
                $found = false;
                $pt = 0;
                $llab = 0;
                $table[$count] = array();
                $table[$count][0] = $cadet['lastName'];

                foreach ($this->Cadetevent_model->get_all_cadetevents() as $event)
                {
                    if (($month > 6 && date("m", strtotime($event['date'])) > 6 || $month <= 6 && date("m", strtotime($event['date'])) <= 6) && (date("Y", strtotime($event['date'])) == $year))
                    {
                        $cursemester = true;
                    }
                    else
                    {
                        $cursemester = false;
                    }

                    // If the event didn't take place in the current semester event is not shown
                    if ($cursemester)
                    {
                        foreach ($this->attendance_model->get_all_attendance() as $attendee)
                        {
                            if ($attendee['rin'] === $cadet['rin'] && $event['eventID'] === $attendee['eventid'])
                            {
                                if ($attendee['excused_absence'] == 1)
                                {
                                    $table[$count][] = "E";
                                    $found = true;
                                    break;
                                }
                                else
                                {
                                    $table[$count][] = "P";
                                    $found = true;
                                    $month = date('m');
                                    $year = date('Y');

                                    if ($event['pt'] == 1) {
                                        $pt += 1;
                                    } else if ($event['llab'] == 1) {
                                        $llab += 1;
                                    }
                                    break;
                                }
                            }
                        }
                    }

                    if ($found === false && $cursemester)
                    {
                        $table[$count][] = "A";
                    }
                    else
                    {
                        $found = false;
                    }
                }

                $table[$count][] = $pt . "/" . $this->Cadetevent_model->get_event_total('pt');
                $table[$count][] = $llab . "/" . $this->Cadetevent_model->get_event_total('llab');

                $count += 1;
                $pt = 0;
                $llab = 0;
            }
        }

        $data['table'] = $table;

        // Loads the home page
        $this->load->view('templates/header', $data);
        $this->load->view('pages/masterattendance');
        $this->load->view('templates/footer');
    }
    
}
