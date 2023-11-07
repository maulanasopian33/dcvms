<?php

namespace Database\Factories;

use App\Models\visit_dc;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\visit_dc>
 */
class visit_dcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = visit_dc::class;
    public function definition(): array
    {
        $dc = ['cyber', 'techno','area 31'];
        $lead = ['Fadli Aziz','Jamaludin Dummy','Maulana Sopian'];
        $reson = ['Maintenance','Troubleshoot','Visit','Replacement','Installation'];
        $rand = rand(1,3);
        return [
        'UID'           => rand(),
        'id_user'       => $rand,
        'lead_name'     => $lead[$rand-1],
        'lead_email'    => 'sdas',
        'lead_phone'    => '2144545454',
        'lead_nik'      => '55464545646',
        'lead_ktp'      => 'sdasdasdasdasd',
        'lead_signature'=> 'sdasdasdasdasd',
        'success'       => rand(0,1),
        'company_name'  => 'sdasdasdasdasd',
        'reason'        => $reson[rand(0,4)],
        'data_center'   => $dc[array_rand($dc,1)],
        'Date'          => $this->faker->dateTimeBetween('-11 months','+2 months'),
        'teams'         => json_encode($lead),
        'webcam'        => 'sdasda'
        ];
    }
}
