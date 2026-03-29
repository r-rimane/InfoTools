<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Produit - Représente un article du catalogue commercial.
 * Gère les informations de tarification, de catégorisation et les niveaux de stock.
 */
class Produit extends Model
{
    use HasFactory;

    /**
     * Nom de la table associée au modèle.
     * @var string
     */
    protected $table = 'produit';

    /**
     * Indique si le modèle doit être horodaté.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs pouvant être assignés massivement.
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'catégorie',
        'prix',
        'stock',
    ];
}