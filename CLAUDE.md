# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

A World of Warcraft guild website for the guild "Jagdgesellschaft". Planned features include a guild member overview with ratings and professions, character pets/mounts/achievements, video clips, and integration with the Blizzard Battle.net API. Currently in early scaffolding stage.

## Stack

- **PHP 8.3** / **Symfony 7.2**
- **Twig** for templates
- **Docker** (nginx + PHP-FPM with Xdebug) — all composer scripts run inside the container
- No database yet; Blizzard API integration is planned but not started

## Running the app

```bash
docker compose up --build -d
```

App is accessible at `http://jagdgesellschaft.local:6108/index.php`

## Commands

All commands run inside the Docker container via composer scripts:

```bash
composer check          # cs-check + analyze + test (full CI pass)
composer cs-check       # Dry-run PHP-CS-Fixer (check only)
composer cs-fix         # Apply PHP-CS-Fixer fixes
composer analyze        # PHPStan at max level
composer test           # Run PHPUnit
composer test-dox       # Run PHPUnit with testdox output
composer test-filter -- "FilterString"  # Run a single test by name/class
composer test-coverage  # Generate HTML coverage report
```

## Code style & static analysis

- **PHP-CS-Fixer** with `@PhpCsFixer` ruleset (`.php-cs-fixer.php`)
- **PHPStan** at max level with strict rules (`phpstan.neon`); `var/cache` is excluded
- `declare(strict_types=1)` is required in all PHP files
- PSR-12 base with strict types, alphabetically ordered imports (class → function → const), aligned `=>`/`=` operators, and trailing commas in multiline expressions. Enforced by `php-cs-fixer` (config in `.php-cs-fixer.php`).
- All function parameters, return types, and class properties must have type declarations.

  Namespace conventions:
- All classes must be in a namespace matching the directory structure
- Follow PSR-4: `App\Http\Controllers\UserController` maps to `src/Http/Controllers/UserController.php`
- No procedural files at the root level except `index.php` (the bootstrap)
- One class per file, always
- Use Composer autoloading — no manual `require_once` chains

Security rules (non-negotiable):
- All output in templates must be escaped: `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')` or the framework equivalent
- CSRF tokens required on all state-mutating forms (POST, PUT, DELETE, PATCH)
- No `eval()`, no `shell_exec()`, no `system()` unless explicitly required (and reviewed)
- Passwords: `password_hash($pass, PASSWORD_ARGON2ID)` + `password_verify()`  — never MD5/SHA1
- Sessions: `session_regenerate_id(true)` after login
- File uploads: validate MIME type server-side, never trust the client-provided Content-Type


## Testing conventions

- PHPUnit 12 with strict coverage enforcement (`requireCoverageMetadata="true"`)
- Every test class must carry a `#[CoversClass(...)]` attribute
- Test methods use `#[Test]` attribute (not `test` prefix)
- Tests are split by namespace:
  - `tests/functional/` — `JagdGesellschaft\Tests\Functional` (uses `WebTestCase`)
  - `tests/unit/` — `JagdGesellschaft\Tests\Unit`
  - `tests/shared/` — `JagdGesellschaft\Tests\Shared`
  - `tests/assets/` — `JagdGesellschaft\Tests\Assets`
- `failOnWarning`, `failOnRisky`, `failOnPhpunitDeprecation` are all enabled

## Architecture

Routes are defined via `#[Route]` attributes on controllers in `src/Controller/`. The router auto-imports that directory (`config/routes.yaml`). Services in `src/` are autowired and autoconfigured via `config/services.yaml`.

Templates live in `templates/` and extend `base.html.twig`. The base template defines `title`, `styles`, `head`, and `body` blocks, loads `public/css/base.css`, and uses the guild logo from `public/images/`.

The app namespace is `JagdGesellschaft\` mapped to `src/`.

Use specific css files instead of inline styles whenever possible.
Use specific js files instead of inline scripts whenever possible.
