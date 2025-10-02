# Laravel News Aggregator Backend

A Laravel backend for aggregating news from multiple sources (Guardian, NewsAPI, NYTimes), storing them locally, and exposing API endpoints.

---

## Requirements

- PHP 8.2+
- Composer
- SQLite

---

## Installation

1. Clone the repository:

```bash
git clone <repo_url>
cd news-aggregator
```

2. Install dependencies:

```bash
composer install
```

3. Copy `.env` and set API keys:

```bash
cp .env.example .env
```

Set your API keys in `.env`:

```
GUARDIAN_KEY=your_guardian_key
NEWSAPI_KEY=your_newsapi_key
NYTIMES_KEY=your_nytimes_key
```

4. Generate application key:

```bash
php artisan key:generate
```

5. Run migrations:

```bash
php artisan migrate
```

---

## Fetching Articles

### Manual fetch
```bash
php artisan news:fetch
```

You can optionally pass a search query:
```bash
php artisan news:fetch technology
```

### Scheduled fetch
The fetch command is scheduled hourly via `bootstrap/app.php`.  
To run manually:
```bash
php artisan queue:work
php artisan schedule:work
```

---

## API Endpoints

Prefix: `/api/v1`

| Method | Endpoint            | Description                                            |
|--------|---------------------|--------------------------------------------------------|
| GET    | /categories         | List article categories                                |
| GET    | /articles           | List articles with filters                             |
| GET    | /articles/preferred | List articles with user preferred filters              |
| GET    | /preferences        | Show user preferences (sources, categories, authors)   |
| PUT    | /preferences        | Update user preferences (sources, categories, authors) |

### Filters

- `q` – search keyword (title or summary)
- `source` – filter by source key (`guardian`, `newsapi`, `nytimes`)
- `category` – filter by category slug
- `from` – published from date (`YYYY-MM-DD`)
- `to` – published to date (`YYYY-MM-DD`)
- `author` - filter by author
- `page` – pagination page number
- `perPage` - articles per page

Example:
```
GET /api/v1/articles?q=technology&source=newsapi&author=jane&category=technology&from=2025-01-01
```

---

## Testing

Uses [Pest PHP](https://pestphp.com/) for feature tests.

Run tests:

```bash
composer test
```

Pest tests cover:

- APIs
- Commands
- Exceptions
- Jobs
- Repositories
- Resources
- Services
