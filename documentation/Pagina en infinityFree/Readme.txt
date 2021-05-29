Para subir la pagina a infinityfree seguir los pasos del siguiente video
https://www.youtube.com/watch?v=pE0EEZ0NYPE&ab_channel=Engineer%27sCommunityGuide

Ademas modificar las siguientes paginas comentando y descomentando la parte necesaria
(Archivos con //Parte local // Parte infinityfree):
app/Http/Controllers/IncidentController.php - En las funciones store y update
app/Http/Controllers/Admin/ProjectController.php - En la funcion forceDestroy
app/Http/Controllers/Admin/CategoryController.php - En la funcoin destroy
app/Http/Controllers/Admin/UserController.php - En la funcoin forceDestroy

