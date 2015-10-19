
# API-REST
Repositorio que contiene proyecto final de la materia Monitoreo y Gestión de redes de la Universidad de Mendoza.
El mismo consiste en la realización de una API-REST para consultar, crear, re-priorizar y matar procesos en un servidor. Cabe destacar que realizar dichas operaciones a través de una API no es lo mas recomendable ya que generamos una vulnerabilidad importante a nivel seguridad en nuestro servidor.

# Arquitectura
El sistema es una API-RESTful que responde en formato JSON. Fue desarrollada en php utilizando el framework SLIM con una arquitectura funcional. La aplicación corre sobre un servidor web apache con los permisos del usuario www-data.
Para la autenticación de los usuario se han almacenado las credenciales en una base de datos MYSQL.
El sistema operativo del servidor es Debian 7.8.

#Aplicación
La aplicacion es accesible a través de la url
```
http://serviciosgdpsalud.com.ar:6517/index.php/process 
```

## autenticación
La autenticación se realiza por medio de una variable pasada por GET llamada "key". Los usuarios serán identificados por una clave única alfanumérica de 30 caracteres almacenada en la base de datos de sistema. Ejemplo:

```
http://serviciosgdpsalud.com.ar:6517/index.php/process?key=123ksdfj12YripJd523409Jrudoiu34Y
```

#URL'S
La aplicación cuenta con 7 rutas distintas, todas variantes de 
```
http://serviciosgdpsalud.com.ar:6517/index.php/process
```

##GET/process
Esta ruta nos devolverá información sobre todos los procesos que actualmente están en ejecución en nuestro servidor.
El detalle de los parámetros devueltos son:

Nombre | Detalle
------------ | ------------- | -------------
USER | Usuario dueño del proceso.
PID | Proceso ID.
%MEM | Porcentaje de memoria RAM usado.
%CPU | Porcentaje de procesador usado.
VSZ | Tamaño de la memoria virtual del proceso en Kb.
RSS | Tamaño de la memoria virtual del proceso en Kb.
TTY | Nombre de la terminal a la que esta asociado al proceso.
STAT | Estado del proceso: R Ejecutable. D Interrumpido. S Suspendido. s Es el proceso líder de la sesión. T Detenido. Z Zombie. N Tiene una prioridad menor que lo normal.  
START | Tiempo en el que comenzó el proceso
TIME | Tiempo que lleva en ejecución el proceso.
NI | Prioridad.
COMAND | Comando de ejecución del proceso.

##GET/process/:username
Devuelve los procesos que esta actualmente ejecutando el usuario especificado.
:username ->  Es el nombre de usuario que este ejecutando procesos en el servidor.

##GET/process/:pid

Devuelve información sobre un proceso en particular.
:pid-> ID de proceso corriendo en el servidor.

##DELETE /process/:pid
Elimina el proceso especificado a través de una señal kill.
:pid-> ID de proceso a ser eliminado. 
El usuario solo podrá eliminar procesos del usuario www-data. 
Este usuario es con el que se ejecuta el servidor apache y por ende la aplicación hereda sus permisos dentro del servidor.
**De ser necesario darle los permisos para eliminar cualquier proceso (lo cual no se recomienda) podemos ejecutar la señal con permisos root modificando el archivo sudouser**
### Editar sudouser
Agregamos la siguiente linea para ejecutar el comando kill con permisos root y sin tener que ingresar password:
```
<username> ALL= NOPASSWD:/usr/bin/kill

```
Donde "username" sera www-data en nuestro caso. 

###Consecuencias
Al hacer esta modificación le estaríamos dando al usuario la posibilidad de eliminar cualquier proceso lo cual es muy peligroso y de no hacerlo de forma responsable pone en riesgo la integridad de los servicios dentro del server.

##PUT /process/:pid
Esta ruta nos permite re-priorizar un proceso especifico. Debemos pasar la variable PUT -> ni=valor    
El valor de "ni" debe estar entre 19 (menor prioridad) y -20 (mayor prioridad). El usuario solo podra bajar la prioridad de los procesos que corren con el usuario www-data.
La aplicación nos devolverá un mensaje de éxito en caso de haber podido re-priorizar el proceso.
**De ser necesario darle los permisos para re-priorizar cualquier proceso (lo cual no se recomienda) podemos ejecutar el comando renice con permisos root modificando el archivo sudouser**

### Editar sudouser
Agregamos la siguiente linea para ejecutar el comando renice con permisos root y sin tener que ingresar password:

```
<username> ALL= NOPASSWD:/usr/bin/renice

```
### Consecuencias
Esta modificación permitirá al usuario poder modificar la prioridad de cualquier proceso pudiendo realizar alguna modificación que perjudiquen los servicios corriendo en el server.

##POST /process
Nos permite ejecutar comandos con un tiempo de vida útil bajo el usuario www-data. Por defecto esta configurado en 3 segundos. Debemos pasar el comando a través de la variable 		POST-> command=comando a ejecutar.
El sistema nos devolverá el resultado de la ejecución del comando.
Esta funcionalidad esta limitada según los permisos del usuario www-data

### Consecuencias
Esta funcionalidad es muy peligrosa dejarla sin restricciones y sin limitar que comandos puede ejecutar el usuario. Por defecto solo se limita la ejecución de comandos de acuerdo a los permisos del usuario en el sistema operativo. Esto es un riesgo muy grande ya que se abren infinidad de vulnerabilidades hacia el servidor. De acuerdo con esto deberíamos personalizar cuales son los procesos que debe correr el usuario y ver si es viable que se realicen a través de la API.
