<?php

namespace App\Jobs;
use App\Models\PhoneList;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldBeUnique;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
// use DB;
use Illuminate\Support\Facades\DB;

class PhoneCsvProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $header;
    public $data;
    public $table_name;
    public $phoneArray=[];

    public function __construct($data, $header, $phoneArray, $table_name)
    {
        $this->data = $data;
        $this->header = $header;
        $this->table_name = $table_name;
        $this->phoneArray = $phoneArray;

        $this->handle();
    }
    
    public function handle()
    {
        $inputArray = [];
        foreach ($this->data as $phone) {
            if (!in_array($phone[0], $this->phoneArray)) {
                array_push($inputArray, array_combine($this->header,array_slice(array_pad($phone, count($this->header),''), 0, count($this->header))));
            }
        }
        // DB::table($this->table_name)->insert($inputArray);

        $inputArrays = array_chunk($inputArray, ceil(count($inputArray)/2));
        foreach ($inputArrays as $key => $inputArray) {
            DB::table($this->table_name)->insert($inputArray);
        }

        // if (count($inputArray) == 500) {
        //   PhoneList::insert($inputArray);
        //   $inputArray = [];
        //}
    }
}
