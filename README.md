# Integral Instrument — Sitio Web y Sistema Softlab

## Descripción

Este repositorio contiene dos sistemas:

1. **Sitio web público** (`/`): Página institucional del laboratorio de calibración e instrumentos.
2. **Softlab** (`/softlab/`): Aplicación interna de gestión del laboratorio (clientes, equipos, calibraciones, cotizaciones).

## Requisitos

- PHP 5.6+
- MySQL / MariaDB
- Servidor web Apache (XAMPP recomendado para desarrollo local)

## Configuración

### Sitio web

Copiar `admin/conexion.example.php` a `admin/conexion.php` y completar los datos de conexión:

```php
$conexion = new mysqli("TU_HOST:3306", "TU_USUARIO", "TU_PASSWORD", "integral_integralinstrument");
```

- Base de datos: `integral_integralinstrument`

### Softlab

Copiar `softlab/class/appconfig.example.ini` a `softlab/class/appconfig.ini` y completar:

```ini
[mysql_base]
db_username = TU_USUARIO
db_password = TU_PASSWORD
db_host = TU_HOST:3306
database = integral_laboratorio
```

- Base de datos: `integral_laboratorio`

Copiar también `softlab/class/enviar.example.php` a `softlab/class/enviar.php` y completar las credenciales del servidor SMTP:

```php
$mail->Host     = "TU_SMTP_HOST";
$mail->Username = "TU_EMAIL_SMTP";
$mail->Password = "TU_PASSWORD_SMTP";
$mail->From     = "TU_EMAIL_FROM";
```

> Los archivos `conexion.php`, `appconfig.ini` y `enviar.php` están excluidos del repositorio vía `.gitignore` para proteger las credenciales.

## Acceso

- Panel admin del sitio: `http://[host]/integralinstrument/admin/`
- Sistema Softlab: `http://[host]/integralinstrument/softlab/`

## Estructura

```
integralinstrument/
├── admin/          # Panel de administración del sitio web (ABM de contenidos)
├── softlab/        # Sistema de gestión interno Softlab
│   └── class/      # Clases PHP y configuración (appconfig.ini)
├── inc/            # Includes del sitio público (header, footer, menú)
└── index.php       # Página de inicio del sitio público
```
