<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{

    public function model(array $row)
    {

        return new User([
            '商品圖片網址'  => $row['url'],
            '商品名稱' => $row['name'],
            '商品價格'    => $row['price'],
            '商品數量' =>$row['num'],
            '商品規格' =>$row['category'],
            '商品備註' =>$row['notes'],
        ]);
    }
}
