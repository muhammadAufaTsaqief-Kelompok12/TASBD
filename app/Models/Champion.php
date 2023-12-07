<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
  
class Champion extends Model
{
    use HasFactory,SoftDeletes;
  
    /**
     * The attributes that are mass assignable.
     *  
     * @var array
     */
    protected $fillable = [
        'id_champion', 'nama_champion', 'desc_champion', 'id_position', 'id_job'
    ];
    protected $primaryKey = 'id_champion';
    protected $KeyType = 'integer';
    public $incrementing = false;
}