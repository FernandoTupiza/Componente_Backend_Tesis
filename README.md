## DESPLIEGUE DEL COMPONENTE BACKEND
![image](https://user-images.githubusercontent.com/105765407/221376101-21110703-cb96-4667-9ba4-4f35c767fc16.png)

## Pasos a seguir para el correcto despliegue.

El componente backend ha realizo el despligue en Heroku una plataforma para el envio a produccion de lso diferentes componentes, No obstante para el despliegue se debe seguir los paso que se muestra a continuacion.

- Crear una cuenta en Heroku gratis o paga, en la siguiente ruta https://signup.heroku.com/.

![image](https://user-images.githubusercontent.com/105765407/221376354-d348cc51-5fbc-4bdd-8efe-5942d7b6ab7b.png)

- Una vez creada la cuenta vamos a dirigirnos a ingresar nuestras credenciales para el inicio de sesión como se muestra en la Figura.

![image](https://user-images.githubusercontent.com/105765407/221376412-fca1198e-f8ab-4924-9fe4-0c3e0e82e687.png)

- Seguidamente al ingresar nos dirigimos hacia el apartado de crear una nueva aplicación

![image](https://user-images.githubusercontent.com/105765407/221376444-448e69ba-2d1e-4209-bb3e-7835cfc5d74a.png)

- Luego procedemos a crear la aplicacion ingresando el nombre.

![image](https://user-images.githubusercontent.com/105765407/221376477-098b3106-7bc3-49ec-bb85-8c2954f4fb13.png)

- Al momento de tener nuestra aplicacion creada nos dirigimos hacia el apartado de configuracion para colocar las variables de entorno.

![image](https://user-images.githubusercontent.com/105765407/221376515-20484aad-cbe2-4e6b-9512-2fb62dfb0bff.png)

- Nos dirigimos hacia nuestro codigo fuente para verificar las variables de entorno necesarias para colocar en Heroku.

![image](https://user-images.githubusercontent.com/105765407/221376573-02f20f1f-9c0e-46a6-94b7-2a6871661b77.png)

- Al verificar las variables de entorno, agregamos dichas variables en Heroku para su respectivo despliegue como se muestra en la Figura.

![image](https://user-images.githubusercontent.com/105765407/221376653-2babe6c0-7c82-4004-92d7-1ca2d3da9e51.png)

- Una vez ingresado las variables de entorno, nos dirigimos hacia despliegue para ingresar los comandos que nos indica en consola.

![image](https://user-images.githubusercontent.com/105765407/221376789-1931b1db-270d-4ebb-a38e-03baecdceafe.png)

- Finlamente verificamos la funcionalidad ingresado a nuestra sistema web desplegado.

![image](https://user-images.githubusercontent.com/105765407/221376836-a69d2cda-c011-4962-8792-511225b3056c.png)


## Documentación de la API en Swagger

Para la documentacion realizada en Swagger se debe seguir los suguientes pasos que se muestra a continuación.

1- Primero se debe instalar las siguientes dependecias necesarias para la documentacion.
 - composer require "darkaonline/l5-swagger"
 - $ php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
 - Comando para guardar la documentación $ php artisan l5-swagger:generate

2- Una vez instalado todo, debemos verificar la logica que lleva para documentar la herramienta Swagger como se muestra en la Figura.

![image](https://user-images.githubusercontent.com/105765407/221377126-2255b791-47a0-47b0-991a-247becb5576b.png)


