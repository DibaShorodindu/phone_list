<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CSVExportSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'columns',
    ];
    protected static $csvExportColumn;
    protected static $credit;

    public static function create($request)
    {
        self::$csvExportColumn = new CSVExportSettings();
        self::$csvExportColumn->userId   = $request->id;
        self::$csvExportColumn->columns  = 'phone,email,uid,first_name,last_name,full_name,gender,country,location,hometown,relationship_status,education_last_year,work';
        self::$csvExportColumn->save();
    }

    public static function customization($request)
    {
        $request = $request->toArray();
        unset($request["_token"]);
        //dd($request);
        $request = array_filter($request, function($request) {return $request !== "";});
        self::$csvExportColumn = CSVExportSettings::where('userId',Auth::user()->id)->first();
        self::$csvExportColumn->userId   = Auth::user()->id;
        self::$csvExportColumn->columns  = implode(',',$request);
        self::$csvExportColumn->save();
    }
}
