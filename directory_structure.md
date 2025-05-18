# Project Directory Structure

```
mmorpg-db/
│
├── index.php                     # Main entry point
├── config/
│   ├── config.php                # Configuration settings
│   └── database.php              # Database connection
│
├── assets/
│   ├── css/
│   │   ├── style.css             # Main stylesheet
│   │   ├── admin.css             # Admin stylesheet
│   │   └── responsive.css        # Responsive styles
│   ├── js/
│   │   ├── main.js               # Main JavaScript
│   │   └── admin.js              # Admin JavaScript
│   └── images/
│       ├── logo.png              # Site logo
│       ├── hero-bg.jpg           # Hero background
│       └── icons/                # Various icons
│
├── public/
│   ├── weapons/
│   │   ├── index.php             # Weapons list view
│   │   └── detail.php            # Weapon detail view
│   ├── armor/
│   │   ├── index.php             # Armor list view
│   │   └── detail.php            # Armor detail view
│   ├── items/
│   │   ├── index.php             # Items list view
│   │   └── detail.php            # Item detail view
│   ├── maps/
│   │   ├── index.php             # Maps list view
│   │   └── detail.php            # Map detail view
│   ├── monsters/
│   │   ├── index.php             # Monsters list view
│   │   └── detail.php            # Monster detail view
│   └── dolls/
│       ├── index.php             # Dolls list view
│       └── detail.php            # Doll detail view
│
├── admin/
│   ├── index.php                 # Admin dashboard
│   ├── login.php                 # Admin login
│   ├── logout.php                # Admin logout
│   ├── weapons/
│   │   ├── index.php             # Weapons management
│   │   ├── create.php            # Create weapon
│   │   ├── edit.php              # Edit weapon
│   │   └── delete.php            # Delete weapon
│   ├── armor/                    # Similar CRUD pages
│   ├── items/                    # Similar CRUD pages
│   ├── maps/                     # Similar CRUD pages
│   ├── monsters/                 # Similar CRUD pages
│   ├── dolls/                    # Similar CRUD pages
│   └── activity/
│       └── index.php             # Admin activity logs
│
├── includes/
│   ├── header.php                # Site header
│   ├── footer.php                # Site footer
│   ├── hero.php                  # Hero section
│   ├── admin-header.php          # Admin header
│   ├── admin-footer.php          # Admin footer
│   ├── pagination.php            # Pagination component
│   └── search.php                # Search component
│
└── classes/
    ├── Database.php              # Database class
    ├── User.php                  # User class for authentication
    ├── Activity.php              # Admin activity logging
    ├── Weapon.php                # Weapon model
    ├── Armor.php                 # Armor model
    ├── Item.php                  # Item model
    ├── Map.php                   # Map model
    ├── Monster.php               # Monster model
    └── Doll.php                  # Doll model
```
