<?php
 
namespace App\View\Composers;

use App\Models\Profil;
use Illuminate\View\View;
 
class ProfilComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // dapatkan data berdasarakan "id"
        $profil = Profil::findOrFail(1);
        
        // tampilkan data ke view
        $view->with('profil', $profil);
    }
}