<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    //   protected $table = 'secrets';
    //   protected $primaryKey = 'id';

    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    public function test_models()
    {
        //$secret = Secret::factory()->make();
    }
}
