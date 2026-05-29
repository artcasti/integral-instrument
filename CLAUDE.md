# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Environment

- **Server:** XAMPP on Windows — Apache + PHP 5.6 (handler set in `.htaccess` as `EA-PHP56`)
- **Database:** MySQL/MariaDB on `localhost:3306`, user `omg_admin`
- **No build tools** — assets are served directly; there is no npm, webpack, composer at root level
- Credentials for DB and SMTP are stored in `admin/conexion.php` and `softlab/class/appconfig.ini`

## Three Subsystems

This repo contains three separate applications sharing the same server root:

### 1. Public Website (`/`)
Marketing site for Integral Instrument (instrument calibration/repair). Entry point: `index.php`. Layout via PHP includes in `inc/` (header, footer, menu, slider). Database: `web_integralinstruments`.

### 2. Admin CMS (`/admin/`)
Content management for the public website. Login: `admin/login.php` → `admin/autenticausuario.php`. Session-gated. Manages articles, services, galleries, news, users, and a hierarchical menu with role-based access. Business logic in `admin/functions.php` (663 lines).

### 3. Softlab Business System (`/softlab/`)
Internal system for calibration tracking, client management, equipment inventory, and quotations. Login: `softlab/signin.php` → `softlab/autenticausuario.php`. Database: `laboratorio`. Config: `softlab/class/appconfig.ini`.

## Code Architecture

### Backend
- **Procedural PHP** for the public website and admin; ABM pages (create/edit/delete) follow the pattern `abm_[entity]_p1.php` (list) / `abm_[entity]_p2.php` (form) / `graba_[entity].php` (save)
- **OOP classes** in `softlab/class/clases.php`: `conectar` (DB), `LoginUsuario` (auth), `ConfigurationManager`, `MenuPadre`, `Manager_ABMs`, `Manager_Cotizaciones`
- **Raw `mysqli`** — no ORM, queries built with string concatenation
- **Session-based auth** — `$_SESSION` holds user ID, profile, and menu permissions
- **AJAX endpoints** in `softlab/ajax/` consumed by jQuery `.ajax()` calls on softlab pages

### Frontend
- Public site: custom CSS + jQuery 1.7.1, Flexslider, FractionSlider, Lightbox
- Admin: Bootstrap + jQuery UI + CKEditor (rich text), PHPSpreadsheet for Excel exports
- Softlab: Bootstrap + custom jQuery AJAX forms

### Database Access
- Admin connects via `admin/conexion.php` (inline credentials, raw `mysqli_connect`)
- Softlab reads `softlab/class/appconfig.ini` into a `conectar` class; all queries go through `$this->con`

## Naming Conventions

- Variables, functions, and SQL identifiers are in **Spanish** (`conexion`, `consulta`, `peticion`, `listar_*`, `graba_*`, `carga_*`)
- Files: `snake_case` with descriptive prefix matching the entity (`abm_articulos_p1.php`, `detalle_servicios.php`)
- Classes: PascalCase; methods: camelCase in `clases.php`

## Running / Testing

There is no test suite, lint config, or build step. To test changes:
1. Place/edit files in this directory under `c:\xampp\htdocs\integralinstrument\`
2. Access via `http://localhost/integralinstrument/` in a browser
3. Admin at `http://localhost/integralinstrument/admin/`
4. Softlab at `http://localhost/integralinstrument/softlab/`

Ensure XAMPP Apache and MySQL services are running before testing.
