# API RESTful en CodeIgniter 4

Este proyecto es una API RESTful creada con CodeIgniter 4 para realizar operaciones CRUD (Crear, Leer, Actualizar y Eliminar). 

## Requisitos Previos

- PHP 7.4 o superior
  - Extensión [intl](http://php.net/manual/en/intl.requirements.php)
  - Extensión [mbstring](http://php.net/manual/en/mbstring.installation.php)
- Servidor MySQL 5.7 o superior
- Composer instalado
- Servidor Apache o Nginx

## Instalación

1. Clona este repositorio en tu servidor local:
    ```bash
    git clone https://github.com/mroblesdev/api-codeigniter4.git
    ```

2. Accede al directorio del proyecto:
    ```bash
    cd api-codeigniter4
    ```

3. Instala las dependencias del proyecto usando Composer:
    ```bash
    composer install
    ```

4. Renombra el archivo `env` a `.env` y configura los datos de la base de datos:
    ```bash
    database.default.hostname = localhost
    database.default.database = nombre_base_datos
    database.default.username = tu_usuario
    database.default.password = tu_contraseña
    database.default.DBDriver = MySQLi
    ```

5. La tabla `products` tiene la siguiente estructura:

    ```sql
    CREATE TABLE `products` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `description` text,
      `price` decimal(10,2) NOT NULL,
      `stock` int NOT NULL
      PRIMARY KEY (`id`)
    );
    ```

6. Inicia el servidor de desarrollo de CodeIgniter:
    ```bash
    php spark serve
    ```

7. La API estará disponible en `http://localhost:8080/products`.

## Endpoints de la API

### 1. Obtener Todos los Productos
- **Método**: `GET`
- **URL**: `/products`
- **Descripción**: Devuelve una lista de todos los productos.

### 2. Obtener Producto por ID
- **Método**: `GET`
- **URL**: `/products/{id}`
- **Descripción**: Devuelve la información de un producto específico.

### 3. Crear un Nuevo Producto
- **Método**: `POST`
- **URL**: `/products`
- **Descripción**: Crea un nuevo producto en la base de datos.
- **Parámetros (Body)**:
    ```json
    {
      "name": "Nuevo Producto",
      "description": "Descripción del nuevo producto",
      "price": 150.00,
      "stock": 10
    }
    ```

### 4. Actualizar un Producto
- **Método**: `PUT`
- **URL**: `/products/{id}`
- **Descripción**: Actualiza la información de un producto existente.
- **Parámetros (Body)**:
    ```json
    {
      "name": "Producto Actualizado",
      "description": "Descripción actualizada",
      "price": 180.00,
      "stock": 5
    }
    ```

### 5. Eliminar un Producto
- **Método**: `DELETE`
- **URL**: `/products/{id}`
- **Descripción**: Elimina un producto de la base de datos.


## Contribuciones

Siéntete libre de contribuir al proyecto.

## Expresiones de Gratitud 🎁

- Comenta a otros sobre este proyecto 📢
- Invitame una cerveza 🍺 o un café ☕ [Da clic aquí](https://www.paypal.com/paypalme/markorobles?locale.x=es_XC.).

## Licencia

Este proyecto está licenciado bajo la Licencia MIT - consulta el archivo [LICENSE](LICENSE) para más detalles.
