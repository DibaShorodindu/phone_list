<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneListSearch extends Model
{
    protected static $phoneList;
    use HasFactory;
    protected $fillable = [
        'phoneList_id',
        'phone',
        'email',
        'uid',
        'first_name',
        'last_name',
        'full_name',
        'gender',
        'country',
        'location',
        'location_city',
        'location_state',
        'location_region',
        // 'location_country',
        'hometown',
        'hometown_city',
        'hometown_state',
        'hometown_region',
        // 'hometown_country',
        'relationship_status',
        'education_last_year',
        'work',
    ];

    public static function newPhoneList($request)
    {
        $location_info = explode(',', $request->location);
        if(count($location_info) == 1)
        {
            $location_info[1] = null;
            $location_info[2] = null;
            $location_info[3] = null;

        }
        elseif (count($location_info) == 2)
        {
            $location_info[2] = null;
            $location_info[3] = null;
        }
        elseif (count($location_info) == 3)
        {
            $location_info[3] = null;
        }
        elseif ($location_info == null)
        {
            $location_info[0] = null;
            $location_info[1] = null;
            $location_info[2] = null;
            $location_info[3] = null;
        }


        $hometown_info = explode(',', $request->hometown);
        if(count($hometown_info) == 1)
        {
            $hometown_info[1] = null;
            $hometown_info[2] = null;
            $hometown_info[3] = null;

        }
        elseif (count($hometown_info) == 2)
        {
            $hometown_info[2] = null;
            $hometown_info[3] = null;
        }
        elseif (count($hometown_info) == 3)
        {
            $hometown_info[3] = null;
        }
        elseif ($hometown_info == null)
        {
            $hometown_info[0] = null;
            $hometown_info[1] = null;
            $hometown_info[2] = null;
            $hometown_info[3] = null;
        }
        self::$phoneList = new PhoneListSearch();
        self::$phoneList->phoneList_id              = $request->id;
        self::$phoneList->phone                     = $request->phone;
        self::$phoneList->uid                       = $request->uid;
        self::$phoneList->email                     = $request->email;
        self::$phoneList->first_name                = $request->first_name;
        self::$phoneList->last_name                 = $request->last_name;
        self::$phoneList->full_name                      = $request->first_name.' '.$request->last_name;
        self::$phoneList->gender                    = $request->gender;
        self::$phoneList->country                   = $request->country;
        self::$phoneList->location                  = $request->location;
        self::$phoneList->location_city             = $location_info[0];
        self::$phoneList->location_state            = $location_info[1];
        self::$phoneList->location_region           = $location_info[2];
        // self::$phoneList->location_country          = $location_info[3];
        self::$phoneList->hometown                  = $request->hometown;
        self::$phoneList->hometown_city             = $hometown_info[0];
        self::$phoneList->hometown_state            = $hometown_info[1];
        self::$phoneList->hometown_region           = $hometown_info[2];
        // self::$phoneList->hometown_country          = $hometown_info[3];
        self::$phoneList->relationship_status       = $request->relationship_status;
        self::$phoneList->education_last_year       = $request->education_last_year;
        self::$phoneList->work                      = $request->work;
        self::$phoneList->save();
    }
}
