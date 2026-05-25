<?php

use Carbon\Carbon;

if (!function_exists('timeDifference')) {
    function timeDifference($date)
    {
        // Asegúrate de que $date sea una instancia de Carbon
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        $now = Carbon::now();

        // Si ya pasó un día, retorna la fecha formateada
        if ($now->diffInDays($date) >= 1) {
            return $date->format('d/m/Y'); // Cambia el formato según tus necesidades
        }

        $differenceInSeconds = $now->diffInSeconds($date);

        $timeUnits = [
            'año' => 31536000,
            'mes' => 2592000,
            'semana' => 604800,
            'día' => 86400,
            'hora' => 3600,
            'minuto' => 60,
        ];

        $result = [];

        foreach ($timeUnits as $unit => $seconds) {
            if ($differenceInSeconds >= $seconds) {
                $numberOfUnits = floor($differenceInSeconds / $seconds);
                $result[] = $numberOfUnits . ' ' . $unit . ($numberOfUnits > 1 ? 's' : '');
                $differenceInSeconds -= $numberOfUnits * $seconds;
            }
        }

        $resultString = implode(' ', $result);

        if ($now->greaterThan($date)) {
            return $resultString ? 'hace ' . $resultString : 'justo ahora';
        } else {
            return $resultString ? 'en el futuro ' . $resultString : 'justo ahora';
        }
    }
}

if (!function_exists('formatAmount')) {
    function formatAmount($number, $currency = 'GTQ')
    {
        return number_format((float)$number, 2, '.', ',') . ' ' . $currency;
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($number, $decimals = 2)
    {
        return number_format((float)$number, $decimals, '.', ',');
    }
}
