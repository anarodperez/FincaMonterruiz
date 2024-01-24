<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Newsletter;
use App\Models\NewsletterSchedule;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $orden = $request->input('orden', 'asc');
        $columna = $request->input('columna', 'created_at');
        $claseOrdenActual = $orden == 'asc' ? 'orden-asc' : 'orden-desc';

        // Iniciar la consulta
        $query = Newsletter::query();

        // Filtrar por rango de fechas
        $fechaInicio = request('fecha_inicio');
        $fechaFin = request('fecha_fin');
        if ($fechaInicio && $fechaFin) {
            $query->whereDate('created_at', '>=', $fechaInicio)->whereDate('created_at', '<=', $fechaFin);
        }

        // Encuentra la newsletter seleccionada
        $selectedNewsletter = Newsletter::where('selected', true)->first();

        // Aplicar ordenación
        $newsletters = Newsletter::orderBy($columna, $orden)->get();
        return view('admin.newsletters.index', compact('newsletters', 'claseOrdenActual','selectedNewsletter'));


    }

    public function create()
    {
        return view('admin.newsletters.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'imagen_url' => 'nullable|url',
            'estado_envio' => 'required|in:pendiente,enviado,programado',
        ]);

        Newsletter::create($data);

        return redirect()
            ->route('admin.newsletters.index')
            ->with('success', 'Newsletter creada con éxito.');
    }

    public function edit($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        return view('admin.newsletters.edit', compact('newsletter'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'titulo' => 'sometimes|required',
            'contenido' => 'sometimes|required',
            'imagen_url' => 'nullable|url',
            'estado_envio' => 'sometimes|required|in:pendiente,enviado,programado',
        ]);

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->update($data);

        return redirect()
            ->route('admin.newsletters.index')
            ->with('success', 'Newsletter actualizada con éxito.');
    }

    public function destroy($id)
    {
        //No puedo borrar la newsletter de bienvenida

        if ($id == 1) {
            return redirect()
                ->back()
                ->with('error', 'No puedes eliminar la newsletter de bienvenida.');
        }

        $newsletter = Newsletter::findOrFail($id);

        if ($newsletter->selected) {
            return redirect()
                ->back()
                ->with('error', 'No puedes eliminar una newsletter que está marcada para enviar.');
        }

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return back()->with('success', 'Newsletter eliminada con éxito.');
    }

    public function enviarNewsletter()
    {
        $suscriptores = Suscriptor::all();
        $newsletter = Newsletter::where('selected', true)->first();

        if ($newsletter) {
            foreach ($suscriptores as $suscriptor) {
                Mail::to($suscriptor->email)->send(new NewsletterMail($newsletter));
            }
        } else {
            // Manejar el caso en que no se encuentra la newsletter seleccionada
        }

        return back()->with('success', 'Newsletter enviado con éxito a todos los suscriptores.');
    }

    public function selectForSending($id)
    {
        // Desmarcar cualquier newsletter actualmente seleccionada
        Newsletter::where('selected', true)->update(['selected' => false]);

        // Marcar la newsletter seleccionada
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->selected = true;
        $newsletter->save();

        return back()->with('success', 'Newsletter seleccionada para el próximo envío.');
    }

    public function preview($id)
    {
        $newsletter = Newsletter::findOrFail($id);

        return view('admin.newsletters.preview', compact('newsletter'));
    }

    public function updateConfig(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday', // Validar el día de la semana
            'execution_time' => 'required|date_format:H:i', // Validar el formato de la hora
        ]);

        // Obtener la configuración existente o crear una nueva si no existe
        $config = NewsletterSchedule::firstOrNew([]);

        // Actualizar la configuración
        $config->day_of_week = $request->day_of_week;
        $config->execution_time = $request->execution_time;
        $config->save();

        return redirect()
            ->back()
            ->with('success', 'Configuración de envío actualizada con éxito.');
    }
}
