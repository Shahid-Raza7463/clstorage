<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sentence extends Command
{
    public function client_list1()
    {

        // 1.The client wants to know the active and inactive users in the attendance report.
        // 2.If a user does not submit their timesheet continuously for one month, the attendance record should reflect this.
        // 3.The client wants attendance report data from April to September. Currently, the data is only available from October because the attendance module has been running since then.


        // Yes,I have some urgent to-do list tasks that need to be completed on a priority basis and ⁠simmi maam i can not do preparion for all vsa flow at 6:30 Pm meeting  
        // As per the client's discussion, this task is not a priority at the moment, so I am ignoring it for now 

        // You mean our meeting will be at 7 PM, right ?


        //! All task


        // Assignment Budgeting and Assignment Mapping tab functions are merged into 1 single tab "Add Assignment"
        // In case of new joining, attendance for the month of joining will be created from the date of joining. Previously in case any person is joining in the mid month attendance for the same will not be captured for the joining month.
        // Since attendance module was implemented in the month of oct so data from April to Sept needs to be included in the reports.


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

        // Send the code for both vsalocal and vsalive, and send the database only for vsalocal

        // Send the code for both vsalocal and vsalive, and send the below all tables only from vsalive

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

        // After the QA passed the task, I received a bug from the client side on  task VS-395. so i am working on it.
        // After the QA passed the task, I received a bug from the client side on task VS-395. I am currently working on fixing it

        // I have already informed Simmi regarding this bug











        // 222222222222222222222222222222222222222222222222222222222222222222222

    }
}
