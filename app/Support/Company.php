<?php

namespace App\Support;

/**
 * Company facts edited in Admin → Company: the location shown on About,
 * Contact and in the footer, and the head count of each department.
 */
class Company
{
    public static function location(): array
    {
        $saved = json_decode((string) Settings::get('company.location'), true) ?: [];

        return array_merge(['city' => null, 'country' => null, 'address' => null, 'note' => null], $saved);
    }

    /**
     * "City, Country", or null until the location is filled in.
     */
    public static function place(): ?string
    {
        $location = static::location();

        return collect([$location['city'], $location['country']])->filter()->implode(', ') ?: null;
    }

    /**
     * Departments from config with their saved head count and visibility.
     */
    public static function departments(bool $visibleOnly = true): array
    {
        $team = json_decode((string) Settings::get('company.team'), true) ?: [];

        $departments = [];
        foreach (config('agency.departments') as $key => $department) {
            $departments[$key] = $department + [
                'size' => $team[$key]['size'] ?? null,
                'visible' => $team[$key]['visible'] ?? true,
            ];
        }

        return $visibleOnly ? array_filter($departments, fn ($d) => $d['visible']) : $departments;
    }

    public static function teamSize(): int
    {
        return (int) array_sum(array_column(static::departments(), 'size'));
    }
}
