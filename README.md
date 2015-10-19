# api-rest
Repositorio que contiene proyecto final de la materia Monitoreo y Gestion de redes de la Universidad de Mendoza.
El mismo consiste en la realizacion de una API-REST para consultar, crear, re-priorizar y matar procesos en un servidor. Cabe destacar que realizar dichas operaciones a traves de una API no es lo mas recomendable ya que generamos una vulnerabilidad importante a nivel seguridad en nuestro servidor.

# Arquitectura
El sistema es una API-RESTful que responde en formato JSON. Fue desarrollada en php utilizando el framework SLIM con una arquitectura funcional. La aplicacion corre sobre un servidor web apache con los permisos del usuario www-data. 

#aplicacion
El servidor es accesible a traves de la url http://serviciosgdpsalud.com.ar:6516 .

autenticacion



