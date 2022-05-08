<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class ProductDocument extends Model
{
    use HasFactory;

    const STATUS_PENDING = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_FAILED = 3;
    const STATUS_COMPLETED = 4;

    protected $guarded = [];

    public static function listStatus()
    {
	    return [
		    self::STATUS_PENDING => 'Pending', 
		    self::STATUS_PROCESSING => 'Processing', 
		    self::STATUS_FAILED => 'Failed', 
		    self::STATUS_COMPLETED => 'Completed', 
	    ];
    }

    public function StatusLabel()
    {
	    $list = self::listStatus();

	    return isset($list[$this->status])
		    ? $list[$this->status]
		    : $this->status;
    }

    protected function createdSince(): Attribute
    {
	    return Attribute::make(
		    get: fn($value, $attributes) => Carbon::parse($attributes['created_at'])->diffForHumans()
	    );
    }

    protected function formattedCreatedAt(): Attribute
    {
	    return Attribute::make(
		    get: fn($value, $attributes) => Carbon::parse($attributes['created_at'])->format('y-m-d g:ia')
	    );
    }

    public function products()
    {
	    return $this->hasMany(Product::class);
    }
}
