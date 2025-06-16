<div align="center">
  <a href="https://github.com/combizera/changelog">
    <img src="./docs/banner.webp" alt="Laravel Changelog Package Banner" style="max-width: 100%; height: auto;" />
  </a>
  <h1>📋 Simple Changelog Generator for Laravel</h1>
</div>

![Packagist Version](https://img.shields.io/packagist/v/combizera/changelog)
![Downloads](https://img.shields.io/packagist/dt/combizera/changelog)
![License](https://img.shields.io/github/license/combizera/changelog)
![PHP Version](https://img.shields.io/packagist/php-v/combizera/changelog)

**Laravel Changelog** is a simple package to **manage and display changelogs** for your Laravel projects in an efficient way.

---

## 🚀 Installation

To install via **Composer**, run the following command:

```bash
composer require combizera/changelog
```

After installation, run the install command to set up the package:

```bash
php artisan changelog:install
```

---

## 📌 What Gets Created

🔹 **Database Table:**
- ✅ **`changelogs` table** with proper indexes
- ✅ **Migration file** with current timestamp

🔹 **Model:**
- ✅ **`app/Models/Changelog.php`** with useful scopes
- ✅ **Fillable attributes** and proper casting

🔹 **Available Fields:**
- `version` (string) - Version number (e.g., "v1.2.0")
- `release_date` (date) - When the version was released
- `type` (enum) - Type of change: `new`, `improvement`, `fix`, `security`, `deprecated`
- `title` (string) - Brief description of the change
- `description` (text, nullable) - Detailed description
- `is_published` (boolean) - Whether to show publicly

---

## 📚 How to Use

### 1️⃣ **Create Changelog Entries**

After installation, you can create changelog entries using the model:

```php
use App\Models\Changelog;

Changelog::create([
    'version' => 'v2.1.0',
    'release_date' => now(),
    'type' => 'new',
    'title' => 'Added dark mode support',
    'description' => 'Users can now toggle between light and dark themes in the settings.',
    'is_published' => true
]);
```

### 2️⃣ **Query Changelog Entries**

The model includes useful scopes for filtering:

```php
// Get only published entries
$changelogs = Changelog::published()->get();

// Filter by type
$fixes = Changelog::published()->byType('fix')->get();

// Get latest entries
$latest = Changelog::published()
    ->orderBy('release_date', 'desc')
    ->take(5)
    ->get();
```

### 3️⃣ **Available Types**

The package supports these changelog types:
- `new` - New features
- `improvement` - Enhancements to existing features
- `fix` - Bug fixes
- `security` - Security-related changes
- `deprecated` - Features being phased out

---

## 📊 Database Schema

The migration creates a table with the following structure:

```sql
id               - Primary key
version          - Version string (indexed)
release_date     - Date of release (indexed)
type             - Enum: new|improvement|fix|security|deprecated (indexed)
title            - Short description
description      - Long description (nullable)
is_published     - Boolean flag (indexed with release_date)
created_at       - Timestamp
updated_at       - Timestamp
```

---

## 🔧 Model Scopes

The `Changelog` model includes these helpful scopes:

```php
// Only published entries
Changelog::published()

// Filter by specific type
Changelog::byType('fix')

// Combine scopes
Changelog::published()
    ->byType('new')
    ->orderBy('release_date', 'desc')
    ->get()
```

---

## 🤝 Contributing

Want to help **improve** this package?

1. **Fork** the repository
2. Create a **feature branch**:
   ```bash
   git checkout -b feat/#issue-number-feature-name
   # Example: git checkout -b feat/#42-add-web-interface
   ```
3. Make your changes and **commit**:
   ```bash
   git commit -m "feat(Model): Add version scope"
   ```
4. Submit a **pull request** and wait for review!

Feel free to **open issues** for questions or suggestions! 🚀

---

## 🛣️ Roadmap

- [ ] Web interface for viewing changelogs
- [ ] RSS feed generation
- [ ] Markdown export functionality
- [ ] Git integration for automatic changelog generation
- [ ] API endpoints for changelog data

---

## 📝 License

This project is licensed under the **MIT License**. Feel free to use and modify it as needed.

Long live **Open Source**! 🎉

---
