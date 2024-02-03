<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Validator;
use App\Models\Reserva;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ActividadController extends Controller
{
    public function index()
    {
        $actividades = Actividad::paginate(4);

        // Obtener datos de reservas
        $datosReservas = Reserva::select(DB::raw("to_char(created_at, 'YYYY-MM-DD') as fecha"), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        return view('admin.actividades.index', [
            'actividades' => $actividades,
            'datosReservas' => $datosReservas,
        ]);
    }

    /**
     * MUestra el formulario para crear una actividad.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $categorias = Categoria::all(); // Obtén todas las categorías para el formulario
        // return view('admin.actividades.create', compact('categorias'));
        return view('admin.actividades.create');
    }

    /**
     * Almacena una actividad recien creada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validaciones básicas
        $validatedData = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'duracion' => 'required|integer',
            'aforo' => 'required|integer',
            'activa' => 'required|in:0,1',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio_adulto' => 'required|numeric',
            'precio_nino' => 'nullable|numeric',
        ]);
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            // Preparar el nombre del archivo, reemplazando espacios con guiones bajos para evitar problemas en S3
            $nombreImagen = time() . '_' . str_replace(' ', '_', $imagen->getClientOriginalName());

            // Especificar la ruta completa incluyendo la carpeta /public/images dentro de tu bucket de S3
            $rutaCompleta = 'public/images/' . $nombreImagen;

            try {
                // Usar Storage::disk('s3') para subir el archivo, incluyendo el ACL public-read.
                Storage::disk('s3')->put($rutaCompleta, file_get_contents($imagen), ['visibility' => 'public']);

                // Obtener la URL pública del archivo almacenado en S3
                $urlImagen = Storage::disk('s3')->url($rutaCompleta);

                // Guardar la URL de la imagen en la base de datos
                $validatedData['imagen'] = $urlImagen;
            } catch (\Exception $e) {
                \Log::error('Error al subir el archivo a S3: ' . $e->getMessage());
                // Manejar el error según sea necesario, como enviar un mensaje de error al usuario
            }
        }

        // Asignar valores nulos para precios si los campos están vacíos
        $validatedData['precio_adulto'] = $request->filled('precio_adulto') ? $request->precio_adulto : null;
        $validatedData['precio_nino'] = $request->filled('precio_nino') ? $request->precio_nino : null;

        // Crear la actividad con los datos validados
        Actividad::create($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()
            ->route('admin.actividades.index')
            ->with('success', '¡Actividad agregada con éxito!');
    }

    /**
     * Mostrar la actividad especificada.
     *
     * @param  \App\Models\Actividad  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show($actividad)
    {
        // Desencriptar el ID
        $realId = Crypt::decrypt($actividad);

        // Obtener la actividad
        $actividad = Actividad::find($realId);

        // Pasar la variable a la vista
        return view('admin.actividades.delete', compact('actividad'));
    }

    /**
     * Este metodo nos sirve para traer los datos que se van a editar y los coloca en un formulario.
     *
     * @param  \App\Models\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /// Desencriptar el ID
        $realId = Crypt::decrypt($id);

        // Buscar la actividad
        $actividad = Actividad::find($realId);

        // Comprueba si la actividad tiene reservas
        $tieneReservas = $actividad->reservas()
        ->where('estado', '!=', 'cancelada')
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('horarios')
                  ->whereRaw('horarios.id = reservas.horario_id')
                  ->whereRaw("TO_TIMESTAMP(horarios.fecha || ' ' || horarios.hora, 'YYYY-MM-DD HH24:MI:SS') AT TIME ZONE 'Europe/Madrid' > NOW()");
        })->exists();


        // Verificar si se encontró la actividad
        if (!$actividad) {
            return redirect()
                ->route('admin.actividades.index')
                ->with('error', 'Actividad no encontrada');
        }

        // Mostrar el formulario de edición con los datos de la actividad
        return view('admin.actividades.edit', compact('actividad', 'tieneReservas'));
    }
    /**
     *Este metodo actualiza los datos en la bd
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actividad = Actividad::find($id);
        if (!$actividad) {
            return redirect()->route('admin.actividades.index')->with('error', '¡Actividad no encontrada!');
        }

        // Validar los campos proporcionados en la solicitud
        $data = $request->validate([
            'nombre' => 'sometimes|required',
            'descripcion' => 'sometimes|required',
            'duracion' => 'sometimes|required|integer',
            'precio_adulto' => 'sometimes|required|numeric',
            'precio_nino' => 'nullable|numeric',
            'aforo' => 'sometimes|required|integer',
            'activa' => 'sometimes|required|in:0,1',
            'imagen' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar la imagen si se ha proporcionado una nueva
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . str_replace(' ', '_', $imagen->getClientOriginalName());
            $rutaCompleta = 'public/images/' . $nombreImagen;

            // Eliminar la imagen antigua de S3 si existe
            if ($actividad->imagen) {
                $rutaImagenAntigua = parse_url($actividad->imagen, PHP_URL_PATH);
                $rutaImagenAntigua = ltrim($rutaImagenAntigua, '/');
                Storage::disk('s3')->delete($rutaImagenAntigua);
            }

            try {
                // Subir la nueva imagen a S3 y establecerla como pública
                Storage::disk('s3')->put($rutaCompleta, file_get_contents($imagen), 'public');
                $urlImagen = Storage::disk('s3')->url($rutaCompleta);

                // Actualizar la URL de la imagen en el array de datos
                $data['imagen'] = $urlImagen;
            } catch (\Exception $e) {
                \Log::error('Error al subir el archivo a S3: ' . $e->getMessage());
                // Considera manejar el error de manera que informes al usuario
            }
        }

        // Actualizar la actividad con los datos proporcionados (incluyendo la nueva imagen si se subió)
        $actividad->fill($data);
        $actividad->save();

        return redirect()->route('admin.actividades.index')->with('success', 'Actividad modificada con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actividad $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Desencriptar el ID
        $realId = Crypt::decrypt($id);

        // Buscar la actividad
        $actividad = Actividad::find($realId);

        // Verificar si la actividad existe antes de intentar eliminar
        if ($actividad) {
            // Verificar si la actividad tiene reservas
            if ($actividad->reservas()->count() > 0) {
                return redirect()
                    ->route('admin.actividades.index')
                    ->with('error', 'No se puede eliminar la actividad porque ya tiene reservas.');
            }

            $rutaImagen = parse_url($actividad->imagen, PHP_URL_PATH);
            $rutaImagen = ltrim($rutaImagen, '/');

            // Elimina el archivo de imagen de S3
            Storage::disk('s3')->delete($rutaImagen);

            // Si no hay reservas, eliminar la actividad
            $actividad->delete();
            return redirect()
                ->route('admin.actividades.index')
                ->with('success', 'Actividad eliminada con éxito.');
        } else {
            // Manejar el caso en el que la actividad no se encuentra
            return redirect()
                ->route('admin.actividades.index')
                ->with('error', 'La actividad no existe o ya ha sido eliminada.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('buscador');
        $actividades = Actividad::where('nombre', 'LIKE', "%{$query}%")->get();

        return view('pages.catalogo', compact('actividades'));
    }

    public function detalleActividad($id)
    {
        // Obtén los detalles de la actividad con el ID proporcionado.
        $actividad = Actividad::find($id);

        // Muestra la vista de detalles de la actividad y pasa los detalles de la actividad.
        return view('pages.detalleActividad', ['actividad' => $actividad]);
    }
}
