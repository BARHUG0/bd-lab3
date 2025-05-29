
# Guía para configurar el proyecto BARHUG0/bd-lab3 usando Docker

Configuración del proyecto [BARHUG0/bd-lab3](https://github.com/BARHUG0/bd-lab3) usando Docker paso a paso.

---

## 1. Clonar el repositorio

Abre una terminal y clona el repositorio:
```bash
git clone https://github.com/BARHUG0/bd-lab3.git
cd bd-lab3
```

## 2. Configurar variables de entorno de Docker

Al ingeresar a esta carpeta encontraras un archivo `.env.example`. Crea una copia de este con el nombre de `.env`. En este archivo podrás configurar el nombre de la base de datos, el usuario y la contraseña y el puerto de conexión.

## 3. Configurar la instancia de base de datos en PHP

Ingresa al directorio `backend/src/Database/` donde encontrarás un archivo llamado Database.example.php. Crea una copia con el nombre de Database.php sin editar el contenido.

## 4. Iniciar la aplicación dockerizada

Regresar al directorio principal del proyecto donde se encuentra el archivo `docker-compose.yml`. Abrir la termiar y correr el siguiente comando.
```bash
docker compose up --build
```

## 5. Verifica que todo funcione

- Asegúrate de que no hay errores en consola.
- Accede a `http://localhost:8002` si la aplicación corre en un servidor web.
- Usa `docker ps` para verificar que ambos contenedores estén activos.

---

## Endpoints

Los endpoints disponibles en la aplicación son:
- /countries
- /countries/{id}
- /users
- /users/{id}

---

¡Listo! Ahora tienes el entorno corriendo el laboratorio `bd-lab3`!
