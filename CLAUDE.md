# Impact Waves Agency site

- Laravel 13 + Livewire 4 (class-based components in `app/Livewire`, views in `resources/views/livewire`) + Tailwind 4.
- Site copy lives in `config/agency.php`; pages in `resources/views/pages`, layout in `resources/views/components/layouts/app.blade.php`.
- Deployed on Vercel with `vercel-php` (`vercel.json`, `api/index.php`). Postgres (Neon, connected in Vercel Storage) holds users, leads and admin-edited articles; `api/index.php` picks it up from `DATABASE_URL*` and migrations run on the first request of each instance (`AppServiceProvider`). Without it the public site still works (sqlite in-memory, array cache). Sessions are cookies, logs go to stderr.
- Auth: `/register`, `/login`, `/account`; admin panel at `/admin` (leads, users, articles, services, vacancies, company) for users with `is_admin`. The first admin is created from `ADMIN_EMAIL` / `ADMIN_PASSWORD`.
- Site chat (`App\Livewire\ChatWidget`) forwards messages to Telegram (`App\Support\Telegram`, token in `TELEGRAM_BOT_TOKEN`); replies arrive via `/telegram/webhook`. The receiving chat is bound from Admin → Chats (stored in the `settings` table). The widget only shows once the bot is connected.
- `public/build` is committed: run `npm run build` after changing CSS/JS/Blade classes.
- Articles are Markdown files in `resources/content/{guides,traffic-providers,news}/{slug}.md` with simple `key: value` front matter (title, description, keywords, date, tag). Sections are configured under `sections` in `config/agency.php`; new files show up automatically in hub pages, sitemap.xml and feed.xml. Articles saved in the admin panel live in the `articles` table and override a file with the same section and slug (`App\Support\Articles`).
