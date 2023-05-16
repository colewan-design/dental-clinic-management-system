<?php

namespace Database\Factories;

use App\Models\appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class appointmentFactory extends Factory
{
    protected $model = appointment::class;

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
        $appointment_id = 'AP' . $current_month . $current_day . $current_year . str_pad(static::$counter, 2, '0', STR_PAD_LEFT);
        $patient_id = 'P' . $current_month . $current_day . $current_year . str_pad(static::$counter, 2, '0', STR_PAD_LEFT);
        $dentist_id = 'D' . $current_month . $current_day . $current_year . str_pad(static::$counter, 2, '0', STR_PAD_LEFT);
        
        return [
            'id' => $appointment_id,
            'patient_id' => $patient_id,
            'dentist_id' => $dentist_id,
            'date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'), // Assuming date is in YYYY-MM-DD format
            'time' => $this->faker->time('H:i:s'), // Assuming time is in HH:MM:SS format
            'status' => $this->faker->randomElement(['cancelled', 'active']),
        ];
        
    }    
}
