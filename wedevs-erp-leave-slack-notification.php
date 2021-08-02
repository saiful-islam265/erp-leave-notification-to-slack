<?php
add_action( 'erp_hr_leave_request_approved', 'erp_leave_request_approved_slack_notification', 10, 2 );
function erp_leave_request_approved_slack_notification($id, $request){
	if($request->last_status == 1){
        $start_date = date("d/m/Y", $request->start_date);
        $end_date = date("d/m/Y", $request->end_date);
        $employeeInfo = get_user_by('id', $request->user_id);
        $channel_hooks = 'Your slack chaqnnel webhook url';
        $sec_array = array();
        $sec_array['type'] = 'section';
        $sec_array['text']['type'] = 'mrkdwn';
        $sec_array['text']['text'] =''.$employeeInfo->data->display_name.' will be on leave from '.$start_date.' to '.$end_date.'';
        $new_sq[] = $sec_array;
        $message = array('payload' => json_encode(array(
            'text' => 'Employee Leave Notification',
            "blocks" =>
                $new_sq
        )));
        $args = array(
            'body'        => $message,
            'timeout'     => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(),
            'cookies'     => array(),
        );
        $response = wp_remote_post( $channel_hooks, $args );
    }
}