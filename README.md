# BlackNova Traders

BlackNova Traders is a web-based, turn-based massively multiplayer space exploration, trading, and combat game inspired by classic BBS strategy games such as TradeWars. Players navigate sectors, trade commodities across orbital ports, colonize planets, establish corporate alliances, build defensive networks, and battle rivals for galactic supremacy.

---

## Technical Stack

- **Backend Runtime:** PHP 8.2+ (PHP-FPM)
- **Database Engine:** MariaDB 10.11 / MySQL 8.0 (InnoDB, `utf8mb4_unicode_ci`)
- **Data Access:** Doctrine DBAL 3.5+
- **Template Engine:** Twig 3.4+
- **Caching Layer:** Memcached 1.6+ / Symfony Cache
- **Event Management:** PSR-14 Event Dispatcher
- **Dependency Management:** Composer 2.x
- **Web Server:** Nginx (Reverse Proxy & FastCGI)
- **Containerization:** Docker & Docker Compose

---

## Architectural Design

BlackNova Traders is undergoing active modernization from procedural legacy scripts into a decoupled, object-oriented domain architecture (`BNT\` namespace) following Domain Unit Architecture principles:

- **Entities (`BNT\*\Entity\`):** Strongly typed representations of domain state (`Ship`, `Planet`, `Sector`, `Zone`, `Bounty`).
- **Data Access Objects (`BNT\*\DAO\`):** Encapsulated database operations using parameterized Doctrine DBAL queries.
- **Data Transfer Objects (`BNT\*\DTO\`):** Structured immutable payloads for business computations and data exchange.
- **Mappers (`BNT\*\Mapper\`):** Transformations between relational database records and domain entities.
- **Servants (`BNT\*\Servant\`):** Single-responsibility transactional command handlers (`ShipMoveServant`, `SectorPortResourcePurchaseServant`).
- **Mediators (`BNT\*\Mediator\`):** Orchestrators for complex, cross-domain calculations.
- **Views (`BNT\*\View\`):** Presenter layers formatting domain models for Twig template rendering.
- **Service Container (`BNT\Container`):** PSR-11 compliant dependency injection container.
- **Event Dispatcher (`BNT\EventDispatcher`):** PSR-14 compliant event pipeline for decoupled side-effects.

---

## Prerequisites

- Docker 24.0+ and Docker Compose v2 (recommended for all operating systems)
- Or native environment: PHP 8.2+, Composer 2.7+, MariaDB 10.11+, Nginx

---

## Quick Start Guide

### 1. Initialize and Start Containers

Copy the configuration template and launch the container cluster:

```bash
make up
```

This command automatically generates `.env` from `.env.dist` if not present, builds the PHP 8.2 image, and starts all background services.

### 2. Initialize Database and Universe

Create database tables and seed the initial universe:

```bash
make universe-create
```

### 3. Service Endpoints

Once the stack is running, access the services locally:

| Service | URL | Default Credentials | Description |
| :--- | :--- | :--- | :--- |
| **Web UI** | `http://localhost:8080` | Registered Player / Admin | Game Interface |
| **Adminer** | `http://localhost:8081` | Server: `db`, User: `root`, Pass: `root` | Database Management GUI |
| **Mailpit** | `http://localhost:8025` | None | Local SMTP Email Inbox |

---

## Development Commands (Makefile)

The included `Makefile` provides standardized workflows:

```bash
make help               # Display all available make targets
make up                 # Build and start all services in background
make down               # Stop and remove containers and networks
make down-v             # Stop containers and wipe persistent volumes (resets DB)
make restart            # Restart all containers
make ps                 # List container status and exposed ports
make logs               # Follow aggregate logs from all containers
make logs-php           # Follow PHP-FPM application logs
make logs-scheduler     # Follow game tick daemon logs
make php                # Open interactive bash session inside PHP container
make mysql              # Open interactive MariaDB client
make composer-install   # Execute composer install inside PHP container
make composer-update    # Update dependencies via Composer
make lint               # Run PHP syntax check (php -l) across all codebase files
make universe-create    # Run create_universe.php to seed world state
make db-dump            # Create a timestamped SQL dump in project root
```

---

## Configuration Reference

Application settings are managed through environment variables defined in `.env`:

```ini
# Port Bindings
WEB_PORT=8080
ADMINER_PORT=8081
DB_PORT=3306
MEMCACHED_PORT=11211
MAILPIT_HTTP_PORT=8025
MAILPIT_SMTP_PORT=1025

# Database Configuration
BNT_DATABASE_TYPE=mysqli
BNT_DATABASE_HOST=db
BNT_DATABASE_NAME=bnt
BNT_DATABASE_PORT=3306
BNT_DATABASE_USERNAME=root
BNT_DATABASE_PASSWORD=root
BNT_DATABASE_PREFIX=bnt_
BNT_DATABASE_CHARSET=utf8mb4

# Administrative Account
BNT_ADMIN_NAME=Admin
BNT_ADMIN_EMAIL=admin@example.com
BNT_ADMIN_PASSWORD=secret

# Game Engine
SCHEDULER_INTERVAL_SEC=60
```

---

## Game Scheduler and Universe Ticks

BlackNova Traders relies on continuous, interval-based ticks to simulate dynamic universe events:

- Commodity price regeneration and stock updates across star ports.
- Sector defense degradation and mine field decay.
- Planetary population growth, resource extraction, and colony production.
- Autonomous alien faction behaviors (Furangee, Xenobe).
- Bank interest calculations and debt handling (IGB).
- Player turn allocation and planetary defense maintenance.

In the Docker stack, the `bnt_scheduler` container runs `docker/scheduler/scheduler-loop.sh` as an autonomous worker, executing `scheduler.php` at intervals defined by `SCHEDULER_INTERVAL_SEC`.

---

## Modernization Roadmap

The system follows Semantic Versioning (SemVer 2.0) across defined developmental phases:

```text
Phase 0: Legacy Stabilization & UI Overhaul (Completed)
  ├── v0.9.0 : Production-ready Docker stack & developer orchestration (PHP 8.2, MariaDB, Nginx, Mailpit)
  ├── v0.9.1 : PHP 8.2 runtime compatibility, short tag elimination (57 files), DAO inheritance fixes
  └── v0.9.2 : Modern password hashing (bcrypt/argon2id with legacy fallback), session hardening, 
               responsive dark sci-fi UI overhaul (Twig + Glassmorphism HUD)

Phase 1: Modern Monolithic Baseline (LTS)
  ├── v1.0.0 : PHPUnit 10 test suite, PHPStan Level 8 static analysis, domain unit refactoring
  └── v1.0.1 : Single HTTP Front-Controller (public/index.php), PSR-15 middleware, Twig unification

Phase 2: Autonomous Engine & Real-Time Systems
  ├── v1.1.0 : Event-driven message queue workers (Redis / Symfony Messenger)
  ├── v1.1.1 : Real-time push notifications and live sector radar via SSE / Mercure
  └── v1.1.2 : Procedural universe generator 2.0 with custom spatial topologies

Phase 3: Headless REST / JSON API
  ├── v1.2.0 : OpenAPI 3.0 / JSON:API endpoints for all game mechanics & trading bot tokens
  ├── v1.2.1 : Automated Swagger UI documentation and SDK generators (TypeScript, Python)
  └── v1.2.2 : Decoupled administrative dashboard for Game Masters

Phase 4: Next-Gen Cloud-Native MMO
  ├── v2.0.0 : Reactive Single Page Application (Next.js / Vue 3) + WebGL Canvas Star Map
  ├── v2.1.0 : In-memory spatial graph engine (Redis) & distributed universe sharding
  └── v2.2.0 : Dynamic player economy, stock exchanges, and emergent AI faction diplomacy
```

---

## Coding Standards and Quality Assurance

- **PHP Standards:** Follow PSR-1 (Basic Coding Standard), PSR-4 (Autoloading), PSR-11 (Container Interface), and PSR-12 (Extended Coding Style).
- **Strict Typing:** All new and refactored PHP files must include `declare(strict_types=1);`.
- **Database Access:** Direct SQL string interpolation is prohibited. All queries must utilize Doctrine DBAL prepared statements.
- **Linting:** Validate codebase syntax prior to committing changes:
  ```bash
  make lint
  ```

---

## License and Credits

- **License:** GNU General Public License v2 (GPL-2.0). See [docs/LICENSE](file:///home/rikbon/prj/blacknovatraders/docs/LICENSE) for terms.
- **Original Authors:** Ron Harwood, L. Patrick Smallwood, and the BlackNova Traders Open Source Community.
- **Historical Reference:** Based on the classic TradeWars BBS mechanics.
