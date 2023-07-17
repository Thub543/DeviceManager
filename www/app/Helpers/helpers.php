<?php
use Illuminate\Support\Facades\DB;


function generateInventoryID($type_id)
{
    // Ermittele das Präfix basierend auf dem Gerätetyp
    $prefix = DB::table('types')
        ->where('id', $type_id)
        ->value('type_initials');

    // Ermittele die höchste verwendete Inventarnummer für den Gerätetyp
    $max = DB::table('devices')
        ->join('devicemodels', 'devicemodels.id', '=', 'devices.devicemodel_id')
        ->join('types', 'types.id', '=', 'devicemodels.type_id')
        ->where('types.id', $type_id)
        ->max('inventory_id');

    // Erhöhe die höchste verwendete Nummer um 1 und füge sie mit dem Präfix zur ID zusammen
    $maxnum = str_pad(intval(substr($max, -4)) + 1, 4, '0', STR_PAD_LEFT);
    $id = $prefix.'-'.$maxnum;

    // Prüfe, ob die ID bereits vorhanden ist, und generiere gegebenenfalls eine neue ID
    $exists = DB::table('devices')
        ->where('inventory_id', $id)
        ->exists();
    while ($exists) {
        $maxnum++;
        $id = $prefix . '-' . str_pad($maxnum, 4, '0', STR_PAD_LEFT);
        $exists = DB::table('devices')
            ->where('inventory_id', $id)
            ->exists();
    }

    return $id;
}


