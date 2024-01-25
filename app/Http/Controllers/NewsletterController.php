<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Newsletter;
use App\Models\NewsletterSchedule;

class NewsletterController extends Controller
{public function index(Request $request)
    {
        $orden = $request->input('orden', 'asc');
        $columna = $request->input('columna', 'created_at');
        $claseOrdenActual = $orden == 'asc' ? 'orden-asc' : 'orden-desc';

        // Filtrar por rango de fechas
        $fechaInicio = request('fecha_inicio');
        $fechaFin = request('fecha_fin');
        $query = Newsletter::query();
        if ($fechaInicio && $fechaFin) {
            $query->whereDate('created_at', '>=', $fechaInicio)->whereDate('created_at', '<=', $fechaFin);
        }

        // Encuentra la newsletter seleccionada
        $selectedNewsletter = Newsletter::where('selected', true)->first();

        // Obtener la información de newsletter_schedule (genérica)
        $schedule = NewsletterSchedule::first(); // Obtiene el horario sin asociarlo a una newsletter específica

        // Traducir el día de la semana al español
        $translatedDay = '';
        $executionTime = '';
        if ($schedule) {
            $translatedDays = [
                'Monday' => 'Lunes',
                'Tuesday' => 'Martes',
                'Wednesday' => 'Miércoles',
                'Thursday' => 'Jueves',
                'Friday' => 'Viernes',
            ];

            $translatedDay = $translatedDays[$schedule->day_of_week] ?? '';
            $executionTime = substr($schedule->execution_time, 0, -3); // Preparar la hora de envío para evitar mostrar segundos
        }

        // Aplicar ordenación
        $newsletters = $query->orderBy($columna, $orden)->paginate(5);

        // Pasar datos a la vista
        return view('admin.newsletters.index', compact('newsletters', 'claseOrdenActual', 'selectedNewsletter', 'schedule', 'translatedDay', 'executionTime'));
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

    public function preview($id)
    {
        $newsletter = Newsletter::findOrFail($id);

        return view('admin.newsletters.preview', compact('newsletter'));
    }

    public function updateConfig(Request $request)
    {
        // dd($request);
        $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday', // Validar el día de la semana
            'execution_time' => 'required|date_format:H:i', // Validar el formato de la hora
            'newsletter_id' => 'required|exists:newsletters,id', // Asegurarse de que se proporcione un ID válido de newsletter
        ]);

        // Actualizar la configuración de programación general
        $config = NewsletterSchedule::firstOrNew([]);
        $config->day_of_week = $request->day_of_week;
        $config->execution_time = $request->execution_time;
        $config->save();

        // Desmarcar cualquier newsletter previamente seleccionada
        Newsletter::where('selected', true)->update(['selected' => false]);

        // Marcar la newsletter específica como seleccionada
        $newsletter = Newsletter::findOrFail($request->newsletter_id);
        $newsletter->selected = true;
        $newsletter->save();

        return redirect()
            ->back()
            ->with('success', 'Configuración de envío actualizada y newsletter seleccionada para el próximo envío.');
    }

    public function deselect($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->selected = false;
        $newsletter->save();

        return redirect()
            ->route('admin.newsletters.index')
            ->with('success', 'Newsletter desmarcada con éxito.');
    }
}
