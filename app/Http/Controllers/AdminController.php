<?php

namespace App\Http\Controllers;
use App\Exports\CustomExport;
use App\Models\Country;
use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\DownloadedList;
use App\Models\ExportHistori;
use App\Models\PhoneListSearch;
use App\Models\PhoneListUserModel;
use App\Models\PurchasePlan;
use App\Models\SetPurchasePlan;
use Auth;
use Carbon\Carbon;
// use DB;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PhoneListImport;
use App\Exports\PhoneListExport;
use App\Jobs\PhoneCsvProcess;
use App\Models\PhoneList;
use App\Models\PhoneListSetup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
// use Bus;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{

    protected $data;
    protected $allData;
    protected $purchasePlan;
    protected $user;
    protected $credit;
    protected $plan;
    protected static $phoneList;

            // view admin Dashboard

    public function index()
    {
        return view('admin.dashboard');
    }

            //  admin Dashboard file upload


    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImportExport()
    {
        //return view('file-import');
    }





    public function fileImport(Request $request)
    {
        if( $request->has('file') ) {
            $phoneArray = PhoneList::pluck('phone')->toArray();
            $csv = file(request()->file);
            $chunks = array_chunk($csv,1000);
            $header = [];
            $batch  = Bus::batch([])->dispatch();

            //create table setup...
            $table_name = 'phone_lists'.time();
            $this->CreateTableSetup($table_name);
            $phoneListSetupData = [
                'file_name' => request()->file->getClientOriginalName(),
                'table_name' => $table_name,
                'date' => date('Y-m-d'),
            ];
            PhoneListSetup::create($phoneListSetupData);

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                
                if($key == 0){
                    $header = $data[0];
                    unset($data[0]);
                }

                if (isset($data)) {
                    $batch->add(new PhoneCsvProcess(mb_convert_encoding($data, 'UTF-8', 'UTF-8'), $header, $phoneArray, $table_name));
                }
            }
            return back()->with('message', 'Successfully imported file!');
        }
        return back()->with('message', 'Please Upload file!');
    }

    private function CreateTableSetup($table_name)
    {
        Schema::create($table_name, function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->bigInteger('uid')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->string('location')->nullable();
            $table->string('location_city')->nullable();
            $table->string('location_state')->nullable();
            $table->string('location_region')->nullable();
            $table->string('hometown')->nullable();
            $table->string('hometown_city')->nullable();
            $table->string('hometown_state')->nullable();
            $table->string('hometown_region')->nullable();
            $table->string('relationship_status')->nullable();
            $table->bigInteger('education_last_year')->nullable();
            $table->string('work')->nullable();
            $table->timestamps();
        });
    }



    public function fileExport()
    {
        return Excel::download(new PhoneListExport, 'phoneList-collection.xlsx');
    }

    public function fileConvert()
    {
        //$last2 = PhoneListSearch::all();

        if (PhoneListSearch::exists())
        {
            $last = PhoneListSearch::query()->orderByDesc('phoneList_id')->first();
            //dd($last->phoneList_id);

            $c1 = PhoneList::where('id', ">", $last->phoneList_id)->get();

            foreach($c1 as $record){

                PhoneListSearch::newPhoneList($record);

            }
        }
        else
        {
            $c1 = PhoneList::all();

            foreach($c1 as $record){

                PhoneListSearch::newPhoneList($record);

            }

        }
        return back();
    }


    public function customExport(Request $request)
    {
        $credit=Credit::where('userId',Auth::user()->id)->first();
        if ($credit->useableCredit >= count($request->chk))
        {
            Credit::updateUserCradit($request);
            ExportHistori::newExportHistori($request);
            DownloadedList::createNew($request);
            CreditHistory::create($request);
            PhoneListUserModel::updateUseAbleCredit($request);

            //return (new CustomExport($request->chk))->download('phoneList.xlsx');
            return Excel::download(new CustomExport($request->chk), 'phoneList.xlsx');
        }
        else
        {
            return redirect('/settings/upgrade');
        }
    }




    //  admin Dashboard view all data // data edit update delete
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function manageData(){
        // $this->allData = PhoneList::paginate(10);

        $allData = [];
        $rowCount = 0;
        $tables = PhoneListSetup::pluck('table_name')->all();
    
        foreach ($tables as $key => $value) {
            $data = DB::table($value)->get();
            $rowCount += count($data);
            array_push($allData, $data);
        }
        $allData = $this->paginate($allData[0]);
        $allData->withPath('view-all');
        // $rowCount = PhoneList::count();
        return view('admin.manage-data', ['allData' => $allData, 'rowcount' => $rowCount]);
    }
    public function editPhoneListData(Request $request){
        PhoneList::updatePhoneList($request);
        $this->allData = PhoneList::paginate(10);
        return redirect(route('view.all'))->with('message', 'Successfully updated data!');
    }
    public function peopleSearch(Request $request)
    {
        //dd($request->search);
        $result = $request->search;
        $this->allData = DB::table('phone_lists')
            ->where('first_name', '=',  $result)
            ->orWhere('last_name', '=',  $result)
            ->orWhere('full_name', '=',  $result)
            ->orderBy('full_name', 'ASC')
            ->paginate(15);
        $rowCount = DB::table('phone_lists')
            ->where('first_name', '=',  $result)
            ->orWhere('last_name', '=',  $result)
            ->orWhere('full_name', '=',  $result)
            ->count();
        return view('admin.manage-data', ['allDataName' => $this->allData, 'res' => $result, 'rowcount' => $rowCount]);
    }

    public function manageUser(){
        //dd('hello');
        $this->allData = PhoneListUserModel::paginate(10);
        return view('admin.manage-user', ['allData' => $this->allData]);
    }
    public function deleteUserData($id){
        $this->data = PhoneListUserModel::find($id);
        $this->data->delete();
        return redirect(route('view.all.user'))->with('message', 'Successfully deleted data!');
    }

    public function addNewUser(){
        $this->countries = Country::all();
        return view('admin.newUser', ['country' => $this->countries]);
    }
    public function addNewUserByAdmin(Request $request){
        $this->countries = Country::all();
        $data = $request->all();
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|unique:phone_list_user_models,email',
            'password' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'phone'=>'required|min:11|numeric|unique:phone_list_user_models',
            'country' => 'required',
        ]);
        if ($validator->fails()) {
            //$errors = $validator->errors();
            return view('admin.newUser', ['country' => $this->countries, 'message'=> 'The email or phone number has already been taken!']);
            //return redirect()->back()->with('message', 'The email or phone number has already been taken')->with(['country' => $this->countries]);
        } else {
            $check = $this->create($data);
            $newUser = PhoneListUserModel::where('email', $data['email'])->first();
            PurchasePlan::create($newUser);
            Credit::create([
                'userId' => $newUser->id,
                'useableCredit' => 20,
            ]);
            CreditHistory::createNew($newUser);
        }

        //return redirect()->back()->with('message', 'Successfully added user!')->with(['country' => $this->countries]);
        return view('admin.newUser', ['country' => $this->countries, 'message'=> 'Successfully added user!']);
    }
    public function resetUserPassword(Request $request){
        $this->countries = Country::all();
        $user = PhoneListUserModel::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return view('admin.newUser', ['country' => $this->countries, 'message' => 'Successfully updated password!']);
    }

    public function create(array $data)
    {
        return PhoneListUserModel::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'full_name' => $data['firstName'].' '.$data['lastName'],
            'phone' => $data['phone'],
            'country' => $data['country'],
            'purchasePlan' => 'Free',
            'useAbleCredit' => 20,
        ]);
    }

    public function creditTransfer(){
        $this->allData = PhoneListUserModel::paginate(10);
        return view('admin.creditTransfer', ['userData' => $this->allData]);
    }
    public function updatePlan($planId, $id){

        $this->plan = SetPurchasePlan::find($planId);
        Credit::updateCreditByAdmin($this->plan, $id);
        PhoneListUserModel::updatePlanAndCreditByAdmin($this->plan, $id);

        PurchasePlan::createNewByAdmin($this->plan, $id);




        $this->allData = PhoneListUserModel::paginate(10);

        return redirect(route('transfer.user.credit'))->with(['userData' => $this->allData]);
    }



    public function updateUserCredit(Request $request)
    {
        $this->user = PhoneListUserModel::find($request->id);
        $this->credit = Credit::find($request->id);
        $this->user->update([
            'useAbleCredit' => $request->useAbleCredit,
        ]);
        $this->credit->update([
            'useableCredit' => $request->useAbleCredit,
        ]);
        return redirect()->back()->with('message', 'Successfully updated credit!');
    }
    public function editData($id){
        $this->data = PhoneList::find($id);
        //return view('admin.edit-data', ['data'=>$this->data]);
    }
    public function updateData(Request $request){
        data::updatedata($request);
        return redirect('/manage-data')->with('message', 'Successfully updated data!');
    }
    public function deleteData($id){
        $this->data = PhoneList::find($id);
        $this->data->delete();
        return redirect(route('view.all'))->with('message', 'Successfully deleted data!');
    }
}
