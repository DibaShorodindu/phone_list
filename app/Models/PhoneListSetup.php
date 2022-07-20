<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PhoneListSetup extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = "phone_list_setups";


}
