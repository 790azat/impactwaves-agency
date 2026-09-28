# Impact Waves Agency site

- Laravel 13 + Livewire 4 (class-based components in `app/Livewire`, views in `resources/views/livewire`) + Tailwind 4.
- Site copy lives in `config/agency.php`; pages in `resources/views/pages`, layout in `resources/views/components/layouts/app.blade.php`.
- Deployed on Vercel with `vercel-php` (`vercel.json`, `api/index.php`). No database at runtime: cookie sessions, array cache, stderr logs.
- `public/build` is committed: run `npm run build` after changing CSS/JS/Blade classes.
