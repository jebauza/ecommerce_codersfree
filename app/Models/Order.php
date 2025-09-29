<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\District;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = ['id', 'status', 'created_at', 'updated_at'];

    const STATUS_PENDING = 'pending';
    const STATUS_RECEIVED = 'received';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_COMPLETED = 'completed';
    const STATUS_ANNULED = 'annuled';
    const STATUS_CANCELED = 'canceled';

    const PICKUP_DELIVERY = 'delivery';
    const PICKUP_STORE = 'store';

    /**
     * Scope a query to only include pending orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePending($query)
    {
        $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include received orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeReceived($query)
    {
        $query->where('status', self::STATUS_RECEIVED);
    }

    /**
     * Scope a query to only include shipped orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeShipped($query)
    {
        $query->where('status', self::STATUS_SHIPPED);
    }

    /**
     * Scope a query to only include completed orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeCompleted($query)
    {
        $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include annuled orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeAnnuled($query)
    {
        $query->where('status', self::STATUS_ANNULED);
    }

    /**
     * Scope a query to only include canceled orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeCanceled($query)
    {
        $query->where('status', self::STATUS_CANCELED);
    }

    /**
     * Get the department that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    /**
     * Get the city that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    /**
     * Get the district that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
