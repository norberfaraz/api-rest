# API-REST
Repositorio que contiene proyecto final de la materia Monitoreo y Gestion de redes de la Universidad de Mendoza.
El mismo consiste en la realizacion de una API-REST para consultar, crear, re-priorizar y matar procesos en un servidor. Cabe destacar que realizar dichas operaciones a traves de una API no es lo mas recomendable ya que generamos una vulnerabilidad importante a nivel seguridad en nuestro servidor.

# Arquitectura
El sistema es una API-RESTful que responde en formato JSON. Fue desarrollada en php utilizando el framework SLIM con una arquitectura funcional. La aplicacion corre sobre un servidor web apache con los permisos del usuario www-data.
Para la autenticacion de los usuario se han almacenado las credenciales en una base de datos MYSQL.

#Aplicacion
El servidor es accesible a traves de la url http://serviciosgdpsalud.com.ar:6517 .
## autenticacion
La autenticacion se realiza a traves de una variable pasada por GET llamada "key". Los usuarios seran identificados por una clave unica alfanumerica 30 caracteres almacenada en la base de datos de sistema. Ejemplo:

http://serviciosgdpsalud.com.ar:6517/index.php/process?key=123ksdfj12YripJd523409Jrudoiu34Y
#URL'S
La aplicacion cuenta con 7 rutas distintas, todas variatenes de http://serviciosgdpsalud.com.ar:6517/index.php/process
##GET/process
Esta ruta nos devolvera informacion sobre todos los procesos que actualmente estan en ejecucion en nuestro servidor.
El detalle de los parametros devueltos son:

Nombre | Detalle
------------ | ------------- | -------------
USER | Usuario dueño del proceso.
PID | Proceso ID.
%MEM | Porcentaje de memoria RAM usado.
%CPU | Porcentaje de prcesador usado.
VSZ | Tamaño de la memoria virtual del proceso en Kb.
RSS | Tamaño de la memoria virtual del proceso en Kb.
TTY | Nombre de la terminal a la que esta asociado al proceso.
STAT | Estado del proceso: R Ejecutable. D Interrumpió.S Suspendido. s Es el proceso líder de la sesión. T Detenido. Z Zombie.N	Tiene una prioridad menor que lo normal.  
START | Tiempo en el que comenzo el proceso
TIME | Tiempo que lleva en ejecución el proceso.
NI | Prioridad.
COMAND | Comando de ejecucion del proceso.

##GET/process/:username
Devuelve los procesos que esta actualemten ejecutando el usuario especificado.
:username ->  Es el nombre de usuario que este ejecutando procesos en el servidor.

##GET/process/:pidhttp://prose.io/#norberfaraz/api-rest/edit/master/README.md
Devuelve informacion sobre un proceso en particular.
:pid-> ID de proceso corriendo en el servidor.

##DELETE /process/:pid
Elimina el proceso especificado a travez de una señal kill.
:pid-> ID de proceso a ser eliminado. 
El usuario solo podra eliminar procesos del usuario www-data. 
Este usuario es con el que se ejecuta el servidor apache y por ende la aplicacion hereda sus permisos dentro del servidor.
**De ser necesario darle los permisos para eliminar cualquier proceso (lo cual no se recomienda) podemos ejecutar la senial con permisos root modificando el archivo sudouser**
### Editar sudouser
Agregamos la siguiente linea para ejecutar el comando kill con permisos root y sin tener que ingresar password:
```
<username> ALL= NOPASSWD:/usr/bin/kill

```
Donde "username" sera www-data en nuesto caso. 

###Consecuencias
Al hacer esta modificacion le estariamos dando al usuario la posibilidad de eliminar cualquier proceso lo cual es muy peligroso y de no hacerlo de forma responsable pone en riesgo la integridad de los servicios dentro del server.

##PUT /process/:pid
Esta ruta nos permite repriorizar un proceso especifico. Debemos pasar la variable PUT -> ni=valor    
El valor de "ni" debe estar entre 19 (menor prioridad) y -20 (mayor prioridad). El usuario solo podra bajar la prioridad de los procesos que corren con el usuario www-data.
**De ser necesario darle los permisos para reprioriza cualquier proceso (lo cual no se recomienda) podemos ejecutar el comando renice con permisos root modificando el archivo sudouser**
### Editar sudouser
Agregamos la siguiente linea para ejecutar el comando renice con permisos root y sin tener que ingresar password:

```
<username> ALL= NOPASSWD:/usr/bin/renice

```
### Consecuecias
Esta modificacion permitira al usuario poder modificar la prioridad de cualquier proceso pudiendo realizar alguna modificacion que perjudique a los servicios corriendo en el server.

##POST /process








