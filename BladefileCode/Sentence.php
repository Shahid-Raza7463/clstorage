<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sentence extends Command
{
  public function client_list1()
  {


    // I currently don’t have any pending tasks. Please let me know which module I should work on next.
    //* mail formate 
    // write subject

    // Dear Sir,

    // I have attached all QA-passed tasks that are currently pending in UAT.

    // Thanks & regards,
    // Shahid Raza (7488952139)


    // 1.The client wants to know the active and inactive users in the attendance report.
    // 2.If a user does not submit their timesheet continuously for one month, the attendance record should reflect this.
    // 3.The client wants attendance report data from April to September. Currently, the data is only available from October because the attendance module has been running since then.


    // Yes,I have some urgent to-do list tasks that need to be completed on a priority basis and ⁠simmi maam i can not do preparion for all vsa flow at 6:30 Pm meeting  
    // As per the client's discussion, this task is not a priority at the moment, so I am ignoring it for now 

    // You mean our meeting will be at 7 PM, right ?



    // Subject: Request for Replacement Laptop

    // Dear IT Team,

    // My current laptop is not functioning properly and is affecting my work efficiency.

    // I kindly request you to assign me another laptop at your earliest convenience so that I can continue my work without interruptions.

    // Thank you for your support.

    // Best regards,
    // Shahid Raza



    //  Dear IT Team,
    // I would like to inform you that I am facing some issues with my laptop. Please look into it and help resolve the issue at the earliest.
    // Thank you for your support.


    // I just wanted to inform you that my friend Astha Gupta has applied for the Data Analyst position via email at hr@capitall.io.
    // Kindly have a look at her resume when you get a chance. Thank you



    //* Meeting Chalanges for Kras
    // you have to ready speech for chalanging point like upload kras file har tab per aata hai 


    //! All task


    // Assignment Budgeting and Assignment Mapping tab functions are merged into 1 single tab "Add Assignment"
    // In case of new joining, attendance for the month of joining will be created from the date of joining. Previously in case any person is joining in the mid month attendance for the same will not be captured for the joining month.
    // Since attendance module was implemented in the month of oct so data from April to Sept needs to be included in the reports.
    //"PRD" ka full form hota hai: Product Requirements Document. 

    // Timesheet Flow
    // 1.     Users fill timesheets daily but can only submit them weekly (Monday-Saturday or Monday-Sunday).
    // 2.     Users must complete timesheets sequentially, with errors flagged for any skipped days during submission.
    // 3.     For new joiners, pre-joining days auto-fill as 'N/A,' and timesheets start from the joining date.
    // 4.     Users can delete and refill incorrect timesheets.
    // 5.     Admins can reject submitted timesheets, allowing users to edit or apply leave for the rejected period.
    // 6.     Blocked timesheets require approval to unlock for a 2-day window before re-blocking.
    // 7.     Timesheets allow inputs for work and travel, with weekends marked as holidays where applicable.
    // 8.     Notifications are sent to partners for approval requests and to users upon approval or rejection.
    // 9.     Admins/partners see a confirmation prompt when approving/rejecting timesheets.
    // 10.  Timesheets automatically block after 16-17 days from the last submission, depending on submission day.
    // 11.  Admins can filter team-submitted timesheets using various criteria.
    // 12.  Assignments are excluded from selection once closed.
    // 13.  Separate columns are used to display submitted timesheet data.
    // 14.  Team timesheet reports are accessible to admins and partners.
    // 15.  Input fields refresh when the date changes during timesheet creation.
    // 16.  Clients are listed based on open assignments and their closure dates.
    // 17.  Warning messages appear when clicking the approve button and modal boxes for rejections.
    // 18.  Total hours reset to zero after taking exam or casual leave.
    // 19.  Team timesheet reports include assignment name filters.
    // 20.  Saved timesheets can be force-submitted during user exit.
    // 21.  Weekly timesheets are accessible by admin, partner, and manager roles.
    // 22.  Work items are auto-filled from the calendar when holidays are selected.
    // 23.  Sundays are highlighted in the timesheet calendar.
    // 24.  Admins can assign secondary partners to assignments.
    // 25.  Warning messages are shown on the timesheet creation page for rejected timesheets.
    // 26.  Remarks are mandatory for timesheet requests to prevent blank submissions.
    // 27.  Timesheet request forms allow attachments.
    // 28.  Leave cannot be applied for dates before the latest submitted timesheet unless rejected.
    // 29.  Rejected timesheets allow leave application for the corresponding period.
    // 30.  Users can edit and resubmit rejected timesheets.
    // 31.  Popups display when viewing "Reason" and "Remark" details on leave and timesheet request listings.
    // 32.  Rejection of timesheets covering multiple days is allowed.
    // 33.  Warning messages prevent saving timesheets for dates post-leaving.
    // 34.  Unsubmitted timesheets for one month reflect in the attendance record.
    // 35.  Admins can delete saved timesheets.
    // 36.  Users cannot submit a new timesheet request within 24 hours of an open request.
    // 37.  Weekly timesheet reports are sent in Excel format upon admin/partner action.
    // Leave Flow
    // 1.     Approved casual leave (CL) appears in the 'Submitted Timesheet' section.
    // 2.     Alerts confirm leave approval/rejection.
    // 3.     Continuous leave excludes holidays automatically.
    // 4.     Holidays during exam leave display 'H' in attendance records.
    // 5.     Leave applications notify partners, and approval sends notifications to users.
    // 6.     Popup messages show "Reason" and "Remark" details on leave listings.
    // 7.     Exam leave timesheets auto-submit if weekly timesheets are consistently submitted.
    // 8.     Total hours reset to zero after taking casual or exam leave.
    // 9.     Leave cannot precede the latest submitted timesheet unless rejected.
    // 10.  Rejected timesheets allow leave applications for corresponding periods, updating submitted timesheets.
    // 11.  Alerts confirm leave approval/rejection on the apply leave page.
    // 12.  Leave reverts delete all data when reversed to the start leave date.
    // 13.  Users can see approved leave counts for the year (April-current).
    // 14.  Apply leave page filters include validation.
    // 15.  Reverted casual leave functionality exists.
    // 16.  CL/EL applied for rejected timesheets auto-approve without admin/partner intervention.
    // Attendance Flow
    // 1.     Admins/partners can view attendance under HR > Attendance, filtering by name and date range.
    // 2.     Date range validations prevent invalid selections.
    // 3.     Attendance reports are exportable to Excel.
    // 4.     Attendance updates dynamically based on timesheets and leave entries.
    // 5.     Attendance statuses include Present (P), Travel (T), Casual Leave (CL), Exam Leave (EL), Holidays (H), Sunday (W), and Rejected Timesheet (R).
    // 6.     Attendance columns: Employee Name, Staff Code, Role, Month, Year, Dates (1-31).
    // 7.     'Total Working Days' links to detailed attendance, exportable to Excel.
    // 8.     Attendance records display from the module start date (October).
    // Teams Flow
    // 1.     Admins can deactivate users by setting a leaving date; users then cannot log in.
    // 2.     Admins can mark users as rejoining for the same or a new role.
    // 3.     Rejoining users can submit timesheets without gaps/errors in validation.
    // 4.     New roles after rejoining or promotion link old and new codes, retaining data access.
    // Notifications
    // 1.     Notifications sent by admins appear in users' tabs, color-coded for read/unread status.
    // Assignments
    // 1.     Assignment creation excludes inactive users from the team member list.
    // 2.     Closed assignments hide in selection fields and reports.
    // 3.     Users receive assignment details via email upon creation or closure.



    // Pooja Kumari or Harish, Before starting the test, please sync up with me once



    // There are 3 tasks in QA that need to be tested


    // I have reviewed all the points, and since the client has changed the requirements, I have implemented them according to the new requirements.

    // There are 4 tasks in QA that need to be tested starting tomorrow

    // There are 4 tasks in QA that we can start testing from tomorrow
    // There are 4 tasks in QA that can be tested starting tomorrow
    // I need to test the attendance report on VSAlive urgently
    // can i meet now Pooja Kumari and Harish
    // I have added some tasks to In QA that need to be tested starting tomorrow
    // I have added 4 tasks to In QA that need to be tested starting tomorrow

    // Yamuna Expressway Industrial Development Authority

    // If someone has login with admin login in VSA then please logout for half an hour

    // This is urgent because the client has requested to make it live within 2 to 3 days

    // All 7 tasks have been QA passed. Atishay Jain, please let me know when these can be deployed.

    // Send the code for both vsademo and vsalive, and send the database only for vsademo

    // Send the code for both vsademo and vsalive, and send the below all tables only from vsalive

    // Send the code for  vsademo and below listed tables

    // Assignment id HUM100765 was mistakenly closed by Kartik. Please reopen it

    // I just want to know when I will receive this mail

    // Please send the code and database for vsademo

    // 1.Tasks VS-395, VS-367, VS-348, VS-346 has been uploaded to vsademo, and functional testing has been completed 
    // 1.Test descreption added on jira for VS-395, VS-367, VS-348, VS-346

    // Send the code for both vsalocal and vsalive, and send the database only for vsalocal
    // This is not required for testing. Please ignore it
    // I have already spoken to Pooja; I can join after lunch

    // jab kisi ko call karo aur vo call n uthaye to ye message kare teams per
    // Simmi Ma’am, I tried reaching out to Pooja, but she seems unavailable at the moment

    // Simmi Ma'am, I kindly request you to ensure that all the tasks currently in QA are tested.

    // I have recieved multiple partner adding on assignment task so i need to discuss on this point so please give me meeting time so that i will create meeting with you 

    // You had asked about the estimated days. The total estimated duration for all the approved tasks I have is 10 days. Additionally, the 'multiple partner adding on assignment' task is estimated to take 10 days. So, the total estimate comes to 20 days. Okay
    // All Affected Points for Assignment Task Updates

    // You need to test the data in the Excel file and ensure that the ascending/descending icons are functioning correctly on the date column only

    // Can we deploy these tasks to production

    // Atishay Jain, have you reviewed this? If you have checked it, please grant me permission
    // If you have checked it, please grant me permission

    // Dear Pooja, 'Miss' is used for females, so please check 'Ms' for female users, not male users.

    // As per client discussion, the client only instructed me to replace 'Miss' with 'Ms' wherever it appears. So, I have made the replacement. 'Miss' was only used for female users, and for male users, 'Mr.' was already in place. The client did not mention any changes regarding male users.

    // 3.When the user submitted their timesheet, an error occurred. I have checked and fixed the issue.
    // 4.There was an attendance data issue on January 19. I have resolved it

    //         Dear Atishay,

    // I understand that the required changes involve applying conditions and restructuring the data for other partners in an existing another table. To achieve this:

    // 1.Changes will be applied on the Assignment Creation page.
    // 2.Changes will be applied on the Add Timesheet page.
    // 3.Changes will be applied in the Partner Section on the Assignment Details page.
    // 4.Changes will be applied on the Independence Confirmation page.

    // Total Development Time: 5 Days.

    // Thanks & regards,
    // Shahid Raza (7488952139)

    // After the QA passed the task, I received a bug from the client side on task VSA-304.  bugs is when admin update profile of rejoined users after that admin get warning message like Please delete save timesheet after leaving date


    // After the QA passed the task, I received a bug from the client side on task rejoining module. The issue occurs when the admin updates the profile of rejoined users, display a warning message: 'Please delete saved timesheet after the leaving date'.

    // I have checked and found that when a user has rejoined and has saved timesheet data, a warning message appears when the admin updates the user's profile.

    // Both of these tasks have been updated on VSA

    // can we deploy this tasks in the production

    // I would like to speak with you. Please let me know if now is a good time

    // I want to talk to you. Can we talk now

    // Yes, this still exists, and it is correct. However, after rejoining, when the admin updates the user's profile, such as their qualification, the warning message is still displayed in that case
    // Yes, Pooja Kumari, it is correct
    // I have some personal work.
    // i have reviewed the entire HR query flow.
    // After the QA passed the task, I received a bug from the client side on  task VS-395. so i am working on it.
    // After the QA passed the task, I received a bug from the client side on task VS-395. I am currently working on fixing it

    // I have already informed Simmi regarding this bug

    // Atishay Jain,please get the tasks in QA completed. There are 4 tasks currently in QA

    // Hopefully within 1 week

    // the approver is still Harish which is why it wasn't visible in Simmi's ID. You had selected it in the dropdown but didn’t save it, so it didn’t reflect in Simmi’s ID Please check again

    // I have checked this, and everything is fine except the mail integration, which is not implemented. I will integrate it

    // when can we connect for functional testing of the bugs reported 

    // We can connect after 4:30 PM for the functional testing of the reported bugs. Let me know if that works for you

    // I have fixed the timesheet issue bugs, so I need to deploy them on VSA. Please grant me permission


    // I just want to inform all of you that I have resolved the timesheet bugs, and it's ready for deployment. I just want to ask whether it should go through the QA process or be deployed directly to live


    // Dear Sir/Ma'am,

    // I just want to inform all of you that I have resolved the timesheet bugs, and it's ready for deployment. I just want to ask whether it should go through the QA process or be deployed directly to live.

    // Thanks & regards,
    // Shahid Raza (7488952139)

    // I have implemented mail integration, and now the partner will receive a notification after editing the timesheet request



    // maam leaving date ke baad user can not login isiliye koi bhi leave apply nahi kar sakta hai 

    // Please create both tasks on GRC so that I can pick them
    // client want to redirect url on open leave page when partner click on hare button on mail 
    // I have attached all QA-passed tasks that are currently pending in UAT 
    // I have completed this task and moved it to QA
    // Belated Happy birthday @Shahid Raza on 01-01-2026
    // I have completed this task, moved it to QA, and updated the description on Jira
    // since there is delay in code merge of KYC, we can pick up VSA tasks in QA ?
    // Shahid Raza where are we on this
    // where are we on the ticketing system??
    // I am working on a data-related bug, so there is no need to test it. I have already discussed this with Prashant
    // I just want to know if I should pick up the new bug reported via email or continue working on my existing in-progress task

    // I am moving the status from IN UAT to Done because this code has been reviewed by Prashant Sir

    // I am moving the status from IN UAT to Done because this is an old task and it is running well on VSA
    // can we have SAME pw for all

    // I have completed this task and placed in QA 
    // Pooja Kumari, I have already explained that the user cannot log in after the leaving date, so they cannot submit the timesheet
    // As per the client's discussion, I have already implemented that when a rejected timesheet is resubmitted, the total hours will be adjusted accordingly (reduced or increased) so this is not required.

    // I have checked this, and everything is fine except the mail integration, which is not implemented. I will integrate it
    // the approver is still Harish which is why it wasn't visible in Simmi's ID. You had selected it in the dropdown but didn’t save it, so it didn’t reflect in Simmi’s ID Please check again
    // Steps:


    // 1.	All mandatory fields are required.
    // 2.	Profile picture should be in .jpg, .jpeg, or .png format.
    // 3.	Personal Email ID should be valid.
    // 4.	Mobile Number should contain only digits, not text.
    // 5.	Emergency Mobile Number should contain only digits, not text.
    // 6.	Date of Birth should not be in the future.
    // 7.	Aadhaar Number should contain only digits, not text.
    // 8.	PAN Card Number should be valid.
    // 9.	Mother's Mobile Number should contain only digits, not text.
    // 10.	Father's Mobile Number should contain only digits, not text.
    // 11.	Bank Account Number should contain only digits, not text.
    // 12.	Joining Date should not be in the future.
    // 13.	Leaving Date should not be in the future.
    // I have moved the status from In Progress to Code Review. Please check once
    // Apply casual leave and exam leave, and verify the saved timesheet after the leave is applied
    // I have moved the task VS-500 to Code Review.
    // I have moved this task to In UAT. Please check once
    // Hi, Shahid here.
    // I have completed all 3 out of 3 tasks (VSA). I would like to discuss one task with you.
    // I am available on March 6. Let me know if that works for you.
    // there are 3 new task in VSA please pick them up
    // I have completed all 3 out of 3 tasks. I would like to discuss one task with you.
    // Due to network issue I can't hear your voice properly
    // i have left comments for simmi and Atishay Jain, please check once.
    // i have already moved this task in Code review and manaly maine jo 4 ya 5 place per hi work kiya hai jo unhe chahiye tha iske alawa rest of palce maine koi test nahi kiya aur nahi koi implementation  
    // All UAT-passed tasks have been deployed on VSA
    // I am working on it, and it will be deployed by the end of the day.
    // The appointment letter is not in use, so it is only visible on the admin dashboard and not to any other users
    // If a user is rejoined and does not have a leaving date for rejoining, the admin can activate or deactivate the user. However, if the rejoined user has a leaving date after rejoining, the admin cannot activate or deactivate them
    // Before starting testing on this task, please connect with me
    // Please review this task once and let me know what needs to be done.
    // We need to discuss VS-456 and VS-412
    // Can we join now ?
    // i have moved some tasks To QA.
    // you have created this task in vsa please look once 
    //  I have received the KT from Shahid for 3 High priority task, Do let me know When can I proceed with the testing. To test these 3 points it will take complete 1 day.
    // yes but if in cas we needed Pooja Kumari for any working in DFCC then ETA might change, no issues in that
    // This was not a database issue but a filter issue specifically for rejoining and promotion users
    // We can meet at 01:10.

    // currently working on the VSA download issue task and verifying it on the demo server. Please refrain from testing or making modifications. Pooja Kumari cc simmi
    // Before starting testing on this task, please connect with me

    // We can test only these assignments: BIR100318, BIR100405
    // please confirm whether VSA has foreign clients or not.
    // Please confirm whether VSA has foreign clients or not so that we can handle mobile number validation accordingly
    // I have to deploy UAT Passed tasks on vsa, (VS-518, 510, 486)
    // I have to deploy In Progress tasks on vsademo, (VS-518, 510, 486)
    // We are ready for VSA deployment. Can we deploy it today ? .
    // Atishay Jain, task numbers VS-124, VS-501, and VS-290 are basically related to staff code (Promotion and Re-joining Module). I have already discussed these tasks in detail when I was developing. But currently simmi ma'am wants to do some changes for that so please send me the updated requirement.
    // Atishay Jain, task numbers VS-124, VS-501, and VS-290 are basically related to staff code. I have already discussed these tasks in detail when I was developing. But currently Simmi mam wants to do some changes for that we need to discuss this point with client. Please confirm if it is needed, if yes then please connect with client & send me the updated requirement

    //## VSA Portal Glitch  ```/
    // The issue might be because of network connectivity and as discussed it is working now.
    // Vsa portal login problem for more details pls open the attachment file.
    // The same has been implemented. Please check and confirm.
    // Do let me know in case of any issue.
    // The same will be implemented by EOD
    // I will deploy it on demo by EOD
    // This is a gentle reminder to you.
    // I am writing to bring to your attention an issue regarding the submitted timesheet. The value entered in the "Filled Day column is exceeding the upper limit,  Kindly look into this matter ASAP.
    // Attached relevant screenshot for your reference.
    // I had already sent it to Atishay
    // I had sent it to Atishay
    // As per the client's discussion, In case there is a change in designation, but the individual is mapped to a particular assignment then his right related to that assignment should not change staff code till the assignment is over.

    // I need to update the task on VSAdemo. Please confirm if I can proceed with cleaning your data
    // Are you available right now? If yes, let’s complete the handover process
    // Please let me know if you're available so that we can complete the handover process
    // Please send me the URL if this project is live
    // Is there any meeting now ?
    // I hve to book meeting wth ashish
    // In case of any other details needed for these projects please feel free to ping me.
    // Simmi, there are two tasks.
    // Simmi, these are the two tasks
    // Simmi, these are the two tasks
    // Ma'am, I had to stop this task because I needed to clear this one
    // I had to stop this task because the VS-254 task was urgent
    // As discussed, the issue has been resolved.
    // I have not received my increment letter yet. I kindly request you to please share it with me
    // Sukh working in email space issue,
    // replace "debtors" with "Entries / Rows"
    //  I am working in GRC, some data need to be correcte as asked by Atishay Jain. Need to complete it till 11
    // Please connect with me whenever you are free ```/
    // Alright, I’ll keep that in mind next time
    // I had a discussion with Atishay today, and I will be starting this task now
    // 222222222222222222222222222222222222222222222222222222222222222222222

    // I discussed with Atishay today, and I’m picking up this task now
    // I will be picking up this task.
    // I am starting work on this task.
    // Pooja Kumari is this done?
    // in one of the role it is pending
    // Yes, Its done yesterday
    // Yes, tomorow will be copleted 
    // before starting the testing, please connect with me once, as KT will be required for this task Pooja Kumari and simmi
    // mam but it has 30 points & I have to test it in 3 different roles also I need to test for few different scenarios
    // Pooja Kumari reached out to you Shahid Raza
    // Pooja Kumari Needs KT for a few points. Pls take out time
    // Pooja Kumari, could we please connect now if you are available 
    // I have explained task 511, so please leave a comment on it
    // I have explained task 511. Could you please leave a comment on it
    // Alright, I’ll keep that in mind next time ...\
    // this was created by you, could you please delete it
    // Deployment has been completed on VSA, and all deployed tasks are listed below
    // Deployment has been completed on VSA, and all deployed tasks are listed hare 
    // There is one more change in figma for user management will add that too related to permissions.
    // I am just going to add comments on jira
    // Akshita Sharma have you listed all this issues on teams
    // The tasks is currently in UAT. Kindly take a moment to review it
    // The tasks is currently in UAT. please review it.
    // It is completed now
    // This has been completed
    // the tasks VS-500, VS-518, VS-521, and VS-456 are urgent. We need to prioritize testing for these
    // As per Sukh Bahadur's discussion, this task is running correctly on the live environment, but it's throwing an error on VSAdemo due to the S3 connection
    // There are around 7 tasks in QA that need to be tested
    // Modification on Adding Multiple timesheet module  
    // I have moved task VS-123 to IN QA.
    // I have discussed with Atishay and all the assigned tasks in UAT have been completed. Atishay has asked me to proceed with the deployment, so I’m currently working on it

    // Pooja Kumari, please explain the flow to Sauma. She’s facing issues because the flow isn’t clear to her, and I’m unable to help right now as I’m working on an urgent task. cc Atishay Jain
    // I have already explained her & currently I am also working on KGS task 
    // this is just for your information. I am sharing the screenshot of my leave for your reference. 
    // simmi ma'am I have not yet received the KRA mail content.
    // , I’ve received the KGS dashboard recording, but I don’t have access to view the video. Kindly provide me with the necessary access.
    // No, this will be completed tomorrow by half morning.
    // 3 things I have checked as mentioned by Vinita that she has added in APK & working fine;
    // But I am checking few other points as well, which I mentioned will take some more time.
    // Please confirm should I complete testing or pause here & start VDR?
    // I am ready to deploy the VSA task. Can we proceed
    // I am currently working on the VSA task and pausing the KGS dashboard report task for now
    // Please send me all these tables from VSAlive
    // Ok prashant we have already given a due date so align sukhbahadur if possible
    // I am ready to deploy on VSA. Can i deploy it Atishay Jain
    // I am sharing the code with Sukh Bahadur to deploy on the demo. After the update, I will inform here
    // I am working on the VSA issue and pausing work on the Dashboard report
    // Thanks and noted
    // Can we deploy KRA module on KGS live
    // I have checked on live as well, everything is fine.
    // for birthday Thank you so much for the wonderful wishes!
    // I have already explained it to Pooja
    // Pooja, please call me whenever you are free
    // I have created the VSA task (ID 332) and deployed it on vsademo. We can test it now
    // It will take me 2 days to complete, excluding the mail-related point
    // The issue has been resolved, please check and let me know in case if it still persists.
    // I received a call from the client, and he assigned me a task which is already solved on VSAdemo but is pending deployment on VSA. I also checked in the Jira backup, and this task has already passed UAT
    // Atishay Jain, I have created all the UAT passed tasks on GRC. Please check from your side
    // and i will be working on VSA for the next 2 days, so after 2 days i will take 3 days 
    // Ma’am, just to confirm, in the meeting, do I need to show only the KPI or include the chart too.
    // Simmi Ma’am, could you please send an email to Atishay so that I can work on dashboard chart.
    // Atishay Jain I’m picking up this task. simmi ma’am  I may not be able to confirm the chart-related data at the moment.
    // Atishay Jain, 4 tasks deployed on vsa and I have already sent tasks name to you. cc prashant 
    // Pooja Kumari, All bugs completed please check now 
    // simmi the VSA task will take around 5–6 days, so even with stretching, it won’t be completed sooner. As of now, the VSA work needs to be done on an urgent basis Shahid might handle it midway.
    // I have checked the chart and would like to discuss it with you. Could you please connect with me
    // the Cash Flow chart has been implemented as per the meeting video and after that we have approved with shivam 
    // simmi please provide me the access for the recording I have sent
    // please let me know the priorities,  should I focus on the dashboard bugs or this issue first. Atishay Jain simmi, cc prashant
    // should I continue working on the dashboard or switch to VSA? I’m currently working on the dashboard
    // I can not pick the Admin Query task without a proper description. Please update the description, sukhbahadur, so that after implementing the task I can assign it to Pooja Kumari cc prashant, simmi 
    // inform the person who created it.

    // Salary Should be encrypted/decrypted in the system

    // What is the process for payroll calculation?

    // What is the process for generating the payslip?

    // Will the payslip be editable manually or not ?

    // How many leaves are considered paid and unpaid?

    // Is there any probation period for employees? If yes, how is payroll handled during probation?

    // Will the payroll rules remain the same for all employees or will they differ based on designation/role?

    // What will be the payroll cycle — 25th to 26th or 1st to 30th?

    // If weekly timesheets are submitted, how should they be integrated with payroll?

    // If a casual leave is not approved, how should it be handled in payroll?

    // How should payroll be managed when leaves are reverted (revert leave functionality)?

    // How should payroll be managed when timesheets are rejected ?

    // In case of a promotion, will the salary be revised or remain the same?

    // In case of rejoining, will the salary be revised or remain the same?

    // Is check-in required, If yes, check in connected or not to payroll calculations?

    // Is check-out required, If yes, check in connected or not to payroll calculations?

    // Will check-in/check-out be available on the web or mobile app?

    // What all functionalities should be included in the mobile app?

    // is half-day functionality or not if yes, how to mange it?

    // is comp-off leave or not?

    // If a user checks in or checks out late, how to mange in that case?

    // What will be the rules for Saturday for staff, managers, and partners?

    // If a user fills the timesheet for the previous day, how should that be handled?

    // If a user forgets to check in, in that case how to manage it ?

    // If a timesheet is rejected, how should payroll be adjusted?

    // If a user exits the organization on a specific date, how should final payroll be handled?

    // What will be the payroll approval workflow? (For example: HR approval → Final approval → Accountant approval)
    // Having network issue at my end


    // I need the Admin Query description so that I can pick up this task. Currently, only the OMS query description is available
    // Is there an appointment letter or not?
    // Is there an increament letter or not?
    // 28.Is there an appointment letter or not?
    // 29.Is there an increment letter or not?
    // 30.Is the long weekend applicable or not? If yes, how should it be managed?
    // 31.How many leaves does a user get in a year?
    // 32.Blockage: If a leave is not approved and the payslip is generated, will it be auto-approved on the last day of the month, or what will be the process?
    // 33.Will there be an add-on system to allow users to fill timesheets for the previous month?
    // 34.If the payslip is generated and later the user submits a timesheet that gets rejected, how should it be handled?
    // 35.Please confirm the payroll generation components such as PF, TDS, etc.
    // 36.If a user takes an advance amount, how will that amount be deducted from their salary?
    // 37.Is the bonus applicable to users or not?
    // Should I start working on this, or should I wait for Shivam’s confirmation?
    // Please confirm whether I should proceed with this task or wait for Shivam’s approval
    // I currently don’t have any pending tasks. Please let me know which module I should work on next.
    // I currently do not have any pending tasks. Please let me know which tasks I should work on next.
    // I have discussed it with prashant. Weekends and holidays should be marked as ‘W’ and ‘H’ and Also in long weekend.
    // should I keep a meeting with kgs team at 3 for KT
    // But eta remains same
    // All queries resolved prashant,
    // The Invoice date cannot be before or after the visiting period dates. If any invoice of the said period is raised then the approval limit for food/Travel will be zero. = If dates fall out of travel date show = Null / Not Applicable 
    // One bug has been resolved and the remaining bugs are still pending
    // any update on close and archive TC status?
    // prashant did you meet Kapil. I need to share ETAs on Monday. End of month?
    // We still need to clarify a few points, and after that, we will be able to estimate the effort level. But this will take time at least 10–15 days (not confirmed yet).
    // Tripti was asking about its deployment date ?
    // These points have been discussed between prashant and me. We need to discuss these points.
    // Shahid Raza there are 3 new task in VSA please pick them up
    // Pooja Kumari there is also a task pending to test in VSA, please pick it up as per your availability
    // maam Please check the OMS Query list now. I have hidden the Audit Query and Data Analytics Query.If you find any issues, please leave a comment here
    // When an other partner is added from the assignment view page, sometimes it gets added successfully, and sometimes a ‘Page Expired’ issue occurs






    // 222222222222222222222222222222222222222222222222222222222222222222222

    // vsalocal, vsademo, bugs ```start
    // vsalocal, vsademo, vsalive ```start
    // vsalocal, vsademo ```start 
    // vsalocal, ```start

  }
}
