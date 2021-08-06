<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class UserImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'id' => $row[0],
            'username' => $row[1],
            'email' => $row[2],
            'password' => $row[3],
            'id_role' => $row[4]
            ]
        );
    }
    public function startRow(): int
    {
        return 2;
    }
}
