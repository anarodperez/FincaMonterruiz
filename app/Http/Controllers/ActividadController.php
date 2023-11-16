<?php

namespace App\Http\Controllers;

use App\Models\Actividad;   // Importa el modelo Actividad

// use App\Models\Categoria;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;



class ActividadController extends Controller
{
    public function index()
    {
        $actividades = Actividad::all();
        return view('admin.actividades.index', [
            'actividades' => $actividades,
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
        $data = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'duracion' => 'required',
            'precio_adulto' => 'required',
            'precio_nino' => 'required',
            'aforo' => 'required',
            'activa' => 'required|in:0,1',
            // 'categoria_id' => 'required', // Asegúrate de tener el campo categoria_id en el formulario
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Agrega validación para la imagen si es obligatoria
        ]);

        // Procesar la carga de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

            // Almacenar la imagen en la carpeta storage
            $rutaImagen = $imagen->storeAs('public/img', $nombreImagen);

            // Obtener la ruta relativa para almacenar en la base de datos
            $rutaRelativa = 'storage/img/' . $nombreImagen;

            $data['imagen'] = $rutaRelativa; // Asignar la ruta relativa de la nueva imagen a los datos a guardar
        }


        Actividad::create($data);

        return redirect()->route("admin.actividades.index")->with("success", "¡Agregado con éxito!");
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
    return view("admin.actividades.delete", compact('actividad'));
}


    /**
     * Este metodo nos sirve para traer los datos que se van a editar y los coloca en un formulario.
     *
     * @param  \App\Models\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Buscar la actividad en base al ID
        $actividad = Actividad::find($id);

        // Verificar si se encontró la actividad
        if (!$actividad) {
            return redirect()->route('admin.actividades.index')->with('error', 'Actividad no encontrada');
        }

        // Mostrar el formulario de edición con los datos de la actividad
        return view('admin.actividades.edit', compact('actividad'));
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
            return redirect()->route("admin.actividades.index")->with("error", "¡Actividad no encontrada!");
        }

        $data = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'duracion' => 'required',
            'precio_adulto' => 'required',
            'precio_nino' => 'required',
            'aforo' => 'required',
            'activa' => 'required',
            // 'categoria_id' => 'required', // Asegúrate de tener el campo categoria_id en el formulario
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Agrega validación para la imagen si es obligatoria
        ]);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

            // Almacenar la imagen en la carpeta storage
            $rutaImagen = $imagen->storeAs('public/img', $nombreImagen);

            // Obtener la ruta relativa para almacenar en la base de datos
            $rutaRelativa = 'storage/img/' . $nombreImagen;

            $data['imagen'] = $rutaRelativa; // Asignar la ruta relativa de la nueva imagen a los datos a guardar
        }

        $actividad->update($data);

        return redirect()->route("admin.actividades.index")->with("success", "¡Actualizado con éxito!");
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
            $actividad->delete();
            return redirect()->route("admin.actividades.index")->with("success", "Eliminada con éxito!");
        } else {
            // Manejar el caso en el que la actividad no se encuentra
            return redirect()->route("admin.actividades.index")->with("error", "La actividad no existe o ya ha sido eliminada.");
        }
    }
    public function mostrarActividad($id)
    {
        $actividad = Actividad::find($id);
        // $categoriaDeActividad = $actividad->categoria;

        return view('actividad', [
            'actividad' => $actividad,
            // 'categoria' => $categoriaDeActividad
        ]);
    }
}
