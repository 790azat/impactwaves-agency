# Impact Waves Agency

Marketing website for [Impact Waves Agency](https://impactwaves.agency): paid social, PPC, CRO, official TikTok agency accounts and Tier-1 search feed partnerships.

Built with **Laravel 13**, **Livewire 4**, **Alpine.js** (bundled with Livewire) and **Tailwind CSS 4**.

## Features

- Pages: home, services, a page per service, expertise, contact, 404, `sitemap.xml`
- Livewire **ROI calculator** (ad spend, CPC, conversion rate, AOV, CRO uplift)
- Livewire **contact form** with live validation, honeypot and rate limiting; leads go to email and, optionally, Telegram
- SPA-style page transitions with `wire:navigate`
- New logo (`public/logo.svg`, `public/favicon.svg`, `resources/views/components/logo*.blade.php`)
- SEO: meta tags, Open Graph image, JSON-LD organization, sitemap, robots.txt

All copy (services, FAQ, process, partners, budgets) lives in `config/agency.php`.

## Local development

```bash
composer install
npm install
cp .env.example .env && php artisan key:generate
composer run dev   # or: php artisan serve + npm run dev
```

## Deploying to Vercel

The repo is ready for Vercel via the community [`vercel-php`](https://github.com/vercel-community/php) runtime (`vercel.json`, `api/index.php`).

1. Vercel → **Add New… → Project** → import this GitHub repository. Leave framework preset as **Other**.
2. **Settings → Environment Variables**, add:
   - `APP_KEY` – generate with `php artisan key:generate --show` (required)
   - `APP_URL` – your production URL, e.g. `https://impactwaves.agency`
   - `AGENCY_EMAIL` – where leads are sent (default `hello@impactwaves.agency`)
   - Optional email delivery: `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`
   - Optional Telegram alerts: `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID`
3. Deploy. Every push to `main` redeploys automatically.

Without SMTP configured, leads are written to the Vercel function logs.

Compiled assets in `public/build` are committed so the PHP function can always read the Vite manifest; run `npm run build` before committing front-end changes.
