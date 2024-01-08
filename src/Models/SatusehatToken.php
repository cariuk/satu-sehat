<?php

namespace syahrulzzadie\SatuSehat\Models;

use Dotenv\Dotenv;
use Illuminate\Database\Eloquent\Model;

/**
 * Satusehat\Integration\Models\SatusehatToken.
 *
 * @property string $environment
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SatusehatToken extends Model
{
    public $guarded = [];

    public function __construct(array $attributes = [])
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();
        $this->setConnection(getenv('DB_DATABASE_SATU_SEHAT'));

        if (! isset($this->connection)) {
            $this->setConnection(config('satusehatintegration.database_connection'));
        }

        if (! isset($this->table)) {
            $this->setTable(config('satusehatintegration.token_table_name'));
        }

        parent::__construct($attributes);
    }

    protected $primaryKey = 'token';

    public $incrementing = false;

    protected $casts = ['environment' => 'string', 'token' => 'string'];
}
