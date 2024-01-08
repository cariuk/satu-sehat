<?php

namespace syahrulzzadie\SatuSehat\Models;

use Dotenv\Dotenv;
use Illuminate\Database\Eloquent\Model;

/**
 * Satusehat\Integration\Models\Icd10.
 *
 * @property string $icd10_code
 * @property string $icd10_en
 * @property string $icd10_id
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Icd10 extends Model
{
    public $table;

    public $guarded = [];

    public function __construct(array $attributes = [])
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();
        $this->setConnection(getenv('DB_DATABASE_SATU_SEHAT'));
        
        if (!isset($this->connection)) {
            $this->setConnection(config('satusehatintegration.database_connection'));
        }

        if (!isset($this->table)) {
            $this->setTable(config('satusehatintegration.icd10_table_name'));
        }

        parent::__construct($attributes);
    }

    protected $primaryKey = 'icd10_code';

    public $incrementing = false;

    protected $casts = ['icd10_code' => 'string', 'icd10_en' => 'string', 'icd10_id' => 'string'];
}
