# ShelfLife · API (Laravel)

API de ShelfLife. Los modelos siguen `draft.yaml` (Category, Product, Item, Loan; User ya existía) y las
respuestas tienen la misma forma que las interfaces de `shelflife-web` (`Product`, `User`, `Item`).

## Puesta en marcha

```bash
composer install
cp .env.example .env && php artisan key:generate   # y configurar DB_* en .env
php artisan migrate:fresh --seed                    # tablas + datos de ejemplo
php artisan serve
```

Los modelos y migraciones están ya escritos (equivalen a lo que genera Blueprint con el `draft.yaml`),
así que **no hace falta ejecutar `blueprint:build`**.
Usuarios de ejemplo (contraseña `password`): `lucia@shelflife.app` (admin), `nuria.gomez@gmail.com`, `alex.romero@icloud.com`.

## Endpoints

Todos van con `Authorization: Bearer <token>` (se obtiene en `POST /login`). Las listas y los elementos vienen dentro de `data`.

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/categories` | Categorías (Videojuegos, Libros, Cómics) |
| GET · POST | `/products` | Listar · añadir al catálogo |
| GET · PUT · DELETE | `/products/{id}` | Ver · editar · eliminar (409 si algún usuario lo tiene) |
| GET · POST | `/users` | Listar · añadir usuario |
| GET · PUT · DELETE | `/users/{id}` | Ver · editar · eliminar (no puedes borrarte a ti mismo) |
| GET · POST | `/items` | Listar · añadir ítem |
| GET · PUT · DELETE | `/items/{id}` | Ver · editar · eliminar |

## Qué envía la web

| Entidad | Cuerpo (JSON) | Respuesta |
|---|---|---|
| Product | `barcode`, `title`, `platform`, `category` (nombre de la categoría) | `id`, `barcode`, `title`, `platform`, `category` (+ campos extra del draft) |
| User | `name`, `email`, `role` (`admin`/`user`/`guest`), `password` (obligatoria al crear) | `id`, `name`, `email`, `role`, `blocked` |
| Item | `product` (título), `user` (nombre), `state` (`new`/`used`), `price` | `id`, `product`, `user`, `state`, `price` (+ ids y campos extra) |

En los ítems, el producto y el usuario se indican por título y nombre (deben existir); más adelante se puede
cambiar por `product_id` y `user_id` con listas desplegables.

## Postman

`ProyectoInterdisciplinar.postman_collection.json` incluye las peticiones de Products, Users, Items y Categories
(usa `{{API_BASE_URL}}` y `{{TOKEN}}`).

## Pendiente (sencillo por ahora)

- No hay comprobación de que quien llama sea administrador.
- Un usuario bloqueado (`blocked`) todavía puede iniciar sesión.
- Los préstamos (`Loan`) tienen modelo y tabla, pero aún no tienen endpoints.
