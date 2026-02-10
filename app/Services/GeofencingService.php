<?php

namespace App\Services;

/**
 * Service untuk validasi Geofencing
 * Pusat Kota Tasikmalaya: Latitude -7.3581, Longitude 108.2186
 * Radius: 20 KM
 */
class GeofencingService
{
    // Pusat Tasikmalaya (Koordinat aproksimasi)
    const TASIKMALAYA_LAT = -7.3581;
    const TASIKMALAYA_LNG = 108.2186;
    const RADIUS_KM = 20;

    /**
     * Hitung jarak antara dua titik menggunakan Haversine Formula
     * 
     * @param float $userLat - Latitude pengguna
     * @param float $userLng - Longitude pengguna
     * @param float $centerLat - Latitude pusat (default: Tasikmalaya)
     * @param float $centerLng - Longitude pusat (default: Tasikmalaya)
     * @return float - Jarak dalam KM
     */
    public static function calculateDistance(
        float $userLat,
        float $userLng,
        float $centerLat = self::TASIKMALAYA_LAT,
        float $centerLng = self::TASIKMALAYA_LNG
    ): float {
        $lat1 = deg2rad($userLat);
        $lon1 = deg2rad($userLng);
        $lat2 = deg2rad($centerLat);
        $lon2 = deg2rad($centerLng);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) ** 2 + cos($lat1) * cos($lat2) * sin($lonDelta / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        // Radius bumi dalam KM
        $R = 6371;

        return round($c * $R, 2);
    }

    /**
     * Validasi apakah pengguna berada dalam radius Tasikmalaya
     * 
     * @param float $userLat
     * @param float $userLng
     * @return array - ['isValid' => bool, 'distance' => float, 'message' => string]
     */
    public static function validateLocation(float $userLat, float $userLng): array
    {
        $distance = self::calculateDistance($userLat, $userLng);

        if ($distance <= self::RADIUS_KM) {
            return [
                'isValid' => true,
                'distance' => $distance,
                'message' => "Lokasi Anda berada dalam jangkauan (Jarak: {$distance} KM dari pusat Tasikmalaya)"
            ];
        }

        return [
            'isValid' => false,
            'distance' => $distance,
            'message' => "Lokasi Anda berada di luar jangkauan. Jarak: {$distance} KM dari pusat Tasikmalaya. Maksimal jangkauan: " . self::RADIUS_KM . " KM."
        ];
    }

    /**
     * Get semua pedagang aktif yang berada dalam radius Tasikmalaya
     * Digunakan untuk filter di dashboard pembeli
     * 
     * @return array
     */
    public static function getActivePedagangsInRadius()
    {
        // Query akan dilakukan di Controller/Repository
        // Ini hanya helper untuk validasi individual pedagang
        return [
            'center_lat' => self::TASIKMALAYA_LAT,
            'center_lng' => self::TASIKMALAYA_LNG,
            'radius' => self::RADIUS_KM,
        ];
    }
}
