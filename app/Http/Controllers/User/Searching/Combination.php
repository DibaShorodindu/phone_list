<?php

namespace App\Http\Controllers\User\Searching;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\DownloadedList;
use App\Models\PhoneList;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;


class Combination extends Controller
{
    protected $allData;
    protected $allDataIds;
    protected $countries;
    public function peopleSearchCombination(Request $request)
    {
        $this->countries = Country::all();
        $this->allDataIds = DownloadedList::where('userId', Auth::user()->id)->get();
        $getdownloadedIds = 0;
        foreach ($this->allDataIds as $dataIds)
        {
            $getdownloadedIds = $getdownloadedIds.','.$dataIds->downloadedIds;
        }
        $result = $request->name;


        if ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country == null && $request->countryInputName == null && $request->gender == null && $request->relationship_status == null)
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('first_name', '=',  $request->name)
                ->orWhere('last_name', '=',  $request->name)
                ->orWhere('full_name', '=',  "$request->name")
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount =DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('first_name', '=',  $request->name)
                ->orWhere('last_name', '=',  $request->name)
                ->orWhere('full_name', '=',  "$request->name")
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'count' => $dataCount]);
        }

        elseif ( $request->location != null && $request->name == null && $request->hometown == null &&
            $request->country == null && $request->countryInputName == null && $request->gender == null && $request->relationship_status == null)
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('location', '=', $request->location)
                ->orWhere('location_city', '=', $request->location)
                ->orWhere('location_city', '=', ' '.$request->location)
                ->orWhere('location_state', '=', ' '.$request->location)
                ->orWhere('location_state', '=', ' '.$request->location."'")
                ->orWhere('location_region', '=', ' '.$request->location)

                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('location', '=', $request->location)
                ->orWhere('location_city', '=', $request->location)
                ->orWhere('location_city', '=', ' '.$request->location)
                ->orWhere('location_state', '=', ' '.$request->location)
                ->orWhere('location_state', '=', ' '.$request->location."'")
                ->orWhere('location_region', '=', ' '.$request->location)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'count' => $dataCount ]);
        }

        elseif ( $request->hometown != null && $request->name == null && $request->location == null
            && $request->country == null && $request->countryInputName == null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('hometown', '=', $request->hometown)
                ->orwhere('hometown_city', '=', $request->hometown)
                ->orwhere('hometown_city', '=', ' '.$request->hometown)
                ->orWhere('hometown_state', '=', ' '.$request->hometown)
                ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                ->orWhere('hometown_region', '=', ' '.$request->hometown)

                ->orderBy('full_name', 'ASC')
                ->paginate(15);

            $dataCount = DB::table('phone_lists')
                ->where('hometown', '=', $request->hometown)
                ->orwhere('hometown_city', '=', $request->hometown)
                ->orwhere('hometown_city', '=', ' '.$request->hometown)
                ->orWhere('hometown_state', '=', ' '.$request->hometown)
                ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                ->orWhere('hometown_region', '=', ' '.$request->hometown)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown' => $request->hometown, 'count' => $dataCount]);
        }

        elseif ( $request->hometown == null && $request->name == null && $request->location == null
            && $request->country != null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('country', '=', $request->country)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('country', '=', $request->country)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'countries' => $request->country,'count' => $dataCount ]);
        }

        elseif ( $request->hometown == null && $request->name == null && $request->location == null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {

            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'gender' => $request->gender, 'count' => $dataCount ]);
        }
        elseif ( $request->hometown == null && $request->name == null && $request->location == null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount ]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country == null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country == null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })

                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })

                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'hometown' => $request->hometown, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country != null  && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('country', '=', $request->country)
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('country', '=', $request->country)
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->count();

            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'countries' => $request->country, 'count' => $dataCount ]);
        }
        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('gender', '=', $request->gender)
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('gender', '=', $request->gender)
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->count();

            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'gender' => $request->gender, 'count' => $dataCount]);
        }
        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('relationship_status', '=', $request->relationship_status)
                ->groupBy('full_name')
                ->having('first_name', '=', $request->name)
                ->orHaving('last_name', '=', $request->name)
                ->orHaving('full_name', '=', $request->name)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('relationship_status', '=', $request->relationship_status)
                ->groupBy('full_name')
                ->having('first_name', '=', $request->name)
                ->orHaving('last_name', '=', $request->name)
                ->orHaving('full_name', '=', $request->name)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })

                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })

                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })

                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown' => $request->hometown, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('country', '=', $request->country)
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('country', '=', $request->country)
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'countries' => $request->country, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('gender', '=', $request->gender)
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('gender', '=', $request->gender)
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('relationship_status', '=', $request->relationship_status)
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('relationship_status', '=', $request->relationship_status)
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('country', '=', $request->country)
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('country', '=', $request->country)
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown'=>$request->hometown, 'countries' => $request->country, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('gender', '=', $request->gender)
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('gender', '=', $request->gender)
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown'=>$request->hometown, 'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown != null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('relationship_status', '=', $request->relationship_status)
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('relationship_status', '=', $request->relationship_status)
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown'=>$request->hometown, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'countries'=>$request->country, 'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown == null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'countries'=>$request->country, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'gender'=>$request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'location'=>$request->location, 'hometown' => $request->hometown,
                'count' => $dataCount]);
        }
        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'location'=>$request->location, 'countries' => $request->country,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'location'=>$request->location, 'gender' => $request->gender,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'location'=>$request->location,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'hometown'=>$request->hometown, 'countries' => $request->country,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'hometown'=>$request->hometown, 'gender' => $request->gender,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'hometown'=>$request->hometown,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'countries'=>$request->country, 'gender' => $request->gender,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'countries'=>$request->country,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'gender'=>$request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name'=>$request->name, 'gender'=>$request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown'=>$request->hometown,
                'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown'=>$request->hometown,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'countries'=>$request->country,
                'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'countries'=>$request->country,
                'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'countries'=>$request->country,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'gender'=>$request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown'=>$request->hometown, 'countries'=>$request->country,
                'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown'=>$request->hometown, 'countries'=>$request->country,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown'=>$request->hometown, 'gender'=>$request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'countries'=>$request->country, 'gender'=>$request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }


        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'count' => $dataCount ]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'hometown'=>$request->hometown,
                'gender' => $request->gender , 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'hometown'=>$request->hometown,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location,
                'countries' => $request->country, 'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location,
                'countries' => $request->country, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location,
                'gender' => $request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name,
                'countries' => $request->country, 'gender' => $request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'hometown'=>$request->hometown,
                'gender' => $request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown'=>$request->hometown,
                'gender' => $request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location,
                'countries' => $request->country, 'gender' => $request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'hometown'=>$request->hometown,
                'countries' => $request->country, 'gender' => $request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }


        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status == null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'gender' => $request->gender, 'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender == null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country == null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'hometown'=>$request->hometown,
                'gender' => $request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location != null && $request->hometown == null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'countries' => $request->country,
                'gender' => $request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name != null && $request->location == null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'hometown'=>$request->hometown, 'countries' => $request->country,
                'gender'=> $request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }

        elseif ( $request->name == null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'location'=>$request->location, 'hometown'=>$request->hometown,'countries' => $request->country,
                'gender' => $request->gender, 'relationship_status' => $request->relationship_status,
                'count' => $dataCount]);
        }


        elseif ( $request->name != null && $request->location != null && $request->hometown != null
            && $request->country != null && $request->gender != null && $request->relationship_status != null )
        {
            $this->allData = DB::table('phone_lists')
                ->whereNotIn('id', explode(',',$getdownloadedIds))
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->orderBy('full_name', 'ASC')
                ->paginate(15);
            $dataCount = DB::table('phone_lists')
                ->where(function ($query) use ($request) {
                    $query->where('first_name', '=',  $request->name)
                        ->orWhere('last_name', '=',  $request->name)
                        ->orWhere('full_name', '=',  "$request->name");
                })
                ->where(function ($query) use ($request) {
                    $query->where('location', '=', $request->location)
                        ->orWhere('location_city', '=', $request->location)
                        ->orWhere('location_city', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location)
                        ->orWhere('location_state', '=', ' '.$request->location."'")
                        ->orWhere('location_region', '=', ' '.$request->location)
                    ;
                })
                ->where(function ($query) use ($request) {
                    $query->where('hometown', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', $request->hometown)
                        ->orwhere('hometown_city', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown)
                        ->orWhere('hometown_state', '=', ' '.$request->hometown."'")
                        ->orWhere('hometown_region', '=', ' '.$request->hometown)
                    ;
                })
                ->where('country', '=', $request->country)
                ->where('gender', '=', $request->gender)
                ->where('relationship_status', '=', $request->relationship_status)
                ->count();
            return view('userDashboard.people', ['allData' => $this->allData, 'country' => $this->countries,
                'name' => $request->name, 'location'=>$request->location, 'hometown'=>$request->hometown,
                'countries' => $request->country, 'gender' => $request->gender,
                'relationship_status' => $request->relationship_status, 'count' => $dataCount]);
        }


    }
}
