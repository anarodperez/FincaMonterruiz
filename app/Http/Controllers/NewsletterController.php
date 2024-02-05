<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Newsletter;
use App\Models\NewsletterSchedule;
use Illuminate\Support\Facades\Storage;

class NewsletterController extends Controller
{
    public function index(Request $request)
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
        $selectedNewsletter = Newsletter::where('selected', true)->where('id', '!=', 1)->first();
        $otraNewsletterSeleccionada = Newsletter::where('id', '!=', 1)->where('selected', true)->exists();

        // Obtener la información de newsletter_schedule
        $schedule = NewsletterSchedule::first();

        // Traducir el día de la semana
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

        return view('admin.newsletters.index', compact('newsletters', 'claseOrdenActual', 'selectedNewsletter', 'otraNewsletterSeleccionada', 'schedule', 'translatedDay', 'executionTime'));
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
        ]);

        // Procesar el archivo de imagen si se proporciona
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . str_replace(' ', '_', $imagen->getClientOriginalName());
            $rutaCompleta = 'public/images/' . $nombreImagen;

            // Subir el archivo a S3 y obtener la URL pública
            Storage::disk('s3')->put($rutaCompleta, file_get_contents($imagen), 'public');
            $urlImagen = Storage::disk('s3')->url($rutaCompleta);

            // Asignar la URL de la imagen al campo correcto para la base de datos
            $data['imagen_url'] = $urlImagen;
        } else {
            $data['imagen_url'] = null;
        }

        // Crear el registro en la base de datos con la URL de la imagen
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
        $newsletter = Newsletter::find($id);
        if (!$newsletter) {
            return redirect()->route('admin.newsletters.index')->with('error', '¡Newsletter no encontrada!');
        }

        $data = $request->validate([
            'titulo' => 'sometimes|required',
            'contenido' => 'sometimes|required',
             'imagen' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar la imagen si se ha proporcionado una nueva
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . str_replace(' ', '_', $imagen->getClientOriginalName());
            $rutaCompleta = 'public/images/' . $nombreImagen;

            // Eliminar la imagen antigua de S3 si existe
            if ($newsletter->imagen_url) {
                $rutaImagenAntigua = parse_url($newsletter->imagen_url, PHP_URL_PATH);
                $rutaImagenAntigua = ltrim($rutaImagenAntigua, '/');
                Storage::disk('s3')->delete($rutaImagenAntigua);
            }

            try {
                // Subir la nueva imagen a S3 y establecerla como pública
                Storage::disk('s3')->put($rutaCompleta, file_get_contents($imagen), 'public');
                $urlImagen = Storage::disk('s3')->url($rutaCompleta);

                $data['imagen_url'] = $urlImagen;
            } catch (\Exception $e) {
                \Log::error('Error al subir el archivo a S3: ' . $e->getMessage());
            }
        }

        $newsletter->fill($data);
        $newsletter->save();

        return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter actualizada con éxito.');
    }


    public function destroy($id)
    {
        $newsletter = Newsletter::findOrFail($id);


        $rutaImagen = parse_url($newsletter->imagen_url, PHP_URL_PATH);
        $rutaImagen = ltrim($rutaImagen, '/');

        // Elimina el archivo de imagen de S3
        Storage::disk('s3')->delete($rutaImagen);

        $newsletter->delete();

        return back()->with('success', 'Newsletter eliminada con éxito.');
    }

    public function enviarNewsletter()
    {
        $suscriptores = Suscriptor::all();
        $newsletter = Newsletter::where('selected', true)->where('id', '!=', 1)->first();

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

        // Desmarcar cualquier newsletter previamente seleccionada, excepto la newsletter con id = 1
        Newsletter::where('selected', true)
            ->where('id', '!=', 1)
            ->update(['selected' => false]);

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
