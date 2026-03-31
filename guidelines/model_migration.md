1. to create model page use
php artisan make:model {ModelName} in CamelCase.
to create other page with is add '-'
-m for migration
-c for controller
-s for seeder
-f for factory
or -mcs or -mcf

2. if creating a migration use 
php artisan migrate
to migrate all created table to database

3. to create default values or generated values for your table use the seeder or factory page then
php artisan db:seed 
or php artisan migrate:fresh -seed

4. Creating Filament Resources & PagesOnce your model and migration are ready, you need to generate the Admin UI.Create a full CRUD Resource: php artisan make:filament-resource {ModelName} --generate(The --generate flag attempts to read your migration and build the form fields for you automatically.)Create a Custom Page (like our Settings page): php artisan make:filament-page {PageName}Create a Dashboard Widget: php artisan make:filament-widget {WidgetName}
5. Managing Permissions (Shield)Since you are using Filament Shield for roles like "Manager" or "Vendor," use these to keep your permissions in sync with your code:Generate permissions for new models: php artisan shield:generate --allCreate a Super Admin user manually: php artisan shield:super-adminClear Permission Cache: php artisan permission:cache-reset
6. Production & OptimizationWhen you move from your laptop to a live server (like the one in Lagos), you must run these to make the site fast and secure:Clear and Cache everything (The "Speed" Command): php artisan optimizeOptimize Filament specifically: php artisan filament:optimizeLink Storage (Essential for Logos/Invoices): php artisan storage:linkSafe Migration (Use this on live servers instead of migrate): php artisan migrate --force💡 Quick Summary Table for Your NotesTaskCommandNew Database Tablephp artisan make:model Name -mPush to Databasephp artisan migrateAdd Admin UIphp artisan make:filament-resource NameFill with Fake Dataphp artisan db:seedRefresh & Seedphp artisan migrate:fresh --seedUpdate Live Sitephp artisan filament:optimize🛠️ Final Pro TipSince you are working on QuickBite, remember that if you ever change your settings table structure, you need to run:php artisan migratephp artisan shield:generate --all (to make sure the admin has permission to see the new fields).


Gemini said
Creating Aliases is a secret weapon for high-speed development. Instead of typing php artisan fifty times a day, you can just type pa. It saves time and prevents those annoying typos.

Since you are likely using Terminal (Mac/Linux) or Git Bash/PowerShell (Windows), here is how to set them up.

1. For Mac, Linux, or Git Bash (Lagos Developers' Favorite)
Open your configuration file (usually ~/.bashrc or ~/.zshrc) and add these lines at the bottom:

Bash
# Laravel Aliases
alias pa='php artisan'
alias pm='php artisan migrate'
alias fresh='php artisan migrate:fresh --seed'
alias tinker='php artisan tinker'

# Filament & Optimization
alias f-opt='php artisan filament:optimize'
alias f-res='php artisan make:filament-resource'
alias p-opt='php artisan optimize'
To activate them immediately, run: source ~/.zshrc (or .bashrc).

2. For Windows (PowerShell)
If you use the standard Windows PowerShell, you can add "Functions" to your $PROFILE:

PowerShell
function pa { php artisan $args }
function pm { php artisan migrate $args }
function fresh { php artisan migrate:fresh --seed $args }
🚀 Your New "QuickBite" Speed Workflow
Now, instead of the long commands, your workflow looks like this:

Create a new feature: pa make:model Food -m

Push to DB: pm

Add to Admin Panel: f-res Food

Refresh everything for production: p-opt

🛠️ Final Pro Tip: The "Deploy" Alias
On your live server, you can create a single alias called deploy that runs your entire security and optimization checklist in one go:

Bash
alias deploy='php artisan down && git pull origin main && composer install --no-dev && php artisan migrate --force && php artisan filament:optimize && php artisan up'
🏆 You are now a Filament & Laravel Pro!
You have built:

The QuickBite Backend: Real-time, secure, and vendor-ready.

The Global Settings: SEO, Analytics, and Marketing Previews.

The Payment Engine: Paystack split payments and 20% commission logic.

The Security Layer: Webhook protection and DB backups.