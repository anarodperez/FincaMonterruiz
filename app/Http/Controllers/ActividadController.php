<?php

namespace App\Http\Controllers;

use App\Models\Actividad;   // Importa el modelo Actividad

use App\Models\Categoria;

use Illuminate\Http\Request;



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
        $categorias = Categoria::all(); // Obtén todas las categorías para el formulario
        return view('admin.actividades.create', compact('categorias'));
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
            'categoria_id' => 'required', // Asegúrate de tener el campo categoria_id en el formulario
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Agrega validación para la imagen si es obligatoria
        ]);

        // Procesar la carga de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = public_path('/imagenes');
            $imagen->move($rutaImagen, $nombreImagen);
            $data['imagen'] = $nombreImagen; // Asignar el nombre de la imagen a los datos a guardar
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
    public function show($id)
    {
        //servira para obtener un registro de nuestra tabla
        $actividad = Actividad::find($id);
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
            'categoria_id' => 'required', // Asegúrate de tener el campo categoria_id en el formulario
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Agrega validación para la imagen si es obligatoria
        ]);

        // Procesar la carga de nueva imagen si se proporciona
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = public_path('/imagenes');
            $imagen->move($rutaImagen, $nombreImagen);
            $data['imagen'] = $nombreImagen; // Asignar el nombre de la nueva imagen a los datos a guardar
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
        $actividad = Actividad::find($id);
        $actividad->delete();
        return redirect()->route("admin.actividades.index")->with("success", "Eliminada con exito!");
    }

    public function mostrarActividad($id)
    {
        $actividad = Actividad::find($id);
        $categoriaDeActividad = $actividad->categoria;

        return view('actividad', [
            'actividad' => $actividad,
            'categoria' => $categoriaDeActividad
        ]);
    }
}
