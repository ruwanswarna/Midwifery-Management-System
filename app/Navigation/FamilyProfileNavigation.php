<?php

declare(strict_types=1);

class FamilyProfileNavigation
{
    public static function items(int $familyId): array
    {
        $baseUrl = '/families/' . $familyId;

        return [
            [
                'title' => 'Overview',
                'url' => $baseUrl
            ],
            [
                'title' => 'Members',
                'url' => $baseUrl . '/members'
            ],
            [
                'title' => 'Children',
                'url' => $baseUrl . '/children'
            ],
            [
                'title' => 'Guardianship',
                'url' => $baseUrl . '/guardianship'
            ],
            // [
            //     'title' => 'Home Details',
            //     'url' => $baseUrl . '/home'
            // ],
            [
                'title' => 'Field Visits',
                'url' => $baseUrl . '/field-visits'
            ],
            // [
            //     'title' => 'Documents',
            //     'url' => $baseUrl . '/documents'
            // ],
            // [
            //     'title' => 'Timeline',
            //     'url' => $baseUrl . '/timeline'
            // ]
        ];
    }
}
