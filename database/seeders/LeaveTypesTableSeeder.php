<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leave_types')->insert([
            [
                'name' => 'Casual/Earned Leaves',
                'total_days' => 12,
                'type' => 'annual',
                'conditions' => json_encode([
                    'conditionType' => [
                        'probation',
                        'lapse',
                        'restriction',
                        'sandwich',
                        'save_and_take'
                    ],
                    'conditionDescriptions' => [
                        'Can avail after 3 months of probation, entitlement starts from DOJ.',
                        'Leaves lapse on 31st March but can be encashed.',
                        'Cannot take all 12 leaves in one go, special approval required for urgent cases.',
                        'One sandwich leave in two months, beyond that is LWP.',
                        'Can take saved three leaves together at the quarter end with pre-approval.'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emergency Leaves',
                'total_days' => 6,
                'type' => 'annual',
                'conditions' => json_encode([
                    'conditionType' => [
                        'probation',
                        'lapse',
                        'restriction',
                        'sandwich'
                    ],
                    'conditionDescriptions' => [
                        'Can avail during probation period.',
                        'Leaves lapse on 31st March but can be encashed.',
                        'Cannot take all 6 leaves in one go, special approval required for urgent cases.',
                        'One sandwich leave in two months, beyond that is LWP.'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Short Leaves',
                'total_days' => 2,
                'type' => 'monthly',
                'conditions' => json_encode([
                    'conditionType' => [
                        'probation',
                        'shift_timing',
                        'lapse',
                        'sandwich',
                        'half_day',
                        'shift_change'
                    ],
                    'conditionDescriptions' => [
                        'Can avail during probation period.',
                        'Short Leave can be taken at Shift Start/Before Shift End.',
                        'Short Leave lapses at month end.',
                        'One sandwich leave in a month, beyond that is absent.',
                        'Short Leave exceeding two hours is considered Half Day.',
                        'Can change shift timing from 10:00 AM - 06:00 PM to 9:00 AM - 05:00 PM.'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bereavement Leaves',
                'total_days' => 5,
                'type' => 'single',
                'conditions' => json_encode([
                    'conditionType' => [
                        'all_at_once',
                    ],
                    'conditionDescriptions' => [
                        'Leave for mourning the death of a close family member.'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wedding Leaves',
                'total_days' => 7,
                'type' => 'single',
                'conditions' => json_encode([
                    'conditionType' => [
                        'all_at_once',
                    ],
                    'conditionDescriptions' => [
                        '7 paid leaves for wedding, including weekends, without affecting Casual and Emergency leaves.'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
