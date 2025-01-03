<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const SEND = 'SEND';
    const ADDED = 'ADDED';
    //vazifani qabul qilish
    const ACCEPT = 'ACCEPT';
    //vazifani rad etish
    const REJECT = 'REJECT';
    protected  $guarded;
}
