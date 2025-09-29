<?php

namespace App\Http\Livewire;

use App\Helpers\Utils;
use App\Models\Order;
use Livewire\Component;
use App\Models\Department;
use Gloudemans\Shoppingcart\Facades\Cart;

class CreateOrder extends Component
{
    public $departments, $cities = [], $districts = [];

    public $departmentId = '', $cityId = '', $districtId = '';

    public $contact, $phone, $address, $references, $shippingCost = 0;

    public $pickupType = 'store';

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function render()
    {
        return view('livewire.create-order');
    }

    public function updatedPickupType($pickupType)
    {
        if ($pickupType == 'store') {
            $this->resetValidation(['departmentId','cityId','districtId','shippingCost','address','references']);
        }
    }

    public function updatedDepartmentId($departmentId)
    {
        $this->departments = Department::with('cities')->get();

        if ($department = $this->departments->firstWhere('id', $departmentId)) {
            $this->cities = $department->cities;
            $this->reset(['cityId','districtId','districts','shippingCost']);
        } else {
            $this->reset(['departmentId','cityId','districtId','cities','districts','shippingCost']);
        }
    }

    public function updatedCityId($cityId)
    {
        if ($department = Department::with('cities.districts')->find($this->departmentId)) {
            $this->cities = $department->cities;
            if ($city = $department->cities->firstWhere('id', $cityId)) {
                $this->shippingCost = $city->cost;
                $this->districts = $city->districts;
                $this->reset(['districtId']);
            } else {
                $this->reset(['cityId','districtId','districts','shippingCost']);
            }
        } else {
            $this->departments = Department::all();
            $this->reset(['departmentId','cityId','districtId','cities','districts','shippingCost']);
        }
    }

    public function createOrder()
    {
        $this->validate([
            'contact' => 'required',
            'phone' => 'required',
            'pickupType' => 'required',
            'departmentId' => 'required_if:pickupType,delivery',
            'cityId' => 'required_if:pickupType,delivery',
            'districtId' => 'required_if:pickupType,delivery',
            'address' => 'required_if:pickupType,delivery',
            'references' => 'required_if:pickupType,delivery',
        ]);

        $newOrder = Order::create([
            'user_id' => auth()->user()->id,
            'contact' => $this->contact,
            'phone' => $this->phone,
            'pickup_type' => $this->pickupType,
            'shipping_cost' => $this->shippingCost,
            'total' => $this->shippingCost + Cart::subtotal(),
            'content' => Cart::content(),

            'department_id' => !empty($this->departmentId) ? $this->departmentId : null,
            'city_id' => !empty($this->cityId) ? $this->cityId : null,
            'district_id' => !empty($this->districtId) ? $this->districtId : null,
            'address' => !empty($this->address) ? $this->address : null,
            'references' => !empty($this->references) ? $this->references : null,
        ]);

        foreach (Cart::content() as $item) {
            Utils::discount($item);
        }

        Cart::destroy();

        return redirect()->route('orders.payment', $newOrder);
    }
}
