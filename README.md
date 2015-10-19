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
Los parametros devueltos son los siguientes:
Nombre | Explicación
------------ | ------------- | -------------
USER | Usuario dueño del proceso.
PID | Proceso ID.
%MEM | Porcentaje de memoria RAM usado.
%CPU | Porcentaje de prcesador usado.
VSZ | Tamaño de la memoria virtual del proceso en Kb.
RSS | Tamaño de la memoria virtual del proceso en Kb.
TTY | Nombre de la terminal a la que esta asociado al proceso.
STAT | Estado del proceso: R	Ejecutable. D Interrumpió. S	Suspendido. s Es el proceso líder de la sesión. T	Detenido. Z	Zombie. N	Tiene una prioridad menor que lo normal.
START | Tiempo en el que comenzo el proceso
TIME | Tiempo que lleva en ejecución el proceso.
NI | Prioridad.
COMAND | Comando de ejecucion del proceso.
num_threads | Número de hilos
open_files | Número de archivos abiertos, y su file descriptor. En windows el fd siempre es -1
pid | El id del proceso
ppid | El id del proceso padre
status | El estado del proceso como un string
terminal | El terminal asociado con este proceso, si hay
threads | Los threads the proceso
