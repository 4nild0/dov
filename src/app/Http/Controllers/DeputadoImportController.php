<?php
// app/Http/Controllers/DeputadoImportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportarDeputadoJob;

class DeputadoImportController extends Controller {
    public function importar(Request $request) {
        $request->validate(['id' => 'required|integer']);
        ImportarDeputadoJob::dispatch($request->id);

        return response()->json(['message' => 'Deputado enviado para importação']);
    }
}
