<?php

return [
    'welcome' => 'Bienvenue dans notre application!',
    'hello' => 'Bonjour, :name',
    'goodbye' => 'Au revoir, :name!',
    'user' => [
        'created' => 'Utilisateur créé avec succès.',
        'updated' => 'Utilisateur mis à jour avec succès.',
        'deleted' => 'Utilisateur supprimé avec succès.',
        'not_found' => 'Utilisateur non trouvé.',
    ],
    'post' => [
        'created' => 'Publication créée avec succès.',
        'updated' => 'Publication mise à jour avec succès.',
        'deleted' => 'Publication supprimée avec succès.',
        'not_found' => 'Publication non trouvée.',
    ],
    'validation' => [
        'required' => 'Le champ :attribute est obligatoire.',
        'email' => 'Le champ :attribute doit être une adresse email valide.',
        'max' => [
            'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        ],
        'min' => [
            'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
        ],
    ],
    'auth' => [
        'failed' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
        'throttle' => 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
    ],
];
