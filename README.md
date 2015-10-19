# api-rest
Repositorio que contiene proyecto final de la materia Monitoreo y Gestion de redes de la Universidad de Mendoza.
El mismo consiste en la realizacion de una API-REST para monitorear, crear, re-priorizar y matar procesos en un servidor. Cabe destacar que realizar dichas operaciones a traves de una API no es lo mas recomendable ya que generamos una vulnerabilidad importante en la seguridad de nuestro servidor, por lo que se ha intentado limitar lo mas posible las funcionalidades de esta API.


# Arquitectura
La aplicacion tiene una arquitectura funcional corriendo sobre un servidor web apache con los permisos del usuario www-data. La misma fue desarrallada en php utilizando el framework SLIM. 
