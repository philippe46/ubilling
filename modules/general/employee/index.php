<?php
// check for right of current admin on this module
if (cfr('EMPLOYEE')) {

   if (wf_CheckPost(array('addemployee','employeename'))) {
   stg_add_employee($_POST['employeename'], $_POST['employeejob']);
   rcms_redirect("?module=employee");
   }
   
   if (isset ($_GET['delete'])) {
   stg_delete_employee($_GET['delete']);
   rcms_redirect("?module=employee");
   }
   
   if (wf_CheckPost(array('addjobtype','newjobtype'))) {
   stg_add_jobtype($_POST['newjobtype']);
   }
   
   if (isset ($_GET['deletejob'])) {
   stg_delete_jobtype($_GET['deletejob']);
   rcms_redirect("?module=employee");
   }
   
   if (!wf_CheckGet(array('edit'))) {
       if (!wf_CheckGet(array('editjob'))) {
           //display normal tasks
       stg_show_employee_form();
       stg_show_jobtype_form();
       
       } else {
           //show jobeditor
           $editjob=vf($_GET['editjob']);
           
           //edit job subroutine
           if (wf_CheckPost(array('editjobtype'))) {
               simple_update_field('jobtypes', 'jobname', $_POST['editjobtype'], "WHERE `id`='".$editjob."'");
               log_register('JOBTYPE CHANGE '.$editjob);
               rcms_redirect("?module=employee");
           }
           
           //edit jobtype form
           $jobdata=  stg_get_jobtype_name($editjob);
           $jobinputs=  wf_TextInput('editjobtype', 'Job type', $jobdata, true, 20);
           $jobinputs.=wf_Submit('Save');
           $jobform=  wf_Form("", "POST", $jobinputs, 'glamour');
           show_window(__('Edit'), $jobform);
           show_window('', wf_Link('?module=employee', 'Back', true, 'ubButton'));
           
       }
       
   } else {
       $editemployee=vf($_GET['edit']);
       
       //if someone editing employee
       if (isset($_POST['editname'])) {
           simple_update_field('employee', 'name', $_POST['editname'], "WHERE `id`='".$editemployee."'");
           simple_update_field('employee', 'appointment', $_POST['editappointment'], "WHERE `id`='".$editemployee."'");
           if (wf_CheckPost(array('editactive'))) {
               simple_update_field('employee', 'active', '1', "WHERE `id`='".$editemployee."'");
           } else {
               simple_update_field('employee', 'active', '0', "WHERE `id`='".$editemployee."'");
           }
           log_register('EMPLOYEE CHANGE '.$editemployee);
           rcms_redirect("?module=employee");
           
       }
       
       
       $employeedata=stg_get_employee_data($editemployee);
       if ($employeedata['active']) {
           $actflag=true;
       } else {
           $actflag=false;
       }
       $editinputs=wf_TextInput('editname','Real Name' , $employeedata['name'], true, 20);
       $editinputs.=wf_TextInput('editappointment','Appointment' , $employeedata['appointment'], true, 20);
       $editinputs.=wf_CheckInput('editactive', 'Active', true, $actflag);
       $editinputs.=wf_Submit('Save');
       $editform=wf_Form('', 'POST', $editinputs, 'glamour');
       show_window(__('Edit'), $editform);
       show_window('', wf_Link('?module=employee', 'Back', true, 'ubButton'));
       
   }
   
  
  
    
} else {
      show_error(__('You cant control this module'));
}

?>