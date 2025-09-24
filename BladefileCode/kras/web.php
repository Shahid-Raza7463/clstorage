<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataanalyticsController;
use App\Http\Controllers\AssignmentremindersystemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CyclingeventController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\CourierinoutController;
use App\Http\Controllers\ClauserestrictingController;
use App\Http\Controllers\PerformanceevaluationformController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\DeclarationformController;
use App\Http\Controllers\HrtaskController;
use App\Http\Controllers\MailTemplateController;
use App\Http\Controllers\AuditticketController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ClientSpecificIndependenceController;
use App\Http\Controllers\StaffappointmentletterController;
use App\Http\Controllers\NeftController;
use App\Http\Controllers\PenalityController;
use App\Http\Controllers\AdminitrController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\QuestionpaperController;
use App\Http\Controllers\SecretarialTaskController;
use App\Http\Controllers\ExamAnswerController;
use App\Http\Controllers\MeetingfolderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\IncrementletterController;
use App\Http\Controllers\AtrController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IfcfolderController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\IfcController;
use App\Http\Controllers\AssignmentplanningController;
use App\Http\Controllers\AssetprocurementController;
use App\Http\Controllers\TravelfeedbackController;
use App\Http\Controllers\EmployeeonboardingController;
use App\Http\Controllers\IcardController;
use App\Http\Controllers\ArticleonboardingController;
use App\Http\Controllers\CandidateboardingController;
use App\Http\Controllers\AssignmentevaluationController;
use App\Http\Controllers\DraftemailController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\StaffassignController;
use App\Http\Controllers\LeavetypeController;
use App\Http\Controllers\ContractandSubscriptionController;
use App\Http\Controllers\ApplyleaveController;
use App\Http\Controllers\StaffdetailController;
use App\Http\Controllers\RecruitmentformController;
use App\Http\Controllers\BackEndController;
use App\Http\Controllers\ClientuserloginController;
use App\Http\Controllers\CreditnoteController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\OutstationconveyanceController;
use App\Http\Controllers\TabController;
use App\Http\Controllers\LocalconveyancesController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\QuestionnaireroundoneController;
use App\Http\Controllers\ArticlefileController;
use App\Http\Controllers\PbdController;
use App\Http\Controllers\FullandfinalController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ReimbursementclaimController;
use App\Http\Controllers\HbrController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TeammemberController;
use App\Http\Controllers\LetterheadController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TeamloginController;
use App\Http\Controllers\EmployeereferralController;
use App\Http\Controllers\AppointmentletterController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\OutstandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentlistController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TeamprofileController;
use App\Http\Controllers\AnnualIndependenceDeclarationController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\KnowledgebaseController;
use App\Http\Controllers\AssignmentbudgetingController;
use App\Http\Controllers\Client\MisController;
use App\Http\Controllers\AdminmisController;
use App\Http\Controllers\AssignmentmappingController;
use App\Http\Controllers\Student\StudenthomeController;
use App\Http\Controllers\Student\StudentExamController;
use App\Http\Controllers\TeamlevelController;
use App\Http\Controllers\CompanydetailController;
use App\Http\Controllers\GnattchartController;
use App\Http\Controllers\TrainingassessmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JobapplicationController;
use App\Http\Controllers\TravelformController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\AssignmentconfirmationController;
use App\Http\Controllers\AssignmenttemplateController;
use App\Http\Controllers\AssetasignController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\TimesheetrequestController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\AssetticketController;
use App\Http\Controllers\AssignmentconfirmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChecklistanswerController;
use App\Http\Controllers\StaffrequestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClientLoginController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Client\ClienthomeController;
use App\Http\Controllers\InformationresourceController;
use App\Http\Controllers\Client\InformationController;
use App\Http\Controllers\Client\InternalauditController;
use App\Http\Controllers\Client\ItrController;
use App\Http\Controllers\Client\ClientAtrController;
use App\Http\Controllers\PerformanceappraisalController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DiscusesController;
use App\Http\Controllers\DirectapplicationController;
use App\Http\Controllers\EmployeepayrollController;
use App\Http\Controllers\ExportController;
use App\Models\Attendance;
use App\Models\Teammember;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\LinkedInController;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\RecruitmentController;
use App\Models\Employeepayroll;
use App\Http\Controllers\RacreateController;
use App\Http\Controllers\ApimasterController;
use App\Http\Controllers\FiledocumentController;
use App\Http\Controllers\AuditprocedureController;

use App\Http\Controllers\FinancialstatementController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\QuestionTemplateController;
use App\Http\Controllers\CheckinsettingController;
use App\Http\Controllers\RecordAdditionController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CodeofconductController;
use App\Http\Controllers\KrasController;
use App\Http\Controllers\OfferLetterController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showloginForm']);
Route::get('/forgetpassword', [App\Http\Controllers\Auth\ClientLoginController::class, 'forgetPassword']);
Route::group(['middleware' => 'throttle:4,1'], function () {
  Route::post('/forgetpassword/store', [App\Http\Controllers\Auth\ClientLoginController::class, 'forgetpasswordStore']);
});


Route::get('/reset/newpassword/{id}', [App\Http\Controllers\Auth\ClientLoginController::class, 'newPassword']);
Route::post('/newpassowrd/store/{id}', [App\Http\Controllers\Auth\ClientLoginController::class, 'passwordStore']);
Route::get('/privacypolicy', function () {
  return view('privacypolicy');
});
Route::get('/run-unallocated-checked-in-mail', function () {
  $exitCode = Artisan::call('UnallocatedCheckedIn:Mail');
  return 'Command executed with exit code.. ' . $exitCode;
});
/*Route::get('/queuework', function () {
  $exitCode = Artisan::call('queue:work');
  return 'Command executed with exit code.. ' . $exitCode;
});
Route::get('/run-late-checked-in-mail', function () {
    $exitCode = Artisan::call('LateCheckedIn:Mail');
    return 'Command executed with exit code ' . $exitCode;
});*/
Route::get('/calculate-attendance', [HomeController::class, 'calculateAttendance']);

//Route::get('/candidateonboardingform/kgs', [HomeController::class, 'candidateonboardingFormKgs']);
Route::get('/candidateonboardingform/kgs/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormKgs']);
Route::get('/payment/success', [HomeController::class, 'payment_success']);

Route::get('/offerletteremail', [HomeController::class, 'offerletterremainder']);

Route::get('/candidateonboardingform/capitall/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormCapitall']);
Route::get('/candidateonboardingform/kgs-advisors/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormKgsAdvisors']);
Route::get('/candidateonboardingform/womennovator/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormWomennovator']);
Route::get('/candidateonboardingform/intern/kgs/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormInternKgs']);
Route::get('/candidateonboardingform/intern/capitall/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormInternCapitall']);
Route::get('/candidateonboardingform/intern/kgs-advisors/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormInternKgsAdvisors']);
Route::get('/candidateonboardingform/intern/womennovator/{encryptedEmail?}', [HomeController::class, 'candidateonboardingFormInternWomennovator']);
Route::get('/check-email', [HomeController::class, 'checkEmail']);


Route::get('/offerletter/create/{id}', [OfferLetterController::class, 'create']);
Route::post('/offerletter/store', [OfferLetterController::class, 'store']);
Route::get('/offerletter/view/{id}', [OfferLetterController::class, 'view']);
Route::get('/offerletter', [OfferLetterController::class, 'index']);
Route::get('/offerletter/edit/{id}', [OfferLetterController::class, 'OfferletterEdit']);
//Route::get('extend/offerletter/edit/{id}', [OfferLetterController::class, 'ExtendofferletterEdit']);
Route::post('/offerletter/update/{id}', [OfferLetterController::class, 'UpdateOfferletter']);
Route::post('/offerletter/statuss/{id}', [HomeController::class, 'OfferletterStatus']);
Route::post('/offerletter/status/{id}', [OfferLetterController::class, 'OfferletterStatus']);
Route::post('/offerlettersend/{id}', [OfferLetterController::class, 'Offerlettersend']);
Route::get('/offer/letter/view/{id}', [HomeController::class, 'OfferletterView']);
Route::get('/offerletteremail', [HomeController::class, 'offerletterremainder']);
Route::post('/offerletterdate/update/{id}', [OfferLetterController::class, 'OfferletterDate']);




//assignmentbaseconfirmation
Route::get('/confirmationAccept/', [AssignmentconfirmationController::class, 'confirmationAccept']);
Route::get('/assignmentconfirmationauthotp',  [AssignmentconfirmationController::class, 'confirmationauthotp']);
Route::post('/assignmentconfirmationotp', [AssignmentconfirmationController::class, 'otpapstore'])->name('confirmationotp');
Route::post('/assignmentconfirmationotphide', [AssignmentconfirmationController::class, 'otpapstore_hide'])->name('confirmationotp');
Route::post('assignmentconfirmation/',   [AssignmentconfirmationController::class, 'confirmationConfirm']);
Route::post('assignmentconfirmationhide/',   [AssignmentconfirmationController::class, 'confirmationConfirmhide']);
Route::post('confirmation/confirm',   [AssignmentconfirmationController::class, 'confirmationConfirm']);

Route::get('/form/{url}', [HomeController::class, 'questiontemplateFormf'])->where('url', '.*');
Route::post('/questiontemplateform/store', [HomeController::class, 'FormTemplatestore']);

Route::get('/authforgetpassword', [App\Http\Controllers\Auth\LoginController::class, 'forgetPassword']);
Route::post('/authforgetpassword/store', [App\Http\Controllers\Auth\LoginController::class, 'authforgetpasswordStore']);

Route::get('/authreset/newpassword/{id}', [App\Http\Controllers\Auth\LoginController::class, 'newPassword']);
Route::post('/authnewpassowrd/store/{id}', [App\Http\Controllers\Auth\LoginController::class, 'passwordStore']);


Route::post('/candidateonboarding/store', [HomeController::class, 'store']);
Route::get('/questionnaireroundone', [App\Http\Controllers\QuestionnaireroundoneController::class, 'showquestionnaireForm']);
Route::post('/questionnaireroundone/store', [App\Http\Controllers\QuestionnaireroundoneController::class, 'store']);
Route::get('/database', [HomeController::class, 'cron']);
Route::get('/cron', [HomeController::class, 'scheduler']);
//Route::get('/jobscheduler', [HomeController::class, 'jobScheduler']);

Route::get('/att', [HomeController::class, 'Att']);
Route::get('/timesheetreminder', [HomeController::class, 'timesheetreminder']);
Route::get('/holidayreminder', [HomeController::class, 'holidayReminder']);
Route::get('/update-attendance', [HomeController::class, 'UpdateAttendance']);
Route::get('/invoicereminder', [HomeController::class, 'invoiceReminder']);
Route::get('/timesheetduplicate', [HomeController::class, 'timesheetDuplicate']);
Route::get('/outstandingreminder', [HomeController::class, 'outstandingReminder']);
Route::get('/birthdayreminder', [HomeController::class, 'birthdayReminder']);
Route::get('/fullandfinalreminders', [HomeController::class, 'fullandfinalreminder']);
Route::get('/poachingreminder', [HomeController::class, 'poachingReminder']);
Route::get('/checkinreminder', [HomeController::class, 'checkinReminder']);
Route::get('/checkineveningreminder', [HomeController::class, 'checkineveningreminder']);


Route::get('/debtorconfirm/', [ConfirmationController::class, 'confirmationAccept']);
Route::get('/confirmationauthotp',  [ConfirmationController::class, 'confirmationauthotp']);
Route::post('/confirmationotp', [ConfirmationController::class, 'otpapstore'])->name('confirmationotp');
Route::post('confirmation/confirm',   [AssignmentconfirmController::class, 'confirmationConfirm']);
Route::post('confirmation/',   [AssignmentconfirmController::class, 'confirmationConfirm']);

Route::get('/ats', [HomeController::class, 'ats']);
//Route::get('/', [LoginController::class, 'index']);
// Articleonboardingform //
Route::get('/articleonboardingform/{encryptedEmail?}', [HomeController::class, 'articleonboardingForm']);
Route::post('/articleonboardingform/store', [HomeController::class, 'articlestore']);

Auth::routes();
Route::get('/adminlogin', [App\Http\Controllers\Auth\AdminLoginController::class, 'showloginForm']);
Route::post('/admin/loginstore', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::group(['prefix' => 'user'], function () {

//  Route::get('/home', [UserController::class, 'index'])->name('home');

//});
//Route::get('/student/login', [App\Http\Controllers\Auth\StudentLoginController::class, 'studentloginForm']);


Route::post('/student/loginstore', [App\Http\Controllers\Auth\StudentLoginController::class, 'studentlogin'])->name('student.login');
Route::post('student/logout', [App\Http\Controllers\Auth\StudentLoginController::class, 'logout'])->name('student.logout');

//Route::get('/student/register', [App\Http\Controllers\Auth\StudentLoginController::class, 'studentregisterForm']);
Route::post('/student/store', [App\Http\Controllers\Auth\StudentLoginController::class, 'StudentregidterStore']);

Route::group(['prefix' => 'students'], function () {
  Route::get('/home', [StudenthomeController::class, 'index'])->name('students.home');
  Route::get('/resetpassword/{id}', [StudenthomeController::class, 'resetPassword']);
  Route::post('/password/update/{id}', [StudenthomeController::class, 'passwordUpdate']);
  Route::resource('/studentexam', StudentExamController::class);
  Route::get('/thanks', [StudentExamController::class, 'examEnd']);
  Route::get('/result/{id}', [StudentExamController::class, 'studentResult']);
});



Route::get('/clientlogin', [App\Http\Controllers\Auth\ClientLoginController::class, 'showloginForm']);
Route::post('/client/loginstore', [App\Http\Controllers\Auth\ClientLoginController::class, 'login'])->name('client.login');
Route::post('client/logout', [App\Http\Controllers\Auth\ClientLoginController::class, 'logout'])->name('client.logout');
Route::get('/loginotp/{id}', [ClientLoginController::class, 'loginOtp']);
Route::post('/otp/store', [ClientLoginController::class, 'otpStore']);
Route::get('/otp/resend/{id?}',  [ClientLoginController::class, 'otpResend']);

Route::group(['prefix' => 'client'], function () {
  Route::get('/home', [ClienthomeController::class, 'index'])->name('client.home');
  Route::get('/switchaccount/{id}', [ClienthomeController::class, 'switchaccount']);
  Route::get('/clientfilelist', [ClienthomeController::class, 'clientFile']);
  Route::post('/clientfile/upload', [ClienthomeController::class, 'store']);
  Route::get('/clientfile/{id}', [ClienthomeController::class, 'getFile']);
  Route::post('/clientfolder/store', [ClienthomeController::class, 'folderStore']);
  Route::get('/folderlist/{id}', [ClienthomeController::class, 'folderList']);
  Route::get('/folderlist/destroy/{id}', [ClienthomeController::class, 'folderListDelete']);
  Route::get('/folderlist/requestdelete/{id}', [ClienthomeController::class, 'folderListRequest']);
  Route::get('/filelist', [ClienthomeController::class, 'fileList']);
  Route::get('/resetpassword/{id}', [ClienthomeController::class, 'resetPassword']);
  Route::post('/password/update/{id}', [ClienthomeController::class, 'passwordUpdate']);
  Route::get('/information', [InformationController::class, 'index']);
  Route::get('/informationlist/{id}', [InformationController::class, 'indexlist']);
  Route::get('/information/create/{id}', [InformationController::class, 'informationCreate']);
  Route::post('/information/store', [InformationController::class, 'informationStore']);
  Route::post('/information/updatestatus', [InformationController::class, 'updateStatus']);
  Route::get('/information/status',  [InformationController::class, 'informationstatusUpdate']);
  Route::get('/ilr/download/{id}', [InformationController::class, 'ilrDownload']);
  Route::get('ilrbank', [InformationController::class, 'ilrbank']);
  Route::get('ilrhouse', [InformationController::class, 'ilrhouse']);
  Route::get('ilrsalary', [InformationController::class, 'ilrsalary']);
  Route::get('ilraddinformation', [InformationController::class, 'ilraddinformation']);
  Route::post('ilrsalary/store', [InformationController::class, 'ilrsalaryStore']);
  Route::post('/ilraddinformation/store', [InformationController::class, 'ilraddStore']);
  Route::post('ilrhouse/store', [InformationController::class, 'ilrhouseStore']);
  Route::post('ilrbank/store', [InformationController::class, 'ilrbankStore']);


  Route::get('/ilrlist', [InformationController::class, 'ilrlist']);
  Route::post('/ilrt/store', [InformationController::class, 'ilrtStore']);
  Route::get('/information/first',  [InformationController::class, 'informationFirst']);
  Route::get('/information/firstt',  [InformationController::class, 'informationFirstt']);
  Route::get('/ilralllist', [InformationController::class, 'ilralllist']);

  Route::post('/informationfolder/store', [InformationController::class, 'folderStore']);
  Route::post('/information/upload', [InformationController::class, 'informationUpload']);
  Route::get('/information/edit/question',  [InformationController::class, 'editrecords']);
  Route::post('/edit/question', [InformationController::class, 'editQuestion']);
  Route::get('/informationq/destroy/{id}', [InformationController::class, 'questionDelete']);
  Route::get('/informationquestion/destroy/{id}', [InformationController::class, 'answerDelete']);

  Route::post('ilraddinformationsecond/store', [ItrController::class, 'ilraddinformationsecondStore']);
  Route::post('ilraddinformationfirst/store', [ItrController::class, 'ilraddinformationfirstStore']);
  Route::post('ilraddinformationthird/store', [ItrController::class, 'ilraddinformationthirdStore']);
  Route::get('ilrdeduction', [ItrController::class, 'ilrdeduction']);
  Route::post('ilrdeduction/store', [ItrController::class, 'ilrdeductionStore']);
  Route::get('ilrbp', [ItrController::class, 'ilrbp']);
  Route::post('ilrbp/store', [ItrController::class, 'ilrbpStore']);
  Route::get('incomefromcapitalgains', [ItrController::class, 'income']);
  Route::post('incomefromcapitalgains/store', [ItrController::class, 'incomefromcapitalgainsStore']);
  Route::get('incomefromsources', [ItrController::class, 'incomefromsources']);
  Route::post('incomefromsources/store', [ItrController::class, 'incomefromsourcesStore']);
  Route::get('ilrpersonal', [ItrController::class, 'ilrpersonal']);
  Route::post('/ilrpersonalinformation/store', [ItrController::class, 'ilrperStore']);

  Route::get('ilrbank/edit', [ItrController::class, 'ilrbankEdit']);
  Route::post('ilrbank/update', [ItrController::class, 'ilrbankUpdate']);
  Route::get('ilrhouse/edit', [ItrController::class, 'ilrhouseEdit']);
  Route::post('ilrhouse/update', [ItrController::class, 'ilrhouseUpdate']);
  Route::get('ilrsalary/edit', [ItrController::class, 'ilrsalaryEdit']);
  Route::post('ilrsalary/update', [ItrController::class, 'ilrsalaryUpdate']);
  Route::get('incomefromcapitalgains/edit', [ItrController::class, 'incomefromcapitalgainsEdit']);
  Route::post('incomefromcapitalgains/update', [ItrController::class, 'incomefromcapitalgainsUpdate']);

  // Mis routes
  Route::resource('/mis', MisController::class);
  Route::get('/misimage',  [MisController::class, 'imageModal']);
  Route::get('/mis/details/{id}', [MisController::class, 'viewUpdate']);
  Route::post('/misclient/update', [MisController::class, 'misUpdate']);
  Route::get('/mis/destroy/{id}', [MisController::class, 'delete']);

  // Internalaudit routes
  Route::resource('/internalaudit', InternalauditController::class);
  Route::get('/actiontracker/index', [InternalauditController::class, 'actionTracker']);
  Route::get('/actionitem/index', [InternalauditController::class, 'actionItem']);
  Route::post('/actionitem/change/{id}', [InternalauditController::class, 'actionItemChange']);
  Route::post('/actiontracker/change/{id}', [InternalauditController::class, 'actionTrackerChange']);

  //Atr routes
  Route::get('/atrlist', [ClientAtrController::class, 'index']);
  Route::get('/atrview/{id}', [ClientAtrController::class, 'atrView']);
  Route::post('/atr/update', [ClientAtrController::class, 'atrUpdate']);
});


/*
|--------------------------------------------------------------------------
| Admin controller Routes
|--------------------------------------------------------------------------
|
| This section contains all admin Routes
| 
|
*/
Route::group(['middleware' => 'throttle:4,1'], function () {
  Route::get('verify/resend', [App\Http\Controllers\Auth\TwoFactorController::class, 'resend'])->name('verify.resend');
});
Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);

Route::get('/home', [BackEndController::class, 'index'])->name('home');
Route::get('/authotp',  [BackEndController::class, 'authotp']);
Route::post('/otpap/store', [BackEndController::class, 'otpapstore']);

Route::group(['middleware' => ['verified']], function () {
  //   Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');
  Route::get('/userprofile/{id}', [BackEndController::class, 'userProfile']);
  Route::get('/userlog', [BackEndController::class, 'userLog']);
  Route::post('/userprofile/update', [BackEndController::class, 'update']);
  Route::get('/activitylog', [BackEndController::class, 'activityLog']);
  Route::get('/useractivity/filtersection',  [BackEndController::class, 'Activityfiltersection']);


  Route::get('/traininglist', [BackEndController::class, 'traininglist']);
  Route::get('/training/list/{id}', [BackEndController::class, 'traininglistshow']);
  Route::post('/training', [BackEndController::class, 'training']);
  Route::post('/training/reminder', [BackEndController::class, 'trainingMail']);
  Route::get('/training/reminderall', [BackEndController::class, 'trainingreminderMail']);
  // Route::get('/authotp',  [BackEndController::class, 'authotp']);
  // Route::post('/otpap/store', [BackEndController::class, 'otpapstore']);
  Route::post('/clauserestricting/store', [BackEndController::class, 'clauserestricting_store']);
  Route::get('/clauseotp',  [BackEndController::class, 'clauseotp']);
  Route::get('/appointmentletters', [BackEndController::class, 'appointmentletter']);
  Route::get('/training/create', [BackEndController::class, 'create']);
  Route::post('/clientfolder/folderstore', [ClientController::class, 'folderStore']);
  Route::get('/folderlist/{id}', [ClientController::class, 'folderList']);
  Route::get('/clientfolderlist/destroy/{id}', [ClientController::class, 'folderDestroy']);
  //Tab routes
  Route::resource('/tab', TabController::class);

  // question Template 
  Route::post('questiontemplate/store', [QuestionTemplateController::class, 'store']);
  Route::get('questiontemplate', [QuestionTemplateController::class, 'index']);
  Route::get('formget/geturl', [QuestionTemplateController::class, 'getUrl']);
  Route::post('question/store', [QuestionTemplateController::class, 'QuestionTemplate']);
  Route::get('/question/list',  [QuestionTemplateController::class, 'questionshow'])->name('question.getlist');
  Route::get('question/delete/{id}', [QuestionTemplateController::class, 'deleteQuestion']);
  Route::get('questiontemplate/delete/{id}', [QuestionTemplateController::class, 'questiontemplateDelete']);
  Route::get('question/edit/{id}', [QuestionTemplateController::class, 'editQuestion']);
  Route::get('questiontemplate/question/view/{id}', [QuestionTemplateController::class, 'QuestiontemplateData']);
  Route::post('/formtemplate/mail',  [QuestionTemplateController::class, 'formTemplateMail']);
  Route::get('/formtemplate/fillform/list/{id}', [QuestionTemplateController::class, 'FormFillList']);
  Route::get('/formtemplate/fillform/view/{id}', [QuestionTemplateController::class, 'FormFillView']);
  Route::get('/questiontemplate/view/{id}', [QuestionTemplateController::class, 'questiontemplateView']);
  Route::get('/formfill/{url}', [QuestionTemplateController::class, 'questiontemplateFormf'])->where('url', '.*');

  // Discuss route
  Route::resource('/discuss', DiscusesController::class);
  Route::post('/participate/update',  [DiscusesController::class, 'participateUpdate']);
  Route::post('/Discussteam/update',  [DiscusesController::class, 'DiscussTeamUpdate']);
  Route::post('/discuss/update', [DiscusesController::class, 'discussupdate']);
  Route::get('/discussfilter',  [DiscusesController::class, 'discussfilter']);
  Route::get('/discussfilter1',  [DiscusesController::class, 'discussfilter']);
  Route::post('/discuss/editupdate',  [DiscusesController::class, 'Editupdate']);
  Route::get('/discuss/delete/{id}',  [DiscusesController::class, 'discussDelete']);
  Route::post('/distopic/update',  [DiscusesController::class, 'TopicUpdate']);
  Route::post('/description/update',  [DiscusesController::class, 'DescriptionUpdate']);

  Route::get('discussstatus',  [DiscusesController::class, 'discussStatus']);
  Route::get('/discuss/deletes/{id}',  [DiscusesController::class, 'discussDeletes']);
  Route::post('/discuss/excel',  [DiscusesController::class, 'ExcelStore']);
  Route::get('/discusslog',  [DiscusesController::class, 'Discusslog']);

  // Documentation route
  Route::get('documentation/create', [DocumentationController::class, 'create']);
  Route::get('documentation', [DocumentationController::class, 'index']);
  Route::post('documentation/store', [DocumentationController::class, 'store']);
  Route::get('documentation/view/{id}', [DocumentationController::class, 'view']);
  Route::get('get-url', [DocumentationController::class, 'getUrl']);
  Route::get('documentation/{url}', [DocumentationController::class, 'viewpage']);
  Route::get('/indexchart',  [DiscusesController::class, 'indexchart']);

  // Directapplication route
  Route::resource('/directapplication', DirectapplicationController::class);
  Route::get('/direct_articleship-applications',  [DirectapplicationController::class, 'articleship']);
  Route::get('/direct_internship-applications',  [DirectapplicationController::class, 'internship']);
  Route::get('/direct_ca-applications',  [DirectapplicationController::class, 'caapplication']);
  Route::get('/direct_other-applications',  [DirectapplicationController::class, 'otherapplications']);
  Route::get('/articleshipdetails/{sno}',  [DirectapplicationController::class, 'articleshipDetails']);
  Route::get('/cadetails/{sno}',  [DirectapplicationController::class, 'caDetails']);
  Route::get('/internshipdetails/{sno}',  [DirectapplicationController::class, 'internshipDetails']);
  Route::get('/interviewinternresume',  [DirectapplicationController::class, 'interviewintenshipResume']);
  Route::post('/forwardinternresume',  [DirectapplicationController::class, 'internshipforwardResume']);
  Route::get('/internstatusupdate', [DirectapplicationController::class, 'internstatusUpdate']);
  Route::post('/internrating',  [DirectapplicationController::class, 'internRating']);
  Route::get('/otherresume',  [DirectapplicationController::class, 'otherResume']);
  Route::post('/forwardotherresume',  [DirectapplicationController::class, 'otherforwardResume']);
  Route::get('/otherdetails/{sno}',  [DirectapplicationController::class, 'otherdetails']);
  Route::post('/otherrating',  [DirectapplicationController::class, 'otherRating']);
  Route::get('/otherstatusupdate', [DirectapplicationController::class, 'otherstatusUpdate']);
  //performance appraisal
  Route::resource('/performanceappraisal', PerformanceappraisalController::class);
  //Check-In
  Route::resource('/check-In', CheckInController::class);
  Route::post('/check-In/update/', [CheckInController::class, 'update'])->name('check-In.checkout');
  Route::post('/check-In/search/', [CheckInController::class, 'search']);
  Route::get('/check-In-assignment', [CheckInController::class, 'assignment']);

  Route::get('checkinreportdashbord', [CheckInController::class, 'ReportsectionDashbord']);
  Route::get('checkinlist', [CheckInController::class, 'checkinlist']);
  Route::get('/checkinlistfilter', [CheckInController::class, 'checkinlistfiltersection']);

  Route::get('checkinreport', [CheckInController::class, 'Reportsection']);
  Route::get('/checkinfiltersection',  [CheckInController::class, 'checkinfiltersection']);
  Route::get('checkinreport/{currentDate}/{url}', [CheckInController::class, 'Todaycheckin']);
  Route::get('checkinreport/{currentDate}', [CheckInController::class, 'Todaynotcheckin']);
  Route::get('leave/{currentDate}', [CheckInController::class, 'Todayleave']);
  Route::get('unallocated/{currentDate}/{url}', [CheckInController::class, 'TodayUnallocated']);

  // checkinsetting routes
  Route::get('/checkinsetting', [CheckinsettingController::class, 'index']);
  Route::post('/checkinsetting/store', [CheckinsettingController::class, 'store']);
  Route::get('/checkinsetting/delete/{id}', [CheckinsettingController::class, 'delete']);
  Route::get('/checkinsetting/view/{id}', [CheckinsettingController::class, 'view']);
  Route::post('/checkinsetting/update/{id}', [CheckinsettingController::class, 'updateStatus']);
  // RA Create routes
  Route::get('/racreate/{id}', [RacreateController::class, 'index']);
  Route::get('/racreate/create/{id}', [RacreateController::class, 'create']);
  //Route::get('/racreate/{id}/edit', [RacreateController::class, 'edit']);
  Route::resource('/racreate', RacreateController::class);
  Route::get('/racreate/destroy/{id}', [RacreateController::class, 'destroy']);
  Route::get('/api/result/{task_id}/{ra_id}', [RacreateController::class, 'apifunction']);
  Route::get('/valuepitchapi/result/{verify_id}/{ra_id}', [RacreateController::class, 'valuepitchApi']);

  // File Document routes
  Route::resource('/filedocument', FiledocumentController::class);
  Route::get('/filedocumentview/{id}', [FiledocumentController::class, 'viewFiledocument']);
  Route::get('/download-zip', [FiledocumentController::class, 'downloadZip'])->name('downloadZip');

  Route::get('/filedocument/delete/{id}', [FiledocumentController::class, 'DeleteFiledocument']);
  Route::get('/imagefile/delete/{id}', [FiledocumentController::class, 'DeleteImagefile']);
  // API Master routes
  Route::resource('/apimaster', ApimasterController::class);
  Route::get('/apimaster/destroy/{id}', [ApimasterController::class, 'destroy']);


  // Atr routes
  //Route::get('/financialstatement', [FinancialstatementController::class, 'show']);
  Route::resource('/financialstatement', FinancialstatementController::class);
  Route::post('/financialstatement/upload', [FinancialstatementController::class, 'financialstatementUpload']);
  Route::get('/financialstatement/destroy/{id}', [FinancialstatementController::class, 'destroy']);

  Route::get('/list_29A/{id}', [FinancialstatementController::class, 'list29A']);
  Route::get('/list_29A/withra/{id}/{ra_id}', [FinancialstatementController::class, 'listwithRA']);
  Route::get('/assignuser/{id}', [FinancialstatementController::class, 'indexview']);
  Route::get('/delete/assignuser/{id}', [FinancialstatementController::class, 'deleteAssignuser']);


  Route::post('/assign/person29', [FinancialstatementController::class, 'assignPerson29']);

  Route::get('/financialview/{id}/{ids}', [FinancialstatementController::class, 'View']);

  // Route::post('/atr/assign', [AtrController::class, 'atrAssign']);
  //Route::get('/view/atr/{id}', [AtrController::class, 'view']);

  //  Route::get('/areastatus/{id}', [AtrController::class, 'areaStatus']);

  //auditprocedure routes
  Route::resource('/auditprocedure', AuditprocedureController::class);
  Route::get('/auditprocedure/check/{id}', [AuditprocedureController::class, 'auditList']);
  Route::get('/auditprocedure/create/{id}', [AuditprocedureController::class, 'CreatecheckList']);
  Route::post('/auditprocedurechecklist/store', [AuditprocedureController::class, 'checklistStore']);


  Route::get('/linkedin/form', [LinkedInController::class, 'showForm'])->name('form');
  Route::post('/linkedin/post', [LinkedInController::class, 'postToLinkedIn']);


  // articleonboarding routes
  Route::get('/articleonboarding', [ArticleonboardingController::class, 'index']);
  Route::get('/articleprevious',  [ArticleonboardingController::class, 'articleprevious']);

  //Question routes admin
  Route::resource('/questionpaper', QuestionpaperController::class);
  Route::resource('/examanswer', ExamAnswerController::class);
  Route::get('/examanswer/edit/{id}', [ExamAnswerController::class, 'studentexamList']);

  Route::get('/employeepayroll/create', [EmployeepayrollController::class, 'payrollform']);
  Route::post('/employeepayrollform/store', [EmployeepayrollController::class, 'store']);
  Route::get('/payrolldata', [EmployeepayrollController::class, 'payrollData']);
  Route::get('/employeepayroll/view/{id}',  [EmployeepayrollController::class, 'emloyeepayrollview']);
  Route::match(['get', 'post'], '/employeepayroll',  [EmployeepayrollController::class, 'index']);
  Route::post('/payroll/approve',  [EmployeepayrollController::class, 'payrollApprove'])->name('payroll-approve');
  Route::post('/payroll/clarification',  [EmployeepayrollController::class, 'payrollClarification'])->name('payroll-clarification');
  Route::get('/export', [ExportController::class, 'export'])->name('export');

  Route::get('/employeepayroll/upload-form', [EmployeepayrollController::class, 'excelUploadForm'])->name('uploadExcel.form');;
  Route::post('/employeepayroll/upload', [EmployeepayrollController::class, 'excelUpload'])->name('uploadExcel');


  //Assetprocurement routes
  Route::resource('/assetprocurement', AssetprocurementController::class);
  Route::get('/assetfetch',  [AssetprocurementController::class, 'assetfetch_id']);
  Route::post('/assetupdate',  [AssetprocurementController::class, 'assetupdate']);

  //Travel routes
  Route::resource('/travel', TravelController::class);
  Route::get('/transaction',  [TravelController::class, 'transaction']);
  Route::get('/assignmentadvance',  [TravelController::class, 'assignmentadvance']);


  //IcardController routes
  Route::resource('/icards', IcardController::class);
  Route::post('/icardsconfirm',  [IcardController::class, 'icardConfirm']);

  //Group routes
  Route::resource('/group', GroupController::class);



  //Assignmentplanning routes
  Route::resource('/assignmentplanning', AssignmentplanningController::class);
  Route::get('/convertoassignment/{id}', [AssignmentplanningController::class, 'convertoassignment']);
  Route::get('/convertoassignmentdelete/{id}', [AssignmentplanningController::class, 'convertoassignmentdelete']);
  Route::get('/exchange-rate', function (Request $request) {
    $currency = $request->query('currency');
    $amount = floatval($request->query('amount'));

    if (!$currency || $amount <= 0) {
      return response()->json(['error' => 'Invalid currency or amount'], 400);
    }

    // If currency is INR, return the amount directly (no conversion needed)
    if (strtoupper($currency) === 'INR') {
      return response()->json(['engagement_fee' => round($amount, 2)]);
    }

    try {
      $client = new \GuzzleHttp\Client();
      $date = now()->format('Y-m-d'); // Current date

      // Try current date
      $response = $client->get("https://api.frankfurter.app/{$date}?from={$currency}&to=INR");
      $data = json_decode($response->getBody(), true);

      if (!isset($data['rates']['INR'])) {
        // Fall back to latest rates
        $response = $client->get("https://api.frankfurter.app/latest?from={$currency}&to=INR");
        $data = json_decode($response->getBody(), true);
      }

      if (isset($data['rates']['INR'])) {
        $exchangeRate = $data['rates']['INR'];
        $engagementFee = $amount * $exchangeRate;
        return response()->json(['engagement_fee' => round($engagementFee, 2)]);
      }

      return response()->json(['error' => 'No INR rate available'], 500);
    } catch (\Exception $e) {
      \Log::error('Exchange rate API error: ' . $e->getMessage());
      return response()->json(['error' => 'API error: ' . $e->getMessage()], 500);
    }
  })->name('exchange.rate');

  Route::post('/convertassignmentstore',  [AssignmentplanningController::class, 'convertassignmentstore'])->name('convertassignmentbudgeting.store');


  //ArticlefileController routes
  Route::resource('/articlefiles', ArticlefileController::class);
  Route::get('/zip/{id}', [ArticlefileController::class, 'zip']);

  //AssignmentremindersystemController routes
  Route::resource('/assignmentremindersystem', AssignmentremindersystemController::class);

  //AppointmentletterController routes
  Route::resource('/appointmentletter', AppointmentletterController::class);
  //Assignment routes
  Route::resource('/assignment', AssignmentController::class);
  Route::post('/checklist/upload',  [AssignmentController::class, 'checklist_upload']);


  Route::get('/assignmentotp',  [AssignmentController::class, 'assignmentotp']);
  Route::post('/assignmentotp/store', [AssignmentController::class, 'assignmentotpstore']);
  Route::get('/assignmentarchieve/{id}', [AssignmentController::class, 'archieve']);
  Route::get('/check-final-report', [AssignmentController::class, 'checkFinalReport']);


  Route::get('/assignment_list', [AssignmentlistController::class, 'assignment_List']);
  Route::get('/assignmentshow/{id}', [AssignmentlistController::class, 'assignmentShow']);
  Route::get('/assignmentedit/{id}', [AssignmentlistController::class, 'assignmentEdit']);
  Route::post('/assignment_list/update/{id}', [AssignmentlistController::class, 'update']);

  //Template
  Route::resource('/template',  TemplateController::class);

  //Route::resource('/mis', AdminmisController::class);
  Route::get('/viewmis/{id}', [AdminmisController::class, 'viewMis']);
  Route::get('/viewmislist/{id}', [AdminmisController::class, 'viewUpdate']);
  Route::post('/mis/update', [AdminmisController::class, 'misUpdate']);
  Route::get('/misstatus/destroy/{id}', [AdminmisController::class, 'delete']);

  //ConfirmationController routes
  Route::get('/confirmation/{id}', [ConfirmationController::class, 'indexview']);
  Route::post('/confirmation/mail', [ConfirmationController::class, 'mail']);
  Route::get('/confirmationtem',  [ConfirmationController::class, 'template']);
  Route::get('/viewconfirmation/{id}', [ConfirmationController::class, 'view']);
  Route::post('/maildraft', [ConfirmationController::class, 'saveMaildraft']);
  Route::any('/pending/mail/{id}', [ConfirmationController::class, 'pendingmail']);
  Route::post('/finalsave', [ConfirmationController::class, 'saveMail']);

  Route::get('/balanceconfirmationreminderlist',  [ConfirmationController::class, 'balanceconfirmationreminderlist']);
  Route::get('/mailsave', [ConfirmationController::class, 'saveMail']);


  Route::resource('/kras',  KrasController::class);
  Route::post('/kras/excelupload', [KrasController::class, 'krasExcelupload']);
  Route::get('/savedtimesheet/edit/{id}',  [TimesheetController::class, 'savedtimesheetEdit']);
  Route::get('/kras/{id}/edit/{column}', [KrasController::class, 'editColumn'])->name('kras.edit.column');
  Route::patch('/kras/{id}/update/{column}', [KrasController::class, 'updateColumn'])->name('kras.update.column');



  //AssignmentConfirmationController routes
  Route::get('/assignmentconfirmation/{id}', [AssignmentconfirmationController::class, 'indexview']);
  Route::get('/assignmentconfirmationtemplate',  [AssignmentconfirmationController::class, 'template']);
  Route::post('/assignmentconfirmation/mail', [AssignmentconfirmationController::class, 'mail']);
  Route::any('/assignmentpending/mail/{id}', [AssignmentconfirmationController::class, 'pendingmail']);
  Route::post('/assignmentmaildraft', [AssignmentconfirmationController::class, 'saveMaildraft']);
  Route::post('/assignmentfinalsave', [AssignmentconfirmationController::class, 'saveMail']);
  Route::post('/update-debtor-status',  [AssignmentconfirmationController::class, 'updateStatus']);

  //Assignment Template
  Route::get('/assignmenttemplate/{assignmentgenerate_id}', [AssignmenttemplateController::class, 'index']);
  Route::get('/assignmenttemplate/create/{assignmentgenerate_id}', [AssignmenttemplateController::class, 'create']);
  Route::resource('/assignmenttemplate',  AssignmenttemplateController::class);


  //Assignmentbudgeting routes
  Route::resource('/assignmentbudgeting', AssignmentbudgetingController::class);
  Route::get('/clientassignmentlist',  [AssignmentbudgetingController::class, 'list']);

  Route::get('/assignmentpartnerlist',  [AssignmentController::class, 'assignmentpartnerlist']);
  Route::get('/assignmentcosting/{id}',  [AssignmentController::class, 'assignment_costing']);
  Route::get('/assignmentprofitloss',  [AssignmentController::class, 'assignmentprofitloss']);
  Route::get('/pandl/{id}',  [AssignmentController::class, 'assignment_profitloss']);
  Route::get('/partnerpandl',  [AssignmentController::class, 'partnerpandl']);
  Route::get('/assignmentpandl',  [AssignmentController::class, 'assignmentpandl']);


  //Assignmentmapping routes
  Route::get('/getteammemberestrolehour', [AssignmentmappingController::class, 'getEstRoleHour']);
  Route::get('/clientassignmentlist/{id}', [AssignmentmappingController::class, 'clientassignmentList']);
  Route::get('/yearwise', [AssignmentmappingController::class, 'yearWise']);
  Route::resource('/assignmentmapping', AssignmentmappingController::class);
  Route::get('/assignmentmapping/edit/{id}',  [AssignmentmappingController::class, 'assignmentmappingEdit']);
  Route::get('/teamconfirm/',  [AssignmentconfirmController::class, 'teamConfirm']);
  Route::get('/debtorconfirms/',  [AssignmentconfirmController::class, 'debtorconfirm']);
  Route::post('confirmation/confirm',   [AssignmentconfirmController::class, 'confirmationConfirm']);

  // leavetype routes
  Route::resource('/leavetype', LeavetypeController::class);

  // Jobapplications routes
  Route::get('/articleship-applications',  [JobapplicationController::class, 'articleship']);
  Route::get('/internship-applications',  [JobapplicationController::class, 'internship']);
  Route::get('/ca-applications',  [JobapplicationController::class, 'caapplication']);
  Route::get('/caapplicationsearch', [JobapplicationController::class, 'caapplicationsearch']);
  Route::post('/carating',  [JobapplicationController::class, 'caRating']);
  Route::get('/other-applications',  [JobapplicationController::class, 'other']);
  Route::get('/interviewresume',  [JobapplicationController::class, 'interviewResume']);
  Route::post('/forwardresume',  [JobapplicationController::class, 'forwardResume']);
  Route::post('/caforwardresume',  [JobapplicationController::class, 'caforwardResume']);
  Route::post('/articlerating',  [JobapplicationController::class, 'articleRating']);
  Route::get('/articleshipdetails/{sno}',  [JobapplicationController::class, 'articleshipDetails']);
  Route::get('/cadetails/{sno}',  [JobapplicationController::class, 'caDetails']);
  Route::get('/castatusupdate', [JobapplicationController::class, 'castatusUpdate']);
  Route::get('/articlestatusupdate', [JobapplicationController::class, 'articlestatusUpdate']);
  Route::get('/interviewcaresume',  [JobapplicationController::class, 'interviewcaResume']);

  // applyleave routes

  Route::get('/scheduler/leave',  [ApplyleaveController::class, 'schedulerTest']);

  Route::resource('/applyleave', ApplyleaveController::class);
  Route::get('/leave/teamapplication',  [ApplyleaveController::class, 'teamApplication']);
  Route::post('/teamapplication/store',  [ApplyleaveController::class, 'teamapplicationStore']);

  Route::get('/checkleavehastimesheet',  [ApplyleaveController::class, 'checkLeaveHasTimesheet']);

  // Policy routes
  Route::resource('/policy', PolicyController::class);
  Route::get('/policy/list/{id}', [PolicyController::class, 'policylist']);
  Route::get('/policyupdate',  [PolicyController::class, 'policy']);
  Route::get('/policy/acknowledgelist/{id}',  [PolicyController::class, 'acknowledgelist']);
  Route::post('/policy/statusupdate', [PolicyController::class, 'policyAcknowledge']);
  Route::get('/policy/reminder/{id}', [PolicyController::class, 'show']);

  // Recruitmentform routes
  Route::resource('/recruitmentform', RecruitmentformController::class);
  Route::post('recruitmentformupdate/{id}', [RecruitmentformController::class, 'recruitmentformupdate']);
  Route::get('/view/recruitmentform/{id}', [RecruitmentformController::class, 'view']);
  Route::resource('recruitment', RecruitmentController::class)->names('recruitment');
  Route::get('/recruitmentform/final-approve/{id}', [RecruitmentformController::class, 'finalApprove']);
  Route::get('/recruitmentform/first-approve/{id}', [RecruitmentformController::class, 'firstApprove']);
  Route::post('/recruitmentform/final-reject/{id}', [RecruitmentformController::class, 'finalReject']);
  Route::post('/recruitmentform/first-reject/{id}', [RecruitmentformController::class, 'firstReject']);
  /* Route::post('/recruitmentform/first-seek-clarification/{id}', [RecruitmentformController::class, 'firstSeekClarification']);
  Route::post('/recruitmentform/final-seek-clarification/{id}', [RecruitmentformController::class, 'finalSeekClarification']);
  Route::post('/recruitmentform/first-reply-clarification/{id}', [RecruitmentformController::class, 'firstReplyClarification']);
  Route::post('/recruitmentform/final-reply-clarification/{id}', [RecruitmentformController::class, 'finalReplyClarification']);*/
  Route::post('/recruitmentform/clarification/{id}', [RecruitmentFormController::class, 'seekClarification'])->name('clarification');
  Route::post('/recruitmentform/reply-clarification/{id}', [RecruitmentFormController::class, 'replyClarification'])->name('reply_clarification');


  //Material routes
  Route::resource('/material', MaterialController::class);
  Route::post('/material/update/{id}', [MaterialController::class, 'senderupdate']);
  Route::post('/material/receiver/{id}', [MaterialController::class, 'receiverupdate']);

  // Travelform routes
  Route::resource('/travelform', TravelformController::class);
  Route::post('/travelform/update', [TravelformController::class, 'travelupdate']);

  // Travelfeedback routes
  Route::get('/travelformfeedback',  [TravelfeedbackController::class, 'feedback']);
  Route::post('/feedbackinsert', [TravelfeedbackController::class, 'store']);
  Route::get('/travelfeedback', [TravelfeedbackController::class, 'index']);

  //Attendance routes
  Route::resource('/attendance', AttendanceController::class);
  Route::post('/attendance/update', [AttendanceController::class, 'update'])->name('updateAttendance');
  Route::get('/attendances', [AttendanceController::class, 'attendances']);
  Route::get('/attendancelog', [AttendanceController::class, 'attendancelog']);

  //Tax
  Route::resource('/tax', TaxController::class);
  Route::post('/tax/upload', [TaxController::class, 'tax_upload']);

  //Meetingfolder
  Route::resource('/meetingfolder', MeetingfolderController::class);
  Route::post('/meeting/upload', [MeetingfolderController::class, 'meeting_upload']);
  Route::post('/meetingfolder/store', [MeetingfolderController::class, 'folderStore']);
  Route::post('/meetingsubfolderstore', [MeetingfolderController::class, 'meetingsubfolderstore']);
  Route::post('/meetingfolder/update', [MeetingfolderController::class, 'meetingfolder_update']);
  Route::get('/meetingfiles/{id}', [MeetingfolderController::class, 'meetingfiles']);
  Route::get('/meeting/filenameedit', [MeetingfolderController::class, 'meeting_filenameedit']);

  // Declaration Form route
  Route::resource('declarationform', DeclarationformController::class);

  //increment letter routes in web.php
  Route::resource('incrementletter', IncrementletterController::class);
  Route::get('/incrementlog', [IncrementletterController::class, 'incrementlog']);
  //Route::get('/incrementlog', [IncrementletterController::class, 'incrementlog']);
  Route::get('/incrementletter/mailverify/{id}', [IncrementletterController::class, 'mailVerify']);
  Route::get('/userincrementletter', [BackEndController::class, 'incrementletter']);
  Route::get('/getTeammemberInfo/{id}', [IncrementletterController::class, 'getTeammemberInfo']);
  Route::get('/incrementletter/view/{id}', [IncrementletterController::class, 'incrementView']);
  Route::get('/userincrementletter/view/{id}', [IncrementletterController::class, 'userincrementletter']);
  Route::get('/incrementauthotp',  [BackEndController::class, 'authotp']);
  Route::get('/incrementletter/hr-verify/{id}', [IncrementletterController::class, 'hrVerify']);
  Route::get('/incrementletter/partner-verify/{id}', [IncrementletterController::class, 'partnerVerify']);
  Route::post('/incrementotp/verify', [BackEndController::class, 'incrementOtpVerify']);


  Route::get('get-id', [IncrementletterController::class, 'getid']);
  Route::post('reject-reason', [IncrementletterController::class, 'rejectReason']);
  Route::post('finalreason', [IncrementletterController::class, 'final_Reason']);

  Route::post('/clarification/{id}', [IncrementletterController::class, 'seekClarification'])->name('clarification');
  Route::post('/incrementletter/reply-clarification/{id}', [IncrementletterController::class, 'replyClarification'])->name('reply_clarification');
  Route::get('/get-incrementletter', [IncrementletterController::class, 'getData'])->name('get-incrementletter');

  //Invoice
  Route::get('/check-assignment-generate/{assignmentId}', [InvoiceController::class, 'checkAssignmentGenerateId']);
  Route::resource('/invoice',  InvoiceController::class);
  Route::get('/invoiceajax/create',  [InvoiceController::class, 'clientList']);
  Route::get('/invoicecompany/create',  [InvoiceController::class, 'companyList']);
  Route::get('/invoiceassignment',  [InvoiceController::class, 'invoiceAssignment']);
  Route::get('/companycode/create',  [InvoiceController::class, 'companyCode']);
  Route::get('/invoiceview/{id}',  [InvoiceController::class, 'invoiceView']);
  Route::get('/downloadpdf/{id}',  [InvoiceController::class, 'downloadpdf']);
  Route::post('invoiceupdate/{id}',   [InvoiceController::class, 'invoiceUpdate']);
  Route::get('/search',  [InvoiceController::class, 'search']);
  Route::get('/invoicereport',  [InvoiceController::class, 'invoicereport']);
  Route::get('/invoiceassignmentreport',  [InvoiceController::class, 'invoiceassignmentreport']);
  Route::get('/invoiceassignmentreport/barchart', [InvoiceController::class, 'echartt']);
  Route::get('/barchart',  [InvoiceController::class, 'bar_chart']);

  //Teammember routes
  Route::resource('/teammember', TeammemberController::class);
  Route::get('/teamslog', [TeammemberController::class, 'teamslog']);
  Route::get('/ourteam', [TeammemberController::class, 'ourTeam']);
  Route::get('/resetpassword/{id}', [TeammemberController::class, 'resetPassword']);
  Route::post('/password/update/{id}', [TeammemberController::class, 'passwordUpdate']);
  Route::get('changeteamStatus',  [TeammemberController::class, 'changeteamStatus']);
  Route::get('/teammemberupdatedetail',  [TeammemberController::class, 'teamUpdate']);
  Route::post('/teamupdate', [TeammemberController::class, 'teamsupdate']);
  Route::get('/relieve/teammember',  [TeammemberController::class, 'relievingTeammember']);

  //Companydetail route
  Route::resource('/companydetail', CompanydetailController::class);
  Route::get('/view/companydetail/{id}', [CompanydetailController::class, 'viewinvoice']);

  //lead Controller
  Route::resource('/lead', LeadController::class);
  Route::post('/lead/observer', [LeadController::class, 'leadreplyDone']);
  Route::get('/lead/view/{id}', [LeadController::class, 'show']);

  // Cyclingevent routes
  Route::resource('/cyclingevent', CyclingeventController::class);


  //Pbd
  Route::resource('/pbd',  PbdController::class);

  // Assignmentevaluation routes
  Route::resource('/assignmentevaluation', AssignmentevaluationController::class);
  Route::get('/view/assignmentevaluation/{id}', [AssignmentevaluationController::class, 'view']);
  Route::get('assignmentevaluation/type/{value}', [AssignmentevaluationController::class, 'assignmentevaluationonType']);
  Route::get('assignmentevaluation/report', [AssignmentevaluationController::class, 'show']);
  Route::get('assignmentevaluationreport', [AssignmentevaluationController::class, 'assignmentevaluationreport']);
  Route::get('filter/assignmentevaluation', [AssignmentevaluationController::class, 'Filters']);


  // Job routes
  Route::resource('/job', JobController::class);
  Route::get('/view/job/{id}', [JobController::class, 'view']);

  // Clauserestricting routes
  Route::resource('/clauserestricting', ClauserestrictingController::class);
  Route::get('/clauserestricting/view/{id}', [ClauserestrictingController::class, 'view']);
  Route::get('clauserestrictingform', [ClauserestrictingController::class, 'creates']);
  Route::post('clauserestrictingstore', [ClauserestrictingController::class, 'store']);


  // Atr routes
  Route::resource('/atr', AtrController::class);
  Route::post('/atr/upload', [AtrController::class, 'atrUpload']);
  Route::post('/atr/assign', [AtrController::class, 'atrAssign']);
  Route::get('/view/atr/{id}', [AtrController::class, 'view']);
  Route::get('/atr/{id}', [AtrController::class, 'show']);
  Route::get('/atrassigned', [AtrController::class, 'assigned']);
  Route::post('/atr/update', [AtrController::class, 'atrUpdate']);
  Route::post('/assign/person', [AtrController::class, 'assignPerson']);
  Route::get('/atr/reminder/{id}', [AtrController::class, 'atrReminder']);

  //target
  Route::resource('/questionnaireform', QuestionnaireroundoneController::class);

  // project routes
  Route::resource('/project', ProjectController::class);
  Route::get('/view/project/{id}', [ProjectController::class, 'view']);

  //fullandfinal
  Route::resource('/fullandfinal',  FullandfinalController::class);
  Route::get('/fullandfinalreminder/{id}', [FullandfinalController::class, 'fullandfinalReminder']);
  Route::get('/fullandfinalajax/create',  [FullandfinalController::class, 'teammemberDetail']);
  Route::get('/fullandfinal/delete/{id}', [FullandfinalController::class, 'delete']);
  Route::get('/fullandfinal/{id}', [FullandfinalController::class, 'show']);
  Route::post('/fullandfinal/updatestatus/{id}', [FullandfinalController::class, 'updatestatus']);

  Route::get('ilrpersonal', [AdminitrController::class, 'ilrpersonal']);
  Route::get('ilrbp', [AdminitrController::class, 'ilrbp']);
  Route::get('incomefromcapitalgains', [AdminitrController::class, 'income']);
  Route::get('incomefromsources', [AdminitrController::class, 'incomefromsources']);
  Route::get('ilrdeduction', [AdminitrController::class, 'ilrdeduction']);

  //letterhead Controller
  Route::resource('/letterhead', LetterheadController::class);
  Route::get('/letterhead/{id}', [LetterheadController::class, 'show']);

  // Staffdetail routes
  Route::resource('/staffdetail', StaffdetailController::class);

  //Teamlevel routes
  Route::get('/teamlevel',  [TeamlevelController::class, 'index']);
  Route::post('/teamlevel/store',  [TeamlevelController::class, 'store']);
  Route::get('/teamlevel/create',  [TeamlevelController::class, 'create']);
  Route::get('/teamlevel/edit/{id}', [TeamlevelController::class, 'edit']);
  Route::post('/teamlevel/update/{id}', [TeamlevelController::class, 'update']);

  // Notification routes
  Route::resource('/notification', NotificationController::class);

  // Secretary of Task routes
  Route::resource('/secretaryoftask', SecretarialTaskController::class);
  Route::post('/secretaryoftask/update', [SecretarialTaskController::class, 'secretarialtaskUpdate']);
  Route::get('/view/secretaryoftask/{id}', [SecretarialTaskController::class, 'viewsecretarialTask']);
  Route::post('/secretaryoftask/complete', [SecretarialTaskController::class, 'secretarialtaskComplete']);


  // Hr Ticket routes
  Route::resource('/hrticket', HrtaskController::class);
  Route::post('/hrticket/update', [HrtaskController::class, 'hrticketUpdate']);
  Route::get('/view/hrticket/{id}', [HrtaskController::class, 'viewhrticketTask']);
  Route::post('/hrticket/complete', [HrtaskController::class, 'hrticketComplete']);

  // Auditticket of Task routes
  Route::resource('/auditticket', AuditticketController::class);
  Route::post('/auditticket/update', [AuditticketController::class, 'auditticketUpdate']);
  Route::get('/view/auditticket/{id}', [AuditticketController::class, 'viewauditticketTask']);
  Route::post('/auditticket/complete', [AuditticketController::class, 'auditticketComplete']);

  // Dataanalytics of Task routes
  Route::resource('/dataanalytics', DataanalyticsController::class);
  Route::post('/dataanalytics/update', [DataanalyticsController::class, 'dataanalyticsUpdate']);
  Route::get('/view/dataanalytics/{id}', [DataanalyticsController::class, 'viewdataanalyticsticket']);
  Route::post('/dataanalytics/complete', [DataanalyticsController::class, 'dataanalyticsComplete']);

  // Feed routes
  Route::get('/feed', [FeedController::class, 'feed']);

  // ILR routes
  Route::get('/ilr/download/{id}', [InformationresourceController::class, 'ilrDownload']);
  Route::get('/informations/delete/{id}', [InformationresourceController::class, 'informationDelete']);
  Route::get('/ilr/delete/{id}', [InformationresourceController::class, 'questionDelete']);
  Route::resource('/informationresources', InformationresourceController::class);
  Route::get('/informationlist/{id}', [InformationresourceController::class, 'indexview']);
  Route::get('/information/{id}', [InformationresourceController::class, 'ilrfolder']);
  Route::post('/information/upload', [InformationresourceController::class, 'informationUpload']);
  Route::post('/ilr/question', [InformationresourceController::class, 'questionUpload']);
  Route::get('/information/create/{id}', [InformationresourceController::class, 'informationCreate']);
  Route::post('/informations/store', [InformationresourceController::class, 'informationStore']);
  Route::post('/informationfolder/store', [InformationresourceController::class, 'folderStore']);
  Route::post('/edit/question', [InformationresourceController::class, 'editQuestion']);
  Route::get('/information/edit/question',  [InformationresourceController::class, 'editrecords']);
  Route::post('assign/folder', [InformationresourceController::class, 'assignfolderStore']);
  Route::get('ilrbank', [InformationresourceController::class, 'ilrbank']);
  Route::get('ilrhouse', [InformationresourceController::class, 'ilrhouse']);
  Route::get('ilrsalary', [InformationresourceController::class, 'ilrsalary']);
  Route::get('ilraddinformation', [InformationresourceController::class, 'ilraddinformation']);

  // ClientuserloginController routes
  // Route::resource('/clientuserlogin', ClientuserloginController::class);
  Route::get('/clientuserlogin/{id}', [ClientuserloginController::class, 'indexview']);
  Route::post('/clientuserlogin/upload', [ClientuserloginController::class, 'informationUpload']);
  Route::get('/clientuserlogin/create/{id}', [ClientuserloginController::class, 'clientCreate']);
  Route::post('/clientuserlogin/store', [ClientuserloginController::class, 'clientStore']);
  Route::get('/clientuserlogin/resetpassword/{id}', [ClientuserloginController::class, 'resetPassword']);
  Route::post('/clientuserlogin/password/update/{id}', [ClientuserloginController::class, 'passwordUpdate']);
  Route::get('changeclientloginStatus',  [ClientuserloginController::class, 'changeclientloginStatus']);
  Route::get('/client/loginid',  [ClientuserloginController::class, 'clientlogin']);
  Route::get('/client/staffpermission',  [ClientuserloginController::class, 'staffpermission']);
  Route::post('/client/assign',  [ClientuserloginController::class, 'clientassign']);
  Route::post('/client/permissionstore',  [ClientuserloginController::class, 'permissionStore']);

  // Profile routes
  Route::resource('/profile', ProfileController::class);

  //Staffappointmentletter
  Route::resource('/staffappointmentletter', StaffappointmentletterController::class);
  Route::get('/staffappointmentletter/view/{id}', [StaffappointmentletterController::class, 'staffappointmentView']);
  Route::get('/staffappointmentletter/destroy/{id}', [StaffappointmentletterController::class, 'destroy']);
  Route::get('/staffappointmentletter/mailverify/{id}', [StaffappointmentletterController::class, 'mailVerify']);
  Route::post('/staffappointmentletter/reject', [StaffappointmentletterController::class, 'reject'])->name('staffappointmentletter.reject');

  Route::get('/appointment/create/{id}', [StaffappointmentletterController::class, 'appointmentcreate']);
  //hrb Controller
  Route::resource('/hbrtools', HbrController::class);

  // courierinout routes
  Route::resource('/courierinout', CourierinoutController::class);
  Route::post('/courierinout/update/{id}', [CourierinoutController::class, 'senderupdate']);
  Route::post('/courierinout/sender/{id}', [CourierinoutController::class, 'sender']);
  Route::post('/courierinout/receiver/{id}', [CourierinoutController::class, 'receiverupdate']);

  // Outstanding route
  Route::resource('/outstanding', OutstandingController::class);
  Route::get('/outstandingdashboard',  [OutstandingController::class, 'echartt']);
  Route::get('/reminder/sendmail',  [OutstandingController::class, 'sendMail']);
  Route::post('/outstanding/reminder',  [OutstandingController::class, 'oustandingMail']);
  Route::get('/reminder/mailshow',  [OutstandingController::class, 'mailshow']);
  Route::get('/partnerchart',  [OutstandingController::class, 'echart_search']);

  // Finance routes
  Route::get('/assetassignedreport', [AssetasignController::class, 'assetassigned_report']);
  Route::resource('/assetassign', AssetasignController::class);
  Route::get('/assetassigned/view/{id}', [AssetasignController::class, 'financeView']);
  Route::get('/assetassign/viewit/{id}', [AssetasignController::class, 'financeViewit']);
  Route::post('/account/update', [AssetasignController::class, 'accountUpdate']);
  Route::post('/it/update', [AssetasignController::class, 'itUpdate']);
  Route::post('/assetassign/upload', [AssetasignController::class, 'financeUpload']);

  // Performance Evaluation Form Form route
  Route::resource('performanceevaluationform', PerformanceevaluationformController::class);
  Route::get('/performance-dashboard', [PerformanceappraisalController::class, 'dashboard']);
  //Knowledgebase routes
  Route::resource('/knowledgebase', KnowledgebaseController::class);
  Route::get('/knowledgebase/create/{id}',  [KnowledgebaseController::class, 'knowledgebaseCreate']);

  //Knowledgebase routes
  Route::resource('/article', ArticleController::class);
  Route::get('/knowledgebase/article/{id}',  [ArticleController::class, 'articleIndex']);
  Route::get('/article-view/{id}', [ArticleController::class, 'articleView']);
  Route::get('/article/create/{id}', [ArticleController::class, 'articleCreate']);

  // employeereferral routes
  Route::resource('/employeereferral', EmployeereferralController::class);

  // Generate ticket route
  Route::get('/generateticket/{id}', [BackEndController::class, 'ticketIndex']);

  // Payment route
  Route::resource('/payments', PaymentController::class);
  Route::get('/paymentlist/{id}', [PaymentController::class, 'paymentList']);
  Route::get('/payment/create/{id}', [PaymentController::class, 'paymentCreate']);
  Route::post('payments/store/{id}', [PaymentController::class, 'paymentsStore']);
  Route::get('paymentsearch', [PaymentController::class, 'paymentSearch']);

  // clientstaffassign routes
  Route::get('/clientstaffassign/{id}', [StaffassignController::class, 'index']);
  Route::post('staff/assign', [StaffassignController::class, 'staffassignStore']);

  Route::get('/profileimage/{id}', [BackEndController::class, 'profileImage']);

  // Staffrequest route
  Route::get('/staffrequest/list/{id}', [StaffrequestController::class, 'viewList']);
  Route::resource('/staffrequest', StaffrequestController::class);
  Route::get('/viewstaff/{id}', [StaffrequestController::class, 'viewStaff']);
  Route::post('staffrequest/complete', [StaffrequestController::class, 'staffRequest']);
  Route::get('staffrequest/delete/{id}', [StaffrequestController::class, 'destroy']);

  // Proposal routes
  Route::resource('/proposal', ProposalController::class);
  Route::post('/proposal/status',  [ProposalController::class, 'proposalStatus']);


  // Vendor routes
  Route::resource('/vendor', VendorController::class);
  Route::post('/vendor/store', [VendorController::class, 'store']);
  Route::get('/vendorlist', [VendorController::class, 'index']);
  Route::get('/vendorlist/fetch',  [VendorController::class, 'vendorList']);
  Route::get('/vendorfetch',  [VendorController::class, 'vendorfetch_id']);
  Route::post('/vendorupdate',  [VendorController::class, 'vendorupdate']);

  // Payroll routes
  Route::resource('/payroll', PayrollController::class);
  Route::post('/payroll/upload', [PayrollController::class, 'payroll_upload']);
  Route::post('/payrollarticle/upload', [PayrollController::class, 'payrollarticle_upload']);
  Route::get('/payroll/neft', [PayrollController::class, 'payroll_neft']);
  Route::post('/payrollneftprocess',  [PayrollController::class, 'payrollneftprocess']);
  Route::get('/payrollarticle', [PayrollController::class, 'payroll_index']);
  Route::post('/payrollarticleneftprocess',  [PayrollController::class, 'payrollarticleneftprocess']);
  Route::get('/payrolls', [PayrollController::class, 'payroll']);
  Route::get('/payrollarticless', [PayrollController::class, 'payrollarticless']);

  // NEFT routes
  Route::get('/payrollarticleneftss', [NeftController::class, 'payrollarticleneftss']);
  Route::resource('/neft', NeftController::class);
  Route::get('/neftajax/create',  [NeftController::class, 'teamList']);
  Route::get('/getconveyancesneft',  [NeftController::class, 'get_conveyacne']);
  Route::get('/getconveyancesnefttotal',  [NeftController::class, 'get_conveyancesnefttotal']);
  Route::get('/neftstatus', [NeftController::class, 'neft_status']);
  Route::post('/neftstatusupdate', [NeftController::class, 'neft_statusupdate']);
  Route::get('/payrollneft', [NeftController::class, 'payrollneft']);
  Route::get('/payrollneftsalary', [NeftController::class, 'payrollneftsalary']);

  Route::get('/neftformat', [NeftController::class, 'neft_format']);
  Route::get('/payrollarticleneft', [NeftController::class, 'payrollarticleneft']);
  Route::get('/neftdate', [NeftController::class, 'neftdate']);

  //Ifcfolder
  Route::get('/ifcfolder/{id}', [IfcfolderController::class, 'index']);
  Route::get('ifcfolders', [IfcfolderController::class, 'staffindex']);
  Route::resource('/ifcfolder', IfcfolderController::class);
  Route::get('/ifclist/{id}',  [IfcfolderController::class, 'ifclist']);
  Route::get('/ifclist/{id}',  [IfcfolderController::class, 'ifclist']);

  //IFC
  Route::get('/ifc/{id}', [IfcController::class, 'index']);
  Route::get('/ifc/view/{id}', [IfcController::class, 'ifcView']);
  Route::post('/ifc/update/{id}', [IfcController::class, 'ifcUpdate']);
  //Route::post('/ifcmanagementupdate', [IfcController::class, 'ifcmanagementupdate']);
  Route::post('/ifc/upload', [IfcController::class, 'ifcUpload']);
  Route::post('/ifc/uploadanswer', [IfcController::class, 'ifcUpload_answer']);
  Route::post('/ifcassign/person', [IfcController::class, 'ifcassignPerson']);
  Route::get('/ifcdocument',  [IfcController::class, 'ifcdocument']);
  Route::post('/ifcresposible/person',  [IfcController::class, 'ifcresposiblePerson']);
  Route::get('/ifcdocuments',  [IfcController::class, 'ifcdocuments']);
  Route::get('echarts/ifc/{id}', [IfcController::class, 'echart']);

  Route::get('/employee_payroll',  [EmployeepayrollController::class, 'employee_payroll']);
  Route::post('/employeepayroll_update',  [EmployeepayrollController::class, 'employeepayroll_update']);


  // outstationconveyance routes
  Route::post('/conveyanceneft',  [OutstationconveyanceController::class, 'conveynace_neft']);
  Route::resource('/outstationconveyance', OutstationconveyanceController::class);
  Route::get('/assignmentoutstation',  [OutstationconveyanceController::class, 'assignmentOutstation']);
  Route::get('/assignmentfunctionn',  [OutstationconveyanceController::class, 'assignmentFunction']);
  Route::get('/advancetype',  [OutstationconveyanceController::class, 'advancetype']);
  Route::get('/getadvancenumber',  [OutstationconveyanceController::class, 'getadvancenumber']);
  Route::get('/getadvancetotal',  [OutstationconveyanceController::class, 'getadvancetotal']);
  Route::post('/outstationconveyanceupdate',  [OutstationconveyanceController::class, 'accountupdate']);
  Route::get('/conveyacnelocal',  [OutstationconveyanceController::class, 'conveyacnelocal']);
  Route::get('/conveyacneoutstation',  [OutstationconveyanceController::class, 'conveyacneoutstation']);

  // Gnatt route
  Route::get('/gnattchart', [GnattchartController::class, 'index']);
  Route::get('/gnattchart/assignlist', [GnattchartController::class, 'gnattchartAssignlist']);
  Route::get('/gnattchart/editassign/{id}', [GnattchartController::class, 'editAssign']);
  Route::post('/gnattchart/assign/update/{id}', [GnattchartController::class, 'updateAssign']);
  Route::post('/gnattchart/store', [GnattchartController::class, 'gnattStore']);
  Route::post('/ganttchart/upload', [GnattchartController::class, 'ganttUpload']);
  Route::post('/ganttchart/client/store', [GnattchartController::class, 'ganttchartClientStore']);

  //Step routes
  Route::resource('/step', StepController::class);
  Route::get('/step/check/{id}', [StepController::class, 'checkList']);
  Route::post('/checklist/store', [StepController::class, 'checklistStore']);
  Route::post('/modify/excel', [StepController::class, 'excelStore']);
  Route::get('/viewassignment/{id}', [StepController::class, 'viewAssignment']);
  Route::get('/auditchecklist', [StepController::class, 'auditChecklist']);
  Route::get('/auditchecklistanswer', [StepController::class, 'auditchecklistAnswer']);
  Route::get('/deleteassignmentchecklist/{id}', [StepController::class, 'deleteassignmentChecklist']);
  Route::get('/assignment/teamreject/{id}/{status}', [StepController::class, 'assignment_teamreject']);
  Route::get('/log/{id}', [StepController::class, 'log']);
  Route::get('/assignmentlog/filtersection', [StepController::class, 'AssignmentLogfilter']);

  Route::post('/fetch-status-data', [StepController::class, 'fetchStatusData'])->name('fetch.status.data');

  // Teamlogin routes
  Route::resource('/teamlogin', TeamloginController::class);

  // Teamprofile routes
  Route::resource('/teamprofile', TeamprofileController::class);

  // Development route
  Route::resource('/development', DevelopmentController::class);

  // Balance routes
  Route::resource('/balance', BalanceController::class);

  //  Connection routes
  Route::resource('/connection', ConnectionController::class);
  Route::get('/view/connection/{id}', [ConnectionController::class, 'viewConnection']);
  Route::get('/connectioncompanies/destroy/{id}', [ConnectionController::class, 'connectionDestroy']);
  Route::get('/connection/list/destroy/{id}', [ConnectionController::class, 'destroy']);

  //Auditchecklistanswer routes
  Route::post('/assignmentna', [ChecklistanswerController::class, 'assignment_na']);
  Route::get('/assignmentclosed', [ChecklistanswerController::class, 'assignmentclosed']);
  Route::post('/auditchecklistanswer/store', [ChecklistanswerController::class, 'checklistAnswer']);
  Route::get('/criticalnotes', [ChecklistanswerController::class, 'criticalNotesview']);
  Route::post('/criticalnotes/store', [ChecklistanswerController::class, 'criticalNotes']);
  Route::get('/assignmentlist/{id}', [ChecklistanswerController::class, 'assignmentList']);
  Route::post('/teammapping/update', [ChecklistanswerController::class, 'teammappingUpdate']);

  // ContractandSubscriptionController routes
  Route::resource('/contract', ContractandSubscriptionController::class);
  Route::get('/view/contract/{id}', [ContractandSubscriptionController::class, 'view']);

  // Client routes
  Route::resource('/client', ClientController::class);
  Route::get('/client/contactedit/{id}', [ClientController::class, 'editContact']);
  Route::post('/client/contactupdate/{id}', [ClientController::class, 'contactUpdate']);
  Route::get('/client/destroy/{id}', [ClientController::class, 'destroyClient']);
  Route::get('/clientdocument/destroy/{id}', [ClientController::class, 'destroyClientdocument']);
  Route::get('/debtor/pdf/{id}', [ClientController::class, 'debtorPdf']);
  Route::get('/clientcontact', [ClientController::class, 'clientContact']);
  Route::get('/clientfile', [ClientController::class, 'clientFile']);
  Route::get('/clientfile/create', [ClientController::class, 'clientCreate']);
  Route::post('/clientfile/store', [ClientController::class, 'clientfileStore']);
  Route::post('/clientcontact/upload', [ClientController::class, 'clientcontactUpload']);
  Route::get('/clientdocument/open/{id}', [ClientController::class, 'clientdocumentOpen']);
  Route::post('/viewassignment/contactupdate', [ClientController::class, 'assignmentContactUpdate']);
  Route::get('/viewclient/{id}', [ClientController::class, 'viewClient']);
  Route::get('changeStatus',  [ClientController::class, 'changeStatus']);
  Route::post('/debtor/excel', [ClientController::class, 'debtorExcel']);
  Route::post('/admin/file', [ClientController::class, 'adminFile']);
  Route::get('/viewclientlist/{client_name}', [ClientController::class, 'viewclientlist']);
  Route::get('/client/add/{clientid?}', [ClientController::class, 'add']);
  Route::get('/clientlist', [ClientController::class, 'client_list']);


  // Service routes
  Route::resource('/service', ServiceController::class);

  // Creditnote routes
  Route::resource('/creditnote', CreditnoteController::class);
  Route::get('/creditnoteinvoice',  [CreditnoteController::class, 'invoiceList']);
  Route::get('/creditnoteinvoice/create',  [CreditnoteController::class, 'companyList']);
  Route::get('/creditnoteinvoices/create',  [CreditnoteController::class, 'companyCode']);

  // localconveyance routes
  Route::resource('/localconveyance', LocalconveyancesController::class);
  Route::get('/assignmentfunction',  [LocalconveyancesController::class, 'assignmentFunction']);

  // claim routes
  Route::resource('/reimbursementclaim', ReimbursementclaimController::class);
  Route::post('/reimbursementclaimupdate',  [ReimbursementclaimController::class, 'accountupdate']);
  Route::get('reimbursementclaimupdate', [ReimbursementclaimController::class, 'reimbursementclaimupdate']);

  // Asset routes
  Route::resource('/asset', AssetController::class);
  Route::get('assetlist', [AssetController::class, 'asset_list']);
  Route::post('/assetconfirm',  [AssetController::class, 'assetConfirm']);

  // holiday routes
  Route::resource('/holiday', HolidayController::class);
  Route::get('/holidays', [HolidayController::class, 'holidays']);
  Route::get('holiday/delete/{id}', [HolidayController::class, 'destroy']);


  // record addition routes
  Route::resource('recordaddition', RecordAdditionController::class);
  Route::get('/recordaddition/view/{id}', [RecordAdditionController::class, 'recordadditionView']);
  Route::get('/recordaddition/partner-verify/{id}', [RecordAdditionController::class, 'partnerVerify']);
  Route::get('/recordveryfication/{id}', [RecordAdditionController::class, 'formE'])->name('details.veryfication');
  Route::post('/detailsUpdate/{id}', [RecordAdditionController::class, 'detailsUpdate'])->name('details.update');
  Route::post('/allocateslot',  [RecordAdditionController::class, 'recordUpdate'])->name('allocate.slot');
  Route::get('/record-get-conversion', [RecordAdditionController::class, 'getConversion'])->name('record-get.conversion');
  Route::post('update-reason', [RecordAdditionController::class, 'updateReason'])->name('record.update.reason');
  Route::get('list/{id}', [RecordAdditionController::class, 'clientlist']);


  //withdrawal route


  Route::resource('withdrawal', WithdrawalController::class);
  Route::post('withdrawal/slotallot',  [WithdrawalController::class, 'recordUpdate'])->name('withdrawal.allocate.slot');
  Route::get('get-conversion', [WithdrawalController::class, 'getConversion'])->name('get.conversion');
  Route::post('withdrawal/update-reason', [WithdrawalController::class, 'updateReason'])->name('withdrawal.update.reason');
  Route::get('withdrawal/recordveryfication/{id}', [WithdrawalController::class, 'formE'])->name('withdrawal.details.veryfication');
  Route::post('withdrawal/detailsUpdate/{id}', [WithdrawalController::class, 'detailsUpdate'])->name('withdrawal.details.update');
  Route::get('withdrawal/list/{id}', [WithdrawalController::class, 'withdrawalclientlist']);


  // Timesheetrequest routes
  Route::get('/timesheetrequestlist', [TimesheetrequestController::class, 'index']);
  Route::get('/timesheetrequest/view/{id}', [TimesheetrequestController::class, 'show']);
  Route::post('/timesheetrequest/update/{id}',  [TimesheetrequestController::class, 'update']);
  Route::post('/get-payroll-data', [TimesheetController::class, 'getPayrollData'])->name('get.payroll.data');
  Route::get('sendRequestReminder', [TimesheetrequestController::class, 'sendRequestReminder']);
  Route::get('/timesheetrequest/reminder/list',  [TimesheetrequestController::class, 'timesheetrequest_list']);

  //Comp off routes 
  Route::get('/compoff', [TimesheetController::class, 'comppOff']);
  Route::get('/timesheetcompoff/view/{id}', [TimesheetController::class, 'compOffApproval']);
  Route::post('/timesheetcompoffrequest/update/{id}',  [TimesheetController::class, 'compOffUpdate']);



  // timesheet routes
  Route::get('/timesheet/destroy/{id}', [TimesheetController::class, 'destroy']);
  Route::match(['get', 'post'], 'timesheet/search', [TimesheetController::class, 'show']);
  Route::resource('/timesheet', TimesheetController::class);
  Route::get('/teamtimelist', [TimesheetController::class, 'mytimelist']);
  Route::get('/view/timesheet/{id}', [TimesheetController::class, 'view']);
  Route::get('/timesheet/edit/{date}', [TimesheetController::class, 'edit']);
  Route::post('/timesheet/updated/', [TimesheetController::class, 'update']);
  Route::post('timesheetexcel/store', [TimesheetController::class, 'timesheetexcelStore']);
  Route::post('timesheetrequest/store', [TimesheetController::class, 'timesheetrequestStore']);
  Route::get('/reportsection',  [TimesheetController::class, 'Reportsection']);
  Route::get('/filtersection',  [TimesheetController::class, 'filtersection']);


  Route::post('generate-audit-ticket', [TicketController::class, 'insertAuditTicket']);
  Route::post('generate-hr-ticket', [TicketController::class, 'insertHrTicket']);
  Route::post('generate-data-analytics-ticket', [TicketController::class, 'insertDataAnalyticsTicket']);


  // Conversion routes
  Route::resource('/conversion', ConversionController::class);
  Route::get('/conversionupdate',  [ConversionController::class, 'conversion']);
  Route::post('/connection/statusupdate',  [ConversionController::class, 'conversionUpdate']);

  // Trainingassessment routes

  Route::resource('/trainingassetsments', TrainingassessmentController::class);

  //candidateboarding routes
  //Route::get('/candidate/article/convert/{id}', [CandidateboardingController::class, 'articleconvert']);
  Route::resource('/candidateboarding', CandidateboardingController::class);
  Route::get('/candidateconvert/{id}', [CandidateboardingController::class, 'candidateconvert']);


  Route::get('/candidateupdate',  [CandidateboardingController::class, 'candidatedetails']);
  Route::post('/candidateonboarding/update',  [CandidateboardingController::class, 'candidateupdate']);

  Route::get('/articleupdate',  [CandidateboardingController::class, 'articledetails']);
  Route::post('/articleonboarding/update',  [CandidateboardingController::class, 'articleupdate']);

  Route::get('/capitallarticle', [CandidateboardingController::class, 'capitallarticle']);
  Route::post('/capitallarticlepreview', [CandidateboardingController::class, 'capitallarticlepreview'])
    ->name('capitallarticlepreview');

  Route::post('/candidate/article/convert/{id}', [CandidateboardingController::class, 'articleconvert'])
    ->name('articleconvert');


  //Powerbi(madhup sir) 
  Route::resource('/report', ReportController::class);

  // employeeonboarding routes
  Route::get('/employeeonboarding', [EmployeeonboardingController::class, 'index']);
  Route::get('/employeeonboarding/sendmail/{id}', [EmployeeonboardingController::class, 'sendMailform']);
  Route::post('/employeeonboarding/sendmailpreview/{id}', [EmployeeonboardingController::class, 'sendMailPreview']);
  Route::post('/employeeonboarding/sendmail/{id}', [EmployeeonboardingController::class, 'sendMail']);
  Route::get('/capitallcred', [EmployeeonboardingController::class, 'capitallcred'])->name('capitallcred');
  Route::post('/sendcapitallcred', [EmployeeonboardingController::class, 'sendcapitallcred'])->name('sendcapitallcred');

  //draftemail
  Route::resource('/draftemail', DraftemailController::class);

  // AnnualIndependenceDeclaration route
  Route::resource('annualindependencedeclaration', AnnualIndependenceDeclarationController::class);

  // ClientSpecificIndependenceDeclaration route
  Route::resource('clientspecificindependence', ClientSpecificIndependenceController::class);



  // Penality routes

  Route::resource('/penality', PenalityController::class);
  Route::post('/penality/update', [PenalityController::class, 'taskUpdate']);
  Route::get('/view/penality/{id}', [PenalityController::class, 'viewTask']);
  Route::post('/penality/complete', [PenalityController::class, 'taskComplete']);
  Route::get('penality/delete/{id}', [PenalityController::class, 'destroy']);
  Route::get('penality/list/{id}', [PenalityController::class, 'list']);


  // Task routes

  Route::resource('/task', TaskController::class);
  Route::get('/taskassignment',  [TaskController::class, 'taskAssignment']);
  Route::get('/taskassignment/{id}',  [TaskController::class, 'taskassignmentlist']);
  Route::post('/tasktrail/update', [TaskController::class, 'taskUpdate']);
  Route::post('/update/subtask', [TaskController::class, 'update_subtask']);
  Route::get('/view/task/{id}', [TaskController::class, 'viewTask']);
  Route::post('/task/complete', [TaskController::class, 'taskComplete']);
  Route::get('task/delete/{id}', [TaskController::class, 'destroy']);
  Route::get('task/repeat/{id}', [TaskController::class, 'task_repeat']);
  Route::get('task/list/{id}', [TaskController::class, 'list']);
  Route::post('/task/reminder',  [TaskController::class, 'taskMail']);
  Route::get('taskreport', [TaskController::class, 'Reportsection']);
  Route::get('/taskfiltersection',  [TaskController::class, 'taskfiltersection']);

  Route::get('/task/dashbord/report',  [TaskController::class, 'Reportdashboard']);
  //  Route::get('/chart-data', [TaskController::class, 'getChartData']);
  // Assetticket routes
  Route::post('/generateticket/store', [AssetticketController::class, 'ticketStore']);
  Route::post('/ticket/reply', [AssetticketController::class, 'ticketreplyDone']);
  Route::get('/ticket/{id}', [AssetticketController::class, 'ticketReply']);
  //Route::get('/ticketsupport', [AssetticketController::class, 'index']);
  Route::get('/it-support', [AssetticketController::class, 'index']);
  Route::get('/finance-support', [AssetticketController::class, 'index']);
  //Route::get('/createticket', [AssetticketController::class, 'createTicket']);
  Route::get('/create-it-ticket', [AssetticketController::class, 'createTicket']);
  Route::get('/create-accounts-ticket', [AssetticketController::class, 'createTicket']);
  Route::post('/switch-department', [AssetticketController::class, 'switchDepartment']);
  Route::post('/switch-department-from-hr', [HrtaskController::class, 'switchDepartment']);

  Route::post('/switch-department-from-auditticket', [AuditticketController::class, 'switchDepartment']);
  Route::post('/switch-department-from-dataanalytics', [DataanalyticsController::class, 'switchDepartment']);
  // databasebackup routes
  Route::resource('/backup', BackupController::class);
  Route::get('/dbbackup', [BackupController::class, 'dbBackup']);
  Route::get('download/{file}', [BackupController::class, 'getFiles']);


  Route::resource('/codeofconduct', CodeofconductController::class);
  //Tender routes
  Route::resource('/tender', TenderController::class);
  Route::get('/tender/list/{id}', [TenderController::class, 'List']);
  Route::get('/tender/view/{id}',  [TenderController::class, 'tenderView']);
  Route::post('tender/assigned',  [TenderController::class, 'tenderAssigned']);
  Route::post('tenderssigned/store',  [TenderController::class, 'tenderssignedStore']);
  Route::post('tendercreatedby/store',  [TenderController::class, 'tendercreatedBystore']);
  Route::get('tenderexpirelist',  [TenderController::class, 'tenderexpireList']);
  Route::post('tenderSubmit/store',  [TenderController::class, 'tenderSubmitstore']);
  Route::get('/payroll-data', [EmployeepayrollController::class, 'payrollGenerate']);

  Route::get('payslipsent', [EmployeepayrollController::class, 'payslipsent']);

  Route::get('/timesheetreportsection',  [TimesheetController::class, 'TimesheetReportsection']);
  Route::get('/timesheetfiltersection',  [TimesheetController::class, 'timesheetfiltersection']);

  Route::get('offerletter/toggleofferletterStatus/{id}', [OfferLetterController::class, 'toggleAuditStatus'])->name('offerletter.confirmation_status');
});
// Route::group(['prefix' => 'settings'], function () {
// -----------Email Templating engine module-------------------------
Route::get('email/templates', [MailTemplateController::class, 'index'])->name('setting.mail_template.index');
Route::match(['get', 'post'], 'email/templates/create', [MailTemplateController::class, 'create'])
  ->name('setting.mail_template.create');
Route::match(['get', 'post'], 'email/templates/update/{id}', [MailTemplateController::class, 'update'])
  ->name('setting.mail_template.edit');
Route::get('email/templates/delete/{id}', [MailTemplateController::class, 'destroy'])
  ->name('setting.mail_template.destroy');
          
//});