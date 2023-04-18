<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;


    // FILLABLE
    protected $fillable = ['type_id', 'title', 'text', 'image'];

    // RELAZIONE CON TABLE TYPES
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    // ABSTRACT FUNCTION
    public function getAbstract($max = 50)
    {
        return substr($this->text, 0, $max) . "...";
    }
    // FUNZIONE GESTIONE SLUG-Funzione statica-genera uno slug unico che aggiunge un "-" più un numero crescente se riscontra nel DataBase uno slug uguale
    public static function generateUniqueSlug($title)
    {
        $possible_slug = Str::of($title)->slug('-');
        $projects = Project::where('slug', $possible_slug)->get();
        $original_slug = $possible_slug;
        $i = 2;
        // CICLO in cui entro solo se la collection è != da 0 quindi non è vuota e lo slug non è unico (quindi si ripete).
        while (count($projects)) {
            // Allora aggiungi allo slug originale un trattino e un numero
            $possible_slug = $original_slug . "-" . $i;
            // Riprendi nel singolo progetto lo slug e il possibile slug; Modello 'eloquent'che matcha la mia tabella db- questa è una QUERY dove chiedo al model Project che è un 'macth' della mia tabella dove slug è uguale a possible slug- get è come SELECT*
            $projects = Project::where('slug', '=', $possible_slug)->get();
            // Incrementa di uno il numero ogni volta
            $i++;
        }
        // RETURN
        return $possible_slug;
    }

    // FUNZIONI PER FORMATTARE DATE
    // public function getCreatedAttribute()
    // {
    //     return date('d/m/Y H:i', strtotime($this->created_at));
    // }

    // MUTATOR- lo richiamo semplicemente con la freccia
    protected function getCreatedAtAttribute($value)
    {
        return date('d/m/Y H:i', strtotime($value));
    }
    // FUNZIONI PER FORMATTARE DATE- richiamo la funzione
    public function getUpdatedAttribute()
    {
        return date('d/m/Y H:i', strtotime($this->updated_at));
    }

    // FUNZIONE GETTER PER IMMAGINI- per avere sempre o il percorso dell'immagine caricato o un placeholder qual'ora non fosse stata caricata nessuna immagine
    public function getImageUri()
    {
        return $this->image ? asset('storage/' . $this->image) : 'https://picsum.photos/300/500';
    }
}
