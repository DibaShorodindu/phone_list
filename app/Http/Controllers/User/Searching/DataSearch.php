<?php

namespace App\Http\Controllers\User\Searching;

use App\Exports\CustomExport;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\DownloadedList;
use App\Models\ExportHistori;
use App\Models\PhoneList;
use App\Models\PhoneListUserModel;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class DataSearch extends Controller
{
    protected $allData;
    protected $allDataIds;
    protected $getdownloadedId;

    public function filter_data($request)
    {
        $getdownloadedIds = 0;
        foreach ($this->allDataIds as $dataIds) {
            $getdownloadedIds = $getdownloadedIds . ',' . $dataIds->downloadedIds;
        }
        $this->getdownloadedId = $getdownloadedIds;
        //$query = DB::table('phone_lists')
        $query = QueryBuilder::for(PhoneList::class)
            ->whereNotIn('id', explode(',', $this->getdownloadedId));

        if ($request->name != null) {
            $query =  $query->where(function ($query) use ($request) {
                $query->where('first_name', '=', $request->name)
                    ->orWhere('last_name', '=', $request->name)
                    ->orWhere('full_name', '=', $request->name);
            });
        }
        if ($request->location != null) {
            $query =  $query->where(function ($query) use ($request) {
                $query->where('location', '=', $request->location)
                    ->orWhere('location_city', '=', $request->location)
                    ->orWhere('location_city', '=', ' ' . $request->location)
                    ->orWhere('location_state', '=', ' ' . $request->location)
                    ->orWhere('location_state', '=', ' ' . $request->location . "'")
                    ->orWhere('location_region', '=', ' ' . $request->location);
            });
        }
        if ($request->hometown != null) {
            $query =  $query->where(function ($query) use ($request) {
                $query->where('hometown', '=', $request->hometown)
                    ->orwhere('hometown_city', '=', $request->hometown)
                    ->orwhere('hometown_city', '=', ' ' . $request->hometown)
                    ->orWhere('hometown_state', '=', ' ' . $request->hometown)
                    ->orWhere('hometown_state', '=', ' ' . $request->hometown . "'")
                    ->orWhere('hometown_region', '=', ' ' . $request->hometown);
            });
        }
        if ($request->country != null) {
            $query =  $query->where('country', '=', $request->country);
        }
        if ($request->gender != null) {
            $query =  $query->where('gender', '=', $request->gender);
        }
        if ($request->relationship_status != null) {
            $query =  $query->where('relationship_status', '=', $request->relationship_status);
        }
        if ($request->age != null) {
            $query =  $query->where('age', 'like', '%/' . $request->age);
        }

        $results = $query->orderBy('full_name', 'ASC');
        return $results;
    }
    public function customExport(Request $request)
    {
        // dd($req uest->name);
            $credit=Credit::where('userId',Auth::user()->id)->first();
            $this->allDataIds = DownloadedList::where('userId', Auth::user()->id)->get();
            $getdownloadedIds = 0;
            foreach ($this->allDataIds as $dataIds) {
                $getdownloadedIds = $getdownloadedIds . ',' . $dataIds->downloadedIds;
            }
            if($request->age != null)
            {
                Credit::filterCredit();
                $validated = $request->validate([
                    'age' => 'required|digits:4',
                ]);
                $age = $validated['age'];
                

            }
            $response_data = $this->filter_data($request);
        $this->allData = $response_data->get();


            if($request->limit != null)
            {
                $allDatas = $this->allData->pluck('id')->take($request->limit);
            }
            else
            {
                $allDatas = $this->allData->pluck('id');
            }
            $array = $allDatas->toArray();
            $preDownloaded = count($array);
            $preDownloaded2 = $preDownloaded - (count(array_intersect($allDatas->toArray(), explode(',',$getdownloadedIds ))));

            if ($credit->useableCredit >= $preDownloaded2)
            {
                Credit::allDataCradit($preDownloaded, $array);
                ExportHistori::allDataExportHistori($preDownloaded, $allDatas);
                DownloadedList::createAllNew($allDatas);
                CreditHistory::createAll($preDownloaded);
                PhoneListUserModel::updateUseAbleCredit($allDatas);

                return (new CustomExport($allDatas->toArray()))->download('phoneList.xlsx');
            }
            else
            {
                return redirect('/settings/upgrade');
        }
    }

    public function downloadData(Request $request)
    {
        $credit = Credit::where('userId', Auth::user()->id)->first();
        $allDataIds = DownloadedList::where('userId', Auth::user()->id)->get();
        $getdownloadedIds = 0;
        foreach ($allDataIds as $dataIds) {
            $getdownloadedIds = $getdownloadedIds . ',' . $dataIds->downloadedIds;
        }
        $preDownloaded = count($request->chk) - (count(array_intersect($request->chk, explode(',', $getdownloadedIds))));


        if ($credit->useableCredit >= $preDownloaded) {
            Credit::updateUserCradit($request);
            ExportHistori::newExportHistori($request);
            DownloadedList::createNew($request);
            CreditHistory::create($request);
            PhoneListUserModel::updateUseAbleCredit($request);

            return (new CustomExport($request->chk))->download('phoneList.xlsx');
        } else {
            return redirect('/settings/upgrade');
        }
    }
}
