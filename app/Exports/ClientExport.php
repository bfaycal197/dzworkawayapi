<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientExport implements FromCollection
{
    public function collection()
    {
        // Récupérer la dernière entrée de la base de données
        $latestClient = Client::latest()->first();

        // Créer une collection avec la dernière entrée
        $collection = collect([$latestClient]);

        return $collection;
    }
}
