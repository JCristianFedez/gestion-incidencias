// TODO: Cuando este terminado agregar imagenes de los botones, quitar las lineas [======] y ademas para referenciar por id usar Ej: eliminar-usuario y arriba del titulo acregar un <span id="eliminar-usuario"></span>

# Sistema de Gestion de Incidencias

## Indice

- [**Introduccion**](#introduccion)
- [**Usuarios**](#usuarios)
  - [Ver](#usuarios-ver)
  - [Crear](#usuarios-crear)
  - [Editar](#usuarios-editar)
  - [Dar de baja](#usuarios-dar-de-baja)
  - [Restaurar](#usuarios-restaurar)
  - [Eliminar](#usuarios-eliminar)
  - [Asignar proyecto](#usuarios-asignar-proyecto)
  - [Editar asignación con proyecto](#usuarios-editar-asignacion-con-proyecto)
  - [Eliminar asignación con proyecto](#usuarios-eliminar-asignacion-con-proyecto)
- [**Proyectos**](#proyectos)
  - [Ver](#proyectos-ver)
  - [Crear](#proyectos-crear)
  - [Editar](#proyectos-editar)
  - [Dar de baja](#proyectos-dar-de-baja)
  - [Restaurar](#proyectos-restaurar)
  - [Eliminar](#proyectos-eliminar)
  - [Cambiar](#proyectos-cambiar)
- [**Niveles**](#niveles)
  - [Ver](#niveles-ver)
  - [Crear](#niveles-crear)
  - [Editar](#niveles-editar)
  - [Eliminar](#niveles-eliminar)
- [**Categorias**](#categorias)
  - [Ver](#categorias-ver)
  - [Crear](#categorias-crear)
  - [Editar](#categorias-editar)
  - [Eliminar](#categorias-eliminar)
- [**Incidencias**](#incidencias)
  - [Ver](#incidencias-ver)
  - [Crear](#incidencias-crear)
  - [Editar](#incidencias-editar)
  - [Atender](#incidencias-atender)
  - [Desatender](#incidencias-desatender)
  - [Marcar como resuelta](#incidencias-marcar-como-resuelta)
  - [Volver a abrir](#incidencias-volver-a-abrir)
  - [Derivar al siguiente nivel](#incidencias-derivar-al-siguiente-nivel)


## <a name="introduccion">Introducción</a>
Empieza a utilizar SGI, la aplicación web destinada a la gestión de incidencias, en los siguientes apartados podrás ver de forma clara como realizar las acciones que deseas.

Las mayoría de las tablas en esta aplicación tienen varias opciones para buscar elementos:
1. Campo para cualquier coincidencia.
2. Filtros por campos.
3. Eliminar campos que no se quieran ver.


- - -



## <a name="usuarios">Usuarios</a>
### <a name="usuarios-ver">Ver usuarios</a>
Para ver a los usuarios registrados en la aplicacion, debe de dirigirse en el menú izquierdo al apartado de ![Usuarios](https://raw.githubusercontent.com/JCristianFedez/gestion-incidencias/main/documentation/Imagenes-botones/btn-usuarios.png).

Una vez le haya cargado la pagina, le aparecerá en la parte inferior de la pagina una tabla con todos los usuarios registrados.
<br>

### <a name="usuarios-crear">Crear usuario</a>
Para crear un usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, le aparecerá en la parte superior de la pagina un formulario, el cual debe de rellenar con los datos del nuevo usuario.

> La contraseña se almacena cifrada para una mayor seguridad.

<br>


### <a name="usuarios-editar">Editar usuario</a>
Para editar un usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del usuario que quiere editar y en la columna opciones pinche en el botón de **Editar usuario**.

Se le redirigirá a una ventana en la cual aparecera un formulario en la parte superior, el cual debe de rellenar con los nuevos datos del usuario.

<br>


### <a name="usuarios-dar-de-baja">Dar de baja a un usuario</a>
Para dar de baja a un usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior buscar el registro del usuario que quiere dar de baja y en la columna opciones pinche en el botón de **Dar de baja**.
<br>

### <a name="usuarios-restaurar">Restaurar usuario</a>
Para volver a activar una cuenta de usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del usuario que quiere restaurar y en la columna opciones pinche en el botón de **Restaurar usuario**.
<br>

### <a name="usuarios-eliminar">Eliminar usuarios</a>
Para eliminar un usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del usuario que quiere eliminar y en la columna opciones pinche en el botón de **Eliminar usuario**.

>Tenga en cuenta que para eliminar un usuario antes debe de haberlo dado de baja, si quiere saber como hacerlo [pinche aqui](#usuarios-dar-de-baja)

<br>

### <a name="usuarios-asignar-proyecto">Asignar un proyecto a un usuario de soporte</a>
Para asignar un proyecto a un usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del usuario que quiere asignar un proyecto y en la columna opciones pinche en el botón de **Editar usuario**.

Se le redirigirá a una ventana en la cual en la parte inferior le aparecerán dos campos de selección, en el de la izquierda seleccionara el proyecto y en el de la derecha el nivel que sera asignado al usuario en dicho proyecto.

>Tenga en cuenta que esta acción solo puede realizarse sobre usuarios de soporte.

<br>

### <a name="usuarios-editar-asignacion-con-proyecto">Editar la asignacion de un proyecto a un usuario de Soporte</a>
Para editar la asignacion de un proyecto a un usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del usuario que quiere editar la asignacion de un proyecto y en la columna opciones pinche en el botón de **Editar usuario**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todos los proyectos a los que pertenece el usuario seleccionado, en la tabla debe de buscar la relación que quiere editar y pinchar en el botón de **Editar**.

Se le abrirá un modal en el cual indicara el nuevo nivel que tendrá el usuario asignado en el proyecto.

>Tenga en cuenta que esta acción solo puede realizarse sobre usuarios de soporte con proyectos asignados.

<br>

### <a name="usuarios-eliminar-asignacion-con-proyecto">Eliminar la asignacion de un proyecto a un usuario de Soporte</a>
Para eliminar la asignacion de un proyecto a un usuario, debe de dirigirse en el menú izquierdo al apartado de **Usuarios**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del usuario que quiere eliminar la asignacion de un proyecto y en la columna opciones pinche en el botón de **Editar usuario**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todos los proyectos a los que pertenece el usuario seleccionado, en la tabla debe de buscar la relación que quiere editar y pinchar en el botón de **Eliminar**.

>Tenga en cuenta que esta acción solo puede realizarse sobre usuarios de soporte con proyectos asignados.

<br>


- - -

## <a name="proyectos">Proyectos</a>
### <a name="proyectos-ver">Ver proyectos</a>
Para ver los proyectos, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, le aparecerá en la parte inferior de la pagina una tabla con todos los proyectos.
<br>

### <a name="proyectos-crear">Crear proyecto</a>
Para crear proyectos, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, le aparecerá en la parte superior de la pagina un formulario, el cual debe de rellenar con los datos del nuevo proyecto.
<br>

### <a name="proyectos-editar">Editar proyecto</a>
Para editar un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto que quiere editar y en la columna opciones pinche en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual aparecera un formulario en la parte superior, el cual debe de rellenar con los nuevos datos del proyecto.
<br>

### <a name="proyectos-dar-de-baja">Dar de baja un proyecto</a>
Para dar de baja a un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto que quiere dar de baja y en la columna opciones pinche en el botón de **Dar de baja**.
<br>

### <a name="proyectos-restaurar">Restaurar proyecto</a>
Para volver a activar un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto que quiere restaurar y en la columna opciones pinche en el botón de **Restaurar proyecto**.
<br>

### <a name="proyectos-eliminar">Eliminar proyecto</a>
Para eliminar un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto que quiere eliminar y en la columna opciones pinche en el botón de **Eliminar proyecto**.

>Tenga en cuenta que para eliminar un proyecto antes debe de haberlo dado de baja, si quiere saber como hacerlo [pinche aqui](#proyectos-dar-de-baja).

<br>

### <a name="proyectos-cambiar">Cambiar de proyecto</a>
Para cambiar de proyecto debe de pinchar en el selector del menú superior.

Se le desplegara una lista con todos los proyectos en los que puede participar, en ella debe de pinchar en el proyecto que desea, automáticamente la aplicación se actualizara mostrando las incidencias de dicho proyecto así como cuando se cree una nueva se creara sobre dicho proyecto.

>Los usuarios de soporte que no tengan ningún proyecto asignado no podrán usar esta funcionalidad.

<br>


- - -

## <a name="niveles">Niveles</a>
### <a name="niveles-ver">Ver niveles de proyecto</a>
Para ver los niveles que tiene un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto del cual quiere ver sus niveles y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todos los niveles del proyecto seleccionado.
<br>

### <a name="niveles-crear">Agregar nivel a proyecto</a>
Para agregar un nivel a un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto al cual le quiere agregar un nivel y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá un campo numérico en el cual se debe de indicar la importancia y otro campo de texto en el cual debe de ingresar el nombre del nivel.

>Tenga en cuenta el nivel 1 tiene menos importancia que el nivel 2, por lo que cuando una incidencia de nivel 1 se deriva al siguiente nivel esta pasara a estar en el nivel 2.

<br>

### <a name="niveles-editar">Editar nivel</a>
Para editar un nivel de un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto del cual quiere editar un nivel y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todos los niveles del proyecto seleccionado, en ella debe de buscar el registro del nivel a editar y en la columna opciones pinchar en el botón de **Editar**.

Se abrirá un modal con dos campos, el primero es un campo de texto en el cual debe de introducir el nuevo nombre del nivel y el segundo es un campo numérico en el cual debe de ingresar la importancia del nivel

>Tenga en cuenta el nivel 1 tiene menos importancia que el nivel 2, por lo que cuando una incidencia de nivel 1 se deriva al siguiente nivel esta pasara a estar en el nivel 2.

<br>

### <a name="niveles-eliminar">Eliminar nivel</a>
Para eliminar un nivel de un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto del cual quiere eliminar un nivel y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todos los niveles del proyecto seleccionado, en ella debe de buscar el registro del nivel a eliminar y en la columna opciones pinchar en el botón de **Eliminar**.

>Tenga en cuenta que al eliminar un nivel, todas las incidencias de dicho nivel pasaran al siguiente nivel. De no ser posible pasaran al nivel general.

<br>


- - -

## <a name="categorias">Categorías</a>
### <a name="categorias-ver">Ver categorías de proyecto</a>
Para ver las categorias que tiene un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto del cual quiere ver sus categorías y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todas las categorías del proyecto seleccionado.
<br>

### <a name="categorias-crear">Agregar categoria a proyecto</a>
Para agregar una categoría a un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto al cual le quiere agregar una categoría y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá un campo de texto en el cual debe de agregar el nombre de la categoría.
<br>

### <a name="categorias-editar">Editar categoria</a>
Para editar una categoría de un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto del cual quiere editar una categoría y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todas las categorías del proyecto seleccionado, en ella debe de buscar el registro de la categoría a editar y en la columna opciones pinchar en el botón de **Editar**.

Se abrirá un modal con un campo de texto en el cual debe de introducir el nuevo nombre de la categoría.
<br>

### <a name="categorias-eliminar">Eliminar categoria</a>
Para eliminar una categoría de un proyecto, debe de dirigirse en el menú izquierdo al apartado de **Proyectos**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla inferior, buscar el registro del proyecto del cual quiere eliminar una categoría y en la columna opciones pinchar en el botón de **Editar proyecto**.

Se le redirigirá a una ventana en la cual en la parte inferior aparecerá una tabla con todas las categorías del proyecto seleccionado, en ella debe de buscar el registro de la categoría a eliminar y en la columna opciones pinchar en el botón de **Eliminar**.

>Tenga en cuenta que al eliminar una categoría todas las incidencias de dicha categoría pasaran a la categoría general.

<br>


- - -

## <a name="incidencias">Incidencias</a>
### <a name="incidencias-ver">Ver Incidencias</a>
Para ver las incidencias, debe de dirigirse en el menú izquierdo al apartado de **Dashboard**.

Una vez le haya cargado la pagina, le aparecerán las siguientes tablas.

1. **Incidencias asignadas a mi**
En esta tabla puede ver todas las incidencias que esta atendiendo.

2. **Mis incidencias**
En esta tabla puede ver todas las incidencias que ha reportado.

3. **Incidencias sin asignar**
En esta tabla puede ver todas las incidencias que esta atendiendo.

Si desea ver mas información acerca de una incidencia dirigase a la columna opciones de dicha incidencia y pinche en el botón de **Ver**.
<br>

### <a name="incidencias-crear">Crear incidencia</a>
Para crear una incidencia, debe de dirigirse en el menú izquierdo al apartado de **Reportar**.

Una vez le haya cargado la pagina, le aparecerá en la parte superior de la pagina un formulario, el cual debe de rellenar con los datos de la incidencia.
<br>

### <a name="incidencias-editar">Editar incidencia</a>
Para editar una incidencia, debe de dirigirse en el menú izquierdo al apartado de **Dashboard**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla de mis incidencias, buscar el registro de la incidencia que quiere editar y en la columna opciones pinchar en el botón de **Ver**.

Se le redirigirá a una ventana en la cual aparecerá toda la información de la incidencia. En esta ventana debe de pinchar en el botón **Editar incidencia**.

Se le redirigirá a una ventana en la cual aparecerá un formulario, el cual debe de rellenar con los nuevos datos de la incidencia.

>Las incidencias solo las puede editar el usuario que la haya creado.

<br>

### <a name="incidencias-atender">Atender incidencia</a>
Para atender una incidencia, debe de dirigirse en el menú izquierdo al apartado de **Dashboard**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla de incidencias sin asignar, busca el registro de la incidencia que quiere atender y en la columna opciones pinchar en el botón de **Atender**.

Tambien la puede atender pinchando en el botón de **Ver**.

Se le redirigirá a una ventana en la cual aparecerá toda la información de la incidencia. En esta ventana debe de pinchar en el botón **Atender incidencia**.

>Las incidencias solo pueden ser atendidas por usuarios de administración o usuarios de soporte con suficiente nivel en el proyecto en el que se ha creado.

<br>

### <a name="incidencias-desatender">Desatender incidencia</a>
Para desatender una incidencia, debe de dirigirse en el menú izquierdo al apartado de **Dashboard**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla de incidencias asignadas a mi, busca el registro de la incidencia que quiere desatender y en la columna opciones pinchar en el botón de **Desatender**.

Tambien la puede desatender pinchando en el botón de **Ver**.

Se le redirigirá a una ventana en la cual aparecerá toda la información de la incidencia. En esta ventana debe de pinchar en el botón **Desatender incidencia**.
<br>

### <a name="incidencias-marcar-como-resuelta">Marcar incidencia como resuelta</a>
Para marcar como resuelta una incidencia, debe de dirigirse en el menú izquierdo al apartado de **Dashboard**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla de mis incidencias, buscar el registro de la incidencia que quiere marcar como resuelta y en la columna opciones pinchar en el botón de **Ver**.

Se le redirigirá a una ventana en la cual aparecerá toda la información de la incidencia. En esta ventana debe de pinchar en el botón **Marcar como resuelta**.

>Las incidencias solo pueden ser marcadas como resuelta por el usuario que las creo.

<br>

### <a name="incidencias-volver-a-abrir">Volver a abrir incidencia</a>
Para volver a abrir una incidencia, debe de dirigirse en el menú izquierdo al apartado de **Dashboard**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla de mis incidencias, buscar el registro de la incidencia que quiere volver a abrir y en la columna opciones pinchar en el botón de **Ver**.

Se le redirigirá a una ventana en la cual aparecerá toda la información de la incidencia. En esta ventana debe de pinchar en el botón **Volver a abrir la incidencia**.

>Esta acción solo se puede realizar si la incidencia se había marcado como resuelta anteriormente y por el usuario que la creo.

<br>

### <a name="incidencias-derivarl-al-siguiente-nivel">Derivar incidencia al siguiente nivel</a>
Para derivar una incidencia al siguiente nivel, debe de dirigirse en el menú izquierdo al apartado de **Dashboard**.

Una vez le haya cargado la pagina, debe dirigirse a la tabla de Incidencias asignadas a mi, buscar el registro de la incidencia que quiere derivar al siguiente nivel y en la columna opciones pinchar en el botón de **Ver**.

Se le redirigirá a una ventana en la cual aparecerá toda la información de la incidencia. En esta ventana debe de pinchar en el botón **Derivar al siguiente nivel**.

>Esta acción solo la puede realizar un administrador o el usuario que esta atendiendo la incidencia, para saber como atender una incidencia [pinche aqui](#incidencias-atender).
