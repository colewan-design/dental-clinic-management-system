<?php

namespace Database\Factories;

use App\Models\dentist;
use Illuminate\Database\Eloquent\Factories\Factory;

class dentistFactory extends Factory
{
    protected $model = dentist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected static $counter = 0;

    public function definition()
    {
        static::$counter++;
        $current_month = date('m');
        $current_day = date('d');
        $current_year = date('y');
        $patient_id = 'P' . $current_month . $current_day . $current_year . str_pad(static::$counter, 2, '0', STR_PAD_LEFT);
        
        return [
            'id' => $patient_id,
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'DOB' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }    
}
