
<?php

//*
// Start Hare
//! End hare

//*
// Start Hare
//! End hare

//* number 3
// Start Hare
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllModelTest extends Model
{
    use HasFactory;

    protected $table = "testvsadata";

    protected $fillable = [
        'lpt_product_name',
        'asq_desc',
        'cln_principal_balance',
        'provision_amount',
        'outstanding',
        'cln_product_type_code',
        'asq_code',
    ];
}
//! End hare

//* Number 2
// Start Hare
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllModelTest extends Model
{
    use HasFactory;

    protected $table = "services";

    // protected $fillable = [
    //     'lpt_product_name',
    //     'asq_desc',
    //     'cln_principal_balance',
    //     'provision_amount',
    //     'outstanding',
    // ];
    protected $fillable = [
        'id',
        'servicename',
        'brif',
    ];
}

//! End hare

//* Number 1
// Start Hare

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllModelTest extends Model
{
    use HasFactory;

    protected $table = "testvsadata";

    protected $fillable = [
        'lpt_product_name',
        'asq_desc',
        'cln_principal_balance',
        'provision_amount',
        'outstanding',
    ];
}
//! End hare
