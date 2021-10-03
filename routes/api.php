<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\SchoolClassController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\SchoolSessionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\GeneralBillController;
use App\Http\Controllers\Api\PaymentController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
  Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/me', function(Request $request) {
        return auth()->user();
    });

    Route::post('logout', [AuthController::class, 'logout']);
      Route::get('schools', [SchoolController::class, 'index']);


});
//Auth
  Route::post('register', [AuthController::class, 'register']);
   Route::post('login', [AuthController::class, 'login']);

   //users
   Route::get('users', [UserController::class, 'index']);
  Route::get('users/{user_id}', [UserController::class, 'getUser']);
  Route::get('users/{user_id}/roles', [UserController::class, 'getUserRoles']);
  Route::post('users', [UserController::class, 'craeteUser']);
   Route::post('users/{id}', [UserController::class, 'editUser']);
   Route::delete('users/{id}', [UserController::class, 'deleteUser']);
  Route::post('users-roles/{id}', [UserController::class, 'roleUpdate']);
   Route::post('users-update/{id}/roles', [UserController::class, 'userRoleUpdate']);




    //Roles
    Route::get('roles', [RoleController::class, 'index']);
    Route::get('roles/{role_id}', [RoleController::class, 'getRole']);
    Route::post('roles/{id}', [RoleController::class, 'editRole']);
    Route::post('roles', [RoleController::class, 'createRole']);
    Route::delete('roles/{id}', [RoleController::class, 'deleteRole']);


    Route::get('schools', [SchoolController::class, 'index']);
     Route::post('school', [SchoolController::class, 'createSchool']);
     Route::get('schools/{school_id}', [SchoolController::class, 'getSchool']);
     Route::post('schools/{id}', [SchoolController::class, 'editSchool']);
     Route::delete('schools/{id}', [SchoolController::class, 'deleteSchool']);
     Route::post('schools/{id}/logo', [SchoolController::class, 'upload']);





     Route::get('terms', [TermController::class, 'index']);
     Route::get('present-term', [TermController::class, 'presentTerm']);
    Route::get('terms/{id}', [TermController::class, 'getTermById']);
    Route::delete('terms/{id}', [TermController::class, 'deleteTerm']);
    Route::post('terms/{id}', [TermController::class, 'updateTerm']);
    Route::post('terms', [TermController::class, 'createTerm']);
    Route::post('end-term/{id}', [TermController::class, 'endTerm']);




   Route::post('school-session-create', [SchoolSessionController::class, 'createSession']);
   Route::post('school-session-end', [SchoolSessionController::class, 'endSchoolSession']);
  Route::get('school-session-term-info', [SchoolSessionController::class, 'schoolSessionAndTermInfo']);
  Route::post('school-new-term', [SchoolSessionController::class, 'newTerm']);



  Route::get('categories', [CategoryController::class, 'index']);
Route::post('category', [CategoryController::class, 'store']);
  Route::get('categories/{id}', [CategoryController::class, 'getCategory']);
 Route::post('category/{id}', [CategoryController::class, 'update']);
Route::delete('category/{id}', [CategoryController::class, 'delete']);
Route::post('category/{id}/departments', [CategoryController::class, 'addDepartments']);
Route::put('category/{id}/departments-update', [CategoryController::class, 'updateCategoryDepartments']);
Route::get('category/{id}/departments', [CategoryController::class, 'getCategoryDepartments']);
Route::delete('category/{id}/departments-all', [CategoryController::class, 'removeAllDepartmentFromCategory']);
Route::post('category/{id}/department', [CategoryController::class, 'removeDepartmentsFromCategory']);


Route::get('departments', [DepartmentController::class, 'index']);
Route::post('department', [DepartmentController::class, 'store']);
Route::get('departments/{id}', [DepartmentController::class, 'getDepartment']);
Route::post('department/{id}', [DepartmentController::class, 'update']);
Route::delete('departments/{id}', [DepartmentController::class, 'delete']);
Route::post('departments/{id}/school-classes', [DepartmentController::class, 'addSchoolClass']);
Route::post('departments/{id}/school-classes-update', [DepartmentController::class, 'updateDepartmentSchoolClasses']);
Route::get('departments/{id}/school-classes', [DepartmentController::class, 'getSchoolClassesFromDepartments']);
Route::post('departments/{id}/school-classes-all', [DepartmentController::class, 'removeAllSchoolClassesFromDepartment']);
Route::delete('departments/{id}/school-classes', [DepartmentController::class, 'removeSchoolClassesFromDepartments']);


Route::get('school-classes', [SchoolClassController::class, 'index']);
Route::post('school-classes', [SchoolClassController::class, 'store']);
Route::post('school-many-classes', [SchoolClassController::class, 'addManyClasses']);
Route::get('school-classes/{id}', [SchoolClassController::class, 'getSchoolClass']);
Route::post('school-classes/{id}', [   SchoolClassController::class, 'update']);
Route::delete('school-classes/{id}', [SchoolClassController::class, 'delete']);



Route::get('students', [StudentController::class, 'index']);
Route::get('students/{id}', [StudentController::class, 'findStudentById']);
Route::get('student/search', [StudentController::class, 'findStudentByParams']);
Route::delete('students/{id}', [StudentController::class, 'deleteStudent']);
Route::post('students/{student_id}/class/{class_id}', [StudentController::class, 'updateStudent']);
Route::post('student/create/class', [StudentController::class, 'createStudent']);
Route::get('students/class/{class_id}', [StudentController::class,'getStudentsInClass']);
Route::get('student/{student_id}/bill', [StudentController::class, 'myBill']);
Route::post('student/{student_id}/class/{class_id}/payment', [StudentController::class, 'saveStoreDebts']);
Route::post('student/{student_id}/class/{class_id}/add', [StudentController::class, 'addToGeneralBill']);
Route::post('student/{student_id}/class/{class_id}/remove', [StudentController::class, 'removeFromGeneralBill']);



Route::post('student/{student_id}/present-class/{present_class_id}/new-class/{new_class_id}', [StudentController::class, 'changeStudentClass']);
Route::get('class/{id}/students', [StudentController::class, 'getStudentsInClass']);
Route::post('students/class/{class_id}/add-students-to-class', [StudentController::class, 'addStudentsToClass']);


Route::get('bills', [GeneralBillController::class, 'index']);
Route::get('compulsoryBills', [GeneralBillController::class, 'compulsoryBill']);

Route::get('specificCompulsoryBill', [GeneralBillController::class, 'spaecifcCompulsoryBill']);
Route::get('storeBills', [GeneralBillController::class, 'storeBill']);
Route::get('generalBills', [GeneralBillController::class, 'generalBill']);
Route::post('bills', [GeneralBillController::class, 'makeBill']);
Route::post('bill/{id}', [GeneralBillController::class, 'updateBill']);
Route::delete('bills/{id}', [GeneralBillController::class, 'deleteBill']);
Route::post('bills/class/{class_id}', [GeneralBillController::class, 'indexByClassId']);
Route::post('pay/{student_id}', [PaymentController::class, 'pay']);



Route::get('tester/', function(){
  return $biil = \App\Models\SchoolClass::addSelect(
      ['amount' => \App\Models\GeneralBill::select('amount')
          ->whereColumn('id', 'general_bills.school_class_id')
          ->orderByDesc('id')
          ->limit(1)
      ]
  )->get();

});



