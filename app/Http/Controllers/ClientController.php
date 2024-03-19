<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientExport;
use App\Mail\ExportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function liste_client() {
        $clients = Client::all();
        return response()->json($clients);
    }


    public function ajouter_client_traitement(Request $request) {
        $request->validate([
            'name'=>'required',
            'lastName'=>'required',
            'email'=>'required',
            'PhoneNumber' => 'required',
            'Address' => 'required',
            'City' => 'required',
            'Zip' => 'required',
            'Cv' => 'nullable|file|mimes:pdf|max:2048', // Le CV doit être un fichier PDF de taille maximale 2MB
            'Degree' => 'nullable|file|mimes:pdf|max:2048',
            'Passport' => 'nullable|file|mimes:pdf|max:2048',
            'message' =>  'required',
        ]);
    
        // Enregistrer le fichier CV dans un emplacement spécifique
        if ($request->hasFile('Cv')) {
            $cvPath = $request->file('Cv')->store('Cv_files'); // Changez 'cv_files' pour le dossier de destination souhaité
        } else {
            $cvPath = null;
        }

        if ($request->hasFile('Degree')) {
            $DegreePath = $request->file('Degree')->store('Degree_files'); // Changez 'cv_files' pour le dossier de destination souhaité
        } else {
            $DegreePath = null;
        }

        if ($request->hasFile('Passport')) {
            $PassportPath = $request->file('Passport')->store('Passport_files'); // Changez 'cv_files' pour le dossier de destination souhaité
        } else {
            $PassportPath = null;
        }
    
        // $client = new Client();
        // $client->name = $request->name;
        // $client->lastName = $request->lastName;
        // $client->email = $request->email;
        // $client->PhoneNumber = $request->PhoneNumber;
        // $client->Address = $request->Address;
        // $client->City = $request->City;
        // $client->Zip = $request->Zip;
        // $client->cv = $cvPath; // Enregistrer le chemin du fichier CV
        // $client->message = $request->message;
        // $client->save();
    
        // Chemin du fichier PDF
        $pdfPath = $cvPath ? Storage::path($cvPath) : null;
        $DegPath = $DegreePath ? Storage::path($DegreePath) : null;
        $PassPath = $PassportPath ? Storage::path($PassportPath) : null;
    
        // Envoyer l'e-mail avec le fichier PDF en pièce jointe à l'adresse spécifiée
        $destinationEmail = 'dzworkaway@gmail.com';
        Mail::to($destinationEmail)->send(new ExportMail($pdfPath,$DegPath,$PassPath, $request->name, $request->lastName));
    
        // Retourner une réponse JSON pour indiquer que le client a été ajouté avec succès
        return response()->json(['message' => 'Le client a été ajouté avec succès et le fichier PDF a été envoyé par e-mail à ' . $destinationEmail . '.'], 201);
    }
    
}